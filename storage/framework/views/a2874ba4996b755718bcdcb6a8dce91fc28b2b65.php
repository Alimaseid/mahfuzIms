<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row p-3">
                <div class="card">
                    <div class="card-body text-sm">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>RequisitionDate</th>
                                    <th>RequestFrom</th>
                                    <th>RequestBy</th>
                                    <th>RequestTo</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0 ; ?>
                                <?php $__empty_1 = true; $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $no++ ; ?>
                                    <tr>
                                        <td><?php echo e($no); ?></td>
                                        <td><?php echo e($requisition->created_at->toDateString()); ?></td>
                                        <td><?php echo e($requisition->requestFrom->name ?? '-'); ?></td>
                                        <td><?php echo e($requisition->request_by); ?></td>
                                        <td><?php echo e($requisition->requestTo->name ?? '-'); ?></td>
                                        <td><?php echo e($requisition->status); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-<?php echo e($requisition->id); ?>">
                                                View
                                            </button>
                                        </td>
                                        <td>
                                            <a href="approveRequisition/<?php echo e($requisition->id); ?>/<?php echo e(Auth::user()->name); ?>"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No Requisitions Found!</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ==================== MODALS ==================== -->
                    <?php $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="modal fade" id="modal-lg-view-<?php echo e($requisition->id); ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Requisition #<?php echo e($requisition->id); ?></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Part no1</th>
                                                        <th>Part no2</th>
                                                        <th>Image1</th>
                                                        <th>Image2</th>
                                                        <th>Unit</th>
                                                        <th>Category</th>
                                                        <th>Shelf</th>
                                                        <th>Batch</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $requisitionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($detail->requisition_id == $requisition->id): ?>
                                                            <?php
                                                                $img1 = str_replace('\\', '/', $detail->item->image);
                                                                $img2 = str_replace('\\', '/', $detail->item->image2);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo e($detail->item->item_name); ?></td>
                                                                <td><?php echo e($detail->item->product_code); ?></td>
                                                                <td><?php echo e($detail->item->part_number); ?></td>
                                                                <td><img src="<?php echo e(asset($img1)); ?>"
                                                                        style="width:60px;height:60px;border-radius:5px;object-fit:cover;">
                                                                </td>
                                                                <td><img src="<?php echo e(asset($img2)); ?>"
                                                                        style="width:60px;height:60px;border-radius:5px;object-fit:cover;">
                                                                </td>
                                                                <td><?php echo e($detail->item->unit); ?></td>
                                                                <td><?php echo e($detail->item->category); ?></td>
                                                                <td>
                                                                    <?php $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($shelff->shelf->business_locations_id == $requisition->request_from && $detail->item_id == $shelff->item_id): ?>
                                                                            <?php echo e($shelff->shelf->shelf_name ?? '-'); ?>

                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </td>
                                                                <td><?php echo e($detail->batch->batch_number ?? '-'); ?></td>
                                                                <td><?php echo e(number_format($detail->quantity)); ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/store/approve_requisition.blade.php ENDPATH**/ ?>