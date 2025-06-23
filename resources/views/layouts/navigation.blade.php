<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center">
      <img src="assets/img/logo.png" alt="">
      <span class="d-none d-lg-block">Kaku</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
      <input type="text" name="query" placeholder="Search" title="Enter search keyword">
      <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li><!-- End Search Icon-->

      <li class="nav-item dropdown">

        @php
      $countNotifs = $lowStockProducts->count();
    @endphp

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          @if($countNotifs > 0)
        <span class="badge bg-primary badge-number">{{ $countNotifs }}</span>
      @endif
        </a><!-- End Notification Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            @php
        $countNotifs = $lowStockProducts->count();
        @endphp
            You have {{ $countNotifs }} stock notifications
            <a href="{{ route('products.index') }}"><span class="badge rounded-pill bg-primary p-2 ms-2">View
                all</span></a>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          @forelse ($lowStockProducts as $product)
          <li class="notification-item">
          @if ($product->stock == 0)
        <i class="bi bi-x-circle text-danger"></i>
        @else
        <i class="bi bi-exclamation-circle text-warning"></i>
        @endif
          <div>
            <h4>{{ $product->name }}</h4>
            @if ($product->stock == 0)
          <p><strong>Stok habis!</strong> Segera restock produk ini.</p>
        @else
          <p><strong>Stok tinggal {{ $product->stock }}</strong>. Segera isi ulang.</p>
        @endif
            <p>{{ $product->updated_at->diffForHumans() }}</p>
          </div>
          </li>
          <li>
          <hr class="dropdown-divider">
          </li>
      @empty
        <li class="notification-item">
        <i class="bi bi-check-circle text-success"></i>
        <div>
          <h4>Stok Aman</h4>
          <p>Tidak ada produk yang perlu restock saat ini.</p>
        </div>
        </li>
      @endforelse

          <li class="dropdown-footer">
            <a href="{{ route('products.index') }}">Show all products</a>
          </li>
        </ul>
        <!-- End Notification Dropdown Items -->

      </li><!-- End Notification Nav -->

      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ asset('admin') }}/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{ Auth::user()->name }}</h6>
            <span>{{ Auth::user()->role }}</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{route('profile')}}">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{route('profile')}}">
              <i class="bi bi-gear"></i>
              <span>Account Settings</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{route('faq')}}">
              <i class="bi bi-question-circle"></i>
              <span>Need Help?</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="#"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>


        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->