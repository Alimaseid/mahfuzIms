@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                <div class="row">
                    <div class="col-8 lg">
                        <h3 class="card-title">
                        <a class="nav-link" data-widget="navbar-search" style="float: center" href="#" role="button">
                          <i class="fas fa-search"></i>
                        </a>
                        <div class="navbar-search-block">
                          <form class="form-inline">
                            <div class="input-group input-group-sm">
                              <input class="form-control form-control-navbar" type="search" placeholder="Search" id="search" name="search" aria-label="Search">
                          </form>
                        </div>
                        </h3>
                    </div>
                    <div class="col-4 lg">
                      <div class="pl-3 " style="float: right"><b> {{ count($sale) }} : Sales</b></div>

                          {{-- <button type="button" class="btn btn-primary pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                            New sale
                          </button> --}}
                    </div>
                </div>
             </div>
        </div>
        </div>

              <div class="card">
                <div class="card-body">
                    {{-- <div class="p-2" style="float: right"> {{ $sales->links() }}</div> --}}
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>SalesDate</th>
                      <th>CustomerName</th>
                      <th>ReferenceNumber</th>
                      <th>salesperson</th>
                      <th>OwnerName</th>
                      <th>Location</th>
                      <th>Payable</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                        @if(count($sales) > 0)
                        @php
                            $no = 0;
                        @endphp
                        @foreach($sales as $sale)
                        @php
                            $no = $no + 1;
                        @endphp
                         <tr>
                            <td>{{$no}}</td>
                            <td>{{$sale->created_at->toDateString()}}</td>
                            <td>
                                @forelse ($customers as $customer)
                                    @if($sale->customer_id == $customer->id)
                                      {{$customer->name}}
                                     @endif
                                @empty
                                @endforelse
                            </td>
                            <td>{{$sale->reference_number}}</td>
                            <td> {{$sale->sales_person}}</td>
                            <td>
                                @forelse ($owners as $owner)
                                @if($sale->owner_id == $owner->id)
                                  {{$owner->name}}
                                 @endif
                                @empty
                                @endforelse
                            </td>
                            <td>
                                @forelse ($locations as $location)
                                @if($sale->location_id== $location->id)
                                  {{$location->name}}
                                 @endif
                                @empty
                                @endforelse
                            </td>
                            <td>{{number_format($sale->grand_total)}}</td>
                            <td>
                                @if ($sale->payment_status == 'Paid')
                                <p class="text-success">{{$sale->payment_status}}</p>
                                @elseif($sale->payment_status == 'Partialy Paid')
                                 <p class="text-warning">{{$sale->payment_status}}</p>
                                @elseif($sale->payment_status == 'Over Paid')
                                    <p class="text-primary">{{$sale->payment_status}}</p>
                                @elseif($sale->payment_status == null)
                                   <p class="text-danger">Not Paid</p>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg-view-{{$sale->id}}">
                                        Payment
                                  </button>
                            </td>
                        </tr>

                            <div class="modal fade" id="modal-lg-view-{{$sale->id}}">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{$sale->reference_number}}</h4>
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
                                        @php
                                           $total = 0;
                                        @endphp
                                        @forelse ($salesOrderDetails as $salesOrderDetail)
                                         @if($salesOrderDetail->sales_order_id == $sale->id)
                                         @php
                                           $total = $total + $salesOrderDetail->total
                                         @endphp
                                            <div class="row">
                                                 <div class="col-3">
                                                    <a href=""><b>{{$salesOrderDetail->item_name}}</b></a>
                                                 </div>
                                                 <div class="col-3">
                                                    {{number_format($salesOrderDetail->quantity)}}
                                                 </div>
                                                 <div class="col-3">
                                                    {{number_format($salesOrderDetail->amount)}} ,<small>{{$salesOrderDetail->tax}}%</small>
                                                 </div>
                                                 <div class="col-3">
                                                    {{number_format($salesOrderDetail->total)}}
                                                 </div>
                                            </div>
                                            <br>

                                         @endif
                                        @empty

                                        @endforelse
                                        <hr>
                                        <div class="row pl-4" style="float:right;">
                                            <div class="col-4" >
                                                Total <b>{{number_format($total) }}</b>
                                            </div>
                                            <div class="col-4" style="float: right">
                                              Payable {{number_format($sale->grand_total)}}
                                             </div>
                                             <div class="col-4" style="float: right">
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg-pay-{{$sale->id}}">
                                                    Pay
                                              </button>
                                             </div>
                                        </div>
                                    </div>

                                  </div>
                                  <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                              </div>
                              <!-- /.modal -->

                                <div class="modal fade" id="modal-lg-pay-{{$sale->id}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">New Payment</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">

                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Total Payment : <b>{{number_format($sale->grand_total)}} <SUB>Birr</SUB></b></h3>
                                                        </div>
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form  action="/salesPayment-{{$sale->id}}-{{$sale->customer_id}}-{{$sale->location_id}}-{{$sale->owner_id}}" method="POST" id="quickForm" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6" >
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1">Payment Type</label>
                                                                   <select name="payment_type" class="form-control" id="cheque" onchange="chequeNumber()" required>
                                                                    <option value="">Select Here</option>
                                                                    <option value="Cash">Cash</option>
                                                                    <option value="Cheque">Cheque</option>
                                                                    <option value="Bank Transfer">Banck Transfer</option>
                                                                   </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >Amount</label>
                                                                    <input type="number" step="any" name="amount" class="form-control"  value="{{$sale->grand_total}}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="chequedate" style="display: none">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label >Cheque</label>
                                                                    <input type="text" name="cheque_no" class="form-control"  placeholder="Cheque Number" >
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label >Bank Receipt</label>
                                                                    <input type="file" name="banck_receipt" class="form-control" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary swalDefaultSuccess" >Save</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                    <!-- /.card -->
                                               </div><!-- /.container-fluid -->

                                            </div>
                                         </div>
                                        <!-- /.modal-content -->
                                       </div>
                                    <!-- /.modal-dialog -->
                                    </div>
                                <!-- /.modal -->

                          <!-- /.card -->

                        @endforeach
                        @else
                         <h2>No sale Found !</h2>
                        @endif
                    </tbody>
                  </table>

              {{-- <div class="p-2" style="float: right"> {{ $sales->links("pagination::bootstrap-4") }}</div> --}}


                </div>
                <!-- /.card-body -->
              </div>

              <!-- /.card -->

            </div>
        </div>
    </div>
  </section>

  <script type="text/javascript">
    $("#search").on('keyup',function(){
        var s_data = $(this).val();
        $.ajax({
            method:'POST',
            url: '{{url("search-sale") }}',
            data:{
               '_token':'{{ csrf_token() }}',
                name:s_data,
            },
            dataType:'json',
            success:function(data){
                var rowData = '';
                var no=0;
                $('#list').html('');
                $.each(data, function(index,value){
                   no = no + 1;
                    rowData = `
                    <tr>
                            <td>${no}</td>
                            <td>
                            <img src="${value.image}" alt="" width="50px" height="30px">
                            </td>
                            <td>${value.sale_name}</td>
                            <td>${value.category}</td>
                            <td> ${value.quantity}</td>
                            <td>${value.product_code}</td>
                            <td>${value.cost_price}</td>
                            <td>${value.selling_price1}</td>
                            <td>${value.selling_price2}</td>
                            <td>${value.selling_price3}</td>
                            <td>${value.supplier_name}</td>
                            <td>
                                <a type="button" class="btn btn-warning btn-sm" href="delete-sale-${value.id}" onclick="return confirm('Are you sure you ?');">
                                    ${value.status}
                                  </a>
                            </td>

                            <td>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-${value.id}">
                              <i class="fas fa-edit"></i>
                              </button>
                              <a type="button" class="btn btn-danger btn-sm" href="delete-sale-${value.id}" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-trash"></i>
                              </a>
                            </td>
                        </tr>`;

                        $('#list').append(rowData);
                });
            }
        });
       })
    </script>
    <script>
        function chequeNumber(){
            var type = $('#cheque').val();
            if(type != 'Cash' ){
               document.getElementById('chequedate').style.display = 'block';
            }else{
               document.getElementById('chequedate').style.display = 'none';

            }
        }
    </script>

@endsection
