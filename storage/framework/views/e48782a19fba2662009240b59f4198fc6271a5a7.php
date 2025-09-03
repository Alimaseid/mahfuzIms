<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        
        <div class="row">
           <div class="col-sm-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                <div class="row">
                    <div class="col-6 lg">
                        <b><h2 class="card-title text-warning"> <?php echo e($netData['vender']); ?> </h2></b>
                    </div>

                    <div class="col-6 lg" >
                    <b style="float:right">
                      Total Curunt Balance:&nbsp;&nbsp;&nbsp;
                        <i class="fa fa-arrow-up sm" style="color:red"></i>&nbsp;
                        <?php echo e(number_format($netData['latestBalance'],2)); ?>

                    </b>
                    </div>
                </div>
             </div>
            </div>
            </div>


            <div class="row">
                <div class="pr-1">
                    <div class="card">
                        <div class="card-body">
                            <P>Individual Owner Balance on <i class="text-warning pull-right"><?php echo e($netData['vender']); ?></i></P>
                            <div class="row">
                                <div class="col-5">
                                    <b>Owner</b>
                                </div>
                                <div class="col-5">
                                   <b>Balance</b>
                                </div>
                                <div class="col-2">

                                </div>
                            </div>
                            <p>________________________________________</p>
                            <?php $__empty_1 = true; $__currentLoopData = $netData['owner_balance']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="row">
                                <div class="col-5">
                                    <?php echo e($ob['owner']); ?>

                                </div>
                                <div class="col-5">
                                    <?php if($ob['balance'] > 0): ?>
                                        <i class="fa fa-arrow-up sm" style="color:red"></i>&nbsp;
                                    <?php else: ?>
                                        <i class="fa fa-arrow-down sm" style="color:green"></i>&nbsp;
                                    <?php endif; ?>
                                    &nbsp;

                                    <?php echo e(number_format($ob['balance'],2)); ?>


                                </div>

                                <div class="col-2">
                                    <a href="" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-lg-reciept-<?php echo e($ob['owner_id']); ?>">Pay</a>
                                </div>
                            </div>
                            <hr>

                            <div class="modal fade" id="modal-lg-reciept-<?php echo e($ob['owner_id']); ?>">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Payment </h4>
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
                                                    <form  action="/purchasePayment-<?php echo e($ob['owner_id']); ?>-<?php echo e($netData['id']); ?>" method="POST" id="quickForm" enctype="multipart/form-data">
                                                        <?php echo csrf_field(); ?>
                                                    <div class="card-header">
                                                        
                                                        <b>TO <i class="text-info"><?php echo e($netData['vender']); ?></i> By <i class="text-success"><?php echo e($ob['owner']); ?></i></b>
                                                        <input type="date" name="date" class="form-control col-3" value="<?php echo e(Carbon\Carbon::now()->toDateString()); ?>" style="float: right;" required>
                                                         <label style="float: right;"> Date &nbsp;&nbsp;</label>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-4" >
                                                                <div class="form-group">
                                                                  <label for="exampleInputEmail1">Payment Type</label>
                                                                   <select name="payment_type" class="form-control" id="cheque_<?php echo e($ob['owner_id']); ?>" onchange="chequeNumber(<?php echo e($ob['owner_id']); ?>)" required>
                                                                    <option value="">Select</option>
                                                                    <option value="CAD/LC/TT">CAD/LC/TT</option>
                                                                    <option value="Direct Paymen">Direct Paymen</option>
                                                                   </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label >Amount</label>
                                                                    <input type="number" step="any" min="0"  name="amount" class="form-control"  value="<?php echo e($ob['balance']); ?>" >
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label >Discount</label>
                                                                    <input type="number" step="any" name="discount" min="0" class="form-control"  value="0" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="chequedate_<?php echo e($ob['owner_id']); ?>" style="display: none">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label >On Bank</label>
                                                                        <a  data-toggle="modal" data-target="#modal-md" style='color:rgb(98, 255, 0)'>
                                                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                        </a>
                                                                        <select name="bank" class="form-control" >
                                                                            <option value="">Select</option>
                                                                           <?php $__empty_2 = true; $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                                            <option value="<?php echo e($bank->BankName); ?>"><?php echo e($bank->BankName); ?> &nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <?php echo e($bank->AccountNumber); ?></option>
                                                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                                           <?php endif; ?>
                                                                           </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label >RefrenceNo</label>
                                                                        <input type="text" name="refrence_no" class="form-control"  placeholder="Cheque Number" >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label >Related Docs</label>
                                                                    <input type="file" name="docs"  accept="application/pdf" class="form-control" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label >Remark <sub>Optional</sub></label>
                                                                    <textarea name="remark" class="form-control" placeholder="Remarks"></textarea>
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

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                        </div>
                    </div>

                  </div>
              <div class="card sm">
                <div class="card-body">
                    
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Date</th>
                      <th>PaidBy</th>
                      <th>Debit</th>
                      <th>Credit</th>
                      <th>Balance</th>
                      <th></th>

                    </tr>
                    </thead>
                    <tbody id='list'>
                        <?php
                            $no = 0;
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $netData['ledger']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $no = $no + 1;
                        ?>
                         <tr>
                            <td><?php echo e($no); ?></td>
                            <td><?php echo e($ledger['date']); ?></td>
                            <td><?php echo e($ledger['owner']); ?></td>
                            <td style="background-color: red"><?php echo e(number_format($ledger['debit'],2)); ?></td>
                            <td style="background-color: green"><?php echo e(number_format($ledger['credit'],2)); ?></td>
                            <td><b><i><?php echo e(number_format($ledger['balance'],2)); ?></i></b></td>
                            <td>
                            <?php if($ledger['debit'] == 0): ?>
                                <a href="" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-lg-payment-<?php echo e($ledger['id']); ?>">Detail</a>
                            <?php endif; ?>
                            </td>

                        </tr>

                        <?php $__empty_2 = true; $__currentLoopData = $purchasPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchasPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                        <?php if($purchasPayment->PL_id == $ledger['id']): ?>
                            <div class="modal fade" id="modal-lg-payment-<?php echo e($purchasPayment->PL_id); ?>">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> <i class="text-info"><?php echo e($netData['vender']); ?></i> By <i class="text-success"><?php echo e($ledger['owner']); ?></i></h4>
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
                                                <form  action="/editPurchasePayment-<?php echo e($purchasPayment->id); ?>" method="POST" id="quickForm" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                <div class="">
                                                    

                                                    <input type="date" name="date" class="form-control col-3 p-2" style="float: right;" value="<?php echo e($purchasPayment->date); ?>" required>
                                                    <label style="float: right;"> Date &nbsp;&nbsp;</label>

                                                </div>

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-4" >
                                                            <div class="form-group">
                                                              <label for="exampleInputEmail1">Payment Type</label>
                                                               <select name="payment_type" class="form-control" required>
                                                                <option value="<?php echo e($purchasPayment->payment_type); ?>"><?php echo e($purchasPayment->payment_type); ?></option>
                                                                <option value="CAD/LC/TT">CAD/LC/TT</option>
                                                                <option value="Direct Paymen">Direct Paymen</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Amount</label>
                                                                <input type="number" step="any" min="0"  name="amount" class="form-control"  value="<?php echo e($purchasPayment->amount); ?>" >
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Discount</label>
                                                                <input type="number" step="any" name="discount" min="0" class="form-control"  value="<?php echo e($purchasPayment->discount); ?>" required>
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
                                                                    <select name="bank" class="form-control" >
                                                                        <option value="<?php echo e($purchasPayment->BnakName); ?>"><?php echo e($purchasPayment->BankName); ?></option>
                                                                       <?php $__empty_3 = true; $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?>
                                                                        <option value="<?php echo e($bank->BankName); ?>"><?php echo e($bank->BankName); ?> &nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; <?php echo e($bank->AccountNumber); ?></option>
                                                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?>
                                                                       <?php endif; ?>
                                                                       </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >RefrenceNo</label>
                                                                    <input type="text" name="refrence_no" class="form-control" value="<?php echo e($purchasPayment->refrence_no); ?>"  placeholder="Cheque Number" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >Related Docs</label>
                                                                <input type="file" accept="application/pdf" name="docs" class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >Docs</label>

                                                              <p>Open Transaction Related file <a href="/<?php echo e($purchasPayment->Docs); ?>">Here</a>.</p>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label >Remark <sub>Optional</sub></label>
                                                                <textarea name="remark" class="form-control" placeholder="Remarks"><?php echo e($purchasPayment->Remarks); ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    

                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <a href="deletePurchasePayment-<?php echo e($purchasPayment->id); ?>"class="btn btn-danger" onclick="return confirm('Are you sure you ? after delete this transaction there is no way to  recover it !!!');">Delete</a>
                                                        <button type="submit" class="btn btn-success swalDefaultSuccess" onclick="return confirm('Are you sure you ? you wanna save changes');">Save Changes</button>
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
                             <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <?php endif; ?>
                    </tbody>
                  </table>

              


                </div>
                <!-- /.card-body -->
              </div>
        <!-- /.card -->


            </div>
        <!-- /.modal-dialog -->

        </div>
    </div>
    <!-- /.modal -->



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
  </section>
  <script>
    function chequeNumber(id){
        var type = $('#cheque_'+id).val();
        console.log(type);
        if(type == 'CAD/LC/TT'){
           document.getElementById('chequedate_'+id).style.display = 'block';
        }else{
           document.getElementById('chequedate_'+id).style.display = 'none';

        }
    }
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/pages/purchase/purchasePayment.blade.php ENDPATH**/ ?>