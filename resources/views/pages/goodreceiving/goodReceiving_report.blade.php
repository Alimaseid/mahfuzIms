@extends('inc.frame')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row pt-1">
                <div class="col-md-6">
                    <form action="{{ route('reports.goodReceiving') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4"></div>

                            <div class="col-sm-3">
                                <label>From</label>
                                <input type="date" name="from_date" value="{{ $fromDate->format('Y-m-d') }}"
                                    class="form-control">
                            </div>

                            <div class="col-sm-3">
                                <label>To</label>
                                <input type="date" name="to_date" value="{{ $toDate->format('Y-m-d') }}"
                                    class="form-control">
                            </div>

                            <div class="col-sm-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-warning btn-sm">Go</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-2"></div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <table id="example1" class="table table-bordered table-striped "
                        style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Receiving Date</th>
                                <th>Item</th>
                                <th>Batch</th>
                                <th>Location</th>
                                <th>Invoice No</th>
                                <th>Cost Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($goodReceivings as $index => $gr)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $gr->receiving_date->format('Y-m-d') }}</td>
                                    <td>{{ $gr->item->item_name ?? '-' }}</td>
                                    <td>{{ $gr->batch->batch_number ?? '-' }}</td>
                                    <td>{{ $gr->location->name ?? '-' }}</td>
                                    <td>{{ $gr->invoice_no }}</td>
                                    <td>{{ number_format($gr->cost_price, 2) }}</td>
                                    <td>{{ $gr->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
@endsection
