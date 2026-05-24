<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 " style="float: left"> Set batch <b>
                                    </b></div>
                            </h3>

                        </div>
                        <div class="mt-2 mt-md-0">
                            <a href="sets-<?php echo e($item->id); ?>" class="btn btn-outline-dark px-4 rounded-pill shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
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
                                            <th>BatchNumber </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no = 0;
                                        ?>
                                        ItemName: <strong> <?php echo e($item->item_name); ?></strong>
                                        <?php $__currentLoopData = $batchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $no = $no + 1;
                                            ?>
                                            <tr>
                                                <td><?php echo e($no); ?></td>
                                                <td><?php echo e($batch->batch_number); ?></td>
                                                <td>
                                                    <a type="button" class="btn btn-danger btn-sm"
                                                        href="delete-batchs-<?php echo e($batch->id); ?>"
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
                                    <form action="/add-batchs" method="POST">
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
                                                    <input type="hidden" name="request_token" value="<?php echo e(Str::uuid()); ?>">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Batch Number</label>
                                                            <input type="text" name="batch_number" class="form-control"
                                                                placeholder="Batch Number" required min="1">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Manufacture Date</label>
                                                            <input type="date" name="manufacture_date"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer justify-content-between">
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/items/setBatch.blade.php ENDPATH**/ ?>