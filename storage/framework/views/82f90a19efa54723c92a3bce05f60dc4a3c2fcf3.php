<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
              <div class="card">
                <div class="card-body text-sm">
                    
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>ItemName</th>
                      <th>Quantity</th>
                      <th>LastUpdate</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php $no = $no + 1; ?>
                            <tr>
                                <td><?php echo e($no); ?></td>
                                <td><?php echo e($item->item_name); ?></td>
                                <td><?php echo e($item->qauntity); ?></td>
                                <td><?php echo e($item->updated_at->toDateString()); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php endif; ?>
                    </tbody>

                
                </div>
                  <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/pages/store/items_on_shop.blade.php ENDPATH**/ ?>