<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row pt-1">
                <div class="col-md-6">
                    <form action="<?php echo e(route('reports.dailySales')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Sales Person</label>
                                <select name="sales_person" class="form-control">
                                    <option value="">All</option>
                                    <?php $__currentLoopData = $salers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saler): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($saler); ?>" <?php echo e($salesPerson == $saler ? 'selected' : ''); ?>>
                                            <?php echo e($saler); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

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
                <div class="col-2">
                </div>
                <div class="col-md-4 pt-3">
                    <table class="table table-borderless table-sm">
                        <thead>
                        </thead>
                        <tbody>
                            
                            
                        </tbody>
                        <tfoot>
                            <tr class="text-warning">
                                <th>Total Tax</th>
                                <td>ETB <?php echo e(number_format($g_vat, 2)); ?></td>
                            </tr>
                            <tr class="text-warning">

                                <th>Total Sales</th>
                                <td>ETB <?php echo e(number_format($g_total, 2)); ?></td>
                            </tr>
                            <tr class="text-warning">

                                <th>Net Amount</th>
                                <td>ETB <?php echo e(number_format($g_total - $g_vat, 2)); ?> </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3></h3>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="background-color: rgb(3, 3, 32)">
                                <?php if($permission->manage_partNumber == 'on'): ?>
                                    <th>Part-No</th>
                                <?php endif; ?>
                                <th>ItemName</th>
                                <?php if($permission->manage_image == 'on'): ?>
                                    <th>Image</th>
                                <?php endif; ?>
                                <th>Qyt</th>
                                <th>Amount</th>
                                <th>Discount</th>
                                <th>Withholding</th>
                                <th>Tax</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $imagePath = str_replace('\\', '/', $inventory['pr_image']); // Fix backslashes
                                ?>
                                <tr>

                                    <?php if($permission->manage_partNumber == 'on'): ?>
                                        <td><?php echo e($inventory['pr_code']); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e($inventory['pr_name']); ?></td>
                                    <?php if($permission->manage_image == 'on'): ?>
                                        <td style="display: flex; align-items: center; gap: 10px;">
                                            <img src="<?php echo e(asset($imagePath)); ?>" alt=""
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">

                                        </td>
                                    <?php endif; ?>

                                    <td><?php echo e($inventory['quantity']); ?></td>
                                    <td><?php echo e($inventory['quantity'] * $inventory['amount']); ?></td>
                                    <td><?php echo e(number_format($inventory['discount'], 2)); ?></td>
                                    <td><?php echo e(number_format($inventory['withholding'], 2)); ?></td>
                                    <td><?php echo e(number_format($inventory['vat'], 2)); ?></td>
                                    
                                    <td><?php echo e(number_format($inventory['tatal'], 2)); ?></td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ims_webims/amarImsfinal/resources/views/pages/reports/daily_sales_report.blade.php ENDPATH**/ ?>