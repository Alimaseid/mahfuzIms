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
                      <th></th>
                      <th></th>
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
                                <td> <a href=""><?php echo e($requisition->status); ?> </a></td>
                                <td  style="width: 50%;">
                                    <?php $__empty_2 = true; $__currentLoopData = $requisition->itemList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <?php echo e($list->item_name); ?> <i style="color: rgb(8, 239, 8)">(<?php echo e($list->quantity); ?>)</i>,
                                        <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>

                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="approveRequisition/<?php echo e($requisition->id); ?>/<?php echo e(Auth::user()->name); ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-check "></i>
                                      </a>
                                </td>
                                <td>
                                    <a href="rejectRequisition-<?php echo e($requisition->id); ?>" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash "></i>
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
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/store/approve_requisition.blade.php ENDPATH**/ ?>