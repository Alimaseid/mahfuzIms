<style>
    /* Make dropdown appear above input */
    .dropdown-menu.show-top {
        top: auto !important;
        bottom: 100% !important;
        margin-bottom: 5px !important;
    }
</style>

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
                                <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                    data-toggle="modal" data-target="#modal-lg">
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
                        
                        <table id="example1" class="table table-bordered table-striped"
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>RequisitionDate</th>
                                    <th>RequestFrom</th>
                                    <th>RequestBy</th>
                                    <th>RequestTo</th>
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
                                        <td><?php echo e($requisition->requestFrom->name ?? '-'); ?></td>
                                        <td><?php echo e($requisition->request_by); ?></td>
                                        <td><?php echo e($requisition->requestTo->name ?? '-'); ?></td>

                                        <td> <a href=""><?php echo e($requisition->status); ?> </a></td>

                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-<?php echo e($requisition->id); ?>">
                                                view
                                            </button>

                                        </td>

                                        <td>
                                            <a href="/transfer-print-<?php echo e($requisition->id); ?>" rel="noopener" target="_blank"
                                                class="btn btn-warning btn-sm"><i class="fas fa-print"></i> Print</a>
                                            <?php if($requisition->status != 'Approved'): ?>
                                                <a href="/delete-requisition-<?php echo e($requisition->id); ?>"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash "></i>
                                                </a>
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-lg-view-<?php echo e($requisition->id); ?>">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">
                                                    </h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            Item
                                                        </div>
                                                        <div class="col">
                                                            Part no1
                                                        </div>
                                                        <div class="col">
                                                            Part no2
                                                        </div>
                                                        <div class="col">
                                                            Image1
                                                        </div>
                                                        <div class="col">
                                                            Image2
                                                        </div>
                                                        <div class="col">
                                                            unit
                                                        </div>
                                                        <div class="col">
                                                            Category
                                                        </div>
                                                        <div class="col">
                                                            Shelf
                                                        </div>
                                                        <div class="col">
                                                            Batch
                                                        </div>
                                                        <div class="col">
                                                            Quantity
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <?php
                                                        $total = 0;
                                                    ?>
                                                    <?php $__empty_2 = true; $__currentLoopData = $requisitionDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisitionDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                        <?php if($requisitionDetail->requisition_id == $requisition->id): ?>
                                                            <?php
                                                                $imagePath1 = str_replace(
                                                                    '\\',
                                                                    '/',
                                                                    $requisitionDetail->item->image,
                                                                );
                                                                $imagePath2 = str_replace(
                                                                    '\\',
                                                                    '/',
                                                                    $requisitionDetail->item->image2,
                                                                );
                                                            ?>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->item_name); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->product_code); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->part_number); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <img src="<?php echo e(asset($imagePath1)); ?>" alt=""
                                                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">

                                                                </div>
                                                                <div class="col">
                                                                    <b> <img src="<?php echo e(asset($imagePath2)); ?>" alt=""
                                                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">
                                                                    </b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->unit); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->item->category); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <b>
                                                                        <?php $__currentLoopData = $shelfs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shelff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php if(
                                                                                $shelff->shelf->business_locations_id == $requisition->request_from &&
                                                                                    $requisitionDetail->item_id == $shelff->item_id): ?>
                                                                                <?php echo e($shelff->shelf->shelf_name ?? '-'); ?>

                                                                            <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </b>
                                                                </div>
                                                                <div class="col">
                                                                    <b><?php echo e($requisitionDetail->batch->batch_number ?? ''); ?></b>
                                                                </div>
                                                                <div class="col">
                                                                    <?php echo e(number_format($requisitionDetail->quantity)); ?>

                                                                </div>
                                                            </div>
                                                            <br>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                    <?php endif; ?>

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
                                                                    <i class="fas fa-globe"></i> inventory, Inc.
                                                                    <small class="float-right">Date :
                                                                        <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?></small>
                                                                </h4>
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <div class="row invoice-info">
                                                            <div class="col-sm-4 invoice-col">
                                                                <address>
                                                                    
                                                                    requisition From
                                                                    <div class="form-group">
                                                                        <select name="request_from" id="request_from"
                                                                            class="form-control" required>
                                                                            <option value="">Select Here</option>
                                                                            <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value="<?php echo e($location->id); ?>">
                                                                                    <?php echo e($location->name); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </select>

                                                                    </div>

                                                                </address>
                                                            </div>
                                                            <div class="col-sm-4 invoice-col">
                                                                <address>
                                                                    
                                                                    requisition To
                                                                    <div class="form-group">
                                                                        <select name="request_to" class="form-control"
                                                                            id="location" required>
                                                                            <option value="">Select Here</option>
                                                                            <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                                                <option value="<?php echo e($location->id); ?>">
                                                                                    <?php echo e($location->name); ?></option>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                                                <option value="">Empty Location !
                                                                                </option>
                                                                            <?php endif; ?>
                                                                        </select>
                                                                    </div>

                                                                </address>
                                                            </div>

                                                            <div class="col-sm-4 invoice-col">
                                                                <address>
                                                                    
                                                                    requisition By
                                                                    <div class="form-group">
                                                                        <input type="text" readonly
                                                                            value="<?php echo e(Auth::user()->name); ?>"
                                                                            name="shipped_by" class="form-control"
                                                                            required>
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
                                                                            <tr id="row_0">
                                                                                <td style="width: 300px;">
                                                                                    <div class="item-search w-100 mb-2"
                                                                                        style="position:relative">
                                                                                        <input type="text"
                                                                                            placeholder="Search Item..."
                                                                                            id="myInput_0"
                                                                                            onclick="myFunction(0)"
                                                                                            onkeyup="filterFunction(0)"
                                                                                            class="form-control"
                                                                                            autocomplete="off" required>

                                                                                        <div id="items_0"
                                                                                            class="dropdown-menu w-100"
                                                                                            style="display:none; position:absolute; z-index:1000; max-height:250px; overflow-y:auto;">
                                                                                            <ul id="item_list_0"
                                                                                                class="list-unstyled mb-0">
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>

                                                                                    <input type="hidden" id="item_id_0"
                                                                                        name="addmore[0][item_id]"
                                                                                        value="">
                                                                                    <input type="hidden" id="batch_id_0"
                                                                                        name="addmore[0][batch_id]"
                                                                                        value="">
                                                                                    <div id="item_image_preview_0"
                                                                                        class="mt-2"></div>
                                                                                </td>


                                                                                <td>
                                                                                    <input type="number" min="0"
                                                                                        id='quantity_0'
                                                                                        name="addmore[0][quantity]"
                                                                                        placeholder="Quantity"
                                                                                        class="form-control input-group-sm"
                                                                                        required>
                                                                                </td>
                                                                                
                                                                            </tr>
                                                                        </tbody>

                                                                    </table>
                                                                    <a href="#" id="add_new_items"
                                                                        class="btn btn-success float-right"
                                                                        style="padding:5px; text-decoration:none">

                                                                        <i class="fa fa-plus-circle"
                                                                            aria-hidden="true"></i>
                                                                    </a>

                                                                </div>
                                                                <hr><br>
                                                                <!-- /.col -->
                                                            </div>

                                                        </div>
                                                        <!-- /.card-body -->
                                                        <button type="submit"
                                                            class="btn btn-primary swalDefaultSuccess">Submit</button>
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

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var i = 0;
        var selectedItems = []; // Track selected items

        // ---------------- ADD NEW ROW ----------------
        $("#add_new_items").click(function() {
            ++i;
            $("#add_items").append(`
        <tr>
            <td style="width: 300px;">
                <div class="item-search w-100 mb-2" style="position:relative">
                    <input type="text" placeholder="Search Item..."
                        id="myInput_${i}"
                        onclick="myFunction(${i})"
                        onkeyup="filterFunction(${i})"
                        class="form-control"
                        autocomplete="off"
                        required>

                    <div id="items_${i}" class="dropdown-menu w-100"
                        style="display:none; position:absolute; z-index:1000; max-height:250px; overflow-y:auto;">
                        <ul id="item_list_${i}" class="list-unstyled mb-0"></ul>
                    </div>
                </div>

                <input type="hidden" id="item_id_${i}" name="addmore[${i}][item_id]" value="">
                <input type="hidden" id="batch_id_${i}" name="addmore[${i}][batch_id]" value="">
                <div id="item_image_preview_${i}" class="mt-2"></div>
            </td>
            <td>
                <input type="number" min="0" id="quantity_${i}"
                    name="addmore[${i}][quantity]"
                    placeholder="Quantity"
                    class="form-control input-group-sm"
                    required>
            </td>
            <td>
                <button type="button" class="remove-tr"><b style="color:red">X</b></button>
            </td>
        </tr>
    `);
        });

        // ---------------- REMOVE ROW ----------------
        $(document).on('click', '.remove-tr', function() {
            let row = $(this).closest('tr');
            let removedId = row.find("input[name*='item_id']").val();
            selectedItems = selectedItems.filter(id => id != removedId);
            row.remove();
        });

        // ---------------- LOAD ITEMS ----------------
        function myFunction(no) {
            let list = $('#item_list_' + no);
            let locationId = $("select[name='request_from']").val();

            if (!locationId) {
                alert("⚠️ Please select 'Requisition From' location first.");
                return;
            }

            list.html(''); // clear old data

            $.ajax({
                type: "POST",
                url: "<?php echo e(url('getItemForSale')); ?>",
                dataType: 'json',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    location_id: locationId
                },
                success: function(result) {
                    $.each(result, function(index, value) {
                        if (selectedItems.includes(String(value.id))) return;

                        let imageUrl = value.image ? `/${value.image}` : '/images/no-image.png';
                        let listItem = `
                    <li class="dropdown-item d-flex align-items-center border-bottom py-2"
                        style="cursor:pointer;"
                        data-name="${(value.item_name + ' ' + value.product_code).toUpperCase()}"
                        onclick="selectedItem(${value.id}, ${no}, ${value.quantity}, '${value.item_name}', '${value.product_code}', '${imageUrl}', '${value.batch_id}')">

                        <img src="${imageUrl}" style="width:40px;height:40px;object-fit:cover;border-radius:5px;margin-right:10px;">
                        <div>
                            <strong>${value.item_name}</strong><br>
                            <small class="text-muted">${value.product_code} | Stock: ${value.quantity}</small>
                        </div>
                    </li>
                `;
                        list.append(listItem);
                    });

                    // dropdown position fix
                    positionDropdown(no);
                    $('#items_' + no).show();
                }
            });
        }

        // ---------------- FILTER FUNCTION ----------------
        // ---------------- FILTER FUNCTION WITH TOP MATCHES ----------------
        function filterFunction(no) {
            let input = $("#myInput_" + no).val().toUpperCase();

            let items = $("#item_list_" + no + " li").toArray();

            // Separate exact/starting matches from others
            let topMatches = [];
            let otherMatches = [];

            items.forEach(function(item) {
                let text = ($(item).attr("data-name") || $(item).text()).toUpperCase();
                if (text.indexOf(input) > -1) {
                    if (text.startsWith(input)) {
                        topMatches.push(item); // Starts with input → top
                    } else {
                        otherMatches.push(item); // contains input elsewhere
                    }
                }
            });

            // Clear the list and append sorted items
            let list = $("#item_list_" + no);
            list.html('');
            topMatches.concat(otherMatches).forEach(function(item) {
                list.append(item);
                $(item).show();
            });

            // Hide if nothing found
            if (topMatches.length + otherMatches.length > 0) {
                positionDropdown(no);
                $('#items_' + no).show();
            } else {
                $('#items_' + no).hide();
            }
        }


        // ---------------- SELECT ITEM ----------------
        function selectedItem(id, no, quantity, name, code, imageUrl, batchId) {
            $("#items_" + no).hide();
            $("#myInput_" + no).val(name + " | " + code);
            $("#item_id_" + no).val(id);
            $("#batch_id_" + no).val(batchId);

            if (!selectedItems.includes(String(id))) {
                selectedItems.push(String(id));
            }

            $("#quantity_" + no).attr("max", quantity);

            $("#item_image_preview_" + no).html(`
        <img src="${imageUrl}" style="width:60px;height:60px;border-radius:5px;cursor:pointer;border:1px solid #ccc;"
            onclick="openImageModal('${imageUrl}')">
    `);
        }

        // ---------------- DROPDOWN POSITION FIX ----------------
        function positionDropdown(no) {
            let dropdown = $('#items_' + no);
            let input = $('#myInput_' + no);
            let inputOffset = input.offset();
            let windowHeight = $(window).height();
            let dropdownHeight = dropdown.outerHeight();

            // if not enough space below, show on top
            if (inputOffset.top + input.outerHeight() + dropdownHeight > windowHeight) {
                dropdown.css({
                    top: 'auto',
                    bottom: '100%',
                    'margin-bottom': '5px'
                });
            } else {
                dropdown.css({
                    top: '100%',
                    bottom: 'auto',
                    'margin-top': '5px'
                });
            }
        }

        // ---------------- IMAGE MODAL ----------------
        function openImageModal(src) {
            $("#modalImage").attr("src", src);
            $("#imageModal").modal("show");
        }

        // ---------------- CLOSE DROPDOWN ON CLICK OUTSIDE ----------------
        $(document).on("click", function(e) {
            if (!$(e.target).closest(".item-search").length) {
                $(".dropdown-menu").hide();
            }
        });
    </script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Halima\Documents\ims\resources\views/pages/store/iterm_transfer.blade.php ENDPATH**/ ?>