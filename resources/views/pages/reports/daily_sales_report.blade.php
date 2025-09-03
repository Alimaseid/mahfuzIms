@extends('inc.frame')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row pt-1">
                <div class="col-md-6">
                    <form action="daily-sales-report" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="">Sales Porson</label>
                                <select name="sales_person" id="" class="form-control">
                                    @if ($salesPerson == '')
                                        <option value="">All</option>
                                    @endif
                                    @forelse ($salers as $saler)
                                        <option value="{{ $saler }}">{{ $saler }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="">Date</label>
                                <input type="date" name='report_date'class="form-control"
                                    value="{{ Carbon\Carbon::now()->toDateString() }}"
                                    max="{{ Carbon\Carbon::now()->toDateString() }}" required>
                            </div>
                            <div class="col-sm-2">
                                <hr>
                                <button type="submit" class="btn btn-sm btn-warning ">Go</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-2">
                </div>
                <div class="col-md-4 pt-3">
                    <table class="table table-borderless table-sm">
                        <thead>
                        </thead>
                        <tbody>
                            {{-- <tr>
                    <th >Sales Amount</th>
                    <td >ETB {{number_format($g_amount,2)}}</td>
                 </tr> --}}
                            <tr>
                                <th>Sales Tax</th>
                                <td>ETB {{ number_format($g_tax, 2) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="text-warning">
                                <th>Total Sales</th>
                                <td>ETB {{ number_format($g_total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3></h3>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr style="background-color: rgb(3, 3, 32)">
                                <th>PartNumber</th>
                                <th>ItemName</th>
                                <th>ItemImage</th>
                                <th>UnitPrice<small>(avg)</small></th>
                                <th>Qyt</th>
                                <th>Amount</th>
                                <th>TaxRate<small>(avg)</small></th>
                                <th>Tax</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $inventory)
                                @php
                                    $imagePath = str_replace('\\', '/', $inventory['pr_image']); // Fix backslashes
                                @endphp
                                <tr>
                                    <td>{{ $inventory['pr_code'] }}</td>
                                    <td>{{ $inventory['pr_name'] }}</td>
                                    <td style="display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ asset($imagePath) }}" alt=""
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">

                                    </td>
                                    <td>{{ number_format($inventory['avg_unit_price'], 2) }}</td>
                                    <td>{{ $inventory['quantity'] }}</td>
                                    <td>{{ number_format($inventory['amount'], 2) }}</td>
                                    <td>{{ number_format($inventory['avg_tax_rate'], 2) }}</td>
                                    <td>{{ number_format($inventory['tax'], 2) }}</td>
                                    <td>{{ number_format($inventory['tatal'], 2) }}</td>
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
