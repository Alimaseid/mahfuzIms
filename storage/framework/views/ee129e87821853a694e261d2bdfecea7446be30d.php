<?php $__env->startSection('content'); ?>
    <section class="content py-3">
        <div class="container-fluid">

            <!-- Header Card -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card shadow-lg border-0 rounded-lg">
                        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">

                            <div>
                                <h2 class="font-weight-bold text-primary mb-1">
                                    <i class="fas fa-cogs mr-2"></i> Item Settings Panel
                                </h2>
                                <p class="text-muted mb-0">
                                    Manage batches, shelves, stock and item movement.
                                </p>
                            </div>

                            <div class="mt-2 mt-md-0">
                                <a href="items" class="btn btn-outline-dark px-4 rounded-pill shadow-sm">
                                    <i class="fas fa-arrow-left mr-1"></i> Back
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline shadow border-0 rounded-lg">
                        <div class="card-header bg-white border-0 pt-4 pb-0">
                            <h4 class="card-title font-weight-bold text-dark">
                                <i class="fas fa-tools text-primary mr-2"></i>
                                Inventory Controls
                            </h4>
                        </div>

                        <div class="card-body">
                            <div class="row text-center">

                                <!-- Batch -->
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <a href="batchs-<?php echo e($item->id); ?>"
                                        class="btn btn-secondary btn-block p-4 rounded-lg shadow-sm">
                                        <i class="fas fa-layer-group fa-2x mb-2"></i>
                                        <div class="font-weight-bold">Set Batch</div>
                                        <small>Manage item batches</small>
                                    </a>
                                </div>

                                <!-- Shelf -->
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <a href="itemShelf-<?php echo e($item->id); ?>"
                                        class="btn btn-primary btn-block p-4 rounded-lg shadow-sm">
                                        <i class="fas fa-warehouse fa-2x mb-2"></i>
                                        <div class="font-weight-bold">Set Shelf</div>
                                        <small>Assign shelf location</small>
                                    </a>
                                </div>

                                <!-- Current Stock -->
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <a href="set_opening_balance-<?php echo e($item->id); ?>"
                                        class="btn btn-warning btn-block p-4 rounded-lg shadow-sm text-dark">
                                        <i class="fas fa-boxes fa-2x mb-2"></i>
                                        <div class="font-weight-bold">Current Stock</div>
                                        <small>Update opening balance</small>
                                    </a>
                                </div>

                                <!-- Move -->
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <button type="button" class="btn btn-info btn-block p-4 rounded-lg shadow-sm"
                                        data-toggle="modal" data-target="#modal-lgplan-<?php echo e($item->id); ?>">
                                        <i class="fas fa-random fa-2x mb-2"></i>
                                        <div class="font-weight-bold">Move Item</div>
                                        <small>Transfer inventory</small>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modal-lgplan-<?php echo e($item->id); ?>">
                <div class="modal-dialog modal-lgplan-<?php echo e($item->id); ?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Move To Plan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- jquery validation -->
                                        <div class="card card-primary">
                                            <div class="card-header">
                                            </div>
                                            <div>
                                                <form action="<?php echo e(route('purchase-plan.move', $item->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Quantity</label>
                                                                <input type="number" name="quantity" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label>Message</label>
                                                                <input type="text" name="message" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm bg-info">
                                                        submit
                                                    </button>
                                                </form>
                                            </div>
                                            <!-- /.card -->
                                        </div>

                                        <!--/.col (right) -->
                                    </div>
                                    <!-- /.row -->
                                </div><!-- /.container-fluid -->

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/items/sets.blade.php ENDPATH**/ ?>