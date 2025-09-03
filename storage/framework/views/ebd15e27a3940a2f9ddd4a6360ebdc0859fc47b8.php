<?php $__env->startSection('content'); ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8 lg">
                           <p class="text-warning"><?php echo e($customer->name); ?>

                                <small class="text-info">Return Sales Here</small>
                           </p>
                        </div>
                        <div class="col-4 lg">
                          <div class="pl-3 " style="float: right"><b> <?php echo e(0); ?> : Sales</b></div>
                        </div>
                    </div>
                </div>
             </div>
           </div>
        </div>

        <div class="row">
        <div class="col-6 lg">
            <div class="card">
                <div class="card-body text-sm">
                    
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>SalesDate</th>
                      <th>InvoiceNo</th>
                      <th>ReturnSomeItems</th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                    <?php
                        $no = 0;
                    ?>
                        <?php $__empty_1 = true; $__currentLoopData = $data['orders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                          $no = $no + 1;
                        ?>
                            <tr>
                                <td><?php echo e($no); ?></td>
                                <td><?php echo e($order['created_at']->toDateString()); ?></td>
                                <td><?php echo e($order['reference_number']); ?></td>
                                <td><a class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-lg-custom-<?php echo e($order['id']); ?>">CustomReturn</a></td>
                            </tr>

                            <div class="modal fade" id="modal-lg-custom-<?php echo e($order['id']); ?>">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php echo e($order['reference_number']); ?></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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

                                                <form  action="/customReturn-<?php echo e($order['id']); ?>" method="POST" id="quickForm" >
                                                    <?php echo csrf_field(); ?>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id='click'>Return Date</label>
                                                                    <input type="date" accept="any" name="return_date" class="form-control"value="<?php echo e(Carbon\Carbon::now()->toDateString()); ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1">Refunded Type</label>
                                                                    <select class="form-control" name='refunded_type' required>
                                                                      <option value="">Select</option>
                                                                      <option value="Cash">Cash</option>
                                                                      <option value="Debit">Debit To Current Balance</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id='click'>Return Location</label>
                                                                    <select class="form-control" name='return_location' required>
                                                                        <option value="">Select</option>
                                                                            <?php $__empty_2 = true; $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                                 <option value="<?php echo e($loc->id); ?>"><?php echo e($loc->name); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                            <?php endif; ?>
                                                                      </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1">Item Code</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-2">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id='click'>Price</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-2">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id='click'>Quantity</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-1">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id='click'>Vat</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-3">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id='click'>RtnQyt</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-1">
                                                                <div class="form-group">

                                                                </div>
                                                            </div>
                                                        </div>
                                                       <?php $__empty_2 = true; $__currentLoopData = $data['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                         <?php if($item['order_id'] == $order['id']): ?>
                                                            <div class="row" id="remove_<?php echo e($item['item_id']); ?>">
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1"> <a href=""><?php echo e($item['item_code']); ?></a></label>
                                                                        <input type="hidden" name="addmore[<?php echo e($item['item_id']); ?>][item_id]" value="<?php echo e($item['item_id']); ?>">
                                                                        <input type="hidden" name="addmore[<?php echo e($item['item_id']); ?>][price]" value="<?php echo e($item['price']); ?>">
                                                                        <input type="hidden" name="addmore[<?php echo e($item['item_id']); ?>][qyt]" value="<?php echo e($item['quantity']); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputPassword1" id='click'><?php echo e(number_format($item['price'],2)); ?></label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-2">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputPassword1" id='click'><?php echo e(number_format($item['quantity'])); ?></label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-1">
                                                                    <div class="form-group clearfix">
                                                                        <div class="form-group clearfix">
                                                                            <div class="icheck-success d-inline">
                                                                              <input type="checkbox" name="addmore[<?php echo e($item['item_id']); ?>][vat]"  checked name="tax" id="" value="<?php echo e($item['tax']); ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="form-group">
                                                                        <input type="number" accept="any" name="addmore[<?php echo e($item['item_id']); ?>][quantity]" class="form-control" min='0' max="<?php echo e($item['quantity']); ?>" id="exampleInputPassword1" placeholder="Return Quantity" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-1">
                                                                    <div class="form-group">
                                                                <button type="button" class=" remove-div_<?php echo e($item['item_id']); ?>"><B style='color:red;height:5px;'> X </B></button>

                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <script>
                                                                $(document).on('click', '.remove-div_<?php echo e($item['item_id']); ?>', function () {
                                                                       $('#remove_<?php echo e($item['item_id']); ?>').remove();
                                                                 });
                                                             </script>
                                                              <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success swalDefaultSuccess" >Return</button>
                                                    </div>
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
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </tbody>
                    </table>
                
                </div>
                  <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>
          <div class="col-6 lg" >
            <div class="card">
                <div class="card-body text-sm">
                    
                  <table id="example2" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Date</th>
                      <th>ReturnTo</th>
                      <th>ReturnBy</th>
                      <th>RFDAmount</th>
                      <th>ReturnType</th>
                      <th>Detail</th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                    <?php $no =0; ?>
                       <?php $__empty_1 = true; $__currentLoopData = $returns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $return): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                         <?php $no = $no + 1; ?>
                           <tr>
                                <td><?php echo e($no); ?></td>
                                <td><?php echo e($return->created_at->year.'/'.$return->created_at->month.'/'.$return->created_at->day); ?></td>
                                <td>
                                <?php $__empty_2 = true; $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <?php if($return->return_to == $loc->id): ?>
                                    <?php echo e($loc->name); ?>

                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <?php endif; ?>
                                </td>
                                <td>
                                 <?php $user = App\Models\user::select('name')->where('id',$return->return_by)->first();?>
                                 <?php echo e($user->name); ?>

                                </td>
                                <td><?php echo e(number_format($return->refunded_amount,2)); ?></td>
                                <td><?php echo e($return->refunded_type); ?></td>
                                <td><a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-lg-return-<?php echo e($return->id); ?>">Detail</a></td>
                           </tr>

                           <div class="modal fade" id="modal-lg-return-<?php echo e($return->id); ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><?php echo e($return->created_at->toDateString()); ?></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <!-- jquery validationc -->
                                            <div class="card card-primary">

                                            <form  action="/editReturn-<?php echo e($return->id); ?>" method="POST" id="quickForm" >
                                                <?php echo csrf_field(); ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1" id='click'>Return Date</label>
                                                                <input type="date"<?php if(true): echo 'readonly'; endif; ?> accept="any" value="<?php echo e($return->return_date); ?>" name="return_date" class="form-control" required>

                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Refunded Type</label>
                                                                <select class="form-control" name='refunded_type' required>
                                                                  <option value="<?php echo e($return->refunded_type); ?>"><?php echo e($return->refunded_type); ?></option>
                                                                  
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1" id='click'>Return Location</label>
                                                                <select class="form-control" name='return_location' required>
                                                                    <option value="<?php echo e($return->return_to); ?>">
                                                                    <?php $__empty_2 = true; $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                    <?php if($loc->id == $return->return_to): ?>
                                                                    <?php echo e($loc->name); ?>

                                                                    <?php endif; ?>
                                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                   <?php endif; ?>
                                                                    </option>
                                                                        
                                                                  </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Item Code</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1" id='click'>Price</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1" id='click'>RTNQuantity</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   <?php $__empty_2 = true; $__currentLoopData = $returnsDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                     <?php if($return->id == $item->return_id): ?>
                                                        <div class="row" id="remove_<?php echo e($item->id); ?>">
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <?php $it = App\Models\Item::select('product_code')->where('id',$item->id)->first();?>
                                                                    <label for="exampleInputEmail1"> <a href=""><?php if($it != ''): ?><?php echo e($it->product_code); ?><?php endif; ?></a></label>
                                                                    <input type="hidden" name="addmore[<?php echo e($item->id); ?>]['item_id']" value="<?php echo e($item->id); ?>">
                                                                    <input type="hidden" name="addmore[<?php echo e($item->id); ?>]['price']" value="<?php echo e($item->price); ?>">
                                                                    <input type="hidden" name="addmore[<?php echo e($item->id); ?>]['qyt']" value="<?php echo e($item->quantity); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id='click'><?php echo e(number_format($item->price,2)); ?></label>
                                                                </div>
                                                            </div>

                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1" id='click'><?php echo e(number_format($item->quantity)); ?></label>
                                                                </div>
                                                            </div>

                                                            
                                                            

                                                        </div>
                                                        <script>
                                                            $(document).on('click', '.remove-div_<?php echo e($item->id); ?>', function () {
                                                                   $('#remove_<?php echo e($item->id); ?>').remove();
                                                             });
                                                         </script>
                                                          <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                        <?php endif; ?>
                                                    </div>
                                                <div class="modal-footer justify-content-between">
                                                    
                                                </div>
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
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                       <?php endif; ?>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/sales/salesReturn.blade.php ENDPATH**/ ?>