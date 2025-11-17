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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        {{-- <div class="p-2" style="float: right"> {{ $sales->links() }}</div> --}}
                        <table id="example1" class="table table-bordered table-striped"
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>CustomerName</th>
                                    <th>Phone</th>
                                    <th>BussinesType</th>
                                    <th style="background-color:rgb(5, 5, 36);">TotalBalance</th>
                                    <th><i></i></th>
                                    <th><i></i></th>

                                </tr>
                            </thead>
                            <tbody id='list'>
                                @php
                                    $no = 0;
                                @endphp
                                @forelse ($creditcustomers as $credit)
                                    @if ($credit->sales_type == 'Credit Sales' && $credit->customer->total_balance > 1)
                                        @php
                                            $no = $no + 1;
                                        @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $credit->customer->name }}</td>
                                            <td>{{ $credit->customer->phone }}</td>
                                            {{-- <td>{{ $customer->address}}</td> --}}
                                            {{-- <td>{{ $customer->company_name}}</td> --}}
                                            <td>{{ $credit->customer->type }}</td>
                                            <td style="color: greenyellow;background-color:rgb(5, 5, 36)">
                                                {{ number_format($credit->customer->total_balance, 2) }}</td>
                                            <td>
                                                <a class="btn btn-success btn-xs"
                                                    href="customerPayments-{{ $credit->customer->id }}">Balance</a>
                                                <a class="btn btn-primary btn-xs"
                                                    href="customerSalesHitory-{{ $credit->customer->id }}">History</a>
                                                <a class="btn btn-warning btn-xs"
                                                    href="sales-return-{{ $credit->customer->id }}">SalesReturn</a>

                                            </td>
                                            <td>
                                                <a class="btn btn-info btn-xs" data-toggle="modal"
                                                    data-target="#modal-lg-customer-{{ $credit->id }}">Edit</a>
                                                <a class="btn btn-danger btn-xs" href="#"
                                                    onclick="return confirm('Are you sure you ?');">Delete</a>
                                                {{-- <a class="btn btn-danger btn-xs" href="delete-customer-{{$customer->id}}" onclick="return confirm('Are you sure you ?');">Delete</a> --}}
                                            </td>
                                            {{-- <td><small> {{ $customer->email}} </small></td> --}}

                                        </tr>
                                    @endif


                                @empty
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
        </div>
    </section>
@endsection
