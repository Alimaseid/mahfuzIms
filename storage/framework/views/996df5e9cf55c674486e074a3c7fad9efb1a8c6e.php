<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="row p-3">
              <div class="card">
                <div class="card-body text-sm">
                    
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>RequisitionDate</th>
                      <th>Requisition#No</th>
                      <th>RequestBy</th>
                      <th>RequestFrom</th>
                      <th>Status</th>
                      <th>ItemList</th>
                      <th>IssueHere</th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                    <?php $no = 0 ; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                         <?php $no = $no + 1 ; ?>
                            <tr>
                                <td><?php echo e($no); ?></td>
                                <td><?php echo e($requisition->created_at->toDateString()); ?></td>
                                <td><?php echo e($requisition->id); ?></td>
                                <td><?php echo e($requisition->request_by); ?></td>
                                <td><?php echo e($requisition->request_from); ?></td>
                                <td> <a href="" style="color: greenyellow"><?php echo e($requisition->status); ?> </a></td>
                                <td  style="width: 50%;">
                                    <?php $__empty_2 = true; $__currentLoopData = $requisition->itemList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <?php echo e($list->item_name); ?> <i style="color: rgb(8, 239, 8)">(<?php echo e($list->quantity); ?>)</i>,
                                        <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>

                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a class="btn btn-success btn-sm"  data-toggle="modal" data-target="#modal-lg-issue<?php echo e($requisition->id); ?>">
                                        <i class="fas fa-check "></i>  Issue
                                      </a>
                                </td>

                            </tr>
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

<?php $__empty_1 = true; $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="modal fade" id="modal-lg-issue<?php echo e($requisition->id); ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Store Issue Voucher<?php echo e($requisition->id); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-default">
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <form action="issueRequisition/<?php echo e($requisition->id); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                          <h4>
                                                            <i class="fas fa-globe"></i> UKAZ, Inc.
                                                            <small class="float-right">Date : <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?></small>
                                                          </h4>
                                                        </div>
                                                        <!-- /.col -->
                                                      </div>
                                                    <div class="row invoice-info">
                                                        <div class="col-sm-4 invoice-col">
                                                          <address>
                                                            
                                                            From
                                                            <div class="form-group">
                                                                <select name="transfer_from_store"  class="form-control" id="location" required>
                                                                    <option value="">Select Here</option>
                                                                        <?php $__empty_2 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                           <option value="<?php echo e($location->id); ?>"><?php echo e($location->name); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                        <option value="">Empty Location !</option>
                                                                        <?php endif; ?>
                                                                </select>
                                                            </div>

                                                          </address>
                                                        </div>

                                                          <div class="col-sm-4 invoice-col">
                                                            <address>
                                                              
                                                              Issue By
                                                              <div class="form-group">
                                                                <input type="text" readonly value="<?php echo e(Auth::user()->name); ?>" name="issued_by" class="form-control" required>
                                                            </div>
                                                          </div>
                                                          <div class="col-sm-4 invoice-col">
                                                            Shipped By
                                                            <div class="form-group">
                                                                <input type="text"  name="ship_by" class="form-control" required>
                                                            </div>
                                                        </div>

                                                    <div class="row">

                                                        <div class="col-12 table-responsive">

                                                          <table class="table table-striped">
                                                              <tr>
                                                                  <th>ProductNameCode</th>
                                                                  <th>Quantity</th>
                                                                  <th> Select Owner</th>
                                                              </tr>
                                                            <tbody id="add_items">
                                                                <?php $__empty_2 = true; $__currentLoopData = $requisition->itemList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>

                                                              <tr>
                                                                <td style="width: 250px;">
                                                                    <input type="text" class="form-control" readonly  name="addmore[<?php echo e($list->id); ?>][item_name]" value="<?php echo e($list->item_name); ?>">

                                                                    <input type="hidden" readonly name="addmore[<?php echo e($list->id); ?>][item_id]" value="<?php echo e($list->item_id); ?>">
                                                                 </td>
                                                                  <td>
                                                                     <input type="number" readonly min="0"  name="addmore[<?php echo e($list->id); ?>][quantity]" value="<?php echo e($list->quantity); ?>" class="form-control input-group-sm" required>
                                                                  </td>
                                                                  <td>
                                                                   <select name="addmore[<?php echo e($list->id); ?>][transfer_from_owner]"  class="form-control"  required>
                                                                    
                                                                    <?php $__empty_3 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                                                       <option value="<?php echo e($owner->id); ?>"><?php echo e($owner->name); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                                                    <option value="">Empty Owner !</option>
                                                                    <?php endif; ?>
                                                                </select>
                                                                 </td>
                                                                </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>

                                                                <?php endif; ?>
                                                            </tbody>

                                                          </table>


                                                        </div><hr><br>
                                                        <!-- /.col -->
                                                      </div>

                                                </div>
                                                <!-- /.card-body -->
                                                <button type="submit" class="btn btn-primary swalDefaultSuccess">Submit</button>
                                            </form>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>


    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <?php endif; ?>

</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/issuing/issue_requisition.blade.php ENDPATH**/ ?>