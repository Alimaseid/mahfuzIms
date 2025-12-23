@extends('inc.frame')

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <h4>Transfer Item REPORT</h4>

                            <!-- ✅ Filter Form -->
                            <form method="GET" action="{{ route('reports.transferWarehouse') }}" class="form-inline">
                                <input type="date" name="from_date" value="{{ $from_date }}" class="form-control mr-2"
                                    required>
                                <input type="date" name="to_date" value="{{ $to_date }}" class="form-control mr-2"
                                    required>
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('reports.transferWarehouse') }}" class="btn btn-secondary ml-2">Reset</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ✅ Table -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="background-color: rgb(3, 3, 32)">
                                <th>No</th>
                                <th>ItemName</th>
                                @if ($permission->manage_image == 'on')
                                    <th>Image1</th>
                                @endif
                                @if ($permission->manage_image == 'on')
                                    <th>Image2</th>
                                @endif
                                @if ($permission->manage_partNumber == 'on')
                                    <th>Part-No1</th>
                                @endif
                                @if ($permission->manage_partNumber == 'on')
                                    <th>Part-No2</th>
                                @endif
                                <th>Category</th>
                                <th>Shelf </th>
                                <th>Quantity</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 0; @endphp
                            @forelse ($data as $stock)
                                @foreach ($stock->details as $detail)
                                    @php
                                        $no++;
                                        $imagePath = str_replace('\\', '/', $detail->item->image ?? '');
                                        $imagePath2 = str_replace('\\', '/', $detail->item->image2 ?? '');
                                    @endphp
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $detail->item->item_name }}</td>
                                        @if ($permission->manage_image == 'on')
                                            <td>
                                                @if ($imagePath)
                                                    <img src="{{ asset($imagePath) }}"
                                                        style="width:50px; height:50px; object-fit:cover;"
                                                        onclick="setModalImage('{{ asset($imagePath) }}')"
                                                        data-toggle="modal" data-target="#imageModal">
                                                @endif
                                            </td>
                                        @endif
                                        @if ($permission->manage_image == 'on')
                                            <td>
                                                @if ($imagePath2)
                                                    <img src="{{ asset($imagePath2) }}"
                                                        style="width:50px; height:50px; object-fit:cover;"
                                                        onclick="setModalImage('{{ asset($imagePath2) }}')"
                                                        data-toggle="modal" data-target="#imageModal">
                                                @endif
                                            </td>
                                        @endif
                                        @if ($permission->manage_partNumber == 'on')
                                            <td> {{ $detail->item->product_code }}</td>
                                        @endif
                                        @if ($permission->manage_partNumber == 'on')
                                            <td>{{ $detail->item->part_number }}</td>
                                        @endif
                                        <td>{{ $detail->item->category }}</td>
                                        <td>
                                            @foreach ($shelfs as $shelff)
                                                @if ($shelff->shelf->business_locations_id == $stock->request_from && $detail->item_id == $shelff->item_id)
                                                    {{ $shelff->shelf->shelf_name ?? '-' }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>{{ $stock->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No Data Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal for Image Preview -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" class="img-fluid rounded">
                    </div>
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
