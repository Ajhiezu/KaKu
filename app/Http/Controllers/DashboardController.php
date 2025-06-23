<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today'); // default 'today'

        $now = Carbon::now();

        switch ($filter) {
            case 'month':
                $start = $now->copy()->startOfMonth();
                $end = $now->copy()->endOfMonth();
                break;
            case 'year':
                $start = $now->copy()->startOfYear();
                $end = $now->copy()->endOfYear();
                break;
            default:
                $start = $now->copy()->startOfDay();
                $end = $now->copy()->endOfDay();
        }

        $transactions = Transaction::whereBetween('transaction_date', [$start, $end]);
        $sales = $transactions->count();
        $revenue = $transactions->sum('payment');

        // Perbandingan dengan periode sebelumnya
        switch ($filter) {
            case 'month':
                $prevStart = $start->copy()->subMonth()->startOfMonth();
                $prevEnd = $start->copy()->subMonth()->endOfMonth();
                break;
            case 'year':
                $prevStart = $start->copy()->subYear()->startOfYear();
                $prevEnd = $start->copy()->subYear()->endOfYear();
                break;
            default:
                $prevStart = $start->copy()->subDay()->startOfDay();
                $prevEnd = $start->copy()->subDay()->endOfDay();
        }

        $prevTransactions = Transaction::whereBetween('transaction_date', [$prevStart, $prevEnd]);
        $prevSales = $prevTransactions->count();
        $prevRevenue = $prevTransactions->sum('payment');

        $percentage = function ($current, $previous) {
            if ($previous == 0) return $current > 0 ? 100 : 0;
            return round((($current - $previous) / $previous) * 100, 2);
        };

        // Cek filter dan generate data chart
        $chartLabels = [];
        $chartSalesData = [];
        $chartRevenueData = [];

        if ($filter === 'year') {
            // Per bulan di tahun ini
            $data = Transaction::selectRaw('MONTH(transaction_date) as month, COUNT(*) as sales, SUM(payment) as revenue')
                ->whereYear('transaction_date', $now->year)
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            for ($i = 1; $i <= 12; $i++) {
                $monthName = Carbon::create()->month($i)->format('M');
                $item = $data->firstWhere('month', $i);
                $chartLabels[] = $monthName;
                $chartSalesData[] = $item->sales ?? 0;
                $chartRevenueData[] = $item->revenue ?? 0;
            }
        } elseif ($filter === 'month') {
            // Per hari di bulan ini
            $daysInMonth = $now->daysInMonth;
            $data = Transaction::selectRaw('DAY(transaction_date) as day, COUNT(*) as sales, SUM(payment) as revenue')
                ->whereMonth('transaction_date', $now->month)
                ->whereYear('transaction_date', $now->year)
                ->groupBy('day')
                ->orderBy('day')
                ->get();

            for ($i = 1; $i <= $daysInMonth; $i++) {
                $label = str_pad($i, 2, '0', STR_PAD_LEFT);
                $item = $data->firstWhere('day', $i);
                $chartLabels[] = $label;
                $chartSalesData[] = $item->sales ?? 0;
                $chartRevenueData[] = $item->revenue ?? 0;
            }
        } else {
            // Hari ini per jam
            $data = Transaction::selectRaw('HOUR(transaction_date) as hour, COUNT(*) as sales, SUM(payment) as revenue')
                ->whereDate('transaction_date', $now->toDateString())
                ->groupBy('hour')
                ->orderBy('hour')
                ->get();

            for ($i = 0; $i < 24; $i++) {
                $label = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                $item = $data->firstWhere('hour', $i);
                $chartLabels[] = $label;
                $chartSalesData[] = $item->sales ?? 0;
                $chartRevenueData[] = $item->revenue ?? 0;
            }
        }

        // Top Selling Products
        $topSelling = \App\Models\TransactionDetail::selectRaw('
        product_id,
        SUM(quantity) as total_sold,
        SUM(quantity * price) as total_revenue
    ')
            ->whereHas('transaction', function ($query) use ($start, $end) {
                $query->whereBetween('transaction_date', [$start, $end]);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // activity recent
        $recentActivities = \App\Models\TransactionDetail::with(['product', 'transaction'])
            ->whereHas('transaction', function ($q) use ($start, $end) {
                $q->whereBetween('transaction_date', [$start, $end]);
            })
            ->orderByDesc('created_at')
            ->take(10)
            ->get();



        return view('dashboard', [
            'sales' => $sales,
            'revenue' => $revenue,
            'sales_change' => $percentage($sales, $prevSales),
            'revenue_change' => $percentage($revenue, $prevRevenue),
            'chartLabels' => $chartLabels,
            'chartSalesData' => $chartSalesData,
            'chartRevenueData' => $chartRevenueData,
            'topSelling' => $topSelling,
            'recentActivities' => $recentActivities,
            'filter' => ucfirst($filter),
        ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
