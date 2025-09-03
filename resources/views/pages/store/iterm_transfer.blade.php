@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header">
              <div class="row">
                  <div class="col-6 lg">
                    <div class="pl-3"><b> requisitions : {{0 }}</b></div>
                  </div>
                  <div class="col-6 lg">
                      <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                          requisition
                        </button>
                  </div>
              </div>
           </div>
      </div>
      </div>
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
                                    <a href="#" class="btn btn-danger btn-sm">
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
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Make New requisition</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <div class="card card-default">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="requisition" method="POST">
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
                                                <div class="col-sm-5 invoice-col">
                                                  <address>
                                                    {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                    requisition From
                                                    <div class="form-group">
                                                        <select name="request_from"  class="form-control" id="location" required>
                                                            <option value="">Select Here</option>
                                                                @forelse ($locations as $location)
                                                                   <option value="{{$location->name}}">{{$location->name}}</option>
                                                                @empty
                                                                <option value="">Empty Location !</option>
                                                                @endforelse
                                                        </select>
                                                    </div>

                                                  </address>
                                                </div>
                                                <div class="col-sm-2 invoice-col">

                                                  </div>
                                                  <div class="col-sm-5 invoice-col">
                                                    <address>
                                                      {{-- <strong>Company Name, Inc.</strong><br> --}}
                                                      requisitiond By
                                                      <div class="form-group">
                                                        <input type="text" readonly value="{{Auth::user()->name}}" name="shipped_by" class="form-control" required>
                                                    </div>

                                            </div>
                                            <div class="row">

                                                <div class="col-12 table-responsive">

                                                  <table class="table table-striped">
                                                      <tr>
                                                          <th>ProductNameCode</th>
                                                          <th>Quantity</th>
                                                          {{-- <th>CurrntBalance</th> --}}
                                                          <th></th>
                                                      </tr>
                                                    <tbody id="add_items">
                                                      <tr>
                                                        <td style="width: 250px;">
                                                            <div class="row">
                                                                <div class="dropdown">
                                                                    <div id="myDropdown_0" class="dropdown-content">
                                                                        <input type="text" autoComplete="off" placeholder="Search.." id="myInput_0" onclick="myFunction(0)" onkeyup="filterFunction(0)" name="addmore[0][search_item]"  class="form-control">
                                                                        <div id="items_0" style="display: none">
                                                                            <ul class="nav nav-pills nav-sidebar flex-column" id="item_list_0" data-widget="treeview" role="menu" data-accordion="false">

                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="item_id_0" name="addmore[0][item_id]" value="">
                                                         </td>
                                                          <td>
                                                             <input type="number"  min="0" id='quantity_0' name="addmore[0][quantity]" placeholder="Quantity" class="form-control input-group-sm" required>
                                                          </td>
                                                          {{-- <td>
                                                            <input type="number" min="0" id='remain_0' readonly value="0" class="form-control input-group-sm">
                                                         </td> --}}
                                                        </tr>
                                                    </tbody>

                                                  </table>
                                                  <a href="#" id="add_new_items"  class="btn btn-success float-right" style="padding:5px; text-decoration:none">

                                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                  </a>

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
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
     var i = 0;
    var subTotal = [];
    $("#add_new_items").click(function () {
        ++i;
        $("#add_items").append(`
        <tr>
            <td style="width: 250px;">
                <div class="row">
                    <div class="dropdown">
                        <div id="myDropdown_`+ i +`" class="dropdown-content">
                            <input type="text" autoComplete="off" placeholder="Search.." id="myInput_`+ i +`" onclick="myFunction(`+ i +`)" onkeyup="filterFunction(`+ i +`)" name="addmore[`+ i +`][search_item]"  class="form-control">
                            <div id="items_`+ i +`" style="display: none">
                                <ul class="nav nav-pills nav-sidebar flex-column" id="item_list_`+ i +`" data-widget="treeview" role="menu" data-accordion="false">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="item_id_`+ i +`" name="addmore[`+ i +`][item_id]" value="">
         </td>
          <td>
             <input type="number" min="0" id='quantity_`+ i +`'  name="addmore[`+ i +`][quantity]" placeholder="Quantity" class="form-control input-group-sm" required>
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

    function myFunction(no) {
            $.ajax({
                type: "POST",
                url: "{{url('getItemForSale')}}",
                dataType:'json',
                data:{
                    '_token':'{{ csrf_token() }}',
                    },
                success: function (result) {
                    var rowData = '';
                    // var no = 0;
                    $('#item_list_'+no).html('');
                    $.each(result, function(index,value){
                        // no = no+1;
                        rowData = `
                           <option class="nav-link" id="item_${value.id}" onclick="selectedItem(${value.id},${no},${value.quantity})">${value.item_name} &nbsp; | ${value.product_code}</option>
                        `;

                        $('#item_list_'+no).append(rowData);


                    });
                },

            });

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

    function selectedItem(id,no,quantity){

         document.getElementById("items_"+no).style.display = 'none';
         document.getElementById("myInput_"+no).value =  document.getElementById("item_"+id).value;
         document.getElementById("item_id_"+no).value =  id;
         document.getElementById("remain_"+no).value =  quantity;
         document.getElementById("quantity_"+no).setAttribute("max",document.getElementById("remain_"+no).value);;

        }
    function chageQyt(i){
       var qyt =  document.getElementById("quantity_"+i).value;
       var rem = document.getElementById("remain_"+i).value;
       document.getElementById("remain_"+i).value = rem - qyt;
    }
</script>
@endsection
