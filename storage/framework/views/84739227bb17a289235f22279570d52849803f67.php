<?php if(count($errors) > 0): ?>
    <?php $__currentLoopData = $errors->all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="alert alert-danger"  style="font-size:35px; font-family:Georgia, 'Times New Roman', Times, serif;">
           <h3>
            <?php echo e(error); ?>

           </h3>
        </div>        
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<?php if(session('error')): ?>
<div class="alert alert-danger">
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?><?php /**PATH C:\Users\Halima\Documents\well-known\resources\views/inc/message.blade.php ENDPATH**/ ?>