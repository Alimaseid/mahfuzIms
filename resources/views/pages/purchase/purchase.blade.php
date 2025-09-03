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
                                    <div class="pl-3"> <small>TotalOrders: </small><b> {{ count($purchaseOrders) }}</b>
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

                <div class="card">
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped"
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>GoodReceivingDate</th>
                                    {{-- <th>Vendor</th> --}}
                                    <th>StoreOn</th>
                                    <th>GoodReceivingBy</th>
                                    <th>ReferenceN0</th>
                                    <th>Payment</th>
                                    <th>Type</th>
                                    <th>Detail</th>
                                    <th>__________</th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                @if (count($purchaseOrders) > 0)
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($purchaseOrders as $purchaseOrder)
                                        @php
                                            $no = $no + 1;
                                        @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $purchaseOrder->created_at->toDateString() }}</td>
                                            {{-- <td>
                                @forelse ($vendors as $vendor)
                                    @if ($vendor->id == $purchaseOrder->vender)
                                    {{$vendor->name}}
                                    @endif
                                @empty
                                @endforelse
                            </td> --}}
                                            <td>
                                                @forelse ($businessLocations as $businessLocation)
                                                    @if ($businessLocation->id == $purchaseOrder->business_location)
                                                        {{ $businessLocation->name }}
                                                    @endif
                                                @empty
                                                @endforelse
                                            </td>
                                            <td>
                                                @forelse ($owners as $owner)
                                                    @if ($owner->id == $purchaseOrder->owner)
                                                        {{ $owner->name }}
                                                    @endif
                                                @empty
                                                @endforelse
                                            </td>
                                            <td>{{ $purchaseOrder->reference_number }}</td>

                                            <div class="modal fade" id="modal-lg-view-{{ $purchaseOrder->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{ $purchaseOrder->reference_number }}
                                                            </h4>
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
                                                            @forelse ($purchaseOrderDetails as $purchaseOrderDetail)
                                                                @if ($purchaseOrderDetail->purchase_order_id == $purchaseOrder->id)
                                                                    @php
                                                                        $total = $total + $purchaseOrderDetail->total;
                                                                    @endphp
                                                                    <div class="row">
                                                                        <div class="col-3">
                                                                            <a
                                                                                href=""><b>{{ $purchaseOrderDetail->item_name }}</b></a>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            {{ number_format($purchaseOrderDetail->qunatity) }}
                                                                        </div>
                                                                        <div class="col-3">
                                                                            {{ number_format($purchaseOrderDetail->amount) }}
                                                                            ,<small>{{ $purchaseOrderDetail->tax }}%</small>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <b>{{ number_format($purchaseOrderDetail->total) }}</b>
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
                                            <td>{{ number_format($total) }}</td>
                                            <td>{{ $purchaseOrder->payment_terms }}</td>

                                            <td>
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal"
                                                    data-target="#modal-lg-view-{{ $purchaseOrder->id }}">
                                                    ViewDetails
                                                </button>

                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                                    data-target="#modal-lg-edit{{ $purchaseOrder->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a type="button" class="btn btn-danger btn-xs"
                                                    href="delete-purchase-order-{{ $purchaseOrder->id }}"
                                                    onclick="return confirm('Are you sure you ?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- /.card -->
                                    @endforeach
                                @else
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
                                <h4 class="modal-title">New GoodReceiving </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <section class="content">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <form method="POST" action="add-purchase-order">
                                                    @csrf
                                                    <!-- Main content -->
                                                    <div class="invoice p-3 mb-3">
                                                        <!-- title row -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <h4>
                                                                    <i class="fas fa-globe"></i> , Inc.
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
                                                                    Store Location
                                                                    <select name="business_location" class="form-control"
                                                                        required>
                                                                        <option value="">Select</option>
                                                                        @forelse ($businessLocations as $businessLocation)
                                                                            <option value="{{ $businessLocation->id }}">
                                                                                {{ $businessLocation->name }}</option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                    {{-- <br> --}}
                                                                    Owner
                                                                    <select name="owner" class="form-control" required>
                                                                        <option value="">Select</option>
                                                                        @forelse ($owners as $owner)
                                                                            <option value="{{ $owner->id }}">
                                                                                {{ $owner->name }}</option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                </address>
                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-sm-3 invoice-col">

                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-sm-5 invoice-col">
                                                                Invoice No
                                                                <input type="text" name="refrence_no"
                                                                    class="form-control"
                                                                    value=" {{ 'IMS-RF-' . random_int(100000, 9999999) }}">
                                                                {{-- <br>
                                              <input type="text" name="sales_person" class="form-control" value="User One" required readonly > --}}
                                                                {{-- Vendor
                                                                <address>
                                                                    <select name="vendor" class="form-control" required>
                                                                        <option value="">Select</option>
                                                                        @forelse ($vendors as $vendor)
                                                                            <option value="{{ $vendor->id }}">
                                                                                {{ $vendor->name }}</option>
                                                                        @empty
                                                                        @endforelse
                                                                    </select>
                                                                </address> --}}
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
                                                                    <tbody id="add_items">
                                                                        <tr id="">
                                                                            <td style="width: 250px;">
                                                                                <div class="row">
                                                                                    <div class="dropdown">
                                                                                        <div id="myDropdown_0"
                                                                                            class="dropdown-content">
                                                                                            <input type="text"
                                                                                                autoComplete="off"
                                                                                                placeholder="Search.."
                                                                                                id="myInput_0"
                                                                                                onclick="myFunction(0)"
                                                                                                onkeyup="filterFunction(0)"
                                                                                                name="addmore[0][search_item]"
                                                                                                class="form-control"
                                                                                                required>
                                                                                            <div id="items_0"
                                                                                                style="display: none">
                                                                                                <ul class="nav nav-pills nav-sidebar flex-column"
                                                                                                    data-widget="treeview"
                                                                                                    role="menu"
                                                                                                    data-accordion="false">
                                                                                                    @forelse ($items as $item)
                                                                                                        <option
                                                                                                            class="nav-link"
                                                                                                            id="item_{{ $item->id }}"
                                                                                                            onclick="selectedItem({{ $item->id }},0)">
                                                                                                            {{ $item->item_name }}
                                                                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                                                                            #
                                                                                                            {{ $item->product_code }}
                                                                                                        </option>
                                                                                                    @empty
                                                                                                    @endforelse
                                                                                                    <input type="hidden"
                                                                                                        id="item_id_0"
                                                                                                        name="addmore[0][item_id]">
                                                                                                    <ul class="nav nav-pills nav-sidebar flex-column"
                                                                                                        data-widget="treeview"
                                                                                                        role="menu"
                                                                                                        data-accordion="false">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id='0'
                                                                                    name="addmore[0][quantity]"
                                                                                    onchange="subTotalCal(0)"
                                                                                    class="form-control input-group-sm"
                                                                                    placeholder="Quantity" required>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id='u_price_0'
                                                                                    name="addmore[0][u_price]"
                                                                                    onchange="subTotalCal(0)"
                                                                                    class="form-control input-group-sm"
                                                                                    placeholder="Price" required>
                                                                            </td>

                                                                            <td><input type="text" id="sub_0"
                                                                                    class="form-control sub"
                                                                                    value="" class="form-control"
                                                                                    placeholder="Sub Total" disabled />
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
                                                                                value="{{ \Carbon\Carbon::now()->toDateString() }}"
                                                                                class="form-control">
                                                                    </div>
                                                                    <div class="col-sm-6 invoice-col">
                                                                        {{-- <br> --}}
                                                                        Shipment Reference
                                                                        <input type="text" name="shipment_reference"
                                                                            class="form-control">
                                                                    </div>
                                                                    </address>
                                                                </div>
                                                                {{-- <p class="lead">Payment Methods:</p> --}}
                                                                <img src="../../dist/img/credit/abby.jpg" alt="Abyssina">
                                                                <img src="../../dist/img/credit/cbe.jpg" alt="CBE">
                                                                <img src="../../dist/img/credit/hij.jpg" alt="Hijra">
                                                                <img src="../../dist/img/credit/hbr.jpg" alt="Hibret">
                                                                <div class="row">
                                                                    <div class="col-8">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Payment
                                                                                Term</label>
                                                                            <select name="payment_type" id=""
                                                                                class="form-control" required>
                                                                                <option value="CAD/TT/LC">CAD/TT/LC
                                                                                </option>
                                                                                <option value="Direct Payment">Direct
                                                                                    Payment</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Vat %</label>
                                                                            <input type="number" min="0"
                                                                                value="15" id="vat_include"
                                                                                name="vat_include" class="form-control"
                                                                                onchange="valCal()" required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!-- /.col -->
                                                            <div class="col-5">
                                                                <h4>----</h4>
                                                                <p class="lead"> Amount Due --
                                                                    {{ \Carbon\Carbon::now()->toFormattedDateString() }}
                                                                </p>

                                                                <div class="table-responsive">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <th style="width:50%">Subtotal : </th>
                                                                            <td><i id="sub"></i> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th id="vatRate">Tax(15%)</th>
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


                {{-- Edit Purchase --}}

                @forelse ($purchaseOrders as $purchaseOrder)
                    <div class="modal fade" id="modal-lg-edit{{ $purchaseOrder->id }}">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit GoodReceiving {{ $purchaseOrder->id }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <section class="content">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12">
                                                    <form method="POST"
                                                        action="editPurchaseOrder-{{ $purchaseOrder->id }}">
                                                        @csrf
                                                        <!-- Main content -->
                                                        <div class="invoice p-3 mb-3">
                                                            <!-- title row -->
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h4>
                                                                        <i class="fas fa-globe"></i> Skylink, Inc.
                                                                        <small class="float-right">Good Receiving Date :
                                                                            {{ $purchaseOrder->created_at->toFormattedDateString() }}</small>
                                                                    </h4>
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- info row -->
                                                            <div class="row invoice-info">
                                                                <div class="col-sm-4 invoice-col">
                                                                    <address>
                                                                        {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                                        Store Location
                                                                        <select name="business_location"
                                                                            class="form-control" required>
                                                                            @forelse ($businessLocations as $businessLocation)
                                                                                @if ($purchaseOrder->business_location == $businessLocation->id)
                                                                                    <option
                                                                                        value="{{ $purchaseOrder->business_location }}">
                                                                                        {{ $businessLocation->name }}
                                                                                    </option>
                                                                                @endif
                                                                            @empty
                                                                            @endforelse
                                                                            @forelse ($businessLocations as $businessLocation)
                                                                                <option
                                                                                    value="{{ $businessLocation->id }}">
                                                                                    {{ $businessLocation->name }}</option>
                                                                            @empty
                                                                            @endforelse
                                                                        </select>
                                                                        {{-- <br> --}}
                                                                        Owner
                                                                        <select name="owner" class="form-control"
                                                                            required>
                                                                            @forelse ($owners as $owner)
                                                                                @if ($purchaseOrder->owner == $owner->id)
                                                                                    <option
                                                                                        value="{{ $purchaseOrder->owner }}">
                                                                                        {{ $owner->name }} </option>
                                                                                @endif
                                                                            @empty
                                                                            @endforelse
                                                                            @forelse ($owners as $owner)
                                                                                <option value="{{ $owner->id }}">
                                                                                    {{ $owner->name }}</option>
                                                                            @empty
                                                                            @endforelse
                                                                        </select>
                                                                    </address>
                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-3 invoice-col">

                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-sm-5 invoice-col">
                                                                    Invoice No
                                                                    <input type="text" name="refrence_no"
                                                                        class="form-control" readonly
                                                                        value=" {{ $purchaseOrder->reference_number }}">
                                                                    {{-- <br>
                                              <input type="text" name="sales_person" class="form-control" value="User One" required readonly > --}}
                                                                    {{-- Purchase On
                                                                    <address>
                                                                        <select name="vendor" class="form-control"
                                                                            required>
                                                                            @forelse ($vendors as $vendor)
                                                                                @if ($purchaseOrder->vender == $vendor->id)
                                                                                    <option
                                                                                        value="{{ $purchaseOrder->vender }}">
                                                                                        {{ $vendor->name }} </option>
                                                                                @endif
                                                                            @empty
                                                                            @endforelse
                                                                            @forelse ($vendors as $vendor)
                                                                                <option value="{{ $vendor->id }}">
                                                                                    {{ $vendor->name }}</option>
                                                                            @empty
                                                                            @endforelse
                                                                        </select>
                                                                    </address> --}}
                                                                </div>
                                                                <!-- /.col -->
                                                            </div>
                                                            <!-- /.row -->




                                                            <!-- Table row -->
                                                            <div class="row">

                                                                <div class="col-12 table-responsive">
                                                                    <a href="/items" style='color:rgb(98, 255, 0)'>
                                                                        <i class="fa fa-plus-circle"
                                                                            aria-hidden="true"></i>
                                                                        ADD New Item</a>
                                                                    <table class="table table-striped">
                                                                        <tr>
                                                                            <th>ProductCode</th>
                                                                            <th>Quantity</th>
                                                                            <th>U-Price</th>
                                                                            <th>SubTotal</th>
                                                                            <th></th>
                                                                        </tr>
                                                                        <tbody id="add_items">
                                                                            @php
                                                                                $tax = 0;
                                                                                $no = 0;
                                                                            @endphp
                                                                            @forelse ($purchaseOrderDetails as $purchaseOrderDetail)
                                                                                @if ($purchaseOrderDetail->purchase_order_id == $purchaseOrder->id)
                                                                                    <tr id="">

                                                                                        <td style="width: 250px;">
                                                                                            <div class="row">
                                                                                                <div class="dropdown">
                                                                                                    <div id="myDropdown_0"
                                                                                                        class="dropdown-content">
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            autoComplete="off"
                                                                                                            readonly
                                                                                                            value="{{ $purchaseOrderDetail->item_name }}"
                                                                                                            placeholder="Search.."
                                                                                                            id="myInput_0"
                                                                                                            onclick="myFunction(0)"
                                                                                                            onkeyup="filterFunction(0)"
                                                                                                            name="addmore[{{ $no }}][search_item]"
                                                                                                            class="form-control"
                                                                                                            required>
                                                                                                        <div id="items_0"
                                                                                                            style="display: none">
                                                                                                            <ul class="nav nav-pills nav-sidebar flex-column"
                                                                                                                data-widget="treeview"
                                                                                                                role="menu"
                                                                                                                data-accordion="false">
                                                                                                                @forelse ($items as $item)
                                                                                                                    <option
                                                                                                                        class="nav-link"
                                                                                                                        id="item_{{ $item->id }}"
                                                                                                                        onclick="selectedItem({{ $item->id }},0)">
                                                                                                                        {{ $item->product_code }}
                                                                                                                    </option>
                                                                                                                @empty
                                                                                                                @endforelse
                                                                                                                <input
                                                                                                                    type="hidden"
                                                                                                                    id="item_id_0"
                                                                                                                    value="{{ $purchaseOrderDetail->item_id }}"
                                                                                                                    name="addmore[{{ $no }}][item_id]">
                                                                                                                <ul class="nav nav-pills nav-sidebar flex-column"
                                                                                                                    data-widget="treeview"
                                                                                                                    role="menu"
                                                                                                                    data-accordion="false">

                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="number"
                                                                                                id='0'
                                                                                                name="addmore[{{ $no }}][quantity]"
                                                                                                value="{{ $purchaseOrderDetail->qunatity }}"
                                                                                                class="form-control input-group-sm"
                                                                                                placeholder="Quantity"
                                                                                                required>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="number"
                                                                                                id='u_price_0'
                                                                                                name="addmore[{{ $no }}][u_price]"
                                                                                                value="{{ $purchaseOrderDetail->amount / $purchaseOrderDetail->qunatity }}"
                                                                                                class="form-control input-group-sm"
                                                                                                required>
                                                                                        </td>

                                                                                        <td><input type="text"
                                                                                                id="sub_0"
                                                                                                class="form-control sub"
                                                                                                value="{{ $purchaseOrderDetail->total }}"
                                                                                                class="form-control"
                                                                                                placeholder="Sub Total"
                                                                                                disabled /></td>
                                                                                    </tr>
                                                                                    @php
                                                                                        $tax =
                                                                                            $purchaseOrderDetail->tax;
                                                                                        $no = $no + 1;
                                                                                    @endphp
                                                                                @endif
                                                                            @empty
                                                                            @endforelse

                                                                        </tbody>

                                                                    </table>
                                                                    {{-- <a href="#" id="add_new_items" class="btn btn-success float-right" style="padding:5px; text-decoration:none">

                                              <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                            </a> --}}

                                                                </div>
                                                                <hr><br>
                                                                <!-- /.col -->
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
                                                                                    value="{{ $purchaseOrder->expected_delivery_date }}">
                                                                        </div>
                                                                        <div class="col-sm-6 invoice-col">
                                                                            {{-- <br> --}}
                                                                            Shipment Reference
                                                                            <input type="text"
                                                                                name="shipment_reference"
                                                                                class="form-control"
                                                                                value="{{ $purchaseOrder->shipment_reference }}">
                                                                        </div>
                                                                        </address>
                                                                    </div>
                                                                    {{-- <p class="lead">Payment Methods:</p> --}}
                                                                    <img src="../../dist/img/credit/abby.jpg"
                                                                        alt="Abyssina">
                                                                    <img src="../../dist/img/credit/cbe.jpg"
                                                                        alt="CBE">
                                                                    <img src="../../dist/img/credit/hij.jpg"
                                                                        alt="Hijra">
                                                                    <img src="../../dist/img/credit/hbr.jpg"
                                                                        alt="Hibret">
                                                                    <div class="row">
                                                                        <div class="col-8">
                                                                            <div class="form-group">
                                                                                <label for="exampleInputEmail1">Payment
                                                                                    Term</label>
                                                                                <select name="payment_type" id=""
                                                                                    class="form-control" required>
                                                                                    <option
                                                                                        value="{{ $purchaseOrder->payment_terms }}">
                                                                                        {{ $purchaseOrder->payment_terms }}
                                                                                    </option>
                                                                                    <option value="CAD/TT/LC">CAD/TT/LC
                                                                                    </option>
                                                                                    <option value="Direct Payment">Direct
                                                                                        Payment</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label for="exampleInputEmail1">Vat
                                                                                    %</label>
                                                                                <input type="number" min="0"
                                                                                    value="{{ $tax }}"
                                                                                    id="vat_include" name="vat_include"
                                                                                    class="form-control"
                                                                                    onchange="valCal()" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-5">
                                                                    <h4>----</h4>
                                                                    <p class="lead"> Amount Due --
                                                                        {{ \Carbon\Carbon::now()->toFormattedDateString() }}
                                                                    </p>

                                                                    <div class="table-responsive">
                                                                        <table class="table">
                                                                            <tr>
                                                                                <th style="width:50%">Subtotal : </th>
                                                                                <td><i
                                                                                        id="sub"></i>{{ $purchaseOrder->total_payment - ($purchaseOrder->total_payment * $tax) / 100 }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th id="vatRate">
                                                                                    Tax({{ $tax }}%)</th>
                                                                                <td> <i id="vat"></i>
                                                                                    {{ ($purchaseOrder->total_payment * $tax) / 100 }}
                                                                                </td>
                                                                            </tr>
                                                                            {{-- <tr>
                                                  <th>Shipping:</th>
                                                  <td>$5.80</td>
                                                </tr> --}}
                                                                            <tr>
                                                                                <th>Total:</th>
                                                                                <td> <i id="tot"
                                                                                        name='Gtotal'>{{ $purchaseOrder->total_payment }}</i>
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
                                                                        class="btn btn-default"><i
                                                                            class="fas fa-print"></i> Print</a>
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
                @empty
                @endforelse

            </div>
        </div>
        </div>
    </section>



    <script type="text/javascript">
        var i = 0;
        var subTotal = [];
        $("#add_new_items").click(function() {
            ++i;
            $("#add_items").append(`
        <tr>
             <td style="width: 250px;">
                <div class="row">
                    <div class="dropdown">
                        <div id="myDropdown_` + i + `" class="dropdown-content">
                            <input type="text" autoComplete="off" placeholder="Search.." id="myInput_` + i +
                `" onkeyup="filterFunction(` + i + `)" name="addmore[` + i + `][search_item]"  class="form-control">
                            <div id="items_` + i +
                `" style="display: none">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            @forelse ($items as $item)
                                <option class="nav-link" id="item_{{ $item->id }}" onclick="selectedItem({{ $item->id }},` +
                i + `)">{{ $item->item_name }} | {{ $item->product_code }}</option>
                            @empty
                            @endforelse
                            <input type="hidden" id="item_id_` + i + `" name="addmore[` + i + `][item_id]">
                            <ul class="nav nav-pills nav-sidebar flex-column"  data-widget="treeview" role="menu" data-accordion="false">
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <input type="number" id="` + i + `" name="addmore[` + i + `][quantity]" onchange="subTotalCal(` + i + `)" class="form-control" id="exampleInputEmail1" placeholder="Quantity" required>
            </td>
            <td>
            <input type="number" id="u_price_` + i + `" name="addmore[` + i + `][u_price]" onchange="subTotalCal(` +
                i + `)" class="form-control" placeholder="Price" required >
            </td>

            <td><input type="text" id="sub_` + i + `" class="form-control sub" value="" placeholder="Sub Total"  disabled /></td>
            <td>

            <button type="button" class=" remove-tr"><B style='color:red'> X </B></button>

            </td>
        </tr>
        `);
        });
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });


        $('#add_items').on('mouseover', function() {
            var subTotal = 0;
            var vatRate = document.getElementById("vat_include").value;
            var allSub = document.getElementsByClassName('sub');
            for (j = 0; j < allSub.length; j++) {

                if (document.getElementById("sub_" + j).value != 0) {

                    subTotal = subTotal + Number(document.getElementById("sub_" + j).value);
                    vat = (subTotal) * vatRate / 100;
                    netTotal = subTotal + vat;
                    document.getElementById('vat').innerHTML = vat.toFixed(2);
                    document.getElementById('sub').innerHTML = subTotal.toFixed(2);
                    document.getElementById('tot').innerHTML = netTotal.toFixed(2);
                    document.getElementById('vatRate').innerHTML = "Tax(" + vatRate + ")%";
                }
            }

        });

        function subTotalCal(i) {
            var u_price = $('#u_price_' + i).val();
            var quantity = $('#0').val();
            var data = parseInt(quantity) * parseFloat(u_price);
            document.getElementById('sub_' + i).value = data;
        }


        function valCal() {
            var subTotal = 0;
            var vatRate = document.getElementById("vat_include").value;
            var allSub = document.getElementsByClassName('sub');
            for (j = 0; j < allSub.length; j++) {

                if (document.getElementById("sub_" + j).value != 0) {

                    subTotal = subTotal + Number(document.getElementById("sub_" + j).value);
                    vat = (subTotal) * vatRate / 100;
                    netTotal = subTotal + vat;
                    document.getElementById('vat').innerHTML = vat.toFixed(2);
                    document.getElementById('sub').innerHTML = subTotal.toFixed(2);
                    document.getElementById('tot').innerHTML = netTotal.toFixed(2);
                    document.getElementById('vatRate').innerHTML = "Tax(" + vatRate + ")%";
                }
            }


        }
    </script>

    <script>
        /* When the user clicks on the button,
                toggle between hiding and showing the dropdown content */
        function myFunction(no) {
            document.getElementById("myDropdown_" + no).classList.toggle("show");
        }

        function filterFunction(no) {
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput_" + no);
            document.getElementById("items_" + no).style.display = 'block';

            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown_" + no);
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
    </script>

    <script>
        function selectedItem(id, no) {
            document.getElementById("items_" + no).style.display = 'none';
            document.getElementById("item_id_" + no).value = id;
            document.getElementById("myInput_" + no).value = document.getElementById("item_" + id).value;


        }
    </script>

@endsection
