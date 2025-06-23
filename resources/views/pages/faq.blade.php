@extends('layouts.app')
@section('main')
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Pertanyaan yang Sering Diajukan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
        <li class="breadcrumb-item">Halaman</li>
        <li class="breadcrumb-item active">FAQ</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section faq">
    <div class="row">
      <div class="col-lg-6">

        <!-- Basic Questions -->
        <div class="card basic">
          <div class="card-body">
            <h5 class="card-title">Pertanyaan Umum</h5>

            <div>
              <h6>1. Bagaimana cara menambahkan produk baru?</h6>
              <p>Buka menu <strong>Produk</strong>, klik tombol <strong>Tambah Produk</strong>, isi nama produk, kategori, stok, dan harga, lalu simpan.</p>
            </div>

            <div class="pt-2">
              <h6>2. Bagaimana cara mencatat transaksi penjualan?</h6>
              <p>Masuk ke menu <strong>Transaksi</strong>, pilih produk yang ingin dijual, masukkan jumlah, lalu klik <strong>Simpan</strong> untuk menyelesaikan transaksi.</p>
            </div>

            <div class="pt-2">
              <h6>3. Apakah sistem mendukung pencatatan hutang pelanggan?</h6>
              <p>Ya, saat melakukan transaksi, Anda bisa memilih metode pembayaran "Hutang". Sistem akan otomatis mencatat sisa pembayaran di menu <strong>Hutang</strong>.</p>
            </div>

          </div>
        </div>

        <!-- FAQ Group 1 -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Manajemen Produk</h5>

            <div class="accordion accordion-flush" id="faq-group-1">

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq1-1" type="button" data-bs-toggle="collapse">
                    Bagaimana cara mengedit informasi produk?
                  </button>
                </h2>
                <div id="faq1-1" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                  <div class="accordion-body">
                    Buka menu <strong>Produk</strong>, lalu klik tombol <strong>Edit</strong> di sebelah produk yang ingin diperbarui. Ubah informasi yang diperlukan lalu simpan.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq1-2" type="button" data-bs-toggle="collapse">
                    Apakah stok akan berkurang otomatis saat penjualan?
                  </button>
                </h2>
                <div id="faq1-2" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                  <div class="accordion-body">
                    Ya, setiap kali transaksi selesai, stok produk yang dijual akan otomatis dikurangi dari jumlah yang tersedia.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq1-3" type="button" data-bs-toggle="collapse">
                    Bagaimana cara menambahkan kategori produk?
                  </button>
                </h2>
                <div id="faq1-3" class="accordion-collapse collapse" data-bs-parent="#faq-group-1">
                  <div class="accordion-body">
                    Masuk ke menu <strong>Kategori</strong>, klik <strong>Tambah Kategori</strong>, lalu isi nama kategori. Produk bisa dikaitkan dengan kategori ini nantinya.
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-6">

        <!-- FAQ Group 2 -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Transaksi & Laporan</h5>

            <div class="accordion accordion-flush" id="faq-group-2">

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq2-1" type="button" data-bs-toggle="collapse">
                    Bagaimana cara melihat laporan penjualan?
                  </button>
                </h2>
                <div id="faq2-1" class="accordion-collapse collapse" data-bs-parent="#faq-group-2">
                  <div class="accordion-body">
                    Laporan penjualan dapat diakses melalui menu <strong>Laporan</strong>. Anda bisa memfilter berdasarkan tanggal, bulan, atau tahun untuk melihat performa penjualan.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq2-2" type="button" data-bs-toggle="collapse">
                    Apakah saya bisa mencetak struk transaksi?
                  </button>
                </h2>
                <div id="faq2-2" class="accordion-collapse collapse" data-bs-parent="#faq-group-2">
                  <div class="accordion-body">
                    Ya, setelah transaksi selesai, tersedia opsi untuk mencetak struk sebagai bukti pembayaran pelanggan.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq2-3" type="button" data-bs-toggle="collapse">
                    Apakah data transaksi bisa diunduh dalam bentuk Excel?
                  </button>
                </h2>
                <div id="faq2-3" class="accordion-collapse collapse" data-bs-parent="#faq-group-2">
                  <div class="accordion-body">
                    Ya, Anda bisa mengunduh laporan penjualan dalam format Excel dari menu <strong>Laporan</strong> untuk keperluan pembukuan atau rekap manual.
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- FAQ Group 3 -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Akun dan Pengguna</h5>

            <div class="accordion accordion-flush" id="faq-group-3">

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq3-1" type="button" data-bs-toggle="collapse">
                    Bagaimana cara menambahkan kasir baru?
                  </button>
                </h2>
                <div id="faq3-1" class="accordion-collapse collapse" data-bs-parent="#faq-group-3">
                  <div class="accordion-body">
                    Masuk sebagai admin, lalu buka menu <strong>Pengguna</strong>. Klik <strong>Tambah Kasir</strong> dan isi informasi seperti nama, email, dan password.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq3-2" type="button" data-bs-toggle="collapse">
                    Apakah data bisa diakses oleh lebih dari satu pengguna?
                  </button>
                </h2>
                <div id="faq3-2" class="accordion-collapse collapse" data-bs-parent="#faq-group-3">
                  <div class="accordion-body">
                    Ya, selama memiliki akun, beberapa kasir dapat menggunakan sistem secara bersamaan, dengan pembatasan hak akses sesuai peran pengguna.
                  </div>
                </div>
              </div>

              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" data-bs-target="#faq3-3" type="button" data-bs-toggle="collapse">
                    Apakah data akan hilang jika aplikasi ditutup?
                  </button>
                </h2>
                <div id="faq3-3" class="accordion-collapse collapse" data-bs-parent="#faq-group-3">
                  <div class="accordion-body">
                    Tidak, semua data tersimpan secara aman di dalam database. Aplikasi dapat ditutup dan dibuka kembali tanpa kehilangan data.
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>
@endsection
