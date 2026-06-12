<?php $__env->startSection('content'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6 lg">

                                </div>
                                <div class="col-6 lg">
                                    <a type="button" href="/addsales" class="btn btn-info pull-rigth btn-sm"
                                        style="float: right;">
                                        <b class="pr-3"> New sales</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped text-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SalesDate</th>
                                <th>CustomerName</th>
                                <th>Payment</th>
                                <th>InvoiceNumber</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>SalesPerson</th>
                                <th>Activity/Action</th>
                            </tr>
                        </thead>

                        <tbody id="list">
                            <?php if(count($salesOrders) > 0): ?>
                                <?php $no = 1; ?>
                                <?php $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($no++); ?></td>

                                        <td><?php echo e($salesOrder->created_at->toDateString()); ?></td>

                                        <td>
                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($customer->id == $salesOrder->customer_id): ?>
                                                    <?php echo e($customer->name); ?>

                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>

                                        <td>
                                            <a class="btn" data-toggle="modal"
                                                data-target="#modal-view-<?php echo e($salesOrder->id); ?>">
                                                <i style="color: greenyellow">
                                                    <?php echo e(number_format($salesOrder->grand_total, 2)); ?>

                                                </i>
                                            </a>
                                        </td>

                                        <td><?php echo e($salesOrder->reference_number); ?></td>

                                        <td>
                                            <?php $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($location->id == $salesOrder->location_id): ?>
                                                    <?php echo e($location->name); ?>

                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>

                                        <td>
                                            <?php if($salesOrder->SM_status == 'Pending'): ?>
                                                <p class="text-warning">Pending</p>
                                            <?php elseif($salesOrder->SM_status == 'Rejected'): ?>
                                                <button class="btn btn-danger btn-xs" data-toggle="modal"
                                                    data-target="#modal-reject-<?php echo e($salesOrder->id); ?>">
                                                    Rejected
                                                </button>
                                            <?php elseif($salesOrder->SM_status == 'Accepted'): ?>
                                                <p class="text-primary">Accepted</p>
                                            <?php else: ?>
                                                <p class="text-success"><?php echo e($salesOrder->SM_status); ?></p>
                                            <?php endif; ?>
                                        </td>

                                        <td><?php echo e($salesOrder->sales_person); ?></td>

                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-view-<?php echo e($salesOrder->id); ?>">
                                                Details
                                            </button>

                                            <?php if($permission->manage_edit_sales == 'on'): ?>
                                                <a class="btn btn-info btn-sm" href="/editsales-<?php echo e($salesOrder->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>

                                            <?php if($permission->manage_delete_sales == 'on'): ?>
                                                <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"
                                                    href="/delete-sales-order-<?php echo e($salesOrder->id); ?>">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>

                                            <a href="/sales-invoice-<?php echo e($salesOrder->id); ?>" target="_blank"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-print"></i> Print
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <h2>No Sales Orders Found!</h2>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- /.card-body -->


                
                
                
                <?php $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <div class="modal fade" id="modal-view-<?php echo e($salesOrder->id); ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title"><?php echo e($salesOrder->reference_number); ?></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <?php if($permission->manage_partNumber == 'on'): ?>
                                                        <th>P-No1</th>
                                                    <?php endif; ?>
                                                    <?php if($permission->manage_partNumber2 == 'on'): ?>
                                                        <th>P-No2</th>
                                                    <?php endif; ?>
                                                    <?php if($permission->manage_image == 'on'): ?>
                                                        <th>Image1</th>
                                                    <?php endif; ?>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Vat</th>
                                                    <th>With Holding</th>
                                                    <th>Discount</th>
                                                    <th>SubTotal</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $total = 0; ?>

                                                <?php $__currentLoopData = $salesOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($detail->sales_order_id == $salesOrder->id): ?>
                                                        <?php
                                                            $total += $detail->total;
                                                            $image1 = str_replace('\\', '/', $detail->item->image);
                                                        ?>
                                                        <tr>
                                                            <td><b><?php echo e($detail->item->item_name); ?></b></td>
                                                            <?php if($permission->manage_partNumber == 'on'): ?>
                                                                <td><b><?php echo e($detail->item->product_code); ?></b></td>
                                                            <?php endif; ?>
                                                            <?php if($permission->manage_partNumber2 == 'on'): ?>
                                                                <td><b><?php echo e($detail->item->part_number); ?></b></td>
                                                            <?php endif; ?>
                                                            <?php if($permission->manage_image == 'on'): ?>
                                                                <td>
                                                                    <img src="<?php echo e(asset($image1)); ?>"
                                                                        style="width:40px;height:40px;border-radius:5px;object-fit:cover;">
                                                                </td>
                                                            <?php endif; ?>
                                                            <td><?php echo e($detail->quantity); ?></td>
                                                            <td><?php echo e($detail->amount); ?></td>
                                                            <td><?php echo e($detail->tax); ?></td>
                                                            <td><?php echo e($detail->with_holding); ?></td>
                                                            <td><?php echo e($detail->discount); ?></td>
                                                            <td><?php echo e($detail->total); ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>

                                        <div class="text-right mt-3">
                                            <h5><b>Total: <?php echo e(number_format($salesOrder->grand_total, 2)); ?></b></h5>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    
                    <div class="modal fade" id="modal-reject-<?php echo e($salesOrder->id); ?>">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title"><?php echo e($salesOrder->reference_number); ?></h4>
                                    <button class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <label>Rejected Because:</label>
                                    <textarea class="form-control" readonly><?php echo e($salesOrder->rejectReasone); ?></textarea>

                                    <br>

                                    <button class="btn btn-success float-right" data-toggle="modal"
                                        data-target="#modal-view-<?php echo e($salesOrder->id); ?>">
                                        Edit Order
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                <!-- Bootstrap 5 Image Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Item Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="modalImage" src="" class="img-fluid rounded" alt="Item Image">
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ims_webims/amarImsfinal/resources/views/pages/sales/sales.blade.php ENDPATH**/ ?>