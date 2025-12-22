


<?php $__env->startSection('content'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left">Business Locations :<b>
                                        <?php echo e(count($location)); ?></b></div>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New Location
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
                                                <th>LocationName</th>
                                                <th>Type</th>
                                                
                                                <th>Site</th>
                                                <th>Address</th>
                                                <th>_________</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(count($locations) > 0): ?>
                                                <?php
                                                    $no = 0;
                                                ?>
                                                <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $no = $no + 1;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo e($no); ?></td>
                                                        <td><?php echo e($location->name); ?></td>
                                                        <td><?php echo e($location->type); ?></td>
                                                        
                                                        <td> <?php echo e($location->site); ?></td>
                                                        <td><?php echo e($location->address); ?></td>

                                                        <td>
                                                            <?php if($permission->manage_edit_location == 'on'): ?>
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-lg-<?php echo e($location->id); ?>">
                                                                    <i class="fas fa-edit "></i>
                                                                </button>
                                                            <?php endif; ?>
                                                            <?php if($permission->manage_delete_location == 'on'): ?>
                                                                <a type="button" class="btn btn-danger btn-sm"
                                                                    href="delete-location-<?php echo e($location->id); ?>"
                                                                    onclick="return confirm('Are you sure you ?');">
                                                                    <i class="fas fa-trash "></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="modal-lg-<?php echo e($location->id); ?>">
                                                        <div class="modal-dialog modal-lg-<?php echo e($location->id); ?>">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit location</h4>
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
                                                                                        <h3 class="card-title">location
                                                                                            <small>Information</small>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <!-- form start -->
                                                                                    <form
                                                                                        action="/edit-location-<?php echo e($location->id); ?>"
                                                                                        method="POST" id="quickForm">
                                                                                        <?php echo csrf_field(); ?>
                                                                                        <div class="card-body">
                                                                                            <div class="form-group">
                                                                                                <label>Name</label>
                                                                                                <input type="text"
                                                                                                    name="name"
                                                                                                    class="form-control"
                                                                                                    value="<?php echo e($location->name); ?>"
                                                                                                    required>
                                                                                            </div>
                                                                                            
                                                                                            <div class="form-group">
                                                                                                <label>Type</label>
                                                                                                <select name="type"
                                                                                                    id=""
                                                                                                    class="form-control"
                                                                                                    required>
                                                                                                    <option
                                                                                                        value="<?php echo e($location->type); ?>"
                                                                                                        selected>
                                                                                                        <?php echo e($location->type); ?>

                                                                                                    </option>
                                                                                                    <option value="Shop">
                                                                                                        Shop</option>
                                                                                                    <option
                                                                                                        value="Warehouse">
                                                                                                        Warehouse</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label>Site</label>
                                                                                                <input type="text"
                                                                                                    name="site"
                                                                                                    class="form-control"
                                                                                                    value="<?php echo e($location->site); ?>">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="">Address</label>
                                                                                                <input type="text"
                                                                                                    name="address"
                                                                                                    class="form-control"
                                                                                                    id=""
                                                                                                    value="<?php echo e($location->address); ?>">
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
                                                <h2>No location Found !</h2>
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
                                    <h4 class="modal-title">New location</h4>
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
                                                        <h3 class="card-title">location <small>Information</small></h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form action="/add-location" method="POST" id="quickForm">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Location Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    placeholder="Business Location Name">
                                                            </div>
                                                            <input type="hidden" name="request_token"
                                                                value="<?php echo e(Str::uuid()); ?>">
                                                            <div class="form-group">
                                                                <label>Type</label>
                                                                <select name="type" id=""
                                                                    class="form-control" required>
                                                                    <option value="" selected>Select</option>
                                                                    <option value="Shop">Shop</option>
                                                                    <option value="Warehouse">Warehouse</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Site <small>opt</small></label>
                                                                <input type="text" name="site" class="form-control"
                                                                    id="" placeholder="Site">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Adress <small>opt</small></label>
                                                                <input type="text" name="address" class="form-control"
                                                                    id="" placeholder="Adress">
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/business_location/location.blade.php ENDPATH**/ ?>