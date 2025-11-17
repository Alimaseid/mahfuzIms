<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($salesOrder->customer->name); ?> | Invoice Print</title>

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
                        <strong>Inventory, <?php echo e($salesOrder->location->name); ?>.</strong><br>
                        <?php echo e($salesOrder->location->address); ?><br>
                        Addis Ababa, Ethiopia<br>
                        Phone: (+251) <br>
                        Email:
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong><?php echo e($salesOrder->customer->name); ?></strong><br>
                        Phone: <?php echo e($salesOrder->customer->phone); ?><br>
                        Email: <?php echo e($salesOrder->customer->email); ?><br>
                        Type: <?php echo e($salesOrder->customer->type); ?> <br>
                        Company: <?php echo e($salesOrder->customer->company_name); ?>


                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #<?php echo e($salesOrder->customer->reference_number); ?></b><br>
                    <br>
                    <b>Order ID:</b> <?php echo e($salesOrder->customer->id); ?><br>
                    <b>Sales Type:</b> <?php echo e($salesOrder->sales_type); ?><br>
                    <b>Sales Person:</b> <?php echo e($salesOrder->sales_person); ?>

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
                            <?php $__empty_1 = true; $__currentLoopData = $salesOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                    <td><?php echo e($detail->amount); ?></td>
                                    <td><?php echo e($detail->amount * $detail->quantity); ?></td>
                                    
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
                        <table class="table">

                            <tr>
                                <th>discount:</th>
                                <td><?php echo e($salesOrder->discount); ?> </td>
                            </tr>
                            <tr>
                                <th>Tax: </th>
                                <td><?php echo e($salesOrder->vat); ?> </td>
                            </tr>
                            <tr>
                                <th>WithHolding:</th>
                                <td><?php echo e($salesOrder->with_holding); ?> </td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td><?php echo e($salesOrder->grand_total); ?> </td>
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
<?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/sales/invoice.blade.php ENDPATH**/ ?>