@extends('layouts.app')
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>User</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item">User</li>
                    <li class="breadcrumb-item active">{{ isset($user) ? 'Edit User' : 'Add User' }}</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">

                <div class="col-100">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ isset($user) ? 'Edit User' : 'Add User' }}</h5>

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
                                action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                                method="POST" enctype="multipart/form-data">

                                @csrf
                                @if(isset($user))
                                    @method('PUT')
                                @endif

                                <div class="col-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $user->name ?? '') }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $user->email ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label for="role" class="form-label">Role</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('role', $user->role ?? 'cashier') }}" disabled>
                                    <input type="hidden" name="role" value="{{ old('role', $user->role ?? 'cashier') }}">
                                </div>
                                @if(isset($user))
                                    <div class="col-12">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="text" class="form-control" id="password" name="password"
                                            value="{{ old('password') }}">
                                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                                    </div>
                                @endif

                                <div class="text-center">
                                    <button type="submit"
                                        class="btn btn-primary">{{ isset($user) ? 'Update' : 'Add' }}</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
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
        document.querySelector('form').addEventListener('submit', function (e) {
            const fields = [
                { id: 'name', name: 'Name' },
                { id: 'password', name: 'Password' },
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