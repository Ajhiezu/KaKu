@extends('layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Categories</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item">Categories</li>
      <li class="breadcrumb-item active">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="row">

      <div class="col-100">

      <div class="card">
        <div class="card-body">
        <h5 class="card-title">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h5>

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
          action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}"
          method="POST" enctype="multipart/form-data">

          @csrf
          @if(isset($category))
        @method('PUT')
      @endif

          <div class="col-12">
          <label for="image" class="form-label">Image</label>
          @if(isset($category) && $category->image)
        <div class="mb-2">
        <img src="{{ asset($category->image) }}" alt="Current Image" width="120" />
        </div>
      @endif
          <input type="file" class="form-control" id="image" name="image" />
          </div>
          <div class="col-12">
          <label for="name" class="form-label">Name Category</label>
          <input type="text" class="form-control" id="name" name="name"
            value="{{ old('name', $category->name ?? '') }}" required>
          </div>
          <div class="text-center">
          <button type="submit" class="btn btn-primary">{{ isset($category) ? 'Update' : 'Add' }}</button>
          <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
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
    const name = document.getElementById('name').value.trim();
    if (!name) {
      e.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Nama kategori wajib diisi!',
      });
    }
  });
</script>
@endpush