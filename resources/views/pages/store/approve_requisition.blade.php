@extends('inc.frame')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row p-3">
                <div class="card">
                    <div class="card-body text-sm">
                        {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                        <table id="example1" class="table table-bordered table-striped"
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>RequisitionDate</th>
                                    <th>RequestFrom</th>
                                    <th>RequestBy</th>
                                    <th>RequestTo</th>
                                    <th>Status</th>
                                    <th>Details</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                @php $no = 0 ; @endphp
                                @forelse ($requisitions as $requisition)
                                    @php $no = $no + 1 ; @endphp
                                    <tr>
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $requisition->created_at->toDateString() }}</td>
                                        <td>{{ $requisition->requestFrom->name ?? '-' }}</td>
                                        <td>{{ $requisition->request_by }}</td>
                                        <td>{{ $requisition->requestTo->name ?? '-' }}</td>

                                        <td> <a href="">{{ $requisition->status }} </a></td>
                                        <td style="">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view-{{ $requisition->id }}">
                                                view
                                            </button>
                                        </td>

                                        <td>
                                            <a href="approveRequisition/{{ $requisition->id }}/{{ Auth::user()->name }}"
                                                class="btn btn-success btn-sm">
                                                <i class="fas fa-check "></i>
                                            </a>
                                        </td>
                                        {{-- <td>
                                            <a href="rejectRequisition-{{ $requisition->id }}"
                                                class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash "></i>
                                            </a>
                                        </td> --}}
                                    </tr>
                                    <div class="modal fade" id="modal-lg-view-{{ $requisition->id }}">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">
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
                                                            unit
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
                                                    @forelse ($requisitionDetails as $requisitionDetail)
                                                        @if ($requisitionDetail->requisition_id == $requisition->id)
                                                            @php
                                                                $imagePath1 = str_replace(
                                                                    '\\',
                                                                    '/',
                                                                    $requisitionDetail->item->image,
                                                                );
                                                                $imagePath2 = str_replace(
                                                                    '\\',
                                                                    '/',
                                                                    $requisitionDetail->item->image2,
                                                                );
                                                            @endphp
                                                            <div class="row">
                                                                <div class="col">
                                                                    <b>{{ $requisitionDetail->item->item_name }}</b>
                                                                </div>
                                                                <div class="col">
                                                                    <b>{{ $requisitionDetail->item->product_code }}</b>
                                                                </div>
                                                                <div class="col">
                                                                    <b>{{ $requisitionDetail->item->part_number }}</b>
                                                                </div>
                                                                <div class="col">
                                                                    <img src="{{ asset($imagePath1) }}" alt=""
                                                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">

                                                                </div>
                                                                <div class="col">
                                                                    <b> <img src="{{ asset($imagePath2) }}" alt=""
                                                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px; cursor: pointer;">
                                                                    </b>
                                                                </div>
                                                                <div class="col">
                                                                    <b>{{ $requisitionDetail->item->unit }}</b>
                                                                </div>
                                                                <div class="col">
                                                                    <b>{{ $requisitionDetail->item->category }}</b>
                                                                </div>
                                                                <div class="col">
                                                                    <b>
                                                                        @foreach ($shelfs as $shelff)
                                                                            @if (
                                                                                $shelff->shelf->business_locations_id == $requisition->request_from &&
                                                                                    $requisitionDetail->item_id == $shelff->item_id)
                                                                                {{ $shelff->shelf->shelf_name ?? '-' }}
                                                                            @endif
                                                                        @endforeach
                                                                    </b>
                                                                </div>
                                                                <div class="col">
                                                                    <b>{{ $requisitionDetail->batch->batch_number ?? '' }}</b>
                                                                </div>
                                                                <div class="col">
                                                                    {{ number_format($requisitionDetail->quantity) }}
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
                                @empty
                                @endforelse
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
