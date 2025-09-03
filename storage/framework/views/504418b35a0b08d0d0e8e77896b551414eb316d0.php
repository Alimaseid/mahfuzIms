<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="container-fluid">
     <div class="row pt-1">
         <div class="col-md-6">
            <form action="daily-customer-report" method="POST">
                <?php echo csrf_field(); ?>
             <div class="row">

               <div class="col-sm-4">
                <label for="">Date</label>
                  <input type="date" name='report_date'class="form-control" value="<?php echo e($date); ?>" required>
               </div>
               <div class="col-sm-2">
                <hr>
                <button type="submit" class="btn btn-sm btn-warning ">Go</button>
             </div>
             </div>
            </form>
         </div>
         <div class="col-2">
         </div>
         <div class="col-md-4 pt-3" >
               <table class="table table-borderless table-sm">
               <thead>
               </thead>
               <tbody>
                
                 <tr>
                  <th>Sales Tax</th>
                  <td >ETB <?php echo e(0); ?></td>
               </tr>
               </tbody>
               <tfoot>
                <tr class="text-warning">
                    <th>Total Sales</th>
                    <td >ETB <?php echo e(number_format($dialyTotal,2)); ?></td>
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
                  <th>CustomerName</th>
                  <th>TotalSalesAmount</th>
                  <th style="width:70%">Description</th>
                </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                     <tr>
                        <?php $__empty_2 = true; $__currentLoopData = $sale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <td><?php echo e($salesDetail->customer->name); ?></td>
                            <td><?php echo e(number_format($sale->sum('grand_total'),2)); ?></td>
                            <?php break; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <?php endif; ?>
                        <td>
                         <?php $__empty_2 = true; $__currentLoopData = $sale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <?php $__empty_3 = true; $__currentLoopData = $salesDetail->salesDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                            <small><?php echo e($detail->item->item_name); ?>(<?php echo e(number_format($detail->quantity)); ?> x <?php echo e(number_format($detail->amount / $detail->quantity )); ?>), &nbsp;&nbsp;</small>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <?php endif; ?>
                        </td>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/reports/daily_customer_report.blade.php ENDPATH**/ ?>