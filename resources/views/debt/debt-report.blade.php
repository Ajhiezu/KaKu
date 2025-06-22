@extends('layouts.app')
@section('main')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Riwayat Pembayaran Hutang : {{ $customerName }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('debts.index') }}">Debt</a></li>
                    <li class="breadcrumb-item active">History</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-body mt-2">
                    @foreach ($debts as $debt)
                        <h5>Hutang ID: {{ $debt->id }}, Total: Rp {{ number_format($debt->remaining_debt, 0, ',', '.') }}</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jumlah Pembayaran</th>
                                    <th>Tanggal Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($debt->payments as $index => $payment)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>Rp {{ number_format($payment->payment_amount, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y H:i:s') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada pembayaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <hr>
                    @endforeach

                    <div class="text-center"><a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a></div>
                </div>
            </div>
        </section>
    </main>
@endsection