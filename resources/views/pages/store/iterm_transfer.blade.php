@extends('inc.frame')
{{-- <style>
    /* Make dropdown appear above input */
    .dropdown-menu.show-top {
        top: auto !important;
        bottom: 100% !important;
        margin-bottom: 5px !important;
    }
</style> --}}

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 lg">
                                <div class="pl-3"><b> requisitions : {{ 0 }}</b></div>
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
                                @php $no = 0; @endphp
                                @forelse($requisitions as $requisition)
                                    @php $no++; @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $requisition->created_at->toDateString() }}</td>
                                        <td>{{ $requisition->requestFrom->name ?? '-' }}</td>
                                        <td>{{ $requisition->request_by }}</td>
                                        <td>{{ $requisition->requestTo->name ?? '-' }}</td>
                                        <td>{{ $requisition->status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-view-{{ $requisition->id }}">
                                                View
                                            </button>
                                        </td>
                                        <td>
                                            <a href="/transfer-print-{{ $requisition->id }}" target="_blank"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-print"></i> Print
                                            </a>
                                            @if ($requisition->status != 'Approved')
                                                <a href="/delete-requisition-{{ $requisition->id }}"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No requisitions found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modals placed **outside of table** -->
            @foreach ($requisitions as $requisition)
                <div class="modal fade" id="modal-view-{{ $requisition->id }}">
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
                                                @if ($permission->manage_partNumber == 'on')
                                                    <th>PartNumber1</th>
                                                @endif
                                                @if ($permission->manage_partNumber == 'on')
                                                    <th>PartNumber2</th>
                                                @endif
                                                @if ($permission->manage_image == 'on')
                                                    <th>Image1</th>
                                                @endif
                                                @if ($permission->manage_image == 'on')
                                                    <th>Image2</th>
                                                @endif
                                                <th>Unit</th>
                                                <th>Category</th>
                                                <th>Shelf</th>
                                                <th>Batch</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($requisitionDetails->where('requisition_id', $requisition->id) as $detail)
                                                <tr>
                                                    <td>{{ $detail->item->item_name }}</td>
                                                    @if ($permission->manage_partNumber == 'on')
                                                        <td>{{ $detail->item->product_code }}</td>
                                                    @endif
                                                    @if ($permission->manage_partNumber == 'on')
                                                        <td>{{ $detail->item->part_number }}</td>
                                                    @endif
                                                    @if ($permission->manage_image == 'on')
                                                        <td>
                                                            @php
                                                                $imagePath1 = str_replace(
                                                                    '\\',
                                                                    '/',
                                                                    $detail->item->image,
                                                                );
                                                                $imagePath2 = str_replace(
                                                                    '\\',
                                                                    '/',
                                                                    $detail->item->image2,
                                                                );
                                                            @endphp
                                                            <img src="{{ asset($imagePath1) }}" alt=""
                                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                                data-toggle="modal" data-target="#imageModal"
                                                                onclick="setModalImage('{{ asset($imagePath1) }}')">
                                                        </td>
                                                    @endif
                                                    @if ($permission->manage_image == 'on')
                                                        <td>
                                                            <img src="{{ asset($imagePath2) }}" alt=""
                                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                                data-toggle="modal" data-target="#imageModal"
                                                                onclick="setModalImage('{{ asset($imagePath2) }}')">
                                                        </td>
                                                    @endif
                                                    <td>{{ $detail->item->unit }}</td>
                                                    <td>{{ $detail->item->category }}</td>
                                                    <td>{{ $shelfs->firstWhere('item_id', $detail->item_id)?->shelf->shelf_name ?? '-' }}
                                                    </td>
                                                    <td>{{ $detail->batch->batch_number ?? '-' }}</td>
                                                    <td>{{ number_format($detail->quantity) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No items found</td>
                                                </tr>
                                            @endforelse
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
            @endforeach
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
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h4>
                                                                    <i class="fas fa-globe"></i> inventory, Inc.
                                                                    <small class="float-right">Date :
                                                                        {{ \Carbon\Carbon::now()->toFormattedDateString() }}</small>
                                                                </h4>
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <div class="row invoice-info">
                                                            <div class="col-sm-4 invoice-col">
                                                                <address>
                                                                    {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                                    requisition From
                                                                    <div class="form-group">
                                                                        <select name="request_from" id="request_from"
                                                                            class="form-control" required>
                                                                            <option value="">Select Here</option>
                                                                            @foreach ($locations as $location)
                                                                                <option value="{{ $location->id }}">
                                                                                    {{ $location->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>

                                                                </address>
                                                            </div>
                                                            <div class="col-sm-4 invoice-col">
                                                                <address>
                                                                    {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                                    requisition To
                                                                    <div class="form-group">
                                                                        <select name="request_to" class="form-control"
                                                                            id="location" required>
                                                                            <option value="">Select Here</option>
                                                                            @forelse ($locations as $location)
                                                                                <option value="{{ $location->id }}">
                                                                                    {{ $location->name }}</option>
                                                                            @empty
                                                                                <option value="">Empty Location !
                                                                                </option>
                                                                            @endforelse
                                                                        </select>
                                                                    </div>

                                                                </address>
                                                            </div>

                                                            <div class="col-sm-4 invoice-col">
                                                                <address>
                                                                    {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                                    requisition By
                                                                    <div class="form-group">
                                                                        <input type="text" readonly
                                                                            value="{{ Auth::user()->name }}"
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
                                                                        {{-- <th>CurrntBalance</th> --}}
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
                url: "{{ url('getItemForSale') }}",
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    location_id: locationId
                },
                success: function(result) {
                    $.each(result, function(index, value) {
                        if (selectedItems.includes(String(value.id))) return;
                        let imageUrl = value.image ? "{{ asset('') }}" + value.image.replace(/\\/g,
                            "/") : "{{ asset('images/no-image.png') }}";
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
@endsection
