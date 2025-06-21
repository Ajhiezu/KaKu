@extends('layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Customers</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item">Customers</li>
      <li class="breadcrumb-item active">{{ isset($customer) ? 'Edit Customer' : 'Add Customer' }}</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="row">

      <div class="col-100">

      <div class="card">
        <div class="card-body">
        <h5 class="card-title">{{ isset($customer) ? 'Edit Customer' : 'Add Customer' }}</h5>

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
        <form class="row g-3"
          action="{{ isset($customer) ? route('customers.update', $customer->id) : route('customers.store') }}"
          method="POST" enctype="multipart/form-data">

          @csrf
          @if(isset($customer))
        @method('PUT')
      @endif

          <div class="col-12">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $customer->name ?? '') }}" required>
          </div>
          <div class="col-12">
          <label for="phone" class="form-label">Phone</label>
          <input type="number" class="form-control" id="phone" name="phone"
            value="{{ old('phone', $customer->phone ?? '') }}">
          </div>
          <div class="col-12">
          <label for="address" class="form-label">Address</label>
          <input type="text" class="form-control" id="address" name="address"
            value="{{ old('address', $customer->address ?? '') }}">
          </div>
          <div class="text-center">
          <button type="submit" class="btn btn-primary">{{ isset($customer) ? 'Update' : 'Add' }}</button>
          <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
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
  <script>
  document.querySelector('form').addEventListener('submit', function(e) {
      const fields = [
        { id: 'name', name: 'Name' },
      ];

      let errorMessages = [];

      if (errorMessages.length > 0) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'Oops!',
          html: errorMessages.join('<br>'),
        });
      }
    });
</script>
@endpush