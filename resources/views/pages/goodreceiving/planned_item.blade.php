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
                                    <b>Total Planned Item: {{ count($plans) }}</b>
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
                                <th>P-No1</th>
                                <th>P-No2</th>
                                <th>Image1</th>
                                <th>Shelf</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Message</th>
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
                                    <td>{{ $plan->item->product_code }}</td>
                                    <td>{{ $plan->item->part_number }}</td>
                                    <td style="display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ asset($imagePath1) }}" alt=""
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; cursor: pointer;"
                                            data-toggle="modal" data-target="#imageModal"
                                            onclick="setModalImage('{{ asset($imagePath1) }}')">
                                    </td>
                                    <td>{{ $plan->item->shelf }}</td>
                                    <td>{{ $plan->item->category }}</td>
                                    <td>{{ $plan->item->unit }}</td>
                                    <td>{{ $plan->required_qty }}</td>
                                    <td>{{ $plan->message }}</td>
                                    <td>
                                        @if ($permission->manage_delete_purchasePlan == 'on')
                                            <a type="button" class="btn btn-danger btn-sm"
                                                href="delete-plans-{{ $plan->id }}"
                                                onclick="return confirm('Are you sure you ?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
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
