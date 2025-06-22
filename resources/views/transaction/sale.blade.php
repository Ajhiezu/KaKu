@extends('layouts.app')
@section('main')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Sales</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item">Transaction</li>
                    <li class="breadcrumb-item active">Sale</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">

                <div class="col-100">

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Sale Data</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="manualCheckbox" checked
                                        onchange="toggleManualMode()">
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Manual</label>
                                </div>
                            </div>


                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home"
                                        aria-selected="true">Data Umum</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile"
                                        aria-selected="false" tabindex="-1">Data Barang</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="borderedTabContent">
                                <div class="tab-pane fade active show" id="bordered-home" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <form class="row g-3 mt-2">
                                        <div class="col-12">
                                            <label for="datetime" class="form-label">Tanggal & Waktu (WIB)</label>
                                            <input type="datetime-local" class="form-control" id="datetime" name="datetime"
                                                disabled>
                                        </div>

                                        <div class="col-12">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ Auth::user()->name }}" disabled>
                                        </div>
                                        <div class="col-12">
                                            <label for="customer" class="form-label">Customer</label>
                                            <input type="text" id="customer" class="form-control" oninput="searchCustomer()"
                                                autocomplete="off" name="customer">
                                            <div id="customer-suggestions" class="dropdown-menu"
                                                style="position: absolute; z-index: 1000;"></div>
                                        </div>
                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary"
                                                onclick="goToDataBarang()">Next</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="bordered-profile" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <div class="row">
                                        <div class="col-lg-6 mt-2">

                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Product Data</h5>

                                                    <!-- Vertical Form -->
                                                    <form class="row g-3" id="product-form" onsubmit="addProduct(event)">
                                                        <div class="col-12">
                                                            <label for="barcode" class="form-label">Barcode</label>
                                                            <input type="text" id="barcode" class="form-control"
                                                                oninput="searchBarcode()" autocomplete="off" name="barcode">
                                                            <div id="barcode-suggestions" class="dropdown-menu show"
                                                                style="position: absolute; z-index: 1000;"></div>
                                                        </div>

                                                        <div class="manual-only col-12">
                                                            <label for="name" class="form-label">Name Product</label>
                                                            <input type="text" id="product-name" class="form-control"
                                                                oninput="searchName()" autocomplete="off" name="name">
                                                            <div id="name-suggestions" class="dropdown-menu show"
                                                                style="position: absolute; z-index: 1000;"></div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="quantity" class="form-label">Qty</label>
                                                            <input type="text" class="form-control" id="quantity"
                                                                name="quantity">
                                                        </div>

                                                        <div class="manual-only col-12">
                                                            <label for="price" class="form-label">Price</label>
                                                            <input type="text" class="form-control" id="price" name="price">
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="diskon" class="form-label">Diskon</label>
                                                            <input type="text" class="form-control" id="diskon"
                                                                name="diskon">
                                                        </div>

                                                        <div class="text-center">
                                                            <button type="submit" id="add-btn"
                                                                class="btn btn-primary">Add</button>
                                                        </div>
                                                    </form>
                                                    <!-- Vertical Form -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mt-2">

                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Table Product</h5>

                                                    <!-- Table with stripped rows -->
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">Product Name</th>
                                                                <th scope="col">Qty</th>
                                                                <th scope="col">Price</th>
                                                                <th scope="col">Subtotal</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="product-list"></tbody>
                                                    </table>
                                                    <!-- End Table with stripped rows -->
                                                    <div class="row mt-3">
                                                        <div class="col-lg-6">
                                                            <label for="total" class="form-label">Total</label>
                                                            <input type="text" class="form-control" id="total" name="total"
                                                                readonly>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label for="bayar" class="form-label">Bayar</label>
                                                            <input type="number" class="form-control" id="bayar"
                                                                name="bayar" oninput="formatBayarInput()">
                                                        </div>
                                                        <div class="col-lg-6 mt-2">
                                                            <label for="kembalian" class="form-label">Kembalian</label>
                                                            <input type="text" class="form-control" id="kembalian"
                                                                name="kembalian" readonly>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="text-center mt-3">
                                                    <form id="sale-form" method="POST"
                                                        action="{{ route('transactions.store') }}" class="mb-3">
                                                        @csrf
                                                        <input type="hidden" name="datetime" id="form-datetime">
                                                        <input type="hidden" name="customer" id="form-customer">
                                                        <input type="hidden" name="total" id="form-total">
                                                        <input type="hidden" name="bayar" id="form-bayar">
                                                        <input type="hidden" name="kembalian" id="form-kembalian">
                                                        <input type="hidden" name="products" id="form-products">
                                                        <div id="debt-info" style="display: none;"
                                                            class="alert alert-warning mt-3">
                                                            <strong>Hutang:</strong>
                                                            <p>Total Hutang: <span id="debt-amount">Rp 0</span></p>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Submit
                                                            Transaksi</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
@push('scripts')
    <script>
        function updateDateTime() {
            const now = new Date();

            // Konversi ke waktu Indonesia Barat (WIB = UTC+7)
            const wibOffset = 7 * 60; // dalam menit
            const localOffset = now.getTimezoneOffset(); // offset lokal dalam menit
            const wibTime = new Date(now.getTime() + (wibOffset + localOffset) * 60000);

            const year = wibTime.getFullYear();
            const month = String(wibTime.getMonth() + 1).padStart(2, '0');
            const day = String(wibTime.getDate()).padStart(2, '0');
            const hours = String(wibTime.getHours()).padStart(2, '0');
            const minutes = String(wibTime.getMinutes()).padStart(2, '0');
            const seconds = String(wibTime.getSeconds()).padStart(2, '0');

            const formatted = `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`;
            document.getElementById('datetime').value = formatted;
        }

        // Jalankan pertama kali
        updateDateTime();

        // Perbarui setiap detik
        setInterval(updateDateTime, 1000);
    </script>
    <script>
        function goToDataBarang() {
            const triggerTab = document.querySelector('#profile-tab');
            const tab = new bootstrap.Tab(triggerTab);
            tab.show();
        }
    </script>
    <script>
        // Fungsi untuk hitung total
        function hitungTotal() {
            let total = 0;
            document.querySelectorAll("#product-list .subtotal").forEach(td => {
                total += parseInt(td.textContent || 0);
            });
            document.getElementById('total').value = `Rp ${total.toLocaleString('id-ID')}`;
            return total;
        }

        // Fungsi hitung kembalian
        function hitungKembalian() {
            const total = hitungTotal();

            // Ambil angka bayar dan hilangkan titik ribuan
            const bayarInput = document.getElementById('bayar').value.replace(/\./g, '');
            const bayar = parseInt(bayarInput || 0);

            const kembalian = bayar - total;
            document.getElementById('kembalian').value =
                kembalian >= 0 ? `Rp ${kembalian.toLocaleString('id-ID')}` : "Rp 0";
        }


        function formatBayarInput() {
            let input = document.getElementById('bayar');
            let value = input.value.replace(/\./g, ''); // Hapus titik ribuan

            // Hapus karakter non digit
            value = value.replace(/\D/g, '');

            if (value === '') {
                input.value = '';
                hitungKembalian();
                return;
            }

            // Format ke ribuan
            let formatted = parseInt(value, 10).toLocaleString('id-ID');
            input.value = formatted;

            hitungKembalian(); // tetap panggil hitung kembalian
        }


        // Jalankan saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            hitungTotal();
        });
    </script>
    <script>
        let manualMode = true;

        function toggleManualMode() {
            manualMode = document.getElementById('manualCheckbox').checked;

            document.querySelectorAll('.manual-only').forEach(el => {
                el.style.display = manualMode ? 'block' : 'none';
            });

            // Hanya tampilkan tombol "Add" di mode manual
            document.getElementById('add-btn').style.display = manualMode ? 'inline-block' : 'none';

            // Reset kolom input
            document.getElementById('product-name').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('price').value = '';
            document.getElementById('diskon').value = '';
            document.getElementById('barcode').value = '';
        }


        function addProduct(e) {
            e.preventDefault();

            if (!manualMode) return;

            const name = document.getElementById('product-name').value;
            const qty = parseInt(document.getElementById('quantity').value);
            const price = parseInt(document.getElementById('price').value);
            const diskon = parseInt(document.getElementById('diskon').value) || 0;
            const barcode = document.getElementById('barcode').value;
            const subtotal = (qty * price) - diskon;

            const table = document.getElementById('product-list');
            const rowCount = table.rows.length + 1;

            const row = table.insertRow();
            row.setAttribute('data-barcode', barcode);

            row.innerHTML = `
                                            <th scope="row">${rowCount}</th>
                                            <td class="product-name">${name}</td>
                                            <td class="qty">${qty}</td>
                                            <td class="price">${price}</td>
                                            <td class="subtotal">${subtotal}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning me-1" onclick="editProduct(this)"><i class="bi bi-pencil"></i></button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteProduct(this)"><i class="bi bi-trash"></i></button>
                                            </td>
                                        `;

            hitungTotal();

            document.getElementById('product-name').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('price').value = '';
            document.getElementById('diskon').value = '';
            document.getElementById('barcode').value = '';
        }



        document.addEventListener('DOMContentLoaded', toggleManualMode);

        function editProduct(button) {
            const row = button.closest('tr');

            const name = row.querySelector('.product-name').textContent;
            const qty = row.querySelector('.qty').textContent;
            const price = row.querySelector('.price').textContent;
            const barcode = row.getAttribute('data-barcode') || '';

            document.getElementById('product-name').value = name;
            document.getElementById('quantity').value = qty;
            document.getElementById('price').value = price;
            document.getElementById('barcode').value = barcode;
            document.getElementById('diskon').value = '';

            row.remove();

            updateRowNumbers();
            hitungTotal();
        }


        function deleteProduct(button) {
            const row = button.closest('tr');
            row.remove();

            // Update ulang nomor urut dan total
            updateRowNumbers();
            hitungTotal();
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#product-list tr');
            rows.forEach((row, index) => {
                row.querySelector('th').textContent = index + 1;
            });
        }

    </script>
    <script>
        function createSuggestionList(data, containerId, isBarcode = false) {
            const container = document.getElementById(containerId);
            container.innerHTML = "";

            if (data.length === 0) {
                container.style.display = "none";
                return;
            }

            data.forEach(item => {
                const option = document.createElement("a");
                option.classList.add("dropdown-item");
                option.href = "#";
                option.textContent = isBarcode ? `${item.barcode} - ${item.name}` : item.name;
                option.addEventListener("click", function (e) {
                    e.preventDefault();
                    document.getElementById("product-name").value = item.name;
                    document.getElementById("barcode").value = item.barcode;
                    document.getElementById("price").value = item.selling_price;
                    document.getElementById("quantity").value = 1;
                    container.innerHTML = "";
                    container.style.display = "none";
                });
                container.appendChild(option);
            });

            container.style.display = "block";
        }

        async function searchBarcode() {
            const keyword = document.getElementById("barcode").value;
            if (keyword.length < 1) return;

            const res = await fetch(`/autocomplete/barcode?barcode=${keyword}`);
            const data = await res.json();
            createSuggestionList(data, "barcode-suggestions", true);
        }

        async function searchName() {
            const keyword = document.getElementById("product-name").value;
            if (keyword.length < 1) return;

            const res = await fetch(`/autocomplete/product?name=${keyword}`);
            const data = await res.json();
            createSuggestionList(data, "name-suggestions", false);
        }

        async function searchCustomer() {
            const input = document.getElementById("customer");
            const suggestionBox = document.getElementById("customer-suggestions");
            const keyword = input.value.trim();

            if (keyword.length < 1) {
                suggestionBox.innerHTML = '';
                suggestionBox.classList.remove('show');
                return;
            }

            try {
                const res = await fetch(`/autocomplete/customer?name=${encodeURIComponent(keyword)}`);
                if (!res.ok) throw new Error("Network response was not ok");
                const data = await res.json();

                suggestionBox.innerHTML = '';
                if (data.length === 0) {
                    suggestionBox.classList.remove('show');
                    return;
                }

                data.forEach(customer => {
                    const item = document.createElement('a');
                    item.classList.add('dropdown-item');
                    item.href = '#';
                    item.textContent = customer.name;
                    item.onclick = (e) => {
                        e.preventDefault();
                        input.value = customer.name;
                        suggestionBox.innerHTML = '';
                        suggestionBox.classList.remove('show');
                    };
                    suggestionBox.appendChild(item);
                });

                suggestionBox.classList.add('show');
            } catch (error) {
                console.error('Fetch error:', error);
            }
        }


        // Hide dropdown if click outside
        document.addEventListener("click", function (e) {
            if (!e.target.closest("#barcode") && !e.target.closest("#barcode-suggestions")) {
                document.getElementById("barcode-suggestions").style.display = "none";
            }
            if (!e.target.closest("#product-name") && !e.target.closest("#name-suggestions")) {
                document.getElementById("name-suggestions").style.display = "none";
            }
        });
    </script>
    <script>
        async function autofillProductByBarcode() {
            const barcode = document.getElementById("barcode").value.trim();
            if (barcode.length === 0 || manualMode) return;

            try {
                const response = await fetch(`/product-by-barcode?barcode=${barcode}`);
                if (!response.ok) throw new Error('Not found');

                const data = await response.json();

                // Ambil qty dan diskon
                const qty = parseInt(document.getElementById("quantity").value) || 1;
                const diskon = parseInt(document.getElementById("diskon").value) || 0;

                const subtotal = (data.selling_price * qty) - diskon;

                const table = document.getElementById('product-list');
                const rowCount = table.rows.length + 1;

                const row = table.insertRow();
                row.setAttribute('data-barcode', data.barcode);
                row.innerHTML = `
                                                            <th scope="row">${rowCount}</th>
                                                            <td class="product-name">${data.name}</td>
                                                            <td class="qty">${qty}</td>
                                                            <td class="price">${data.selling_price}</td>
                                                            <td class="subtotal">${subtotal}</td>
                                                        `;

                hitungTotal();
                document.getElementById("barcode").value = '';
                document.getElementById("quantity").value = '';
                document.getElementById("diskon").value = '';

            } catch (error) {
                console.log("Product not found by barcode");
            }
        }


        async function autofillProductByName() {
            const name = document.getElementById("product-name").value;

            if (name.length === 0) return;

            try {
                const response = await fetch(`/product-by-name?name=${encodeURIComponent(name)}`);
                if (!response.ok) throw new Error('Not found');

                const data = await response.json();

                document.getElementById("barcode").value = data.barcode;
                document.getElementById("quantity").value = 1;
                document.getElementById("price").value = data.selling_price;
            } catch (error) {
                console.log("Product not found by name");
            }
        }

        function handleBarcodeInput() {
            if (!manualMode) {
                autofillProductByBarcode();
            }
        }


        function handleNameInput() {
            autofillProductByName();
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById("product-name").addEventListener("input", handleNameInput);
            document.getElementById("barcode").addEventListener("input", handleBarcodeInput);
        });
    </script>
    <script>
        document.getElementById("sale-form").addEventListener("submit", function (e) {
            e.preventDefault(); // cegah submit sementara

            // Cek apakah ada produk di tabel
            const productRows = document.querySelectorAll("#product-list tr");
            if (productRows.length === 0) {
                // Pakai SweetAlert2 (pastikan sudah include SweetAlert2) 
                Swal.fire({
                    icon: 'warning',
                    title: 'Belum ada produk',
                    text: 'Mohon tambahkan minimal 1 produk sebelum submit transaksi.',
                    confirmButtonColor: '#3085d6',
                });
                return; // batalkan submit
            }

            // Jika ada produk, lanjut validasi dan submit seperti biasa
            const datetime = document.getElementById("datetime").value;
            const customer = document.getElementById("customer").value.trim();
            const totalStr = document.getElementById("total").value.replace(/[^\d]/g, '');
            const bayarStr = document.getElementById("bayar").value.replace(/[^\d]/g, '');
            const kembalianStr = document.getElementById("kembalian").value.replace(/[^\d]/g, '');

            const total = parseFloat(totalStr || 0);
            const bayar = parseFloat(bayarStr || 0);

            if (bayar <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pembayaran kosong!',
                    text: 'Pembayaran harus diisi terlebih dahulu!',
                });
                return;
            }

            if (bayar < total && customer === '') {
                Swal.fire({
                    icon: 'info',
                    title: 'Customer kosong!',
                    text: 'Customer harus diisi jika ingin menghutang!',
                });
                return;
            }

            // Siapkan data produk untuk disubmit
            const products = [];
            productRows.forEach(row => {
                const name = row.querySelector(".product-name")?.textContent.trim();
                const qty = parseInt(row.querySelector(".qty")?.textContent || 0);
                const price = parseInt(row.querySelector(".price")?.textContent || 0);
                const subtotal = parseInt(row.querySelector(".subtotal")?.textContent || 0);
                if (name) {
                    products.push({ name, quantity: qty, price, subtotal });
                }
            });

            document.getElementById("form-datetime").value = datetime;
            document.getElementById("form-customer").value = customer;
            document.getElementById("form-total").value = totalStr;
            document.getElementById("form-bayar").value = bayarStr;
            document.getElementById("form-kembalian").value = kembalianStr;
            document.getElementById("form-products").value = JSON.stringify(products);

            // Konfirmasi submit
            Swal.fire({
                title: 'Yakin ingin submit transaksi?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit(); // submit form asli
                }
            });
        });

    </script>
    <script>
        function updateDebtInfo() {
            const total = parseInt(document.getElementById("total").value.replace(/[^\d]/g, '') || "0");
            const bayar = parseInt(document.getElementById("bayar").value.replace(/[^\d]/g, '') || "0");
            const debtAmount = total - bayar;

            if (bayar < total) {
                document.getElementById("debt-info").style.display = "block";
                document.getElementById("debt-amount").innerText = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(debtAmount);
            } else {
                document.getElementById("debt-info").style.display = "none";
            }
        }
        document.getElementById("bayar").addEventListener("input", updateDebtInfo);
    </script>
@endpush