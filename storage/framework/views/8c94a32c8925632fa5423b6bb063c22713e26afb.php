<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            Shop STOCK REPORT
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3></h3>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="background-color: rgb(3, 3, 32)">
                                <th>No</th>
                                <th>ItemName</th>
                                <th>Itemimage1</th>
                                <th>Itemimage2</th>
                                <th style="background-color: rgb(2, 2, 39)">Part Number1</th>
                                <th style="background-color: rgb(2, 2, 39)">Part Number2</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Category</th>
                                <th>Shelf </th>
                                <th>BatchNumber</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 0;
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $imagePath = str_replace('\\', '/', $stock->item->image); // Fix backslashes
                                    $imagePath2 = str_replace('\\', '/', $stock->item->image2);
                                ?>
                                <?php
                                    $no = $no + 1;
                                ?>
                                <td><?php echo e($no); ?></td>
                                <td><?php echo e($stock->item->item_name); ?></td>
                                <td style="display: flex; align-items: center; gap: 10px;">
                                    <img src="<?php echo e(asset($imagePath)); ?>" alt=""
                                        style="width: 30px; height: 30px; object-fit: cover; border-radius: 5px;"
                                        data-toggle="modal" data-target="#imageModal"
                                        onclick="setModalImage('<?php echo e(asset($imagePath)); ?>')">

                                </td>
                                <td style="display: flex; align-items: center; gap: 10px;">
                                    <img src="<?php echo e(asset($imagePath2)); ?>" alt=""
                                        style="width: 30px; height: 30px; object-fit: cover; border-radius: 5px;"
                                        data-toggle="modal" data-target="#imageModal"
                                        onclick="setModalImage('<?php echo e(asset($imagePath2)); ?>')">

                                </td>
                                <td style="background-color: rgb(2, 2, 39)"><a type="button" style="color: gold"
                                        href="#"data-toggle="modal"
                                        data-target="#modal-lg-O-<?php echo e($stock->id); ?>"><?php echo e($stock->item->product_code); ?></a>
                                </td>
                                <td style="background-color: rgb(2, 2, 39)"><a type="button" style="color: gold"
                                        href="#"data-toggle="modal"
                                        data-target="#modal-lg-O-<?php echo e($stock->id); ?>"><?php echo e($stock->item->part_number); ?></a>
                                </td>
                                <td><?php echo e($stock->quantity); ?></td>
                                <td><?php echo e($stock->item->unit); ?></td>
                                <td><?php echo e($stock->item->category); ?></td>
                                <td>
                                    <?php $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($shelff->shelf->business_locations_id == $stock->location_id && $stock->item_id == $shelff->item_id): ?>
                                            <?php echo e($shelff->shelf->shelf_name ?? '-'); ?>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </td>
                                <td><?php echo e($stock->batch->batch_number); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/reports/shopStock_report.blade.php ENDPATH**/ ?>