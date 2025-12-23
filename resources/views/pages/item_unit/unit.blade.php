@extends('inc.frame')


@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left">ItemUnit :<b>
                                        {{ count($item_units) }}</b></div>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New Item Unit
                            </button>
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
                        <div class="row">
                            <div class="col-8 lg">
                                <div class="card-body">
                                    {{-- <div class="p-2" style="float: right"> {{ $locations->links() }}</div> --}}
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Item Unit</th>
                                                <th>_________</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($item_units) > 0)
                                                @php
                                                    $no = 0;
                                                @endphp
                                                @foreach ($item_units as $item_unit)
                                                    @php
                                                        $no = $no + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $item_unit->unit }}</td>

                                                        <td>
                                                            @if ($permission->manage_edit_itemUnit == 'on')
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-lg-{{ $item_unit->id }}">
                                                                    <i class="fas fa-edit "></i>
                                                                </button>
                                                            @endif
                                                            @if ($permission->manage_delete_itemUnit == 'on')
                                                                <a type="button" class="btn btn-danger btn-sm"
                                                                    href="delete-item_unit-{{ $item_unit->id }}"
                                                                    onclick="return confirm('Are you sure you ?');">
                                                                    <i class="fas fa-trash "></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="modal-lg-{{ $item_unit->id }}">
                                                        <div class="modal-dialog modal-lg-{{ $item_unit->id }}">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Item Unit</h4>
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
                                                                                        <h3 class="card-title">Item Unit
                                                                                            <small></small>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <!-- form start -->
                                                                                    <form
                                                                                        action="/edit-item_unit-{{ $item_unit->id }}"
                                                                                        method="POST" id="quickForm">
                                                                                        @csrf
                                                                                        <div class="card-body">
                                                                                            <div class="form-group">
                                                                                                <label>Unit</label>
                                                                                                <input type="text"
                                                                                                    name="unit"
                                                                                                    class="form-control"
                                                                                                    value="{{ $item_unit->unit }}"
                                                                                                    required>
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
                                                <h2>No Item Unit Found !</h2>
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
                                    <h4 class="modal-title">New Item Unit</h4>
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
                                                        <h3 class="card-title">Item Unit <small>Information</small></h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form action="/add-item_unit" method="POST" id="quickForm">
                                                        @csrf
                                                        <input type="hidden" name="request_token"
                                                            value="{{ Str::uuid() }}">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Unit</label>
                                                                <input type="text" name="unit" class="form-control"
                                                                    placeholder="Item Unit">
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


                </div>
            </div>
        </div>
    </section>

@endsection
