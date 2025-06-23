<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Debt;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        return view("login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'name' => 'Username atau Password Salah.',
        ])->onlyInput('name');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function sales()
    {
        return view('transaction.sale');
    }

    public function transaction(Request $request)
    {
        $request->validate([
            'datetime'     => 'required|date',
            'total'        => 'required|numeric',
            'bayar'        => 'required|numeric|min:0',
            'kembalian'    => 'required|numeric',
            'products'     => 'required|json',
        ]);

        try {
            DB::beginTransaction();

            $total = floatval($request->total);
            $bayar = floatval($request->bayar);
            $kembalian = floatval($request->kembalian);

            // Log untuk debugging
            Log::info('Transaction started', [
                'total' => $total,
                'bayar' => $bayar,
                'products' => $request->products
            ]);

            // Validasi jika bayar kosong
            if ($bayar < 0) {
                return back()->withErrors(['bayar' => 'Pembayaran harus diisi terlebih dahulu!'])->withInput();
            }

            // Jika ingin menghutang tapi customer kosong
            if ($bayar < $total && empty($request->customer)) {
                return back()->withErrors(['customer' => 'Customer harus diisi jika ingin menghutang!'])->withInput();
            }

            // Proses customer (boleh kosong)
            $customerId = null;
            if (!empty($request->customer)) {
                $customer = Customer::firstOrCreate(['name' => $request->customer]);
                $customerId = $customer->id;
            }

            // Decode products dari JSON
            $products = json_decode($request->products, true);
            
            // LANGKAH 1: Validasi semua produk dan stok sebelum menyimpan transaksi
            $productDetails = [];
            foreach ($products as $item) {
                // Cari produk berdasarkan barcode ATAU nama jika barcode kosong
                $product = null;
                if (!empty($item['barcode'])) {
                    $product = Product::where('barcode', $item['barcode'])->first();
                } else {
                    // Jika barcode kosong, cari berdasarkan nama
                    $product = Product::where('name', $item['name'])->first();
                }

                if (!$product) {
                    throw new \Exception("Produk '{$item['name']}' tidak ditemukan dalam database.");
                }

                // Validasi stok
                $requestedQty = intval($item['quantity']);
                if ($product->stock < $requestedQty) {
                    throw new \Exception("Stok produk '{$product->name}' tidak mencukupi. Stok tersedia: {$product->stock}, diminta: {$requestedQty}");
                }

                // Simpan detail produk untuk diproses nanti
                $productDetails[] = [
                    'product' => $product,
                    'quantity' => $requestedQty,
                    'price' => floatval($item['price']),
                    'subtotal' => floatval($item['subtotal'])
                ];

                Log::info('Product validation passed', [
                    'product_name' => $product->name,
                    'current_stock' => $product->stock,
                    'requested_qty' => $requestedQty
                ]);
            }

            // LANGKAH 2: Simpan transaksi utama
            $transaction = Transaction::create([
                'transaction_date' => $request->datetime,
                'total_amount'     => $total,
                'payment'          => $bayar,
                'change'           => $kembalian,
                'customer_id'      => $customerId,
                'cashier_id'       => Auth::id(),
            ]);

            Log::info('Transaction created', ['transaction_id' => $transaction->id]);

            // LANGKAH 3: Proses setiap produk - simpan detail dan kurangi stok
            $lowStockProducts = [];
            foreach ($productDetails as $detail) {
                $product = $detail['product'];
                $quantity = $detail['quantity'];
                $price = $detail['price'];
                $subtotal = $detail['subtotal'];

                // Simpan detail transaksi
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'quantity'       => $quantity,
                    'price'          => $price,
                    'subtotal'       => $subtotal,
                ]);

                // KURANGI STOK - Ini bagian yang penting!
                $oldStock = $product->stock;
                $newStock = $oldStock - $quantity;
                
                // Update stok menggunakan query builder untuk memastikan berhasil
                $updated = DB::table('products')
                    ->where('id', $product->id)
                    ->update(['stock' => $newStock]);

                if (!$updated) {
                    throw new \Exception("Gagal mengupdate stok produk '{$product->name}'");
                }

                Log::info('Stock updated', [
                    'product_name' => $product->name,
                    'old_stock' => $oldStock,
                    'quantity_sold' => $quantity,
                    'new_stock' => $newStock
                ]);

                // Cek stok rendah
                if ($newStock <= 5) {
                    $lowStockProducts[] = "{$product->name} (sisa {$newStock})";
                }
            }

            // LANGKAH 4: Tampilkan warning jika ada produk dengan stok rendah
            if (!empty($lowStockProducts)) {
                session()->flash('warning_stock', 'Beberapa produk perlu restock: <br><ul><li>' . implode('</li><li>', $lowStockProducts) . '</li></ul>');
            }

            // LANGKAH 5: Simpan ke tabel hutang jika bayar < total
            if ($bayar < $total && $customerId) {
                Debt::create([
                    'customer_id' => $customerId,
                    'transaction_id' => $transaction->id,
                    'total_debt' => $total,
                    'amount_paid' => $bayar,
                    'remaining_debt' => $total - $bayar,
                    'status' => $bayar == 0 ? 'unpaid' : 'partial',
                    'due_date' => $request->datetime,
                ]);
            }

            DB::commit();
            Log::info('Transaction completed successfully');

            return redirect()->route('sales')->with('success', 'Transaksi berhasil disimpan dan stok produk telah dikurangi.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function report_sales()
    {
        // Ambil semua transaksi dengan relasi customer dan debt
        $sales = Transaction::with(['customer', 'debt'])->get();

        return view('report.sale-report', compact('sales'));
    }

    public function show_detail_sales($transaction_id)
    {
        $transaction = Transaction::with(['customer', 'debt', 'details.product'])->findOrFail($transaction_id);

        return view('report.sales-report-detail', compact('transaction'));
    }
}