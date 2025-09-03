<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
              <div class="card">
                <div class="card-body text-sm">
                    
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>SalesDate</th>
                      <th>InvoiceNo</th>
                      <th>CustomerName</th>
                      <th>SalesFrom</th>
                      <th>SalesPerson</th>
                      <th>View  </th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                        <?php if(count($salesOrders) > 0): ?>
                        <?php
                            $no = 0;
                        ?>
                        <?php $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $no = $no + 1;
                        ?>
                         <tr>
                            <td><?php echo e($no); ?></td>
                            <td><?php echo e($salesOrder->created_at->toDateString()); ?></td>
                            <td><?php echo e($salesOrder->reference_number); ?></td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($customer->id == $salesOrder->customer_id): ?>
                                    <?php echo e($customer->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($businessLocation->id == $salesOrder->location_id): ?>
                                    <?php echo e($businessLocation->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($salesOrder->sales_person); ?></td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg-view-<?php echo e($salesOrder->id); ?>">
                                        SalesDetails
                                 </button>
                              
                            </td>
                            <td>
                                <div class="btn-group">
                                    <?php if($salesOrder->SM_status == 'Accepted'): ?>
                                    <button type="button" class="btn btn-success btn-sm"><?php echo e($salesOrder->SM_status); ?></button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <?php elseif($salesOrder->SM_status == 'Pending'): ?>
                                    <button type="button" class="btn btn-info btn-xs"><?php echo e($salesOrder->SM_status); ?></button>
                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <?php else: ?>
                                    <button type="button" class="btn btn-danger btn-sm"><?php echo e($salesOrder->SM_status); ?></button>
                                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <?php endif; ?>
                                      <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="acceptOrder-<?php echo e($salesOrder->id); ?>">
                                    Accepte</a>
                                      <a class="dropdown-item" data-toggle="modal" data-target="#modal-lg-reject-<?php echo e($salesOrder->id); ?>">Reject</a>
                                      
                                  </div>
                            </td>

                        </tr>
                          <!-- /.card -->

                          <div class="modal fade" id="modal-lg-view-<?php echo e($salesOrder->id); ?>">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title"><?php echo e($salesOrder->reference_number); ?></h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-4">
                                            Item
                                        </div>
                                        <div class="col-2">
                                           <small>order</small> Qyt
                                        </div>
                                        <div class="col-2">
                                            <small>Available</small> Qyt
                                        </div>
                                        <div class="col-2">
                                            <small>Ramain</small> Qyt
                                        </div>
                                        <div class="col-2">
                                            <small>isOnShop</small>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php
                                       $total = 0;
                                    ?>
                                    <?php $__empty_1 = true; $__currentLoopData = $salesOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                     <?php if($salesOrderDetail->sales_order_id == $salesOrder->id): ?>
                                     <?php
                                       $total = $total + $salesOrderDetail->total
                                     ?>
                                        <div class="row">
                                             <div class="col-4">
                                                <a href=""><b><?php echo e($salesOrderDetail->item_name); ?></b></a>
                                             </div>
                                             <div class="col-2">
                                                <?php echo e(number_format($salesOrderDetail->quantity)); ?>

                                             </div>
                                             <div class="col-2">
                                             <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($item->id == $salesOrderDetail->item_id): ?>
                                                <?php echo e(number_format( $item->quantity + $salesOrderDetail->quantity)); ?>

                                                <?php endif; ?>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </div>
                                             <div class="col-2">
                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($item->id == $salesOrderDetail->item_id): ?>
                                                  <b> <?php echo e(number_format( $item->quantity)); ?> </b>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </div>
                                             <div class="col-2">
                                                 <?php if($salesOrderDetail->owner_id == 666): ?>
                                                   <i class="text-success">Yes</i>
                                                  <?php else: ?>
                                                   <i class="text-info">No</i>
                                                 <?php endif; ?>
                                             </div>
                                        </div>
                                        <br>

                                     <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                    <?php endif; ?>
                                    <div class="row no-print">
                                        <div class="col-12">
                                          <a  rel="noopener" class="btn btn-danger" data-toggle="modal" data-target="#modal-lg-reject-<?php echo e($salesOrder->id); ?>">Reject</a>
                                          <a  href="acceptOrder-<?php echo e($salesOrder->id); ?>"class="btn btn-success float-right"> Accept</a>

                                        </div>
                                    </div>
                                </div>

                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <!-- /.modal -->

                          <div class="modal fade" id="modal-lg-reject-<?php echo e($salesOrder->id); ?>">
                            <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title"><?php echo e($salesOrder->reference_number); ?></h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="regect-order-<?php echo e($salesOrder->id); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                    <div class="modal-body">
                                        <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">I reject this order due to this reasone</label>
                                                <textarea name="rejectReasone"  class="form-control" id="" placeholder="reasone..."></textarea>                                    </div>
                                            </div>
                                        </div>
                                        </br>
                                        <div class="row no-print">
                                            <div class="col-12">
                                              <button type="submit" class="btn btn-success float-right"> Save</a>
                                             </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          <!-- /.modal-content -->
                         </div>
                            <!-- /.modal-dialog -->
                        </div>
                          <!-- /.modal -->

                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php else: ?>
                           <h2>No salesOrder Found !</h2>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/store/orderlist.blade.php ENDPATH**/ ?>