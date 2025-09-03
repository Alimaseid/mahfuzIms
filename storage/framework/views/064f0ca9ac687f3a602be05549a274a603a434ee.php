<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                      INVENTORY REPORT On <i class="text-warning" style="font-weight: 800">&nbsp; <?php echo e(Carbon\Carbon::now()->toFormattedDateString()); ?></i>
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
                  <th>ItemName</th>
                  <th>ProductCode</th>
                  <th>CostPerItem</th>
                  <th >StockQuantity</th>
                  <th>InventoryValue</th>
                  <th>ReOrder (auto-fill)</th>
                  <th>ReorderLevel</th>
                </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php if($inventory['reorder_flag'] == 'Ok'): ?>
                        <tr>
                        <?php else: ?>
                        <tr style="background-color: rgb(228, 171, 14)">
                        <?php endif; ?>
                            <td><?php echo e($inventory['product_name']); ?></td>
                            <td><?php echo e($inventory['product_code']); ?></td>
                            <td>ETB <?php echo e(number_format($inventory['cost_per_item'],2)); ?></td>
                            <td><?php echo e(number_format($inventory['stock_qauntity'])); ?></td>
                            <td>ETB <?php echo e(number_format($inventory['inventory_value'],2)); ?></td>
                            <td><?php echo e($inventory['reorder_flag']); ?></td>
                            <td><?php echo e(number_format($inventory['reorder_level'])); ?></td>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/pages/reports/general_report.blade.php ENDPATH**/ ?>