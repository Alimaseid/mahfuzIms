@extends('inc.frame')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            INVENTORY REPORT On <i class="text-warning" style="font-weight: 800">&nbsp;
                                {{ Carbon\Carbon::now()->toFormattedDateString() }}</i>
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
                                <th>ItemName</th>
                                <th>Itemimage</th>
                                <th>PartNumber</th>
                                <th>CostPerItem</th>
                                <th>StockQuantity</th>
                                <th>InventoryValue</th>
                                <th>ReOrder (auto-fill)</th>
                                <th>ReorderLevel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $inventory)
                                @php
                                    $imagePath = str_replace('\\', '/', $inventory['product_image']); // Fix backslashes
                                @endphp
                                @if ($inventory['reorder_flag'] == 'Ok')
                                    <tr>
                                    @else
                                    <tr style="background-color: rgb(228, 171, 14)">
                                @endif
                                <td>{{ $inventory['product_name'] }}</td>
                                <td style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset($imagePath) }}" alt=""
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">

                                </td>
                                <td>{{ $inventory['product_code'] }}</td>
                                <td>ETB {{ number_format($inventory['cost_per_item'], 2) }}</td>
                                <td>{{ number_format($inventory['stock_qauntity']) }}</td>
                                <td>ETB {{ number_format($inventory['inventory_value'], 2) }}</td>
                                <td>{{ $inventory['reorder_flag'] }}</td>
                                <td>{{ number_format($inventory['reorder_level']) }}</td>
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
