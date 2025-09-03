@extends('inc.frame')

@section('content')
    <section class="content-header">
        <div class="row">
          <div class="col-sm-12">
            <h1>
                Issue | <i class="text-primary">{{$data[0]['Owner']}}</i> from  <i class="text-success"> {{$data[0]['From']}}</i> to <i class="text-success">{{$data[0]['To']}}</i> .
            </h1>
          </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#No</th>
                    <th>Owner</th>
                    <th>IssuedBy</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php
                    $no = 0;
                    @endphp
                    @forelse ($data[0]['ItemList'] as $item)
                    @php
                        $no = $no+1;
                    @endphp
                    <tr>
                        <td>{{$no}}</td>
                        <td>{{$data[0]['Owner']}}</td>
                        <td>{{$data[0]['IssuedBy']}}</td>
                        <td>{{$item->item_name}}</td>
                        <td>{{$item->qauntity}}</td>
                    </tr>
                    @empty

                    @endforelse
                  <tr >
                    <th>~</td>
                    <th></td>
                    <th></td>
                    <th><hr></td>
                    <th></td>
                  </tr>

                  <tr>
                    <th>~</td>
                    <th>~</td>
                    <th>~</td>
                    <th  style="background-color: rgb(10, 216, 99)">V-No: {{$data[0]['Vno']}}</td>
                    <th  style="background-color: rgb(10, 216, 99)">Total: {{$data[0]['Quantity']}}</td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>


@endsection
