<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
            <div class="row">
                <div class="col-8 lg">
                  <div class="pl-3">From <b class="text-warning"> <?php echo e($vendor); ?>'s</b> Purchase History </div>
                </div>
                <div class="col-4 lg">
                </div>
            </div>
         </div>
      </div>
        <div class="row">
              <div class="card">
                <div class="card-body text-sm">
                    
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>PurchaseDate</th>
                      <th>RefrenceNo</th>
                      <th>PurchasedBy</th>
                      <th>StoredOn</th>
                      <th>PaymentTerms</th>
                      <th>TotalPayment</th>
                      <th>View  </th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                      <?php $no= 0; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                             <?php $no= $no + 1; ?>
                             <tr>
                                <td><?php echo e($no); ?></td>
                                <td><?php echo e($dt['date']->toDateString()); ?></td>
                                <td><?php echo e($dt['RF']); ?></td>
                                <td><?php echo e($dt['owner']); ?></td>
                                <td><?php echo e($dt['location']); ?></td>
                                <td><?php echo e($dt['payment_terms']); ?></td>
                                <td><?php echo e(number_format($dt['total_payment'])); ?></td>
                                <td>
                                    <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-lg-view-<?php echo e($dt['id']); ?>">View Detail</button>
                                </td>
                             </tr>


                             <div class="modal fade" id="modal-lg-view-<?php echo e($dt['id']); ?>">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title"><?php echo e($dt['RF']); ?></h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-3">
                                                Item
                                            </div>
                                            <div class="col-3">
                                                Quantity
                                            </div>
                                            <div class="col-3">
                                                Price <small>Vat</small>
                                            </div>
                                            <div class="col-3">
                                                Total
                                            </div>
                                        </div>
                                        <hr>
                                        <?php $__empty_2 = true; $__currentLoopData = $dt['Details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchaseOrderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                          <?php if($purchaseOrderDetail['order_id'] == $dt['id']): ?>
                                            <div class="row">
                                                 <div class="col-3">
                                                    <a href=""><b><?php echo e($purchaseOrderDetail['item_code']); ?></b></a>
                                                 </div>
                                                 <div class="col-3">
                                                    <?php echo e(number_format($purchaseOrderDetail['quantity'])); ?>

                                                 </div>
                                                 <div class="col-3">
                                                    <?php echo e(number_format($purchaseOrderDetail['total'])); ?> ,<small><?php echo e($purchaseOrderDetail['tax']); ?>%</small>
                                                 </div>
                                                 <div class="col-3">
                                                    <b><?php echo e(number_format($purchaseOrderDetail['grand_total'])); ?></b>
                                                 </div>
                                            </div>
                                            <br>
                                        <?php endif; ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>

                                        <?php endif; ?>
                                    </div>

                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
                              <!-- /.modal -->

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php endif; ?>
                    </tbody>
                </table>
               </div>
                  <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/pages/purchase/vendorPurchaseHistory.blade.php ENDPATH**/ ?>