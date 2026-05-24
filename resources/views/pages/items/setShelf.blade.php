@extends('inc.frame')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 " style="float: left"> Set Shelf <b>
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
                                            <th>Shelf </th>
                                            <th>Location</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 0;
                                        @endphp
                                        ItemName: <strong> {{ $item->item_name }}</strong>
                                        @foreach ($itemshelfs as $itemshelf)
                                            @php
                                                $no = $no + 1;
                                            @endphp
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $itemshelf->shelf->shelf_name }}</td>
                                                <td>{{ $itemshelf->shelf->location->name }}</td>
                                                <td>
                                                    <a type="button" class="btn btn-danger btn-sm"
                                                        href="delete-itemShelf-{{ $itemshelf->id }}"
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
                                    <form action="/add-itemShelf" method="POST">
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
                                                            <label>Shelf</label>
                                                            <select name="shelf_id" class="form-control select2bs4"
                                                                id="shelf_id" required>
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
