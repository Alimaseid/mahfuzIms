@extends('inc.frame')

@section('content')
<section class="content">
    <div class="container-fluid">
     <div class="row pt-1">
         <div class="col-md-6">
            <form action="daily-customer-report" method="POST">
                @csrf
             <div class="row">

               <div class="col-sm-4">
                <label for="">Date</label>
                  <input type="date" name='report_date'class="form-control" value="{{ $date }}" required>
               </div>
               <div class="col-sm-2">
                <hr>
                <button type="submit" class="btn btn-sm btn-warning ">Go</button>
             </div>
             </div>
            </form>
         </div>
         <div class="col-2">
         </div>
         <div class="col-md-4 pt-3" >
               <table class="table table-borderless table-sm">
               <thead>
               </thead>
               <tbody>
                {{-- <tr>
                    <th >Sales Amount</th>
                    <td >ETB {{0}}</td>
                 </tr> --}}
                 <tr>
                  <th>Sales Tax</th>
                  <td >ETB {{0}}</td>
               </tr>
               </tbody>
               <tfoot>
                <tr class="text-warning">
                    <th>Total Sales</th>
                    <td >ETB {{number_format($dialyTotal,2)}}</td>
                 </tr>
               </tfoot>
             </table>
         </div>
     </div>
        <div class="row">
           <div class="col-md-12">
            <h3></h3>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr style="background-color: rgb(3, 3, 32)">
                  <th>CustomerName</th>
                  <th>TotalSalesAmount</th>
                  <th style="width:70%">Description</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                     <tr>
                        @forelse ($sale as $salesDetail)
                            <td>{{ $salesDetail->customer->name }}</td>
                            <td>{{ number_format($sale->sum('grand_total'),2) }}</td>
                            @break
                        @empty
                        @endforelse
                        <td>
                         @forelse ($sale as $salesDetail)
                            @forelse ($salesDetail->salesDetails as $detail)
                            <small>{{ $detail->item->item_name }}({{ number_format($detail->quantity) }} x {{ number_format($detail->amount / $detail->quantity )}}), &nbsp;&nbsp;</small>
                            @empty
                            @endforelse
                        @empty
                        @endforelse
                        </td>
                      </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
           </div>
        </div>
    </div>

</section>

@endsection
