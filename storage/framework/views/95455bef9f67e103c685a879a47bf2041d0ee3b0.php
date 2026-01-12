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
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>SetAction</th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                <?php if(count($items) > 0): ?>
                                    <?php
                                        $no = 0;
                                    ?>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $no = $no + 1;
                                        ?>
                                        <tr>
                                            <td><?php echo e($no); ?></td>
                                            <?php
                                                $imagePath1 = str_replace('\\', '/', $item->image);
                                                $imagePath2 = str_replace('\\', '/', $item->image2);
                                            ?>
                                            <td><?php echo e($item->item_name); ?></td>
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
                                                <td><?php echo e($item->product_code); ?></td>
                                            <?php endif; ?>
                                            <?php if($permission->manage_partNumber2 == 'on'): ?>
                                                <td><?php echo e($item->part_number); ?></td>
                                            <?php endif; ?>
                                            <td><?php echo e($item->item_code); ?></td>
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
                                            <td><?php echo e($item->reorder); ?></td>

                                            <td><?php echo e($item->selling_price1); ?></td>
                                            <td><?php echo e($item->selling_price2); ?></td>
                                            <td>
                                                <a type="button" class="btn btn-secondary btn-sm"
                                                    href="batchs-<?php echo e($item->id); ?>">
                                                    <i class="fas fa-plus"></i> Set Batch
                                                </a>
                                            </td>
                                            <td>
                                                <a type="button" class="btn bg-primary btn-sm"
                                                    href="itemShelf-<?php echo e($item->id); ?>">
                                                    <i class="fas fa-plus"></i> Set Shelf
                                                </a>
                                            </td>
                                            <td>
                                                <a type="button" class="btn btn-warning btn-xs"
                                                    href="set_opening_balance-<?php echo e($item->id); ?>">
                                                    <i class="fas fa-view"> SetCurrentStock</i>
                                                </a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn bg-info btn-sm" data-toggle="modal"
                                                    data-target="#modal-lgplan-<?php echo e($item->id); ?>">
                                                    <i class="fas ">move</i>
                                                </button>

                                            </td>

                                            <td>
                                                <?php if($permission->manage_edit_item == 'on'): ?>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal" data-target="#modal-lg-<?php echo e($item->id); ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                <?php endif; ?>
                                                
                                                <?php if($permission->manage_delete_item == 'on'): ?>
                                                    <a type="button" class="btn btn-danger btn-sm"
                                                        href="delete-item-<?php echo e($item->id); ?>"
                                                        onclick="return confirm('Are you sure you ?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>



                                        <div class="modal fade" id="modal-lgplan-<?php echo e($item->id); ?>">
                                            <div class="modal-dialog modal-lgplan-<?php echo e($item->id); ?>">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Move To Plan</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <!-- left column -->
                                                                <div class="col-md-12">
                                                                    <!-- jquery validation -->
                                                                    <div class="card card-primary">
                                                                        <div class="card-header">
                                                                        </div>
                                                                        <div>
                                                                            <form
                                                                                action="<?php echo e(route('purchase-plan.move', $item->id)); ?>"
                                                                                method="POST">
                                                                                <?php echo csrf_field(); ?>
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label>Quantity</label>
                                                                                            <input type="number"
                                                                                                name="quantity"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="form-group">
                                                                                            <label>Message</label>
                                                                                            <input type="text"
                                                                                                name="message"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="submit"
                                                                                    class="btn btn-sm bg-info">
                                                                                    submit
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                        <!-- /.card -->
                                                                    </div>

                                                                    <!--/.col (right) -->
                                                                </div>
                                                                <!-- /.row -->
                                                            </div><!-- /.container-fluid -->

                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        </div>

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
                                                                    <h3 class="card-title">item
                                                                        <small>Information</small>
                                                                    </h3>
                                                                </div>
                                                                <!-- /.card-header -->
                                                                <!-- form start -->
                                                                <form action="/edit-item-<?php echo e($item->id); ?>"
                                                                    method="POST" id="quickForm"
                                                                    enctype="multipart/form-data">
                                                                    <?php echo csrf_field(); ?>
                                                                    <div class="card-body">
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
                                                                                    <label>p-No 1</label>
                                                                                    <input type="text"
                                                                                        name="product_code"
                                                                                        class="form-control"
                                                                                        value="<?php echo e($item->product_code); ?>"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>p-No 2</label>
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
                                                                                            <?php echo e($item->category); ?>

                                                                                        </option>
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
                                                                                    <label>Other Unit</label>
                                                                                    <input type="text"
                                                                                        name="other_unit"
                                                                                        class="form-control"
                                                                                        placeholder=""
                                                                                        value="<?php echo e($item->other_unit); ?>">
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
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Re-Order Level</label>
                                                                                    <input type="number" name="reorder"
                                                                                        class="form-control"
                                                                                        placeholder="Re Order Level"
                                                                                        value="<?php echo e($item->reorder); ?>">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>ReOrder ForShop </label>
                                                                                    <input type="number"
                                                                                        name="reorder_for_shop"
                                                                                        class="form-control"
                                                                                        placeholder="Re Order forShop"
                                                                                        value="<?php echo e($item->reorder_for_shop); ?>">
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
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>image 1</label>
                                                                                    <input type="file" name="image"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>


                                                                        </div>
                                                                        <div class="row">
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
                                    <h2>No item Found !</h2>
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
                                <h4 class="modal-title">New item</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">item <small>Information</small></h3>
                                        </div>
                                        <!-- form start -->
                                        <form action="/add-item" method="POST" id="quickForm"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Item Name</label>
                                                            <input type="text" name="item_name" class="form-control"
                                                                placeholder="Item Name" required>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="request_token"
                                                        value="<?php echo e(Str::uuid()); ?>">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>p-No 1</label>
                                                            <input type="text" name="product_code"
                                                                class="form-control" value=""
                                                                placeholder="Part number 1">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>p-No 2</label>
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
                                                            <label>Other Unit</label>
                                                            <input type="text" name="other_unit" class="form-control"
                                                                placeholder="">
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
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Re-Order Level</label>
                                                            <input type="number" name="reorder" class="form-control"
                                                                placeholder="Re Order Level">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>ReOrder ForShop </label>
                                                            <input type="number" name="reorder_for_shop"
                                                                class="form-control" placeholder="Re Order forShop"
                                                                value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <input type="text" name="description" class="form-control"
                                                                placeholder="Description">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>image 1</label>
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

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

                <!-- /.modal -->
            </div>
        </div>
        </div>
    </section>
    <script>
        function setModalImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('quickForm');
            form.addEventListener('submit', function(e) {
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = "Processing...";
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\user\Documents\amarImsfinal\resources\views/pages/items/item.blade.php ENDPATH**/ ?>