@extends('inc.frame')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body text-sm">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SalesDate</th>
                                    <th>InvoiceNo</th>
                                    <th>Customer</th>
                                    <th>SalesPerson</th>
                                    <th>View</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($salesOrders as $salesOrder)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $salesOrder->created_at->toDateString() }}</td>
                                        <td>{{ $salesOrder->reference_number }}</td>
                                        <td>
                                            @foreach ($customers as $c)
                                                @if ($c->id == $salesOrder->customer_id)
                                                    {{ $c->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $salesOrder->sales_person }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-{{ $salesOrder->id }}">
                                                SalesDetails
                                            </button>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                @if ($salesOrder->SM_status == 'Accepted')
                                                    <button type="button"
                                                        class="btn btn-success btn-sm">{{ $salesOrder->SM_status }}</button>
                                                    <button type="button"
                                                        class="btn btn-success dropdown-toggle dropdown-icon"
                                                        data-toggle="dropdown">
                                                    @elseif($salesOrder->SM_status == 'Pending')
                                                        <button type="button"
                                                            class="btn btn-info btn-xs">{{ $salesOrder->SM_status }}</button>
                                                        <button type="button"
                                                            class="btn btn-info dropdown-toggle dropdown-icon"
                                                            data-toggle="dropdown">
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm">{{ $salesOrder->SM_status }}</button>
                                                            <button type="button"
                                                                class="btn btn-danger dropdown-toggle dropdown-icon"
                                                                data-toggle="dropdown">
                                                @endif
                                                <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="acceptOrder-{{ $salesOrder->id }}">
                                                        Accepte</a>
                                                    <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#modal-lg-reject-{{ $salesOrder->id }}">Reject</a>
                                                    {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- ==================== MODALS ==================== -->
                    @foreach ($salesOrders as $salesOrder)
                        <!-- DETAILS MODAL -->
                        <div class="modal fade" id="modal-lg-view-{{ $salesOrder->id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ $salesOrder->reference_number }}</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Part no1</th>
                                                        <th>Part no2</th>
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
                                                    @foreach ($salesOrderDetails as $detail)
                                                        @if ($detail->sales_order_id == $salesOrder->id)
                                                            @php
                                                                $img1 = str_replace('\\', '/', $detail->item->image);
                                                                $img2 = str_replace('\\', '/', $detail->item->image2);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $detail->item->item_name }}</td>
                                                                <td>{{ $detail->item->product_code }}</td>
                                                                <td>{{ $detail->item->part_number }}</td>
                                                                <td>
                                                                    <img src="{{ asset($img1) }}"
                                                                        style="width:50px;height:50px;border-radius:5px;object-fit:cover;">
                                                                </td>
                                                                <td>
                                                                    <img src="{{ asset($img2) }}"
                                                                        style="width:50px;height:50px;border-radius:5px;object-fit:cover;">
                                                                </td>
                                                                <td>{{ $detail->item->unit }}</td>
                                                                <td>{{ $detail->item->category }}</td>
                                                                <td>{{ $detail->item->shelf }}</td>
                                                                <td>{{ $detail->batch->batch_number }}</td>
                                                                <td>{{ number_format($detail->quantity) }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="text-right mt-3">
                                            <button class="btn btn-danger" data-toggle="modal"
                                                data-target="#modal-lg-reject-{{ $salesOrder->id }}">
                                                Reject
                                            </button>

                                            <a href="acceptOrder-{{ $salesOrder->id }}" class="btn btn-success">
                                                Accept
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- REJECT MODAL -->
                        <div class="modal fade" id="modal-lg-reject-{{ $salesOrder->id }}">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Reject Order {{ $salesOrder->reference_number }}</h4>
                                        <button class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>

                                    <form action="regect-order-{{ $salesOrder->id }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <label>Reject Reason</label>
                                            <textarea name="rejectReasone" class="form-control" required></textarea>

                                            <div class="text-right mt-3">
                                                <button type="submit" class="btn btn-success">Save</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach



                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection
