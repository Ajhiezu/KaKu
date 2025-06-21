@extends('layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Customer</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Customer</li>
      <li class="breadcrumb-item active">Customer</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->

    <section class="section">
    <div class="row">

      <div class="col-100">

      <div class="card">
        <div class="card-body">
        <h5 class="card-title">Table Customer</h5>

        <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">+ Add Customer</a>

        <!-- Table with stripped rows -->
        <table class="table table-striped">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($customers as $index => $customer)
          <tr>
          <th scope="row">{{ $index + 1 }}</th>
          <td>{{ $customer['name'] }}</td>
          <td>{{ $customer['phone'] ?? '-' }}</td>
          <td>{{ $customer['address'] ?? '-' }}</td>
          <td>
          <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning"><i
            class="bi bi-pencil"></i></a>
          <form id="delete-form-{{ $customer->id }}" action="{{ route('customers.destroy', $customer->id) }}"
            method="POST" style="display:none;">
            @csrf
            @method('DELETE')
          </form>

          <button onclick="deleteCustomer({{ $customer->id }})" class="btn btn-danger"><i
            class="bi bi-trash"></i></button>
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
@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  @if(session('success'))
    <script>
    Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
    });
    </script>
  @endif

  <script>
    function deleteCustomer(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
      document.getElementById('delete-form-' + id).submit();
      }
    })
    }
  </script>
@endpush