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
        $debt = Debt::where('customer_id', $customer_id)
            ->where('status', '!=', 'paid')
            ->firstOrFail(); // atau get() kalau lebih dari 1

        return view('debt.form-debt', compact('debt'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'payment' => 'required|numeric|min:1',
        ]);

        $debt = \App\Models\Debt::findOrFail($id);

        $payment = $request->input('payment');

        if ($payment > $debt->remaining_debt) {
            return back()->withErrors(['payment' => 'Pembayaran melebihi sisa utang.']);
        }

        // Kurangi remaining_debt langsung
        $debt->remaining_debt -= $payment;

        // Update status
        if ($debt->remaining_debt <= 0) {
            $debt->remaining_debt = 0;
            $debt->status = 'paid';
        } elseif ($debt->remaining_debt < $debt->total_debt) {
            $debt->status = 'partial';
        } else {
            $debt->status = 'unpaid';
        }

        $debt->save();

        \App\Models\Debt_Payment::create([
            'debt_id' => $debt->id,
            'payment_amount' => $payment,
            'payment_date' => now(),
        ]);

        return redirect()->route('debts.index')->with('success', 'Payment berhasil disimpan.');
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
