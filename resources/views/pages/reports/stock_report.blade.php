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
                                <th>Itemimage</th>
                                <th>Category</th>
                                <th>Shelf No</th>
                                <th>Location</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @forelse ($data as $stock)
                                @php
                                    $imagePath = str_replace('\\', '/', $stock->image); // Fix backslashes
                                @endphp
                                @php
                                    $no = $no + 1;
                                @endphp
                                <td>{{ $no }}</td>
                                <td>{{ $stock->item_name }}</td>
                                <td style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset($imagePath) }}" alt=""
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">

                                </td>
                                <td>{{ $stock->category }}</td>
                                <td>{{ $stock->shelf->shelf_name ?? '-' }}</td>
                                <td>{{ $stock->shelf->location->name ?? '-' }}</td>
                                <td>{{ $stock->quantity }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection
