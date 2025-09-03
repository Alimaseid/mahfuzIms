@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
              <div class="card">
                <div class="card-body text-sm">
                    {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>ItemName</th>
                      <th>Quantity</th>
                      <th>LastUpdate</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $no = 0; @endphp
                        @forelse ($items as $item)
                        @php $no = $no + 1; @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->qauntity }}</td>
                                <td>{{ $item->updated_at->toDateString() }}</td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>

                {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links("pagination::bootstrap-4") }}</div> --}}
                </div>
                  <!-- /.card-body -->
            </div>
              <!-- /.card -->
        </div>
    </div>
</section>
@endsection
