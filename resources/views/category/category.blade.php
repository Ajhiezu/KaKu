@extends('layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Category</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item">Category</li>
      <li class="breadcrumb-item active">Category</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->

    <section class="section">
    <div class="row">

      <div class="col-100">

      <div class="card">
        <div class="card-body">
        <h5 class="card-title">Table Category</h5>

        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">+ Add Category</a>

        <!-- Table with stripped rows -->
        <table class="table table-striped">
          <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Action</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($categories as $index => $category)
        <tr>
        <th scope="row">{{ $index + 1 }}</th>
        <td>
        <img src="{{ asset($category['image']) }}" alt="Gambar Category" width="80">
        </td>
        <td>{{ $category['name'] }}</td>
        <td>
        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning"><i
          class="bi bi-pencil"></i></a>
        <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}"
          method="POST" style="display:none;">
          @csrf
          @method('DELETE')
        </form>

        <button onclick="deleteCategory({{ $category->id }})" class="btn btn-danger"><i
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
    <script>
    function deleteCategory(id) {
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
  @endif
@endpush