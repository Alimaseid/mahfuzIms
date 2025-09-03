<title><?php echo e($customer); ?> Transaction Summery </title>
<meta
      name="Summery"
      content=""
    />

<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                <div class="row">
                    <div class="col-10">
                    <div class="row">
                        <div class="col-3 lg">
                            <b class="text-warning"> <?php echo e($customer); ?></b>
                        </div>
                        <div class="col-4 lg">
                            <i> APVD Balance</i>:
                            <i class="fa fa-arrow-right sm" style="color:blue"></i>
                            <?php if($approved_payment > 0): ?>
                             <?php echo e(number_format($lastBalance->running_balance - $approved_payment,2)); ?></i>
                            <?php else: ?>
                              <?php echo e(number_format($lastBalance->running_balance - $approved_payment,2)); ?></i>
                            <?php endif; ?>

                        </div>
                        <div class="col-3 lg">
                            <i>Balance</i>:
                            &nbsp;
                            <?php if($lastBalance->running_balance > 0): ?>
                              <i class="fa fa-arrow-up sm" style="color:red"></i>
                            <?php else: ?>
                              <i class="fa fa-arrow-down sm" style="color:green"></i>
                            <?php endif; ?>
                            &nbsp;
                            <?php echo e(number_format($lastBalance->running_balance,2)); ?>

                        </div>
                        <div class="col-2 lg">
                        Def:
                        <?php if($approved_payment > 0): ?>
                        <i class="fa fa-plus sm" style="color:red"></i>
                        <?php else: ?>
                           <i class="fa fa-minus sm" style="color:green"></i>
                        <?php endif; ?>
                            <?php echo e(number_format($approved_payment,2)); ?>

                        </div>
                    </div>
                    </div>
                    <div class="col-2 lg">
                            <div class="p-2 btn btn-primary btn-xs" style="float: right"  data-toggle="modal" data-target="#modal-lg">New Payment</div>
                    </div>
                </div>

                </div>
              </div>

              <div class="card">
                <div class="row">
                    <div class="col-12 lg">
                <div class="card-body">
                    
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Date</th>
                      <th>Debit</th>
                      <th>Credit</th>
                      <th>RunningBalace</th>
                      <th>PaymentType</th>
                      <th>Sattus</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $no = 0;
                    ?>
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $no =$no+1;
                    ?>
                        <tr>
                             <td><?php echo e($no); ?></td>
                             <td><?php echo e($payment->date); ?></td>
                             <td ><a href="" data-toggle="modal" style="color: rgb(7, 161, 233)" data-target="#modal-lg-view-<?php echo e($payment->narration); ?>"><?php echo e(number_format($payment->debit,2)); ?></a></td>
                             <td><?php echo e(number_format($payment->credit,2)); ?></td>
                             <td>
                             <?php if($payment->debit > 0): ?>
                               <i class="fa fa-arrow-up sm" style="color:red"  data-toggle="modal"  data-target="#modal-lg-view-<?php echo e($payment->narration); ?>"></i>
                             <?php else: ?>
                               <i class="fa fa-arrow-down sm" style="color:green"  data-toggle="modal" style="color: rgb(7, 161, 233)" data-target="#modal-lg-edit-<?php echo e($payment->id); ?>"></i>
                             <?php endif; ?>
                               &nbsp; &nbsp;
                               <?php echo e(number_format($payment->running_balance,2)); ?>

                             </td>
                             <td>
                                 <?php echo e($payment->voucher_type); ?>

                                 <?php if($payment->voucher_type == 'Cheque'): ?>
                                    <small> <?php echo e($payment->refrence_no); ?></small>
                                 <?php elseif($payment->voucher_type == 'Bank Transfer'): ?>
                                 <a href="">View</a>
                                 <?php endif; ?>
                             </td>
                             <td>
                             <?php if($payment->status == 'Pending'): ?>
                                 <p class="text-warning" ><?php echo e($payment->status); ?></p>
                             <?php elseif($payment->status == 'OnProccess'): ?>
                                <p class="text-info" ><?php echo e($payment->status); ?></p>
                             <?php else: ?>
                             <p class="text-success" ><?php echo e($payment->status); ?></p>
                             <?php endif; ?>
                             </td>

                        </tr>

                        <div class="modal fade" id="modal-lg-edit-<?php echo e($payment->id); ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit <i class="text-info"><?php echo e($customer); ?>'s </i>Payment.</h4>
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
                                                <div class="card-header">
                                                    <h3 class="card-title">Payment <small>Information</small></h3>
                                                </div>
                                                <form  action="/editCustomerPayment-<?php echo e($payment->id); ?>" method="POST" id="quickForm" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-6" >
                                                            <div class="form-group">
                                                              <label for="exampleInputEmail1">Payment Type</label>
                                                               <select name="payment_type" class="form-control" required>
                                                                <option value="<?php echo e(Illuminate\Support\Str::before($payment->voucher_type,',')); ?>"><?php echo e(Illuminate\Support\Str::before($payment->voucher_type,',')); ?></option>
                                                                <option value="Cash">Cash</option>
                                                                <option value="Cheque">Cheque</option>
                                                                <option value="Bank Transfer">Banck Transfer</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >Amount</label>
                                                                <input type="number" step="any" name="amount" class="form-control"  value="<?php echo e($payment->credit); ?>" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >OnBank</label>
                                                                <a  data-toggle="modal" data-target="#modal-md" style='color:rgb(98, 255, 0)'>
                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                </a>
                                                                <select name="bank" class="form-control" id="cheque" >
                                                                    <option value="<?php echo e(Illuminate\Support\Str::after($payment->voucher_type,',')); ?>"><?php echo e(Illuminate\Support\Str::after($payment->voucher_type,',')); ?></option>
                                                                   <?php $__empty_2 = true; $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                    <option value="<?php echo e($bank->BankName); ?>"><?php echo e($bank->BankName); ?> &nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <?php echo e($bank->AccountNumber); ?></option>
                                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                   <?php endif; ?>
                                                                   </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >ChequeNo / RefrenceNo</label>
                                                                <input type="text" name="cheque_no" class="form-control"  value="<?php echo e($payment->refrence_no); ?>" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >Bank Receipt / cheque</label>
                                                                <input type="file" name="banck_receipt" class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >Bank Receipt / cheque</label>
                                                                <p>Open File <a href="/<?php echo e($payment->voucher_no); ?>">View Here</a>.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success swalDefaultSuccess" >Save Change</button>
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
              <!-- /.card -->
              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New payment By <i class="text-info"><?php echo e($customer); ?></i></h4>
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
                                    <div class="card-header">
                                        <h3 class="card-title">Payment <small>Information</small></h3>
                                    </div>
                                    <form  action="/Payment-<?php echo e($lastBalance->customer_id); ?>" method="POST" id="quickForm" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6" >
                                                <div class="form-group">
                                                  <label for="exampleInputEmail1">Payment Type</label>
                                                   <select name="payment_type" class="form-control" id="cheque" onchange="chequeNumber()" required>
                                                    <option value="">Select Here</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Bank Transfer">Banck Transfer</option>
                                                    <option value="Beginning Balance">Beginning Balance</option>
                                                   </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Amount</label>
                                                    <input type="number" step="any" name="amount" class="form-control"  value="<?php echo e($lastBalance->running_balance); ?>" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="chequedate" style="display: none">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label >On Bank</label>
                                                        <a  data-toggle="modal" data-target="#modal-md" style='color:rgb(98, 255, 0)'>
                                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                        </a>
                                                        <select name="bank" class="form-control" id="cheque" >
                                                            <option value="">Select</option>
                                                           <?php $__empty_1 = true; $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <option value="<?php echo e($bank->BankName); ?>"><?php echo e($bank->BankName); ?> &nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <?php echo e($bank->AccountNumber); ?></option>
                                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                           <?php endif; ?>
                                                           </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label >ChequeNo / RefrenceNo</label>
                                                        <input type="text" name="cheque_no" class="form-control"  placeholder="Cheque Number" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label >Bank Receipt / cheque</label>
                                                    <input type="file" name="banck_receipt" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary swalDefaultSuccess" >Save</button>
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
                <!-- /.modal -->


              <!-- /.card -->


                <?php $__empty_1 = true; $__currentLoopData = $salesOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="modal fade" id="modal-lg-view-<?php echo e($salesOrder->id); ?>">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <p>
                          <small> Date:</small>  <i class="text-info" ><?php echo e($salesOrder->created_at->toDateString()); ?></i>&nbsp;&nbsp;&nbsp;
                          <small>Status:</small> <i class="text-info" ><?php echo e($salesOrder->SM_status); ?></i> &nbsp;&nbsp;&nbsp;
                          <small>VoucherNo:</small> <i class="text-info" ><?php echo e($salesOrder->reference_number); ?></i></p>
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
                            <?php $__empty_2 = true; $__currentLoopData = $salesOrderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salesOrderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                             <?php if($salesOrderDetail->sales_order_id == $salesOrder->id): ?>
                             <?php
                               $total = $total + $salesOrderDetail->total
                             ?>
                                <div class="row">
                                     <div class="col-3">
                                        <i class="text-info" ><b><?php echo e($salesOrderDetail->item_name); ?></b></i>
                                     </div>
                                     <div class="col-3">
                                        <?php echo e(number_format($salesOrderDetail->quantity)); ?>

                                     </div>
                                     <div class="col-3">
                                        <?php echo e(number_format($salesOrderDetail->amount,2)); ?> ,<small><?php echo e($salesOrderDetail->tax); ?>%</small>
                                     </div>
                                     <div class="col-3">
                                        <?php echo e(number_format($salesOrderDetail->total,2)); ?>

                                     </div>
                                </div>
                                <hr>

                             <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-9">
                                </div>
                                <div class="col-3">
                                   <b>Total: &nbsp; <i class="text-info" > <?php echo e(number_format($salesOrder->grand_total,2)); ?></i></b>
                                 </div>
                            </div>
                        </div>

                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </div>
            <div class="modal fade" id="modal-md">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">ADD Bank</h4>
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
                                    <div class="card-header">
                                        <h3 class="card-title">Bank <small>Information</small></h3>
                                    </div>
                                    <form  action="/bank" method="POST" id="quickForm" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label >Bank Name</label>
                                                    <input type="text" name="bankname" class="form-control" placeholder="Bank Name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Account Number <small>opt</small> </label>
                                                    <input type="text"  name="account" class="form-control" placeholder="Account Number">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Label <small>opt</small></label>
                                                    <input type="text" name="label" class="form-control" placeholder="Label To Your reference">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success swalDefaultSuccess" >Save</button>
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
                <!-- /.modal -->
        </div>
    </div>
  </section>
  <script>
    function chequeNumber(){
        var type = $('#cheque').val();
        if(type != 'Cash' ){
           document.getElementById('chequedate').style.display = 'block';
        }else{
           document.getElementById('chequedate').style.display = 'none';

        }
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/payment/payments.blade.php ENDPATH**/ ?>