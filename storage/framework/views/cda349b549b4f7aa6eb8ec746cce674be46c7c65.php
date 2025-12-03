<?php $__env->startSection('content'); ?>
    <div class="container">
        <h2 class="mb-4">System Activity Logs</h2>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <table id="example1" class="table table-bordered table-striped "
                        style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Model</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <?php echo e($activity->causer ? $activity->causer->name : 'System'); ?>

                                    </td>
                                    <td><?php echo e($activity->description); ?></td>
                                    <td><?php echo e(class_basename($activity->subject_type)); ?></td>
                                    <td><?php echo e($activity->created_at->timezone('Africa/Mogadishu')->format('Y-m-d h:i:s A')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No activity logs found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/log_activities/log.blade.php ENDPATH**/ ?>