<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('dashboard') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#categories-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layers"></i><span>Categories</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="categories-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('categories.index') }}">
            <i class="bi bi-circle"></i><span>Categories</span>
          </a>
        </li>
        <li>
          <a href="{{ route('categories.create') }}">
            <i class="bi bi-circle"></i><span>Add Categories</span>
          </a>
        </li>
      </ul>
    </li><!-- End Products Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#products-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-box"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="products-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('products.index') }}">
            <i class="bi bi-circle"></i><span>Product</span>
          </a>
        </li>
        <li>
          <a href="{{ route('products.create') }}">
            <i class="bi bi-circle"></i><span>Add Product</span>
          </a>
        </li>
      </ul>
    </li><!-- End Products Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#customer-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-cash"></i><span>Customers</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="customer-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('customers.index') }}">
            <i class="bi bi-circle"></i><span>Customer</span>
          </a>
        </li>
        <li>
          <a href="{{ route('customers.create') }}">
            <i class="bi bi-circle"></i><span>Add Customer</span>
          </a>
        </li>
      </ul>
    </li><!-- End Customer Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('users.index') }}">
            <i class="bi bi-circle"></i><span>User</span>
          </a>
        </li>
        <li>
          <a href="{{ route('users.create') }}">
            <i class="bi bi-circle"></i><span>Add User</span>
          </a>
        </li>
      </ul>
    </li><!-- End User Nav -->

    <li class="nav-heading">Pages</li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#transaction-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-cart"></i><span>Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="transaction-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>Sale</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>Supplier</span>
          </a>
        </li>
      </ul>
    </li><!-- End Transaction Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-clipboard"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="report-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>Sales Report</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bi bi-circle"></i><span>Supplier Reports</span>
          </a>
        </li>
      </ul>
    </li><!-- End report Nav -->

    <li class="nav-heading">Pages</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="#">
        <i class="bi bi-person"></i>
        <span>Profile</span>
      </a>
    </li><!-- End Profile Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="#">
        <i class="bi bi-question-circle"></i>
        <span>F.A.Q</span>
      </a>
    </li><!-- End F.A.Q Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="#">
        <i class="bi bi-envelope"></i>
        <span>Contact</span>
      </a>
    </li><!-- End Contact Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-in-right"></i>
        <span>Log Out</span>
      </a>
    </li>
    <!-- End Login Page Nav -->

  </ul>

</aside><!-- End Sidebar-->