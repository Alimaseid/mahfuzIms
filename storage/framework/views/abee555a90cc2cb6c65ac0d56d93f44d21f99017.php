<?php $__env->startSection('content'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left">Shelfs :<b>
                                        <?php echo e(count($shelfs)); ?></b></div>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New Shelf
                            </button>
                        </div>
                    </div>
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="row">
                            <div class="col-8 lg">
                                <div class="card-body">
                                    
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ShelfName</th>
                                                <th>LocationName</th>

                                                <th>_________</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($shelfs) > 0): ?>
                                                <?php
                                                    $no = 0;
                                                ?>
                                                <?php $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $no = $no + 1;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo e($no); ?></td>
                                                        <td><?php echo e($shelf->shelf_name); ?></td>
                                                        <td><?php echo e($shelf->location->name); ?></td>

                                                        <td>

                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal-lg-<?php echo e($shelf->id); ?>">
                                                                <i class="fas fa-edit "></i>
                                                            </button>
                                                            <a type="button" class="btn btn-danger btn-sm"
                                                                href="delete-shelf-<?php echo e($shelf->id); ?>"
                                                                onclick="return confirm('Are you sure you ?');">
                                                                <i class="fas fa-trash "></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="modal-lg-<?php echo e($shelf->id); ?>">
                                                        <div class="modal-dialog modal-lg-<?php echo e($shelf->id); ?>">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit shelf</h4>
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
                                                                                        <h3 class="card-title">Shelf
                                                                                            <small>Information</small>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <!-- form start -->
                                                                                    <form
                                                                                        action="/edit-shelf-<?php echo e($shelf->id); ?>"
                                                                                        method="POST" id="quickForm">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <div class="card-body">
                                                                                            <div class="form-group">
                                                                                                <label>Name</label>
                                                                                                <input type="text"
                                                                                                    name="shelf_name"
                                                                                                    class="form-control"
                                                                                                    value="<?php echo e($shelf->shelf_name); ?>"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label>Location</label>
                                                                                                <select
                                                                                                    name="business_locations_id"
                                                                                                    id=""
                                                                                                    class="form-control"
                                                                                                    required>
                                                                                                    <option
                                                                                                        value="<?php echo e($shelf->business_locations_id); ?>"
                                                                                                        selected>
                                                                                                        <?php echo e($shelf->location->name); ?>

                                                                                                    </option>
                                                                                                    <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                                        <option
                                                                                                            value="<?php echo e($location->id); ?>">
                                                                                                            <?php echo e($location->name); ?>

                                                                                                        </option>
                                                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                                    <?php endif; ?>
                                                                                                </select>
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <label>Description</label>
                                                                                                <input type="text"
                                                                                                    name="description"
                                                                                                    class="form-control"
                                                                                                    value="<?php echo e($shelf->description); ?>">
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
                                                <h2>No Shelf Found !</h2>
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
                                    <h4 class="modal-title">New Shelf</h4>
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
                                                        <h3 class="card-title">Shelf <small>Information</small></h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form action="/add-shelf" method="POST" id="quickForm">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Shelf Name</label>
                                                                <input type="text" name="shelf_name"
                                                                    class="form-control" placeholder="Shelf Name">
                                                            </div>
                                                            <input type="hidden" name="request_token"
                                                                value="<?php echo e(Str::uuid()); ?>">
                                                            <div class="form-group">
                                                                <label>Location</label>
                                                                <select name="business_locations_id" id=""
                                                                    class="form-control" required>
                                                                    <option value="" selected>
                                                                        Select
                                                                    </option>
                                                                    <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                        <option value="<?php echo e($location->id); ?>">
                                                                            <?php echo e($location->name); ?>

                                                                        </option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                    <?php endif; ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Description
                                                                    <small>opt</small></label>
                                                                <input type="text" name="description"
                                                                    class="form-control" id=""
                                                                    placeholder="Description">
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

                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('quickForm');
            form.addEventListener('submit', function(e) {
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = "Processing...";
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/shelfs/shelf.blade.php ENDPATH**/ ?>