@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row p-3">
              <div class="card">
                <div class="card-body text-sm">
                    {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>RequisitionDate</th>
                      <th>Requisition#No</th>
                      <th>RequestBy</th>
                      <th>RequestFrom</th>
                      <th>Status</th>
                      <th>ItemList</th>
                      <th>IssueHere</th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                    @php $no = 0 ; @endphp
                        @forelse ($requisitions as $requisition)
                         @php $no = $no + 1 ; @endphp
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{$requisition->created_at->toDateString()}}</td>
                                <td>{{$requisition->id}}</td>
                                <td>{{$requisition->request_by}}</td>
                                <td>{{$requisition->request_from}}</td>
                                <td> <a href="" style="color: greenyellow">{{$requisition->status}} </a></td>
                                <td  style="width: 50%;">
                                    @forelse ($requisition->itemList as $list)
                                        {{ $list->item_name }} <i style="color: rgb(8, 239, 8)">({{ $list->quantity }})</i>,
                                        <br>
                                    @empty

                                    @endforelse
                                </td>

                                <td>
                                    <a class="btn btn-success btn-sm"  data-toggle="modal" data-target="#modal-lg-issue{{$requisition->id}}">
                                        <i class="fas fa-check "></i>  Issue
                                      </a>
                                </td>

                            </tr>
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

@forelse ($requisitions as $requisition)
    <div class="modal fade" id="modal-lg-issue{{$requisition->id}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Store Issue Voucher{{$requisition->id}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <section class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-default">
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <form action="issueRequisition/{{ $requisition->id }}" method="POST">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                          <h4>
                                                            <i class="fas fa-globe"></i> UKAZ, Inc.
                                                            <small class="float-right">Date : {{ \Carbon\Carbon::now()->toFormattedDateString() }}</small>
                                                          </h4>
                                                        </div>
                                                        <!-- /.col -->
                                                      </div>
                                                    <div class="row invoice-info">
                                                        <div class="col-sm-4 invoice-col">
                                                          <address>
                                                            {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                            From
                                                            <div class="form-group">
                                                                <select name="transfer_from_store"  class="form-control" id="location" required>
                                                                    <option value="">Select Here</option>
                                                                        @forelse ($locations as $location)
                                                                           <option value="{{$location->id}}">{{$location->name}}</option>
                                                                        @empty
                                                                        <option value="">Empty Location !</option>
                                                                        @endforelse
                                                                </select>
                                                            </div>

                                                          </address>
                                                        </div>

                                                          <div class="col-sm-4 invoice-col">
                                                            <address>
                                                              {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                              Issue By
                                                              <div class="form-group">
                                                                <input type="text" readonly value="{{Auth::user()->name}}" name="issued_by" class="form-control" required>
                                                            </div>
                                                          </div>
                                                          <div class="col-sm-4 invoice-col">
                                                            Shipped By
                                                            <div class="form-group">
                                                                <input type="text"  name="ship_by" class="form-control" required>
                                                            </div>
                                                        </div>

                                                    <div class="row">

                                                        <div class="col-12 table-responsive">

                                                          <table class="table table-striped">
                                                              <tr>
                                                                  <th>ProductNameCode</th>
                                                                  <th>Quantity</th>
                                                                  <th> Select Owner</th>
                                                              </tr>
                                                            <tbody id="add_items">
                                                                @forelse ($requisition->itemList as $list)

                                                              <tr>
                                                                <td style="width: 250px;">
                                                                    <input type="text" class="form-control" readonly  name="addmore[{{ $list->id }}][item_name]" value="{{ $list->item_name }}">

                                                                    <input type="hidden" readonly name="addmore[{{ $list->id }}][item_id]" value="{{ $list->item_id }}">
                                                                 </td>
                                                                  <td>
                                                                     <input type="number" readonly min="0"  name="addmore[{{ $list->id }}][quantity]" value="{{ $list->quantity }}" class="form-control input-group-sm" required>
                                                                  </td>
                                                                  <td>
                                                                   <select name="addmore[{{ $list->id }}][transfer_from_owner]"  class="form-control"  required>
                                                                    {{-- <option value="">Select Here</option> --}}
                                                                    @forelse ($owners as $owner)
                                                                       <option value="{{$owner->id}}">{{$owner->name}}</option>
                                                                    @empty
                                                                    <option value="">Empty Owner !</option>
                                                                    @endforelse
                                                                </select>
                                                                 </td>
                                                                </tr>
                                                                @empty

                                                                @endforelse
                                                            </tbody>

                                                          </table>


                                                        </div><hr><br>
                                                        <!-- /.col -->
                                                      </div>

                                                </div>
                                                <!-- /.card-body -->
                                                <button type="submit" class="btn btn-primary swalDefaultSuccess">Submit</button>
                                            </form>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </section>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>


    @empty
    @endforelse

</section>

@endsection
