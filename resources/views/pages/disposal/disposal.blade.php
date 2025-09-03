@extends('inc.frame')


@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left">Disposal :<b>
                                        {{ count($disposals) }}</b></div>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New Disposal
                            </button>


                        </div>
                    </div>

                    <div class="card">
                        <div class="row">
                            <div class="col-8 lg">
                                <div class="card-body">
                                    {{-- <div class="p-2" style="float: right"> {{ $locations->links() }}</div> --}}
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Reason</th>
                                                <th>_________</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($disposals) > 0)
                                                @php
                                                    $no = 0;
                                                @endphp
                                                @foreach ($disposals as $disposal)
                                                    @php
                                                        $no = $no + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $disposal->item->item_name }}</td>
                                                        <td>{{ $disposal->quantity }}</td>
                                                        <td>{{ $disposal->reason }}</td>
                                                        <td>

                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal-lg-{{ $disposal->id }}">
                                                                <i class="fas fa-edit "></i>
                                                            </button>
                                                            <a type="button" class="btn btn-danger btn-sm"
                                                                href="delete-disposal-{{ $disposal->id }}"
                                                                onclick="return confirm('Are you sure you ?');">
                                                                <i class="fas fa-trash "></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="modal-lg-{{ $disposal->id }}">
                                                        <div class="modal-dialog modal-lg-{{ $disposal->id }}">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Disposal</h4>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
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
                                                                                        <h3 class="card-title">Disposal
                                                                                            <small>Information</small>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <!-- form start -->
                                                                                    <form
                                                                                        action="/edit-disposal-{{ $disposal->id }}"
                                                                                        method="POST" id="quickForm">
                                                                                        @csrf
                                                                                        <div class="card-body">
                                                                                            <div class="form-group">
                                                                                                <label>Item</label>
                                                                                                <select name="item_id"
                                                                                                    id=""
                                                                                                    class="form-control"
                                                                                                    required>
                                                                                                    <option
                                                                                                        value="{{ $disposal->item_id }}"
                                                                                                        selected>
                                                                                                        {{ $disposal->item->item_name }}
                                                                                                    </option>
                                                                                                    @forelse ($items as $item)
                                                                                                        <option
                                                                                                            value="{{ $item->id }}">
                                                                                                            {{ $item->item_name }}
                                                                                                        </option>
                                                                                                    @empty
                                                                                                    @endforelse
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label>Quantity</label>
                                                                                                <input type="text"
                                                                                                    name="quantity"
                                                                                                    class="form-control"
                                                                                                    value="{{ $disposal->quantity }}"
                                                                                                    required>
                                                                                            </div>


                                                                                            <div class="form-group">
                                                                                                <label>Reason</label>
                                                                                                <input type="text"
                                                                                                    name="reason"
                                                                                                    class="form-control"
                                                                                                    value="{{ $disposal->reason }}">
                                                                                            </div>

                                                                                        </div>

                                                                                        <div
                                                                                            class="modal-footer justify-content-between">
                                                                                            <button type="button"
                                                                                                class="btn btn-default"
                                                                                                data-dismiss="modal">Close</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary swalDefaultSuccess"
                                                                                                onclick="return confirm('Are you sure you want to save changes ?');">Save
                                                                                                Change</button>
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
                                                @endforeach
                                            @else
                                                <h2>No Disposal Found !</h2>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>

                        </div>
                    </div>


                    <!-- /.card -->
                    <div class="modal fade" id="modal-lg">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">New Disposal</h4>
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
                                                        <h3 class="card-title">Disposal <small>Information</small></h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form action="/add-disposal" method="POST" id="quickForm">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Item</label>
                                                                <select name="item_id" id="" class="form-control"
                                                                    required>
                                                                    <option value="" selected>
                                                                        Select
                                                                    </option>
                                                                    @forelse ($items as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->item_name }}
                                                                        </option>
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Quantity</label>
                                                                <input type="text" name="quantity"
                                                                    class="form-control" placeholder="Quantity">
                                                            </div>


                                                            <div class="form-group">
                                                                <label for="">Reason
                                                                    <small>opt</small></label>
                                                                <input type="text" name="reason" class="form-control"
                                                                    id="" placeholder="Reason">
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

                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>

@endsection
