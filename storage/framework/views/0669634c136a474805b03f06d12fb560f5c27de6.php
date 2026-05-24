<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8 lg">
                                    <b>Total Item: <?php echo e(count($items)); ?></b>
                                </div>
                                <div class="col-4 lg">
                                    <button type="button" class="btn btn-primary pull-rigth btn-sm" style="float: right;"
                                        data-toggle="modal" data-target="#modal-lg">
                                        New Item
                                    </button>
                                </div>
                            </div>
                        </div>
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
                    <div class="card-body">
                        
                        <table id="example1" class="table table-bordered table-striped "
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    
                                    <th>ItemName </th>
                                    <?php if($permission->manage_image == 'on'): ?>
                                        <th>Image1</th>
                                    <?php endif; ?>
                                    <?php if($permission->manage_image == 'on'): ?>
                                        <th>Image2</th>
                                    <?php endif; ?>
                                    <?php if($permission->manage_partNumber == 'on'): ?>
                                        <th>Part Number1</th>
                                    <?php endif; ?>
                                    <?php if($permission->manage_partNumber2 == 'on'): ?>
                                        <th>Part Number2</th>
                                    <?php endif; ?>
                                    <th>Item Code</th>
                                    <th>Category</th>
                                    <th>Reorder</th>
                                    <th>Price1</th>
                                    <th>Price2</th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                <?php if(count($items) > 0): ?>
                                    <?php
                                        $no = 0;
                                    ?>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $no = $no + 1;
                                        ?>
                                        <tr>
                                            <td><?php echo e($no); ?></td>
                                            <?php
                                                $imagePath1 = str_replace('\\', '/', $inventory->item->image);
                                                $imagePath2 = str_replace('\\', '/', $inventory->item->image2);
                                            ?>
                                            <td><?php echo e($inventory->item->item_name); ?></td>
                                            <?php if($permission->manage_image == 'on'): ?>
                                                <td style="display: flex; align-items: center; gap: 10px;">
                                                    <img src="<?php echo e(asset($imagePath1)); ?>" alt=""
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                        data-toggle="modal" data-target="#imageModal"
                                                        onclick="setModalImage('<?php echo e(asset($imagePath1)); ?>')">
                                                </td>
                                            <?php endif; ?>
                                            <?php if($permission->manage_image == 'on'): ?>
                                                <td>
                                                    <img src="<?php echo e(asset($imagePath2)); ?>" alt=""
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                        data-toggle="modal" data-target="#imageModal"
                                                        onclick="setModalImage('<?php echo e(asset($imagePath2)); ?>')">
                                                </td>
                                            <?php endif; ?>
                                            <?php if($permission->manage_partNumber == 'on'): ?>
                                                <td><?php echo e($inventory->item->product_code); ?></td>
                                            <?php endif; ?>
                                            <?php if($permission->manage_partNumber2 == 'on'): ?>
                                                <td><?php echo e($inventory->item->part_number); ?></td>
                                            <?php endif; ?>
                                            <td><?php echo e($inventory->item->item_code); ?></td>
                                            <!-- Image Modal (works with Bootstrap 4) -->
                                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img id="modalImage" src="" class="img-fluid rounded">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <td><?php echo e($inventory->item->category); ?></td>
                                            <td><?php echo e($inventory->item->reorder); ?></td>

                                            <td><?php echo e($inventory->item->selling_price1); ?></td>
                                            <td><?php echo e($inventory->item->selling_price2); ?></td>
                                        </tr>
                                        <!-- /.modal -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <h2>No item Found !</h2>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/items/reorderStore.blade.php ENDPATH**/ ?>