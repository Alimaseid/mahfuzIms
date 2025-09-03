<?php $__env->startSection('content'); ?>
<div class="col-md-12">
    <div class="card card-primary card-outline">
      <div class="card-header">
      <div class="row">
          <div class="col-8 lg">
            <div class="pl-3"> <small>Vendors: </small><b> <?php echo e(count($vendor)); ?></b></div>
          </div>
          <div class="col-4 lg">

            <button type="button" class="btn btn-primary pull-rigth btn-sm" style="float: right;" data-toggle="modal" data-target="#modal-lg">
              New vendor
            </button>
          </div>
      </div>
   </div>
</div>
</div>
    <div class="row">
        <div class="col-9">
            <section class="content" >
                <div class="container-fluid">
                        <div class="timeline">
                            <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div id='list'>
                            <i class="fas fa-user bg-green"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i><?php echo e($vendor->created_at->diffForHumans()); ?></span>
                                <h3 class="timeline-header no-border"><a href="#"><?php echo e($vendor->name); ?></a>:
                                 <small>Phone:</small> <?php echo e($vendor->phone); ?> , <small>Company:</small> <?php echo e($vendor->company_name); ?>

                                 <div id="detail_<?php echo e($vendor->id); ?>" style="display:none;">
                                    <small>City</small> <?php echo e($vendor->city); ?> , <small>Email</small> <?php echo e($vendor->email); ?>

                                    <small>Woreda</small> <?php echo e($vendor->woreda); ?> , <small>Kebele</small> <?php echo e($vendor->kebele); ?>

                                 </div>
                                </h3>
                                <div class="timeline-footer">
                                    <a class="btn btn-success btn-xs" href="purcahsePayments-<?php echo e($vendor->id); ?>">Balance</a>
                                    <a class="btn btn-primary btn-xs" href="vendorPurchaseHistory-<?php echo e($vendor->id); ?>" >History</a>
                                    <a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-lg-vendor-<?php echo e($vendor->id); ?>">Edit</a>
                                    <a class="btn btn-danger btn-xs" href="delete-vendor-<?php echo e($vendor->id); ?>" onclick="return confirm('Are you sure you ?');">Delete</a>
                                </div>
                            </div>
                            </div>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php endif; ?>
                            
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
                        </div>
                    </div>

                </div>
                <!-- /.timeline -->
                </section>
        </div>
    </div>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Owner</h4>
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
                                    <h3 class="card-title">vendor<small> Information </small></h3>
                                </div>
                                <form action="add-vendor" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Full Name</label>
                                                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Vendor Full Name" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1" id='click'> Phone</label>
                                                    <input type="text" name="phone" class="form-control" id="exampleInputPassword1" placeholder="Phone" required pattern="[+ , 0]{1}[0-9]{9,14}" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1" id='click'> Email <small>Optional</small> </label>
                                                    <input type="email" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Company Name <small>Optional</small> </label>
                                                    <input type="text" name="company_name" class="form-control" id="exampleInputPassword1" placeholder="Company Name" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">City <small>Optional</small> </label>
                                                    <input type="text" name="city" class="form-control" id="exampleInputPassword1" placeholder="City" >
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Woreda <small>Optional</small> </label>
                                                    <input type="text" name="woreda" class="form-control" id="exampleInputPassword1" placeholder="Woreda" >
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Kebele <small>Optional</small> </label>
                                                    <input type="text" name="kebele" class="form-control" id="exampleInputPassword1" placeholder="Kebele" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                    <button type="submit" class="btn btn-primary swalDefaultSuccess">Submit</button>
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


    <?php $__empty_1 = true; $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="modal fade" id="modal-lg-vendor-<?php echo e($vendor->id); ?>">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit <?php echo e($vendor->name); ?></h4>
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
                                <h3 class="card-title">vendor <small>Information</small></h3>
                            </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form  action="/edit-vendor-<?php echo e($vendor->id); ?>" method="POST" id="quickForm" >
                            <?php echo csrf_field(); ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Full Name</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" value=<?php echo e($vendor->name); ?> required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1" id='click'> Phone</label>
                                            <input type="text" name="phone" class="form-control" id="exampleInputPassword1" value=<?php echo e($vendor->phone); ?> required pattern="[+ , 0]{1}[0-9]{9,14}" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1" id='click'> Email <small>Optional</small> </label>
                                            <input type="email" name="email" class="form-control" id="exampleInputPassword1" value=<?php echo e($vendor->email); ?>>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Company Name <small>Optional</small> </label>
                                            <input type="text" name="company_name" class="form-control" id="exampleInputPassword1" value=<?php echo e($vendor->company_name); ?> >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">City <small>Optional</small> </label>
                                            <input type="text" name="city" class="form-control" id="exampleInputPassword1" value=<?php echo e($vendor->city); ?> >
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Woreda <small>Optional</small> </label>
                                            <input type="text" name="woreda" class="form-control" id="exampleInputPassword1" value=<?php echo e($vendor->woreda); ?> >
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Kebele <small>Optional</small> </label>
                                            <input type="text" name="kebele" class="form-control" id="exampleInputPassword1" value=<?php echo e($vendor->kebele); ?> >
                                        </div>
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

    <script type="text/javascript">
        $("#search").on('keyup',function(){
            var s_data = $(this).val();
            $.ajax({
                method:'POST',
                url: '<?php echo e(url("search-vendor")); ?>',
                data:{
                   '_token':'<?php echo e(csrf_token()); ?>',
                    name:s_data,
                },
                dataType:'json',
                success:function(data){
                    var rowData = '';
                    $('#list').html('');

                    $.each(data, function(index,value){
                        rowData = `
                        <i class="fas fa-user bg-green"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i>${value.created_at}</span>
                                <h3 class="timeline-header no-border"><a href="#">${value.name}</a>:
                                 <small>Phone</small> ${value.phone} , <small>Company</small> ${value.company_name}
                                 <div id="detail_${value.id}" style="display:none;">
                                     <small>address</small> ${value.city} , <small>Email</small> ${value.email}
                                    <small>Tin</small> ${value.woreda} , <small>Type</small> ${value.kebele}
                                </div>
                                 </h3>
                                <div class="timeline-footer">
                                    <a class="btn btn-success btn-xs" href="vendor-history-${value.id}">History</a>
                                    <a class="btn btn-primary btn-xs" onclick="vendorDetail(${value.id})">View</a>
                                    <a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal-lg-vendor-${value.id}">Edit</a>
                                    <a class="btn btn-danger btn-xs" href="delete-vendor-${value.id}" onclick="return confirm('Are you sure you ?');">Delete</a>
                                </div>
                            </div>
                        `;

                        $('#list').append(rowData);
                    });
                }
            });
        });
        </script>
       <script>
        function vendorDetail(id){
            var x = document.getElementById("detail_"+id);
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/merkuzcom/ims.merkuz.com/resources/views/pages/purchase/vendor.blade.php ENDPATH**/ ?>