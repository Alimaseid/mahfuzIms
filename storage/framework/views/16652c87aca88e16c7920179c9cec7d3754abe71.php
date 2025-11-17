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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        
                        <table id="example1" class="table table-bordered table-striped"
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>CustomerName</th>
                                    <th>Phone</th>
                                    <th>BussinesType</th>
                                    <th style="background-color:rgb(5, 5, 36);">TotalBalance</th>
                                    <th><i></i></th>
                                    <th><i></i></th>

                                </tr>
                            </thead>
                            <tbody id='list'>
                                <?php
                                    $no = 0;
                                ?>
                                <?php $__empty_1 = true; $__currentLoopData = $creditcustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $credit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php if($credit->sales_type == 'Credit Sales' && $credit->customer->total_balance > 1): ?>
                                        <?php
                                            $no = $no + 1;
                                        ?>
                                        <tr>
                                            <td><?php echo e($no); ?></td>
                                            <td><?php echo e($credit->customer->name); ?></td>
                                            <td><?php echo e($credit->customer->phone); ?></td>
                                            
                                            
                                            <td><?php echo e($credit->customer->type); ?></td>
                                            <td style="color: greenyellow;background-color:rgb(5, 5, 36)">
                                                <?php echo e(number_format($credit->customer->total_balance, 2)); ?></td>
                                            <td>
                                                <a class="btn btn-success btn-xs"
                                                    href="customerPayments-<?php echo e($credit->customer->id); ?>">Balance</a>
                                                <a class="btn btn-primary btn-xs"
                                                    href="customerSalesHitory-<?php echo e($credit->customer->id); ?>">History</a>
                                                <a class="btn btn-warning btn-xs"
                                                    href="sales-return-<?php echo e($credit->customer->id); ?>">SalesReturn</a>

                                            </td>
                                            <td>
                                                <a class="btn btn-info btn-xs" data-toggle="modal"
                                                    data-target="#modal-lg-customer-<?php echo e($credit->id); ?>">Edit</a>
                                                <a class="btn btn-danger btn-xs" href="#"
                                                    onclick="return confirm('Are you sure you ?');">Delete</a>
                                                
                                            </td>
                                            

                                        </tr>
                                    <?php endif; ?>


                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/customers/creditSales.blade.php ENDPATH**/ ?>