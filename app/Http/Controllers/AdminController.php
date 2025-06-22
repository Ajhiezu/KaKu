<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        return view("login");
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($credentials, $request->filled('remember'))){
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'name' => 'Username atau Password Salah.',
        ])->onlyInput('name');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function sales(){
        
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

            // Jika customer tidak diisi, tetap null
            $customerId = null;
            if (!empty($request->customer)) {
                $customer = Customer::firstOrCreate([
                    'name' => $request->customer,
                ]);
                $customerId = $customer->id;
            }

            // Simpan transaksi utama
            $transaction = Transaction::create([
                'transaction_date' => $request->datetime,
                'total_amount'     => $request->total,
                'payment'          => $request->bayar,
                'change'           => $request->kembalian,
                'customer_id'      => $customerId,
                'cashier_id'       => Auth::id(),
            ]);

            // Simpan detail transaksi
            $products = json_decode($request->products, true);
            foreach ($products as $item) {
                // Temukan produk by name (atau bisa pakai barcode/id jika kamu simpan itu)
                $product = Product::where('name', $item['name'])->first();

                if (!$product) {
                    // Jika tidak ada, buat produk baru sementara
                    $product = Product::create([
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'category_id' => 1,
                        'stock' => 0,
                    ]);
                }

                // Simpan ke transaction_details
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'quantity'       => $item['qty'],
                    'price'          => $item['price'],
                    'subtotal'       => $item['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()->route('sale')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}
