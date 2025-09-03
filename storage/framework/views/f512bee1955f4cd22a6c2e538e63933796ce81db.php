<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="container-fluid">
     <div class="row pt-1">
         <div class="col-md-6">
            <form action="daily-sales-report" method="POST">
                <?php echo csrf_field(); ?>
             <div class="row">
               <div class="col-sm-6">
               <label for="">Sales Porson</label>
                <select name="sales_person" id="" class="form-control" >
                 <?php if($salesPerson == ''): ?>
                      <option value="">All</option>
                 <?php endif; ?>
                     <?php $__empty_1 = true; $__currentLoopData = $salers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $saler): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                     <option value="<?php echo e($saler); ?>"><?php echo e($saler); ?></option>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                     <?php endif; ?>
                 </select>
               </div>
               <div class="col-sm-4">
                <label for="">Date</label>
                  <input type="date" name='report_date'class="form-control" value="<?php echo e(Carbon\Carbon::now()->toDateString()); ?>" max="<?php echo e(Carbon\Carbon::now()->toDateString()); ?>" required>
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
                  <td >ETB <?php echo e(number_format($g_tax,2)); ?></td>
               </tr>
               </tbody>
               <tfoot>
                <tr class="text-warning">
                    <th>Total Sales</th>
                    <td >ETB <?php echo e(number_format($g_total,2)); ?></td>
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
                  <th>ItemCode</th>
                  <th>ItemName</th>
                  <th>UnitPrice<small>(avg)</small></th>
                  <th >Qyt</th>
                  <th>Amount</th>
                  <th>TaxRate<small>(avg)</small></th>
                  <th>Tax</th>
                  <th>Total</th>
                </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                           <td><?php echo e($inventory['pr_code']); ?></td>
                            <td><?php echo e($inventory['pr_name']); ?></td>
                            <td><?php echo e(number_format($inventory['avg_unit_price'],2)); ?></td>
                            <td><?php echo e($inventory['quantity']); ?></td>
                            <td><?php echo e(number_format($inventory['amount'],2)); ?></td>
                            <td><?php echo e(number_format($inventory['avg_tax_rate'],2)); ?></td>
                            <td><?php echo e(number_format($inventory['tax'],2)); ?></td>
                            <td><?php echo e(number_format($inventory['tatal'],2)); ?></td>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/pages/reports/daily_sales_report.blade.php ENDPATH**/ ?>