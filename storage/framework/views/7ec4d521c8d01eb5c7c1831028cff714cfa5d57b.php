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

                <div class="card-body">

                    <div class="modal-body">
                        <section class="content">
                            <div class="container-fluid">
                                <form method="POST" action="<?php echo e(url('add-sales-order')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <div class="invoice p-3 mb-3">

                                        <!-- Title row -->
                                        <div class="row">
                                            <div class="col-12">
                                                <h4>
                                                    <i class="fas fa-globe"></i> Inventory, Inc.
                                                    <small class="float-right">Date:
                                                        <?php echo e(\Carbon\Carbon::now()->toFormattedDateString()); ?></small>
                                                </h4>
                                            </div>
                                        </div>
                                        <input type="hidden" name="request_token" value="<?php echo e(Str::uuid()); ?>">
                                        <!-- Info row -->
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
                                                <address>
                                                    Business Location
                                                    <select name="business_location" class="form-control" id="location"
                                                        required>
                                                        <option value="">Select</option>
                                                        <?php $__currentLoopData = $businessLocations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessLocation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($businessLocation->id); ?>">
                                                                <?php echo e($businessLocation->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>

                                                    Invoice No
                                                    <input type="text" name="refrence_no" class="form-control"
                                                        value="<?php echo e('IMS-RF-' . random_int(100000, 9999999)); ?>">
                                                </address>
                                            </div>

                                            <div class="col-sm-1"></div>

                                            <div class="col-sm-7 invoice-col">
                                                <div class="form-group">
                                                    Sales Type
                                                    <select name="sales_type" class="form-control" required>
                                                        <option value="Cash Sales">Cash Sales</option>
                                                        <option value="Credit Sales">Credit Sales</option>
                                                    </select>
                                                </div>

                                                To
                                                <select name="customer" class="form-control select2bs4" required>
                                                    <option value="">Select</option>
                                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($customer->id); ?>">
                                                            <?php echo e($customer->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Items table -->
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Product / Item</th>
                                                            <th>Quantity</th>
                                                            <th>U-Price</th>
                                                            <th>SubTotal</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="add_items">
                                                        <tr id="row_0">
                                                            <td style="width: 400px;">
                                                                <!-- Category Dropdown -->
                                                                <select id="category_0" class="form-control mb-2"
                                                                    onchange="loadItemsByCategory(0)">
                                                                    <option value="">-- Select Category --
                                                                    </option>
                                                                    <?php $__currentLoopData = \App\Models\Item::select('category')->distinct()->pluck('category'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($cat); ?>">
                                                                            <?php echo e($cat); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>

                                                                <!-- Item Search -->
                                                                <div class="item-search w-100 mb-2"
                                                                    style="position:relative">
                                                                    <input type="text" placeholder="Search Item..."
                                                                        id="myInput_0" onclick="myFunction(0)"
                                                                        onkeyup="filterFunction(0)" class="form-control"
                                                                        autocomplete="off" disabled required>
                                                                    <div id="myDropdown_0" class="dropdown-content">
                                                                        <div id="item_list_0"></div>
                                                                    </div>
                                                                </div>

                                                                <input type="hidden" id="item_id_0"
                                                                    name="addmore[0][item_id]" value="">
                                                                <input type="hidden" id="batch_id_0"
                                                                    name="addmore[0][batch_id]" value="">
                                                                <input type="hidden" id="selling_price2_0"
                                                                    name="addmore[0][selling_price2]" value="">

                                                            </td>
                                                            <td>
                                                                <input type="number" min="1" id="qty_0"
                                                                    name="addmore[0][quantity]" onchange="subTotalCal(0)"
                                                                    class="form-control" placeholder="Quantity" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" id="u_price_0"
                                                                    name="addmore[0][u_price]" onchange="subTotalCal(0)"
                                                                    class="form-control" style="width:120px;" required>
                                                            </td>
                                                            <input type="hidden" id="available_qty_0" value="">
                                                            <td>
                                                                <input type="text" id="sub_0"
                                                                    class="form-control sub" placeholder="Sub Total"
                                                                    disabled>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="remove-tr"><b
                                                                        style="color:red">X</b></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <a href="#" id="add_new_items" class="btn btn-success float-right"
                                                    style="padding:5px; text-decoration:none">
                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <!-- Totals -->
                                        <div class="row" id="calculate">
                                            <div class="col-7">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Discount (%)</label>
                                                        <input type="number" id="discount_percent" class="form-control"
                                                            value="0" name="discount" onchange="calculateTotal()"
                                                            min="0"max="100">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <input type="checkbox" id="vat_include" name="vat_include"
                                                            onchange="calculateTotal()" value="0.15">
                                                        <label>VAT (%)</label>

                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-3">
                                                        <input type="checkbox" id="with_holding" name="with_holding"
                                                            onchange="calculateTotal()" value="0.03">
                                                        <label>Withholding(%)</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-5">
                                                <p class="lead" style="float:right;">Total Due Amount</p>
                                                <div class="table-responsive" style="float:right;">
                                                    <table class="table">
                                                        <tr>
                                                            <th style="width:50%">Subtotal :</th>
                                                            <td><i id="sub"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <th id="discountRate">Discount(0%)</th>
                                                            <td><i id="discount"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <th id="vatRate">Tax(0%)</th>
                                                            <td><i id="vat"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <th id="withHoldingRate">WithHolding(0%)</th>
                                                            <td><i id="with_hold"></i></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total:</th>
                                                            <td><i id="tot" name="Gtotal"></i></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit -->
                                        <div class="row no-print">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-success float-right">Submit
                                                    Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>
                    </div>



                </div>
                <!-- /.card-body -->
                <!-- Bootstrap 5 Image Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Item Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="modalImage" src="" class="img-fluid rounded" alt="Item Image">
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('quickForm');
            form.addEventListener('submit', function(e) {
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = "Processing...";
            });
        });
    </script>
    <script>
        var i = 0;
        var selectedItems = []; // ✅ track selected item IDs globally

        // Get categories from PHP safely
        var categories = <?php echo json_encode(\App\Models\Item::select('category')->distinct()->pluck('category'), 15, 512) ?>;

        // ------------------- ADD NEW ROW -------------------
        $("#add_new_items").click(function(e) {
            e.preventDefault();
            ++i;
            var categoryOptions = `<option value="">-- Select Category --</option>`;
            categories.forEach(function(cat) {
                categoryOptions += `<option value="${cat}">${cat}</option>`;
            });

            $("#add_items").append(`
<tr id="row_${i}">
    <td style="width: 350px;">
        <select id="category_${i}" class="form-control mb-2" onchange="loadItemsByCategory(${i})">
            ${categoryOptions}
        </select>
        <div class="dropdown w-100 mb-2" style="position:relative">
            <input type="text" placeholder="Search Item..." id="myInput_${i}"
                   onclick="myFunction(${i})" onkeyup="filterFunction(${i})"
                   class="form-control" autocomplete="off" disabled required>
            <div id="myDropdown_${i}" class="dropdown-content w-100"
                 style="display:none; position:absolute; z-index:1000; max-height:250px; overflow:auto;">
                <div id="item_list_${i}"></div>
            </div>
        </div>
        <input type="hidden" id="item_id_${i}" name="addmore[${i}][item_id]" value="">
        <input type="hidden" id="batch_id_${i}" name="addmore[${i}][batch_id]" value="">
          <input type="hidden" id="selling_price2_${i}" name="addmore[${i}][selling_price2]" value="">
        <div id="selected_image_${i}" class="mt-2"></div>
    </td>
    <td>
        <input type="number" min="1" id="qty_${i}" name="addmore[${i}][quantity]"
               onchange="subTotalCal(${i})" class="form-control" placeholder="Quantity" required>
    </td>
    <td>
        <input type="number" id="u_price_${i}" name="addmore[${i}][u_price]"
               onchange="subTotalCal(${i})" class="form-control" style="width:120px;" required>
    </td>
    <input type="hidden" id="available_qty_${i}" value="">
    <td>
        <input type="text" id="sub_${i}" class="form-control sub" placeholder="Sub Total" disabled>
    </td>
    <td>
        <button type="button" class="remove-tr"><b style="color:red">X</b></button>
    </td>
</tr>
        `);
        });

        // ------------------- REMOVE ROW -------------------
        $(document).on('click', '.remove-tr', function() {
            var row = $(this).closest('tr');
            var removedId = row.find("input[name*='item_id']").val();
            if (removedId) {
                selectedItems = selectedItems.filter(id => id != removedId); // ✅ allow reuse
            }
            row.remove();
            calculateTotal();
        });

        // ------------------- LOAD ITEMS BY CATEGORY -------------------
        function loadItemsByCategory(no) {
            var location_id = $("#location").val();
            var category = $('#category_' + no).val();
            if (!category) {
                $('#myInput_' + no).prop('disabled', true).val('');
                $('#item_list_' + no).empty();
                return;
            }
            $('#myInput_' + no).prop('disabled', false);
            fetchItems(no, location_id, category);
        }

        // ------------------- FETCH ITEMS -------------------
        function fetchItems(no, location_id, category) {
            $.ajax({
                type: "POST",
                url: "<?php echo e(url('getItemForSale')); ?>",
                dataType: 'json',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    location_id: location_id,
                    category: category
                },
                success: function(result) {
                    var container = $('#item_list_' + no);
                    container.html('');

                    $.each(result, function(idx, item) {
                        // ✅ Skip already selected items
                        if (selectedItems.includes(String(item.id))) return;

                        var imageUrl = item.image ? item.image : "<?php echo e(asset('images/no-image.png')); ?>";

                        // ✅ Build clean display text
                        var displayText =
                            `${item.item_name} | ${item.product_code} | qty:${item.quantity}`;
                        if (item.batch_number) displayText += ` | Batch: ${item.batch_number}`;
                        if (item.selling_price2) displayText +=
                            ` |max-p: ${item.selling_price2}`;

                        // ✅ Create clickable option
                        var option = $(`
                    <div style="padding:8px; cursor:pointer; border-bottom:1px solid #eee; display:flex; align-items:center; justify-content:space-between;">
                        <div style="flex:1;">${displayText}</div>
                        <img src="${imageUrl}" width="40" height="40" style="object-fit:cover; margin-left:10px; border:1px solid #ccc; border-radius:4px;">
                    </div>
                `);

                        option.on('click', function() {
                            selectedItem(item, no);
                        });

                        container.append(option);
                    });

                    $('#myDropdown_' + no).show();
                },
                error: function(err) {
                    console.error('Could not fetch items', err);
                }
            });
        }


        function myFunction(no) {
            var location_id = $("#location").val();
            var category = $('#category_' + no).val();
            if (!category) return;
            fetchItems(no, location_id, category);
        }

        function filterFunction(no) {
            var input = $("#myInput_" + no).val().toUpperCase();
            var found = false;

            $("#item_list_" + no + " > div").each(function() {
                var text = $(this).text().toUpperCase();
                var match = text.indexOf(input) > -1;
                $(this).toggle(match);
                if (match) found = true;
            });

            if (found) {
                $('#myDropdown_' + no).show();
            } else {
                $('#myDropdown_' + no).hide();
            }
        }

        // ------------------- SELECT ITEM -------------------
        function selectedItem(item, no) {
            var imageUrl = item.image ? item.image : "<?php echo e(asset('images/no-image.png')); ?>";
            $('#myInput_' + no).val((item.item_name || '') + " | " + (item.product_code || '') +
                (item.batch_number ? " | Batch: " + item.batch_number : ""));
            $('#item_id_' + no).val(item.id);
            $('#batch_id_' + no).val(item.batch_id ?? '');
            $('#selling_price2_' + no).val(item.selling_price2 ?? '');
            $('#available_qty_' + no).val(item.quantity ?? 0);

            $('#selected_image_' + no).html(`
            <img src="${imageUrl}" width="70" height="70" class="img-thumbnail" style="cursor:pointer;" onclick="showImageModal('${imageUrl}')">
        `);

            // ✅ Add to selectedItems
            if (!selectedItems.includes(String(item.id))) {
                selectedItems.push(String(item.id));
            }

            // Set minimum price (selling_price1) if exists
            var prices = [item.selling_price1, item.selling_price2, item.selling_price3]
                .map(p => parseFloat(p || 0)).filter(p => p > 0);
            var minPrice = prices.length ? Math.min(...prices) : 0;
            if (minPrice && minPrice > 0) {
                $('#u_price_' + no).val(minPrice.toFixed(2));
            }

            if ($('#selling_price1_' + no).length === 0) {
                $('#row_' + no).append(
                    `<input type="hidden" id="selling_price1_${no}" value="${item.selling_price1 || 0}">`
                );
            } else {
                $('#selling_price1_' + no).val(item.selling_price1 || 0);
            }

            $('#myDropdown_' + no).hide();
            subTotalCal(no);
        }

        // ------------------- IMAGE MODAL -------------------
        function showImageModal(url) {
            $('#modalImage').attr('src', url);
            $('#imageModal').modal('show');
        }

        // ------------------- CALCULATE SUBTOTAL -------------------
        function subTotalCal(i) {
            var qty = parseInt($('#qty_' + i).val()) || 1;
            var available = parseInt($('#available_qty_' + i).val()) || 0;
            var enteredPrice = parseFloat($('#u_price_' + i).val()) || 0;
            var sellingPrice1 = parseFloat($('#selling_price1_' + i).val()) || 0;

            if (available > 0 && qty > available) {
                alert('Quantity must be ≤ available stock (' + available + ')');
                qty = available;
                $('#qty_' + i).val(qty);
            }

            if (sellingPrice1 > 0 && enteredPrice < sellingPrice1) {
                alert('Unit Price cannot be less than Selling Price 1 (' + sellingPrice1 + ')');
                $('#u_price_' + i).val(sellingPrice1.toFixed(2));
                enteredPrice = sellingPrice1;
            }

            var subtotal = qty * enteredPrice;
            $('#sub_' + i).val(subtotal.toFixed(2));
            calculateTotal();
        }

        // ------------------- CALCULATE TOTAL -------------------
        function calculateTotal() {
            var subtotal = 0;
            $('.sub').each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });

            var discountPercent = parseFloat($('#discount_percent').val()) || 0;
            var discountRate = discountPercent / 100;

            var vatRate = $('#vat_include').is(':checked') ? parseFloat($('#vat_include').val()) || 0 : 0;
            var withHoldingRate = $('#with_holding').is(':checked') ? parseFloat($('#with_holding').val()) || 0 : 0;

            var discount = subtotal * discountRate;
            var afterDiscount = subtotal - discount;

            var vat = afterDiscount * vatRate;
            var withHolding = afterDiscount * withHoldingRate;

            var total = afterDiscount + vat - withHolding;

            $('#sub').text(subtotal.toFixed(2));
            $('#discount').text(discount.toFixed(2));
            $('#vat').text(vat.toFixed(2));
            $('#with_hold').text(withHolding.toFixed(2));
            $('#tot').text(total.toFixed(2));

            $('#discountRate').text(`Discount(${discountPercent}%)`);
            $('#vatRate').text(`Tax(${(vatRate * 100).toFixed(2)}%)`);
            $('#withHoldingRate').text(`WithHolding(${(withHoldingRate * 100).toFixed(2)}%)`);
        }

        // Auto calculate on modal show
        $('#modal-lg').on('shown.bs.modal', function() {
            calculateTotal();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('inc.frame', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/ims_webims/amarImsfinal/resources/views/pages/sales/addsales.blade.php ENDPATH**/ ?>