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
                                    <th>Category</th>
                                    <th>Shelf Location</th>
                                    <th style="background-color: rgb(2, 2, 39)">Part Number</th>
                                    <th style="background-color: rgb(2, 2, 39)">Quantity</th>
                                    <th>CostPrice</th>
                                    <th>Price1</th>
                                    <th>Price2</th>
                                    <th>Status</th>
                                    <th>SetAction</th>
                                </tr>
                            </thead>
                            <tbody id='list'>
                                @if (count($items) > 0)
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($items as $item)
                                        @php
                                            $no = $no + 1;
                                        @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            @php
                                                $imagePath1 = str_replace('\\', '/', $item->image);
                                                $imagePath2 = str_replace('\\', '/', $item->image2);
                                            @endphp

                                            <td style="display: flex; align-items: center; gap: 10px;">
                                                <span>{{ $item->item_name }}</span>
                                                <img src="{{ asset($imagePath1) }}" alt=""
                                                    style="width: 25px; height: 25px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                    data-toggle="modal" data-target="#imageModal"
                                                    onclick="setModalImage('{{ asset($imagePath1) }}')">

                                                <img src="{{ asset($imagePath2) }}" alt=""
                                                    style="width: 25px; height: 25px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                    data-toggle="modal" data-target="#imageModal"
                                                    onclick="setModalImage('{{ asset($imagePath2) }}')">


                                            </td>

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
                                            <td>{{ $item->category }}</td>
                                            <td>{{ $item->shelf->shelf_name ?? '-' }}</td>
                                            <td style="background-color: rgb(2, 2, 39)"><a type="button"
                                                    style="color: gold" href="#"data-toggle="modal"
                                                    data-target="#modal-lg-O-{{ $item->id }}">{{ $item->product_code }}</a>
                                            </td>
                                            <td style="background-color: rgb(2, 2, 39)"> <a type="button"
                                                    style="color: rgb(6, 248, 6)" href="#"data-toggle="modal"
                                                    data-target="#modal-lg-O-{{ $item->id }}">{{ $item->quantity }}</a>
                                            </td>
                                            <td>{{ $item->cost_price }}</td>
                                            <td>{{ $item->selling_price1 }}</td>
                                            <td>{{ $item->selling_price2 }}</td>

                                            {{-- <td>{{$item->supplier_name}}</td> --}}
                                            <td>
                                                <a type="button" class="btn btn-warning btn-xs"
                                                    href="activate-item-{{ $item->id }}"
                                                    onclick="return confirm('Are you sure you ?');">
                                                    {{ $item->status }}
                                                </a>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                    data-target="#modal-lg-{{ $item->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                {{-- <a type="button" class="btn btn-danger btn-sm" href="delete-item-{{$item->id}}" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-trash"></i>
                              </a> --}}
                                                <a type="button" class="btn btn-danger btn-sm" href="#"
                                                    onclick="return confirm('Are you sure you ?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>


                                        <div class="modal fade" id="modal-lg-O-{{ $item->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Part Number - {{ $item->product_code }}
                                                        </h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="col-3">
                                                                Owner
                                                            </div>
                                                            <div class="col-3">
                                                                Item
                                                            </div>
                                                            <div class="col-3">
                                                                Location
                                                            </div>
                                                            <div class="col-3">
                                                                Quantity
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        @forelse ($item_owners as $owner)
                                                            @if ($owner->item_id == $item->id)
                                                                @forelse ($owners as $own)
                                                                    @forelse ($location as $loc)
                                                                        @if ($own->id == $owner->owner_id && $loc->id == $owner->location_id)
                                                                            <div class="row">
                                                                                <div class="col-3">
                                                                                    <a href=""> {{ $own->name }}
                                                                                    </a>
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    {{ $item->product_code }}
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    {{ $loc->name }}
                                                                                </div>
                                                                                <div class="col-3">
                                                                                    <p><b class="text-warning">
                                                                                            {{ number_format($owner->quantity) }}</b>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @empty
                                                                    @endforelse
                                                                @empty
                                                                @endforelse
                                                            @endif
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.card -->

                                        <div class="modal fade" id="modal-lg-{{ $item->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit {{ $item->item_name }}</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">

                                                            <div class="card card-primary">
                                                                <div class="card-header">
                                                                    <h3 class="card-title">item <small>Information</small>
                                                                    </h3>
                                                                </div>
                                                                <!-- /.card-header -->
                                                                <!-- form start -->
                                                                <form action="/edit-item-{{ $item->id }}"
                                                                    method="POST" id="quickForm"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Item Name</label>
                                                                                    <input type="text" name="item_name"
                                                                                        class="form-control"
                                                                                        value="{{ $item->item_name }}"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>part Number 1</label>
                                                                                    <input type="text"
                                                                                        name="product_code"
                                                                                        class="form-control"
                                                                                        value="{{ $item->product_code }}"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>part Number 2</label>
                                                                                    <input type="text"
                                                                                        name="part_number"
                                                                                        class="form-control"
                                                                                        value="{{ $item->part_number }}"
                                                                                        required>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Item Code</label>
                                                                                    <input type="text" name="item_code"
                                                                                        class="form-control"
                                                                                        value="{{ $item->item_code }} "
                                                                                        placeholder="">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Category</label>
                                                                                    <select name="category"
                                                                                        class="form-control"
                                                                                        id="" required>
                                                                                        <option
                                                                                            value="{{ $item->category }}">
                                                                                            {{ $item->category }}</option>
                                                                                        @forelse ($categories as $category)
                                                                                            <option
                                                                                                value="{{ $category->name }}">
                                                                                                {{ $category->name }}
                                                                                            </option>
                                                                                        @empty
                                                                                        @endforelse
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Shelf</label>
                                                                                    <select name="shelves_id"
                                                                                        class="form-control"
                                                                                        id="" required>
                                                                                        @forelse ($shelfs as $shelf)
                                                                                            @if ($item->shelves_id == $shelf->id)
                                                                                                <option
                                                                                                    value="{{ $item->shelves_id }}">
                                                                                                    {{ $shelf->shelf_name }}
                                                                                                </option>
                                                                                            @endif
                                                                                        @empty
                                                                                        @endforelse
                                                                                        @forelse ($shelfs as $shelf)
                                                                                            <option
                                                                                                value="{{ $shelf->id }}">
                                                                                                {{ $shelf->shelf_name }}
                                                                                            </option>
                                                                                        @empty
                                                                                        @endforelse
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Unit</label>
                                                                                    <select name="unit"
                                                                                        class="form-control"
                                                                                        id="" required>
                                                                                        @forelse ($item_units as $item_unit)
                                                                                            <option
                                                                                                value="{{ $item_unit->unit }}">
                                                                                                {{ $item_unit->unit }}
                                                                                            </option>
                                                                                        @empty
                                                                                        @endforelse
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Batch Number</label>
                                                                                    <input type="text" name="bar_code"
                                                                                        class="form-control"
                                                                                        value="{{ $item->bar_code }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Brand</label>
                                                                                    <input type="text" name="brand"
                                                                                        class="form-control"
                                                                                        value="{{ $item->brand }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Cost Price</label>
                                                                                    <input type="number" step="any"
                                                                                        name="cost_price"
                                                                                        class="form-control"
                                                                                        value="{{ $item->cost_price }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Price 1</label>
                                                                                    <input type="number" step="any"
                                                                                        name="selling_price1"
                                                                                        class="form-control"
                                                                                        value="{{ $item->selling_price1 }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Price 2</label>
                                                                                    <input type="number" step="any"
                                                                                        name="selling_price2"
                                                                                        class="form-control"
                                                                                        value="{{ $item->selling_price2 }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>CurruntStock</label>
                                                                                    <input type="number" step="any"
                                                                                        name="quantity"
                                                                                        class="form-control"
                                                                                        placeholder="Quantity"
                                                                                        value="{{ $item->quantity }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Re-Order Level</label>
                                                                                    <input type="number" name="reorder"
                                                                                        class="form-control"
                                                                                        placeholder="Re Order Level"
                                                                                        value="{{ $item->reorder }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>Description</label>
                                                                                    <input type="text"
                                                                                        name="description"
                                                                                        class="form-control"
                                                                                        value="{{ $item->description }}"
                                                                                        placeholder="Description">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>image 1</label>
                                                                                    <input type="file" name="image"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="form-group">
                                                                                    <label>image 2</label>
                                                                                    <input type="file" name="image2"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer justify-content-between">
                                                                            <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">Close</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary swalDefaultSuccess"
                                                                                onclick="return confirm('Are you sure? Save Changes !!!');">Save
                                                                                Change</button>
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

                <!-- /.card -->

                <div class="modal fade" id="modal-lg">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New item</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">

                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">item <small>Information</small></h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form action="/add-item" method="POST" id="quickForm"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Item Name</label>
                                                            <input type="text" name="item_name" class="form-control"
                                                                placeholder="Item Name" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Part Number 1</label>
                                                            <input type="text" name="product_code"
                                                                class="form-control" value=""
                                                                placeholder="Part number 1">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Part Number 2</label>
                                                            <input type="text" name="part_number" class="form-control"
                                                                value="" placeholder="Part number 2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Item Code</label>
                                                            <input type="text" name="item_code" class="form-control"
                                                                value="{{ 'Item-C-' . random_int(0000001, 9999999) }} "
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Category</label>
                                                            <select name="category" class="form-control" id=""
                                                                required>
                                                                <option value="">Select</option>
                                                                @forelse ($categories as $category)
                                                                    <option value="{{ $category->name }}">
                                                                        {{ $category->name }}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Shelf</label>
                                                            <select name="shelves_id" class="form-control" id=""
                                                                required>
                                                                <option value="">Select</option>
                                                                @forelse ($shelfs as $shelf)
                                                                    <option value="{{ $shelf->id }}">
                                                                        {{ $shelf->shelf_name }}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Unit</label>
                                                            <select name="unit" class="form-control" id=""
                                                                required>
                                                                <option value="">Select</option>
                                                                @forelse ($item_units as $item_unit)
                                                                    <option value="{{ $item_unit->unit }}">
                                                                        {{ $item_unit->unit }}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Batch Number</label>
                                                            <input type="text" name="bar_code" class="form-control"
                                                                placeholder="Batch Number">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Brand</label>
                                                            <input type="text" name="brand" class="form-control"
                                                                placeholder="Brand">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Cost Price</label>
                                                            <input type="number" step="any" name="cost_price"
                                                                class="form-control" placeholder="Cost Price">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Price 1</label>
                                                            <input type="number" step="any" name="selling_price1"
                                                                class="form-control" placeholder="Selling Price 1">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Price 2</label>
                                                            <input type="number" step="any" name="selling_price2"
                                                                class="form-control" placeholder="Selling Price 2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>CurruntStock</label>
                                                            <input type="number" step="any" name="quantity"
                                                                class="form-control" placeholder="Quantity">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Re-Order Level</label>
                                                            <input type="number" name="reorder" class="form-control"
                                                                placeholder="Re Order Level">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <input type="text" name="description" class="form-control"
                                                                placeholder="Description">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>image 1</label>
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>image 2</label>
                                                            <input type="file" name="image2" class="form-control">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-primary swalDefaultSuccess">Register</button>
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
            </div>
        </div>
        </div>
    </section>
    <script>
        function setModalImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>
@endsection
