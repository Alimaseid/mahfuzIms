@extends('inc.frame')


@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left">Category :<b>
                                        {{ count($categorys) }}</b></div>
                            </h3>
                            <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;"
                                data-toggle="modal" data-target="#modal-lg">
                                ADD New category
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
                                                <th>Category Name</th>
                                                <th>_________</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($categorys) > 0)
                                                @php
                                                    $no = 0;
                                                @endphp
                                                @foreach ($categorys as $category)
                                                    @php
                                                        $no = $no + 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $no }}</td>
                                                        <td>{{ $category->name }}</td>

                                                        <td>

                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#modal-lg-{{ $category->id }}">
                                                                <i class="fas fa-edit "></i>
                                                            </button>
                                                            <a type="button" class="btn btn-danger btn-sm"
                                                                href="delete-category-{{ $category->id }}"
                                                                onclick="return confirm('Are you sure you ?');">
                                                                <i class="fas fa-trash "></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="modal-lg-{{ $category->id }}">
                                                        <div class="modal-dialog modal-lg-{{ $category->id }}">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Edit Category</h4>
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
                                                                                        <h3 class="card-title">Category
                                                                                            <small></small>
                                                                                        </h3>
                                                                                    </div>
                                                                                    <!-- /.card-header -->
                                                                                    <!-- form start -->
                                                                                    <form
                                                                                        action="/edit-category-{{ $category->id }}"
                                                                                        method="POST" id="quickForm"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="col-12">
                                                                                            <div class="form-group">
                                                                                                <input type="text"
                                                                                                    name="category_name"
                                                                                                    class="form-control"
                                                                                                    Value="{{ $category->name }}"
                                                                                                    required>
                                                                                                <div class="col-12">
                                                                                                    <div class="form-group">
                                                                                                        <label>Description</label>
                                                                                                        <textarea name="decription" id="" class="form-control">{{ $category->description }}</textarea>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <button type="submit"
                                                                                                    class="btn btn-primary btn-xs swalDefaultSuccess">Edit</button>

                                                                                            </div>
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
                                                <h2>No categoryFound !</h2>
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
                                    <h4 class="modal-title">New Category</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">

                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">Category <small>Information</small></h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form action="/add-category" method="POST" id="quickForm"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Category Name</label>
                                                                <input type="text" name="category_name"
                                                                    class="form-control" placeholder="Category Name"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Description</label>
                                                                <textarea name="decription" id="" class="form-control"></textarea>
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

@endsection
