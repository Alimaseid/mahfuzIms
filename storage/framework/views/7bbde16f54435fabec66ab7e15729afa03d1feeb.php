<?php $__env->startSection('content'); ?>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8 lg">
                                    <div class="pl-3"> <small>TotalOrders: </small><b> <?php echo e(count($good_receivings)); ?></b>
                                    </div>
                                </div>
                                <div class="col-4 lg">
                                    <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                        data-toggle="modal" data-target="#modal-lg">
                                        New Good Receiving
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="<?php echo e(route('good-receivings.import')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Select Excel File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Import Goods</button>
                </form>

                <div class="card">
                    <div class="card-body">
                        
                        <table id="example1" class="table table-bordered table-striped "
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ReceivingDate</th>
                                    <th>ItemName </th>
                                    <th>Category</th>
                                    <th>Shelf Location</th>
                                    <th style="background-color: rgb(2, 2, 39)">Part Number</th>
                                    <th style="background-color: rgb(2, 2, 39)">Quantity</th>
                                    <th>CostPrice</th>
                                    <th>Price1</th>
                                    <th>Price2</th>
                                    <th>SetAction</th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                <?php if(count($good_receivings) > 0): ?>
                                    <?php
                                        $no = 0;
                                    ?>
                                    <?php $__currentLoopData = $good_receivings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $no = $no + 1;
                                        ?>
                                        <tr>
                                            <td><?php echo e($no); ?></td>
                                            <td><?php echo e($item->receiving_date); ?></td>
                                            <?php
                                                $imagePath1 = str_replace('\\', '/', $item->image);
                                                $imagePath2 = str_replace('\\', '/', $item->image2);
                                            ?>

                                            <td style="display: flex; align-items: center; gap: 10px;">
                                                <span><?php echo e($item->item_name); ?></span>
                                                <img src="<?php echo e(asset($imagePath1)); ?>" alt=""
                                                    style="width: 25px; height: 25px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                    data-toggle="modal" data-target="#imageModal"
                                                    onclick="setModalImage('<?php echo e(asset($imagePath1)); ?>')">

                                                <img src="<?php echo e(asset($imagePath2)); ?>" alt=""
                                                    style="width: 25px; height: 25px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                    data-toggle="modal" data-target="#imageModal"
                                                    onclick="setModalImage('<?php echo e(asset($imagePath2)); ?>')">


                                            </td>

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
                                            <td><?php echo e($item->category); ?></td>
                                            <td><?php echo e($item->shelf->shelf_name ?? '-'); ?></td>
                                            <td style="background-color: rgb(2, 2, 39)"><a type="button"
                                                    style="color: gold" href="#"data-toggle="modal"
                                                    data-target="#modal-lg-O-<?php echo e($item->id); ?>"><?php echo e($item->product_code); ?></a>
                                            </td>
                                            <td style="background-color: rgb(2, 2, 39)"> <a type="button"
                                                    style="color: rgb(6, 248, 6)" href="#"data-toggle="modal"
                                                    data-target="#modal-lg-O-<?php echo e($item->id); ?>"><?php echo e($item->quantity); ?></a>
                                            </td>
                                            <td><?php echo e($item->cost_price); ?></td>
                                            <td><?php echo e($item->selling_price1); ?></td>
                                            <td><?php echo e($item->selling_price2); ?></td>

                                            

                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-<?php echo e($item->id); ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <a type="button" class="btn btn-danger btn-sm" href="delete-purchase-order"
                                                    onclick="return confirm('Are you sure you ?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>


                                        <!-- /.card -->

                                        <div class="modal fade" id="modal-lg-<?php echo e($item->id); ?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit <?php echo e($item->item_name); ?></h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">

                                                            <div class="card card-primary">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">GoodReceiving
                                                                        <small>Information</small>
                                                                    </h3>
                                                                </div>
                                                                <!-- /.card-header -->
                                                                <!-- form start -->
                                                                <form action="/edit-purchase-order-<?php echo e($item->id); ?>"
                                                                    method="POST" id="quickForm"
                                                                    enctype="multipart/form-data">
                                                                    <?php echo csrf_field(); ?>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Receiving Date</label>
                                                                                    <input type="text"
                                                                                        name="receiving_date"
                                                                                        class="form-control"
                                                                                        value=" <?php echo e($item->receiving_date); ?>"
                                                                                        placeholder="date">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label> Store Location</label>
                                                                                    <select name="location_name"
                                                                                        class="form-control">
                                                                                        <option value="">
                                                                                            <?php echo e($item->location_name); ?>

                                                                                        </option>
                                                                                        <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                            <option
                                                                                                value="<?php echo e($businessLocation->name); ?>">
                                                                                                <?php echo e($businessLocation->name); ?>

                                                                                            </option>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                        <?php endif; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Invoice No</label>
                                                                                    <input type="text"
                                                                                        name="invoice_no"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->invoice_no); ?> "
                                                                                        placeholder="">
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Item Name</label>
                                                                                    <input type="text" name="item_name"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->item_name); ?>"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>part Number 1</label>
                                                                                    <input type="text"
                                                                                        name="product_code"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->product_code); ?>"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>part Number 2</label>
                                                                                    <input type="text"
                                                                                        name="part_number"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->part_number); ?>"
                                                                                        required>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Item Code</label>
                                                                                    <input type="text" name="item_code"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->item_code); ?> "
                                                                                        placeholder="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Category</label>
                                                                                    <select name="category"
                                                                                        class="form-control"
                                                                                        id="" required>
                                                                                        <option
                                                                                            value="<?php echo e($item->category); ?>">
                                                                                            <?php echo e($item->category); ?></option>
                                                                                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                            <option
                                                                                                value="<?php echo e($category->name); ?>">
                                                                                                <?php echo e($category->name); ?>

                                                                                            </option>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                        <?php endif; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Shelf</label>
                                                                                    <select name="shelves_id"
                                                                                        class="form-control"
                                                                                        id="" required>
                                                                                        <?php $__empty_1 = true; $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                            <?php if($item->shelves_id == $shelf->id): ?>
                                                                                                <option
                                                                                                    value="<?php echo e($item->shelves_id); ?>">
                                                                                                    <?php echo e($shelf->shelf_name); ?>

                                                                                                </option>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                        <?php endif; ?>
                                                                                        <?php $__empty_1 = true; $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                            <option
                                                                                                value="<?php echo e($shelf->id); ?>">
                                                                                                <?php echo e($shelf->shelf_name); ?>

                                                                                            </option>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                        <?php endif; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Unit</label>
                                                                                    <select name="unit"
                                                                                        class="form-control"
                                                                                        id="" required>
                                                                                        <?php $__empty_1 = true; $__currentLoopData = $item_units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                            <option
                                                                                                value="<?php echo e($item_unit->unit); ?>">
                                                                                                <?php echo e($item_unit->unit); ?>

                                                                                            </option>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                        <?php endif; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Batch Number</label>
                                                                                    <input type="text" name="bar_code"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->bar_code); ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Brand</label>
                                                                                    <input type="text" name="brand"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->brand); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Cost Price</label>
                                                                                    <input type="number" step="any"
                                                                                        name="cost_price"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->cost_price); ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Price 1</label>
                                                                                    <input type="number" step="any"
                                                                                        name="selling_price1"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->selling_price1); ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Price 2</label>
                                                                                    <input type="number" step="any"
                                                                                        name="selling_price2"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->selling_price2); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>CurruntStock</label>
                                                                                    <input type="number" step="any"
                                                                                        name="quantity"
                                                                                        class="form-control"
                                                                                        placeholder="Quantity"
                                                                                        value="<?php echo e($item->quantity); ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Re-Order Level</label>
                                                                                    <input type="number" name="reorder"
                                                                                        class="form-control"
                                                                                        placeholder="Re Order Level"
                                                                                        value="<?php echo e($item->reorder); ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Description</label>
                                                                                    <input type="text"
                                                                                        name="description"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->description); ?>"
                                                                                        placeholder="Description">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>image 1</label>
                                                                                    <input type="file" name="image"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>image 2</label>
                                                                                    <input type="file" name="image2"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary swalDefaultSuccess"
                                                                                onclick="return confirm('Are you sure? Save Changes !!!');">Save
                                                                                Change</button>
                                                                        </div>
                                                                </form>
                                                            </div>
                                                            <!-- /.card -->
                                                        </div><!-- /.container-fluid -->

                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>

                                        <!-- /.modal -->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <h2>No GoodReceiving Found !</h2>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="modal fade" id="modal-lg">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New GoodReceiving</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">

                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">GoodReceiving <small>Information</small></h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form action="/add-purchase-order" method="POST" id="quickForm"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Receiving Date</label>
                                                            <input type="date" name="receiving_date"
                                                                class="form-control" value="<?php echo e(now()->format('Y-m-d')); ?>"
                                                                placeholder="date">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label> Store Location</label>
                                                            <select name="location_name" class="form-control" required>
                                                                <option value="">Select</option>
                                                                <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <option value="<?php echo e($businessLocation->name); ?>">
                                                                        <?php echo e($businessLocation->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Invoice No</label>
                                                            <input type="text" name="invoice_no" class="form-control"
                                                                value="<?php echo e('I-No-' . random_int(0000001, 9999999)); ?> "
                                                                placeholder="">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Item Name</label>
                                                            <select name="item_name" class="form-control" required>
                                                                <option value="">Select</option>
                                                                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <option value="<?php echo e($item->item_name); ?>">
                                                                        <?php echo e($item->item_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Part Number 1</label>
                                                            <input type="text" name="product_code"
                                                                class="form-control" value=""
                                                                placeholder="Part number 1">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Part Number 2</label>
                                                            <input type="text" name="part_number" class="form-control"
                                                                value="" placeholder="Part number 2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Item Code</label>
                                                            <input type="text" name="item_code" class="form-control"
                                                                value="<?php echo e('Item-C-' . random_int(0000001, 9999999)); ?> "
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Category</label>
                                                            <select name="category" class="form-control" id=""
                                                                required>
                                                                <option value="">Select</option>
                                                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <option value="<?php echo e($category->name); ?>">
                                                                        <?php echo e($category->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Shelf</label>
                                                            <select name="shelves_id" class="form-control" id=""
                                                                required>
                                                                <option value="">Select</option>
                                                                <?php $__empty_1 = true; $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <option value="<?php echo e($shelf->id); ?>">
                                                                        <?php echo e($shelf->shelf_name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Unit</label>
                                                            <select name="unit" class="form-control" id=""
                                                                required>
                                                                <option value="">Select</option>
                                                                <?php $__empty_1 = true; $__currentLoopData = $item_units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <option value="<?php echo e($item_unit->unit); ?>">
                                                                        <?php echo e($item_unit->unit); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <?php endif; ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Batch Number</label>
                                                            <input type="text" name="bar_code" class="form-control"
                                                                placeholder="Batch Number">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Brand</label>
                                                            <input type="text" name="brand" class="form-control"
                                                                placeholder="Brand">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Cost Price</label>
                                                            <input type="number" step="any" name="cost_price"
                                                                class="form-control" placeholder="Cost Price">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Price 1</label>
                                                            <input type="number" step="any" name="selling_price1"
                                                                class="form-control" placeholder="Selling Price 1">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Price 2</label>
                                                            <input type="number" step="any" name="selling_price2"
                                                                class="form-control" placeholder="Selling Price 2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>CurruntStock</label>
                                                            <input type="number" step="any" name="quantity"
                                                                class="form-control" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Re-Order Level</label>
                                                            <input type="number" name="reorder" class="form-control"
                                                                placeholder="Re Order Level">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <input type="text" name="description" class="form-control"
                                                                placeholder="Description">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>image 1</label>
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>image 2</label>
                                                            <input type="file" name="image2" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-primary swalDefaultSuccess">Register</button>
                                                </div>
                                        </form>
                                    </div>
                                    <!-- /.card -->
                                </div><!-- /.container-fluid -->

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>





            </div>
        </div>
        </div>
    </section>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/goodreceiving/good_receiving.blade.php ENDPATH**/ ?>