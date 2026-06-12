@extends('inc.frame')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 " style="float: left"> Set batch <b>
                                    </b></div>
                            </h3>

                        </div>
                        <div class="mt-2 mt-md-0">
                            <a href="sets-{{ $item->id }}" class="btn btn-outline-dark px-4 rounded-pill shadow-sm">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="row">
                            <div class="col-6 lg">
                                <table class="table table-bordered table-striped "
                                    style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>BatchNumber </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 0;
                                        @endphp
                                        ItemName: <strong> {{ $item->item_name }}</strong>
                                        @foreach ($batchs as $batch)
                                            @php
                                                $no = $no + 1;
                                            @endphp
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $batch->batch_number }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-toggle="modal" data-target="#modal-lg-{{ $batch->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <a type="button" class="btn btn-danger btn-sm"
                                                        href="delete-batchs-{{ $batch->id }}"
                                                        onclick="return confirm('Are you sure you ?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="modal-lg-{{ $batch->id }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit </h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/edit_batches-{{ $batch->id }}" method="POST"
                                                                id="quickForm" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="container-fluid">
                                                                    <div class="row">

                                                                        <input type="hidden" name="request_token"
                                                                            value="{{ Str::uuid() }}">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label>Batch Number</label>
                                                                                <input type="text" name="batch_number"
                                                                                    class="form-control"
                                                                                    value="{{ $batch->batch_number }}"
                                                                                    required min="1">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label>Manufacture Date</label>
                                                                                <input type="date"
                                                                                    name="manufacture_date"
                                                                                    class="form-control"
                                                                                    value="{{ $batch->manufacture_date }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-between">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
                                                                    </div>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-6 lg">
                                <div class="card-body">
                                    <form action="/add-batchs" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Item Name</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $item->item_name }}" readonly>
                                                            <input type="hidden" name="item_id"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="request_token" value="{{ Str::uuid() }}">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Batch Number</label>
                                                            <input type="text" name="batch_number" class="form-control"
                                                                placeholder="Batch Number" required min="1">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Manufacture Date</label>
                                                            <input type="date" name="manufacture_date"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-primary">Register</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('quickForm');
            form.addEventListener('submit', function(e) {
                const btn = form.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerHTML = "Processing...";
            });
        });
    </script>
@endsection
