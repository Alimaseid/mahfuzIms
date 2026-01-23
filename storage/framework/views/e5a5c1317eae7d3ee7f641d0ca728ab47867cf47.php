<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><b>User Login Exceptions</b></h3>
                        </div>
                    </div>
                </div>
            </div>

            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger mt-2">
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <b>Create New Exception</b>
                </div>

                <form method="POST" action="<?php echo e(route('admin.login-exceptions.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="card-body row">
                        <div class="col-md-3">
                            <label>User</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">Select User</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Allowed From</label>
                            <input type="datetime-local" name="allowed_from" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label>Allowed To</label>
                            <input type="datetime-local" name="allowed_to" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label>Reason</label>
                            <input type="text" name="reason" class="form-control" placeholder="Optional">
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Exception
                        </button>
                    </div>
                </form>
            </div>

            
            <div class="card mt-3">
                <div class="card-header bg-light">
                    <b>Active / Past Exceptions</b>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $exceptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <form method="POST" action="<?php echo e(route('admin.login-exceptions.update', $ex)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>

                                        <td><?php echo e($ex->user->name); ?></td>

                                        <td>
                                            <input type="datetime-local" name="allowed_from"
                                                class="form-control form-control-sm"
                                                value="<?php echo e(\Carbon\Carbon::parse($ex->allowed_from)->format('Y-m-d\TH:i')); ?>">
                                        </td>

                                        <td>
                                            <input type="datetime-local" name="allowed_to"
                                                class="form-control form-control-sm"
                                                value="<?php echo e(\Carbon\Carbon::parse($ex->allowed_to)->format('Y-m-d\TH:i')); ?>">
                                        </td>

                                        <td>
                                            <select name="active" class="form-control form-control-sm">
                                                <option value="1" <?php echo e($ex->active ? 'selected' : ''); ?>>Active</option>
                                                <option value="0" <?php echo e(!$ex->active ? 'selected' : ''); ?>>Inactive
                                                </option>
                                            </select>
                                        </td>

                                        <td class="text-center">
                                            <button class="btn btn-success btn-xs">
                                                <i class="fas fa-save"></i> Update
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No login exceptions found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/loginException.blade.php ENDPATH**/ ?>