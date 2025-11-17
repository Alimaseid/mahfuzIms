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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 0;
                                        @endphp
                                        @foreach ($batchs as $batch)
                                            @php
                                                $no = $no + 1;
                                            @endphp
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $batch->batch_number }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger btn-sm"
                                                        href="delete-batchs-{{ $batch->id }}"
                                                        onclick="return confirm('Are you sure you ?');">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
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
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Batch Number</label>
                                                            <input type="number" name="batch_number" class="form-control"
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
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Close</button>
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
@endsection
