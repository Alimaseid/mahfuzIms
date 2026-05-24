<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8 lg">
                                    <b>Total Planned Item: <?php echo e(count($plans)); ?></b>
                                </div>
                                <div class="col-4 lg">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped "
                        style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ItemName </th>
                                <?php if($permission->manage_partNumber == 'on'): ?>
                                    <th>P-No1</th>
                                <?php endif; ?>
                                <?php if($permission->manage_partNumber2 == 'on'): ?>
                                    <th>P-No2</th>
                                <?php endif; ?>
                                <?php if($permission->manage_image == 'on'): ?>
                                    <th>Image1</th>
                                <?php endif; ?>
                                <th>ItemCode</th>
                                <th>Shelf</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>otherUnit</th>
                                <th>Brand</th>
                                <th>Message</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 0;
                            ?>
                            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $no = $no + 1;
                                ?>
                                <?php
                                    $imagePath1 = str_replace('\\', '/', $plan->item->image);
                                ?>
                                <tr>
                                    <td><?php echo e($no); ?></td>
                                    <td><?php echo e($plan->item->item_name); ?></td>
                                    <?php if($permission->manage_partNumber == 'on'): ?>
                                        <td><?php echo e($plan->item->product_code); ?></td>
                                    <?php endif; ?>
                                    <?php if($permission->manage_partNumber2 == 'on'): ?>
                                        <td><?php echo e($plan->item->part_number); ?></td>
                                    <?php endif; ?>
                                    <?php if($permission->manage_image == 'on'): ?>
                                        <td style="display: flex; align-items: center; gap: 10px;">
                                            <img src="<?php echo e(asset($imagePath1)); ?>" alt=""
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                data-toggle="modal" data-target="#imageModal"
                                                onclick="setModalImage('<?php echo e(asset($imagePath1)); ?>')">
                                        </td>
                                    <?php endif; ?>
                                    <td><?php echo e($plan->item->item_code); ?></td>
                                    <td><?php echo e($plan->item->shelf); ?></td>
                                    <td><?php echo e($plan->item->category); ?></td>
                                    <td><?php echo e($plan->required_qty); ?></td>
                                    <td><?php echo e($plan->item->unit); ?></td>
                                    <td><?php echo e($plan->item->other_unit); ?></td>
                                    <td><?php echo e($plan->item->brand); ?></td>

                                    <td><?php echo e($plan->message); ?></td>
                                    <td>
                                        <?php if($permission->manage_delete_purchasePlan == 'on'): ?>
                                            <a type="button" class="btn btn-danger btn-sm"
                                                href="delete-plans-<?php echo e($plan->id); ?>"
                                                onclick="return confirm('Are you sure you ?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <img id="modalImage" src="" class="img-fluid rounded">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script>
        function setModalImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/goodreceiving/planned_item.blade.php ENDPATH**/ ?>