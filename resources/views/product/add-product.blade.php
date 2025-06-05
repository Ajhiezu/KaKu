@extends('layouts.app')
@section('main')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Product</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item">Product</li>
          <li class="breadcrumb-item active">Add Product</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">

        <div class="col-100">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Product Add</h5>

              <!-- Vertical Form -->
              <form class="row g-3">
                <div class="col-12">
                  <label for="barcode" class="form-label">Barcode</label>
                  <input type="number" class="form-control" id="barcode">
                </div>
                <div class="col-12">
                  <label for="nameProduct" class="form-label">Name Product</label>
                  <input type="text" class="form-control" id="nameProduct">
                </div>
                <div class="col-12">
                  <label for="unit" class="form-label">Unit</label>
                  <select id="unit" class="form-select">
                    <option selected="">Choose Unit</option>
                    <option>Pcs</option>
                    <option>Liter</option>
                    <option>Kg</option>
                  </select>
                </div>
                <div class="col-12">
                  <label for="hargaBeli" class="form-label">Purchase Price</label>
                  <input type="number" class="form-control" id="hargaBeli">
                </div>
                <div class="col-12">
                  <label for="hargaJual" class="form-label">Selling Price</label>
                  <input type="number" class="form-control" id="hargaJual">
                </div>
                <div class="col-12">
                  <label for="stock" class="form-label">Stock</label>
                  <input type="number" class="form-control" id="stock">
                </div>
                <div class="col-12">
                  <label for="category" class="form-label">Category</label>
                  <select id="unit" class="form-select">
                    <option selected="">Choose Category</option>
                    <option>...</option>
                  </select>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Add</button>
                  <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main>
@endsection