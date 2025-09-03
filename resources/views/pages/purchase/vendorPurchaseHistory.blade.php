@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
            <div class="row">
                <div class="col-8 lg">
                  <div class="pl-3">From <b class="text-warning"> {{$vendor}}'s</b> Purchase History </div>
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
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>PurchaseDate</th>
                      <th>RefrenceNo</th>
                      <th>PurchasedBy</th>
                      <th>StoredOn</th>
                      <th>PaymentTerms</th>
                      <th>TotalPayment</th>
                      <th>View  </th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                      @php $no= 0; @endphp
                        @forelse ($data as $dt)
                             @php $no= $no + 1; @endphp
                             <tr>
                                <td>{{$no}}</td>
                                <td>{{$dt['date']->toDateString()}}</td>
                                <td>{{$dt['RF']}}</td>
                                <td>{{$dt['owner']}}</td>
                                <td>{{$dt['location']}}</td>
                                <td>{{$dt['payment_terms']}}</td>
                                <td>{{number_format($dt['total_payment'])}}</td>
                                <td>
                                    <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-lg-view-{{$dt['id']}}">View Detail</button>
                                </td>
                             </tr>


                             <div class="modal fade" id="modal-lg-view-{{$dt['id']}}">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{$dt['RF']}}</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-3">
                                                Item
                                            </div>
                                            <div class="col-3">
                                                Quantity
                                            </div>
                                            <div class="col-3">
                                                Price <small>Vat</small>
                                            </div>
                                            <div class="col-3">
                                                Total
                                            </div>
                                        </div>
                                        <hr>
                                        @forelse ($dt['Details'] as $purchaseOrderDetail)
                                          @if ($purchaseOrderDetail['order_id'] == $dt['id'])
                                            <div class="row">
                                                 <div class="col-3">
                                                    <a href=""><b>{{$purchaseOrderDetail['item_code']}}</b></a>
                                                 </div>
                                                 <div class="col-3">
                                                    {{number_format($purchaseOrderDetail['quantity'])}}
                                                 </div>
                                                 <div class="col-3">
                                                    {{number_format($purchaseOrderDetail['total'])}} ,<small>{{$purchaseOrderDetail['tax']}}%</small>
                                                 </div>
                                                 <div class="col-3">
                                                    <b>{{number_format($purchaseOrderDetail['grand_total'])}}</b>
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
