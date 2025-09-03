@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 p-2 d-none d-xl-block">
                <h4 class="text-center">Order List</h4>
                <p class=" text-sm text-startr">
                    This List is Approved by the Store Manager to be Issued.
                    the Storekeeper should fill out the following form and make issue
                </p>
            </div>
            <div class="col-10">
              <div class="card">
                <div class="card-body">
                    {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                  <table id="example2" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>OrderDate</th>
                      <th>VoucherNumber</th>
                      <th>CustomerName</th>
                      <th>SalesFrom</th>
                      <th>SalesPerson</th>
                      <th>ApprovedOn</th>
                      <th>View</th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                        @if(count($salesOrders) > 0)
                        @php
                            $no = 0;
                        @endphp
                        @foreach($salesOrders as $salesOrder)
                        @php
                            $no = $no + 1;
                        @endphp
                         <tr>
                            <td>{{$no}}</td>
                            <td>{{$salesOrder->created_at->diffForHumans()}}</td>
                            <td>{{$salesOrder->reference_number}}</td>
                            <td>
                                @forelse ($customers as $customer)
                                    @if($customer->id == $salesOrder->customer_id)
                                    {{$customer->name}}
                                    @endif
                                @empty
                                @endforelse
                            </td>
                            <td>
                                @forelse ($businessLocations as $businessLocation)
                                    @if($businessLocation->id == $salesOrder->location_id)
                                    {{$businessLocation->name}}
                                    @endif
                                @empty
                                @endforelse
                            </td>
                            <td>{{$salesOrder->sales_person}}</td>
                            <td>{{$salesOrder->updated_at->toDateString()}}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg-view-{{$salesOrder->id}}">
                                        SetIssue
                                 </button>
                              {{-- <a href="/sales-invoice-{{$salesOrder->id}}" rel="noopener" target="_blank" class="btn btn-warning"><i class="fas fa-print"></i> Print</a>
                              <a type="button" class="btn btn-danger btn-sm" href="delete-sales-order-{{$salesOrder->id}}" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-trash"></i>
                              </a> --}}
                            </td>
                        </tr>
                          <!-- /.card -->

                          @endforeach
                          @else
                          @endif
                      </tbody>
                    </table>
                {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links("pagination::bootstrap-4") }}</div> --}}
                </div>
                  <!-- /.card-body -->
            </div>
            </div>

            <div class="col-2 p-2 d-none d-xl-block">
                <h3 class="text-center">Issued List</h3>
                <p class=" text-sm text-startr">
                    This List is Approved by the Store Manager and Set Issued By Storekeeper
                     issue History.
                </p>
            </div>
            <div class="col-10">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>IssueDate</th>
                      {{-- <th>VoucherNumber</th> --}}
                      <th>Code#</th>
                      <th>IssuedBy</th>
                      <th>IssueFrom</th>
                      <th>IssueTo</th>
                      <th>Quantity</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody id='list'>
                        @if(count($issues) > 0)
                        @php
                            $no = 0;
                        @endphp
                        @foreach($issues as $issue)
                        @php
                            $no = $no + 1;
                        @endphp
                         <tr>
                            <td>{{$no}}</td>
                            <td>{{$issue->date }} <small class="text-warning">{{$issue->created_at->hour.':'.$issue->created_at->minute}}</small></td>
                            {{-- <td>{{$issue->voucher_number }}</td> --}}
                            <td style="color: greenyellow">{{$issue->id }}</td>
                            <td>
                                @php
                                    $user =  App\Models\User::where('id',$issue->issued_by)->first();
                                @endphp
                                {{$user->name}}
                            </td>
                            <td>
                                @forelse ($businessLocations as $businessLocation)
                                    @if($businessLocation->id == $issue->issued_from)
                                    {{$businessLocation->name}}
                                    @endif
                                @empty
                                @endforelse
                            </td>
                            <td>
                                @forelse ($businessLocations as $businessLocation)
                                    @if($businessLocation->id == $issue->issued_to)
                                    {{$businessLocation->name}}
                                    @endif
                                @empty
                                @endforelse
                            </td>

                            <td>{{$issue->issuing_detail_id}}</td>
                            <td>
                                @if ($issue->status == 'Pending')
                                  <p class="text-warning">{{$issue->status}}</p>
                                @else
                                <p class="text-success">{{$issue->status}}</p>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg-view-d{{$issue->id}}">
                                        <i class="fas fa-eye"></i>
                                 </button>
                                 @php
                                     $thisOrder = App\Models\SalesOrder::where('reference_number', $issue->voucher_number)->first();
                                 @endphp
                              <a href="/sales-invoice-{{$thisOrder->id}}" rel="noopener" target="_blank" class="btn btn-warning"><i class="fas fa-print"></i></a>
                              {{-- <a type="button" class="btn btn-warning btn-sm" href="sales-invoice-{{$salesOrder->id}}" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-print"></i>
                              </a> --}}
                            </td>
                        </tr>
                          <!-- /.card -->

                          <div class="modal fade" id="modal-lg-view-d{{$issue->id}}">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">{{$issue->voucher_number}}</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-1">
                                            <small>#</small>
                                        </div>
                                        <div class="col-3">
                                            ItemName
                                        </div>
                                        <div class="col-2">
                                            code
                                        </div>
                                        <div class="col-3">
                                           Owner
                                        </div>
                                        <div class="col-3">
                                            Quantity
                                        </div>

                                    </div>
                                    <hr>
                                    @php
                                       $total = 0;
                                       $n = 0;
                                    @endphp
                                    @forelse ($issue_detail as $issue_d)
                                     @if($issue_d->issuing_id == $issue->id)
                                     @php
                                       $total = $total + $issue_d->qauntity;
                                       $n = $n + 1;
                                     @endphp
                                        <div class="row">
                                             <div class="col-1">
                                                <small>{{$n}}</small>
                                             </div>
                                             @php
                                             $item_d_name =  App\Models\Item::find($issue_d->item_id);
                                            @endphp
                                            <div class="col-3">
                                                <small>{{$item_d_name->item_name}}</small>
                                             </div>

                                             <div class="col-2">
                                                <a href=""><b>{{$issue_d->item_name}}</b></a>
                                             </div>

                                             <div class="col-3">
                                             @foreach ($owners as $owner)
                                                @if ($owner->id == $issue_d->owner_id)
                                                    {{$owner->name}}
                                                @endif
                                             @endforeach
                                             </div>
                                             <div class="col-3">
                                                {{number_format($issue_d->qauntity)}}
                                             </div>
                                        </div>
                                        <br>

                                     @endif
                                    @empty

                                    @endforelse
                                    {{-- <div class="row no-print">
                                        <div class="col-12">
                                          <a  rel="noopener" class="btn btn-danger" data-toggle="modal" data-target="#modal-lg-reject-{{$salesOrder->id}}">Reject</a>
                                          <a  href="acceptOrder-{{$salesOrder->id}}"class="btn btn-success float-right"> Accept</a>

                                        </div>
                                    </div> --}}
                                </div>

                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>

                          @endforeach
                          @else
                          @endif
                      </tbody>
                    </table>
                {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links("pagination::bootstrap-4") }}</div> --}}
                </div>
                  <!-- /.card-body -->
            </div>
            </div>
              <!-- /.card -->
            @forelse ($salesOrders as $salesOrder)
              <div class="modal fade" id="modal-lg-view-{{$salesOrder->id}}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Store Issue Voucher </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <section class="content">
                                    <div class="container-fluid">
                                      <div class="row">
                                        <div class="col-12">
                                          <form method="POST" action="add-issuing-{{$salesOrder->id}}">
                                          @csrf
                                          <!-- Main content -->
                                          <div class="invoice p-3 mb-3">
                                            <!-- title row -->
                                            <div class="row">
                                              <div class="col-12">
                                                <h4>
                                                  <i class="fas fa-globe"></i> UKAZ, Inc.
                                                  <small class="float-right">Date : {{ \Carbon\Carbon::now()->toFormattedDateString() }}</small>
                                                </h4>
                                              </div>
                                              <!-- /.col -->
                                            </div>
                                            <!-- info row -->
                                            <div class="row invoice-info">
                                                <div class="col-sm-4 invoice-col">
                                                  <address>
                                                    {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                    Customer
                                                    @php
                                                        $cust = App\Models\Customer::find($salesOrder->customer_id);
                                                    @endphp
                                                    <input type="text" name="issue_date" value="{{ $cust->name }}" readonly class="form-control" required>
                                                    <input type="hidden" name="issue_date" value="{{ Carbon\Carbon::now()->toDateString() }}" class="form-control" required>

                                                    {{-- <br> --}}
                                                    Invoice No
                                                    <input type="text" readonly name="refrence_no" class="form-control" value=" {{ $salesOrder->reference_number }}"  >
                                                  </address>
                                                </div>

                                                <!-- /.col -->
                                                <div class="col-sm-1 invoice-col">

                                                </div>
                                                <!-- /.col -->
                                                 <input type="hidden" id="location" name="to" value="{{$salesOrder->location_id }}">
                                                <div class="col-sm-7 invoice-col">
                                                  <div class="row">
                                                      <div class="col-12">
                                                          Order From
                                                            {{-- <option value="">Select</option> --}}
                                                            @forelse ($businessLocations as $businessLocation)
                                                                @if ($salesOrder->location_id == $businessLocation->id)
                                                               <input type="text" readonly name="toName" class="form-control" value=" {{ $businessLocation->name }}" >
                                                                @endif
                                                            @empty
                                                            @endforelse
                                                      </div>
                                                  </div>

                                                    From &nbsp; &nbsp;
                                                  <address>
                                                      {{-- <select name="from" id='fromLocation' class="form-control" id='Ownloc' required onchange="enableOwner()"> --}}
                                                        <select name="from" id='fromLocation' class="form-control" id='Ownloc' required>
                                                          {{-- <option value="">Select</option> --}}
                                                          @forelse ($warehouses as $businessLocation)
                                                                <option value="{{$businessLocation->id}}">{{$businessLocation->name}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                  </address>
                                                </div>
                                                <!-- /.col -->
                                              </div>
                                              <!-- /.row -->

                                            <!-- Table row -->
                                            <div class="row">

                                              <div class="col-12 table-responsive">

                                                <table class="table table-striped">
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>P-Code</th>
                                                        <th>Quantity</th>
                                                        <th>ItemOwner</th>
                                                        {{-- <th>CurnetBalance</th> --}}
                                                        <th></th>
                                                    </tr>
                                                  <tbody id="add_items_{{$salesOrder->id}}">
                                                    @forelse ($salesOrderDetails as $salesOrderDetail)
                                                    @if($salesOrderDetail->sales_order_id == $salesOrder->id)
                                                    @if($salesOrderDetail->owner_id != 666)
                                                    <tr>
                                                        <td style="width:40%;">
                                                         @php
                                                            $item =  App\Models\Item::find($salesOrderDetail->item_id);
                                                         @endphp
                                                         <input type="text" class="form-control" value="{{ $item->item_name }}" />
                                                        </td>
                                                        <td style="width:20%;">
                                                            <input type="hidden" id="item_id_{{$salesOrderDetail->id}}" name="addmore[{{$salesOrderDetail->id}}][item_id]" value="{{$salesOrderDetail->item_id}}">
                                                            <input type="text"  id='item_{{$salesOrderDetail->id}}' name="addmore[{{$salesOrderDetail->id}}][item_name]" value="{{$salesOrderDetail->item_name}}" class="form-control input-group-sm" readonly required>
                                                        </td>
                                                        <td>
                                                           <input type="number" min="0" id='quantity_{{$salesOrderDetail->id}}' name="addmore[{{$salesOrderDetail->id}}][quantity]" onchange="getItemOwnerBalance({{$salesOrderDetail->item_id}},{{$salesOrderDetail->id}})" value="{{$salesOrderDetail->quantity}}" class="form-control input-group-sm" required>
                                                        </td>
                                                        <td>
                                                        <select id='owner_{{$salesOrderDetail->id}}' name="addmore[{{$salesOrderDetail->id}}][owner]" onchange="getItemOwnerBalance({{$salesOrderDetail->item_id}},{{$salesOrderDetail->id}})" class="form-control owner" style="width:180px;" required >
                                                               {{-- <option value="">Owner</option> --}}
                                                            @forelse ($owners as $owner)
                                                            <option value="{{$owner->id}}">{{$owner->name}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                        </td>
                                                        <td>

                                                            <input type="hidden" id="stock_blance_{{$salesOrderDetail->id}}" class="form-control sub" value=""  class="form-control" placeholder="Stock Balance" disabled /></td>
                                                      </tr>
                                                    @endif
                                                    @endif
                                                   @empty

                                                   @endforelse
                                                  </tbody>

                                                </table>
                                                {{-- <a href="#" id="add_new_items_{{$salesOrder->id}}"  class="btn btn-success float-right" style="padding:5px; text-decoration:none">

                                                  <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                </a> --}}

                                              </div><hr><br>
                                              <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <div class="row" id='calculate'>
                                              <!-- accepted payments column -->
                                              <div class="col-7">


                                              </div>
                                              <!-- /.col -->
                                              <div class="col-5">
                                                {{-- <p class="lead" style="float:right;">Total Due Amount</p> --}}
                                                <p></p>
                                                <div class="table-responsive" style="float:right;">
                                                  <table class="table">
                                                    <tr>
                                                      {{-- <th>Total Item Qyt:</th>
                                                      <td > <i id="tot" name='Gtotal'></i></td> --}}
                                                    </tr>
                                                  </table>
                                                </div>
                                              </div>
                                              <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <!-- this row will not appear when printing -->
                                            <div class="row no-print">
                                              <div class="col-12">
                                                <a href="returnIssue-{{ $salesOrder->id }}" class="btn btn-warning"><i class="fas fa-back-arrow"></i> Return Issue</a>
                                                <button type="submit" class="btn btn-success float-right"> Save
                                                </button>
                                                {{-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                                  <i class="fas fa-download"></i> Generate PDF
                                                </button> --}}
                                              </div>
                                            </div>
                                          </div>
                                          <!-- /.invoice -->
                                        </form>
                                        </div><!-- /.col -->
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
        </div>
    </div>
</section>

<script>
    function getItemOwnerBalance(item,id){
        var owner = document.getElementById('owner_'+id).value;
        var location =  document.getElementById('fromLocation').value;
        // var owner = document.getElementsByClassName("owner_"+id).value;
        var quantity = document.getElementById('quantity_'+id).value;

        if(owner != '' && location !== ''){
            $.ajax({
                type: "POST",
                url: "{{url('getItemOwnerBalance')}}",
                dataType:'json',
                data:{
                    '_token':'{{ csrf_token() }}',
                        item:item,
                        owner:owner,
                        location:location,
                    },
                success: function (result) {
                    if(result != null){
                        document.getElementById("quantity_"+id).max = result.quantity;
                        document.getElementById('stock_blance_'+id).value = result.quantity - quantity;
                    }else{
                        document.getElementById("owner_"+id).value = '';
                        document.getElementById("stock_blance_"+id).value = '';

                        alert("Have No Such Quantity For This Paticular Owner on this From Locationn !!!");
                    }
                }

            });
        }
    }

</script>
@forelse ($salesOrders as $salesOrder)
  <script>
   var i = 0;
    $("#add_new_items_{{$salesOrder->id}}").click(function () {
        ++i;
        if(i==1){
            $("#add_items_{{$salesOrder->id}}").append(`
            <tr>

                <th class="text-success">Supplement</th>

            </tr>
            <tr>
                <th>Location</th>
                <th>Owner</th>
                <th>ProductCode</th>
                <th>Qyt</th>
                <th></th>
            </tr>
             `);
        }
        $("#add_items_{{$salesOrder->id}}").append(`
        <tr>
            <td>
            <select id='location_`+i+`' name="addmoreSup[`+i+`][location]"  class="form-control" style="width:180px;" required >
                <option value="">Location</option>
                @forelse ($businessLocations as $businessLocation)
                <option value="{{$businessLocation->id}}">{{$businessLocation->name}}</option>
                @empty
                @endforelse
            </select>

            </td>
            <td>
            <select id='owner_`+i+`' name="addmoreSup[`+i+`][owner]"  class="form-control" style="width:180px;" required >
                <option value="">Owner</option>
                @forelse ($owners as $owner)
                <option value="{{$owner->id}}">{{$owner->name}}</option>
                @empty
                @endforelse
            </select>
            </td>
            <td style="width: 210px;">
                <div class="row">
                    <div class="dropdown">
                        <div id="myDropdown_`+i+`" class="dropdown-content">
                            <input type="hidden" id="item_id_s`+ i +`" name="addmoreSup[`+ i +`][item_id]">
                            <input type="text" autoComplete="off" placeholder="Search Item..." id="myInput_`+i+`" onclick="myFunction(`+ i +`)" onkeyup="filterFunction(`+i+`)" name="addmoreSup[`+i+`][item_name]"  class="form-control" required>
                            <div id="items_`+i+`">
                                <ul class="nav nav-pills nav-sidebar flex-column" id="item_list_`+i+`" data-widget="treeview" role="menu" data-accordion="false">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <input type="number" min="1" id='quantity_s`+ i +`' value='0' name="addmoreSup[`+i+`][quantity]"  class="form-control input-group-sm" required>
            </td>

            <td>
            <button type="button" class=" remove-tr"><B style='color:red'> X </B></button>
            </td>
        </tr>
        `);
    });

    $(document).on('click', '.remove-tr', function () {
          $(this).parents('tr').remove();
    });

  </script>
@empty

@endforelse

<script>
    function enableOwner(){
        var element = document.getElementsByClassName("owner");
         for (var i = 0; i < element.length; i++){
                element[i].disabled = false;
           }
    }
    function myFunction(no) {
            var owner_id = document.getElementById("owner_"+no).value;
            var location_id = document.getElementById("fromLocation").value;
            var quantity = document.getElementById('quantity_s'+no).value;
            if(location_id != '' && owner_id != ''){
            $.ajax({
                type: "POST",
                url: "{{url('getItemForIssue')}}",
                dataType:'json',
                data:{
                    '_token':'{{ csrf_token() }}',
                        owner_id:owner_id,
                        location_id:location_id,
                    },
                success: function (result) {
                    console.log(result);
                    var rowData = '';
                    $('#item_list_'+no).html('');
                    $.each(result, function(index,value){
                        // no = no+1;
                        rowData = `
                           <option class="nav-link" id="item_${value.id}" onclick="selectedItem(${value.id},${value.item_id},${value.quantity},${no})">${value.item_code}</option>
                        `;

                        $('#item_list_'+no).append(rowData);
                        // document.getElementById('stock_blance_'+no).value = value.quantity -  document.getElementById('quantity_'+no).value;
                        document.getElementById('quantity_s'+no).max = value.quantity;
                    // getItemOwnerBalance(no,value.id,location_id);
                    });
                },

            });
            }
           document.getElementById("myDropdown_"+no).classList.toggle("show");
    }
    function filterFunction(no) {
      var input, filter, ul, li, a, i;
      input = document.getElementById("myInput_"+no);
      document.getElementById("items_"+no).style.display = 'block';

      filter = input.value.toUpperCase();
      div = document.getElementById("myDropdown_"+no);
      a = div.getElementsByTagName("option");
      for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          a[i].style.display = "";
        } else {
          a[i].style.display = "none";
        }
      }
    }

    function selectedItem(id,item,qyt,no){
         document.getElementById("items_"+no).style.display = 'none';
         document.getElementById('item_id_s'+no).value = item;
        //  var location_id = document.getElementById("location").value;
         document.getElementById('quantity_s'+no).max = qyt;
         document.getElementById("myInput_"+no).value =  document.getElementById("item_"+id).value;

        }
</script>
@endsection
