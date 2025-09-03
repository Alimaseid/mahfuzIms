<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            STOCK REPORT
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3></h3>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="background-color: rgb(3, 3, 32)">
                                <th>No</th>
                                <th>ItemName</th>
                                <th>Itemimage</th>
                                <th>Category</th>
                                <th>Shelf No</th>
                                <th>Location</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 0;
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $imagePath = str_replace('\\', '/', $stock->image); // Fix backslashes
                                ?>
                                <?php
                                    $no = $no + 1;
                                ?>
                                <td><?php echo e($no); ?></td>
                                <td><?php echo e($stock->item_name); ?></td>
                                <td style="display: flex; align-items: center; gap: 10px;">
                                    <img src="<?php echo e(asset($imagePath)); ?>" alt=""
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">

                                </td>
                                <td><?php echo e($stock->category); ?></td>
                                <td><?php echo e($stock->shelf->shelf_name ?? '-'); ?></td>
                                <td><?php echo e($stock->shelf->location->name ?? '-'); ?></td>
                                <td><?php echo e($stock->quantity); ?></td>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/reports/stock_report.blade.php ENDPATH**/ ?>