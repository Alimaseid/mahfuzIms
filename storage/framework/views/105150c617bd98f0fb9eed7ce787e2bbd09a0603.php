<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                <div class="row">
                    <div class="col-8 lg">
                      <div class="pl-3"> <small>TotalOrders: </small><b> <?php echo e(count($purchaseOrders)); ?></b></div>

                    </div>
                    <div class="col-4 lg">

                      <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                        New PurchaseOrder
                      </button>
                    </div>
                </div>
             </div>
        </div>
        </div>

              <div class="card">
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>PurchaseDate</th>
                      <th>Vendor</th>
                      <th>StoreOn</th>
                      <th>PurchaseBy</th>
                      <th>ReferenceN0</th>
                      <th>Payment</th>
                      <th>Type</th>
                      <th>Detail</th>
                      <th>__________</th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                        <?php if(count($purchaseOrders) > 0): ?>
                        <?php
                            $no = 0;
                        ?>
                        <?php $__currentLoopData = $purchaseOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchaseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $no = $no + 1;
                        ?>
                         <tr>
                            <td><?php echo e($no); ?></td>
                            <td><?php echo e($purchaseOrder->created_at->toDateString()); ?></td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($vendor->id == $purchaseOrder->vender): ?>
                                    <?php echo e($vendor->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($businessLocation->id == $purchaseOrder->business_location): ?>
                                    <?php echo e($businessLocation->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($owner->id == $purchaseOrder->owner): ?>
                                    <?php echo e($owner->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($purchaseOrder->reference_number); ?></td>

                            <div class="modal fade" id="modal-lg-view-<?php echo e($purchaseOrder->id); ?>">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title"><?php echo e($purchaseOrder->reference_number); ?></h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-3">
                                                Item
                                            </div>
                                            <div class="col-3">
                                                Quantity
                                            </div>
                                            <div class="col-3">
                                                Price <small>Vat</small>
                                            </div>
                                            <div class="col-3">
                                                Total
                                            </div>
                                        </div>
                                        <hr>
                                        <?php
                                           $total = 0;
                                        ?>
                                        <?php $__empty_1 = true; $__currentLoopData = $purchaseOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchaseOrderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                         <?php if($purchaseOrderDetail->purchase_order_id == $purchaseOrder->id): ?>
                                         <?php
                                           $total = $total + $purchaseOrderDetail->total
                                         ?>
                                            <div class="row">
                                                 <div class="col-3">
                                                    <a href=""><b><?php echo e($purchaseOrderDetail->item_name); ?></b></a>
                                                 </div>
                                                 <div class="col-3">
                                                    <?php echo e(number_format($purchaseOrderDetail->qunatity)); ?>

                                                 </div>
                                                 <div class="col-3">
                                                    <?php echo e(number_format($purchaseOrderDetail->amount)); ?> ,<small><?php echo e($purchaseOrderDetail->tax); ?>%</small>
                                                 </div>
                                                 <div class="col-3">
                                                    <b><?php echo e(number_format($purchaseOrderDetail->total)); ?></b>
                                                 </div>
                                            </div>
                                            <br>
                                         <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <?php endif; ?>
                                    </div>

                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
                              <!-- /.modal -->
                            <td><?php echo e(number_format($total)); ?></td>
                            <td><?php echo e($purchaseOrder->payment_terms); ?></td>

                            <td>
                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-lg-view-<?php echo e($purchaseOrder->id); ?>">
                                        ViewDetails
                                  </button>

                            </td>
                            <td>
                              <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal-lg-edit<?php echo e($purchaseOrder->id); ?>">
                              <i class="fas fa-edit"></i>
                              </button>
                              <a type="button" class="btn btn-danger btn-xs" href="delete-purchase-order-<?php echo e($purchaseOrder->id); ?>" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                        </tr>
                          <!-- /.card -->



                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                         <h2>No purchaseOrder Found !</h2>
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
                            <h4 class="modal-title">New Purchase Order</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <section class="content">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-12">
                                      <form method="POST" action="add-purchase-order">
                                      <?php echo csrf_field(); ?>
                                      <!-- Main content -->
                                      <div class="invoice p-3 mb-3">
                                        <!-- title row -->
                                        <div class="row">
                                          <div class="col-12">
                                            <h4>
                                              <i class="fas fa-globe"></i> UKAZ, Inc.
                                              <small class="float-right">Date : <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?></small>
                                            </h4>
                                          </div>
                                          <!-- /.col -->
                                        </div>
                                        <!-- info row -->
                                        <div class="row invoice-info">
                                          <div class="col-sm-4 invoice-col">
                                            <address>
                                              
                                              Store Location
                                              <select name="business_location" class="form-control"  required >
                                                <option value="">Select</option>
                                                <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <option value="<?php echo e($businessLocation->id); ?>"><?php echo e($businessLocation->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <?php endif; ?>
                                              </select>
                                              
                                              Owner
                                              <select name="owner" class="form-control"  required >
                                                <option value="">Select</option>
                                                <?php $__empty_1 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <option value="<?php echo e($owner->id); ?>"><?php echo e($owner->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <?php endif; ?>
                                              </select>
                                            </address>
                                          </div>
                                          <!-- /.col -->
                                          <div class="col-sm-3 invoice-col">

                                          </div>
                                          <!-- /.col -->
                                          <div class="col-sm-5 invoice-col">
                                            Invoice  No
                                            <input type="text" name="refrence_no" class="form-control" value=" <?php echo e('IMS-RF-'.random_int(100000,9999999)); ?>"  >
                                              
                                              Vendor
                                            <address>
                                                <select name="vendor" class="form-control" required >
                                                    <option value="">Select</option>
                                                    <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <option value="<?php echo e($vendor->id); ?>"><?php echo e($vendor->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                    <?php endif; ?>
                                                  </select>
                                            </address>
                                          </div>
                                          <!-- /.col -->
                                        </div>
                                        <!-- /.row -->




                                        <!-- Table row -->
                                        <div class="row">

                                          <div class="col-12 table-responsive">
                                            <a href="/items" style='color:rgb(98, 255, 0)'>
                                              <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                ADD New Item</a>
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>ProductCode</th>
                                                    <th>Quantity</th>
                                                    <th>U-Price</th>
                                                    <th>SubTotal</th>
                                                    <th></th>
                                                </tr>
                                              <tbody id="add_items">
                                                <tr id="">
                                                    <td style="width: 250px;">
                                                        <div class="row">
                                                            <div class="dropdown">
                                                                <div id="myDropdown_0" class="dropdown-content">
                                                                  <input type="text" autoComplete="off" placeholder="Search.." id="myInput_0" onclick="myFunction(0)" onkeyup="filterFunction(0)" name="addmore[0][search_item]"  class="form-control" required>
                                                                  <div id="items_0" style="display: none">
                                                                   <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                                                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                    <option class="nav-link" id="item_<?php echo e($item->id); ?>" onclick="selectedItem(<?php echo e($item->id); ?>,0)"><?php echo e($item->item_name); ?> &nbsp;&nbsp;&nbsp;&nbsp; # <?php echo e($item->product_code); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                    <?php endif; ?>
                                                                    <input type="hidden" id="item_id_0" name="addmore[0][item_id]">
                                                                   <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                                                                  </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                       <input type="number" id='0' name="addmore[0][quantity]" onchange="subTotalCal(0)" class="form-control input-group-sm" placeholder="Quantity"  required>
                                                    </td>
                                                    <td>
                                                    <input type="number" id='u_price_0' name="addmore[0][u_price]" onchange="subTotalCal(0)" class="form-control input-group-sm" placeholder="Price" required >
                                                    </td>

                                                    <td><input type="text" id="sub_0" class="form-control sub" value=""  class="form-control" placeholder="Sub Total" disabled /></td>
                                                  </tr>

                                              </tbody>

                                            </table>
                                            <a href="#" id="add_new_items" class="btn btn-success float-right" style="padding:5px; text-decoration:none">

                                              <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a>

                                          </div><hr><br>
                                          <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <div class="row" id='calculate'>
                                          <!-- accepted payments column -->
                                          <div class="col-7">
                                            <div class="row">
                                                <div class="col-sm-6 invoice-col">
                                                    <address>
                                                      
                                                      Expected Delivery Date
                                                      <input type="date" name="expected_delivery_date" value="<?php echo e(\Carbon\Carbon::now()->toDateString()); ?>" class="form-control" >
                                                  </div>
                                                 <div class="col-sm-6 invoice-col">
                                                      
                                                      Shipment Reference
                                                      <input type="text" name="shipment_reference" class="form-control" >
                                                 </div>
                                                    </address>
                                             </div>
                                            
                                            <img src="../../dist/img/credit/abby.jpg" alt="Abyssina">
                                            <img src="../../dist/img/credit/cbe.jpg" alt="CBE">
                                            <img src="../../dist/img/credit/hij.jpg" alt="Hijra">
                                            <img src="../../dist/img/credit/hbr.jpg" alt="Hibret">
                                            <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Payment Term</label>
                                                   <select name="payment_type" id="" class="form-control" required>
                                                    <option value="CAD/TT/LC">CAD/TT/LC</option>
                                                    <option value="Direct Payment">Direct Payment</option>
                                                   </select>
                                                  </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Vat %</label>
                                                    <input  type="number" min="0" value="15" id="vat_include" name="vat_include" class="form-control" onchange="valCal()" required>
                                                  </div>
                                            </div>
                                            </div>

                                          </div>
                                          <!-- /.col -->
                                          <div class="col-5">
                                            <h4>----</h4>
                                            <p class="lead"> Amount Due --   <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?> </p>

                                            <div class="table-responsive">
                                              <table class="table">
                                                <tr>
                                                  <th style="width:50%">Subtotal : </th>
                                                  <td><i id="sub"></i> </td>
                                                </tr>
                                                <tr>
                                                  <th id="vatRate">Tax(15%)</th>
                                                  <td> <i id="vat"></i> </td>
                                                </tr>
                                                
                                                <tr>
                                                  <th>Total:</th>
                                                  <td > <i id="tot" name='Gtotal'></i></td>
                                                </tr>
                                              </table>
                                            </div>
                                          </div>
                                          <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- this row will not appear when printing -->
                                        <div class="row no-print">
                                          <div class="col-12">
                                            <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                            <button type="submit" class="btn btn-success float-right"> Submit
                                              Order
                                            </button>
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <!-- /.invoice -->
                                    </form>
                                    </div><!-- /.col -->
                                  </div><!-- /.row -->
                                </div><!-- /.container-fluid -->
                              </section>

                        </div>
                     </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


            

            <?php $__empty_1 = true; $__currentLoopData = $purchaseOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchaseOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="modal fade" id="modal-lg-edit<?php echo e($purchaseOrder->id); ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Purchase Order <?php echo e($purchaseOrder->id); ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <section class="content">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-12">
                                      <form method="POST" action="editPurchaseOrder-<?php echo e($purchaseOrder->id); ?>">
                                      <?php echo csrf_field(); ?>
                                      <!-- Main content -->
                                      <div class="invoice p-3 mb-3">
                                        <!-- title row -->
                                        <div class="row">
                                          <div class="col-12">
                                            <h4>
                                              <i class="fas fa-globe"></i> UKAZ, Inc.
                                              <small class="float-right">Purchased Date : <?php echo e($purchaseOrder->created_at->toFormattedDateString()); ?></small>
                                            </h4>
                                          </div>
                                          <!-- /.col -->
                                        </div>
                                        <!-- info row -->
                                        <div class="row invoice-info">
                                          <div class="col-sm-4 invoice-col">
                                            <address>
                                              
                                              Store Location
                                              <select name="business_location" class="form-control"  required >
                                                 <?php $__empty_2 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                    <?php if($purchaseOrder->business_location == $businessLocation->id): ?>
                                                     <option value="<?php echo e($purchaseOrder->business_location); ?>"><?php echo e($businessLocation->name); ?> </option>
                                                    <?php endif; ?>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                 <?php endif; ?>
                                                <?php $__empty_2 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                    <option value="<?php echo e($businessLocation->id); ?>"><?php echo e($businessLocation->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                <?php endif; ?>
                                              </select>
                                              
                                              Owner
                                              <select name="owner" class="form-control"  required >
                                                <?php $__empty_2 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                <?php if($purchaseOrder->owner == $owner->id): ?>
                                                 <option value="<?php echo e($purchaseOrder->owner); ?>"><?php echo e($owner->name); ?> </option>
                                                <?php endif; ?>
                                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                             <?php endif; ?>
                                                <?php $__empty_2 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                    <option value="<?php echo e($owner->id); ?>"><?php echo e($owner->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                <?php endif; ?>
                                              </select>
                                            </address>
                                          </div>
                                          <!-- /.col -->
                                          <div class="col-sm-3 invoice-col">

                                          </div>
                                          <!-- /.col -->
                                          <div class="col-sm-5 invoice-col">
                                            Invoice  No
                                            <input type="text" name="refrence_no" class="form-control" readonly value=" <?php echo e($purchaseOrder->reference_number); ?>"  >
                                              
                                              Purchase On
                                            <address>
                                                <select name="vendor" class="form-control" required >
                                                    <?php $__empty_2 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                    <?php if($purchaseOrder->vender == $vendor->id): ?>
                                                     <option value="<?php echo e($purchaseOrder->vender); ?>"><?php echo e($vendor->name); ?> </option>
                                                    <?php endif; ?>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                 <?php endif; ?>
                                                    <?php $__empty_2 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                        <option value="<?php echo e($vendor->id); ?>"><?php echo e($vendor->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                    <?php endif; ?>
                                                  </select>
                                            </address>
                                          </div>
                                          <!-- /.col -->
                                        </div>
                                        <!-- /.row -->




                                        <!-- Table row -->
                                        <div class="row">

                                          <div class="col-12 table-responsive">
                                            <a href="/items" style='color:rgb(98, 255, 0)'>
                                              <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                ADD New Item</a>
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>ProductCode</th>
                                                    <th>Quantity</th>
                                                    <th>U-Price</th>
                                                    <th>SubTotal</th>
                                                    <th></th>
                                                </tr>
                                              <tbody id="add_items">
                                              <?php
                                                  $tax = 0;
                                                  $no = 0;
                                              ?>
                                                <?php $__empty_2 = true; $__currentLoopData = $purchaseOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchaseOrderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                  <?php if($purchaseOrderDetail->purchase_order_id == $purchaseOrder->id): ?>

                                                    <tr id="">

                                                        <td style="width: 250px;">
                                                            <div class="row">
                                                                <div class="dropdown">
                                                                    <div id="myDropdown_0" class="dropdown-content">
                                                                      <input type="text" autoComplete="off" readonly value="<?php echo e($purchaseOrderDetail->item_name); ?>" placeholder="Search.." id="myInput_0" onclick="myFunction(0)" onkeyup="filterFunction(0)" name="addmore[<?php echo e($no); ?>][search_item]"  class="form-control" required>
                                                                      <div id="items_0" style="display: none">
                                                                       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                                                        <?php $__empty_3 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                                                        <option class="nav-link" id="item_<?php echo e($item->id); ?>" onclick="selectedItem(<?php echo e($item->id); ?>,0)"><?php echo e($item->product_code); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                                                        <?php endif; ?>
                                                                        <input type="hidden" id="item_id_0" value="<?php echo e($purchaseOrderDetail->item_id); ?>" name="addmore[<?php echo e($no); ?>][item_id]">
                                                                       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                                                                      </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <input type="number" id='0' name="addmore[<?php echo e($no); ?>][quantity]" value="<?php echo e($purchaseOrderDetail->qunatity); ?>" class="form-control input-group-sm" placeholder="Quantity"  required>
                                                        </td>
                                                        <td>
                                                        <input type="number" id='u_price_0' name="addmore[<?php echo e($no); ?>][u_price]" value="<?php echo e($purchaseOrderDetail->amount / $purchaseOrderDetail->qunatity); ?>" class="form-control input-group-sm" required >
                                                        </td>

                                                        <td><input type="text" id="sub_0" class="form-control sub" value="<?php echo e($purchaseOrderDetail->total); ?>"  class="form-control" placeholder="Sub Total" disabled /></td>
                                                      </tr>
                                                      <?php
                                                      $tax = $purchaseOrderDetail->tax;
                                                      $no = $no + 1;
                                                       ?>
                                                    <?php endif; ?>
                                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                  <?php endif; ?>

                                              </tbody>

                                            </table>
                                            

                                          </div><hr><br>
                                          <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <div class="row" id='calculate'>
                                          <!-- accepted payments column -->
                                          <div class="col-7">
                                            <div class="row">
                                                <div class="col-sm-6 invoice-col">
                                                    <address>
                                                      
                                                      Expected Delivery Date
                                                      <input type="date" name="expected_delivery_date" class="form-control" value="<?php echo e($purchaseOrder->expected_delivery_date); ?>" >
                                                  </div>
                                                 <div class="col-sm-6 invoice-col">
                                                      
                                                      Shipment Reference
                                                      <input type="text" name="shipment_reference" class="form-control" value="<?php echo e($purchaseOrder->shipment_reference); ?>">
                                                 </div>
                                                    </address>
                                             </div>
                                            
                                            <img src="../../dist/img/credit/abby.jpg" alt="Abyssina">
                                            <img src="../../dist/img/credit/cbe.jpg" alt="CBE">
                                            <img src="../../dist/img/credit/hij.jpg" alt="Hijra">
                                            <img src="../../dist/img/credit/hbr.jpg" alt="Hibret">
                                            <div class="row">
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Payment Term</label>
                                                   <select name="payment_type" id="" class="form-control" required>
                                                    <option value="<?php echo e($purchaseOrder->payment_terms); ?>"><?php echo e($purchaseOrder->payment_terms); ?></option>
                                                    <option value="CAD/TT/LC">CAD/TT/LC</option>
                                                    <option value="Direct Payment">Direct Payment</option>
                                                   </select>
                                                  </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Vat %</label>
                                                    <input  type="number" min="0" value="<?php echo e($tax); ?>" id="vat_include" name="vat_include" class="form-control" onchange="valCal()" required>
                                                  </div>
                                            </div>
                                            </div>

                                          </div>
                                          <!-- /.col -->
                                          <div class="col-5">
                                            <h4>----</h4>
                                            <p class="lead"> Amount Due --   <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?> </p>

                                            <div class="table-responsive">
                                              <table class="table">
                                                <tr>
                                                  <th style="width:50%">Subtotal : </th>
                                                  <td><i id="sub"></i><?php echo e($purchaseOrder->total_payment - ($purchaseOrder->total_payment * $tax / 100)); ?></td>
                                                </tr>
                                                <tr>
                                                  <th id="vatRate">Tax(<?php echo e($tax); ?>%)</th>
                                                  <td> <i id="vat"></i> <?php echo e($purchaseOrder->total_payment * $tax / 100); ?> </td>
                                                </tr>
                                                
                                                <tr>
                                                  <th>Total:</th>
                                                  <td > <i id="tot" name='Gtotal'><?php echo e($purchaseOrder->total_payment); ?></i></td>
                                                </tr>
                                              </table>
                                            </div>
                                          </div>
                                          <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- this row will not appear when printing -->
                                        <div class="row no-print">
                                          <div class="col-12">
                                            <a href="#" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                            <button type="submit" class="btn btn-success float-right"> Submit
                                              Order
                                            </button>
                                            
                                          </div>
                                        </div>
                                      </div>
                                      <!-- /.invoice -->
                                    </form>
                                    </div><!-- /.col -->
                                  </div><!-- /.row -->
                                </div><!-- /.container-fluid -->
                              </section>

                        </div>
                     </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>

            </div>
        </div>
    </div>
  </section>



<script type="text/javascript">
    var i = 0;
    var subTotal = [];
    $("#add_new_items").click(function () {
        ++i;
        $("#add_items").append(`
        <tr>
             <td style="width: 250px;">
                <div class="row">
                    <div class="dropdown">
                        <div id="myDropdown_`+ i +`" class="dropdown-content">
                            <input type="text" autoComplete="off" placeholder="Search.." id="myInput_`+ i +`" onkeyup="filterFunction(`+ i +`)" name="addmore[`+ i +`][search_item]"  class="form-control">
                            <div id="items_`+ i +`" style="display: none">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option class="nav-link" id="item_<?php echo e($item->id); ?>" onclick="selectedItem(<?php echo e($item->id); ?>,`+ i +`)"><?php echo e($item->item_name); ?> | <?php echo e($item->product_code); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                            <input type="hidden" id="item_id_`+ i +`" name="addmore[`+ i +`][item_id]">
                            <ul class="nav nav-pills nav-sidebar flex-column"  data-widget="treeview" role="menu" data-accordion="false">
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <input type="number" id="`+i+`" name="addmore[`+ i +`][quantity]" onchange="subTotalCal(`+ i +`)" class="form-control" id="exampleInputEmail1" placeholder="Quantity" required>
            </td>
            <td>
            <input type="number" id="u_price_`+i+`" name="addmore[`+ i +`][u_price]" onchange="subTotalCal(`+ i +`)" class="form-control" placeholder="Price" required >
            </td>

            <td><input type="text" id="sub_`+ i +`" class="form-control sub" value="" placeholder="Sub Total"  disabled /></td>
            <td>

            <button type="button" class=" remove-tr"><B style='color:red'> X </B></button>

            </td>
        </tr>
        `);
    });
    $(document).on('click', '.remove-tr', function () {
          $(this).parents('tr').remove();
    });


      $('#add_items').on('mouseover',function(){
              var subTotal = 0;
              var vatRate = document.getElementById("vat_include").value;
              var allSub = document.getElementsByClassName('sub');
              for(j=0; j < allSub.length ; j++){

                if(document.getElementById("sub_"+j).value != 0){

                  subTotal = subTotal +  Number(document.getElementById("sub_"+j).value);
                  vat = (subTotal) * vatRate / 100;
                  netTotal = subTotal + vat;
                  document.getElementById('vat').innerHTML =  vat.toFixed(2);
                  document.getElementById('sub').innerHTML =  subTotal.toFixed(2);
                  document.getElementById('tot').innerHTML =  netTotal.toFixed(2);
                  document.getElementById('vatRate').innerHTML = "Tax("+vatRate+")%";
                  }
                }

            });

        function subTotalCal(i){
          var u_price = $('#u_price_'+i).val();
          var  quantity  = $('#0').val();
          var data = parseInt(quantity) * parseFloat(u_price);
          document.getElementById('sub_'+i).value = data;
         }


    function valCal(){
      var subTotal = 0;
      var vatRate = document.getElementById("vat_include").value;
      var allSub = document.getElementsByClassName('sub');
      for(j=0; j < allSub.length ; j++){

        if(document.getElementById("sub_"+j).value != 0){

          subTotal = subTotal +  Number(document.getElementById("sub_"+j).value);
          vat = (subTotal) * vatRate / 100;
          netTotal = subTotal + vat;
          document.getElementById('vat').innerHTML =  vat.toFixed(2);
          document.getElementById('sub').innerHTML =  subTotal.toFixed(2);
          document.getElementById('tot').innerHTML =  netTotal.toFixed(2);
          document.getElementById('vatRate').innerHTML = "Tax("+vatRate+")%";
          }
        }


    }


</script>

<script>
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function myFunction(no) {
      document.getElementById("myDropdown_"+no).classList.toggle("show");
    }

    function filterFunction(no) {
      var input, filter, ul, li, a, i;
      input = document.getElementById("myInput_"+no);
      document.getElementById("items_"+no).style.display = 'block';

      filter = input.value.toUpperCase();
      div = document.getElementById("myDropdown_"+no);
      a = div.getElementsByTagName("option");
      for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          a[i].style.display = "";
        } else {
          a[i].style.display = "none";
        }
      }
    }
    </script>

    <script>
        function selectedItem(id,no){
         document.getElementById("items_"+no).style.display = 'none';
         document.getElementById("item_id_"+no).value = id;
         document.getElementById("myInput_"+no).value =  document.getElementById("item_"+id).value;


        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/purchase/purchase.blade.php ENDPATH**/ ?>