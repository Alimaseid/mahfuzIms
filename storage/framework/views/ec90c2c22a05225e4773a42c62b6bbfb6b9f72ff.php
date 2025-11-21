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
                        <table id="example1" class="table table-bordered table-striped "
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                <?php $__empty_1 = true; $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php $no++; ?>
                                    <tr>
                                        <td><?php echo e($no); ?></td>
                                        <td><?php echo e($requisition->created_at->toDateString()); ?></td>
                                        <td><?php echo e($requisition->requestFrom->name ?? '-'); ?></td>
                                        <td><?php echo e($requisition->request_by); ?></td>
                                        <td><?php echo e($requisition->requestTo->name ?? '-'); ?></td>
                                        <td><?php echo e($requisition->status); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-view-<?php echo e($requisition->id); ?>">
                                                View
                                            </button>
                                        </td>
                                        <td>
                                            <a href="/transfer-print-<?php echo e($requisition->id); ?>" target="_blank"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-print"></i> Print
                                            </a>
                                            <?php if($requisition->status != 'Approved'): ?>
                                                <a href="/delete-requisition-<?php echo e($requisition->id); ?>"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No requisitions found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modals placed **outside of table** -->
            <?php $__currentLoopData = $requisitions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requisition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modal fade" id="modal-view-<?php echo e($requisition->id); ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Requisition Items</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Part No1</th>
                                                <th>Part No2</th>
                                                <th>Image1</th>
                                                <th>Image2</th>
                                                <th>Unit</th>
                                                <th>Category</th>
                                                <th>Shelf</th>
                                                <th>Batch</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $requisitionDetails->where('requisition_id', $requisition->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td><?php echo e($detail->item->item_name); ?></td>
                                                    <td><?php echo e($detail->item->product_code); ?></td>
                                                    <td><?php echo e($detail->item->part_number); ?></td>
                                                    <td>
                                                        <?php
                                                            $imagePath1 = str_replace('\\', '/', $detail->item->image);
                                                            $imagePath2 = str_replace('\\', '/', $detail->item->image2);
                                                        ?>
                                                        <img src="<?php echo e(asset($imagePath1)); ?>" alt=""
                                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                            data-toggle="modal" data-target="#imageModal"
                                                            onclick="setModalImage('<?php echo e(asset($imagePath1)); ?>')">
                                                    </td>
                                                    <td>
                                                        <img src="<?php echo e(asset($imagePath2)); ?>" alt=""
                                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                            data-toggle="modal" data-target="#imageModal"
                                                            onclick="setModalImage('<?php echo e(asset($imagePath2)); ?>')">
                                                    </td>
                                                    <td><?php echo e($detail->item->unit); ?></td>
                                                    <td><?php echo e($detail->item->category); ?></td>
                                                    <td><?php echo e($shelfs->firstWhere('item_id', $detail->item_id)?->shelf->shelf_name ?? '-'); ?>

                                                    </td>
                                                    <td><?php echo e($detail->batch->batch_number ?? '-'); ?></td>
                                                    <td><?php echo e(number_format($detail->quantity)); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td colspan="10" class="text-center">No items found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                                                            <td style="width: 450px;">
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

                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                </a>

                                                            </div>
                                                            <hr><br>
                                                            <!-- /.col -->
                                                        </div>
                                                        <button type="submit"
                                                            class="btn btn-primary swalDefaultSuccess">Submit</button>
                                                    </div>
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
                        let imageUrl = value.image ? "<?php echo e(asset('')); ?>" + value.image.replace(/\\/g,
                            "/") : "<?php echo e(asset('images/no-image.png')); ?>";
                        let listItem = `
                    <li class="dropdown-item d-flex align-items-center border-bottom py-2"
                        style="cursor:pointer;"
                        data-name="${(value.item_name + ' ' + value.product_code).toUpperCase()}"
                        onclick="selectedItem(${value.id}, ${no}, ${value.quantity}, '${value.item_name}', '${value.product_code}', '${imageUrl}', '${value.batch_id}')">

                        <img src="${imageUrl}" style="width:40px;height:40px;object-fit:cover;border-radius:5px;margin-right:10px;">
                        <div>
                            <strong>${value.item_name}| ${value.product_code}</strong><br>
                            <small class="text-muted"> batch: ${value.batch_number} | Stock: ${value.quantity}</small>
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

            // Use proper quotes for src
            $("#item_image_preview_" + no).html(`
        <img src="${imageUrl}"
            style="width:60px;height:60px;border-radius:5px;cursor:pointer;border:1px solid #ccc;"
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