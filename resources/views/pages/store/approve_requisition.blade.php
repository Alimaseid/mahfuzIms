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
                      <th></th>
                      <th></th>
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
                                <td> <a href="">{{$requisition->status}} </a></td>
                                <td  style="width: 50%;">
                                    @forelse ($requisition->itemList as $list)
                                        {{ $list->item_name }} <i style="color: rgb(8, 239, 8)">({{ $list->quantity }})</i>,
                                        <br>
                                    @empty

                                    @endforelse
                                </td>

                                <td>
                                    <a href="approveRequisition/{{ $requisition->id }}/{{ Auth::user()->name }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-check "></i>
                                      </a>
                                </td>
                                <td>
                                    <a href="rejectRequisition-{{ $requisition->id }}" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash "></i>
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
</section>

@endsection
