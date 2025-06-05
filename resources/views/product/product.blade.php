@extends('layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Product</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
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

        <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">+ Tambah Produk</a>

        <!-- Table with stripped rows -->
        <table class="table table-striped">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Barcode</th>
            <th scope="col">Name</th>
            <th scope="col">Unit</th>
            <th scope="col">Purchase Price</th>
            <th scope="col">Selling Price</th>
            <th scope="col">Stock</th>
            <th scope="col">Category</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($products as $index => $product)
        <tr>
        <th scope="row">{{ $index + 1 }}</th>
        <td>{{ $product['barcode'] }}</td>
        <td>{{ $product['name'] }}</td>
        <td>{{ ucfirst($product['unit']) }}</td>
        <td>Rp {{ number_format($product['harga_beli'], 0, ',', '.') }}</td>
        <td>Rp {{ number_format($product['harga_jual'], 0, ',', '.') }}</td>
        <td>{{ $product['stock'] }}</td>
        <td>{{ $product['category'] }}</td>
        <td>
        <a href="{{ route('admin.edit', $product['id']) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.destroy', $product['id']) }}" method="POST" style="display:inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-danger"
          onclick="return confirm('Hapus produk ini?')">Hapus</button>
        </form>
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