<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="/assets_style/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="/assets_style/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="/assets_style/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="/assets_style/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets_style/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="/assets_style/css/style.css" />
    
    {{-- DataTables --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" /> --}}
    <link rel="stylesheet" href="/assets_style/datatables/datatables.css">

    <link rel="shortcut icon" href="/assets_style/images/favicon.png" />

    {{-- Jquery --}}
    <script src="/assets_style/jquery.min.js"></script>
  </head>

  {{-- class="sidebar-icon-only" --}}
  <body class="{{ Request::is('buy_detail') || Request::is('sell_detail') ? 'sidebar-icon-only' : '' }}">
    <div class="container-scroller">
    
      {{-- Sidebar --}}
      @include('layouts.sidebar')
      {{-- Sidebar --}}

      <div class="container-fluid page-body-wrapper">

        {{-- Settingan Sidebar --}}
        <div id="theme-settings" class="settings-panel">
          <i class="settings-close mdi mdi-close"></i>
          <p class="settings-heading">SIDEBAR SKINS</p>
          <div class="sidebar-bg-options selected" id="sidebar-default-theme">
            <div class="img-ss rounded-circle bg-light border mr-3"></div> Default
          </div>
          <div class="sidebar-bg-options" id="sidebar-dark-theme">
            <div class="img-ss rounded-circle bg-dark border mr-3"></div> Dark
          </div>
          <p class="settings-heading mt-2">HEADER SKINS</p>
          <div class="color-tiles mx-0 px-4">
            <div class="tiles light"></div>
            <div class="tiles dark"></div>
          </div>
        </div>
        {{-- END Settingan Sidebar --}}


        {{-- Navbar --}}
        @include('layouts.navbar')
        {{-- END Navbar --}}

        
        {{-- Main Panel --}}
        <div class="main-panel">

          {{-- Main Content --}}
          @yield('mainContent')
          {{-- END Main Content --}}

          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © aplikasi kasir 2022</span>
            </div>
          </footer>

        </div>
        {{-- END Main Panel --}}
        

      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets_style/vendors/js/vendor.bundle.base.js"></script>

    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/assets_style/vendors/chart.js/Chart.min.js"></script>
    <script src="/assets_style/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/assets_style/vendors/flot/jquery.flot.js"></script>
    <script src="/assets_style/vendors/flot/jquery.flot.resize.js"></script>
    <script src="/assets_style/vendors/flot/jquery.flot.categories.js"></script>
    <script src="/assets_style/vendors/flot/jquery.flot.fillbetween.js"></script>
    <script src="/assets_style/vendors/flot/jquery.flot.stack.js"></script>
    <script src="/assets_style/vendors/flot/jquery.flot.pie.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets_style/js/off-canvas.js"></script>
    <script src="/assets_style/js/hoverable-collapse.js"></script>
    <script src="/assets_style/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets_style/js/dashboard.js"></script>
    <!-- End custom js for this page -->

    {{-- DataTables --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="/assets_style/datatables/jquery-datatables.js"></script>
    <script src="/assets_style/datatables/datatables.js"></script>

    <script>
      $(document).ready(function () {
          $('#tableDT').DataTable();
          $('#tableDT2').DataTable();
      });
    </script>

  </body>
</html>