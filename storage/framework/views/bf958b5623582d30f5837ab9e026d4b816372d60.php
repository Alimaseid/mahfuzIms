<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h4>Transfer Item REPORT</h4>

                            <!-- ✅ Filter Form -->
                            <form method="GET" action="<?php echo e(route('reports.transferWarehouse')); ?>" class="form-inline">
                                <input type="date" name="from_date" value="<?php echo e($from_date); ?>" class="form-control mr-2"
                                    required>
                                <input type="date" name="to_date" value="<?php echo e($to_date); ?>" class="form-control mr-2"
                                    required>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="<?php echo e(route('reports.transferWarehouse')); ?>" class="btn btn-secondary ml-2">Reset</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ✅ Table -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="background-color: rgb(3, 3, 32)">
                                <th>No</th>
                                <th>ItemName</th>
                                <?php if($permission->manage_image == 'on'): ?>
                                    <th>Image1</th>
                                <?php endif; ?>
                                <?php if($permission->manage_image == 'on'): ?>
                                    <th>Image2</th>
                                <?php endif; ?>
                                <?php if($permission->manage_partNumber == 'on'): ?>
                                    <th>Part-No1</th>
                                <?php endif; ?>
                                <?php if($permission->manage_partNumber2 == 'on'): ?>
                                    <th>Part-No2</th>
                                <?php endif; ?>
                                <th>Category</th>
                                <th>Shelf </th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>OtherUnit</th>
                                <th>Category</th>
                                <th>ItemCode</th>
                                <th>Brand</th>
                                <th>Price1</th>
                                <th>Price2</th>
                                <th>BatchNumber</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php $__currentLoopData = $stock->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $no++;
                                        $imagePath = str_replace('\\', '/', $detail->item->image ?? '');
                                        $imagePath2 = str_replace('\\', '/', $detail->item->image2 ?? '');
                                    ?>
                                    <tr>
                                        <td><?php echo e($no); ?></td>
                                        <td><?php echo e($detail->item->item_name); ?></td>
                                        <?php if($permission->manage_image == 'on'): ?>
                                            <td>
                                                <?php if($imagePath): ?>
                                                    <img src="<?php echo e(asset($imagePath)); ?>"
                                                        style="width:50px; height:50px; object-fit:cover;"
                                                        onclick="setModalImage('<?php echo e(asset($imagePath)); ?>')"
                                                        data-toggle="modal" data-target="#imageModal">
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                        <?php if($permission->manage_image == 'on'): ?>
                                            <td>
                                                <?php if($imagePath2): ?>
                                                    <img src="<?php echo e(asset($imagePath2)); ?>"
                                                        style="width:50px; height:50px; object-fit:cover;"
                                                        onclick="setModalImage('<?php echo e(asset($imagePath2)); ?>')"
                                                        data-toggle="modal" data-target="#imageModal">
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                        <?php if($permission->manage_partNumber == 'on'): ?>
                                            <td> <?php echo e($detail->item->product_code); ?></td>
                                        <?php endif; ?>
                                        <?php if($permission->manage_partNumber2 == 'on'): ?>
                                            <td><?php echo e($detail->item->part_number); ?></td>
                                        <?php endif; ?>
                                        <td><?php echo e($detail->item->category); ?></td>
                                        <td>
                                            <?php $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($shelff->shelf->business_locations_id == $stock->request_from && $detail->item_id == $shelff->item_id): ?>
                                                    <?php echo e($shelff->shelf->shelf_name ?? '-'); ?>

                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <td><?php echo e($detail->quantity); ?></td>
                                        <td><?php echo e($detail->item->unit); ?></td>
                                        <td><?php echo e($detail->item->other_unit); ?></td>
                                        <td><?php echo e($detail->item->category); ?></td>
                                        <td><?php echo e($detail->item->item_code); ?></td>
                                        <td><?php echo e($detail->item->brand); ?></td>
                                        <td><?php echo e($detail->item->selling_price1); ?></td>
                                        <td><?php echo e($detail->item->selling_price2); ?></td>
                                        <td><?php echo e($stock->batch->batch_number); ?></td>
                                        <td><?php echo e($stock->created_at->format('Y-m-d')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="10" class="text-center">No Data Found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for Image Preview -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid rounded">
                    </div>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/reports/transfer_warehouse_item.blade.php ENDPATH**/ ?>