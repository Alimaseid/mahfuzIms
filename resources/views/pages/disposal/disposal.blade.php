@extends('inc.frame')


@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left">Disposal :<b>
                                        {{ count($disposals) }}</b></div>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New Disposal
                            </button>


                        </div>
                    </div>

                    <div class="card">
                        <div class="row">
                            <div class="col-8 lg">
                                <div class="card-body">
                                    {{-- <div class="p-2" style="float: right"> {{ $locations->links() }}</div> --}}
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Location</th>
                                                <th>Reason</th>
                                                <th>_________</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($disposals) > 0)
                                                @php
                                                    $no = 0;
                                                @endphp
                                                @foreach ($disposals as $disposal)
                                                    @php
                                                        $no = $no + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $disposal->item->item_name }}</td>
                                                        <td>{{ $disposal->quantity }}</td>
                                                        <td>{{ $disposal->location->name ?? '-' }}</td>
                                                        <td>{{ $disposal->reason }}</td>
                                                        <td>
                                                            @if ($permission->manage_edit_disposal == 'on')
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-lg-{{ $disposal->id }}">
                                                                    <i class="fas fa-edit "></i>
                                                                </button>
                                                            @endif
                                                            @if ($permission->manage_delete_disposal == 'on')
                                                                <a type="button" class="btn btn-danger btn-sm"
                                                                    href="delete-disposal-{{ $disposal->id }}"
                                                                    onclick="return confirm('Are you sure you ?');">
                                                                    <i class="fas fa-trash "></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="modal-lg-{{ $disposal->id }}">
                                                        <div class="modal-dialog modal-lg-{{ $disposal->id }}">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Disposal</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
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
                                                                                        <h3 class="card-title">Disposal
                                                                                            <small>Information</small>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <!-- form start -->
                                                                                    <form
                                                                                        action="/edit-disposal-{{ $disposal->id }}"
                                                                                        method="POST" id="quickForm">
                                                                                        @csrf
                                                                                        <div class="card-body">

                                                                                            <div
                                                                                                class="col-sm-12 invoice-col">
                                                                                                <address>
                                                                                                    Business Location
                                                                                                    <select
                                                                                                        name="location_id"
                                                                                                        class="form-control"
                                                                                                        required>
                                                                                                        @foreach ($businessLocations as $businessLocation)
                                                                                                            <option
                                                                                                                value="{{ $businessLocation->id }}"
                                                                                                                {{ $disposal->location_id == $businessLocation->id ? 'selected' : '' }}>
                                                                                                                {{ $businessLocation->name }}
                                                                                                            </option>
                                                                                                        @endforeach
                                                                                                    </select>

                                                                                                </address>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label>Item</label>
                                                                                                <div class="item-search w-100"
                                                                                                    style="position:relative">
                                                                                                    <input type="text"
                                                                                                        id="myInput_edit"
                                                                                                        class="form-control"
                                                                                                        placeholder="Search Item..."
                                                                                                        autocomplete="off"
                                                                                                        onclick="myFunction_edit()"
                                                                                                        onkeyup="filterFunction_edit()"
                                                                                                        required
                                                                                                        value="{{ $disposal->item->item_name }} | {{ $disposal->item->product_code }}">
                                                                                                    <div id="myDropdown_edit"
                                                                                                        class="dropdown-content"
                                                                                                        style="display:none; position:absolute; max-height:250px; background:#353333; border:1px solid #ccc; overflow:auto; z-index:1000;">
                                                                                                        <div
                                                                                                            id="item_list_edit">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <input type="hidden"
                                                                                                    id="item_id_edit"
                                                                                                    name="item_id"
                                                                                                    value="{{ $disposal->item_id }}">
                                                                                                <input type="hidden"
                                                                                                    id="batch_id_edit"
                                                                                                    name="batch_id"
                                                                                                    value="{{ $disposal->batch_id }}">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label>Quantity</label>
                                                                                                <input type="text"
                                                                                                    name="quantity"
                                                                                                    class="form-control"
                                                                                                    value="{{ $disposal->quantity }}"
                                                                                                    required>
                                                                                            </div>


                                                                                            <div class="form-group">
                                                                                                <label>Reason</label>
                                                                                                <input type="text"
                                                                                                    name="reason"
                                                                                                    class="form-control"
                                                                                                    value="{{ $disposal->reason }}">
                                                                                            </div>

                                                                                        </div>

                                                                                        <div
                                                                                            class="modal-footer justify-content-between">
                                                                                            <button type="button"
                                                                                                class="btn btn-default"
                                                                                                data-dismiss="modal">Close</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary swalDefaultSuccess"
                                                                                                onclick="return confirm('Are you sure you want to save changes ?');">Save
                                                                                                Change</button>
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
                                                @endforeach
                                            @else
                                                <h2>No Disposal Found !</h2>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>
                    </div>


                    <!-- /.card -->
                    <div class="modal fade" id="modal-lg">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">New Disposal</h4>
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
                                                        <h3 class="card-title">Disposal <small>Information</small></h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form action="/add-disposal" method="POST" id="quickForm">
                                                        @csrf
                                                        <div class="card-body">


                                                            <div class="col-sm-12 location-col">
                                                                <address>
                                                                    Business Location
                                                                    <select name="location_id" class="form-control"
                                                                        required>
                                                                        @foreach ($businessLocations as $businessLocation)
                                                                            <option value="{{ $businessLocation->id }}">
                                                                                {{ $businessLocation->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </address>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Item</label>
                                                                <!-- Item Search -->
                                                                <input type="hidden" name="request_token"
                                                                    value="{{ Str::uuid() }}">
                                                                <div class="item-search w-100 mb-2"
                                                                    style="position:relative">
                                                                    <input type="text" placeholder="Search Item..."
                                                                        id="myInput_0" onclick="myFunction(0)"
                                                                        onkeyup="filterFunction(0)" class="form-control"
                                                                        autocomplete="off" required>

                                                                    <div id="myDropdown_0" class="dropdown-content"
                                                                        style="display:none; position:absolute; z-index:1000; background:#353333; border:1px solid #ccc; max-height:250px; overflow-y:auto; width:100%;">
                                                                        <div id="item_list_0"></div>
                                                                    </div>
                                                                </div>

                                                                <!-- Hidden fields -->
                                                                <input type="hidden" id="item_id_0" name="item_id"
                                                                    value="">
                                                                <input type="hidden" id="batch_id_0" name="batch_id"
                                                                    value="">

                                                            </div>
                                                            <div class="form-group">
                                                                <label>Quantity</label>
                                                                <input type="number" name="quantity" min="1"
                                                                    class="form-control" placeholder="Quantity" required>
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="">Reason
                                                                    <small>opt</small></label>
                                                                <input type="text" name="reason" class="form-control"
                                                                    id="" placeholder="Reason">
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
                    <!-- /.modal -->

                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
    <script>
        // ========================= FETCH ITEMS =========================
        function fetchItems(no) {

            // selected business location
            let locationId = $('select[name="location_id"]').val();

            $.ajax({
                type: "POST",
                url: "{{ url('getItemForSale') }}",
                dataType: "json",

                data: {
                    _token: "{{ csrf_token() }}",
                    location_id: locationId
                },

                success: function(result) {

                    let container = $('#item_list_' + no);

                    // clear old items
                    container.html('');

                    // no items
                    if (result.length === 0) {

                        container.append(`
                        <div style="
                            padding:10px;
                            text-align:center;
                            color:#999;
                        ">
                            No items found
                        </div>
                    `);

                        $('#myDropdown_' + no).show();
                        return;
                    }

                    // loop items
                    $.each(result, function(idx, item) {

                        let imageUrl = item.image ?
                            item.image :
                            "{{ asset('images/no-image.png') }}";

                        let displayText =
                            item.item_name +
                            " | " +
                            item.product_code;

                        // batch
                        if (item.batch_number) {
                            displayText += " | Batch: " + item.batch_number;
                        }

                        // quantity
                        displayText += " | Qty: " + item.quantity;

                        let option = $(`
                        <div class="item-option"
                            style="
                                padding:8px;
                                cursor:pointer;
                                border-bottom:1px solid #eee;
                                display:flex;
                                align-items:center;
                                justify-content:space-between;
                                background:black;
                                color:white;
                            ">
                            <div style="flex:1;">
                                ${displayText}
                            </div>

                            <img src="${imageUrl}"
                                width="40"
                                height="40"
                                style="
                                    object-fit:cover;
                                    margin-left:10px;
                                    border:1px solid #ccc;
                                    border-radius:4px;
                                ">
                        </div>
                    `);

                        // select item
                        option.on('click', function(e) {

                            e.stopPropagation();

                            selectedItem(item, no);
                        });

                        container.append(option);
                    });

                    // show dropdown
                    $('#myDropdown_' + no).show();
                },

                error: function(err) {

                    console.error('❌ Could not fetch items', err);
                }
            });
        }

        // ========================= OPEN DROPDOWN =========================
        function myFunction(no) {

            fetchItems(no);
        }

        // ========================= FILTER ITEMS =========================
        function filterFunction(no) {

            let input = $("#myInput_" + no)
                .val()
                .toUpperCase();

            let found = false;

            $("#item_list_" + no + " > div").each(function() {

                let text = $(this)
                    .text()
                    .toUpperCase();

                let match = text.indexOf(input) > -1;

                $(this).toggle(match);

                if (match) {
                    found = true;
                }
            });

            if (found) {
                $('#myDropdown_' + no).show();
            } else {
                $('#myDropdown_' + no).hide();
            }
        }

        // ========================= SELECT ITEM =========================
        function selectedItem(item, no) {

            let text =
                item.item_name +
                " | " +
                item.product_code;

            if (item.batch_number) {
                text += " | Batch: " + item.batch_number;
            }

            $("#myInput_" + no).val(text);

            // hidden fields
            $("#item_id_" + no).val(item.id);
            $("#batch_id_" + no).val(item.batch_id);

            // close dropdown
            $('#myDropdown_' + no).hide();
        }

        // ========================= LOCATION CHANGE =========================
        $('select[name="location_id"]').on('change', function() {

            // clear selected item
            $("#myInput_0").val('');
            $("#item_id_0").val('');
            $("#batch_id_0").val('');

            // clear old list
            $("#item_list_0").html('');

            // reload items for location
            fetchItems(0);
        });

        // ========================= CLOSE DROPDOWN =========================
        $(document).on('click', function(e) {

            if (!$(e.target).closest('.item-search').length) {

                $('.dropdown-content').hide();
            }
        });
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


    <script>
        // ------------------- FETCH ITEMS (no filters) -------------------
        function fetchItems_edit() {
            $.ajax({
                type: "POST",
                url: "{{ url('getItemForSale') }}",
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    let container = $('#item_list_edit');
                    container.html('');

                    $.each(result, function(idx, item) {
                        let imageUrl = item.image ? item.image : "{{ asset('images/no-image.png') }}";
                        let displayText = `${item.item_name} | ${item.product_code}` +
                            (item.batch_number ? ` | Batch: ${item.batch_number}` : '');
                        let option = $(`
                        <div style="padding:8px; cursor:pointer; border-bottom:1px solid #eee; display:flex; align-items:center; justify-content:space-between;">
                            <div style="flex:1;">${displayText}</div>
                            <img src="${imageUrl}" width="40" height="40" style="object-fit:cover; margin-left:10px; border:1px solid #ccc; border-radius:4px;">
                        </div>
                    `);

                        option.on('click', function(e) {
                            e.stopPropagation(); // prevent closing before select
                            selectedItem_edit(item);
                        });

                        container.append(option);
                    });

                    $('#myDropdown_edit').show();
                },
                error: function(err) {
                    console.error('❌ Could not fetch items', err);
                }
            });
        }

        // ------------------- SHOW DROPDOWN -------------------
        function myFunction_edit() {
            fetchItems_edit();
        }

        // ------------------- FILTER -------------------
        function filterFunction_edit() {
            let input = $("#myInput_edit").val().toUpperCase();
            let found = false;

            $("#item_list_edit > div").each(function() {
                let text = $(this).text().toUpperCase();
                let match = text.indexOf(input) > -1;
                $(this).toggle(match);
                if (match) found = true;
            });

            if (found) {
                $('#myDropdown_edit').show();
            } else {
                $('#myDropdown_edit').hide();
            }
        }

        // ------------------- SELECT ITEM -------------------
        function selectedItem_edit(item) {
            $("#myInput_edit").val(item.item_name + " | " + item.product_code +
                (item.batch_number ? " | Batch: " + item.batch_number : ""));
            $("#item_id_edit").val(item.id);
            $("#batch_id_edit").val(item.batch_id);

            $('#myDropdown_edit').hide();
        }

        // ------------------- CLOSE DROPDOWN ON OUTSIDE CLICK -------------------
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.item-search').length) {
                $('#myDropdown_edit').hide();
            }
        });
    </script>
@endsection
