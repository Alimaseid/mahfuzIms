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
                      <button type="button" class="btn btn-primary pull-rigth btn-sm" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                        New Item
                      </button>
                    </div>
                </div>
             </div>
           </div>
          </div>

              <div class="card">
                <div class="card-body">
                    
                  <table id="example1" class="table table-bordered table-striped " style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      
                      <th>ItemName</th>
                      <th>Category</th>
                      <th style="background-color: rgb(2, 2, 39)">P_Code</th>
                      <th style="background-color: rgb(2, 2, 39)">Quantity</th>
                      <th>CostPrice</th>
                      <th>Price1</th>
                      <th>Price2</th>
                      <th>Price3</th>
                      
                      <th>Status</th>
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
                            
                            <td><?php echo e($item->item_name); ?></td>
                            <td><?php echo e($item->category); ?></td>
                           <td style="background-color: rgb(2, 2, 39)"><a  type="button" style="color: gold" href="#"data-toggle="modal" data-target="#modal-lg-O-<?php echo e($item->id); ?>"><?php echo e($item->product_code); ?></a></td>
                            <td style="background-color: rgb(2, 2, 39)"> <a  type="button" style="color: rgb(6, 248, 6)" href="#"data-toggle="modal" data-target="#modal-lg-O-<?php echo e($item->id); ?>"><?php echo e($item->quantity); ?></a></td>
                            <td><?php echo e($item->cost_price); ?></td>
                            <td><?php echo e($item->selling_price1); ?></td>
                            <td><?php echo e($item->selling_price2); ?></td>
                            <td><?php echo e($item->selling_price3); ?></td>
                            
                            <td>
                                <a type="button" class="btn btn-warning btn-xs" href="activate-item-<?php echo e($item->id); ?>" onclick="return confirm('Are you sure you ?');">
                                    <?php echo e($item->status); ?>

                                  </a>
                            </td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-<?php echo e($item->id); ?>">
                              <i class="fas fa-edit"></i>
                              </button>
                              
                              <a type="button" class="btn btn-danger btn-sm" href="#" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                        </tr>


                        <div class="modal fade" id="modal-lg-O-<?php echo e($item->id); ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Product Code -  <?php echo e($item->product_code); ?></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-3">
                                           Owner
                                        </div>
                                        <div class="col-3">
                                            Item
                                        </div>
                                        <div class="col-3">
                                            Location
                                        </div>
                                        <div class="col-3">
                                            Quantity
                                        </div>
                                    </div>
                                    <hr>
                                    <?php $__empty_1 = true; $__currentLoopData = $item_owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php if($owner->item_id == $item->id): ?>
                                            <?php $__empty_2 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $own): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                <?php $__empty_3 = true; $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                                    <?php if($own->id == $owner->owner_id && $loc->id == $owner->location_id): ?>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                 <a href=""> <?php echo e($own->name); ?> </a>
                                                            </div>
                                                            <div class="col-3">
                                                                <?php echo e($item->product_code); ?>

                                                            </div>
                                                            <div class="col-3">
                                                                <?php echo e($loc->name); ?>

                                                            </div>
                                                            <div class="col-3">
                                                            <p><b class="text-warning"> <?php echo e(number_format($owner->quantity)); ?></b></p>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                </div>
                                 </div>
                                <!-- /.modal-content -->
                               </div>
                            <!-- /.modal-dialog -->
                            </div>
                          <!-- /.card -->

                          <div class="modal fade" id="modal-lg-<?php echo e($item->id); ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit <?php echo e($item->item_name); ?></h4>
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
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form  action="/edit-item-<?php echo e($item->id); ?>" method="POST" id="quickForm" enctype="multipart/form-data">
                                                <?php echo csrf_field(); ?>
                                                <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label >Item Name</label>
                                                            <input type="text" name="item_name" class="form-control"  value="<?php echo e($item->item_name); ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label >Category</label>
                                                            <select name="category" class="form-control" id="" required>
                                                            <option value="<?php echo e($item->category); ?>"><?php echo e($item->category); ?></option>
                                                            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                <option value="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label >Product Code</label>
                                                            <input type="text" name="product_code" class="form-control" value="<?php echo e($item->product_code); ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Unit</label>
                                                            <input type="text" name="unit" class="form-control"  value="<?php echo e($item->unit); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Weight</label>
                                                            <input type="text" name="weight" class="form-control"  value="<?php echo e($item->weight); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Dimension</label>
                                                            <input type="text" name="dimension" class="form-control"  value="<?php echo e($item->dimension); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Manufacturer</label>
                                                            <input type="text" name="manufacturer" class="form-control"  value="<?php echo e($item->manufacturer); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>SupplierName</label>
                                                            <input type="text" name="supplier_name" class="form-control"  value="<?php echo e($item->supplier_name); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Cost Price</label>
                                                            <input type="number" step="any" name="cost_price" class="form-control"  value="<?php echo e($item->cost_price); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Price 1</label>
                                                            <input type="number" step="any" name="selling_price1" class="form-control" value="<?php echo e($item->selling_price1); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Price 2</label>
                                                            <input type="number" step="any" name="selling_price2" class="form-control"  value="<?php echo e($item->selling_price2); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Price 3</label>
                                                            <input type="number" step="any" name="selling_price3" class="form-control"  value="<?php echo e($item->selling_price3); ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Re-Order Level</label>
                                                            <input type="number" name="reorder" class="form-control" value="<?php echo e($item->reorder); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>UPC</label>
                                                            <input type="text" name="universal_product_code" class="form-control" value="<?php echo e($item->universal_product_code); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>S/No</label>
                                                            <input type="number" name="serial_number" class="form-control"  value="<?php echo e($item->serial_number); ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Bar Code</label>
                                                            <input type="text" name="bar_code" class="form-control"  value="<?php echo e($item->bar_code); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>image</label>
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>CurruntStock</label>
                                                            <input type="number" step="any" name="currnent_stock" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary swalDefaultSuccess" onclick="return confirm('Are you sure? Save Changes !!!');" >Save Change</button>
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
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-item" method="POST" id="quickForm" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label >Item Name</label>
                                                <input type="text" name="item_name" class="form-control"  placeholder="Item Name" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label >Category</label><a data-toggle="modal" data-target="#modal-lg-category" class="btn btn-xs btn-primary" style="float:right"> <i class="fas fa-plus"></i></a>
                                                <select name="category" class="form-control" id="" required>
                                                <option value="">Select</option>
                                                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <option value="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label >Product Code</label>
                                                <input type="text" name="product_code" class="form-control"  placeholder="Product Code" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Unit</label>
                                                <input type="text" name="unit" class="form-control"  placeholder="Unit">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Weight</label>
                                                <input type="text" name="weight" class="form-control"  placeholder="Weight">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Dimension</label>
                                                <input type="text" name="dimension" class="form-control"  placeholder="Dimension">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Manufacturer</label>
                                                <input type="text" name="manufacturer" class="form-control"  placeholder="Manufacturer">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>SupplierName</label>
                                                <input type="text" name="supplier_name" class="form-control"  placeholder="Supplier Name">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Cost Price</label>
                                                <input type="number" step="any" name="cost_price" class="form-control"  placeholder="Cost Price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Price 1</label>
                                                <input type="number" step="any" name="selling_price1" class="form-control"  placeholder="Selling Price 1">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Price 2</label>
                                                <input type="number" step="any" name="selling_price2" class="form-control"  placeholder="Selling Price 2">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Price 3</label>
                                                <input type="number" step="any" name="selling_price3" class="form-control"  placeholder="Selling Price 3">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Re-Order Level</label>
                                                <input type="number" name="reorder" class="form-control"  placeholder="Re Order Level">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>UPC</label>
                                                <input type="text" name="universal_product_code" class="form-control"  placeholder="Universal Product Code">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>S/No</label>
                                                <input type="number" name="serial_number" class="form-control"  placeholder="Serial Number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Bar Code</label>
                                                <input type="text" name="bar_code" class="form-control"  placeholder="Bar Code">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label>image</label>
                                                <input type="file" name="image" class="form-control">
                                            </div>
                                        </div>

                                    </div>


                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" >Register</button>
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

                <div class="modal fade" id="modal-lg-category">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New Category</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container-fluid">

                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Category <small>Information</small></h3>
                                        </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form  action="/add-category" method="POST" id="quickForm" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label >Category Name</label>
                                                    <input type="text" name="category_name" class="form-control"  placeholder="Category Name" required>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label >Description</label>
                                                    <textarea name="decription" id="" class="form-control" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary swalDefaultSuccess" >Register</button>
                                        </div>
                                    </form>
                                    </div>
                                    <!-- /.card -->
                               </div><!-- /.container-fluid -->
                               <div class="row">
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <form  action="/edit-category-<?php echo e($category->id); ?>" method="POST" id="quickForm" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="text" name="category_name" class="form-control"  Value="<?php echo e($category->name); ?>" required>
                                                <button type="submit" class="btn btn-primary btn-xs swalDefaultSuccess" >Edit</button>

                                            </div>
                                        </div>
                                    </form>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <?php endif; ?>
                            </div>

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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/items/item.blade.php ENDPATH**/ ?>