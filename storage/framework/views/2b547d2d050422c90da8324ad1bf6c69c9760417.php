<!DOCTYPE html>
<html lang="en">
<head>
  <!-- PWA  -->
  <meta name="theme-color" content="#6777ef"/>
  <link rel="apple-touch-icon" href="<?php echo e(asset('ukaz512.png')); ?>">
  <link rel="manifest" href="<?php echo e(asset('/manifest.json')); ?>">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UKAZ</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
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
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          
          <div class="dropdown-divider"></div>
          
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="https://t.me/Habib_y" class="brand-link">
      <img src="dist/img/ukaz.jpg" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: .9">
      <span class="brand-text font-weight-light"> <i> UKAZ <small><sup>Trading</sup></small></i></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- SidebarSearch Form -->
    <hr>
            <?php
                    $payments = 0;
                    $sales = 0;
                    $sales = App\Models\SalesOrder::where('SM_status','Pending')->orderBy('id', 'desc')->get();
                    $payment  = App\Models\PaymentLedger::where('status','Pending')->where('debit','=',0)->orderBy('created_at','desc')->get();
                    if(!empty($payment)){
                        $payments = count($payment);
                    }
                    if(!empty($sales)){
                        $sales = count($sales);
                     $permission = App\Models\Role::where('id',Auth::user()->role)->first();
                    }
            ?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p class="text-sm">Dashboard</p>
            </a>
          </li>

          </li>
    <?php if($permission != null): ?>

         <?php if($permission->reports  == 'on'): ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p class="text-sm">
                Reports
                <i class="fas fa-angle-left right"></i>
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
                 <li class="nav-item">
                   <a href="daily-sales-report" class="nav-link">
                     <i class="far fa-circle nav-icon"></i>
                     <p class="text-sm">Daily Sales Report</p>
                   </a>
                 </li>
                 <li class="nav-item">
                    <a href="daily-customer-report" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p class="text-sm">Daily Customer Report</p>
                    </a>
                  </li>
                 <li class="nav-item">
                    <a href="inventory-reports" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p class="text-sm">Inventory Report</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="customerPerformance" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p class="text-sm">Customer Performance</p>
                    </a>
                  </li>
            </ul>
          </li>
         <?php endif; ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p class="text-sm" >
                Register
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
             <?php if($permission->manage_purchase  == 'on'): ?>
              <li class="nav-item">
                <a href="location" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="text-sm">Business Location </p>
                </a>
              </li>
              <?php endif; ?>
             <?php if($permission->manage_item  == 'on'): ?>
              <li class="nav-item">
                <a href="items" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="text-sm">Items</p>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </li>
          <?php if($permission->manage_purchase  == 'on'): ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p class="text-sm">
                Purchase
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">2</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="purchase-orders" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="text-sm">
                    Purchase Orders
                  </p>
                </a>
              </li> <li class="nav-item">
                <a href="vendors" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p class="text-sm">
                    Vendors
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <?php endif; ?>

          <?php if($permission->manage_customer  == 'on'): ?>
          <li class="nav-item">
            <a href="customers" class="nav-link">
                <i class="nav-icon fa fa-user-secret" aria-hidden="true"></i>
              <p class="text-sm">Customers</p>
            </a>
          </li>
          <?php endif; ?>
          <?php if($permission->manage_sales  == 'on'): ?>
          <li class="nav-item">
            <a href="sales-order" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p class="text-sm">Sales Order
                    <span class="badge badge-warning right">New</span>
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="transfer-requisition" class="nav-link">
                <i class="nav-icon fas fa-recycle"></i>
                <p class="text-sm">Transfer Requisition
                    <span class="badge badge-warning right"></span>
                </p>
            </a>
        </li>
          <?php endif; ?>

          <li class="nav-header">Approval</li>
          <?php if($permission->manage_order  == 'on'): ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p class="text-sm">
                Store Manager
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="orders-to-approve" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Orders
                        <span class="badge badge-warning right"><?php echo e($sales); ?></span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="approve-requisition" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">ApproveRequisition
                    </p>
                </a>
            </li>
            </ul>
          </li>
        <?php endif; ?>
        <?php if($permission->approval  == 'on'): ?>
          <li class="nav-item">
            <a href="payment approval" class="nav-link">
                <i class="nav-icon fas fa-filter"></i>
              <p class="text-sm">
               Payment Approval
                
                <span class="badge badge-warning right"><?php echo e($payments); ?></span>
              </p>
            </a>
          </li>
          <?php endif; ?>
         <?php if($permission->manage_store_issue  == 'on'): ?>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p class="text-sm">
                Issuing
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="issuing-item" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Orders Issuing
                        
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="requisition-issue" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p class="text-sm">Requisition Issuing
                    </p>
                </a>
            </li>
            </ul>
          </li>
          <?php endif; ?>
          <?php if($permission->manage_user  == 'on'): ?>
          <li class="nav-item">
            <a href="users" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p class="text-sm">User Management</p>
            </a>
          </li>
          <?php endif; ?>
       <?php endif; ?>
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
                      <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                      <a href="#" class="d-block"><?php echo e(Auth::user()->name); ?></a>
                    </div>
                </div>

              <li class="nav-item">
                <a class="nav-link"
                href="/profile">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Edit Acount</p>
                </a>
              </li>
              <li class="nav-item">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <a class="nav-link"  href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="far fa-circle nav-icon"></i>
                    <p>LogOut</p>
                    </a>
                </form>
              </li>

            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">

    <?php echo $__env->make('inc.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
  </div>




 <!-- Control Sidebar -->
 <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>&copy; 2022-<?php echo e(\Carbon\Carbon::now()->format('Y')); ?> <a href="https://skylinkict.com">SkyLink Technologies</a>.</strong>
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

<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
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

<script src="<?php echo e(asset('/sw.js')); ?>"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }

    $(function () {
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
<?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/inc/frame.blade.php ENDPATH**/ ?>