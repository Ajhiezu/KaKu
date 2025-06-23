@extends('layouts.app')
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Sales Report</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Report</li>
                    <li class="breadcrumb-item active">Sales Report</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">

                <div class="col-100">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Table Sale Report</h5>

                            <!-- Table with stripped rows -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Transaction Date</th>
                                        <th scope="col">Name Customer</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Change</th>
                                        <th scope="col">Payment</th>
                                        <th scope="col">Total Debt</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $index => $sale)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $sale->transaction_date->format('d-m-Y H:i') }}</td>
                                            <td>{{ $sale->customer->name ?? '-' }}</td>
                                            <td>Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($sale->change, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($sale->payment, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($sale->debt)
                                                    Rp {{ number_format($sale->debt->remaining_debt, 0, ',', '.') }}
                                                @else
                                                    Rp 0
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('sales.history', $sale->id) }}"
                                                    class="btn btn-sm btn-info text-white">
                                                    <i class="bi bi-clock-history"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection