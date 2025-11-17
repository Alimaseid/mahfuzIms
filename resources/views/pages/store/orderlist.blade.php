@extends('inc.frame')


@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body text-sm">
                        {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                        <table id="example1" class="table table-bordered table-striped"
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SalesDate</th>
                                    <th>InvoiceNo</th>
                                    <th>CustomerName</th>
                                    <th>SalesPerson</th>
                                    <th>View </th>
                                    <th>Action</th>
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
                                            <td>{{ $salesOrder->created_at->toDateString() }}</td>
                                            <td>{{ $salesOrder->reference_number }}</td>
                                            <td>
                                                @forelse ($customers as $customer)
                                                    @if ($customer->id == $salesOrder->customer_id)
                                                        {{ $customer->name }}
                                                    @endif
                                                @empty
                                                @endforelse
                                            </td>
                                            <td>{{ $salesOrder->sales_person }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
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
                                        <!-- /.card -->

                                        <div class="modal fade" id="modal-lg-view-{{ $salesOrder->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{ $salesOrder->reference_number }}
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col">
                                                                Item
                                                            </div>
                                                            <div class="col">
                                                                Part no1
                                                            </div>
                                                            <div class="col">
                                                                Part no2
                                                            </div>
                                                            <div class="col">
                                                                Image1
                                                            </div>
                                                            <div class="col">
                                                                Image2
                                                            </div>
                                                            <div class="col">
                                                                Unit
                                                            </div>
                                                            <div class="col">
                                                                Category
                                                            </div>
                                                            <div class="col">
                                                                Shelf
                                                            </div>
                                                            <div class="col">
                                                                Batch
                                                            </div>
                                                            <div class="col">
                                                                Quantity
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
                                                                @php
                                                                    $imagePath1 = str_replace(
                                                                        '\\',
                                                                        '/',
                                                                        $salesOrderDetail->item->image,
                                                                    );
                                                                    $imagePath2 = str_replace(
                                                                        '\\',
                                                                        '/',
                                                                        $salesOrderDetail->item->image2,
                                                                    );
                                                                @endphp
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <b>{{ $salesOrderDetail->item->item_name }}</b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b>{{ $salesOrderDetail->item->product_code }}</b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b>{{ $salesOrderDetail->item->part_number }}</b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <img src="{{ asset($imagePath1) }}" alt=""
                                                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">

                                                                    </div>
                                                                    <div class="col">
                                                                        <b> <img src="{{ asset($imagePath2) }}"
                                                                                alt=""
                                                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">
                                                                        </b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b>{{ $salesOrderDetail->item->unit }}</b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b>{{ $salesOrderDetail->item->category }}</b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b>{{ $salesOrderDetail->item->shelf }}</b>
                                                                    </div>
                                                                    <div class="col">
                                                                        <b>{{ $salesOrderDetail->batch->batch_number }}</b>
                                                                    </div>

                                                                    <div class="col">
                                                                        {{ number_format($salesOrderDetail->quantity) }}
                                                                    </div>


                                                                </div>
                                                                <br>
                                                            @endif
                                                        @empty
                                                        @endforelse
                                                        <div class="row no-print">
                                                            <div class="col-12">
                                                                <a rel="noopener" class="btn btn-danger" data-toggle="modal"
                                                                    data-target="#modal-lg-reject-{{ $salesOrder->id }}">Reject</a>
                                                                <a
                                                                    href="acceptOrder-{{ $salesOrder->id }}"class="btn btn-success float-right">
                                                                    Accept</a>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->

                                        <div class="modal fade" id="modal-lg-reject-{{ $salesOrder->id }}">
                                            <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{ $salesOrder->reference_number }}
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="regect-order-{{ $salesOrder->id }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="">I reject this order due to
                                                                            this reasone</label>
                                                                        <textarea name="rejectReasone" class="form-control" id="" placeholder="reasone..."></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </br>
                                                            <div class="row no-print">
                                                                <div class="col-12">
                                                                    <button type="submit"
                                                                        class="btn btn-success float-right"> Save</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    @endforeach
                                @else
                                    <h2>No salesOrder Found !</h2>
                                @endif
                            </tbody>
                        </table>
                        {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links("pagination::bootstrap-4") }}</div> --}}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection
