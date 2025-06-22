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
            'bayar'        => 'required|numeric',
            'kembalian'    => 'required|numeric',
            'products'     => 'required|json',
        ]);

        try {
            DB::beginTransaction();

            $total = floatval($request->total);
            $bayar = floatval($request->bayar);
            $kembalian = floatval($request->kembalian);

            // Validasi jika bayar kosong
            if ($bayar <= 0) {
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

            // Simpan transaksi utama
            $transaction = Transaction::create([
                'transaction_date' => $request->datetime,
                'total_amount'     => $total,
                'payment'          => $bayar,
                'change'           => $kembalian,
                'customer_id'      => $customerId,
                'cashier_id'       => Auth::id(),
            ]);

            // Simpan detail produk
            $products = json_decode($request->products, true);
            foreach ($products as $item) {
                $product = Product::firstOrCreate(['name' => $item['name']], [
                    'price' => $item['price'],
                    'category_id' => 1,
                    'stock' => 0
                ]);

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'quantity'       => $item['quantity'],
                    'price'          => $item['price'],
                    'subtotal'       => $item['subtotal'],
                ]);
            }

            // Simpan ke tabel hutang jika bayar < total
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

            return redirect()->route('sales')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
