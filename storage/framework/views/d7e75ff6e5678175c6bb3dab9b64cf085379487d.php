<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 p-2 d-none d-xl-block">
                <h4 class="text-center">Order List</h4>
                <p class=" text-sm text-startr">
                    This List is Approved by the Store Manager to be Issued.
                    the Storekeeper should fill out the following form and make issue
                </p>
            </div>
            <div class="col-10">
              <div class="card">
                <div class="card-body">
                    
                  <table id="example2" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>OrderDate</th>
                      <th>VoucherNumber</th>
                      <th>CustomerName</th>
                      <th>SalesFrom</th>
                      <th>SalesPerson</th>
                      <th>ApprovedOn</th>
                      <th>View</th>
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
                            <td><?php echo e($salesOrder->created_at->diffForHumans()); ?></td>
                            <td><?php echo e($salesOrder->reference_number); ?></td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($customer->id == $salesOrder->customer_id): ?>
                                    <?php echo e($customer->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($businessLocation->id == $salesOrder->location_id): ?>
                                    <?php echo e($businessLocation->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($salesOrder->sales_person); ?></td>
                            <td><?php echo e($salesOrder->updated_at->toDateString()); ?></td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg-view-<?php echo e($salesOrder->id); ?>">
                                        SetIssue
                                 </button>
                              
                            </td>
                        </tr>
                          <!-- /.card -->

                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php else: ?>
                          <?php endif; ?>
                      </tbody>
                    </table>
                
                </div>
                  <!-- /.card-body -->
            </div>
            </div>

            <div class="col-2 p-2 d-none d-xl-block">
                <h3 class="text-center">Issued List</h3>
                <p class=" text-sm text-startr">
                    This List is Approved by the Store Manager and Set Issued By Storekeeper
                     issue History.
                </p>
            </div>
            <div class="col-10">
            <div class="card">
                <div class="card-body">
                    
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>IssueDate</th>
                      
                      <th>Code#</th>
                      <th>IssuedBy</th>
                      <th>IssueFrom</th>
                      <th>IssueTo</th>
                      <th>Quantity</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                        <?php if(count($issues) > 0): ?>
                        <?php
                            $no = 0;
                        ?>
                        <?php $__currentLoopData = $issues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $no = $no + 1;
                        ?>
                         <tr>
                            <td><?php echo e($no); ?></td>
                            <td><?php echo e($issue->date); ?> <small class="text-warning"><?php echo e($issue->created_at->hour.':'.$issue->created_at->minute); ?></small></td>
                            
                            <td style="color: greenyellow"><?php echo e($issue->id); ?></td>
                            <td>
                                <?php
                                    $user =  App\Models\User::where('id',$issue->issued_by)->first();
                                ?>
                                <?php echo e($user->name); ?>

                            </td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($businessLocation->id == $issue->issued_from): ?>
                                    <?php echo e($businessLocation->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $__empty_1 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($businessLocation->id == $issue->issued_to): ?>
                                    <?php echo e($businessLocation->name); ?>

                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </td>

                            <td><?php echo e($issue->issuing_detail_id); ?></td>
                            <td>
                                <?php if($issue->status == 'Pending'): ?>
                                  <p class="text-warning"><?php echo e($issue->status); ?></p>
                                <?php else: ?>
                                <p class="text-success"><?php echo e($issue->status); ?></p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg-view-d<?php echo e($issue->id); ?>">
                                        <i class="fas fa-eye"></i>
                                 </button>
                                 <?php
                                     $thisOrder = App\Models\SalesOrder::where('reference_number', $issue->voucher_number)->first();
                                 ?>
                              <a href="/sales-invoice-<?php echo e($thisOrder->id); ?>" rel="noopener" target="_blank" class="btn btn-warning"><i class="fas fa-print"></i></a>
                              
                            </td>
                        </tr>
                          <!-- /.card -->

                          <div class="modal fade" id="modal-lg-view-d<?php echo e($issue->id); ?>">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title"><?php echo e($issue->voucher_number); ?></h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-1">
                                            <small>#</small>
                                        </div>
                                        <div class="col-3">
                                            ItemName
                                        </div>
                                        <div class="col-2">
                                            code
                                        </div>
                                        <div class="col-3">
                                           Owner
                                        </div>
                                        <div class="col-3">
                                            Quantity
                                        </div>

                                    </div>
                                    <hr>
                                    <?php
                                       $total = 0;
                                       $n = 0;
                                    ?>
                                    <?php $__empty_1 = true; $__currentLoopData = $issue_detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $issue_d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                     <?php if($issue_d->issuing_id == $issue->id): ?>
                                     <?php
                                       $total = $total + $issue_d->qauntity;
                                       $n = $n + 1;
                                     ?>
                                        <div class="row">
                                             <div class="col-1">
                                                <small><?php echo e($n); ?></small>
                                             </div>
                                             <?php
                                             $item_d_name =  App\Models\Item::find($issue_d->item_id);
                                            ?>
                                            <div class="col-3">
                                                <small><?php echo e($item_d_name->item_name); ?></small>
                                             </div>

                                             <div class="col-2">
                                                <a href=""><b><?php echo e($issue_d->item_name); ?></b></a>
                                             </div>

                                             <div class="col-3">
                                             <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($owner->id == $issue_d->owner_id): ?>
                                                    <?php echo e($owner->name); ?>

                                                <?php endif; ?>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </div>
                                             <div class="col-3">
                                                <?php echo e(number_format($issue_d->qauntity)); ?>

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

                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php else: ?>
                          <?php endif; ?>
                      </tbody>
                    </table>
                
                </div>
                  <!-- /.card-body -->
            </div>
            </div>
              <!-- /.card -->
            <?php $__empty_1 = true; $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <div class="modal fade" id="modal-lg-view-<?php echo e($salesOrder->id); ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Store Issue Voucher </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <section class="content">
                                    <div class="container-fluid">
                                      <div class="row">
                                        <div class="col-12">
                                          <form method="POST" action="add-issuing-<?php echo e($salesOrder->id); ?>">
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
                                                    
                                                    Customer
                                                    <?php
                                                        $cust = App\Models\Customer::find($salesOrder->customer_id);
                                                    ?>
                                                    <input type="text" name="issue_date" value="<?php echo e($cust->name); ?>" readonly class="form-control" required>
                                                    <input type="hidden" name="issue_date" value="<?php echo e(Carbon\Carbon::now()->toDateString()); ?>" class="form-control" required>

                                                    
                                                    Invoice No
                                                    <input type="text" readonly name="refrence_no" class="form-control" value=" <?php echo e($salesOrder->reference_number); ?>"  >
                                                  </address>
                                                </div>

                                                <!-- /.col -->
                                                <div class="col-sm-1 invoice-col">

                                                </div>
                                                <!-- /.col -->
                                                 <input type="hidden" id="location" name="to" value="<?php echo e($salesOrder->location_id); ?>">
                                                <div class="col-sm-7 invoice-col">
                                                  <div class="row">
                                                      <div class="col-12">
                                                          Order From
                                                            
                                                            <?php $__empty_2 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                <?php if($salesOrder->location_id == $businessLocation->id): ?>
                                                               <input type="text" readonly name="toName" class="form-control" value=" <?php echo e($businessLocation->name); ?>" >
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                            <?php endif; ?>
                                                      </div>
                                                  </div>

                                                    From &nbsp; &nbsp;
                                                  <address>
                                                      
                                                        <select name="from" id='fromLocation' class="form-control" id='Ownloc' required>
                                                          
                                                          <?php $__empty_2 = true; $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                <option value="<?php echo e($businessLocation->id); ?>"><?php echo e($businessLocation->name); ?></option>
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

                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>P-Code</th>
                                                        <th>Quantity</th>
                                                        <th>ItemOwner</th>
                                                        
                                                        <th></th>
                                                    </tr>
                                                  <tbody id="add_items_<?php echo e($salesOrder->id); ?>">
                                                    <?php $__empty_2 = true; $__currentLoopData = $salesOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                    <?php if($salesOrderDetail->sales_order_id == $salesOrder->id): ?>
                                                    <?php if($salesOrderDetail->owner_id != 666): ?>
                                                    <tr>
                                                        <td style="width:40%;">
                                                         <?php
                                                            $item =  App\Models\Item::find($salesOrderDetail->item_id);
                                                         ?>
                                                         <input type="text" class="form-control" value="<?php echo e($item->item_name); ?>" />
                                                        </td>
                                                        <td style="width:20%;">
                                                            <input type="hidden" id="item_id_<?php echo e($salesOrderDetail->id); ?>" name="addmore[<?php echo e($salesOrderDetail->id); ?>][item_id]" value="<?php echo e($salesOrderDetail->item_id); ?>">
                                                            <input type="text"  id='item_<?php echo e($salesOrderDetail->id); ?>' name="addmore[<?php echo e($salesOrderDetail->id); ?>][item_name]" value="<?php echo e($salesOrderDetail->item_name); ?>" class="form-control input-group-sm" readonly required>
                                                        </td>
                                                        <td>
                                                           <input type="number" min="0" id='quantity_<?php echo e($salesOrderDetail->id); ?>' name="addmore[<?php echo e($salesOrderDetail->id); ?>][quantity]" onchange="getItemOwnerBalance(<?php echo e($salesOrderDetail->item_id); ?>,<?php echo e($salesOrderDetail->id); ?>)" value="<?php echo e($salesOrderDetail->quantity); ?>" class="form-control input-group-sm" required>
                                                        </td>
                                                        <td>
                                                        <select id='owner_<?php echo e($salesOrderDetail->id); ?>' name="addmore[<?php echo e($salesOrderDetail->id); ?>][owner]" onchange="getItemOwnerBalance(<?php echo e($salesOrderDetail->item_id); ?>,<?php echo e($salesOrderDetail->id); ?>)" class="form-control owner" style="width:180px;" required >
                                                               
                                                            <?php $__empty_3 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                                            <option value="<?php echo e($owner->id); ?>"><?php echo e($owner->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                                            <?php endif; ?>
                                                        </select>
                                                        </td>
                                                        <td>

                                                            <input type="hidden" id="stock_blance_<?php echo e($salesOrderDetail->id); ?>" class="form-control sub" value=""  class="form-control" placeholder="Stock Balance" disabled /></td>
                                                      </tr>
                                                    <?php endif; ?>
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


                                              </div>
                                              <!-- /.col -->
                                              <div class="col-5">
                                                
                                                <p></p>
                                                <div class="table-responsive" style="float:right;">
                                                  <table class="table">
                                                    <tr>
                                                      
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
                                                <a href="returnIssue-<?php echo e($salesOrder->id); ?>" class="btn btn-warning"><i class="fas fa-back-arrow"></i> Return Issue</a>
                                                <button type="submit" class="btn btn-success float-right"> Save
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
              </div>

              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

              <?php endif; ?>
        </div>
    </div>
</section>

<script>
    function getItemOwnerBalance(item,id){
        var owner = document.getElementById('owner_'+id).value;
        var location =  document.getElementById('fromLocation').value;
        // var owner = document.getElementsByClassName("owner_"+id).value;
        var quantity = document.getElementById('quantity_'+id).value;

        if(owner != '' && location !== ''){
            $.ajax({
                type: "POST",
                url: "<?php echo e(url('getItemOwnerBalance')); ?>",
                dataType:'json',
                data:{
                    '_token':'<?php echo e(csrf_token()); ?>',
                        item:item,
                        owner:owner,
                        location:location,
                    },
                success: function (result) {
                    if(result != null){
                        document.getElementById("quantity_"+id).max = result.quantity;
                        document.getElementById('stock_blance_'+id).value = result.quantity - quantity;
                    }else{
                        document.getElementById("owner_"+id).value = '';
                        document.getElementById("stock_blance_"+id).value = '';

                        alert("Have No Such Quantity For This Paticular Owner on this From Locationn !!!");
                    }
                }

            });
        }
    }

</script>
<?php $__empty_1 = true; $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <script>
   var i = 0;
    $("#add_new_items_<?php echo e($salesOrder->id); ?>").click(function () {
        ++i;
        if(i==1){
            $("#add_items_<?php echo e($salesOrder->id); ?>").append(`
            <tr>

                <th class="text-success">Supplement</th>

            </tr>
            <tr>
                <th>Location</th>
                <th>Owner</th>
                <th>ProductCode</th>
                <th>Qyt</th>
                <th></th>
            </tr>
             `);
        }
        $("#add_items_<?php echo e($salesOrder->id); ?>").append(`
        <tr>
            <td>
            <select id='location_`+i+`' name="addmoreSup[`+i+`][location]"  class="form-control" style="width:180px;" required >
                <option value="">Location</option>
                <?php $__empty_2 = true; $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                <option value="<?php echo e($businessLocation->id); ?>"><?php echo e($businessLocation->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                <?php endif; ?>
            </select>

            </td>
            <td>
            <select id='owner_`+i+`' name="addmoreSup[`+i+`][owner]"  class="form-control" style="width:180px;" required >
                <option value="">Owner</option>
                <?php $__empty_2 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                <option value="<?php echo e($owner->id); ?>"><?php echo e($owner->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                <?php endif; ?>
            </select>
            </td>
            <td style="width: 210px;">
                <div class="row">
                    <div class="dropdown">
                        <div id="myDropdown_`+i+`" class="dropdown-content">
                            <input type="hidden" id="item_id_s`+ i +`" name="addmoreSup[`+ i +`][item_id]">
                            <input type="text" autoComplete="off" placeholder="Search Item..." id="myInput_`+i+`" onclick="myFunction(`+ i +`)" onkeyup="filterFunction(`+i+`)" name="addmoreSup[`+i+`][item_name]"  class="form-control" required>
                            <div id="items_`+i+`">
                                <ul class="nav nav-pills nav-sidebar flex-column" id="item_list_`+i+`" data-widget="treeview" role="menu" data-accordion="false">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <input type="number" min="1" id='quantity_s`+ i +`' value='0' name="addmoreSup[`+i+`][quantity]"  class="form-control input-group-sm" required>
            </td>

            <td>
            <button type="button" class=" remove-tr"><B style='color:red'> X </B></button>
            </td>
        </tr>
        `);
    });

    $(document).on('click', '.remove-tr', function () {
          $(this).parents('tr').remove();
    });

  </script>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<?php endif; ?>

<script>
    function enableOwner(){
        var element = document.getElementsByClassName("owner");
         for (var i = 0; i < element.length; i++){
                element[i].disabled = false;
           }
    }
    function myFunction(no) {
            var owner_id = document.getElementById("owner_"+no).value;
            var location_id = document.getElementById("fromLocation").value;
            var quantity = document.getElementById('quantity_s'+no).value;
            if(location_id != '' && owner_id != ''){
            $.ajax({
                type: "POST",
                url: "<?php echo e(url('getItemForIssue')); ?>",
                dataType:'json',
                data:{
                    '_token':'<?php echo e(csrf_token()); ?>',
                        owner_id:owner_id,
                        location_id:location_id,
                    },
                success: function (result) {
                    console.log(result);
                    var rowData = '';
                    $('#item_list_'+no).html('');
                    $.each(result, function(index,value){
                        // no = no+1;
                        rowData = `
                           <option class="nav-link" id="item_${value.id}" onclick="selectedItem(${value.id},${value.item_id},${value.quantity},${no})">${value.item_code}</option>
                        `;

                        $('#item_list_'+no).append(rowData);
                        // document.getElementById('stock_blance_'+no).value = value.quantity -  document.getElementById('quantity_'+no).value;
                        document.getElementById('quantity_s'+no).max = value.quantity;
                    // getItemOwnerBalance(no,value.id,location_id);
                    });
                },

            });
            }
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

    function selectedItem(id,item,qyt,no){
         document.getElementById("items_"+no).style.display = 'none';
         document.getElementById('item_id_s'+no).value = item;
        //  var location_id = document.getElementById("location").value;
         document.getElementById('quantity_s'+no).max = qyt;
         document.getElementById("myInput_"+no).value =  document.getElementById("item_"+id).value;

        }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/issuing/issuing.blade.php ENDPATH**/ ?>