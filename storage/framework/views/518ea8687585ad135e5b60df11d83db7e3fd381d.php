<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6 lg">
                                    <div class="pl-3"><b> Customers: <?php echo e(number_format(count($customers))); ?></b></div>
                                </div>
                                <div class="col-6 lg">
                                    <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                        data-toggle="modal" data-target="#modal-lg">
                                        New Customer
                                    </button>
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
                                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $no = $no + 1;
                                    ?>
                                    <tr>
                                        <td><?php echo e($no); ?></td>
                                        <td><?php echo e($customer->name); ?></td>
                                        <td><?php echo e($customer->phone); ?></td>
                                        
                                        
                                        <td><?php echo e($customer->type); ?></td>
                                        <td style="color: greenyellow;background-color:rgb(5, 5, 36)">
                                            <?php echo e(number_format($customer->total_balance, 2)); ?></td>
                                        <td>
                                            <a class="btn btn-success btn-xs"
                                                href="customerPayments-<?php echo e($customer->id); ?>">Balance</a>
                                            <a class="btn btn-primary btn-xs"
                                                href="customerSalesHitory-<?php echo e($customer->id); ?>">History</a>
                                            <a class="btn btn-warning btn-xs"
                                                href="sales-return-<?php echo e($customer->id); ?>">SalesReturn</a>

                                        </td>
                                        <td>
                                            <?php if($permission->manage_edit_customer == 'on'): ?>
                                                <a class="btn btn-info btn-xs" data-toggle="modal"
                                                    data-target="#modal-lg-customer-<?php echo e($customer->id); ?>">Edit</a>
                                            <?php endif; ?>
                                            <?php if($permission->manage_delete_customer == 'on'): ?>
                                                <a class="btn btn-danger btn-xs" href="delete-customer-<?php echo e($customer->id); ?>"
                                                    onclick="return confirm('Are you sure you ?');">Delete</a>
                                            <?php endif; ?>
                                            
                                        </td>
                                        

                                    </tr>

                                    <div class="modal fade" id="modal-lg-customer-<?php echo e($customer->id); ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit <i
                                                            class="text-warning"><?php echo e($customer->name); ?>'s </i>Information
                                                    </h4>
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
                                                                        <h3 class="card-title"><i
                                                                                class="text-warning"><?php echo e($customer->name); ?></i>
                                                                        </h3>
                                                                    </div>
                                                                    <!-- /.card-header -->
                                                                    <!-- form start -->
                                                                    <form action="/edit-customer-<?php echo e($customer->id); ?>"
                                                                        method="POST" id="quickForm">
                                                                        <?php echo csrf_field(); ?>
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label for="exampleInputEmail1">Full
                                                                                            Name</label>
                                                                                        <input type="text" name="name"
                                                                                            class="form-control"
                                                                                            id="exampleInputEmail1"
                                                                                            value="<?php echo e($customer->name); ?>"
                                                                                            required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label for="exampleInputPassword1"
                                                                                            id='click'> Phone</label>
                                                                                        <input type="text" name="phone"
                                                                                            class="form-control"
                                                                                            id="exampleInputPassword1"
                                                                                            value="<?php echo e($customer->phone); ?>"
                                                                                            required
                                                                                            pattern="[+ , 0]{1}[0-9]{9,14}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label for="exampleInputPassword1"
                                                                                            id='click'> Email
                                                                                            <small>Optional</small> </label>
                                                                                        <input type="email" name="email"
                                                                                            class="form-control"
                                                                                            id="exampleInputPassword1"
                                                                                            value="<?php echo e($customer->email); ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="exampleInputEmail1">Type</label>
                                                                                        <select name="type"
                                                                                            id=""
                                                                                            class="form-control" required>
                                                                                            <option
                                                                                                value="<?php echo e($customer->type); ?>">
                                                                                                <?php echo e($customer->type); ?>

                                                                                            </option>
                                                                                            <option value="Business">
                                                                                                Business</option>
                                                                                            <option value="Individual">
                                                                                                Individual</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="exampleInputPassword1">Company
                                                                                            Name <small>Optional</small>
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            name="company_name"
                                                                                            class="form-control"
                                                                                            id="exampleInputPassword1"
                                                                                            value="<?php echo e($customer->company_name); ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="exampleInputPassword1">TIN
                                                                                            <small>Optional</small> </label>
                                                                                        <input type="text"
                                                                                            name="tin"
                                                                                            class="form-control"
                                                                                            id="exampleInputPassword1"
                                                                                            value="<?php echo e($customer->tin); ?>">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="exampleInputPassword1"> Address
                                                                                    <small>Optional</small> </label>
                                                                                <input type="text" name="address"
                                                                                    class="form-control"
                                                                                    id="exampleInputPassword1"
                                                                                    value="<?php echo e($customer->address); ?>">
                                                                            </div>
                                                                        </div>

                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success swalDefaultSuccess">Save
                                                                                Update</button>
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
                <div class="modal fade" id="modal-lg">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Customer</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <div class="card card-default">
                                                <!-- /.card-header -->
                                                <div class="card-body" style="color: black">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Customer<small> Information </small>
                                                            </h3>
                                                        </div>
                                                        <form action="add-customer" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Full
                                                                                Name</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control"
                                                                                id="exampleInputEmail1"
                                                                                placeholder="Customer Full Name" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputPassword1"
                                                                                id='click'> Phone</label>
                                                                            <input type="text" name="phone"
                                                                                class="form-control"
                                                                                id="exampleInputPassword1"
                                                                                placeholder="Phone" required
                                                                                pattern="[+ , 0]{1}[0-9]{9,14}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputPassword1"
                                                                                id='click'> Email
                                                                                <small>Optional</small> </label>
                                                                            <input type="email" name="email"
                                                                                class="form-control"
                                                                                id="exampleInputPassword1"
                                                                                placeholder="Email">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Type</label>
                                                                            <select name="type" id=""
                                                                                class="form-control" required>
                                                                                <option value="">Select Here</option>
                                                                                <option value="Business">Business</option>
                                                                                <option value="Individual">Individual
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputPassword1">Company Name
                                                                                <small>Optional</small> </label>
                                                                            <input type="text" name="company_name"
                                                                                class="form-control"
                                                                                id="exampleInputPassword1"
                                                                                placeholder="Company Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputPassword1">TIN
                                                                                <small>Optional</small> </label>
                                                                            <input type="text" name="tin"
                                                                                class="form-control"
                                                                                id="exampleInputPassword1"
                                                                                placeholder="TIN Number">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="exampleInputPassword1"> Address
                                                                        <small>Optional</small> </label>
                                                                    <input type="text" name="address"
                                                                        class="form-control" id="exampleInputPassword1"
                                                                        placeholder="address">
                                                                </div>
                                                            </div>
                                                            <!-- /.card-body -->
                                                            <div class="card-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary swalDefaultSuccess">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/customers/customer.blade.php ENDPATH**/ ?>