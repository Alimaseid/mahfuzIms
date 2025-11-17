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
                                    <button type="button" class="btn btn-info pull-rigth btn-sm" style="float: right;"
                                        data-toggle="modal" data-target="#modal-lg">
                                        <b class="pr-3"> New sales</b>
                                    </button>
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
                        <tbody id='list'>
                            <?php if(count($salesOrders) > 0): ?>
                                <?php
                                    $no = 0;
                                ?>
                                <?php $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $no = $no + 1;
                                    ?>
                                    <tr>
                                        <td><?php echo e($no); ?></td>
                                        
                                        <td><?php echo e($salesOrder->created_at->toDateString()); ?></td>
                                        <td>
                                            <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <?php if($customer->id == $salesOrder->customer_id): ?>
                                                    <?php echo e($customer->name); ?>

                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                        </td>


                                        <div class="modal fade" id="modal-lg-view-<?php echo e($salesOrder->id); ?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><?php echo e($salesOrder->reference_number); ?></h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                Item
                                                            </div>
                                                            <div class="col">
                                                                p-No1
                                                            </div>
                                                            <div class="col">
                                                                P-No2
                                                            </div>
                                                            <div class="col">
                                                                Image1
                                                            </div>
                                                            <div class="col">
                                                                Quantity
                                                            </div>
                                                            <div class="col">
                                                                Price
                                                            </div>
                                                            <div class="col">
                                                                Vat
                                                            </div>
                                                            <div class="col">
                                                                With Holding
                                                            </div>
                                                            <div class="col">
                                                                Discount
                                                            </div>
                                                            <div class="col">
                                                                SubTotal
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <?php
                                                            $total = 0;
                                                        ?>
                                                        <?php $__empty_1 = true; $__currentLoopData = $salesOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <?php if($salesOrderDetail->sales_order_id == $salesOrder->id): ?>
                                                                <?php
                                                                    $total = $total + $salesOrderDetail->total;
                                                                ?>
                                                                <?php
                                                                    $imagePath1 = str_replace(
                                                                        '\\',
                                                                        '/',
                                                                        $salesOrderDetail->item->image,
                                                                    );
                                                                    $imagePath2 = str_replace(
                                                                        '\\',
                                                                        '/',
                                                                        $salesOrderDetail->item->image2,
                                                                    );
                                                                ?>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <b><?php echo e($salesOrderDetail->item->item_name); ?></b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b><?php echo e($salesOrderDetail->item->product_code); ?></b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b><?php echo e($salesOrderDetail->item->part_number); ?></b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <img src="<?php echo e(asset($imagePath1)); ?>" alt=""
                                                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px; cursor: pointer;">

                                                                    </div>

                                                                    <div class="col">
                                                                        <?php echo e($salesOrderDetail->quantity); ?>

                                                                    </div>
                                                                    <div class="col">
                                                                        <?php echo e($salesOrderDetail->amount); ?>

                                                                    </div>
                                                                    <div class="col">
                                                                        <b><?php echo e($salesOrderDetail->tax); ?></b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b><?php echo e($salesOrderDetail->with_holding); ?></b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b><?php echo e($salesOrderDetail->discount); ?></b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b><?php echo e($salesOrderDetail->total); ?></b>
                                                                    </div>


                                                                </div>
                                                                <br>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <?php endif; ?>
                                                        <div class="col">
                                                            Total:<?php echo e($salesOrder->grand_total); ?>

                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                        <td><a class="btn" data-toggle="modal"
                                                data-target="#modal-lg-view-<?php echo e($salesOrder->id); ?>"> <i
                                                    style="color: greenyellow"><?php echo e(number_format($salesOrder->grand_total, 2)); ?></i></a>
                                        </td>
                                        <td><?php echo e($salesOrder->reference_number); ?></td>
                                        <td>
                                            <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <?php if($businessLocation->id == $salesOrder->location_id): ?>
                                                    <?php echo e($businessLocation->name); ?>

                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>

                                            <?php if($salesOrder->SM_status == 'Pending'): ?>
                                                <p class="text-warning"><?php echo e($salesOrder->SM_status); ?></p>
                                            <?php elseif($salesOrder->SM_status == 'Rejected'): ?>
                                                <a class="btn btn-danger btn-xs" href="#" class="text-danger"
                                                    data-toggle="modal"
                                                    data-target="#modal-reject-<?php echo e($salesOrder->id); ?>"><?php echo e($salesOrder->SM_status); ?></a>
                                            <?php elseif($salesOrder->SM_status == 'Accepted'): ?>
                                                <p class="text-primary"><?php echo e($salesOrder->SM_status); ?></p>
                                            <?php else: ?>
                                                <p class="text-success"><?php echo e($salesOrder->SM_status); ?></p>
                                            <?php endif; ?>


                                        </td>

                                        <td><?php echo e($salesOrder->sales_person); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-<?php echo e($salesOrder->id); ?>">
                                                Details
                                            </button>
                                            <?php if($permission->manage_edit_sales == 'on'): ?>
                                                <a type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-<?php echo e($salesOrder->id); ?>">
                                                    <i class="fas fa-edit "></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if($permission->manage_delete_sales == 'on'): ?>
                                                <a type="button" class="btn btn-danger btn-sm"
                                                    href="delete-sales-order-<?php echo e($salesOrder->id); ?>"
                                                    onclick="return confirm('Are you sure you ?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>


                                            <a href="/sales-invoice-<?php echo e($salesOrder->id); ?>" rel="noopener" target="_blank"
                                                class="btn btn-warning btn-sm"><i class="fas fa-print"></i> Print</a>

                                            
                                        </td>
                                    </tr>
                                    <!-- /.card -->
                                    <div class="modal fade" id="modal-reject-<?php echo e($salesOrder->id); ?>">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"><?php echo e($salesOrder->reference_number); ?></h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">This order rejected due to this
                                                                    reasone</label>
                                                                <textarea name="rejectReasone" readonly class="form-control" id="" placeholder="reasone..."><?php echo e($salesOrder->rejectReasone); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </br>
                                                    <div class="row no-print">
                                                        <div class="col-12">
                                                            <button type="submit" data-toggle="modal"
                                                                data-target="#modal-lg-<?php echo e($salesOrder->id); ?>"
                                                                class="btn btn-success float-right"> Edit Order</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <h2>No salesOrder Found !</h2>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    


                </div>
                <!-- /.card-body -->


                <div class="modal fade" id="modal-lg">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Sales Order</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <section class="content">
                                    <div class="container-fluid">
                                        <form method="POST" action="<?php echo e(url('add-sales-order')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="invoice p-3 mb-3">

                                                <!-- Title row -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>
                                                            <i class="fas fa-globe"></i> Inventory, Inc.
                                                            <small class="float-right">Date:
                                                                <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?></small>
                                                        </h4>
                                                    </div>
                                                </div>

                                                <!-- Info row -->
                                                <div class="row invoice-info">
                                                    <div class="col-sm-4 invoice-col">
                                                        <address>
                                                            Business Location
                                                            <select name="business_location" class="form-control"
                                                                id="location" required>
                                                                <option value="">Select</option>
                                                                <?php $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($businessLocation->id); ?>">
                                                                        <?php echo e($businessLocation->name); ?>

                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>

                                                            Invoice No
                                                            <input type="text" name="refrence_no" class="form-control"
                                                                value="<?php echo e('IMS-RF-' . random_int(100000, 9999999)); ?>">
                                                        </address>
                                                    </div>

                                                    <div class="col-sm-1"></div>

                                                    <div class="col-sm-7 invoice-col">
                                                        <div class="form-group">
                                                            Sales Type
                                                            <select name="sales_type" class="form-control" required>
                                                                <option value="Cash Sales">Cash Sales</option>
                                                                <option value="Credit Sales">Credit Sales</option>
                                                            </select>
                                                        </div>

                                                        To
                                                        <select name="customer" class="form-control select2bs4" required>
                                                            <option value="">Select</option>
                                                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Items table -->
                                                <div class="row">
                                                    <div class="col-12 table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product / Item</th>
                                                                    <th>Quantity</th>
                                                                    <th>U-Price</th>
                                                                    <th>SubTotal</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="add_items">
                                                                <tr id="row_0">
                                                                    <td style="width: 300px;">
                                                                        <!-- Category Dropdown -->
                                                                        <select id="category_0" class="form-control mb-2"
                                                                            onchange="loadItemsByCategory(0)">
                                                                            <option value="">-- Select Category --
                                                                            </option>
                                                                            <?php $__currentLoopData = \App\Models\Item::select('category')->distinct()->pluck('category'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($cat); ?>">
                                                                                    <?php echo e($cat); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>

                                                                        <!-- Item Search -->
                                                                        <div class="item-search w-100 mb-2"
                                                                            style="position:relative">
                                                                            <input type="text"
                                                                                placeholder="Search Item..."
                                                                                id="myInput_0" onclick="myFunction(0)"
                                                                                onkeyup="filterFunction(0)"
                                                                                class="form-control" autocomplete="off"
                                                                                disabled required>
                                                                            <div id="myDropdown_0"
                                                                                class="dropdown-content">
                                                                                <div id="item_list_0"></div>
                                                                            </div>
                                                                        </div>

                                                                        <input type="hidden" id="item_id_0"
                                                                            name="addmore[0][item_id]" value="">
                                                                        <input type="hidden" id="batch_id_0"
                                                                            name="addmore[0][batch_id]" value="">
                                                                        <input type="hidden" id="selling_price2_0"
                                                                            name="addmore[0][selling_price2]"
                                                                            value="">

                                                                    </td>
                                                                    <td>
                                                                        <input type="number" min="1"
                                                                            id="qty_0" name="addmore[0][quantity]"
                                                                            onchange="subTotalCal(0)" class="form-control"
                                                                            placeholder="Quantity" required>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" id="u_price_0"
                                                                            name="addmore[0][u_price]"
                                                                            onchange="subTotalCal(0)" class="form-control"
                                                                            style="width:120px;" required>
                                                                    </td>
                                                                    <input type="hidden" id="available_qty_0"
                                                                        value="">
                                                                    <td>
                                                                        <input type="text" id="sub_0"
                                                                            class="form-control sub"
                                                                            placeholder="Sub Total" disabled>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="remove-tr"><b
                                                                                style="color:red">X</b></button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <a href="#" id="add_new_items"
                                                            class="btn btn-success float-right"
                                                            style="padding:5px; text-decoration:none">
                                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Totals -->
                                                <div class="row" id="calculate">
                                                    <div class="col-7">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label>Discount (%)</label>
                                                                <input type="number" id="discount_percent"
                                                                    class="form-control" value="0" name="discount"
                                                                    onchange="calculateTotal()" min="0"max="100">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <input type="checkbox" id="vat_include"
                                                                    name="vat_include" onchange="calculateTotal()"
                                                                    value="0.15">
                                                                <label>VAT (%)</label>

                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <input type="checkbox" id="with_holding"
                                                                    name="with_holding" onchange="calculateTotal()"
                                                                    value="0.03">
                                                                <label>Withholding(%)</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-5">
                                                        <p class="lead" style="float:right;">Total Due Amount</p>
                                                        <div class="table-responsive" style="float:right;">
                                                            <table class="table">
                                                                <tr>
                                                                    <th style="width:50%">Subtotal :</th>
                                                                    <td><i id="sub"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <th id="discountRate">Discount(0%)</th>
                                                                    <td><i id="discount"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <th id="vatRate">Tax(0%)</th>
                                                                    <td><i id="vat"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <th id="withHoldingRate">WithHolding(0%)</th>
                                                                    <td><i id="with_hold"></i></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total:</th>
                                                                    <td><i id="tot" name="Gtotal"></i></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Submit -->
                                                <div class="row no-print">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-success float-right">Submit
                                                            Order</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>


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

                <?php $__empty_1 = true; $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="modal fade" id="modal-lg-<?php echo e($salesOrder->id); ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Order - <?php echo e($salesOrder->reference_number); ?></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <section class="content">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form method="POST" action="edit-sales-order-<?php echo e($salesOrder->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <div class="invoice p-3 mb-3">

                                                            <!-- Order Info -->
                                                            <div class="row invoice-info">
                                                                <div class="col-sm-4 invoice-col">
                                                                    <address>
                                                                        <label>Business Location</label>
                                                                        <!-- IMPORTANT: id used by JS -->
                                                                        <select id="e_location_<?php echo e($salesOrder->id); ?>"
                                                                            name="business_location" class="form-control"
                                                                            required>
                                                                            <option value="">Select</option>
                                                                            <?php $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($loc->id); ?>"
                                                                                    <?php echo e($salesOrder->location_id == $loc->id ? 'selected' : ''); ?>>
                                                                                    <?php echo e($loc->name); ?>

                                                                                </option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>

                                                                        <label>Invoice No</label>
                                                                        <input type="text" readonly name="refrence_no"
                                                                            class="form-control"
                                                                            value="<?php echo e($salesOrder->reference_number); ?>">
                                                                    </address>
                                                                </div>

                                                                <div class="col-sm-8 invoice-col">
                                                                    <label>Sales Type</label>
                                                                    <select name="sales_type" class="form-control"
                                                                        required>
                                                                        <option value="Cash Sales"
                                                                            <?php echo e($salesOrder->sales_type == 'Cash Sales' ? 'selected' : ''); ?>>
                                                                            Cash Sales
                                                                        </option>
                                                                        <option value="Credit Sales"
                                                                            <?php echo e($salesOrder->sales_type == 'Credit Sales' ? 'selected' : ''); ?>>
                                                                            Credit Sales
                                                                        </option>
                                                                    </select>

                                                                    <label>Customer</label>
                                                                    <select name="customer" class="form-control" required>
                                                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <option value="<?php echo e($customer->id); ?>"
                                                                                <?php echo e($salesOrder->customer_id == $customer->id ? 'selected' : ''); ?>>
                                                                                <?php echo e($customer->name); ?>

                                                                            </option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Items table -->
                                                            <div class="row mt-3">
                                                                <div class="col-12 table-responsive">
                                                                    <a href="/items" style="color:rgb(98, 255, 0)"><i
                                                                            class="fa fa-plus-circle"></i> ADD New Item</a>

                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Item Name</th>
                                                                                <th>Quantity</th>
                                                                                <th>U-Price</th>
                                                                                <th>SubTotal</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody id="e_add_items_<?php echo e($salesOrder->id); ?>">
                                                                            <?php
                                                                                // compute a safe subtotal (before discount/tax)
                                                                                $subtotal = $salesOrder->details->sum(
                                                                                    function ($d) {
                                                                                        return $d->quantity *
                                                                                            $d->amount;
                                                                                    },
                                                                                );
                                                                            ?>

                                                                            <?php $__currentLoopData = $salesOrder->details ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <tr
                                                                                    id="e_row_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>">
                                                                                    <td style="width:300px;">
                                                                                        <select
                                                                                            id="e_category_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>"
                                                                                            class="form-control mb-2"
                                                                                            onchange="e_loadItemsByCategory(<?php echo e($salesOrder->id); ?>, <?php echo e($i); ?>)">
                                                                                            <option value="">--
                                                                                                Select Category --</option>
                                                                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                <option
                                                                                                    value="<?php echo e($cat->id); ?>"
                                                                                                    <?php echo e($detail->item->category_id == $cat->id ? 'selected' : ''); ?>>
                                                                                                    <?php echo e($cat->name); ?>

                                                                                                </option>
                                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                        </select>

                                                                                        <div class="dropdown w-100"
                                                                                            style="position:relative;">
                                                                                            <input type="text"
                                                                                                placeholder="Search Item..."
                                                                                                id="e_myInput_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>"
                                                                                                onclick="e_myFunction(<?php echo e($salesOrder->id); ?>, <?php echo e($i); ?>)"
                                                                                                onkeyup="e_filterFunction(<?php echo e($salesOrder->id); ?>, <?php echo e($i); ?>)"
                                                                                                class="form-control"
                                                                                                autocomplete="off"
                                                                                                value="<?php echo e(optional($detail->item)->item_name); ?> | <?php echo e(optional($detail->item)->product_code); ?> | <?php echo e(optional($detail->batch)->batch_number ?? ''); ?>">
                                                                                            <div id="e_myDropdown_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>"
                                                                                                class="dropdown-content w-100"
                                                                                                style="display:none; position:absolute; max-height:250px; overflow:auto; z-index:2000;">
                                                                                                <div
                                                                                                    id="e_item_list_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <input type="hidden"
                                                                                            id="e_item_id_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>"
                                                                                            name="addmore[<?php echo e($i); ?>][item_id]"
                                                                                            value="<?php echo e($detail->item_id); ?>">
                                                                                        <input type="hidden"
                                                                                            id="e_available_qty_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>"
                                                                                            value="<?php echo e(optional($detail->item)->quantity ?? 0); ?>">
                                                                                    </td>

                                                                                    <td>
                                                                                        <input type="number"
                                                                                            min="1"
                                                                                            id="e_qty_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>"
                                                                                            name="addmore[<?php echo e($i); ?>][quantity]"
                                                                                            class="form-control"
                                                                                            value="<?php echo e($detail->quantity); ?>"
                                                                                            onchange="e_subTotalCal(<?php echo e($salesOrder->id); ?>, <?php echo e($i); ?>)">
                                                                                    </td>

                                                                                    <td>
                                                                                        <input type="number"
                                                                                            id="e_u_price_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>"
                                                                                            name="addmore[<?php echo e($i); ?>][u_price]"
                                                                                            class="form-control"
                                                                                            value="<?php echo e($detail->amount); ?>"
                                                                                            onchange="e_subTotalCal(<?php echo e($salesOrder->id); ?>, <?php echo e($i); ?>)">
                                                                                    </td>

                                                                                    <td>
                                                                                        <input type="text"
                                                                                            id="e_sub_<?php echo e($salesOrder->id); ?>_<?php echo e($i); ?>"
                                                                                            class="form-control e_sub"
                                                                                            value="<?php echo e(number_format($detail->quantity * $detail->amount, 2, '.', '')); ?>"
                                                                                            readonly>
                                                                                    </td>

                                                                                    <td>
                                                                                        <button type="button"
                                                                                            class="btn btn-danger btn-sm"
                                                                                            onclick="e_removeRow(<?php echo e($salesOrder->id); ?>, <?php echo e($i); ?>)">
                                                                                            <i class="fa fa-trash"></i>
                                                                                        </button>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </tbody>
                                                                    </table>

                                                                    <a href="#" class="btn btn-success float-right"
                                                                        onclick="e_addNewRow(<?php echo e($salesOrder->id); ?>)">
                                                                        <i class="fa fa-plus-circle"></i> Add New Item
                                                                    </a>
                                                                </div>
                                                            </div>

                                                            <!-- Totals -->
                                                            <div class="row mt-3">
                                                                <div class="col-7">
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label>Discount (%)</label>
                                                                            <input type="number" name="discount"
                                                                                id="e_discount_percent_<?php echo e($salesOrder->id); ?>"
                                                                                value="<?php echo e($subtotal > 0 ? round(($salesOrder->discount / $subtotal) * 100, 2) : 0); ?>"
                                                                                class="form-control"
                                                                                onchange="e_calculater(<?php echo e($salesOrder->id); ?>)"
                                                                                onkeyup="e_calculater(<?php echo e($salesOrder->id); ?>)"
                                                                                min="0">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-2">
                                                                        <div class="col-md-6">
                                                                            <input type="checkbox"
                                                                                id="e_vat_include_<?php echo e($salesOrder->id); ?>"
                                                                                name="vat_include" value="0.15"
                                                                                <?php echo e($salesOrder->vat > 0 ? 'checked' : ''); ?>

                                                                                onchange="e_calculater(<?php echo e($salesOrder->id); ?>)">
                                                                            <label
                                                                                for="e_vat_include_<?php echo e($salesOrder->id); ?>">VAT
                                                                                (%)
                                                                            </label>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <input type="checkbox"
                                                                                id="e_with_holding_<?php echo e($salesOrder->id); ?>"
                                                                                name="with_holding" value="0.03"
                                                                                <?php echo e($salesOrder->with_holding > 0 ? 'checked' : ''); ?>

                                                                                onchange="e_calculater(<?php echo e($salesOrder->id); ?>)">
                                                                            <label
                                                                                for="e_with_holding_<?php echo e($salesOrder->id); ?>">Withholding
                                                                                (%)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-5">
                                                                    <p class="lead text-right">Total Due Amount</p>
                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <tr>
                                                                                <th>Subtotal:</th>
                                                                                <td><i
                                                                                        id="e_subtotal_<?php echo e($salesOrder->id); ?>"><?php echo e(number_format($subtotal, 2, '.', '')); ?></i>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Discount:</th>
                                                                                <td><i
                                                                                        id="e_discount_<?php echo e($salesOrder->id); ?>"><?php echo e(number_format($salesOrder->discount, 2, '.', '')); ?></i>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Tax:</th>
                                                                                <td><i
                                                                                        id="e_vat_<?php echo e($salesOrder->id); ?>"><?php echo e(number_format($salesOrder->vat, 2, '.', '')); ?></i>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>WithHolding:</th>
                                                                                <td><i
                                                                                        id="e_with_holding_val_<?php echo e($salesOrder->id); ?>"><?php echo e(number_format($salesOrder->with_holding, 2, '.', '')); ?></i>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Total:</th>
                                                                                <td><i
                                                                                        id="e_total_<?php echo e($salesOrder->id); ?>"><?php echo e(number_format($salesOrder->grand_total, 2, '.', '')); ?></i>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Buttons -->
                                                            <div class="row no-print">
                                                                <div class="col-12">
                                                                    <button type="submit"
                                                                        class="btn btn-success float-right">Update
                                                                        Order</button>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div><!-- /.col -->
                                            </div><!-- /.row -->
                                        </div><!-- /.container-fluid -->
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>

            </div>
        </div>
        </div>
    </section>
    <script>
        window.categories = <?php echo json_encode($categories, 15, 512) ?>;
        window.e_selectedItems = {}; // ✅ store selected items per orderId

        // Build categories array safely
        var categories = [
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $catValue = is_object($cat) ? $cat->name ?? ($cat->id ?? '') : $cat;
                    $catLabel = is_object($cat) ? $cat->name ?? $catValue : $catValue;
                ?> {
                    value: <?php echo json_encode($catValue); ?>,
                    label: <?php echo json_encode($catLabel); ?>

                }
                <?php if(!$loop->last): ?>
                    ,
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];

        function renderCategoryOptions() {
            if (!window.categories) return '';
            return window.categories.map(cat =>
                `<option value="${cat}">${cat}</option>`
            ).join('');
        }

        // jQuery ajax CSRF header
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        });

        // ------------------- ADD NEW ROW -------------------
        function e_addNewRow(orderId) {
            if (!window.e_selectedItems[orderId]) {
                window.e_selectedItems[orderId] = []; // ✅ init if not exists
            }

            let maxIdx = -1;
            $(`#e_add_items_${orderId} tr`).each(function() {
                let id = $(this).attr('id'); // e_row_{orderId}_{i}
                if (!id) return;
                let parts = id.split('_');
                let idx = parseInt(parts.pop());
                if (!isNaN(idx) && idx > maxIdx) maxIdx = idx;
            });
            let i = maxIdx + 1;

            let newRow = `
<tr id="e_row_${orderId}_${i}">
  <td style="width:300px;">
    <select id="e_category_${orderId}_${i}" class="form-control mb-2"
            onchange="e_loadItemsByCategory(${orderId}, ${i})">
      <option value="">-- Select Category --</option>
      ${renderCategoryOptions()}
    </select>

    <div class="dropdown w-100" style="position:relative;">
      <input type="text" placeholder="Search Item..." id="e_myInput_${orderId}_${i}"
             onclick="e_myFunction(${orderId}, ${i})"
             onkeyup="e_filterFunction(${orderId}, ${i})"
             class="form-control" autocomplete="off" disabled required>
      <div id="e_myDropdown_${orderId}_${i}" class="dropdown-content w-100"
           style="display:none; position:absolute; max-height:250px; overflow:auto; z-index:2000;">
        <div id="e_item_list_${orderId}_${i}"></div>
      </div>
    </div>

    <input type="hidden" id="e_item_id_${orderId}_${i}" name="addmore[${i}][item_id]">
    <input type="hidden" id="batch_id_${i}" name="addmore[${i}][batch_id]" value="">
    <input type="hidden" id="e_available_qty_${orderId}_${i}" value="">
  </td>

  <td>
    <input type="number" min="1" id="e_qty_${orderId}_${i}" name="addmore[${i}][quantity]"
           class="form-control" onchange="e_subTotalCal(${orderId}, ${i})">
  </td>

  <td>
    <input type="number" id="e_u_price_${orderId}_${i}" name="addmore[${i}][u_price]"
           class="form-control" onchange="e_subTotalCal(${orderId}, ${i})">
  </td>

  <td>
    <input type="text" id="e_sub_${orderId}_${i}" class="form-control e_sub" readonly>
  </td>

  <td>
    <button type="button" class="btn btn-danger btn-sm" onclick="e_removeRow(${orderId}, ${i})">
      <i class="fa fa-trash"></i>
    </button>
  </td>
</tr>`;

            $(`#e_add_items_${orderId}`).append(newRow);
        }

        // ------------------- LOAD ITEMS BY CATEGORY -------------------
        function e_loadItemsByCategory(orderId, rowIndex) {
            let location_id = $("#e_location_" + orderId).val();
            let categoryId = $("#e_category_" + orderId + "_" + rowIndex).val();

            if (!location_id || !categoryId) {
                $("#e_myInput_" + orderId + "_" + rowIndex)
                    .prop("disabled", true).val("");
                $("#e_item_list_" + orderId + "_" + rowIndex).empty();
                return;
            }

            $("#e_myInput_" + orderId + "_" + rowIndex).prop("disabled", false).val("");
            e_fetchItems(orderId, rowIndex, location_id, categoryId);
        }

        // ------------------- FETCH ITEMS -------------------
        function e_fetchItems(orderId, rowIndex, location_id, categoryId) {
            $.ajax({
                type: "POST",
                url: "<?php echo e(url('getItemForSale')); ?>",
                dataType: 'json',
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    location_id: location_id,
                    category_id: categoryId
                },
                success: function(result) {
                    let container = $(`#e_item_list_${orderId}_${rowIndex}`);
                    container.html('');

                    if (result.length === 0) {
                        container.html('<div style="padding:5px;color:red;">No items found</div>');
                    }

                    $.each(result, function(_, item) {
                        // ✅ skip already selected in this order
                        if (window.e_selectedItems[orderId].includes(item.id)) return;

                        let option = $(`
                        <div style="cursor:pointer; padding:5px; border-bottom:1px solid #eee;">
                            ${item.item_name} | ${item.product_code}
                        </div>
                    `);
                        option.on('click', function() {
                            e_selectedItem(item, orderId, rowIndex);
                        });
                        container.append(option);
                    });

                    $(`#e_myDropdown_${orderId}_${rowIndex}`).show();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // ------------------- FILTER -------------------
        function e_myFunction(orderId, rowIndex) {
            let category = $(`#e_category_${orderId}_${rowIndex}`).val();
            let loc = $(`#e_location_${orderId}`).val();
            if (!category || !loc) return;
            e_fetchItems(orderId, rowIndex, loc, category);
        }

        function e_filterFunction(orderId, rowIndex) {
            let filter = $(`#e_myInput_${orderId}_${rowIndex}`).val().toUpperCase();
            $(`#e_item_list_${orderId}_${rowIndex} > div`).each(function() {
                $(this).toggle($(this).text().toUpperCase().indexOf(filter) > -1);
            });
            $(`#e_myDropdown_${orderId}_${rowIndex}`).show();
        }

        // ------------------- SELECT ITEM -------------------
        function e_selectedItem(item, orderId, rowIndex) {
            $(`#e_myInput_${orderId}_${rowIndex}`).val(
                item.item_name + ' | ' + item.product_code + (item.batch_number ? ' | ' + item.batch_number : '')
            );
            $(`#e_item_id_${orderId}_${rowIndex}`).val(item.id);

            $(`#e_available_qty_${orderId}_${rowIndex}`).val(item.quantity || 0);

            // ✅ store selected item
            if (!window.e_selectedItems[orderId].includes(item.id)) {
                window.e_selectedItems[orderId].push(item.id);
            }

            // set price
            let prices = [item.selling_price1, item.selling_price2, item.selling_price3].map(p => parseFloat(p || 0));
            let valid = prices.filter(p => p > 0);
            let minPrice = valid.length ? Math.min(...valid) : (parseFloat(item.selling_price1 || 0) || 0);
            if (minPrice > 0) $(`#e_u_price_${orderId}_${rowIndex}`).val(minPrice);

            $(`#e_myDropdown_${orderId}_${rowIndex}`).hide();
            e_subTotalCal(orderId, rowIndex);
        }

        // ------------------- SUBTOTAL -------------------
        function e_subTotalCal(orderId, rowIndex) {
            let qty = parseFloat($(`#e_qty_${orderId}_${rowIndex}`).val()) || 0;
            if (qty < 1) {
                qty = 1;
                $(`#e_qty_${orderId}_${rowIndex}`).val(qty);
            }

            let available = parseInt($(`#e_available_qty_${orderId}_${rowIndex}`).val()) || 0;
            if (available > 0 && qty > available) {
                alert(`Quantity must be ≤ available stock (${available})`);
                qty = available;
                $(`#e_qty_${orderId}_${rowIndex}`).val(available);
            }

            let price = parseFloat($(`#e_u_price_${orderId}_${rowIndex}`).val()) || 0;
            let subtotal = qty * price;

            $(`#e_sub_${orderId}_${rowIndex}`).val(subtotal.toFixed(2));
            e_calculater(orderId);
        }

        // ------------------- TOTAL -------------------
        function e_calculater(orderId) {
            let subtotal = 0;
            $(`#e_add_items_${orderId} .e_sub`).each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });

            let discountRate = parseFloat($(`#e_discount_percent_${orderId}`).val()) || 0;

            let vatRate = $(`#e_vat_include_${orderId}`).is(':checked') ? (parseFloat($(`#e_vat_include_${orderId}`)
                .val()) || 0.15) : 0;
            let withHoldingRate = $(`#e_with_holding_${orderId}`).is(':checked') ? (parseFloat($(
                `#e_with_holding_${orderId}`).val()) || 0.03) : 0;

            let discount = subtotal * discountRate / 100;
            let afterDiscount = subtotal - discount;
            let vat = afterDiscount * vatRate;
            let withHold = afterDiscount * withHoldingRate;

            let total = afterDiscount + vat - withHold;

            $(`#e_subtotal_${orderId}`).text(subtotal.toFixed(2));
            $(`#e_discount_${orderId}`).text(discount.toFixed(2));
            $(`#e_vat_${orderId}`).text(vat.toFixed(2));
            $(`#e_with_holding_val_${orderId}`).text(withHold.toFixed(2));
            $(`#e_total_${orderId}`).text(total.toFixed(2));

            $(`#e_discountRate_${orderId}`).text(`Discount(${discountRate}%)`);
            $(`#e_vatRate_${orderId}`).text(`Tax(${(vatRate * 100).toFixed(0)}%)`);
            $(`#e_withHoldingRate_${orderId}`).text(`WithHolding(${(withHoldingRate * 100).toFixed(0)}%)`);
        }

        // ------------------- REMOVE ROW -------------------
        function e_removeRow(orderId, rowIndex) {
            let removedId = $(`#e_item_id_${orderId}_${rowIndex}`).val();
            if (removedId) {
                // ✅ remove from selected list
                window.e_selectedItems[orderId] = window.e_selectedItems[orderId].filter(id => id != removedId);
            }
            $(`#e_row_${orderId}_${rowIndex}`).remove();
            e_calculater(orderId);
        }

        // ------------------- LISTENERS -------------------
        $(document).on('input change', "[id^='e_qty_'], [id^='e_u_price_']", function() {
            let id = $(this).attr('id');
            let parts = id.split('_');
            let rowIndex = parts.pop();
            let orderId = parts.pop();
            if (!isNaN(orderId) && !isNaN(rowIndex)) {
                e_subTotalCal(orderId, rowIndex);
            }
        });

        $(document).on('change keyup', "[id^='e_discount_percent_'], [id^='e_vat_include_'], [id^='e_with_holding_']",
            function() {
                let id = $(this).attr('id');
                let parts = id.split('_');
                let orderId = parts[parts.length - 1];
                if (!isNaN(orderId)) e_calculater(orderId);
            });

        // close dropdowns on outside click
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-content').hide();
            }
        });

        // init calculations
        $(function() {
            $("tbody[id^='e_add_items_']").each(function() {
                let id = $(this).attr('id').replace('e_add_items_', '');
                if (id) e_calculater(id);
            });
        });
    </script>

    <script>
        var i = 0;
        var selectedItems = []; // ✅ track selected item IDs globally

        // Get categories from PHP safely
        var categories = <?php echo json_encode(\App\Models\Item::select('category')->distinct()->pluck('category'), 15, 512) ?>;

        // ------------------- ADD NEW ROW -------------------
        $("#add_new_items").click(function(e) {
            e.preventDefault();
            ++i;
            var categoryOptions = `<option value="">-- Select Category --</option>`;
            categories.forEach(function(cat) {
                categoryOptions += `<option value="${cat}">${cat}</option>`;
            });

            $("#add_items").append(`
<tr id="row_${i}">
    <td style="width: 350px;">
        <select id="category_${i}" class="form-control mb-2" onchange="loadItemsByCategory(${i})">
            ${categoryOptions}
        </select>
        <div class="dropdown w-100 mb-2" style="position:relative">
            <input type="text" placeholder="Search Item..." id="myInput_${i}"
                   onclick="myFunction(${i})" onkeyup="filterFunction(${i})"
                   class="form-control" autocomplete="off" disabled required>
            <div id="myDropdown_${i}" class="dropdown-content w-100"
                 style="display:none; position:absolute; z-index:1000; max-height:250px; overflow:auto;">
                <div id="item_list_${i}"></div>
            </div>
        </div>
        <input type="hidden" id="item_id_${i}" name="addmore[${i}][item_id]" value="">
        <input type="hidden" id="batch_id_${i}" name="addmore[${i}][batch_id]" value="">
          <input type="hidden" id="selling_price2_${i}" name="addmore[${i}][selling_price2]" value="">
        <div id="selected_image_${i}" class="mt-2"></div>
    </td>
    <td>
        <input type="number" min="1" id="qty_${i}" name="addmore[${i}][quantity]"
               onchange="subTotalCal(${i})" class="form-control" placeholder="Quantity" required>
    </td>
    <td>
        <input type="number" id="u_price_${i}" name="addmore[${i}][u_price]"
               onchange="subTotalCal(${i})" class="form-control" style="width:120px;" required>
    </td>
    <input type="hidden" id="available_qty_${i}" value="">
    <td>
        <input type="text" id="sub_${i}" class="form-control sub" placeholder="Sub Total" disabled>
    </td>
    <td>
        <button type="button" class="remove-tr"><b style="color:red">X</b></button>
    </td>
</tr>
        `);
        });

        // ------------------- REMOVE ROW -------------------
        $(document).on('click', '.remove-tr', function() {
            var row = $(this).closest('tr');
            var removedId = row.find("input[name*='item_id']").val();
            if (removedId) {
                selectedItems = selectedItems.filter(id => id != removedId); // ✅ allow reuse
            }
            row.remove();
            calculateTotal();
        });

        // ------------------- LOAD ITEMS BY CATEGORY -------------------
        function loadItemsByCategory(no) {
            var location_id = $("#location").val();
            var category = $('#category_' + no).val();
            if (!category) {
                $('#myInput_' + no).prop('disabled', true).val('');
                $('#item_list_' + no).empty();
                return;
            }
            $('#myInput_' + no).prop('disabled', false);
            fetchItems(no, location_id, category);
        }

        // ------------------- FETCH ITEMS -------------------
        function fetchItems(no, location_id, category) {
            $.ajax({
                type: "POST",
                url: "<?php echo e(url('getItemForSale')); ?>",
                dataType: 'json',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    location_id: location_id,
                    category: category
                },
                success: function(result) {
                    var container = $('#item_list_' + no);
                    container.html('');

                    $.each(result, function(idx, item) {
                        // ✅ Skip already selected items
                        if (selectedItems.includes(String(item.id))) return;

                        var imageUrl = item.image ? item.image : "<?php echo e(asset('images/no-image.png')); ?>";

                        // ✅ Build clean display text
                        var displayText = `${item.item_name} | ${item.product_code}`;
                        if (item.batch_number) displayText += ` | Batch: ${item.batch_number}`;
                        if (item.selling_price2) displayText +=
                            ` |max-p: ${item.selling_price2}`;

                        // ✅ Create clickable option
                        var option = $(`
                    <div style="padding:8px; cursor:pointer; border-bottom:1px solid #eee; display:flex; align-items:center; justify-content:space-between;">
                        <div style="flex:1;">${displayText}</div>
                        <img src="${imageUrl}" width="40" height="40" style="object-fit:cover; margin-left:10px; border:1px solid #ccc; border-radius:4px;">
                    </div>
                `);

                        option.on('click', function() {
                            selectedItem(item, no);
                        });

                        container.append(option);
                    });

                    $('#myDropdown_' + no).show();
                },
                error: function(err) {
                    console.error('Could not fetch items', err);
                }
            });
        }


        function myFunction(no) {
            var location_id = $("#location").val();
            var category = $('#category_' + no).val();
            if (!category) return;
            fetchItems(no, location_id, category);
        }

        function filterFunction(no) {
            var input = $("#myInput_" + no).val().toUpperCase();
            var found = false;

            $("#item_list_" + no + " > div").each(function() {
                var text = $(this).text().toUpperCase();
                var match = text.indexOf(input) > -1;
                $(this).toggle(match);
                if (match) found = true;
            });

            if (found) {
                $('#myDropdown_' + no).show();
            } else {
                $('#myDropdown_' + no).hide();
            }
        }

        // ------------------- SELECT ITEM -------------------
        function selectedItem(item, no) {
            var imageUrl = item.image ? item.image : "<?php echo e(asset('images/no-image.png')); ?>";
            $('#myInput_' + no).val((item.item_name || '') + " | " + (item.product_code || '') +
                (item.batch_number ? " | Batch: " + item.batch_number : ""));
            $('#item_id_' + no).val(item.id);
            $('#batch_id_' + no).val(item.batch_id ?? '');
            $('#selling_price2_' + no).val(item.selling_price2 ?? '');
            $('#available_qty_' + no).val(item.quantity ?? 0);

            $('#selected_image_' + no).html(`
            <img src="${imageUrl}" width="70" height="70" class="img-thumbnail" style="cursor:pointer;" onclick="showImageModal('${imageUrl}')">
        `);

            // ✅ Add to selectedItems
            if (!selectedItems.includes(String(item.id))) {
                selectedItems.push(String(item.id));
            }

            // Set minimum price (selling_price1) if exists
            var prices = [item.selling_price1, item.selling_price2, item.selling_price3]
                .map(p => parseFloat(p || 0)).filter(p => p > 0);
            var minPrice = prices.length ? Math.min(...prices) : 0;
            if (minPrice && minPrice > 0) {
                $('#u_price_' + no).val(minPrice.toFixed(2));
            }

            if ($('#selling_price1_' + no).length === 0) {
                $('#row_' + no).append(
                    `<input type="hidden" id="selling_price1_${no}" value="${item.selling_price1 || 0}">`
                );
            } else {
                $('#selling_price1_' + no).val(item.selling_price1 || 0);
            }

            $('#myDropdown_' + no).hide();
            subTotalCal(no);
        }

        // ------------------- IMAGE MODAL -------------------
        function showImageModal(url) {
            $('#modalImage').attr('src', url);
            $('#imageModal').modal('show');
        }

        // ------------------- CALCULATE SUBTOTAL -------------------
        function subTotalCal(i) {
            var qty = parseInt($('#qty_' + i).val()) || 1;
            var available = parseInt($('#available_qty_' + i).val()) || 0;
            var enteredPrice = parseFloat($('#u_price_' + i).val()) || 0;
            var sellingPrice1 = parseFloat($('#selling_price1_' + i).val()) || 0;

            if (available > 0 && qty > available) {
                alert('Quantity must be ≤ available stock (' + available + ')');
                qty = available;
                $('#qty_' + i).val(qty);
            }

            if (sellingPrice1 > 0 && enteredPrice < sellingPrice1) {
                alert('Unit Price cannot be less than Selling Price 1 (' + sellingPrice1 + ')');
                $('#u_price_' + i).val(sellingPrice1.toFixed(2));
                enteredPrice = sellingPrice1;
            }

            var subtotal = qty * enteredPrice;
            $('#sub_' + i).val(subtotal.toFixed(2));
            calculateTotal();
        }

        // ------------------- CALCULATE TOTAL -------------------
        function calculateTotal() {
            var subtotal = 0;
            $('.sub').each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });

            var discountPercent = parseFloat($('#discount_percent').val()) || 0;
            var discountRate = discountPercent / 100;

            var vatRate = $('#vat_include').is(':checked') ? parseFloat($('#vat_include').val()) || 0 : 0;
            var withHoldingRate = $('#with_holding').is(':checked') ? parseFloat($('#with_holding').val()) || 0 : 0;

            var discount = subtotal * discountRate;
            var afterDiscount = subtotal - discount;

            var vat = afterDiscount * vatRate;
            var withHolding = afterDiscount * withHoldingRate;

            var total = afterDiscount + vat - withHolding;

            $('#sub').text(subtotal.toFixed(2));
            $('#discount').text(discount.toFixed(2));
            $('#vat').text(vat.toFixed(2));
            $('#with_hold').text(withHolding.toFixed(2));
            $('#tot').text(total.toFixed(2));

            $('#discountRate').text(`Discount(${discountPercent}%)`);
            $('#vatRate').text(`Tax(${(vatRate * 100).toFixed(2)}%)`);
            $('#withHoldingRate').text(`WithHolding(${(withHoldingRate * 100).toFixed(2)}%)`);
        }

        // Auto calculate on modal show
        $('#modal-lg').on('shown.bs.modal', function() {
            calculateTotal();
        });
    </script>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/sales/sales.blade.php ENDPATH**/ ?>