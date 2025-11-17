@extends('inc.frame')


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <div class="p-2 btn btn-primary btn-sm" style="float: left"> Set Opening Balance <b>
                                    </b></div>
                            </h3>

                        </div>
                    </div>

                    <div class="card">
                        <div class="row">
                            <div class="col-10 lg">
                                <div class="card-body">
                                    <form action="/add-Opening_balance" method="POST">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Item Name</label>
                                                        <input type="text" name="" class="form-control"
                                                            value="{{ $item->item_name }}"
                                                            placeholder="{{ $item->item_name }}" readonly>
                                                        <input type="hidden" name="item_id" class="form-control"
                                                            value="{{ $item->id }}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Location</label>
                                                        <select name="location_id" class="form-control" id=""
                                                            required>
                                                            <option value="">Select</option>
                                                            @forelse ($locations as $location)
                                                                <option value="{{ $location->id }}">
                                                                    {{ $location->name }}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Batch</label>
                                                        <select name="batch_id" class="form-control" id="batch_id"
                                                            required>
                                                            <option value="">Select</option>
                                                            @forelse ($batchs as $batch)
                                                                @if ($batch->item_id == $item->id)
                                                                    <option value="{{ $batch->id }}">
                                                                        {{ $batch->batch_number }}</option>
                                                                @endif

                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Current Stock</label>
                                                        <input type="number" name="quantity" class="form-control"
                                                            placeholder="Quantity" value="1" min="1" required>
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
