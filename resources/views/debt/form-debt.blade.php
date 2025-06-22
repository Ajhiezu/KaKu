@extends('layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Debt Payment</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Debt</li>
      <li class="breadcrumb-item active">Debt Payment</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="row">

      <div class="col-100">

      <div class="card">
        <div class="card-body">
        <h5 class="card-title">Debt Payment</h5>

        {{-- Validasi --}}
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Whoops!</strong> Ada kesalahan dalam input:<br>
        <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

        <!-- Vertical Form -->
        <form class="row g-3" action="{{ isset($debt) ? route('debts.update', $debt->id) : '' }}" method="POST">

          @csrf
          @if(isset($debt))
        @method('PUT')
      @endif

          <div class="col-12">
          <label for="remaining_debt" class="form-label">Total Debt</label>
          <input type="number" class="form-control" id="remaining_debt" name="remaining_debt"
            value="{{ old('remaining_debt', $debt->remaining_debt ?? '') }}" disabled>
          </div>
          <div class="col-12">
          <label for="payment" class="form-label">Payment</label>
          <input type="number" class="form-control" id="payment" name="payment">
          </div>
          <div class="text-center">
          <button type="submit" class="btn btn-primary">Payment</button>
          <a href="{{ route('debts.index') }}" class="btn btn-secondary">Cancel</a>
          </div>
        </form><!-- Vertical Form -->

        </div>
      </div>

      </div>
    </div>
    </section>

  </main>
@endsection
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @if (session('success'))
    <script>
    Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
    });
    console.log("Script berhasil dijalankan dari blade child!");
    </script>
  @endif
@endpush