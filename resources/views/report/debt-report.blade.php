@extends('layouts.app')
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Debt</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Debt</li>
                    <li class="breadcrumb-item active">Debt</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">

                <div class="col-100">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Table Debt</h5>

                            <!-- Table with stripped rows -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Total Debt</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($debts as $index => $debt)
                                        <tr>
                                            <th scope="row">{{ $index + 1 }}</th>
                                            <td>{{ $debt['name_customer'] }}</td>
                                            <td>Rp {{ number_format($debt['remaining_debt'], 0, ',', '.') }}</td>
                                            <td>
                                                @if ($debt['status'] === 'unpaid')
                                                    <span class="badge bg-danger">Unpaid</span>
                                                @elseif ($debt['status'] === 'partial')
                                                    <span class="badge bg-warning text-dark">Partial</span>
                                                @else
                                                    <span class="badge bg-success">Paid</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('debts.history', $debt['customer_id']) }}" class="btn btn-sm btn-info text-white">
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