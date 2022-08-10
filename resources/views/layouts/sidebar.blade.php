<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="/assets_style/images/faces-clipart/pic-1.png" alt="profile" />
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column pr-3">
            <span class="font-weight-medium mb-2">
                {{ auth()->user()->name }}
            </span>

            <span class="font-weight-normal">
                {{ auth()->user()->username }}
            </span>
          </div>

        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/dashboard">
          <i class="mdi mdi-home menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-database-plus menu-icon"></i>
          <span class="menu-title">Master Data</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">

            <li class="nav-item">
              <a class="nav-link" href="/category">Category</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/product">Product</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/member">Member</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="/supplier">Supplier</a>
            </li>

          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/buy">
          <i class="mdi mdi-cart-plus menu-icon"></i>
          <span class="menu-title"> Transaksi Pembelian</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="/sell">
          <i class="mdi mdi-cart menu-icon"></i>
          <span class="menu-title"> Transaksi Penjualan</span>
        </a>
      </li>

      <li class="nav-item sidebar-actions">
        <div class="nav-link">
          <div class="mt-4">
            <div class="border-none">
              <p class="text-black">Akses</p>
            </div>

            <ul class="mt-4 pl-0">
              <li>
                <a href="/logout" class="nav-link">
                    <i class="mdi mdi-logout"></i> Logout
                </a>
              </li>
            </ul>
            
          </div>
        </div>
      </li>
    </ul>
  </nav>