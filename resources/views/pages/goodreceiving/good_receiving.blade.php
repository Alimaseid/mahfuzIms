@extends('inc.frame')


@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8 lg">
                                    <div class="pl-3"> <small>TotalOrders: </small><b> {{ count($good_receivings) }}</b>
                                    </div>
                                </div>
                                <div class="col-4 lg">
                                    <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                        data-toggle="modal" data-target="#modal-lg">
                                        New Good Receiving
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('good-receivings.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Select Excel File</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <button class="btn btn-primary">Import Goods</button>
                </form>
                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped "
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ReceivingDate</th>
                                    <th>ItemName </th>
                                    @if ($permission->manage_image == 'on')
                                        <th>Image1</th>
                                    @endif
                                    @if ($permission->manage_image == 'on')
                                        <th>Image2</th>
                                    @endif
                                    @if ($permission->manage_partNumber == 'on')
                                        <th>Part Number1</th>
                                    @endif
                                    @if ($permission->manage_partNumber2 == 'on')
                                        <th>Part Number2</th>
                                    @endif
                                    <th>Category</th>
                                    <th>ItemCode</th>
                                    <th>Location</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>CostPrice</th>
                                    <th>SetAction</th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                @if (count($good_receivings) > 0)
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($good_receivings as $receiving)
                                        @php
                                            $no = $no + 1;
                                        @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $receiving->receiving_date }}</td>
                                            @php
                                                $imagePath1 = str_replace('\\', '/', $receiving->item->image);
                                                $imagePath2 = str_replace('\\', '/', $receiving->item->image2);
                                            @endphp
                                            <td>{{ $receiving->item->item_name }}</td>
                                            @if ($permission->manage_image == 'on')
                                                <td style="display: flex; align-items: center; gap: 10px;">
                                                    <img src="{{ asset($imagePath1) }}" alt=""
                                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                        data-toggle="modal" data-target="#imageModal"
                                                        onclick="setModalImage('{{ asset($imagePath1) }}')">
                                                </td>
                                            @endif
                                            @if ($permission->manage_image == 'on')
                                                <td>
                                                    <img src="{{ asset($imagePath2) }}" alt=""
                                                        style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                        data-toggle="modal" data-target="#imageModal"
                                                        onclick="setModalImage('{{ asset($imagePath2) }}')">
                                                </td>
                                            @endif
                                            @if ($permission->manage_partNumber == 'on')
                                                <td>{{ $receiving->item->product_code }}</td>
                                            @endif
                                            @if ($permission->manage_partNumber2 == 'on')
                                                <td>{{ $receiving->item->part_number }}</td>
                                            @endif
                                            <!-- Image Modal (works with Bootstrap 4) -->
                                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img id="modalImage" src="" class="img-fluid rounded">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <td>{{ $receiving->item->category }}</td>
                                            <td>{{ $receiving->item->item_code }}</td>
                                            <td>{{ $receiving->location->name ?? '-' }}</td>
                                            <td>{{ $receiving->quantity }}</td>
                                            <td>{{ $receiving->item->unit }}</td>
                                            <td>{{ $receiving->cost_price }}</td>
                                            <td>
                                                @if ($permission->manage_edit_goodreceiving == 'on')
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal" data-target="#modal-lg-{{ $receiving->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                                @if ($permission->manage_delete_goodreceiving == 'on')
                                                    <a type="button" class="btn btn-danger btn-sm"
                                                        href="delete-good-receiving-{{ $receiving->id }}"
                                                        onclick="return confirm('Are you sure you ?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <!-- 🔹 EDIT GOOD RECEIVING MODAL -->
                                        <div class="modal fade" id="modal-lg-{{ $receiving->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">
                                                            Edit Good Receiving (Invoice: {{ $receiving->invoice_no }})
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="/edit-good-receiving-{{ $receiving->id }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="card-body">
                                                                <!-- 🔸 ITEM SEARCH -->
                                                                <div class="form-group">
                                                                    <label>Item</label>
                                                                    <div class="item-search w-100 mb-2"
                                                                        style="position:relative;">
                                                                        <input type="text" placeholder="Search Item..."
                                                                            id="myInput_{{ $receiving->id }}"
                                                                            onclick="e_myFunction({{ $receiving->id }})"
                                                                            onkeyup="e_filterFunction({{ $receiving->id }})"
                                                                            class="form-control"
                                                                            value="{{ $receiving->item->item_name ?? '' }} ({{ $receiving->item->item_code ?? '' }})"
                                                                            autocomplete="off" required>
                                                                        <input type="hidden" name="item_id"
                                                                            id="item_id_{{ $receiving->id }}"
                                                                            value="{{ $receiving->item_id }}">
                                                                        <div id="myDropdown_{{ $receiving->id }}"
                                                                            class="dropdown-content"
                                                                            style="display:none; position:absolute; z-index:1000; background:#2c2b2b; border:1px solid #ccc; max-height:250px; overflow-y:auto; width:100%;">
                                                                            <div id="item_list_{{ $receiving->id }}">
                                                                                @foreach ($items as $item)
                                                                                    <div class="dropdown-item"
                                                                                        data-id="{{ $item->id }}"
                                                                                        data-code="{{ $item->item_code }}"
                                                                                        data-name="{{ $item->item_name }}"
                                                                                        data-part1="{{ $item->product_code }}"
                                                                                        data-part2="{{ $item->part_number }}"
                                                                                        data-category="{{ $item->category }}"
                                                                                        data-unit="{{ $item->unit }}"
                                                                                        data-brand="{{ $item->brand }}"
                                                                                        data-image="{{ asset(str_replace('\\', '/', $item->image)) }}"
                                                                                        data-image2="{{ asset(str_replace('\\', '/', $item->image2)) }}"
                                                                                        onclick="e_selectItem(this, {{ $receiving->id }})">
                                                                                        {{ $item->item_name }}
                                                                                        ({{ $item->product_code }})
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- 🔸 ITEM DETAILS -->
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <label>Item Code</label>
                                                                        <input type="text"
                                                                            id="item_code_{{ $receiving->id }}"
                                                                            class="form-control"
                                                                            value="{{ $receiving->item->item_code ?? '' }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Part Number 1</label>
                                                                        <input type="text"
                                                                            id="part1_{{ $receiving->id }}"
                                                                            class="form-control"
                                                                            value="{{ $receiving->item->product_code ?? '' }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Part Number 2</label>
                                                                        <input type="text"
                                                                            id="part2_{{ $receiving->id }}"
                                                                            class="form-control"
                                                                            value="{{ $receiving->item->part_number ?? '' }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-2">
                                                                    <div class="col-4">
                                                                        <label>Category</label>
                                                                        <input type="text"
                                                                            id="category_{{ $receiving->id }}"
                                                                            class="form-control"
                                                                            value="{{ $receiving->item->category ?? '' }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Unit</label>
                                                                        <input type="text"
                                                                            id="unit_{{ $receiving->id }}"
                                                                            class="form-control"
                                                                            value="{{ $receiving->item->unit ?? '' }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Brand</label>
                                                                        <input type="text"
                                                                            id="brand_{{ $receiving->id }}"
                                                                            class="form-control"
                                                                            value="{{ $receiving->item->brand ?? '' }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>

                                                                <!-- 🔸 IMAGE PREVIEW -->
                                                                <div class="row mt-2">
                                                                    <div class="col-4">
                                                                        <label>Image 1</label><br>
                                                                        <img id="preview_image1_{{ $receiving->id }}"
                                                                            src="{{ $receiving->item->image ? asset(str_replace('\\', '/', $receiving->item->image)) : '' }}"
                                                                            alt="No Image" class="img-thumbnail"
                                                                            style="max-width: 150px;">
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Image 2</label><br>
                                                                        <img id="preview_image2_{{ $receiving->id }}"
                                                                            src="{{ $receiving->item->image2 ? asset(str_replace('\\', '/', $receiving->item->image2)) : '' }}"
                                                                            alt="No Image" class="img-thumbnail"
                                                                            style="max-width: 150px;">
                                                                    </div>
                                                                </div>

                                                                <!-- 🔸 RECEIVING INFO -->
                                                                <div class="row mt-3">
                                                                    <div class="col-4">
                                                                        <label>Receiving Date</label>
                                                                        <input type="date" name="receiving_date"
                                                                            class="form-control"
                                                                            value="{{ $receiving->receiving_date }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Store Location</label>
                                                                        <select name="location_id" class="form-control"
                                                                            required>
                                                                            @foreach ($businessLocations as $businessLocation)
                                                                                <option
                                                                                    value="{{ $businessLocation->id }}"
                                                                                    {{ $receiving->location_id == $businessLocation->id ? 'selected' : '' }}>
                                                                                    {{ $businessLocation->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Invoice No</label>
                                                                        <input type="text" name="invoice_no"
                                                                            class="form-control"
                                                                            value="{{ $receiving->invoice_no }}" required>
                                                                    </div>
                                                                </div>

                                                                <!-- 🔸 BATCH, PRICE, QUANTITY -->
                                                                <div class="row mt-2">
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Batch</label>
                                                                            <select name="batch_id" class="form-control"
                                                                                id="batch_id_{{ $receiving->id }}"
                                                                                required>
                                                                                <option value="">Select</option>
                                                                                @foreach ($batchs as $batch)
                                                                                    @if ($batch->item_id == $receiving->item_id)
                                                                                        <option
                                                                                            value="{{ $batch->id }}"
                                                                                            {{ $receiving->batch_id == $batch->id ? 'selected' : '' }}>
                                                                                            {{ $batch->batch_number }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Cost Price</label>
                                                                        <input type="number" step="any"
                                                                            name="cost_price" class="form-control"
                                                                            value="{{ $receiving->cost_price }}" required>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <label>Quantity</label>
                                                                        <input type="number" step="any"
                                                                            name="quantity" class="form-control"
                                                                            value="{{ $receiving->quantity }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between mt-3">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary"
                                                                    onclick="return confirm('Are you sure you want to update this record?');">
                                                                    Save Changes
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.modal -->
                                    @endforeach
                                @else
                                    <h2>No GoodReceiving Found !</h2>
                                @endif
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
                                <h4 class="modal-title">New GoodReceiving</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">GoodReceiving <small>Information</small></h3>
                                        </div>
                                        <!-- form start -->
                                        <form action="/add-good-receiving" method="POST" id="quickForm"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Item</label>
                                                    <div class="item-search w-100 mb-2" style="position:relative">
                                                        <input type="text" placeholder="Search Item..." id="myInput_0"
                                                            onclick="myFunction(0)" onkeyup="filterFunction(0)"
                                                            class="form-control" autocomplete="off" required
                                                            name="item_id">
                                                        <div id="myDropdown_0" class="dropdown-content"
                                                            style="display:none; position:absolute; z-index:1000; background:#312f2f; border:1px solid #ccc; max-height:250px; overflow-y:auto; width:100%;">
                                                            <div id="item_list_0">
                                                                @foreach ($items as $item)
                                                                    <div class="dropdown-item"
                                                                        data-id="{{ $item->id }}"
                                                                        data-code="{{ $item->item_code }}"
                                                                        data-name="{{ $item->item_name }}"
                                                                        data-part1="{{ $item->product_code }}"
                                                                        data-part2="{{ $item->part_number }}"
                                                                        data-category="{{ $item->category }}"
                                                                        data-unit="{{ $item->unit }}"
                                                                        data-batch="{{ $item->bar_code }}"
                                                                        data-brand="{{ $item->brand }}"
                                                                        data-image="{{ asset(str_replace('\\', '/', $item->image)) }}"
                                                                        data-image2="{{ asset(str_replace('\\', '/', $item->image2)) }}"
                                                                        onclick="selectItem(this, 0)">
                                                                        {{ $item->item_name }} ({{ $item->product_code }})
                                                                    </div>
                                                                @endforeach
                                                                <!-- Hidden field to store real item_id -->
                                                                <input type="hidden" id="item_id" name="item_id">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="request_token" value="{{ Str::uuid() }}">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label>Item Code</label>
                                                        <input type="text" id="item_code" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Part Number 1</label>
                                                        <input type="text" id="part1" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Part Number 2</label>
                                                        <input type="text" id="part2" class="form-control"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label>Category</label>
                                                        <input type="text" id="category" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Unit</label>
                                                        <input type="text" id="unit" class="form-control"
                                                            readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Brand</label>
                                                        <input type="text" id="brand" class="form-control"
                                                            readonly>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-4">
                                                        <label>Image 1</label><br>
                                                        <img id="preview_image1" src="" alt="No Image"
                                                            class="img-thumbnail" style="max-width: 150px;">
                                                    </div>
                                                    <div class="col-4">
                                                        <label>Image 2</label><br>
                                                        <img id="preview_image2" src="" alt="No Image"
                                                            class="img-thumbnail" style="max-width: 150px;">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Receiving Date</label>
                                                            <input type="date" name="receiving_date"
                                                                class="form-control" value="{{ now()->format('Y-m-d') }}"
                                                                placeholder="date">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label> Store Location</label>
                                                            <select name="location_id" class="form-control" required>
                                                                <option value="">Select</option>
                                                                @forelse ($businessLocations as $businessLocation)
                                                                    <option value="{{ $businessLocation->id }}">
                                                                        {{ $businessLocation->name }}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Invoice No</label>
                                                            <input type="text" name="invoice_no" class="form-control"
                                                                value="{{ 'I-No-' . random_int(0000001, 9999999) }} "
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Batch</label>
                                                            <select name="batch_id" id="batch_id" class="form-control"
                                                                required>
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Cost Price</label>
                                                            <input type="number" step="any" name="cost_price"
                                                                class="form-control" placeholder="Cost Price">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Quantity</label>
                                                            <input type="number" step="any" name="quantity"
                                                                class="form-control" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-primary swalDefaultSuccess">Register</button>
                                                </div>
                                        </form>
                                    </div>
                                    <!-- /.card -->
                                </div><!-- /.container-fluid -->

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
        </div>
    </section>


    <!-- ✅ SCRIPT FOR EDIT MODAL -->
    <script>
        function e_myFunction(no) {
            $('#myDropdown_' + no).show();
        }

        function e_filterFunction(no) {
            const input = $("#myInput_" + no).val().toUpperCase();
            let found = false;
            $("#item_list_" + no + " > div").each(function() {
                const text = $(this).text().toUpperCase();
                const match = text.indexOf(input) > -1;
                $(this).toggle(match);
                if (match) found = true;
            });
            $('#myDropdown_' + no).toggle(found);
        }

        function e_selectItem(element, modalId) {
            const itemId = $(element).data('id');
            $("#myInput_" + modalId).val($(element).data('name') + ' (' + $(element).data('code') + ')');
            $('#myDropdown_' + modalId).hide();

            $("#item_id_" + modalId).val(itemId);
            $("#item_code_" + modalId).val($(element).data('code'));
            $("#part1_" + modalId).val($(element).data('part1'));
            $("#part2_" + modalId).val($(element).data('part2'));
            $("#category_" + modalId).val($(element).data('category'));
            $("#unit_" + modalId).val($(element).data('unit'));
            $("#brand_" + modalId).val($(element).data('brand'));
            $("#preview_image1_" + modalId).attr("src", $(element).data('image'));
            $("#preview_image2_" + modalId).attr("src", $(element).data('image2'));

            e_fetchBatches(itemId, modalId);
        }

        function e_fetchBatches(itemId, modalId) {
            const batchSelect = $("#batch_id_" + modalId);
            batchSelect.empty().append('<option>Loading...</option>');

            $.ajax({
                url: "/get-batches/" + itemId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    batchSelect.empty().append('<option value="">Select Batch</option>');
                    if (response.length > 0) {
                        response.forEach(batch => {
                            batchSelect.append(
                                `<option value="${batch.id}">${batch.batch_number}</option>`);
                        });
                    } else {
                        batchSelect.append('<option value="">No batches found</option>');
                    }
                },
                error: function() {
                    batchSelect.empty().append('<option>Error loading batches</option>');
                }
            });
        }

        // Hide dropdown on outside click
        $(document).on("click", function(e) {
            if (!$(e.target).closest('.item-search').length) {
                $(".dropdown-content").hide();
            }
        });
    </script>

    <script>
        // ------------------- Show dropdown -------------------
        function myFunction(no) {
            $('#myDropdown_' + no).show();
        }

        // ------------------- Filter search -------------------
        function filterFunction(no) {
            let input = $("#myInput_" + no).val().toUpperCase();
            let found = false;

            $("#item_list_" + no + " > div").each(function() {
                let text = $(this).text().toUpperCase();
                let match = text.indexOf(input) > -1;
                $(this).toggle(match);
                if (match) found = true;
            });

            $('#myDropdown_' + no).toggle(found);
        }

        // ------------------- When user selects an item -------------------

        function selectItem(element, no) {
            // Set selected item text
            $("#myInput_" + no).val($(element).data('name') + ' (' + $(element).data('code') + ')');
            $('#myDropdown_' + no).hide();

            // Store real ID
            const itemId = $(element).data('id');
            $("#item_id").val(itemId);

            // Fill details
            $("#item_code").val($(element).data('code'));
            $("#part1").val($(element).data('part1'));
            $("#part2").val($(element).data('part2'));
            $("#category").val($(element).data('category'));
            $("#unit").val($(element).data('unit'));
            $("#brand").val($(element).data('brand'));
            $("#preview_image1").attr("src", $(element).data('image'));
            $("#preview_image2").attr("src", $(element).data('image2'));

            // Now load batches
            fetchBatches(itemId);
        }

        function fetchBatches(itemId) {
            console.log("Fetching batches for item:", itemId);

            // Wait a moment to ensure modal content is loaded
            setTimeout(() => {
                const batchSelect = $("#modal-lg").find("#batch_id"); // target batch inside modal
                batchSelect.empty();
                batchSelect.append('<option value="">Loading...</option>');

                $.ajax({
                    url: "/get-batches/" + itemId,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log("✅ Batches received:", response);

                        batchSelect.empty();
                        batchSelect.append('<option value="">Select Batch</option>');

                        if (response && response.length > 0) {
                            response.forEach(batch => {
                                batchSelect.append(`
                            <option value="${batch.id}">
                                ${batch.batch_number}
                            </option>
                        `);
                            });
                        } else {
                            batchSelect.append('<option value="">No batches available</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("❌ Failed to fetch batches:", error);
                        batchSelect.empty().append('<option value="">Error loading batches</option>');
                    }
                });
            }, 100);
        }



        // Hide dropdown on outside click
        $(document).on("click", function(e) {
            if (!$(e.target).closest('.item-search').length) {
                $(".dropdown-content").hide();
            }
        });
    </script>

    <script>
        function setModalImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>
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
@endsection
