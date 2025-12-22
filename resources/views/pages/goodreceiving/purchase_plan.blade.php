@extends('inc.frame')


@section('content')
    <section class="content">
        <div class="card">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8 lg">
                                    <b>Total Purchase Plan: {{ count($plans) }}</b>
                                </div>
                                <div class="col-4 lg">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">

                    <table id="example1" class="table table-bordered table-striped "
                        style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ItemName </th>
                                @if ($permission->manage_partNumber == 'on')
                                    <th>P-No1</th>
                                @endif
                                @if ($permission->manage_partNumber == 'on')
                                    <th>P-No2</th>
                                @endif
                                @if ($permission->manage_image == 'on')
                                    <th>Image1</th>
                                @endif
                                <th>Location</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Batch</th>
                                <th>Quantity</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp

                            @foreach ($plans as $plan)
                                @php
                                    $no = $no + 1;
                                @endphp
                                @php
                                    $imagePath1 = str_replace('\\', '/', $plan->item->image);
                                @endphp
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $plan->item->item_name }}</td>
                                    @if ($permission->manage_partNumber == 'on')
                                        <td>{{ $plan->item->product_code }}</td>
                                    @endif
                                    @if ($permission->manage_partNumber == 'on')
                                        <td>{{ $plan->item->part_number }}</td>
                                    @endif
                                    @if ($permission->manage_image == 'on')
                                        <td style="display: flex; align-items: center; gap: 10px;">
                                            <img src="{{ asset($imagePath1) }}" alt=""
                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                                data-toggle="modal" data-target="#imageModal"
                                                onclick="setModalImage('{{ asset($imagePath1) }}')">
                                        </td>
                                    @endif
                                    <td>{{ $plan->location->name ?? '' }}</td>
                                    <td>{{ $plan->item->category }}</td>
                                    <td>{{ $plan->item->unit }}</td>
                                    <td>{{ $plan->batch->batch_number }}</td>
                                    <td>{{ $plan->quantity }}</td>

                                    <td>
                                        <button type="button" class="btn bg-info btn-sm" data-toggle="modal"
                                            data-target="#modal-lgplan-{{ $plan->item->id }}">
                                            <i class="fas ">move</i>
                                        </button>

                                    </td>
                                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body text-center">
                                                    <img id="modalImage" src="" class="img-fluid rounded">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <div class="modal fade" id="modal-lgplan-{{ $plan->item->id }}">
                                    <div class="modal-dialog modal-lgplan-{{ $plan->item->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Move To Plan</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
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
                                                                </div>
                                                                <div>
                                                                    <form
                                                                        action="{{ route('purchase-plan.move', $plan->item->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label>Quantity</label>
                                                                                    <input type="number" name="quantity"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <div class="form-group">
                                                                                    <label>Message</label>
                                                                                    <input type="text" name="message"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-sm bg-info">
                                                                            submit
                                                                        </button>
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
                                </div>
                            @endforeach

                        </tbody>
                    </table>


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
