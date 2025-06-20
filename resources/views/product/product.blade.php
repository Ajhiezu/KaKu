@extends('layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Product</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Product</li>
      <li class="breadcrumb-item active">Product</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->

    <section class="section">
    <div class="row">

      <div class="col-100">

      <div class="card">
        <div class="card-body">
        <h5 class="card-title">Table Product</h5>

        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">+ Add Produk</a>

        <!-- Table with stripped rows -->
        <table class="table table-striped">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Barcode</th>
            <th scope="col">Name</th>
            <th scope="col">Unit</th>
            <th scope="col">Stock</th>
            <th scope="col">Purchase Price</th>
            <th scope="col">Selling Price</th>
            <th scope="col">Category</th>
            <th scope="col">Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($products as $index => $product)
          <tr>
          <th scope="row">{{ $index + 1 }}</th>
          <td>@if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" width="80"
        onerror="this.onerror=null;this.src='{{ asset('no-image.png') }}';">
        @else
        <span class="text-muted">No image</span>
        @endif
          </td>
          <td>{{ $product['barcode'] }}</td>
          <td>{{ $product['name'] }}</td>
          <td>{{ ucfirst($product['unit']) }}</td>
          <td>{{ ucfirst($product['stock']) }}</td>
          <td>Rp {{ number_format($product['purchase_price'], 0, ',', '.') }}</td>
          <td>Rp {{ number_format($product['selling_price'], 0, ',', '.') }}</td>
          <td>{{ $product->category->name ?? '-' }}</td>
          <td>
          <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning"><i
            class="bi bi-pencil"></i></a>
          <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}"
            method="POST" style="display:none;">
            @csrf
            @method('DELETE')
          </form>

          <button onclick="deleteProduct({{ $product->id }})" class="btn btn-danger"><i
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
    function deleteProduct(id) {
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