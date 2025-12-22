<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body text-sm">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SalesDate</th>
                                    <th>InvoiceNo</th>
                                    <th>Customer</th>
                                    <th>SalesPerson</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $no = 1; ?>
                                <?php $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($no++); ?></td>
                                        <td><?php echo e($salesOrder->created_at->toDateString()); ?></td>
                                        <td><?php echo e($salesOrder->reference_number); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($c->id == $salesOrder->customer_id): ?>
                                                    <?php echo e($c->name); ?>

                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td><?php echo e($salesOrder->sales_person); ?></td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-<?php echo e($salesOrder->id); ?>">
                                                SalesDetails
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <?php if($salesOrder->SM_status == 'Accepted'): ?>
                                                    <button type="button"
                                                        class="btn btn-success btn-sm"><?php echo e($salesOrder->SM_status); ?></button>
                                                    <button type="button"
                                                        class="btn btn-success dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown">
                                                    <?php elseif($salesOrder->SM_status == 'Pending'): ?>
                                                        <button type="button"
                                                            class="btn btn-info btn-xs"><?php echo e($salesOrder->SM_status); ?></button>
                                                        <button type="button"
                                                            class="btn btn-info dropdown-toggle dropdown-icon"
                                                            data-toggle="dropdown">
                                                        <?php else: ?>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm"><?php echo e($salesOrder->SM_status); ?></button>
                                                            <button type="button"
                                                                class="btn btn-danger dropdown-toggle dropdown-icon"
                                                                data-toggle="dropdown">
                                                <?php endif; ?>
                                                <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="acceptOrder-<?php echo e($salesOrder->id); ?>">
                                                        Accepte</a>
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#modal-lg-reject-<?php echo e($salesOrder->id); ?>">Reject</a>
                                                    
                                                </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ==================== MODALS ==================== -->
                    <?php $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!-- DETAILS MODAL -->
                        <div class="modal fade" id="modal-lg-view-<?php echo e($salesOrder->id); ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php echo e($salesOrder->reference_number); ?></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <?php if($permission->manage_partNumber == 'on'): ?>
                                                            <th>Part-No1</th>
                                                        <?php endif; ?>
                                                        <?php if($permission->manage_partNumber == 'on'): ?>
                                                            <th>Part-No2</th>
                                                        <?php endif; ?>
                                                        <?php if($permission->manage_image == 'on'): ?>
                                                            <th>Image1</th>
                                                        <?php endif; ?>
                                                        <?php if($permission->manage_image == 'on'): ?>
                                                            <th>Image2</th>
                                                        <?php endif; ?>
                                                        <th>Unit</th>
                                                        <th>Category</th>
                                                        <th>Shelf</th>
                                                        <th>Batch</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $__currentLoopData = $salesOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($detail->sales_order_id == $salesOrder->id): ?>
                                                            <?php
                                                                $img1 = str_replace('\\', '/', $detail->item->image);
                                                                $img2 = str_replace('\\', '/', $detail->item->image2);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo e($detail->item->item_name); ?></td>
                                                                <?php if($permission->manage_partNumber == 'on'): ?>
                                                                    <td><?php echo e($detail->item->product_code); ?></td>
                                                                <?php endif; ?>
                                                                <?php if($permission->manage_partNumber == 'on'): ?>
                                                                    <td><?php echo e($detail->item->part_number); ?></td>
                                                                <?php endif; ?>
                                                                <?php if($permission->manage_image == 'on'): ?>
                                                                    <td>
                                                                        <img src="<?php echo e(asset($img1)); ?>"
                                                                            style="width:50px;height:50px;border-radius:5px;object-fit:cover;">
                                                                    </td>
                                                                <?php endif; ?>
                                                                <?php if($permission->manage_image == 'on'): ?>
                                                                    <td>
                                                                        <img src="<?php echo e(asset($img2)); ?>"
                                                                            style="width:50px;height:50px;border-radius:5px;object-fit:cover;">
                                                                    </td>
                                                                <?php endif; ?>
                                                                <td><?php echo e($detail->item->unit); ?></td>
                                                                <td><?php echo e($detail->item->category); ?></td>
                                                                <td><?php echo e($detail->item->shelf); ?></td>
                                                                <td><?php echo e($detail->batch->batch_number); ?></td>
                                                                <td><?php echo e(number_format($detail->quantity)); ?></td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="text-right mt-3">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal-lg-reject-<?php echo e($salesOrder->id); ?>">
                                                Reject
                                            </button>

                                            <a href="acceptOrder-<?php echo e($salesOrder->id); ?>" class="btn btn-success">
                                                Accept
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- REJECT MODAL -->
                        <div class="modal fade" id="modal-lg-reject-<?php echo e($salesOrder->id); ?>">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Reject Order <?php echo e($salesOrder->reference_number); ?></h4>
                                        <button class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>

                                    <form action="regect-order-<?php echo e($salesOrder->id); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-body">
                                            <label>Reject Reason</label>
                                            <textarea name="rejectReasone" class="form-control" required></textarea>

                                            <div class="text-right mt-3">
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </div>
                                    </form>

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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/store/orderlist.blade.php ENDPATH**/ ?>