@extends('layouts.app')
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Transaction Detail</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sales.report') }}">Sales Report</a></li>
                    <li class="breadcrumb-item active">Transaction Detail</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">

                <div class="col-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Transaction Info</h5>

                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Customer</th>
                                        <td>{{ $transaction->customer->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment</th>
                                        <td>Rp {{ number_format($transaction->payment, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Change</th>
                                        <td>Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Debt</th>
                                        <td>
                                            @if ($transaction->debt)
                                                Rp {{ number_format($transaction->debt->remaining_debt, 0, ',', '.') }}
                                                ({{ ucfirst($transaction->debt->status) }})
                                            @else
                                                Rp 0
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Purchased Items</h5>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction->details as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
