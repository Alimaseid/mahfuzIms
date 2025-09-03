<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="container-fluid">
     <div class="row pt-1">
        <div class="col-md-2"></div>
         <div class="col-md-10">
            <form action="customerPerformance" method="POST">
             <?php echo csrf_field(); ?>
             <div class="row">
                <div class="col-sm-4">
                    <h5 class="text-warning">Customer Performance</h5>
                </div>
               <div class="col-sm-1">
                  <label for="" style="float:right">From</label>
               </div>
                <div class="col-sm-2">
                  <input type="date" name="from" class="form-control" value="<?php echo e($from); ?>" max="<?php echo e(Carbon\Carbon::now()->subDay()->toDateString()); ?>">
               </div>
               <div class="col-sm-1">
                <label for="" style="float:right">To</label>
             </div>
               <div class="col-sm-2">
                  <input type="date"  name="to" class="form-control" value="<?php echo e($to); ?>" max="<?php echo e(Carbon\Carbon::now()->toDateString()); ?>">
               </div>
               <div class="col-sm-2">
                <button type="submit" class="btn btn-sm btn-warning">Go</button>
             </div>
             </div>
            </form>
         </div>
     </div>
        <div class="row">
           <div class="col-md-12">
            <h3></h3>

            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr style="background-color: rgb(3, 3, 32)">
                  <th>No</th>
                  <th>CustomeName</th>
                  <th >Phone</th>
                  <th>Quantity(avg)</th>
                  <th>Total<small>(Qyt)</small></th>
                  <th>TotalAmount</th>
                  <th>TRP</th>
                </tr>
                </thead>
                <tbody>
                     <?php $no = 0;?>
                     <?php $__empty_1 = true; $__currentLoopData = $performance_final_summery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pfs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                     <?php ++$no;?>
                        <tr>
                           <td><?php echo e($no); ?></td>
                           <td><?php echo e($pfs['customer_name']); ?></td>
                            <td><?php echo e($pfs['phone']); ?></td>
                            <td><?php echo e(number_format(100 * $pfs['qyt'] / $g_total,2)); ?> %</td>
                            <td><?php echo e(number_format($pfs['qyt'])); ?></td>
                            <td>ETB <?php echo e(number_format($pfs['total'],2)); ?></td>
                            <?php if($no == 1): ?>
                            <td><i class="fa fa-trophy" style="color:gold;"></i></td>
                            <?php elseif($no == 2): ?>
                            <td><i class="fa fa-trophy" style="color:silver"></i></td>
                            <?php elseif($no == 3): ?>
                            <td><i class="fa fa-trophy" style="color:red"></i></td>
                            <?php else: ?>
                            <td><i class="fa fa-bookmark" aria-hidden="true"></i></td>
                            <?php endif; ?>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/pages/reports/customer_perfoormance.blade.php ENDPATH**/ ?>