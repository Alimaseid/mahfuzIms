@extends('inc.frame')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            STOCK REPORT
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3></h3>

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
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Category</th>
                                <th>Shelf </th>
                                <th>BatchNumber</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @forelse ($data as $stock)
                                @php
                                    $imagePath = str_replace('\\', '/', $stock->item->image); // Fix backslashes
                                    $imagePath2 = str_replace('\\', '/', $stock->item->image2);
                                @endphp
                                @php
                                    $no = $no + 1;
                                @endphp
                                <td>{{ $no }}</td>
                                <td>{{ $stock->item->item_name }}</td>

                                 @if ($permission->manage_image == 'on')
                                    <td style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset($imagePath) }}" alt=""
                                        style="width: 30px; height: 30px; object-fit: cover; border-radius: 5px;"
                                        data-toggle="modal" data-target="#imageModal"
                                        onclick="setModalImage('{{ asset($imagePath) }}')">

                                </td>
                                @endif
                                 @if ($permission->manage_image == 'on')
                                   <td style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset($imagePath2) }}" alt=""
                                        style="width: 30px; height: 30px; object-fit: cover; border-radius: 5px;"
                                        data-toggle="modal" data-target="#imageModal"
                                        onclick="setModalImage('{{ asset($imagePath2) }}')">

                                </td>
                                @endif
                                  @if ($permission->manage_partNumber == 'on')
                                      <td>{{ $stock->item->product_code }}</a>
                                </td>
                                @endif
                                   @if ($permission->manage_partNumber == 'on')
                                  <td>{{ $stock->item->part_number }}</a>
                                </td>
                                @endif

                                @if ($stock->item->reorder > $stock->quantity)
                                    <td style="background-color: rgb(2, 2, 39)"><a type="button"
                                            style="color: rgb(169, 55, 20)">
                                            {{ $stock->quantity }}</td>
                                @else
                                    <td> {{ $stock->quantity }}</td>
                                @endif

                                <td>{{ $stock->item->unit }},{{ $stock->item->other_unit }}</td>
                                <td>{{ $stock->item->category }}</td>
                                <td>
                                    @foreach ($shelfs as $shelff)
                                        @if ($shelff->shelf->business_locations_id == $stock->location_id && $stock->item_id == $shelff->item_id)
                                            {{ $shelff->shelf->shelf_name ?? '-' }}
                                        @endif
                                    @endforeach

                                </td>
                                <td>{{ $stock->batch->batch_number }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
