<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row p-3">
                <div class="card">
                    <div class="card-body text-sm">
                        
                        <table id="example1" class="table table-bordered table-striped"
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>RequisitionDate</th>
                                    <th>RequestFrom</th>
                                    <th>RequestBy</th>
                                    <th>RequestTo</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                <?php $no = 0 ; ?>
                                <?php $__empty_1 = true; $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $no = $no + 1 ; ?>
                                    <tr>
                                    <tr>
                                        <td><?php echo e($no); ?></td>
                                        <td><?php echo e($requisition->created_at->toDateString()); ?></td>
                                        <td><?php echo e($requisition->requestFrom->name ?? '-'); ?></td>
                                        <td><?php echo e($requisition->request_by); ?></td>
                                        <td><?php echo e($requisition->requestTo->name ?? '-'); ?></td>

                                        <td> <a href=""><?php echo e($requisition->status); ?> </a></td>
                                        <td style="">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-<?php echo e($requisition->id); ?>">
                                                view
                                            </button>
                                        </td>

                                        <td>
                                            <a href="approveRequisition/<?php echo e($requisition->id); ?>/<?php echo e(Auth::user()->name); ?>"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-check "></i>
                                            </a>
                                        </td>
                                        
                                    </tr>
                                    <div class="modal fade" id="modal-lg-view-<?php echo e($requisition->id); ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            Item
                                                        </div>
                                                        <div class="col">
                                                            Part no1
                                                        </div>
                                                        <div class="col">
                                                            Part no2
                                                        </div>
                                                        <div class="col">
                                                            Image1
                                                        </div>
                                                        <div class="col">
                                                            Image2
                                                        </div>
                                                        <div class="col">
                                                            unit
                                                        </div>
                                                        <div class="col">
                                                            Category
                                                        </div>
                                                        <div class="col">
                                                            Shelf
                                                        </div>
                                                        <div class="col">
                                                            Batch
                                                        </div>
                                                        <div class="col">
                                                            Quantity
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <?php
                                                        $total = 0;
                                                    ?>
                                                    <?php $__empty_2 = true; $__currentLoopData = $requisitionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisitionDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                        <?php if($requisitionDetail->requisition_id == $requisition->id): ?>
                                                            <?php
                                                                $imagePath1 = str_replace(
                                                                    '\\',
                                                                    '/',
                                                                    $requisitionDetail->item->image,
                                                                );
                                                                $imagePath2 = str_replace(
                                                                    '\\',
                                                                    '/',
                                                                    $requisitionDetail->item->image2,
                                                                );
                                                            ?>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->item_name); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->product_code); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->part_number); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <img src="<?php echo e(asset($imagePath1)); ?>" alt=""
                                                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">

                                                                </div>
                                                                <div class="col">
                                                                    <b> <img src="<?php echo e(asset($imagePath2)); ?>" alt=""
                                                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">
                                                                    </b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->unit); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->category); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <b>
                                                                        <?php $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if(
                                                                                $shelff->shelf->business_locations_id == $requisition->request_from &&
                                                                                    $requisitionDetail->item_id == $shelff->item_id): ?>
                                                                                <?php echo e($shelff->shelf->shelf_name ?? '-'); ?>

                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->batch->batch_number ?? ''); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <?php echo e(number_format($requisitionDetail->quantity)); ?>

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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/store/approve_requisition.blade.php ENDPATH**/ ?>