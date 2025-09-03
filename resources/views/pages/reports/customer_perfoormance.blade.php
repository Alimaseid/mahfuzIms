@extends('inc.frame')

@section('content')
<section class="content">
    <div class="container-fluid">
     <div class="row pt-1">
        <div class="col-md-2"></div>
         <div class="col-md-10">
            <form action="customerPerformance" method="POST">
             @csrf
             <div class="row">
                <div class="col-sm-4">
                    <h5 class="text-warning">Customer Performance</h5>
                </div>
               <div class="col-sm-1">
                  <label for="" style="float:right">From</label>
               </div>
                <div class="col-sm-2">
                  <input type="date" name="from" class="form-control" value="{{$from}}" max="{{Carbon\Carbon::now()->subDay()->toDateString()}}">
               </div>
               <div class="col-sm-1">
                <label for="" style="float:right">To</label>
             </div>
               <div class="col-sm-2">
                  <input type="date"  name="to" class="form-control" value="{{$to}}" max="{{Carbon\Carbon::now()->toDateString()}}">
               </div>
               <div class="col-sm-2">
                <button type="submit" class="btn btn-sm btn-warning">Go</button>
             </div>
             </div>
            </form>
         </div>
     </div>
        <div class="row">
           <div class="col-md-12">
            <h3></h3>

            <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr style="background-color: rgb(3, 3, 32)">
                  <th>No</th>
                  <th>CustomeName</th>
                  <th >Phone</th>
                  <th>Quantity(avg)</th>
                  <th>Total<small>(Qyt)</small></th>
                  <th>TotalAmount</th>
                  <th>TRP</th>
                </tr>
                </thead>
                <tbody>
                     @php $no = 0;@endphp
                     @forelse ($performance_final_summery as $pfs)
                     @php ++$no;@endphp
                        <tr>
                           <td>{{$no}}</td>
                           <td>{{$pfs['customer_name']}}</td>
                            <td>{{$pfs['phone']}}</td>
                            <td>{{number_format(100 * $pfs['qyt'] / $g_total,2)}} %</td>
                            <td>{{number_format($pfs['qyt'])}}</td>
                            <td>ETB {{number_format($pfs['total'],2)}}</td>
                            @if ($no == 1)
                            <td><i class="fa fa-trophy" style="color:gold;"></i></td>
                            @elseif ($no == 2)
                            <td><i class="fa fa-trophy" style="color:silver"></i></td>
                            @elseif ($no == 3)
                            <td><i class="fa fa-trophy" style="color:red"></i></td>
                            @else
                            <td><i class="fa fa-bookmark" aria-hidden="true"></i></td>
                            @endif
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
