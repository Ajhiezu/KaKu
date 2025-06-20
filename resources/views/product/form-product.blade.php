@extends('layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Product</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Product</li>
      <li class="breadcrumb-item active">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="row">

      <div class="col-100">

      <div class="card">
        <div class="card-body">
        <h5 class="card-title">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h5>

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
          action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}"
          method="POST" enctype="multipart/form-data">

          @csrf
          @if(isset($product))
        @method('PUT')
      @endif

          <div class="col-12">
          <label for="image" class="form-label">Image</label>
          @if(isset($product) && $product->image)
        <div class="mb-2">
        <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" width="120" />
        </div>
      @endif
          <input type="file" class="form-control" id="image" name="image" />
          </div>
          <div class="col-12">
          <label for="barcode" class="form-label">Barcode</label>
          <input type="number" class="form-control" id="barcode" name="barcode" value="{{ old('barcode', $product->barcode ?? '') }}" required>
          </div>
          <div class="col-12">
          <label for="name" class="form-label">Name Product</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
          </div>
          <div class="col-12">
          <label for="unit" class="form-label">Unit</label>
          <select id="unit" name="unit" class="form-select">
            <option selected="">Choose Unit</option>
            <option value="pcs" {{ old('unit', $product->unit ?? '') == 'pcs' ? 'selected' : '' }}>Pcs</option>
            <option value="liter" {{ old('unit', $product->unit ?? '') == 'liter' ? 'selected' : '' }}>Liter</option>
            <option value="kg" {{ old('unit', $product->unit ?? '') == 'kg' ? 'selected' : '' }}>Kg</option>
          </select>
          </div>
          <div class="col-12">
          <label for="stock" class="form-label">Stock</label>
          <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required>
          </div>
          <div class="col-12">
          <label for="purchase_price" class="form-label">Purchase Price</label>
          <input type="number" class="form-control" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price ?? '') }}" required>
          </div>
          <div class="col-12">
          <label for="selling_price" class="form-label">Selling Price</label>
          <input type="number" class="form-control" id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price ?? '') }}" required>
          </div>
          <div class="col-12">
          <label for="category" class="form-label">Category</label>
          <select id="category_id" name="category_id" class="form-select">
            <option selected="">Choose Category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}> {{ $category->name }}</option>
            @endforeach
          </select>
          </div>
          <div class="text-center">
          <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Add' }}</button>
          <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
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
    </script>
  @endif

  <script>
    document.querySelector('form').addEventListener('submit', function(e) {
      const fields = [
        { id: 'barcode', name: 'Barcode' },
        { id: 'name', name: 'Product Name' },
        { id: 'unit', name: 'Unit' },
        { id: 'stock', name: 'Stock' },
        { id: 'purchase_price', name: 'Purchase Price' },
        { id: 'selling_price', name: 'Selling Price' },
        { id: 'category_id', name: 'Category' },
      ];

      let errorMessages = [];

      fields.forEach(field => {
        const el = document.getElementById(field.id);
        if (!el || el.value.trim() === '' || el.value === 'Choose Unit' || el.value === 'Choose Category') {
          errorMessages.push(`- ${field.name} is required`);
        }
      });

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
