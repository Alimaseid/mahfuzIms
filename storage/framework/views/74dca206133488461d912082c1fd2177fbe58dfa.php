<?php $__env->startSection('content'); ?>

<section class="content">
    <div class="container-fluid">
        <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
              <div class="row">
                  <div class="col-6 lg">
                    <div class="pl-3"><b> requisitions : <?php echo e(0); ?></b></div>
                  </div>
                  <div class="col-6 lg">
                      <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                          requisition
                        </button>
                  </div>
              </div>
           </div>
      </div>
      </div>
        <div class="row p-3">
              <div class="card">
                <div class="card-body text-sm">
                    
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>RequisitionDate</th>
                      <th>Requisition#No</th>
                      <th>RequestBy</th>
                      <th>RequestFrom</th>
                      <th>Status</th>
                      <th>ItemList</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                    <?php $no = 0 ; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                         <?php $no = $no + 1 ; ?>
                            <tr>
                                <td><?php echo e($no); ?></td>
                                <td><?php echo e($requisition->created_at->toDateString()); ?></td>
                                <td><?php echo e($requisition->id); ?></td>
                                <td><?php echo e($requisition->request_by); ?></td>
                                <td><?php echo e($requisition->request_from); ?></td>
                                <td> <a href=""><?php echo e($requisition->status); ?> </a></td>
                                <td  style="width: 50%;">
                                    <?php $__empty_2 = true; $__currentLoopData = $requisition->itemList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                        <?php echo e($list->item_name); ?> <i style="color: rgb(8, 239, 8)">(<?php echo e($list->quantity); ?>)</i>,
                                        <br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>

                                    <?php endif; ?>
                                </td>

                                <td>
                                    <a href="#" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash "></i>
                                      </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php endif; ?>
                     </tbody>
                    </table>
                
                </div>
                  <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Make New requisition</h4>
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
                                <div class="card-body">
                                    <form action="requisition" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                  <h4>
                                                    <i class="fas fa-globe"></i> UKAZ, Inc.
                                                    <small class="float-right">Date : <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?></small>
                                                  </h4>
                                                </div>
                                                <!-- /.col -->
                                              </div>
                                            <div class="row invoice-info">
                                                <div class="col-sm-5 invoice-col">
                                                  <address>
                                                    
                                                    requisition From
                                                    <div class="form-group">
                                                        <select name="request_from"  class="form-control" id="location" required>
                                                            <option value="">Select Here</option>
                                                                <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                   <option value="<?php echo e($location->name); ?>"><?php echo e($location->name); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                <option value="">Empty Location !</option>
                                                                <?php endif; ?>
                                                        </select>
                                                    </div>

                                                  </address>
                                                </div>
                                                <div class="col-sm-2 invoice-col">

                                                  </div>
                                                  <div class="col-sm-5 invoice-col">
                                                    <address>
                                                      
                                                      requisitiond By
                                                      <div class="form-group">
                                                        <input type="text" readonly value="<?php echo e(Auth::user()->name); ?>" name="shipped_by" class="form-control" required>
                                                    </div>

                                            </div>
                                            <div class="row">

                                                <div class="col-12 table-responsive">

                                                  <table class="table table-striped">
                                                      <tr>
                                                          <th>ProductNameCode</th>
                                                          <th>Quantity</th>
                                                          
                                                          <th></th>
                                                      </tr>
                                                    <tbody id="add_items">
                                                      <tr>
                                                        <td style="width: 250px;">
                                                            <div class="row">
                                                                <div class="dropdown">
                                                                    <div id="myDropdown_0" class="dropdown-content">
                                                                        <input type="text" autoComplete="off" placeholder="Search.." id="myInput_0" onclick="myFunction(0)" onkeyup="filterFunction(0)" name="addmore[0][search_item]"  class="form-control">
                                                                        <div id="items_0" style="display: none">
                                                                            <ul class="nav nav-pills nav-sidebar flex-column" id="item_list_0" data-widget="treeview" role="menu" data-accordion="false">

                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="item_id_0" name="addmore[0][item_id]" value="">
                                                         </td>
                                                          <td>
                                                             <input type="number"  min="0" id='quantity_0' name="addmore[0][quantity]" placeholder="Quantity" class="form-control input-group-sm" required>
                                                          </td>
                                                          
                                                        </tr>
                                                    </tbody>

                                                  </table>
                                                  <a href="#" id="add_new_items"  class="btn btn-success float-right" style="padding:5px; text-decoration:none">

                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                  </a>

                                                </div><hr><br>
                                                <!-- /.col -->
                                              </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <button type="submit" class="btn btn-primary swalDefaultSuccess">Submit</button>
                                    </form>
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
</section>
<script>
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
                            <input type="text" autoComplete="off" placeholder="Search.." id="myInput_`+ i +`" onclick="myFunction(`+ i +`)" onkeyup="filterFunction(`+ i +`)" name="addmore[`+ i +`][search_item]"  class="form-control">
                            <div id="items_`+ i +`" style="display: none">
                                <ul class="nav nav-pills nav-sidebar flex-column" id="item_list_`+ i +`" data-widget="treeview" role="menu" data-accordion="false">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="item_id_`+ i +`" name="addmore[`+ i +`][item_id]" value="">
         </td>
          <td>
             <input type="number" min="0" id='quantity_`+ i +`'  name="addmore[`+ i +`][quantity]" placeholder="Quantity" class="form-control input-group-sm" required>
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

    function myFunction(no) {
            $.ajax({
                type: "POST",
                url: "<?php echo e(url('getItemForSale')); ?>",
                dataType:'json',
                data:{
                    '_token':'<?php echo e(csrf_token()); ?>',
                    },
                success: function (result) {
                    var rowData = '';
                    // var no = 0;
                    $('#item_list_'+no).html('');
                    $.each(result, function(index,value){
                        // no = no+1;
                        rowData = `
                           <option class="nav-link" id="item_${value.id}" onclick="selectedItem(${value.id},${no},${value.quantity})">${value.item_name} &nbsp; | ${value.product_code}</option>
                        `;

                        $('#item_list_'+no).append(rowData);


                    });
                },

            });

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

    function selectedItem(id,no,quantity){

         document.getElementById("items_"+no).style.display = 'none';
         document.getElementById("myInput_"+no).value =  document.getElementById("item_"+id).value;
         document.getElementById("item_id_"+no).value =  id;
         document.getElementById("remain_"+no).value =  quantity;
         document.getElementById("quantity_"+no).setAttribute("max",document.getElementById("remain_"+no).value);;

        }
    function chageQyt(i){
       var qyt =  document.getElementById("quantity_"+i).value;
       var rem = document.getElementById("remain_"+i).value;
       document.getElementById("remain_"+i).value = rem - qyt;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/nuhaimscom/app.nuhaims.com/resources/views/pages/store/iterm_transfer.blade.php ENDPATH**/ ?>