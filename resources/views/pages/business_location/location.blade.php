@extends('inc.frame')


@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left">Business Locations :<b>
                                        {{ count($location) }}</b></div>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New Location
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
                                                <th>LocationName</th>
                                                <th>Type</th>
                                                {{-- <th>OwnerName</th> --}}
                                                <th>Site</th>
                                                <th>Address</th>
                                                <th>_________</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($locations) > 0)
                                                @php
                                                    $no = 0;
                                                @endphp
                                                @foreach ($locations as $location)
                                                    @php
                                                        $no = $no + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $location->name }}</td>
                                                        <td>{{ $location->type }}</td>
                                                        {{-- <td>{{$location->owner_id}}</td> --}}
                                                        <td> {{ $location->site }}</td>
                                                        <td>{{ $location->address }}</td>

                                                        <td>
                                                            @if ($permission->manage_edit_location == 'on')
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-toggle="modal"
                                                                    data-target="#modal-lg-{{ $location->id }}">
                                                                    <i class="fas fa-edit "></i>
                                                                </button>
                                                            @endif
                                                            @if ($permission->manage_delete_location == 'on')
                                                                <a type="button" class="btn btn-danger btn-sm"
                                                                    href="delete-location-{{ $location->id }}"
                                                                    onclick="return confirm('Are you sure you ?');">
                                                                    <i class="fas fa-trash "></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="modal-lg-{{ $location->id }}">
                                                        <div class="modal-dialog modal-lg-{{ $location->id }}">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit location</h4>
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
                                                                                        <h3 class="card-title">location
                                                                                            <small>Information</small>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <!-- form start -->
                                                                                    <form
                                                                                        action="/edit-location-{{ $location->id }}"
                                                                                        method="POST" id="quickForm">
                                                                                        @csrf
                                                                                        <div class="card-body">
                                                                                            <div class="form-group">
                                                                                                <label>Name</label>
                                                                                                <input type="text"
                                                                                                    name="name"
                                                                                                    class="form-control"
                                                                                                    value="{{ $location->name }}"
                                                                                                    required>
                                                                                            </div>
                                                                                            {{-- <div class="form-group">
                                                    <label >Owner</label>
                                                    <select name="owner" id="" class="form-control" required>
                                                        <option value="{{$location->owner_id}}" selected >{{$location->owner_id}}</option>
                                                        @forelse ($owners as $owner)
                                                          <option value="{{$owner->name}}">{{$owner->name}}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div> --}}
                                                                                            <div class="form-group">
                                                                                                <label>Type</label>
                                                                                                <select name="type"
                                                                                                    id=""
                                                                                                    class="form-control"
                                                                                                    required>
                                                                                                    <option
                                                                                                        value="{{ $location->type }}"
                                                                                                        selected>
                                                                                                        {{ $location->type }}
                                                                                                    </option>
                                                                                                    <option value="Shop">
                                                                                                        Shop</option>
                                                                                                    <option
                                                                                                        value="Warehouse">
                                                                                                        Warehouse</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label>Site</label>
                                                                                                <input type="text"
                                                                                                    name="site"
                                                                                                    class="form-control"
                                                                                                    value="{{ $location->site }}">
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="">Address</label>
                                                                                                <input type="text"
                                                                                                    name="address"
                                                                                                    class="form-control"
                                                                                                    id=""
                                                                                                    value="{{ $location->address }}">
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
                                                <h2>No location Found !</h2>
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
                                    <h4 class="modal-title">New location</h4>
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
                                                        <h3 class="card-title">location <small>Information</small></h3>
                                                    </div>
                                                    <!-- /.card-header -->
                                                    <!-- form start -->
                                                    <form action="/add-location" method="POST" id="quickForm">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label>Location Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    placeholder="Business Location Name">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Type</label>
                                                                <select name="type" id=""
                                                                    class="form-control" required>
                                                                    <option value="" selected>Select</option>
                                                                    <option value="Shop">Shop</option>
                                                                    <option value="Warehouse">Warehouse</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Site <small>opt</small></label>
                                                                <input type="text" name="site" class="form-control"
                                                                    id="" placeholder="Site">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Adress <small>opt</small></label>
                                                                <input type="text" name="address" class="form-control"
                                                                    id="" placeholder="Adress">
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
    </section>

@endsection
