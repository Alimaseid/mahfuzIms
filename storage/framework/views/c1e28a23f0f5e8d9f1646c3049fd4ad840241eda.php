


<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left"> Set Opening Balance <b>
                                    </b></div>
                            </h3>

                        </div>
                    </div>

                    <div class="card">
                        <div class="row">
                            <div class="col-10 lg">
                                <div class="card-body">
                                    <form action="/add-Opening_balance" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Item Name</label>
                                                        <input type="text" name="" class="form-control"
                                                            value="<?php echo e($item->item_name); ?>"
                                                            placeholder="<?php echo e($item->item_name); ?>" readonly>
                                                        <input type="hidden" name="item_id" class="form-control"
                                                            value="<?php echo e($item->id); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Location</label>
                                                        <select name="location_id" class="form-control" id=""
                                                            required>
                                                            <option value="">Select</option>
                                                            <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <option value="<?php echo e($location->id); ?>">
                                                                    <?php echo e($location->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Batch</label>
                                                        <select name="batch_id" class="form-control" id="batch_id"
                                                            required>
                                                            <option value="">Select</option>
                                                            <?php $__empty_1 = true; $__currentLoopData = $batchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <?php if($batch->item_id == $item->id): ?>
                                                                    <option value="<?php echo e($batch->id); ?>">
                                                                        <?php echo e($batch->batch_number); ?></option>
                                                                <?php endif; ?>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Current Stock</label>
                                                        <input type="number" name="quantity" class="form-control"
                                                            placeholder="Quantity" value="1" min="1" required>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit"
                                                    class="btn btn-primary swalDefaultSuccess">Register</button>
                                            </div>

                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>
                    </div>


                    <!-- /.card -->



                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/items/openingBalance.blade.php ENDPATH**/ ?>