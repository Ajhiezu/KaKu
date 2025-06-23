<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data utang yang belum lunas dan relasi customer
        $debts = \App\Models\Debt::with('customer')
            ->where('remaining_debt', '>', 0)
            ->get()
            ->groupBy('customer_id') // Grup berdasarkan customer
            ->map(function ($items, $customer_id) {
                $customer = $items->first()->customer;
                $totalDebt = $items->sum('total_debt');
                $totalPaid = $items->sum('amount_paid');
                $remaining = $items->sum('remaining_debt');

                // Tentukan status berdasarkan sisa utang
                $status = 'unpaid';
                if ($totalPaid > 0 && $remaining > 0) {
                    $status = 'partial';
                } elseif ($remaining <= 0) {
                    $status = 'paid';
                }

                return [
                    'customer_id' => $customer_id,
                    'name_customer' => $customer->name ?? 'Unknown',
                    'total_debt' => $totalDebt,
                    'amount_paid' => $totalPaid,
                    'remaining_debt' => $remaining,
                    'status' => $status,
                ];
            })->values(); // reset index array

        return view('debt.debt', compact('debts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($customer_id)
    {
        $debts = Debt::where('customer_id', $customer_id)
            ->where('status', '!=', 'paid')
            ->get();

        if ($debts->isEmpty()) {
            abort(404, 'Utang tidak ditemukan');
        }

        // Jumlahkan seluruh sisa utang
        $remaining_debt = $debts->sum('remaining_debt');
        $total_debt = $debts->sum('total_debt');
        $amount_paid = $debts->sum('amount_paid');
        $debt_id = $debts->first()->id;

        return view('debt.form-debt', [
            'debt' => (object)[
                'id' => $debt_id, // pakai id salah satu utangnya
                'remaining_debt' => $remaining_debt,
                'total_debt' => $total_debt,
                'amount_paid' => $amount_paid,
            ]
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'payment' => 'required|numeric|min:1',
    ]);

    $payment = floatval($request->input('payment'));

    // Ambil salah satu utang berdasarkan ID untuk dapatkan customer_id
    $firstDebt = Debt::findOrFail($id);
    $customerId = $firstDebt->customer_id;

    // Ambil semua utang customer yang belum lunas
    $debts = Debt::where('customer_id', $customerId)
        ->where('remaining_debt', '>', 0)
        ->orderBy('created_at') // lunasi dari utang tertua dulu
        ->get();

    if ($debts->isEmpty()) {
        return back()->withErrors(['payment' => 'Tidak ada utang yang bisa dilunasi.']);
    }

    $sisaPembayaran = $payment;

    foreach ($debts as $debt) {
        if ($sisaPembayaran <= 0) break;

        $bayarSekarang = min($debt->remaining_debt, $sisaPembayaran);

        $debt->amount_paid += $bayarSekarang;
        $debt->remaining_debt -= $bayarSekarang;

        // Tentukan status
        if ($debt->remaining_debt <= 0) {
            $debt->remaining_debt = 0;
            $debt->status = 'paid';
        } elseif ($debt->amount_paid > 0) {
            $debt->status = 'partial';
        }

        $debt->save();

        // Simpan ke debt_payment
        \App\Models\Debt_Payment::create([
            'debt_id' => $debt->id,
            'payment_amount' => $bayarSekarang,
            'payment_date' => now(),
        ]);

        $sisaPembayaran -= $bayarSekarang;
    }

    return redirect()->route('debts.index')->with('success', 'Payment berhasil dibagi ke semua utang.');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function history($customer_id)
    {
        $debts = Debt::where('customer_id', $customer_id)
            ->with('payments')
            ->get();

        $customerName = $debts->first()->customer->name ?? 'Unknown';

        return view('debt.debt-report', compact('debts', 'customerName'));
    }

    public function report()
    {
        // Ambil semua data utang + relasi customer
        $debts = \App\Models\Debt::with('customer')
            ->get()
            ->groupBy('customer_id')
            ->map(function ($items, $customer_id) {
                $customer = $items->first()->customer;
                $totalDebt = $items->sum('total_debt');
                $totalPaid = $items->sum('amount_paid');
                $remaining = $items->sum('remaining_debt');

                // Tentukan status
                $status = 'unpaid';
                if ($totalPaid > 0 && $remaining > 0) {
                    $status = 'partial';
                } elseif ($remaining <= 0) {
                    $status = 'paid';
                }

                return [
                    'customer_id' => $customer_id,
                    'name_customer' => $customer->name ?? 'Unknown',
                    'total_debt' => $totalDebt,
                    'amount_paid' => $totalPaid,
                    'remaining_debt' => $remaining,
                    'status' => $status,
                ];
            })
            ->values(); // reset index

        return view('report.debt-report', compact('debts'));
    }
}
