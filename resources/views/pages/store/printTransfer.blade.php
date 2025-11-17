<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Transfer Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fas fa-globe"></i> Inventory.
                        <small class="float-right">Date: {{ \Carbon\Carbon::now()->toFormattedDateString() }}</small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>Inventory, {{ $requesition->requestFrom->name }}.</strong><br>
                        {{ $requesition->requestFrom->address }}<br>
                        Addis Ababa, Ethiopia<br>
                        Phone: (+251) <br>
                        Email:
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>{{ $requesition->requestTo->name }}</strong><br>
                        {{-- Phone: {{ $salesOrder->customer->phone }}<br>
                        Email: {{ $salesOrder->customer->email }}<br>
                        Type: {{ $salesOrder->customer->type }} <br>
                        Company: {{ $salesOrder->customer->company_name }} --}}

                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    {{-- <b>Invoice #{{ $salesOrder->customer->reference_number }}</b><br>
                    <br>
                    <b>Order ID:</b> {{ $salesOrder->customer->id }}<br>
                    <b>Sales Type:</b> {{ $salesOrder->sales_type }}<br>
                    <b>Sales Person:</b> {{ $salesOrder->sales_person }} --}}
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#NO</th>
                                <th>Item</th>
                                <th>P-No1</th>
                                <th>P-No2</th>
                                <th>Batch</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                                $vat = 0;
                                $total = 0;
                            @endphp
                            @forelse ($reqDetails as $detail)
                                @php
                                    $no = $no + 1;
                                    // $vat = $detail->tax;
                                    // $total = $detail->total + $detail->item->amount;
                                @endphp
                                <tr>
                                    <td>{{ $no }}</td>
                                    @php
                                        $printItem = App\Models\Item::find($detail->item->item_id);
                                    @endphp
                                    <td>{{ $detail->item->item_name }}</td>
                                    <td>{{ $detail->item->product_code }}</td>
                                    <td>{{ $detail->item->part_number }}</td>
                                    <td>{{ $detail->batch->batch_number }}</td>
                                    <td>{{ $detail->item->unit }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    {{-- <td>{{ $detail->amount * $detail->quantity }}</td> --}}
                                    {{-- <td>{{ number_format($item->amount / $item->quantity) }}</td>
                                    <td>{{ number_format($item->amount) }}</td> --}}
                                </tr>
                            @empty
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">



                </div>
                <!-- /.col -->
                <div class="col-6">

                    <div class="table-responsive">
                        {{-- <table class="table">

                            <tr>
                                <th>discount:</th>
                                <td>{{ $salesOrder->discount }} </td>
                            </tr>
                            <tr>
                                <th>Tax: </th>
                                <td>{{ $salesOrder->vat }} </td>
                            </tr>
                            <tr>
                                <th>WithHolding:</th>
                                <td>{{ $salesOrder->with_holding }} </td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>{{ $salesOrder->grand_total }} </td>
                            </tr>
                        </table> --}}
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <!-- Page specific script -->
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
