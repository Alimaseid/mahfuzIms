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
                                    <b>Total Item: {{ count($items) }}</b>
                                </div>
                                <div class="col-4 lg">
                                    <button type="button" class="btn btn-primary pull-rigth btn-sm" style="float: right;"
                                        data-toggle="modal" data-target="#modal-lg">
                                        New Item
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="p-2" style="float: right"> {{ $items->links() }}</div> --}}
                        <table id="example1" class="table table-bordered table-striped "
                            style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    {{-- <th>Image</th> --}}
                                    <th>ItemName </th>
                                    @if ($permission->manage_image == 'on')
                                        <th>Image1</th>
                                    @endif
                                    @if ($permission->manage_image == 'on')
                                        <th>Image2</th>
                                    @endif
                                    @if ($permission->manage_partNumber == 'on')
                                        <th>Part Number1</th>
                                    @endif
                                    @if ($permission->manage_partNumber2 == 'on')
                                        <th>Part Number2</th>
                                    @endif
                                    <th>Item Code</th>
                                    <th>Category</th>
                                    <th>Reorder</th>
                                    <th>Price1</th>
                                    <th>Price2</th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                @if (count($items) > 0)
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($items as $inventory)
                                        @php
                                            $no = $no + 1;
                                        @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            @php
                                                $imagePath1 = str_replace('\\', '/', $inventory->item->image);
                                                $imagePath2 = str_replace('\\', '/', $inventory->item->image2);
                                            @endphp
                                            <td>{{ $inventory->item->item_name }}</td>
                                            @if ($permission->manage_image == 'on')
                                                <td style="display: flex; align-items: center; gap: 10px;">
                                                    <img src="{{ asset($imagePath1) }}" alt=""
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                        data-toggle="modal" data-target="#imageModal"
                                                        onclick="setModalImage('{{ asset($imagePath1) }}')">
                                                </td>
                                            @endif
                                            @if ($permission->manage_image == 'on')
                                                <td>
                                                    <img src="{{ asset($imagePath2) }}" alt=""
                                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                        data-toggle="modal" data-target="#imageModal"
                                                        onclick="setModalImage('{{ asset($imagePath2) }}')">
                                                </td>
                                            @endif
                                            @if ($permission->manage_partNumber == 'on')
                                                <td>{{ $inventory->item->product_code }}</td>
                                            @endif
                                            @if ($permission->manage_partNumber2 == 'on')
                                                <td>{{ $inventory->item->part_number }}</td>
                                            @endif
                                            <td>{{ $inventory->item->item_code }}</td>
                                            <!-- Image Modal (works with Bootstrap 4) -->
                                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img id="modalImage" src="" class="img-fluid rounded">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <td>{{ $inventory->item->category }}</td>
                                            <td>{{ $inventory->item->reorder }}</td>

                                            <td>{{ $inventory->item->selling_price1 }}</td>
                                            <td>{{ $inventory->item->selling_price2 }}</td>
                                        </tr>
                                        <!-- /.modal -->
                                    @endforeach
                                @else
                                    <h2>No item Found !</h2>
                                @endif
                            </tbody>
                        </table>

                        {{-- <div class="p-2" style="float: right"> {{ $items->links("pagination::bootstrap-4") }}</div> --}}
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.modal -->
            </div>
        </div>
        </div>
    </section>

@endsection
