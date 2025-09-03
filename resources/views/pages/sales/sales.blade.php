@extends('inc.frame')

@section('content')

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
                                    <button type="button" class="btn btn-info pull-rigth btn-sm" style="float: right;"
                                        data-toggle="modal" data-target="#modal-lg">
                                        <b class="pr-3"> New sales</b>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                    <table id="example1" class="table table-bordered table-striped text-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                {{-- <th>Date</th> --}}
                                <th>SalesDate</th>
                                <th>CustomerName</th>
                                {{-- <th>SalesType</th> --}}
                                <th>Payment</th>
                                <th>InvoiceNumber</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>SalesPerson</th>
                                <th>Activity/Action</th>
                            </tr>
                        </thead>
                        <tbody id='list'>
                            @if (count($salesOrders) > 0)
                                @php
                                    $no = 0;
                                @endphp
                                @foreach ($salesOrders as $salesOrder)
                                    @php
                                        $no = $no + 1;
                                    @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        {{-- <td>{{$salesOrder->created_at->month.'/'.$salesOrder->created_at->day }} - <small class="text-info">{{$salesOrder->created_at->hour.':'.$salesOrder->created_at->minute}}</small> </td> --}}
                                        <td>{{ $salesOrder->created_at->toDateString() }}</td>
                                        <td>
                                            @forelse ($customers as $customer)
                                                @if ($customer->id == $salesOrder->customer_id)
                                                    {{ $customer->name }}
                                                @endif
                                            @empty
                                            @endforelse
                                        </td>

                                        {{-- <td>{{$salesOrder->sales_type}}</td> --}}

                                        <div class="modal fade" id="modal-lg-view-{{ $salesOrder->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{ $salesOrder->reference_number }}</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                Item
                                                            </div>
                                                            <div class="col-3">
                                                                Quantity
                                                            </div>
                                                            <div class="col-3">
                                                                Price <small>Vat</small>
                                                            </div>
                                                            <div class="col-3">
                                                                Total
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @php
                                                            $total = 0;
                                                        @endphp
                                                        @forelse ($salesOrderDetails as $salesOrderDetail)
                                                            @if ($salesOrderDetail->sales_order_id == $salesOrder->id)
                                                                @php
                                                                    $total = $total + $salesOrderDetail->total;
                                                                @endphp
                                                                {{-- @php
                                                                    $imagePath = str_replace('\\', '/', $item->image); // Fix backslashes
                                                                @endphp --}}
                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <a
                                                                            href=""><b>{{ $salesOrderDetail->item_name }}</b></a>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        {{ number_format($salesOrderDetail->quantity) }}
                                                                    </div>
                                                                    <div class="col-3">
                                                                        {{ number_format($salesOrderDetail->amount, 2) }}
                                                                        ,<small>{{ $salesOrderDetail->tax }}%</small>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <b>{{ number_format($salesOrderDetail->total, 2) }}</b>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                            @endif
                                                        @empty
                                                        @endforelse
                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                        <td><a class="btn" data-toggle="modal"
                                                data-target="#modal-lg-view-{{ $salesOrder->id }}"> <i
                                                    style="color: greenyellow">{{ number_format($total, 2) }}</i></a></td>
                                        <td>{{ $salesOrder->reference_number }}</td>
                                        <td>
                                            @forelse ($businessLocations as $businessLocation)
                                                @if ($businessLocation->id == $salesOrder->location_id)
                                                    {{ $businessLocation->name }}
                                                @endif
                                            @empty
                                            @endforelse
                                        </td>
                                        <td>
                                            @if ($salesOrder->SM_status == 'Pending')
                                                <p class="text-warning">{{ $salesOrder->SM_status }}</p>
                                            @elseif ($salesOrder->SM_status == 'Rejected')
                                                <a class="btn btn-danger btn-xs" href="#" class="text-danger"
                                                    data-toggle="modal"
                                                    data-target="#modal-reject-{{ $salesOrder->id }}">{{ $salesOrder->SM_status }}</a>
                                            @elseif ($salesOrder->SM_status == 'Accepted')
                                                <p class="text-primary">{{ $salesOrder->SM_status }}</p>
                                            @else
                                                <p class="text-success">{{ $salesOrder->SM_status }}</p>
                                            @endif
                                        </td>

                                        <td>{{ $salesOrder->sales_person }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-{{ $salesOrder->id }}">
                                                Details
                                            </button>
                                            @if ($salesOrder->SM_status != 'Accepted' && $salesOrder->SM_status != 'Shipping' && $salesOrder->SM_status != 'Done')
                                                <a type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-{{ $salesOrder->id }}">
                                                    <i class="fas fa-edit "></i>
                                                </a>
                                                {{-- <a type="button" class="btn btn-danger btn-sm" href="delete-sales-order-{{$salesOrder->id}}" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-trash"></i>
                              </a> --}}
                                                <a type="button" class="btn btn-danger btn-sm" href="#"
                                                    onclick="return confirm('Forbidden To Remove Sales Order !!');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @else
                                                <a href="/sales-invoice-{{ $salesOrder->id }}" rel="noopener"
                                                    target="_blank" class="btn btn-warning btn-sm"><i
                                                        class="fas fa-print"></i> Print</a>
                                            @endif
                                            @if ($salesOrder->SM_status == 'Shipping')
                                                <a href="/acceptIssue-{{ $salesOrder->id }}" rel="noopener"
                                                    class="btn btn-primary btn-sm"
                                                    onclick="return confirm('Are you sure you ? Please ReCheck Before Approve !');">
                                                    <i class="fas fa-car"></i> isDeliverd ?
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <!-- /.card -->
                                    <div class="modal fade" id="modal-reject-{{ $salesOrder->id }}">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{ $salesOrder->reference_number }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="">This order rejected due to this
                                                                    reasone</label>
                                                                <textarea name="rejectReasone" readonly class="form-control" id="" placeholder="reasone...">{{ $salesOrder->rejectReasone }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </br>
                                                    <div class="row no-print">
                                                        <div class="col-12">
                                                            <button type="submit" data-toggle="modal"
                                                                data-target="#modal-lg-{{ $salesOrder->id }}"
                                                                class="btn btn-success float-right"> Edit Order</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                @endforeach
                            @else
                                <h2>No salesOrder Found !</h2>
                            @endif
                        </tbody>
                    </table>

                    {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links("pagination::bootstrap-4") }}</div> --}}


                </div>
                <!-- /.card-body -->


                <div class="modal fade" id="modal-lg">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Sales Order</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <form method="POST" action="add-sales-order">
                                                    @csrf
                                                    <!-- Main content -->
                                                    <div class="invoice p-3 mb-3">
                                                        <!-- title row -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h4>
                                                                    <i class="fas fa-globe"></i> Inventory, Inc.
                                                                    <small class="float-right">Date :
                                                                        {{ \Carbon\Carbon::now()->toFormattedDateString() }}</small>
                                                                </h4>
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <!-- info row -->
                                                        <div class="row invoice-info">
                                                            <div class="col-sm-4 invoice-col">
                                                                <address>
                                                                    {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                                    Business Location
                                                                    <select name="business_location" class="form-control"
                                                                        id="location" required>

                                                                        @forelse ($businessLocations as $businessLocation)
                                                                            <option value="{{ $businessLocation->id }}">
                                                                                {{ $businessLocation->name }}</option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                    {{-- <br> --}}
                                                                    Invoice No
                                                                    <input type="text" name="refrence_no"
                                                                        class="form-control"
                                                                        value=" {{ 'IMS-RF-' . random_int(100000, 9999999) }}">
                                                                </address>
                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-sm-1 invoice-col">

                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-sm-7 invoice-col">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        Sales Type
                                                                        <select name="sales_type" id=""
                                                                            class="form-control" required>
                                                                            {{-- <option value="">Select</option> --}}
                                                                            <option value="Cash Sales">Cash Sales</option>
                                                                            <option value="Credit Sales">Credit Sales
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                To &nbsp; &nbsp;

                                                                <a href="/customers" style='color:rgb(98, 255, 0)'>
                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                </a>
                                                                <address>
                                                                    <select name="customer"
                                                                        class="form-control select2bs4" required>
                                                                        <option value="">Select</option>
                                                                        @forelse ($customers as $customer)
                                                                            <option value="{{ $customer->id }}">
                                                                                {{ $customer->name }}</option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                </address>
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <!-- /.row -->
                                                        <!-- Table row -->
                                                        <div class="row">
                                                            <div class="col-12 table-responsive">
                                                                <a href="/items" style="color:rgb(98, 255, 0)">
                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                    ADD New Item
                                                                </a>

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
                                                                            <td style="width: 300px;">
                                                                                <div class="dropdown w-100">
                                                                                    <input type="text"
                                                                                        placeholder="Search Item..."
                                                                                        id="myInput_0"
                                                                                        onclick="myFunction(0)"
                                                                                        onkeyup="filterFunction(0)"
                                                                                        class="form-control"
                                                                                        autocomplete="off" required>
                                                                                    <div id="myDropdown_0"
                                                                                        class="dropdown-content w-100"
                                                                                        style="display:none; position:absolute; z-index:1000; max-height:250px; overflow:auto;">
                                                                                        <div id="item_list_0"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" id="item_id_0"
                                                                                    name="addmore[0][item_id]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" min="1"
                                                                                    id="qty_0"
                                                                                    name="addmore[0][quantity]"
                                                                                    onchange="subTotalCal(0)"
                                                                                    class="form-control"
                                                                                    placeholder="Quantity" required>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="u_price_0"
                                                                                    name="addmore[0][u_price]"
                                                                                    onchange="subTotalCal(0)"
                                                                                    class="form-control"
                                                                                    style="width:120px;" required>
                                                                                {{-- <select id="u_price_0"
                                                                                    name="addmore[0][u_price]"
                                                                                    onchange="subTotalCal(0)"
                                                                                    class="form-control"
                                                                                    style="width:120px;" required>
                                                                                    <option value="">Price</option>
                                                                                </select> --}}
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" id="sub_0"
                                                                                    class="form-control sub"
                                                                                    placeholder="Sub Total" disabled>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button"
                                                                                    class="remove-tr"><b
                                                                                        style="color:red">X</b></button>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>

                                                                    <!-- Image Modal -->
                                                                    <div id="imageModal" class="modal">
                                                                        <span id="closeModal">&times;</span>
                                                                        <div class="modal-content">
                                                                            <img id="modalImage" src="">
                                                                        </div>
                                                                    </div>
                                                                </table>

                                                                <a href="#" id="add_new_items"
                                                                    class="btn btn-success float-right"
                                                                    style="padding:5px; text-decoration:none">
                                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <!-- /.row -->

                                                        <div class="row" id='calculate'>
                                                            <!-- accepted payments column -->
                                                            <div class="col-7">
                                                                <div class="row">
                                                                    <div class="col-sm-6 invoice-col">
                                                                        <address>
                                                                            {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                                            Expected Delivery Date
                                                                            <input type="date"
                                                                                name="expected_delivery_date"
                                                                                class="form-control"
                                                                                value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                                                    </div>
                                                                    <div class="col-sm-3 invoice-col">
                                                                        Vat %
                                                                        <input type="number" min="0"
                                                                            max="15" value="0"
                                                                            id="vat_include" name="vat_include"
                                                                            class="form-control" onchange="valCal()"
                                                                            required>
                                                                        {{-- <br> --}}
                                                                        {{-- Shipment Reference
                                                      <input type="text" name="shipment_reference" class="form-control" > --}}
                                                                    </div>
                                                                    </address>
                                                                </div>
                                                                {{-- <p class="lead">Payment Methods:</p> --}}
                                                                {{-- <img src="../../dist/img/credit/abby.jpg" alt="Abyssina">
                                                                <img src="../../dist/img/credit/cbe.jpg" alt="CBE">
                                                                <img src="../../dist/img/credit/hij.jpg" alt="Hijra">
                                                                <img src="../../dist/img/credit/hbr.jpg" alt="Hibret"> --}}
                                                                <div class="row">
                                                                    <div class="col-8">

                                                                    </div>
                                                                    <div class="col-4">

                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-5">
                                                                <p class="lead" style="float:right;">Total Due Amount
                                                                </p>

                                                                <div class="table-responsive" style="float:right;">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <th style="width:50%">Subtotal : </th>
                                                                            <td><i id="sub"></i> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th id="vatRate">Tax(0%)</th>
                                                                            <td> <i id="vat"></i> </td>
                                                                        </tr>
                                                                        {{-- <tr>
                                                  <th>Shipping:</th>
                                                  <td>$5.80</td>
                                                </tr> --}}
                                                                        <tr>
                                                                            <th>Total:</th>
                                                                            <td> <i id="tot" name='Gtotal'></i>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <!-- /.row -->

                                                        <!-- this row will not appear when printing -->
                                                        <div class="row no-print">
                                                            <div class="col-12">
                                                                <a href="#" rel="noopener" target="_blank"
                                                                    class="btn btn-default"><i class="fas fa-print"></i>
                                                                    Print</a>
                                                                <button type="submit"
                                                                    class="btn btn-success float-right"> Submit
                                                                    Order
                                                                </button>
                                                                {{-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                              <i class="fas fa-download"></i> Generate PDF
                                            </button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.invoice -->
                                                </form>
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </div><!-- /.container-fluid -->
                                </section>

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>


                <div class="modal fade" id="modal-lg-ADD">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Additional Item From Shop Sales Order</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <form method="POST" action="add-sales-order-from-shop">
                                                    @csrf
                                                    <!-- Main content -->
                                                    <div class="invoice p-3 mb-3">
                                                        <!-- title row -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h4>
                                                                    <i class="fas fa-globe"></i> UKAZ, Inc.
                                                                    <small class="float-right">Date :
                                                                        {{ \Carbon\Carbon::now()->toFormattedDateString() }}</small>
                                                                </h4>
                                                            </div>
                                                            <!-- /.col -->
                                                        </div>
                                                        <!-- info row -->
                                                        <div class="row invoice-info">
                                                            <div class="col-sm-5 invoice-col">
                                                                <address>
                                                                    {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                                    Business Location
                                                                    <select name="business_location" class="form-control"
                                                                        id="x_location" required>
                                                                        {{-- <option value="">Select</option> --}}
                                                                        @forelse ($businessLocations as $businessLocation)
                                                                            <option value="{{ $businessLocation->id }}">
                                                                                {{ $businessLocation->name }}</option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                    {{-- <br> --}}

                                                            </div>
                                                            <div class="col-sm-5 invoice-col">
                                                                <address>
                                                                    Invoice No
                                                                    <input type="text" name="refrence_no"
                                                                        class="form-control" required>
                                                                </address>
                                                            </div>
                                                            <div class="col-sm-2 invoice-col">
                                                                Vat %
                                                                <input type="number" min="0" max="15"
                                                                    value="0" id="x_vat_include"
                                                                    name="x_vat_include" class="form-control"
                                                                    onchange="valCal()" required>
                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-sm-1 invoice-col">

                                                            </div>

                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->
                                                    <!-- Table row -->
                                                    <div class="row">

                                                        <div class="col-12 table-responsive">
                                                            <a href="/items" style='color:rgb(98, 255, 0)'>
                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                ADD New Item</a>
                                                            <table class="table table-striped">
                                                                <tr>
                                                                    <th>ProductCode</th>
                                                                    <th>Quantity</th>
                                                                    <th>U-Price</th>
                                                                    <th>SubTotal</th>
                                                                    <th></th>
                                                                </tr>
                                                                <tbody id="x_add_items">
                                                                    <tr id="">
                                                                        <td style="width: 250px;">
                                                                            <div class="row">
                                                                                <div class="dropdown">
                                                                                    <div id="x_myDropdown_0"
                                                                                        class="dropdown-content">
                                                                                        <input type="text"
                                                                                            placeholder="Search Item..."
                                                                                            id="x_myInput_0"
                                                                                            onclick="x_myFunction(0)"
                                                                                            onkeyup="x_filterFunction(0)"
                                                                                            name="x_addmore[0][search_item]"
                                                                                            class="form-control"
                                                                                            autoComplete="off" required>
                                                                                        <div id="x_items_0"
                                                                                            style="display: none">
                                                                                            {{-- item lists --}}
                                                                                            <ul class="nav nav-pills nav-sidebar flex-column"
                                                                                                id="x_item_list_0"
                                                                                                data-widget="treeview"
                                                                                                role="menu"
                                                                                                data-accordion="false">

                                                                                            </ul>
                                                                                            {{-- end item list --}}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" id="x_item_id_0"
                                                                                    name="x_addmore[0][item_id]"
                                                                                    value="">
                                                                            </div>

                                                                        </td>
                                                                        <td>
                                                                            <input type="number" min="0"
                                                                                id='x_0'
                                                                                name="x_addmore[0][quantity]"
                                                                                onchange="x_subTotalCal(0)"
                                                                                class="form-control input-group-sm"
                                                                                placeholder="Quantity" required>
                                                                        </td>
                                                                        <td>
                                                                            <select id='x_u_price_0'
                                                                                name="x_addmore[0][u_price]"
                                                                                onchange="x_subTotalCal(0)"
                                                                                class="form-control" style="width:120px;"
                                                                                required>
                                                                                <option value="">Price</option>
                                                                            </select>
                                                                        </td>

                                                                        <td><input type="text" id="x_sub_0"
                                                                                class="form-control x_sub" value=""
                                                                                class="form-control"
                                                                                placeholder="Sub Total" disabled /></td>

                                                                    </tr>

                                                                </tbody>


                                                            </table>
                                                            <a href="#" id="x_add_new_items"
                                                                class="btn btn-success float-right"
                                                                style="padding:5px; text-decoration:none">

                                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                            </a>

                                                        </div>
                                                        <hr><br>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->


                                                    <!-- /.row -->
                                                    <hr>
                                                    <!-- this row will not appear when printing -->
                                                    <div class="row no-print">
                                                        <div class="col-12">
                                                            <a href="#" rel="noopener" target="_blank"
                                                                class="btn btn-default"><i class="fas fa-print"></i>
                                                                Print</a>
                                                            <button type="submit" class="btn btn-success float-right">
                                                                Submit
                                                                Order
                                                            </button>
                                                            {{-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                              <i class="fas fa-download"></i> Generate PDF
                                            </button> --}}
                                                        </div>
                                                    </div>
                                            </div>
                                            <!-- /.invoice -->
                                            </form>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                            </div><!-- /.container-fluid -->
    </section>

    </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>





    @forelse ($salesOrders as $salesOrder)
        <div class="modal fade" id="modal-lg-{{ $salesOrder->id }}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Order - {{ $salesOrder->reference_number }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        <form method="POST" action="edit-sales-order-{{ $salesOrder->id }}">
                                            @csrf
                                            <div class="invoice p-3 mb-3">

                                                <!-- ================= Order Info ================= -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4>
                                                            <i class="fas fa-globe"></i> Inventory, Inc.
                                                            <small class="float-right">Date:
                                                                {{ \Carbon\Carbon::now()->toFormattedDateString() }}</small>
                                                        </h4>
                                                    </div>
                                                </div>

                                                <div class="row invoice-info">
                                                    <div class="col-sm-4 invoice-col">
                                                        <address>
                                                            Business Location
                                                            <select name="business_location" class="form-control"
                                                                required>
                                                                @foreach ($businessLocations as $businessLocation)
                                                                    <option value="{{ $businessLocation->id }}"
                                                                        {{ $salesOrder->business_location_id == $businessLocation->id ? 'selected' : '' }}>
                                                                        {{ $businessLocation->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            Invoice No
                                                            <input type="text" readonly name="refrence_no"
                                                                class="form-control"
                                                                value="{{ $salesOrder->reference_number }}">
                                                        </address>
                                                    </div>

                                                    <div class="col-sm-7 invoice-col">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                Sales Type
                                                                <select name="sales_type" class="form-control" required>
                                                                    <option value="{{ $salesOrder->sales_type }}">
                                                                        {{ $salesOrder->sales_type }}
                                                                    </option>
                                                                    <option value="Cash Sales">Cash Sales</option>
                                                                    <option value="Credit Sales">Credit Sales</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        To &nbsp;
                                                        <a href="/customers" style="color:rgb(98, 255, 0)">
                                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                        </a>
                                                        <address>
                                                            <select name="customer" class="form-control" required>
                                                                @foreach ($customers as $customer)
                                                                    <option value="{{ $customer->id }}"
                                                                        {{ $salesOrder->customer_id == $customer->id ? 'selected' : '' }}>
                                                                        {{ $customer->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </address>
                                                    </div>
                                                </div>

                                                <!-- ================= Items Table ================= -->
                                                <div class="row">
                                                    <div class="col-12 table-responsive">
                                                        <a href="/items" style='color:rgb(98, 255, 0)'>
                                                            <i class="fa fa-plus-circle"></i> ADD New Item
                                                        </a>
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
                                                                @php
                                                                    $rowIndex = 0;
                                                                    $vat = 0;
                                                                @endphp
                                                                @foreach ($salesOrderDetails as $salesOrderDetail)
                                                                    @if ($salesOrderDetail->sales_order_id == $salesOrder->id)
                                                                        @php
                                                                            $rowIndex++;
                                                                            $vat = $salesOrderDetail->tax;
                                                                        @endphp
                                                                        <tr
                                                                            id="e_row_{{ $salesOrder->id }}_{{ $rowIndex }}">
                                                                            <td style="width: 300px;">
                                                                                <div class="dropdown w-100">
                                                                                    <input type="text"
                                                                                        placeholder="Search Item..."
                                                                                        id="e_myInput_{{ $salesOrder->id }}_{{ $rowIndex }}"
                                                                                        value="{{ $salesOrderDetail->item_name }}"
                                                                                        onclick="e_myFunction({{ $salesOrder->id }}, {{ $rowIndex }})"
                                                                                        onkeyup="e_filterFunction({{ $salesOrder->id }}, {{ $rowIndex }})"
                                                                                        class="form-control"
                                                                                        autocomplete="off" required>
                                                                                    <div id="e_myDropdown_{{ $salesOrder->id }}_{{ $rowIndex }}"
                                                                                        class="dropdown-content w-100"
                                                                                        style="display:none; position:absolute; z-index:1000; max-height:250px; overflow:auto;">
                                                                                        <div
                                                                                            id="e_item_list_{{ $salesOrder->id }}_{{ $rowIndex }}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden"
                                                                                    id="e_item_id_{{ $salesOrder->id }}_{{ $rowIndex }}"
                                                                                    name="addmore[{{ $rowIndex }}][item_id]"
                                                                                    value="{{ $salesOrderDetail->item_id }}">
                                                                                {{-- Image placeholder --}}
                                                                                <div id="e_item_images_{{ $salesOrder->id }}_{{ $rowIndex }}"
                                                                                    style="display:flex; gap:5px; margin-top:5px;">
                                                                                    @if ($salesOrderDetail->item->image)
                                                                                        <img src="{{ asset($salesOrderDetail->item->image) }}"
                                                                                            style="width:30px;height:30px;border-radius:5px;cursor:pointer;"
                                                                                            onclick="openModal('{{ asset($salesOrderDetail->item->image) }}')">
                                                                                    @endif
                                                                                    @if ($salesOrderDetail->item->image2)
                                                                                        <img src="{{ asset($salesOrderDetail->item->image2) }}"
                                                                                            style="width:30px;height:30px;border-radius:5px;cursor:pointer;"
                                                                                            onclick="openModal('{{ asset($salesOrderDetail->item->image2) }}')">
                                                                                    @endif
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" min="1"
                                                                                    id="e_qty_{{ $salesOrder->id }}_{{ $rowIndex }}"
                                                                                    name="addmore[{{ $rowIndex }}][quantity]"
                                                                                    value="{{ $salesOrderDetail->quantity }}"
                                                                                    class="form-control"
                                                                                    onchange="e_subTotalCal({{ $salesOrder->id }}, {{ $rowIndex }})">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number"
                                                                                    id="e_u_price_{{ $salesOrder->id }}_{{ $rowIndex }}"
                                                                                    name="addmore[{{ $rowIndex }}][u_price]"
                                                                                    value="{{ $salesOrderDetail->item->selling_price1 }}"
                                                                                    class="form-control"
                                                                                    onchange="e_subTotalCal({{ $salesOrder->id }}, {{ $rowIndex }})">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text"
                                                                                    id="e_subTotal_{{ $salesOrder->id }}_{{ $rowIndex }}"
                                                                                    class="form-control e_sub"
                                                                                    value="{{ $salesOrderDetail->total }}"
                                                                                    readonly>
                                                                            </td>
                                                                            <td>
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm"
                                                                                    onclick="e_removeRow({{ $salesOrder->id }}, {{ $rowIndex }})">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>

                                                        </table>
                                                        <a href="#" class="btn btn-success float-right"
                                                            onclick="e_addNewRow({{ $salesOrder->id }})">
                                                            <i class="fa fa-plus-circle"></i> Add New Item
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- ================= Totals ================= -->
                                                <div class="row" id="calculate_{{ $salesOrder->id }}">
                                                    <div class="col-7">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                Expected Delivery Date
                                                                <input type="date" name="expected_delivery_date"
                                                                    class="form-control"
                                                                    value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                Vat %
                                                                <input type="number" min="0" max="15"
                                                                    value="{{ $vat }}"
                                                                    id="e_vat_include_{{ $salesOrder->id }}"
                                                                    name="vat_include" class="form-control"
                                                                    onchange="calculateTotal({{ $salesOrder->id }})">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-5">
                                                        <p class="lead text-right">Total Due Amount</p>
                                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <tr>
                                                                    <th>Subtotal:</th>
                                                                    <td><i id="e_subtotal_{{ $salesOrder->id }}">0</i>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tax:</th>
                                                                    <td><i id="e_vat_{{ $salesOrder->id }}">0</i></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Total:</th>
                                                                    <td><i id="e_total_{{ $salesOrder->id }}">0</i></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- ================= Buttons ================= -->
                                                <div class="row no-print">
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-success float-right">Submit
                                                            Order</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div><!-- /.container-fluid -->
                        </section>
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse


    </div>
    </div>
    </div>
    </section>
    <script>
        function e_subTotalCal(orderId, rowIndex) {
            let qty = parseFloat($(`#e_qty_${orderId}_${rowIndex}`).val()) || 1;
            if (qty < 1) {
                qty = 1;
                $(`#e_qty_${orderId}_${rowIndex}`).val(qty);
            }

            let price = parseFloat($(`#e_u_price_${orderId}_${rowIndex}`).val()) || 0;
            let subtotal = qty * price;
            $(`#e_subTotal_${orderId}_${rowIndex}`).val(subtotal.toFixed(2));

            e_calculater(orderId);
        }

        function e_calculater(orderId) {
            let subtotal = 0;
            $(`#e_add_items_${orderId} .e_sub`).each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });
            let vatRate = parseFloat($(`#e_vat_include_${orderId}`).val()) || 0;
            let vat = subtotal * vatRate / 100;
            let total = subtotal + vat;

            $(`#e_subtotal_${orderId}`).text(subtotal.toFixed(2));
            $(`#e_vat_${orderId}`).text(vat.toFixed(2));
            $(`#e_total_${orderId}`).text(total.toFixed(2));
        }

        // Remove row
        function e_removeRow(orderId, rowIndex) {
            $(`#e_row_${orderId}_${rowIndex}`).remove();
            e_calculater(orderId);
        }

        // Dropdown search
        function e_myFunction(orderId, rowIndex) {
            let location_id = $(`#location`).val();
            if (!location_id) return;

            $.ajax({
                type: "POST",
                url: "{{ url('getItemForSale') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    location_id: location_id
                },
                dataType: 'json',
                success: function(result) {
                    let container = $(`#e_item_list_${orderId}_${rowIndex}`);
                    container.html('');
                    $.each(result, function(_, item) {
                        let option = $(
                            `<div style="padding:5px; cursor:pointer; border-bottom:1px solid #eee;">${item.item_name} | ${item.product_code}</div>`
                        );
                        option.on('click', function() {
                            e_selectedItem(item, orderId, rowIndex);
                        });
                        container.append(option);
                    });
                    $(`#e_myDropdown_${orderId}_${rowIndex}`).show();
                }
            });
        }

        function e_filterFunction(orderId, rowIndex) {
            let filter = $(`#e_myInput_${orderId}_${rowIndex}`).val().toUpperCase();
            $(`#e_item_list_${orderId}_${rowIndex} > div`).each(function() {
                $(this).toggle($(this).text().toUpperCase().includes(filter));
            });
            $(`#e_myDropdown_${orderId}_${rowIndex}`).show();
        }

        function e_selectedItem(item, orderId, rowIndex) {
            $(`#e_myInput_${orderId}_${rowIndex}`).val(item.item_name + " | " + item.product_code);
            $(`#e_item_id_${orderId}_${rowIndex}`).val(item.id);

            let prices = [item.selling_price1, item.selling_price2, item.selling_price3].map(p => parseFloat(p || 0));
            let minPrice = Math.min(...prices.filter(p => p > 0));
            if (minPrice) $(`#e_u_price_${orderId}_${rowIndex}`).val(minPrice);

            // Remove old images
            $(`#e_item_images_${orderId}_${rowIndex}`).remove();

            // Display images
            let imgHtml = `<div id="e_item_images_${orderId}_${rowIndex}" style="display:flex; gap:5px; margin-top:5px;">`;
            if (item.image) imgHtml +=
                `<img src="/${item.image}" style="width:30px;height:30px;border-radius:5px;cursor:pointer;" onclick="openModal('/${item.image}')">`;
            if (item.image2) imgHtml +=
                `<img src="/${item.image2}" style="width:30px;height:30px;border-radius:5px;cursor:pointer;" onclick="openModal('/${item.image2}')">`;
            imgHtml += '</div>';
            $(`#e_myInput_${orderId}_${rowIndex}`).after(imgHtml);

            $(`#e_myDropdown_${orderId}_${rowIndex}`).hide();
            e_subTotalCal(orderId, rowIndex);
        }

        // Image modal function
        function openModal(src) {
            $('#modalImage').attr('src', src);
            $('#imageModal').fadeIn();
        }

        $('#closeModal').click(function() {
            $('#imageModal').fadeOut();
        });
        $('#imageModal').click(function(e) {
            if (e.target.id === 'imageModal') $(this).fadeOut();
        });


        // Add new row
        function e_addNewRow(orderId) {
            let rowCount = $(`#e_add_items_${orderId} tr`).length;
            let i = rowCount + 1;
            $(`#e_add_items_${orderId}`).append(`
        <tr id="e_row_${orderId}_${i}">
            <td style="width:300px;">
                <div class="dropdown w-100">
                    <input type="text" placeholder="Search Item..." id="e_myInput_${orderId}_${i}" onclick="e_myFunction(${orderId}, ${i})" onkeyup="e_filterFunction(${orderId}, ${i})" name="addmore[${i}][search_item]" class="form-control" autocomplete="off" required>
                    <div id="e_myDropdown_${orderId}_${i}" class="dropdown-content w-100" style="display:none; position:absolute; z-index:1000; max-height:250px; overflow:auto;">
                        <div id="e_item_list_${orderId}_${i}"></div>
                    </div>
                </div>
                <input type="hidden" id="e_item_id_${orderId}_${i}" name="addmore[${i}][item_id]" value="">
            </td>
            <td><input type="number" min="1" id="e_qty_${orderId}_${i}" name="addmore[${i}][quantity]" onchange="e_subTotalCal(${orderId}, ${i})" class="form-control" value="1"></td>
            <td><input type="number" id="e_u_price_${orderId}_${i}" name="addmore[${i}][u_price]" onchange="e_subTotalCal(${orderId}, ${i})" class="form-control" value="0"></td>
            <td><input type="text" id="e_subTotal_${orderId}_${i}" class="form-control e_sub" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="e_removeRow(${orderId}, ${i})"><i class="fa fa-trash"></i></button></td>
        </tr>
    `);
        }

        // Initialize totals on page load
        @foreach ($salesOrders as $salesOrder)
            $(document).ready(function() {
                e_calculater({{ $salesOrder->id }});
                $(`#e_add_items_{{ $salesOrder->id }} [id^="e_qty_{{ $salesOrder->id }}_"], #e_add_items_{{ $salesOrder->id }} [id^="e_u_price_{{ $salesOrder->id }}_"]`)
                    .on('change keyup', function() {
                        e_calculater({{ $salesOrder->id }});
                    });
                $(`#e_vat_include_{{ $salesOrder->id }}`).on('change keyup', function() {
                    e_calculater({{ $salesOrder->id }});
                });
            });
        @endforeach
    </script>



    <script>
        var i = 0;

        // Add new row
        $("#add_new_items").click(function() {
            ++i;
            $("#add_items").append(`
     <tr id="row_${i}">
        <td style="width: 300px;">
            <div class="dropdown w-100">
                <input type="text" placeholder="Search Item..." id="myInput_${i}"
                       onclick="myFunction(${i})" onkeyup="filterFunction(${i})"
                       name="addmore[${i}][search_item]" class="form-control" autocomplete="off" required>
                <div id="myDropdown_${i}" class="dropdown-content w-100" style="display:none; position:absolute; z-index:1000; max-height:250px; overflow:auto;">
                    <div id="item_list_${i}"></div>
                </div>
            </div>
            <input type="hidden" id="item_id_${i}" name="addmore[${i}][item_id]" value="">
        </td>
        <td>
            <input type="number" min="1" id="qty_${i}" name="addmore[${i}][quantity]" onchange="subTotalCal(${i})" class="form-control" placeholder="Quantity" required>
        </td>
        <td>
            <input type="number" id="u_price_${i}" name="addmore[${i}][u_price]" onchange="subTotalCal(${i})" class="form-control" style="width:120px;" required>
        </td>
        <td>
            <input type="text" id="sub_${i}" class="form-control sub" placeholder="Sub Total" disabled>
        </td>
        <td>
            <button type="button" class="remove-tr"><b style="color:red">X</b></button>
        </td>
    </tr>
    `);
        });

        // Remove row
        $(document).on('click', '.remove-tr', function() {
            $(this).closest('tr').remove();
            calculateTotal();
        });

        // Fetch items for dropdown
        function myFunction(no) {
            var location_id = document.getElementById("location") ? document.getElementById("location").value : '';
            if (location_id === '') return;

            $.ajax({
                type: "POST",
                url: "{{ url('getItemForSale') }}",
                dataType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    location_id: location_id
                },
                success: function(result) {
                    var container = $('#item_list_' + no);
                    container.html('');

                    $.each(result, function(idx, item) {
                        var img1 = item.image ? item.image.replace(/\\/g, '/') : '';
                        var img2 = item.image2 ? item.image2.replace(/\\/g, '/') : '';
                        var option = $(`<div style="display:flex; align-items:center; gap:5px; padding:5px; cursor:pointer; border-bottom:1px solid #eee;">
                        <span>${item.item_name} | ${item.product_code}</span>
                        ${img1 ? `<img src="/${img1}" style="width:30px;height:30px;border-radius:5px;">` : ''}
                        ${img2 ? `<img src="/${img2}" style="width:30px;height:30px;border-radius:5px;">` : ''}
                    </div>`);

                        option.on('click', function() {
                            selectedItem(item, no);
                        });

                        container.append(option);
                    });

                    $('#myDropdown_' + no).show();
                }
            });
        }

        // Filter items in dropdown
        function filterFunction(no) {
            var input = document.getElementById("myInput_" + no);
            var filter = input.value.toUpperCase();
            $("#item_list_" + no + " > div").each(function() {
                var text = $(this).text().toUpperCase();
                $(this).toggle(text.indexOf(filter) > -1);
            });
            $('#myDropdown_' + no).show();
        }

        // Select item from dropdown
        function selectedItem(item, no) {
            var img1 = item.image ? "{{ url('/') }}/" + item.image : '';
            var img2 = item.image2 ? "{{ url('/') }}/" + item.image2 : '';

            $('#myInput_' + no).val(item.item_name + " | " + item.product_code);
            $('#item_id_' + no).val(item.id);

            // Minimum price -> set directly into input field
            var prices = [item.selling_price1, item.selling_price2, item.selling_price3].map(p => parseFloat(p || 0));
            var minPrice = Math.min(...prices.filter(p => p > 0));
            if (minPrice && minPrice > 0) {
                $('#u_price_' + no).val(minPrice);
            }

            // Display images next to input with modal click
            $("#item_images_" + no).remove();
            var imgHtml = '<div id="item_images_' + no + '" style="display:flex; gap:5px; margin-top:5px;">';
            if (img1) imgHtml +=
                `<img src="${img1}" style="width:30px;height:30px;border-radius:5px;cursor:pointer;" onclick="openModal('${img1}')">`;
            if (img2) imgHtml +=
                `<img src="${img2}" style="width:30px;height:30px;border-radius:5px;cursor:pointer;" onclick="openModal('${img2}')">`;
            imgHtml += '</div>';
            $('#myInput_' + no).after(imgHtml);

            $('#myDropdown_' + no).hide();
            subTotalCal(no);
        }

        // Subtotal and total calculation
        function subTotalCal(i) {
            var qty = parseInt($('#qty_' + i).val()) || 1;
            if (qty < 1) {
                $('#qty_' + i).val(1);
                qty = 1;
            }

            var price = parseFloat($('#u_price_' + i).val()) || 0;
            var subtotal = qty * price;
            $('#sub_' + i).val(subtotal.toFixed(2));

            calculateTotal();
        }

        function calculateTotal() {
            var subtotal = 0;
            $('.sub').each(function() {
                subtotal += parseFloat($(this).val()) || 0;
            });

            var vatRate = parseFloat($('#vat_include').val()) || 0;
            var vat = subtotal * vatRate / 100;
            var total = subtotal + vat;

            $('#sub').text(subtotal.toFixed(2));
            $('#vat').text(vat.toFixed(2));
            $('#tot').text(total.toFixed(2));
            $('#vatRate').text(`Tax(${vatRate}%)`);
        }

        // Modal functions
        function openModal(src) {
            $('#modalImage').attr('src', src);
            $('#imageModal').fadeIn();
        }

        $('#closeModal').click(function() {
            $('#imageModal').fadeOut();
        });

        $('#imageModal').click(function(e) {
            if (e.target.id === 'imageModal') $(this).fadeOut();
        });
    </script>

@endsection
