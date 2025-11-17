<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Transfer Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                        <i class="fas fa-globe"></i> Inventory.
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
                        <strong>Inventory, <?php echo e($requesition->requestFrom->name); ?>.</strong><br>
                        <?php echo e($requesition->requestFrom->address); ?><br>
                        Addis Ababa, Ethiopia<br>
                        Phone: (+251) <br>
                        Email:
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong><?php echo e($requesition->requestTo->name); ?></strong><br>
                        

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    
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
                                <th>Item</th>
                                <th>P-No1</th>
                                <th>P-No2</th>
                                <th>Batch</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 0;
                                $vat = 0;
                                $total = 0;
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $reqDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $no = $no + 1;
                                    // $vat = $detail->tax;
                                    // $total = $detail->total + $detail->item->amount;
                                ?>
                                <tr>
                                    <td><?php echo e($no); ?></td>
                                    <?php
                                        $printItem = App\Models\Item::find($detail->item->item_id);
                                    ?>
                                    <td><?php echo e($detail->item->item_name); ?></td>
                                    <td><?php echo e($detail->item->product_code); ?></td>
                                    <td><?php echo e($detail->item->part_number); ?></td>
                                    <td><?php echo e($detail->batch->batch_number); ?></td>
                                    <td><?php echo e($detail->item->unit); ?></td>
                                    <td><?php echo e($detail->quantity); ?></td>
                                    
                                    
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



                </div>
                <!-- /.col -->
                <div class="col-6">

                    <div class="table-responsive">
                        
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
<?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/store/printTransfer.blade.php ENDPATH**/ ?>