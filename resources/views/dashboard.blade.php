@extends('Layouts.app')
@section('main')
  <main id="main" class="main">

    <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-8">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card">

          <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
            <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'today']) }}">Today</a></li>
            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'month']) }}">This Month</a>
            </li>
            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'year']) }}">This Year</a></li>

          </ul>
          </div>

          <div class="card-body">
          <h5 class="card-title">Sales <span>| {{ $filter }}</span></h5>

          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-cart"></i>
            </div>
            <div class="ps-3">
            <h6>{{ $sales }}</h6>
            <span class="text-{{ $sales_change >= 0 ? 'success' : 'danger' }}">{{ abs($sales_change) }}%</span>
            <span class="text-muted small pt-2 ps-1">{{ $sales_change >= 0 ? 'increase' : 'decrease' }}</span>

            </div>
          </div>
          </div>

        </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
        <div class="card info-card revenue-card">

          <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
            <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'today']) }}">Today</a></li>
            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'month']) }}">This Month</a>
            </li>
            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'year']) }}">This Year</a></li>
          </ul>
          </div>

          <div class="card-body">
          <h5 class="card-title">Pendapatan <span>| {{ $filter }}</span></h5>

          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
            <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="ps-3">
            <h6>Rp. {{ $revenue }}</h6>
            <span
              class="text-{{ $revenue_change >= 0 ? 'success' : 'danger' }}">{{ abs($revenue_change) }}%</span>
            <span class="text-muted small pt-2 ps-1">{{ $revenue_change >= 0 ? 'increase' : 'decrease' }}</span>

            </div>
          </div>
          </div>

        </div>
        </div><!-- End Revenue Card -->

        <!-- Reports -->
        <div class="col-12">
        <div class="card">

          <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
            <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'today']) }}">Today</a></li>
            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'month']) }}">This Month</a>
            </li>
            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'year']) }}">This Year</a></li>
          </ul>
          </div>

          <div class="card-body">
          <h5 class="card-title">Reports <span>/{{ $filter ?? 'Today' }}</span></h5>

          <!-- Line Chart -->
          <div id="reportsChart"></div>

          <script>
            document.addEventListener("DOMContentLoaded", () => {
            const chartLabels = @json($chartLabels);
            const salesData = @json($chartSalesData);
            const revenueData = @json($chartRevenueData);

            new ApexCharts(document.querySelector("#reportsChart"), {
              series: [
              { name: 'Sales', data: salesData },
              { name: 'Revenue', data: revenueData }
              ],
              chart: {
              height: 350,
              type: 'area',
              toolbar: { show: false }
              },
              markers: { size: 4 },
              colors: ['#4154f1', '#2eca6a'],
              fill: {
              type: "gradient",
              gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.4,
                stops: [0, 90, 100]
              }
              },
              dataLabels: { enabled: false },
              stroke: { curve: 'smooth', width: 2 },
              xaxis: {
              categories: chartLabels
              },
              tooltip: {
              x: {
                formatter: function (val) {
                return val;
                }
              }
              }
            }).render();
            });
          </script>

          <!-- End Line Chart -->

          </div>

        </div>
        </div><!-- End Reports -->

        <!-- Top Selling -->
        <div class="col-12">
        <div class="card top-selling overflow-auto">

          <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
            <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'today']) }}">Today</a></li>
            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'month']) }}">This Month</a>
            </li>
            <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'year']) }}">This Year</a></li>
          </ul>
          </div>

          <div class="card-body pb-0">
          <h5 class="card-title">Top Selling <span>| Today</span></h5>

          <table class="table table-borderless">
            <thead>
            <tr>
              <th scope="col">Preview</th>
              <th scope="col">Product</th>
              <th scope="col">Price</th>
              <th scope="col">Sold</th>
              <th scope="col">Revenue</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($topSelling as $item)
        <tr>
          <th scope="row">
          <a href="{{ route('products.index') }}">
          <img src="{{ asset('storage/' . $item->product->image) }}" alt="Gambar Produk" width="80"
          onerror="this.onerror=null;this.src='{{ asset('no-image.png') }}';">
          </a>
          </th>
          <td><a href="{{ route('products.index') }}"
          class="text-primary fw-bold">{{ $item->product->name }}</a></td>
          <td>Rp{{ number_format($item->product->selling_price, 0, ',', '.') }}</td>
          <td class="fw-bold">{{ $item->total_sold }}</td>
          <td>Rp{{ number_format($item->total_revenue, 0, ',', '.') }}</td>
        </tr>
        @endforeach
            </tbody>
          </table>

          </div>

        </div>
        </div><!-- End Top Selling -->

      </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">

      <!-- Recent Activity -->
      <div class="card">
        <div class="filter">
        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <li class="dropdown-header text-start">
          <h6>Filter</h6>
          </li>

          <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'today']) }}">Today</a></li>
          <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'month']) }}">This Month</a></li>
          <li><a class="dropdown-item" href="{{ route('dashboard', ['filter' => 'year']) }}">This Year</a></li>
        </ul>
        </div>

        <div class="card-body">
        <h5 class="card-title">Recent Activity <span>| {{ $filter }}</span></h5>

        <div class="activity">
          @foreach ($recentActivities as $item)
        <div class="activity-item d-flex">
        <div class="activite-label">
        {{ $item->created_at->diffForHumans() }}
        </div>
        <i
        class="bi bi-circle-fill activity-badge text-{{ ['success', 'danger', 'primary', 'info', 'warning', 'muted'][rand(0, 5)] }} align-self-start"></i>
        <div class="activity-content">
        Produk <a href="#" class="fw-bold text-dark">{{ $item->product->name }}</a> dibeli sebanyak
        <strong>{{ $item->quantity }}</strong> pcs.
        </div>
        </div>
      @endforeach
        </div>


        </div>
      </div><!-- End Recent Activity -->

      </div><!-- End Right side columns -->

    </div>
    </section>

  </main><!-- End #main -->
@endsection