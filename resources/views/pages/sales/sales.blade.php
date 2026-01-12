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
                                    <a type="button" href="/addsales" class="btn btn-info pull-rigth btn-sm"
                                        style="float: right;">
                                        <b class="pr-3"> New sales</b>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped text-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SalesDate</th>
                                <th>CustomerName</th>
                                <th>Payment</th>
                                <th>InvoiceNumber</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>SalesPerson</th>
                                <th>Activity/Action</th>
                            </tr>
                        </thead>

                        <tbody id="list">
                            @if (count($salesOrders) > 0)
                                @php $no = 1; @endphp
                                @foreach ($salesOrders as $salesOrder)
                                    <tr>
                                        <td>{{ $no++ }}</td>

                                        <td>{{ $salesOrder->created_at->toDateString() }}</td>

                                        <td>
                                            @foreach ($customers as $customer)
                                                @if ($customer->id == $salesOrder->customer_id)
                                                    {{ $customer->name }}
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            <a class="btn" data-toggle="modal"
                                                data-target="#modal-view-{{ $salesOrder->id }}">
                                                <i style="color: greenyellow">
                                                    {{ number_format($salesOrder->grand_total, 2) }}
                                                </i>
                                            </a>
                                        </td>

                                        <td>{{ $salesOrder->reference_number }}</td>

                                        <td>
                                            @foreach ($businessLocations as $location)
                                                @if ($location->id == $salesOrder->location_id)
                                                    {{ $location->name }}
                                                @endif
                                            @endforeach
                                        </td>

                                        <td>
                                            @if ($salesOrder->SM_status == 'Pending')
                                                <p class="text-warning">Pending</p>
                                            @elseif ($salesOrder->SM_status == 'Rejected')
                                                <button class="btn btn-danger btn-xs" data-toggle="modal"
                                                    data-target="#modal-reject-{{ $salesOrder->id }}">
                                                    Rejected
                                                </button>
                                            @elseif ($salesOrder->SM_status == 'Accepted')
                                                <p class="text-primary">Accepted</p>
                                            @else
                                                <p class="text-success">{{ $salesOrder->SM_status }}</p>
                                            @endif
                                        </td>

                                        <td>{{ $salesOrder->sales_person }}</td>

                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-view-{{ $salesOrder->id }}">
                                                Details
                                            </button>

                                            @if ($permission->manage_edit_sales == 'on')
                                                <a class="btn btn-info btn-sm" href="/editsales-{{ $salesOrder->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            @if ($permission->manage_delete_sales == 'on')
                                                <a onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"
                                                    href="/delete-sales-order-{{ $salesOrder->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif

                                            <a href="/sales-invoice-{{ $salesOrder->id }}" target="_blank"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-print"></i> Print
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <h2>No Sales Orders Found!</h2>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- /.card-body -->


                {{-- ============================= --}}
                {{--   ALL SALES ORDER MODALS      --}}
                {{-- ============================= --}}
                @foreach ($salesOrders as $salesOrder)
                    {{-- DETAILS MODAL --}}
                    <div class="modal fade" id="modal-view-{{ $salesOrder->id }}">
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
                                                    @if ($permission->manage_partNumber == 'on')
                                                        <th>P-No1</th>
                                                    @endif
                                                    @if ($permission->manage_partNumber2 == 'on')
                                                        <th>P-No2</th>
                                                    @endif
                                                    @if ($permission->manage_image == 'on')
                                                        <th>Image1</th>
                                                    @endif
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Vat</th>
                                                    <th>With Holding</th>
                                                    <th>Discount</th>
                                                    <th>SubTotal</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php $total = 0; @endphp

                                                @foreach ($salesOrderDetails as $detail)
                                                    @if ($detail->sales_order_id == $salesOrder->id)
                                                        @php
                                                            $total += $detail->total;
                                                            $image1 = str_replace('\\', '/', $detail->item->image);
                                                        @endphp
                                                        <tr>
                                                            <td><b>{{ $detail->item->item_name }}</b></td>
                                                            @if ($permission->manage_partNumber == 'on')
                                                                <td><b>{{ $detail->item->product_code }}</b></td>
                                                            @endif
                                                            @if ($permission->manage_partNumber2 == 'on')
                                                                <td><b>{{ $detail->item->part_number }}</b></td>
                                                            @endif
                                                            @if ($permission->manage_image == 'on')
                                                                <td>
                                                                    <img src="{{ asset($image1) }}"
                                                                        style="width:40px;height:40px;border-radius:5px;object-fit:cover;">
                                                                </td>
                                                            @endif
                                                            <td>{{ $detail->quantity }}</td>
                                                            <td>{{ $detail->amount }}</td>
                                                            <td>{{ $detail->tax }}</td>
                                                            <td>{{ $detail->with_holding }}</td>
                                                            <td>{{ $detail->discount }}</td>
                                                            <td>{{ $detail->total }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="text-right mt-3">
                                            <h5><b>Total: {{ number_format($salesOrder->grand_total, 2) }}</b></h5>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    {{-- REJECT MODAL --}}
                    <div class="modal fade" id="modal-reject-{{ $salesOrder->id }}">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">{{ $salesOrder->reference_number }}</h4>
                                    <button class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <label>Rejected Because:</label>
                                    <textarea class="form-control" readonly>{{ $salesOrder->rejectReasone }}</textarea>

                                    <br>

                                    <button class="btn btn-success float-right" data-toggle="modal"
                                        data-target="#modal-view-{{ $salesOrder->id }}">
                                        Edit Order
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach



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

@endsection
