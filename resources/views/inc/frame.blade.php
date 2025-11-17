<!DOCTYPE html>
<html lang="en">

<head>
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="#">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"></script>

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->

    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Home</a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    {{-- <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a> --}}
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                {{-- <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search"> --}}
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    {{-- <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a> --}}
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        {{-- <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a> --}}
                        <div class="dropdown-divider"></div>
                        {{-- <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a> --}}
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            {{-- <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a> --}}
                            {{-- <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a> --}}
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell">shop</i>
                        @if ($lowShopItems->count() > 0)
                            <span class="badge badge-warning navbar-badge">{{ $lowShopItems->count() }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">
                            {{ $lowShopItems->count() }} Low ShopStock Notifications
                        </span>

                        <div class="dropdown-divider"></div>
                        @forelse($lowShopItems as $items)
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-box mr-2"></i>
                                {{ $items->item->item_name }} is low
                                ({{ $items->quantity }})
                                <span class="float-right text-muted text-sm">Reorder Needed</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        @empty
                            <a href="#" class="dropdown-item text-muted">No low stock items 🎉</a>
                        @endforelse

                        <a href="{{ url('/shopStock_reports') }}" class="dropdown-item dropdown-footer">See All
                            Items</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell">store</i>
                        @if ($lowStockItems->count() > 0)
                            <span class="badge badge-warning navbar-badge">{{ $lowStockItems->count() }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">
                            {{ $lowStockItems->count() }} Low Stock Notifications
                        </span>

                        <div class="dropdown-divider"></div>
                        @forelse($lowStockItems as $items)
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-box mr-2"></i>
                                {{ $items->item->item_name }} is low ({{ $items->quantity }})
                                <span class="float-right text-muted text-sm">Reorder Needed</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        @empty
                            <a href="#" class="dropdown-item text-muted">No low stock items 🎉</a>
                        @endforelse

                        <a href="{{ url('/stock_reports') }}" class="dropdown-item dropdown-footer">See All Items</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light"> <i> Inventory <small><sup>System</sup></small></i></span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- SidebarSearch Form -->
                <hr>
                @php
                    $payments = 0;
                    $sales = 0;
                    $requisition = 0;
                    $sales = App\Models\SalesOrder::where('SM_status', 'Pending')->orderBy('id', 'desc')->get();
                    $requisition = App\Models\Requisition::where('status', 'Pending')->orderBy('id', 'desc')->get();
                    $payment = App\Models\PaymentLedger::where('status', 'Pending')
                        ->where('debit', '=', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();
                    if (!empty($payment)) {
                        $payments = count($payment);
                    }
                    if (!empty($sales)) {
                        $sales = count($sales);
                        $permission = App\Models\Role::where('id', Auth::user()->role)->first();
                    }
                    if (!empty($requisition)) {
                        $requisition = count($requisition);
                    }
                @endphp
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p class="text-sm">Dashboard</p>
                            </a>
                        </li>

                        </li>
                        @if ($permission != null)

                         
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p class="text-sm">
                                        Register
                                        <i class="fas fa-angle-left right"></i>
                                        <span class="badge badge-info right"></span>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if ($permission->manage_location == 'on')
                                        <li class="nav-item">
                                            <a href="location" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Business Location </p>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($permission->manage_shelf == 'on')
                                        <li class="nav-item">
                                            <a href="shelfs" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Shelfs</p>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($permission->manage_item_unit == 'on')
                                        <li class="nav-item">
                                            <a href="item_unit" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Item Unit</p>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($permission->manage_category == 'on')
                                        <li class="nav-item">
                                            <a href="category" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Category</p>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($permission->manage_item == 'on')
                                        <li class="nav-item">
                                            <a href="items" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Items</p>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($permission->manage_customer == 'on')
                                        <li class="nav-item">
                                            <a href="customers" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Customers</p>
                                            </a>
                                        </li>
                                    @endif


                                </ul>
                            </li>
                            @if ($permission->manage_good_receiving == 'on')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-file"></i>
                                        <p class="text-sm">
                                            Good Receiving
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                      @if ($permission->manage_good_receiving == 'on')
                                        <li class="nav-item">
                                            <a href="good-receiving" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">
                                                    Good Receiving
                                                </p>
                                            </a>
                                        </li>
                                        @endif
                                          @if ($permission->manage_purchase_plan == 'on')
                                        <li class="nav-item">
                                            <a href="purchase_plan" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Purchase Plan</p>
                                            </a>
                                        </li>
                                        @endif
                                          @if ($permission->manage_purchase_plan == 'on')
                                        <li class="nav-item">
                                            <a href="planned_item" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm"> Planned Item</p>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if ($permission->manage_customer == 'on')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-user-secret"></i>
                                        <p class="text-sm">
                                            Customer Management
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                      @if ($permission->manage_customer == 'on')
                                        <li class="nav-item">
                                            <a href="customers" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">
                                                    Customer
                                                </p>
                                            </a>
                                        </li>
                                        @endif
                                          @if ($permission->manage_customer_history == 'on')
                                        <li class="nav-item">
                                            <a href="customerPerformance" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Customer Performance</p>
                                            </a>
                                        </li>
                                        @endif
                                          @if ($permission->manage_dailycustomerReport == 'on')
                                        <li class="nav-item">
                                            <a href="daily-customer-report" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm"> Customer Report</p>
                                            </a>
                                        </li>
                                        @endif
                                          @if ($permission->manage_customer == 'on')
                                        <li class="nav-item">
                                            <a href="creditCustomers" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">
                                                    creditSales
                                                </p>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if ($permission->manage_item_transfer == 'on')
                                <li class="nav-item">
                                    <a href="transfer-requisition" class="nav-link">
                                        <i class="nav-icon fas fa-recycle"></i>
                                        <p class="text-sm">Transfer Requisition
                                            <span class="badge badge-warning right"></span>
                                        </p>
                                    </a>
                                </li>
                            @endif
                            @if ($permission->manage_sales == 'on')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon  fas fa-book"></i>
                                        <p class="text-sm">
                                            Sales Management
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                      @if ($permission->manage_sales == 'on')
                                        <li class="nav-item">
                                            <a href="sales-order" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">
                                                    Sales
                                                </p>
                                            </a>
                                        </li>
                                        @endif
                                          @if ($permission->manage_shopStock_reports == 'on')
                                        <li class="nav-item">
                                            <a href="shopStock_reports" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm">Shop Stock Report</p>
                                            </a>
                                        </li>
                                        @endif
                                          @if ($permission->manage_dailysalesReport == 'on')
                                        <li class="nav-item">
                                            <a href="daily-sales-report" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm"> Sales Report</p>
                                            </a>
                                        </li>
                                        @endif
                                          @if ($permission->manage_shopTRansferReports == 'on')
                                        <li class="nav-item">
                                            <a href="transfer_shop_reports" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm"> Transfer Item Report</p>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if ($permission->approval == 'on' || $permission->manage_stock_reports == 'on' || $permission->manage_storeTRansferReports == 'on')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-home"></i>
                                        <p class="text-sm">
                                            Warehouse Management
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if ($permission->approval == 'on')
                                            <li class="nav-item">
                                                <a href="orders-to-approve" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p class="text-sm">Approve SalesOrder
                                                        <span
                                                            class="badge badge-warning right">{{ $sales }}</span>
                                                    </p>
                                                </a>
                                            </li>
                                            @endif
                                             @if ($permission->approval == 'on')
                                            <li class="nav-item">
                                                <a href="approve-requisition" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p class="text-sm">ApproveRequisition
                                                        <span
                                                            class="badge badge-warning right">{{ $requisition }}</span>
                                                    </p>
                                                </a>
                                            </li>
                                        @endif
                                         @if ($permission->manage_stock_reports == 'on')
                                        <li class="nav-item">
                                            <a href="stock_reports" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm"> Stock Report</p>
                                            </a>
                                        </li>
                                        @endif
                                         @if ($permission->manage_storeTRansferReports == 'on')
                                        <li class="nav-item">
                                            <a href="transfer_warehouse_reports" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p class="text-sm"> Transfer Item Report</p>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                            @if ($permission->manage_disposal == 'on')
                                <li class="nav-item">
                                    <a href="disposals" class="nav-link">
                                        <i class="nav-icon  fas fa-file" aria-hidden="true"></i>
                                        <p class="text-sm">Disposal</p>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-header">User Management</li>
                            @if ($permission->manage_user == 'on')
                                <li class="nav-item">
                                    <a href="users" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p class="text-sm">User Management</p>
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li class="nav-header"></li>

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-user"></i>
                                <p class="text-sm">
                                    My Account
                                    <i class="fas fa-angle-left right"></i>
                                    <span class="badge badge-success right">Auth</span>

                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                    <div class="image">
                                        <img src="dist/img/avatar5.png" class="img-circle elevation-2"
                                            alt="User Image">
                                    </div>
                                    <div class="info">
                                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                                    </div>
                                </div>

                                <li class="nav-item">
                                    <a class="nav-link" href="/profile">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Edit Acount</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="nav-link" href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>LogOut</p>
                                        </a>
                                    </form>
                                </li>

                            </ul>
                        </li>
                        @if ($permission->manage_activity_log == 'on')
                            <li class="nav-item">
                                <a href="/activity-logs" class="nav-link">
                                    <i class="nav-icon  fas fa-file" aria-hidden="true"></i>
                                    <p class="text-sm">Activity Logs</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">

            @include('inc.message')
            @yield('content')
        </div>




        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>&copy; 2022-{{ \Carbon\Carbon::now()->format('Y') }} <a href="https://skylinkict.com">SkyLink
                    Technologies</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="plugins/raphael/raphael.min.js"></script>
    <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/validation.js"></script>
    <script src="dist/js/alert.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard2.js"></script>

    <!-- jQuery -->
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- AdminLTE App -->
    {{-- <script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script> --}}
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }

        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
</body>

</html>
