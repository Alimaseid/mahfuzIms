@extends('inc.frame')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header d-flex justify-content-end">

                        </div>
                    </div>
                </div>

                <div class="col-12 card-body">
                    <form method="POST" action="edit-sales-order-{{ $salesOrder->id }}">
                        @csrf
                        <div class="invoice p-3 mb-3">
                            {{-- Order Info --}}
                            <div class="row invoice-info">
                                <div class="col-sm-4">
                                    <label>Business Location</label>
                                    <select id="e_location_{{ $salesOrder->id }}" name="business_location"
                                        class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach ($businessLocations as $loc)
                                            <option value="{{ $loc->id }}"
                                                {{ $salesOrder->location_id == $loc->id ? 'selected' : '' }}>
                                                {{ $loc->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <label class="mt-2">Invoice No</label>
                                    <input type="text" readonly name="refrence_no" class="form-control"
                                        value="{{ $salesOrder->reference_number }}">
                                </div>

                                <div class="col-sm-8">
                                    <label>Sales Type</label>
                                    <select name="sales_type" class="form-control" required>
                                        <option value="Cash Sales"
                                            {{ $salesOrder->sales_type == 'Cash Sales' ? 'selected' : '' }}>Cash Sales
                                        </option>
                                        <option value="Credit Sales"
                                            {{ $salesOrder->sales_type == 'Credit Sales' ? 'selected' : '' }}>Credit Sales
                                        </option>
                                    </select>

                                    <label class="mt-2">Customer</label>
                                    <select name="customer" class="form-control" required>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ $salesOrder->customer_id == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Items Table --}}
                            <div class="row mt-3">
                                <div class="col-12 table-responsive">
                                    <a href="/items" class="text-success mb-2 d-inline-block"><i
                                            class="fa fa-plus-circle"></i> Add New Item</a>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Quantity</th>
                                                <th>U-Price</th>
                                                <th>SubTotal</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="e_add_items_{{ $salesOrder->id }}">
                                            @php $subtotal = $salesOrder->details->sum(fn($d) => $d->quantity * $d->amount); @endphp

                                            @foreach ($salesOrderDetails as $i => $detail)
                                                <tr id="e_row_{{ $salesOrder->id }}_{{ $i }}">
                                                    <td style="width:400px">
                                                        {{-- Category --}}
                                                        <select id="e_category_{{ $salesOrder->id }}_{{ $i }}"
                                                            class="form-control mb-1"
                                                            onchange="e_loadItemsByCategory({{ $salesOrder->id }}, {{ $i }})">
                                                            <option value="">-- Select Category --</option>
                                                            @foreach ($categories as $cat)
                                                                <option value="{{ $cat->name }}"
                                                                    {{ $detail->item->category == $cat->name ? 'selected' : '' }}>
                                                                    {{ $cat->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                        {{-- Item Search --}}
                                                        <div class="dropdown w-100" style="position:relative;">
                                                            <input type="text" class="form-control"
                                                                id="e_myInput_{{ $salesOrder->id }}_{{ $i }}"
                                                                placeholder="Search Product..."
                                                                onclick="e_myFunction({{ $salesOrder->id }}, {{ $i }})"
                                                                onkeyup="e_filterFunction({{ $salesOrder->id }}, {{ $i }})"
                                                                autocomplete="off"
                                                                value="{{ optional($detail->item)->item_name }} | {{ optional($detail->item)->product_code }} | {{ optional($detail->batch)->batch_number ?? '' }}">
                                                            <div id="e_myDropdown_{{ $salesOrder->id }}_{{ $i }}"
                                                                class="dropdown-content w-100"
                                                                style="display:none; position:absolute; max-height:250px; overflow:auto; z-index:2000;">
                                                                <div
                                                                    id="e_item_list_{{ $salesOrder->id }}_{{ $i }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Hidden Fields --}}
                                                        <input type="hidden"
                                                            id="e_item_id_{{ $salesOrder->id }}_{{ $i }}"
                                                            name="addmore[{{ $i }}][item_id]"
                                                            value="{{ $detail->item_id }}">
                                                        <input type="hidden"
                                                            id="e_batch_id_{{ $salesOrder->id }}_{{ $i }}"
                                                            name="addmore[{{ $i }}][batch_id]"
                                                            value="{{ $detail->batch_id }}">
                                                        <input type="hidden"
                                                            id="e_available_qty_{{ $salesOrder->id }}_{{ $i }}"
                                                            value="{{ optional($detail->item)->quantity ?? 0 }}">
                                                    </td>

                                                    <td><input type="number" min="1"
                                                            id="e_qty_{{ $salesOrder->id }}_{{ $i }}"
                                                            name="addmore[{{ $i }}][quantity]"
                                                            class="form-control" value="{{ $detail->quantity }}"
                                                            onchange="e_subTotalCal({{ $salesOrder->id }}, {{ $i }})">
                                                    </td>
                                                    <td><input type="number"
                                                            id="e_u_price_{{ $salesOrder->id }}_{{ $i }}"
                                                            name="addmore[{{ $i }}][u_price]"
                                                            class="form-control" value="{{ $detail->amount }}"
                                                            onchange="e_subTotalCal({{ $salesOrder->id }}, {{ $i }})">
                                                    </td>
                                                    <td><input type="text"
                                                            id="e_sub_{{ $salesOrder->id }}_{{ $i }}"
                                                            class="form-control e_sub"
                                                            value="{{ number_format($detail->quantity * $detail->amount, 2, '.', '') }}"
                                                            readonly></td>
                                                    <td><button type="button" class="btn btn-danger btn-sm"
                                                            onclick="e_removeRow({{ $salesOrder->id }}, {{ $i }})"><i
                                                                class="fa fa-trash"></i></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <a href="#" class="btn btn-success float-right"
                                        onclick="e_addNewRow({{ $salesOrder->id }})">
                                        <i class="fa fa-plus-circle"></i> Add New Item
                                    </a>
                                </div>
                            </div>

                            {{-- Totals --}}
                            <div class="row mt-3">
                                <div class="col-7">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Discount (%)</label>
                                            <input type="number" name="discount"
                                                id="e_discount_percent_{{ $salesOrder->id }}"
                                                value="{{ $subtotal > 0 ? round(($salesOrder->discount / $subtotal) * 100, 2) : 0 }}"
                                                class="form-control" onchange="e_calculater({{ $salesOrder->id }})"
                                                onkeyup="e_calculater({{ $salesOrder->id }})" min="0">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <input type="checkbox" id="e_vat_include_{{ $salesOrder->id }}"
                                                name="vat_include" value="0.15"
                                                {{ $salesOrder->vat > 0 ? 'checked' : '' }}
                                                onchange="e_calculater({{ $salesOrder->id }})">
                                            <label for="e_vat_include_{{ $salesOrder->id }}">VAT (%)</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="checkbox" id="e_with_holding_{{ $salesOrder->id }}"
                                                name="with_holding" value="0.03"
                                                {{ $salesOrder->with_holding > 0 ? 'checked' : '' }}
                                                onchange="e_calculater({{ $salesOrder->id }})">
                                            <label for="e_with_holding_{{ $salesOrder->id }}">Withholding (%)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <p class="lead text-right">Total Due Amount</p>
                                    <table class="table">
                                        <tr>
                                            <th>Subtotal:</th>
                                            <td><i
                                                    id="e_subtotal_{{ $salesOrder->id }}">{{ number_format($subtotal, 2, '.', '') }}</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Discount:</th>
                                            <td><i
                                                    id="e_discount_{{ $salesOrder->id }}">{{ number_format($salesOrder->discount, 2, '.', '') }}</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tax:</th>
                                            <td><i
                                                    id="e_vat_{{ $salesOrder->id }}">{{ number_format($salesOrder->vat, 2, '.', '') }}</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>WithHolding:</th>
                                            <td><i
                                                    id="e_with_holding_val_{{ $salesOrder->id }}">{{ number_format($salesOrder->with_holding, 2, '.', '') }}</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td><i
                                                    id="e_total_{{ $salesOrder->id }}">{{ number_format($salesOrder->grand_total, 2, '.', '') }}</i>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="row no-print mt-2">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success float-right">Update Order</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <!-- Bootstrap 5 Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Item Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Item Image">
                </div>
            </div>
        </div>
    </div>
    <script>
        /* ---------------- GLOBAL ---------------- */
        var e_selectedItems = {}; // track selected IDs per order

        function initEditTracker(orderId) {
            e_selectedItems[orderId] = [];

            // Collect already selected item_ids from loaded rows
            $(`#e_add_items_${orderId} input[id^="e_item_id_${orderId}"]`).each(function() {
                var id = $(this).val();
                if (id && !e_selectedItems[orderId].includes(id)) {
                    e_selectedItems[orderId].push(id);
                }
            });
        }

        /* ---------------- ADD NEW ROW ---------------- */
        function e_addNewRow(orderId) {
            let rowIndex = $(`#e_add_items_${orderId} tr`).length;

            let catOptions = `<option value="">-- Select Category --</option>`;
            @foreach ($categories as $cat)
                catOptions += `<option value="{{ $cat->name }}">{{ $cat->name }}</option>`;
            @endforeach

            let row = `
<tr id="e_row_${orderId}_${rowIndex}">
    <td style="width:350px">
        <select id="e_category_${orderId}_${rowIndex}"
                class="form-control mb-1"
                onchange="e_loadItemsByCategory(${orderId}, ${rowIndex})">
            ${catOptions}
        </select>

        <div class="dropdown w-100" style="position:relative;">
            <input type="text" class="form-control"
                   id="e_myInput_${orderId}_${rowIndex}"
                   placeholder="Search Product..."
                   onclick="e_myFunction(${orderId}, ${rowIndex})"
                   onkeyup="e_filterFunction(${orderId}, ${rowIndex})"
                   autocomplete="off" disabled>
            <div id="e_myDropdown_${orderId}_${rowIndex}"
                 class="dropdown-content w-100"
                 style="display:none; position:absolute; max-height:250px; overflow:auto; z-index:2000;">
                <div id="e_item_list_${orderId}_${rowIndex}"></div>
            </div>
        </div>

        <input type="hidden" id="e_item_id_${orderId}_${rowIndex}"
               name="addmore[${rowIndex}][item_id]">
        <input type="hidden" id="e_batch_id_${orderId}_${rowIndex}"
               name="addmore[${rowIndex}][batch_id]">
        <input type="hidden" id="e_available_qty_${orderId}_${rowIndex}" value="">
    </td>

    <td>
        <input type="number" min="1"
               id="e_qty_${orderId}_${rowIndex}"
               name="addmore[${rowIndex}][quantity]"
               class="form-control"
               onchange="e_subTotalCal(${orderId}, ${rowIndex})">
    </td>

    <td>
        <input type="number"
               id="e_u_price_${orderId}_${rowIndex}"
               name="addmore[${rowIndex}][u_price]"
               class="form-control"
               onchange="e_subTotalCal(${orderId}, ${rowIndex})">
    </td>

    <td>
        <input type="text"
               id="e_sub_${orderId}_${rowIndex}"
               class="form-control e_sub"
               readonly>
    </td>

    <td>
        <button type="button"
                class="btn btn-danger btn-sm"
                onclick="e_removeRow(${orderId}, ${rowIndex})">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>`;

            $(`#e_add_items_${orderId}`).append(row);
        }

        /* ---------------- REMOVE ROW ---------------- */
        function e_removeRow(orderId, idx) {
            let removedId = $(`#e_item_id_${orderId}_${idx}`).val();
            if (removedId) {
                e_selectedItems[orderId] = e_selectedItems[orderId].filter(id => id != removedId);
            }

            $(`#e_row_${orderId}_${idx}`).remove();
            e_calculater(orderId);
        }

        /* ---------------- LOAD ITEMS BY CATEGORY ---------------- */
        function e_loadItemsByCategory(orderId, idx) {
            var location_id = $(`#e_location_${orderId}`).val();
            var category = $(`#e_category_${orderId}_${idx}`).val();

            if (!category) {
                $(`#e_myInput_${orderId}_${idx}`).prop("disabled", true).val("");
                $(`#e_item_list_${orderId}_${idx}`).empty();
                return;
            }

            $(`#e_myInput_${orderId}_${idx}`).prop("disabled", false);

            e_fetchItems(orderId, idx, location_id, category);
        }

        /* ---------------- FETCH ITEMS ---------------- */
        function e_fetchItems(orderId, idx, location_id, category) {

            $.ajax({
                type: "POST",
                url: "{{ url('getItemForSale') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    location_id: location_id,
                    category: category
                },
                success: function(items) {
                    let container = $(`#e_item_list_${orderId}_${idx}`);
                    container.html("");

                    items.forEach(function(item) {

                        // prevent duplicates
                        if (e_selectedItems[orderId].includes(String(item.id))) return;

                        let img = item.image ? item.image : "{{ asset('images/no-image.png') }}";

                        let display =
                            `${item.item_name} | ${item.product_code} | qty:${item.quantity}` +
                            (item.batch_number ? ` | Batch: ${item.batch_number}` : "");

                        let el = $(`
                <div style="padding:8px; cursor:pointer; border-bottom:1px solid #eee; display:flex; justify-content:space-between;">
                    <span>${display}</span>
                    <img src="${img}" width="40" height="40" style="object-fit:cover">
                </div>`);

                        el.on("click", () => e_selectItem(item, orderId, idx));

                        container.append(el);
                    });

                    $(`#e_myDropdown_${orderId}_${idx}`).show();
                }
            });
        }

        /* ---------------- FILTER ---------------- */
        function e_myFunction(orderId, idx) {
            var location = $(`#e_location_${orderId}`).val();
            var category = $(`#e_category_${orderId}_${idx}`).val();
            if (!category) return;
            e_fetchItems(orderId, idx, location, category);
        }

        function e_filterFunction(orderId, idx) {
            var input = $(`#e_myInput_${orderId}_${idx}`).val().toUpperCase();

            let list = $(`#e_item_list_${orderId}_${idx} > div`);
            let found = false;

            list.each(function() {
                let text = $(this).text().toUpperCase();
                let show = text.includes(input);
                $(this).toggle(show);
                if (show) found = true;
            });

            $(`#e_myDropdown_${orderId}_${idx}`).toggle(found);
        }

        /* ---------------- SELECT ITEM ---------------- */
        function e_selectItem(item, orderId, idx) {

            let img = item.image ? item.image : "{{ asset('images/no-image.png') }}";

            $(`#e_myInput_${orderId}_${idx}`).val(
                `${item.item_name} | ${item.product_code}` +
                (item.batch_number ? ` | Batch: ${item.batch_number}` : "")
            );

            $(`#e_item_id_${orderId}_${idx}`).val(item.id);
            $(`#e_batch_id_${orderId}_${idx}`).val(item.batch_id ?? "");
            $(`#e_available_qty_${orderId}_${idx}`).val(item.quantity ?? 0);

            if (!e_selectedItems[orderId].includes(String(item.id))) {
                e_selectedItems[orderId].push(String(item.id));
            }

            let prices = [
                parseFloat(item.selling_price1 || 0),
                parseFloat(item.selling_price2 || 0),
                parseFloat(item.selling_price3 || 0)
            ].filter(p => p > 0);

            if (prices.length > 0) {
                $(`#e_u_price_${orderId}_${idx}`).val(Math.min(...prices).toFixed(2));
            }

            $(`#e_myDropdown_${orderId}_${idx}`).hide();

            e_subTotalCal(orderId, idx);
        }

        /* ---------------- SUBTOTAL ---------------- */
        function e_subTotalCal(orderId, idx) {
            let qty = parseFloat($(`#e_qty_${orderId}_${idx}`).val()) || 1;
            let available = parseFloat($(`#e_available_qty_${orderId}_${idx}`).val()) || 0;
            let price = parseFloat($(`#e_u_price_${orderId}_${idx}`).val()) || 0;

            if (qty > available && available > 0) {
                alert("Qty exceeds stock (" + available + ")");
                qty = available;
                $(`#e_qty_${orderId}_${idx}`).val(available);
            }

            let total = qty * price;
            $(`#e_sub_${orderId}_${idx}`).val(total.toFixed(2));

            e_calculater(orderId);
        }

        /* ---------------- TOTAL CALCULATION ---------------- */
        function e_calculater(orderId) {
            let subtotal = 0;

            $(`#e_add_items_${orderId} .e_sub`).each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });

            let discountPercent = parseFloat($(`#e_discount_percent_${orderId}`).val()) || 0;
            let discount = subtotal * (discountPercent / 100);

            let afterDiscount = subtotal - discount;

            let vatRate = $(`#e_vat_include_${orderId}`).is(":checked") ?
                parseFloat($(`#e_vat_include_${orderId}`).val()) :
                0;

            let vat = afterDiscount * vatRate;

            let whRate = $(`#e_with_holding_${orderId}`).is(":checked") ?
                parseFloat($(`#e_with_holding_${orderId}`).val()) :
                0;

            let wh = afterDiscount * whRate;

            let total = afterDiscount + vat - wh;

            // update UI
            $(`#e_subtotal_${orderId}`).text(subtotal.toFixed(2));
            $(`#e_discount_${orderId}`).text(discount.toFixed(2));
            $(`#e_vat_${orderId}`).text(vat.toFixed(2));
            $(`#e_with_holding_val_${orderId}`).text(wh.toFixed(2));
            $(`#e_total_${orderId}`).text(total.toFixed(2));
        }

        /* Initialize tracker when edit page loads */
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($salesOrders as $so)
                initEditTracker({{ $so->id }});
            @endforeach
        });
    </script>
@endsection
