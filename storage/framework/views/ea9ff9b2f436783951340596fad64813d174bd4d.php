<?php $__env->startSection('content'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left">ItemUnit :<b>
                                        <?php echo e(count($item_units)); ?></b></div>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New Item Unit
                            </button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="row">
                            <div class="col-8 lg">
                                <div class="card-body">
                                    
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Item Unit</th>
                                                <th>_________</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($item_units) > 0): ?>
                                                <?php
                                                    $no = 0;
                                                ?>
                                                <?php $__currentLoopData = $item_units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $no = $no + 1;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo e($no); ?></td>
                                                        <td><?php echo e($item_unit->unit); ?></td>

                                                        <td>

                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal-lg-<?php echo e($item_unit->id); ?>">
                                                                <i class="fas fa-edit "></i>
                                                            </button>
                                                            <a type="button" class="btn btn-danger btn-sm"
                                                                href="delete-item_unit-<?php echo e($item_unit->id); ?>"
                                                                onclick="return confirm('Are you sure you ?');">
                                                                <i class="fas fa-trash "></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="modal-lg-<?php echo e($item_unit->id); ?>">
                                                        <div class="modal-dialog modal-lg-<?php echo e($item_unit->id); ?>">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Item Unit</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
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
                                                                                        <h3 class="card-title">Item Unit
                                                                                            <small></small>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <!-- form start -->
                                                                                    <form
                                                                                        action="/edit-item_unit-<?php echo e($item_unit->id); ?>"
                                                                                        method="POST" id="quickForm">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <div class="card-body">
                                                                                            <div class="form-group">
                                                                                                <label>Unit</label>
                                                                                                <input type="text"
                                                                                                    name="unit"
                                                                                                    class="form-control"
                                                                                                    value="<?php echo e($item_unit->unit); ?>"
                                                                                                    required>
                                                                                            </div>

                                                                                        </div>

                                                                                        <div
                                                                                            class="modal-footer justify-content-between">
                                                                                            <button type="button"
                                                                                                class="btn btn-default"
                                                                                                data-dismiss="modal">Close</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary swalDefaultSuccess"
                                                                                                onclick="return confirm('Are you sure you want to save changes ?');">Save
                                                                                                Change</button>
                                                                                        </div>
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
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <h2>No Item Unit Found !</h2>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>
                    </div>


                    <!-- /.card -->
                    <div class="modal fade" id="modal-lg">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">New Item Unit</h4>
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
                                                        <h3 class="card-title">Item Unit <small>Information</small></h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form action="/add-item_unit" method="POST" id="quickForm">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Unit</label>
                                                                <input type="text" name="unit" class="form-control"
                                                                    placeholder="Item Unit">
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
                    <!-- /.modal -->


                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/item_unit/unit.blade.php ENDPATH**/ ?>