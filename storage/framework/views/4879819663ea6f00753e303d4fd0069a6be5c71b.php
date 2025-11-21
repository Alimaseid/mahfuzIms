<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 " style="float: left"> Set Shelf <b>
                                    </b></div>
                            </h3>
                        </div>
                    </div>
                    <div class="card">
                        <div class="row">
                            <div class="col-6 lg">
                                <table class="table table-bordered table-striped "
                                    style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Shelf </th>
                                            <th>Location</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 0;
                                        ?>
                                        ItemName: <strong> <?php echo e($item->item_name); ?></strong>
                                        <?php $__currentLoopData = $itemshelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemshelf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $no = $no + 1;
                                            ?>
                                            <tr>
                                                <td><?php echo e($no); ?></td>
                                                <td><?php echo e($itemshelf->shelf->shelf_name); ?></td>
                                                <td><?php echo e($itemshelf->shelf->location->name); ?></td>
                                                <td>
                                                    <a type="button" class="btn btn-danger btn-sm"
                                                        href="delete-itemShelf-<?php echo e($itemshelf->id); ?>"
                                                        onclick="return confirm('Are you sure you ?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-6 lg">
                                <div class="card-body">
                                    <form action="/add-itemShelf" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Item Name</label>
                                                            <input type="text" class="form-control"
                                                                value="<?php echo e($item->item_name); ?>" readonly>
                                                            <input type="hidden" name="item_id"
                                                                value="<?php echo e($item->id); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Shelf</label>
                                                            <select name="shelf_id" class="form-control" id="shelf_id"
                                                                required>
                                                                <option value="">Select</option>
                                                                <?php $__empty_1 = true; $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <option value="<?php echo e($shelf->id); ?>">
                                                                        <?php echo e($shelf->shelf_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Register</button>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/items/setShelf.blade.php ENDPATH**/ ?>