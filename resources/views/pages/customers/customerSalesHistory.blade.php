@extends('inc.frame')


@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8 lg">
                            <div class="pl-3">To <b class="text-warning">{{ $vendor }}'s</b> Sales History </div>
                        </div>
                        <div class="col-4 lg">
                        </div>
                    </div>
                </div>
            </div>
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
                                    <th>RefrenceNo</th>
                                    <th>SalesPerson</th>
                                    <th>SalesLocation</th>
                                    <th>SalesType</th>
                                    <th>Sataus</th>
                                    <th>TotalPayment</th>
                                    <th>View </th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                @php $no= 0; @endphp
                                @forelse ($data as $dt)
                                    @php $no= $no + 1; @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $dt['date']->toDateString() }}</td>
                                        <td>{{ $dt['RF'] }}</td>
                                        <td>{{ $dt['RF'] }}</td>
                                        <td>{{ $dt['sales_person'] }}</td>
                                        <td>{{ $dt['sales_type'] }}</td>
                                        <td>{{ $dt['status'] }}</td>
                                        <td>{{ number_format($dt['total_payment']) }}</td>
                                        <td>
                                            <a class="btn btn-success btn-xs" data-toggle="modal"
                                                data-target="#modal-lg-view-{{ $dt['id'] }}">View Detail</button>
                                        </td>
                                    </tr>


                                    <div class="modal fade" id="modal-lg-view-{{ $dt['id'] }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">{{ $dt['RF'] }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            ItemName
                                                        </div>
                                                        <div class="col">
                                                            P-no1
                                                        </div>
                                                        <div class="col">
                                                            P-no2
                                                        </div>
                                                        <div class="col">
                                                            unit
                                                        </div>
                                                        <div class="col">
                                                            Category
                                                        </div>

                                                        <div class="col">
                                                            Shelf
                                                        </div>

                                                        <div class="col">
                                                            Quantity
                                                        </div>

                                                        <div class="col">
                                                            Price
                                                        </div>
                                                        <div class="col">
                                                            Total
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @forelse ($dt['Details'] as $purchaseOrderDetail)
                                                        @if ($purchaseOrderDetail['order_id'] == $dt['id'])
                                                            <div class="row">
                                                                <div class="col">
                                                                    <a
                                                                        href=""><b>{{ $purchaseOrderDetail['item_name'] }}</b></a>
                                                                </div>
                                                                <div class="col">
                                                                    <a
                                                                        href=""><b>{{ $purchaseOrderDetail['item_code'] }}</b></a>
                                                                </div>
                                                                <div class="col">
                                                                    <a
                                                                        href=""><b>{{ $purchaseOrderDetail['part_number'] }}</b></a>
                                                                </div>
                                                                <div class="col">
                                                                    <a
                                                                        href=""><b>{{ $purchaseOrderDetail['unit'] }}</b></a>
                                                                </div>
                                                                <div class="col">
                                                                    <a
                                                                        href=""><b>{{ $purchaseOrderDetail['category'] }}</b></a>
                                                                </div>
                                                                <div class="col">
                                                                    <a
                                                                        href=""><b>{{ $purchaseOrderDetail['shelf'] }}</b></a>
                                                                </div>
                                                                <div class="col">
                                                                    {{ number_format($purchaseOrderDetail['quantity']) }}
                                                                </div>
                                                                <div class="col">
                                                                    {{ number_format($purchaseOrderDetail['total']) }}

                                                                </div>
                                                                <div class="col">
                                                                    <b>{{ number_format($purchaseOrderDetail['grand_total']) }}</b>
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

                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
@endsection
