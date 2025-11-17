@extends('inc.frame')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-8 lg">
                                    <p class="text-warning">{{ $customer->name }}
                                        <small class="text-info">Return Sales Here</small>
                                    </p>
                                </div>
                                <div class="col-4 lg">
                                    <div class="pl-3 " style="float: right"><b> {{ 0 }} : Sales</b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6 lg">
                    <div class="card">
                        <div class="card-body text-sm">
                            {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                            <table id="example1" class="table table-bordered table-striped"
                                style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>SalesDate</th>
                                        <th>InvoiceNo</th>
                                        <th>ReturnSomeItems</th>
                                    </tr>
                                </thead>
                                <tbody id='list'>
                                    @php
                                        $no = 0;
                                    @endphp
                                    @foreach ($data['orders'] as $order)
                                        @if ($order->r_status != 'Done')
                                            @php
                                                $no = $no + 1;
                                            @endphp
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $order['created_at']->toDateString() }}</td>
                                                <td>{{ $order['reference_number'] }}</td>
                                                <td><a class="btn btn-info btn-xs" data-toggle="modal"
                                                        data-target="#modal-lg-custom-{{ $order['id'] }}">CustomReturn</a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="modal-lg-custom-{{ $order['id'] }}">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">{{ $order['reference_number'] }}</h4>
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

                                                                            <form action="/customReturn-{{ $order['id'] }}"
                                                                                method="POST" id="quickForm">
                                                                                @csrf
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputPassword1"
                                                                                                    id='click'>Return
                                                                                                    Date</label>
                                                                                                <input type="date"
                                                                                                    accept="any"
                                                                                                    name="return_date"
                                                                                                    class="form-control"value="{{ Carbon\Carbon::now()->toDateString() }}"
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputEmail1">Refunded
                                                                                                    Type</label>
                                                                                                <select class="form-control"
                                                                                                    name='refunded_type'
                                                                                                    required>
                                                                                                    <option value="">
                                                                                                        Select</option>
                                                                                                    <option value="Cash">
                                                                                                        Cash
                                                                                                    </option>
                                                                                                    <option value="Debit">
                                                                                                        BankTransfer
                                                                                                    </option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputPassword1"
                                                                                                    id='click'>Return
                                                                                                    Location</label>
                                                                                                <select class="form-control"
                                                                                                    name='return_location'
                                                                                                    required>
                                                                                                    <option value="">
                                                                                                        Select</option>
                                                                                                    @forelse ($location as  $loc)
                                                                                                        <option
                                                                                                            value="{{ $loc->id }}">
                                                                                                            {{ $loc->name }}
                                                                                                        </option>
                                                                                                    @empty
                                                                                                    @endforelse
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputPassword1"
                                                                                                    id='click'>Reason</label>
                                                                                                <input type="text"
                                                                                                    accept="any"
                                                                                                    name="reason"
                                                                                                    class="form-control"value=""
                                                                                                    required>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                    <hr>
                                                                                    <div class="row">
                                                                                        <div class="col-3">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputEmail1">Item
                                                                                                    Name</label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-2">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputPassword1"
                                                                                                    id='click'>Price</label>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-2">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputPassword1"
                                                                                                    id='click'>Quantity</label>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-2">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputPassword1"
                                                                                                    id='click'>RemainingQty</label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-2">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="exampleInputPassword1"
                                                                                                    id='click'>RtnQyt</label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-1">
                                                                                            <div class="form-group">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    @foreach ($data['items'] as $item)
                                                                                        @if ($item['order_id'] == $order['id'])
                                                                                            <div class="row"
                                                                                                id="remove_{{ $item['item_id'] }}">
                                                                                                <div class="col-3">
                                                                                                    <div
                                                                                                        class="form-group">
                                                                                                        <label
                                                                                                            for="exampleInputEmail1">
                                                                                                            <a
                                                                                                                href="">{{ $item['item_code'] }}</a></label>
                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            name="addmore[{{ $item['item_id'] }}][item_id]"
                                                                                                            value="{{ $item['item_id'] }}">
                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            name="addmore[{{ $item['item_id'] }}][price]"
                                                                                                            value="{{ $item['price'] }}">
                                                                                                        <input
                                                                                                            type="hidden"
                                                                                                            name="addmore[{{ $item['item_id'] }}][qyt]"
                                                                                                            value="{{ $item['quantity'] }}">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-2">
                                                                                                    <div
                                                                                                        class="form-group">
                                                                                                        <label
                                                                                                            for="exampleInputPassword1"
                                                                                                            id='click'>{{ number_format($item['price'], 2) }}</label>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="col-2">
                                                                                                    <div
                                                                                                        class="form-group">
                                                                                                        <label
                                                                                                            for="exampleInputPassword1"
                                                                                                            id='click'>{{ number_format($item['quantity']) }}</label>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-2">
                                                                                                    <div
                                                                                                        class="form-group">
                                                                                                        <input
                                                                                                            type="number"
                                                                                                            accept="any"
                                                                                                            name="addmore[{{ $item['item_id'] }}][remaining]"
                                                                                                            class="form-control"
                                                                                                            min='0'
                                                                                                            max="{{ $item['quantity'] }}"
                                                                                                            id="exampleInputPassword1"
                                                                                                            value="{{ $item['remaining'] }}"
                                                                                                            required>
                                                                                                    </div>

                                                                                                </div>

                                                                                                <div class="col-2">
                                                                                                    <div
                                                                                                        class="form-group">
                                                                                                        <input
                                                                                                            type="number"
                                                                                                            accept="any"
                                                                                                            name="addmore[{{ $item['item_id'] }}][quantity]"
                                                                                                            class="form-control"
                                                                                                            min='0'
                                                                                                            max="{{ $item['quantity'] }}"
                                                                                                            id="exampleInputPassword1"
                                                                                                            placeholder="ReturnQty"
                                                                                                            required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-1">
                                                                                                    <div
                                                                                                        class="form-group">
                                                                                                        <button
                                                                                                            type="button"
                                                                                                            class=" remove-div_{{ $item['item_id'] }}"><B
                                                                                                                style='color:red;height:5px;'>
                                                                                                                X
                                                                                                            </B></button>

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        @endif
                                                                                    @endforeach
                                                                                    <div
                                                                                        class="modal-footer justify-content-between">
                                                                                        <button type="button"
                                                                                            class="btn btn-default"
                                                                                            data-dismiss="modal">Close</button>
                                                                                        <button type="submit"
                                                                                            class="btn btn-success swalDefaultSuccess">Return</button>
                                                                                    </div>
                                                                                </div>

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                $(document).on('click', '.remove-div_{{ $item['item_id'] }}', function() {
                                                    $('#remove_{{ $item['item_id'] }}').remove();
                                                });
                                            </script>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>

                <div class="col-6 lg">
                    <div class="card">
                        <div class="card-body text-sm">
                            {{-- <div class="p-2" style="float: right"> {{ $salesOrders->links() }}</div> --}}
                            <table id="example2" class="table table-bordered table-striped"
                                style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>ReturnTo</th>
                                        <th>ReturnBy</th>
                                        <th>RFDAmount</th>
                                        <th>ReturnType</th>
                                        <th>Reason</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody id='list'>
                                    @php $no =0; @endphp
                                    @forelse ($returns as $return)
                                        @php $no = $no + 1; @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $return->created_at->year . '/' . $return->created_at->month . '/' . $return->created_at->day }}
                                            </td>
                                            <td>
                                                @forelse ( $location as $loc)
                                                    @if ($return->return_to == $loc->id)
                                                        {{ $loc->name }}
                                                    @endif
                                                @empty
                                                @endforelse
                                            </td>
                                            <td>
                                                @php $user = App\Models\user::select('name')->where('id',$return->return_by)->first();@endphp
                                                {{ $user->name }}
                                            </td>
                                            <td>{{ number_format($return->refunded_amount, 2) }}</td>
                                            <td>{{ $return->refunded_type }}</td>
                                            <td>{{ $return->reason }}</td>
                                            <td><a class="btn btn-warning btn-xs" data-toggle="modal"
                                                    data-target="#modal-lg-return-{{ $return->id }}">Detail</a></td>
                                        </tr>

                                        <div class="modal fade" id="modal-lg-return-{{ $return->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">{{ $return->created_at->toDateString() }}
                                                        </h4>
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
                                                                    <!-- jquery validationc -->
                                                                    <div class="card card-primary">

                                                                        <form action="/editReturn-{{ $return->id }}"
                                                                            method="POST" id="quickForm">
                                                                            @csrf
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="exampleInputPassword1"
                                                                                                id='click'>Return
                                                                                                Date</label>
                                                                                            <input
                                                                                                type="date"@readonly(true)
                                                                                                accept="any"
                                                                                                value="{{ $return->return_date }}"
                                                                                                name="return_date"
                                                                                                class="form-control"
                                                                                                required>

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="exampleInputEmail1">Refunded
                                                                                                Type</label>
                                                                                            <select class="form-control"
                                                                                                name='refunded_type'
                                                                                                required>
                                                                                                <option
                                                                                                    value="{{ $return->refunded_type }}">
                                                                                                    {{ $return->refunded_type }}
                                                                                                </option>
                                                                                                <option value="Cash">Cash
                                                                                                </option>
                                                                                                <option value="Debit">
                                                                                                    Debit To Current Balance
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="exampleInputPassword1"
                                                                                                id='click'>Return
                                                                                                Location</label>
                                                                                            <select class="form-control"
                                                                                                name='return_location'
                                                                                                required>
                                                                                                <option
                                                                                                    value="{{ $return->return_to }}">
                                                                                                    @forelse ($location as  $loc)
                                                                                                        @if ($loc->id == $return->return_to)
                                                                                                            {{ $loc->name }}
                                                                                                        @endif
                                                                                                    @empty
                                                                                                    @endforelse
                                                                                                </option>
                                                                                                {{-- @forelse ($location as  $loc)
                                                                             <option value="{{$loc->id}}">{{$loc->name}}</option>
                                                                        @empty
                                                                        @endforelse --}}
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="exampleInputEmail1">Item
                                                                                                Code</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="exampleInputPassword1"
                                                                                                id='click'>Price</label>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-4">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="exampleInputPassword1"
                                                                                                id='click'>RTNQuantity</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @forelse ($returnsDetail as $item)
                                                                                    @if ($return->id == $item->return_id)
                                                                                        <div class="row"
                                                                                            id="remove_{{ $item->id }}">
                                                                                            <div class="col-4">
                                                                                                <div class="form-group">
                                                                                                    @php $it = App\Models\Item::select('product_code')->where('id',$item->id)->first();@endphp
                                                                                                    <label
                                                                                                        for="exampleInputEmail1">
                                                                                                        <a href="">
                                                                                                            @if ($it != '')
                                                                                                                {{ $it->product_code }}
                                                                                                            @endif
                                                                                                        </a></label>
                                                                                                    <input type="hidden"
                                                                                                        name="addmore[{{ $item->id }}]['item_id']"
                                                                                                        value="{{ $item->id }}">
                                                                                                    <input type="hidden"
                                                                                                        name="addmore[{{ $item->id }}]['price']"
                                                                                                        value="{{ $item->price }}">
                                                                                                    <input type="hidden"
                                                                                                        name="addmore[{{ $item->id }}]['qyt']"
                                                                                                        value="{{ $item->quantity }}">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-4">
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        for="exampleInputPassword1"
                                                                                                        id='click'>{{ number_format($item->price, 2) }}</label>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-4">
                                                                                                <div class="form-group">
                                                                                                    <label
                                                                                                        for="exampleInputPassword1"
                                                                                                        id='click'>{{ number_format($item->quantity) }}</label>
                                                                                                </div>
                                                                                            </div>

                                                                                            {{-- <div class="col-3">
                                                                <div class="form-group">

                                                                    <input type="number" accept="any" name="addmore[{{$item->id}}][quantity]" placeholder="{{$item->quantity}}" class="form-control" min='0' max="{{$item->quantity}}" required>
                                                                </div>
                                                            </div> --}}
                                                                                            {{-- <div class="col-1">
                                                                <div class="form-group">
                                                            <button type="button" class=" remove-div_{{$item->id}}"><B style='color:red;height:5px;'> X </B></button>

                                                                </div>
                                                            </div> --}}

                                                                                        </div>
                                                                                        <script>
                                                                                            $(document).on('click', '.remove-div_{{ $item->id }}', function() {
                                                                                                $('#remove_{{ $item->id }}').remove();
                                                                                            });
                                                                                        </script>
                                                                                    @endif
                                                                                @empty
                                                                                @endempty
                                                                        </div>
                                                                        <div
                                                                            class="modal-footer justify-content-between">
                                                                            {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success swalDefaultSuccess" >Save Change</button> --}}
                                                                        </div>
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
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        // When user types or changes the ReturnQty field
        $(document).on('input', 'input[name^="addmore"][name$="[quantity]"]', function() {
            const $returnInput = $(this);
            const $row = $returnInput.closest('.row');

            // Find the corresponding Remaining input in the same row
            const remainingVal = parseFloat($row.find('input[name$="[remaining]"]').val()) || 0;
            const returnVal = parseFloat($returnInput.val()) || 0;

            // Validate
            if (returnVal > remainingVal) {
                alert('Return quantity cannot be greater than Remaining quantity!');
                $returnInput.val(''); // clear invalid value
            }
        });
    });
</script>
@endsection
