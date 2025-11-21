<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row pt-1">
                <div class="col-md-6">
                    <form action="<?php echo e(route('reports.goodReceiving')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-4"></div>

                            <div class="col-sm-3">
                                <label>From</label>
                                <input type="date" name="from_date" value="<?php echo e($fromDate->format('Y-m-d')); ?>"
                                    class="form-control">
                            </div>

                            <div class="col-sm-3">
                                <label>To</label>
                                <input type="date" name="to_date" value="<?php echo e($toDate->format('Y-m-d')); ?>"
                                    class="form-control">
                            </div>

                            <div class="col-sm-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-warning btn-sm">Go</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-2"></div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <table id="example1" class="table table-bordered table-striped "
                        style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Receiving Date</th>
                                <th>Item</th>
                                <th>Batch</th>
                                <th>Location</th>
                                <th>Invoice No</th>
                                <th>Cost Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $goodReceivings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $gr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($gr->receiving_date->format('Y-m-d')); ?></td>
                                    <td><?php echo e($gr->item->item_name ?? '-'); ?></td>
                                    <td><?php echo e($gr->batch->batch_number ?? '-'); ?></td>
                                    <td><?php echo e($gr->location->name ?? '-'); ?></td>
                                    <td><?php echo e($gr->invoice_no); ?></td>
                                    <td><?php echo e(number_format($gr->cost_price, 2)); ?></td>
                                    <td><?php echo e($gr->quantity); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No records found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/goodreceiving/goodReceiving_report.blade.php ENDPATH**/ ?>