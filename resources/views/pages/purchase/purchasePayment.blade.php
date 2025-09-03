@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        {{-- <div class="row">
            <div class="card">
                <div class="card-body">
                       sddsd
                </div>
            </div>
        </div> --}}
        <div class="row">
           <div class="col-sm-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                <div class="row">
                    <div class="col-6 lg">
                        <b><h2 class="card-title text-warning"> {{$netData['vender']}} </h2></b>
                    </div>

                    <div class="col-6 lg" >
                    <b style="float:right">
                      Total Curunt Balance:&nbsp;&nbsp;&nbsp;
                        <i class="fa fa-arrow-up sm" style="color:red"></i>&nbsp;
                        {{number_format($netData['latestBalance'],2)}}
                    </b>
                    </div>
                </div>
             </div>
            </div>
            </div>


            <div class="row">
                <div class="pr-1">
                    <div class="card">
                        <div class="card-body">
                            <P>Individual Owner Balance on <i class="text-warning pull-right">{{$netData['vender']}}</i></P>
                            <div class="row">
                                <div class="col-5">
                                    <b>Owner</b>
                                </div>
                                <div class="col-5">
                                   <b>Balance</b>
                                </div>
                                <div class="col-2">

                                </div>
                            </div>
                            <p>________________________________________</p>
                            @forelse($netData['owner_balance'] as $ob)
                            <div class="row">
                                <div class="col-5">
                                    {{$ob['owner']}}
                                </div>
                                <div class="col-5">
                                    @if($ob['balance'] > 0)
                                        <i class="fa fa-arrow-up sm" style="color:red"></i>&nbsp;
                                    @else
                                        <i class="fa fa-arrow-down sm" style="color:green"></i>&nbsp;
                                    @endif
                                    &nbsp;

                                    {{number_format($ob['balance'],2)}}

                                </div>

                                <div class="col-2">
                                    <a href="" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-lg-reciept-{{$ob['owner_id']}}">Pay</a>
                                </div>
                            </div>
                            <hr>

                            <div class="modal fade" id="modal-lg-reciept-{{$ob['owner_id']}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Payment </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                            <!-- left column -->
                                            <div class="col-md-12">
                                                <!-- jquery validation -->
                                                <div class="card card-primary">
                                                    <form  action="/purchasePayment-{{$ob['owner_id']}}-{{$netData['id']}}" method="POST" id="quickForm" enctype="multipart/form-data">
                                                        @csrf
                                                    <div class="card-header">
                                                        {{-- <h3 class="card-title">Payment <small>Information</small></h3> --}}
                                                        <b>TO <i class="text-info">{{$netData['vender']}}</i> By <i class="text-success">{{$ob['owner']}}</i></b>
                                                        <input type="date" name="date" class="form-control col-3" value="{{Carbon\Carbon::now()->toDateString()}}" style="float: right;" required>
                                                         <label style="float: right;"> Date &nbsp;&nbsp;</label>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-4" >
                                                                <div class="form-group">
                                                                  <label for="exampleInputEmail1">Payment Type</label>
                                                                   <select name="payment_type" class="form-control" id="cheque_{{$ob['owner_id']}}" onchange="chequeNumber({{$ob['owner_id']}})" required>
                                                                    <option value="">Select</option>
                                                                    <option value="CAD/LC/TT">CAD/LC/TT</option>
                                                                    <option value="Direct Paymen">Direct Paymen</option>
                                                                   </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label >Amount</label>
                                                                    <input type="number" step="any" min="0"  name="amount" class="form-control"  value="{{$ob['balance']}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label >Discount</label>
                                                                    <input type="number" step="any" name="discount" min="0" class="form-control"  value="0" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="chequedate_{{$ob['owner_id']}}" style="display: none">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label >On Bank</label>
                                                                        <a  data-toggle="modal" data-target="#modal-md" style='color:rgb(98, 255, 0)'>
                                                                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                        </a>
                                                                        <select name="bank" class="form-control" >
                                                                            <option value="">Select</option>
                                                                           @forelse ($banks as $bank )
                                                                            <option value="{{$bank->BankName}}">{{$bank->BankName}} &nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; {{$bank->AccountNumber}}</option>
                                                                           @empty
                                                                           @endforelse
                                                                           </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label >RefrenceNo</label>
                                                                        <input type="text" name="refrence_no" class="form-control"  placeholder="Cheque Number" >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label >Related Docs</label>
                                                                    <input type="file" name="docs"  accept="application/pdf" class="form-control" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label >Remark <sub>Optional</sub></label>
                                                                    <textarea name="remark" class="form-control" placeholder="Remarks"></textarea>
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
                                                </div>

                                               <!--/.col (right) -->
                                              </div>
                                            <!-- /.row -->
                                           </div><!-- /.container-fluid -->

                                        </div>
                                     </div>
                                    <!-- /.modal-content -->
                                   </div>
                                <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

                            @empty
                            @endforelse
                        </div>
                    </div>

                  </div>
              <div class="card sm">
                <div class="card-body">
                    {{-- <div class="p-2" style="float: right"> {{ $items->links() }}</div> --}}
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Date</th>
                      <th>PaidBy</th>
                      <th>Debit</th>
                      <th>Credit</th>
                      <th>Balance</th>
                      <th></th>

                    </tr>
                    </thead>
                    <tbody id='list'>
                        @php
                            $no = 0;
                        @endphp
                        @forelse ($netData['ledger'] as $ledger)
                        @php
                            $no = $no + 1;
                        @endphp
                         <tr>
                            <td>{{$no}}</td>
                            <td>{{$ledger['date']}}</td>
                            <td>{{$ledger['owner']}}</td>
                            <td style="background-color: red">{{number_format($ledger['debit'],2)}}</td>
                            <td style="background-color: green">{{number_format($ledger['credit'],2)}}</td>
                            <td><b><i>{{number_format($ledger['balance'],2)}}</i></b></td>
                            <td>
                            @if ($ledger['debit'] == 0)
                                <a href="" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modal-lg-payment-{{$ledger['id']}}">Detail</a>
                            @endif
                            </td>

                        </tr>

                        @forelse ($purchasPayments as $purchasPayment)
                        @if ($purchasPayment->PL_id == $ledger['id'])
                            <div class="modal fade" id="modal-lg-payment-{{$purchasPayment->PL_id}}">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"> <i class="text-info">{{$netData['vender']}}</i> By <i class="text-success">{{$ledger['owner']}}</i></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                        <!-- left column -->
                                        <div class="col-md-12">
                                            <!-- jquery validation -->
                                            <div class="card card-primary">
                                                <form  action="/editPurchasePayment-{{$purchasPayment->id}}" method="POST" id="quickForm" enctype="multipart/form-data">
                                                    @csrf
                                                <div class="">
                                                    {{-- <h3 class="card-title">Payment <small>Information</small></h3> --}}

                                                    <input type="date" name="date" class="form-control col-3 p-2" style="float: right;" value="{{$purchasPayment->date}}" required>
                                                    <label style="float: right;"> Date &nbsp;&nbsp;</label>

                                                </div>

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-4" >
                                                            <div class="form-group">
                                                              <label for="exampleInputEmail1">Payment Type</label>
                                                               <select name="payment_type" class="form-control" required>
                                                                <option value="{{$purchasPayment->payment_type}}">{{$purchasPayment->payment_type}}</option>
                                                                <option value="CAD/LC/TT">CAD/LC/TT</option>
                                                                <option value="Direct Paymen">Direct Paymen</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Amount</label>
                                                                <input type="number" step="any" min="0"  name="amount" class="form-control"  value="{{$purchasPayment->amount}}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Discount</label>
                                                                <input type="number" step="any" name="discount" min="0" class="form-control"  value="{{$purchasPayment->discount}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >OnBank</label>
                                                                    <a  data-toggle="modal" data-target="#modal-md" style='color:rgb(98, 255, 0)'>
                                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                                    </a>
                                                                    <select name="bank" class="form-control" >
                                                                        <option value="{{$purchasPayment->BnakName}}">{{$purchasPayment->BankName}}</option>
                                                                       @forelse ($banks as $bank )
                                                                        <option value="{{$bank->BankName}}">{{$bank->BankName}} &nbsp;&nbsp; | &nbsp;&nbsp;&nbsp;&nbsp; {{$bank->AccountNumber}}</option>
                                                                       @empty
                                                                       @endforelse
                                                                       </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >RefrenceNo</label>
                                                                    <input type="text" name="refrence_no" class="form-control" value="{{$purchasPayment->refrence_no}}"  placeholder="Cheque Number" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >Related Docs</label>
                                                                <input type="file" accept="application/pdf" name="docs" class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label >Docs</label>

                                                              <p>Open Transaction Related file <a href="/{{$purchasPayment->Docs}}">Here</a>.</p>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label >Remark <sub>Optional</sub></label>
                                                                <textarea name="remark" class="form-control" placeholder="Remarks">{{$purchasPayment->Remarks}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    {{-- <embed src="" width="800px" height="2100px" /> --}}

                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <a href="deletePurchasePayment-{{$purchasPayment->id}}"class="btn btn-danger" onclick="return confirm('Are you sure you ? after delete this transaction there is no way to  recover it !!!');">Delete</a>
                                                        <button type="submit" class="btn btn-success swalDefaultSuccess" onclick="return confirm('Are you sure you ? you wanna save changes');">Save Changes</button>
                                                    </div>
                                                </form>

                                            </div>
                                            <!-- /.card -->
                                            </div>

                                           <!--/.col (right) -->
                                          </div>
                                        <!-- /.row -->
                                       </div><!-- /.container-fluid -->

                                    </div>
                                 </div>
                                <!-- /.modal-content -->
                               </div>
                            <!-- /.modal-dialog -->
                            </div>
                             @endif
                            @empty
                            @endforelse
                        @empty
                        @endforelse($items as $item)
                    </tbody>
                  </table>

              {{-- <div class="p-2" style="float: right"> {{ $items->links("pagination::bootstrap-4") }}</div> --}}


                </div>
                <!-- /.card-body -->
              </div>
        <!-- /.card -->


            </div>
        <!-- /.modal-dialog -->

        </div>
    </div>
    <!-- /.modal -->



    <div class="modal fade" id="modal-md">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ADD Bank</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Bank <small>Information</small></h3>
                            </div>
                            <form  action="/bank" method="POST" id="quickForm" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label >Bank Name</label>
                                            <input type="text" name="bankname" class="form-control" placeholder="Bank Name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label >Account Number <small>opt</small> </label>
                                            <input type="text"  name="account" class="form-control" placeholder="Account Number">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label >Label <small>opt</small></label>
                                            <input type="text" name="label" class="form-control" placeholder="Label To Your reference">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success swalDefaultSuccess" >Save</button>
                                </div>
                            </form>

                        </div>
                        <!-- /.card -->
                        </div>

                       <!--/.col (right) -->
                      </div>
                    <!-- /.row -->
                   </div><!-- /.container-fluid -->

                </div>
             </div>
            <!-- /.modal-content -->
           </div>
        <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
  </section>
  <script>
    function chequeNumber(id){
        var type = $('#cheque_'+id).val();
        console.log(type);
        if(type == 'CAD/LC/TT'){
           document.getElementById('chequedate_'+id).style.display = 'block';
        }else{
           document.getElementById('chequedate_'+id).style.display = 'none';

        }
    }
</script>

@endsection

