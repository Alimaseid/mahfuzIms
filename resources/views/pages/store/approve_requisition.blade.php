@extends('inc.frame')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row p-3">
                <div class="card">
                    <div class="card-body text-sm">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>RequisitionDate</th>
                                    <th>RequestFrom</th>
                                    <th>RequestBy</th>
                                    <th>RequestTo</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 0 ; @endphp
                                @forelse ($requisitions as $requisition)
                                    @php $no++ ; @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $requisition->created_at->toDateString() }}</td>
                                        <td>{{ $requisition->requestFrom->name ?? '-' }}</td>
                                        <td>{{ $requisition->request_by }}</td>
                                        <td>{{ $requisition->requestTo->name ?? '-' }}</td>
                                        <td>{{ $requisition->status }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-{{ $requisition->id }}">
                                                View
                                            </button>
                                        </td>
                                        <td>
                                            <a href="approveRequisition/{{ $requisition->id }}/{{ Auth::user()->name }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No Requisitions Found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- ==================== MODALS ==================== -->
                    @foreach ($requisitions as $requisition)
                        <div class="modal fade" id="modal-lg-view-{{ $requisition->id }}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4 class="modal-title">Requisition #{{ $requisition->id }}</h4>
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
                                                    @foreach ($requisitionDetails as $detail)
                                                        @if ($detail->requisition_id == $requisition->id)
                                                            @php
                                                                $img1 = str_replace('\\', '/', $detail->item->image);
                                                                $img2 = str_replace('\\', '/', $detail->item->image2);
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $detail->item->item_name }}</td>
                                                                <td>{{ $detail->item->product_code }}</td>
                                                                <td>{{ $detail->item->part_number }}</td>
                                                                <td><img src="{{ asset($img1) }}"
                                                                        style="width:60px;height:60px;border-radius:5px;object-fit:cover;">
                                                                </td>
                                                                <td><img src="{{ asset($img2) }}"
                                                                        style="width:60px;height:60px;border-radius:5px;object-fit:cover;">
                                                                </td>
                                                                <td>{{ $detail->item->unit }}</td>
                                                                <td>{{ $detail->item->category }}</td>
                                                                <td>
                                                                    @foreach ($shelfs as $shelff)
                                                                        @if ($shelff->shelf->business_locations_id == $requisition->request_from && $detail->item_id == $shelff->item_id)
                                                                            {{ $shelff->shelf->shelf_name ?? '-' }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td>{{ $detail->batch->batch_number ?? '-' }}</td>
                                                                <td>{{ number_format($detail->quantity) }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

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
