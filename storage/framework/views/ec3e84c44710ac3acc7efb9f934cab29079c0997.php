<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">

            
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title"><b>System Login Time Policy</b></h3>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#policyModal">
                                Update Policy
                            </button>
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
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Timezone</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($policy): ?>
                                <tr>
                                    <td><?php echo e($policy->start_time); ?></td>
                                    <td><?php echo e($policy->end_time); ?></td>
                                    <td><?php echo e($policy->timezone); ?></td>
                                    <td>
                                        <span class="badge badge-success">Active</span>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No active login time policy set
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            
            <div class="modal fade" id="policyModal">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title">Set Login Time Policy</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <form method="POST" action="<?php echo e(route('admin.time-policy.store')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time" class="form-control"
                                        value="<?php echo e(old('start_time', $policy->start_time ?? '08:00')); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" name="end_time" class="form-control"
                                        value="<?php echo e(old('end_time', $policy->end_time ?? '17:00')); ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Timezone</label>
                                    <input type="text" name="timezone" class="form-control"
                                        value="<?php echo e(old('timezone', $policy->timezone ?? 'Africa/Addis_Ababa')); ?>" required>
                                </div>

                                <small class="text-muted">
                                    This policy applies to all <b>non-admin users</b>.
                                </small>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">
                                    Save Policy
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/index.blade.php ENDPATH**/ ?>