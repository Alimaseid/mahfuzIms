<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo e($invoice_data['customer']['name']); ?> | Invoice Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <i class="fas fa-globe"></i> UKAZ.
          <small class="float-right">Date: <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong>UKAZ, <?php echo e($invoice_data['location']['name']); ?>.</strong><br>
          <?php echo e($invoice_data['location']['address']); ?><br>
          Addis Ababa, Ethiopia<br>
          Phone: (+251) 934-515656<br>
          Email: info@ims.com
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo e($invoice_data['customer']['name']); ?></strong><br>
          Phone: <?php echo e($invoice_data['customer']['phone']); ?><br>
          Email: <?php echo e($invoice_data['customer']['email']); ?><br>
          Type: <?php echo e($invoice_data['customer']['type']); ?> <br>
          Company: <?php echo e($invoice_data['customer']['company_name']); ?>


        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice #<?php echo e($invoice_data['order']['reference_number']); ?></b><br>
        <br>
        <b>Order ID:</b> <?php echo e($invoice_data['order']['id']); ?><br>
        <b>Sales Type:</b> <?php echo e($invoice_data['order']['sales_type']); ?><br>
        <b>Sales Person:</b> <?php echo e($invoice_data['order']['sales_person']); ?>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>#NO</th>
            <th>Product</th>
            <th>Code</th>
            <th>Quantity</th>
            <th>unitPrice</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
            <?php
                $no = 0;
                $vat = 0;
                $total = 0;
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $invoice_data['salesDetail']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $no = $no + 1;
                $vat = $item->tax;
                $total = $total + $item->amount;
            ?>
            <tr>
                <td><?php echo e($no); ?></td>
                <td>
                    <?php
                        $printItem = App\Models\Item::find($item->item_id);
                    ?>
                    <?php echo e($printItem->item_name); ?>

                </td>
                <td><?php echo e($item->item_name); ?></td>
                <td><?php echo e($item->quantity); ?></td>
                <td><?php echo e(number_format($item->amount / $item->quantity)); ?></td>
                <td><?php echo e(number_format($item->amount)); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>

          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <p class="lead">Payment Methods:</p>
        <img src="../../dist/img/credit/abby.jpg" alt="Abyssina">
        <img src="../../dist/img/credit/cbe.jpg" alt="CBE">
        <img src="../../dist/img/credit/hij.jpg" alt="Hijra">
        <img src="../../dist/img/credit/hbr.jpg" alt="Hibret">

        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
            There are various methods of receiving payment for products sold in this company,
             the selection of which is usually determined by your Comfort to pay.
        </p>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Amount Due <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?></p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td><?php echo e(number_format($total)); ?> </td>
            </tr>
            <tr>
              <th>Tax (<?php echo e($vat); ?>%)</th>
              <td><?php echo e(number_format($total * $vat / 100)); ?> </td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><?php echo e(number_format($total + ($total * $vat / 100))); ?> </td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
<?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/pages/sales/invoice.blade.php ENDPATH**/ ?>