@extends('backend.layout.master')

@section('content')
@php
    $unit_types = array(
        [
            'id' => 1,
            'name' => 'KG'
        ],
        [
            'id' => 2,
            'name' => 'M.T'
        ],
        [
            'id' => 3,
            'name' => 'Nos'
        ],
        [
            'id' => 4,
            'name' => 'Pcs'
        ],
        [
            'id' => 5,
            'name' => 'W'
        ],
        [
            'id' => 6,
            'name' => 'M'
        ],
        [
            'id' => 7,
            'name' => 'Sch'
        ],
        [
            'id' => 8,
            'name' => 'Set'
        ],
        [
            'id' => 9,
            'name' => 'PKT'
        ],
        [
            'id' => 10,
            'name' => 'Sheet'
        ],
        [
            'id' => 11,
            'name' => 'Pec'
        ],
        [
            'id' => 12,
            'name' => 'Book'
        ],
        [
            'id' => 13,
            'name' => 'Box'
        ],
        [
            'id' => 14,
            'name' => 'Packet'
        ],
        [
            'id' => 15,
            'name' => 'CFT'
        ],
        [
            'id' => 16,
            'name' => 'Piss'
        ],
        [
            'id' => 17,
            'name' => 'Fit'
        ],
        [
            'id' => 18,
            'name' => 'SQ. mtr'
        ],
        [
            'id' => 19,
            'name' => 'LBS'
        ],
        [
            'id' => 20,
            'name' => 'MTR'
        ],
        [
            'id' => 21,
            'name' => 'Feet'
        ],
        [
            'id' => 22,
            'name' => 'LTR'
        ],
        [
            'id' => 23,
            'name' => 'Gallon'
        ],
        [
            'id' => 24,
            'name' => 'GRW'
        ],
        [
            'id' => 25,
            'name' => 'FT'
        ],
        [
            'id' => 26,
            'name' => 'Roll'
        ],
        [
            'id' => 27,
            'name' => 'POT'
        ],
        [
            'id' => 28,
            'name' => 'Bottle'
        ],
        [
            'id' => 29,
            'name' => 'Cor'
        ],
        [
            'id' => 30,
            'name' => 'Coil'
        ],
        [
            'id' => 31,
            'name' => 'Yds'
        ],
        [
            'id' => 32,
            'name' => 'Pair'
        ],
        [
            'id' => 33,
            'name' => 'MTS'
        ],
        [
            'id' => 34,
            'name' => 'RFT'
        ],
        [
            'id' => 35,
            'name' => 'Pound'
        ],
        [
            'id' => 36,
            'name' => 'Gram'
        ],
        [
            'id' => 37,
            'name' => 'Cey'
        ],
    );
@endphp
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">

                        <div class="card-header">
                            <h3 class="card-title">Inventory Report Product Wise</h3>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">

                            <form class="form-inline" method="GET">
                                <table>
                                    <tr>
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date"  name="fromDate" @if(isset($_GET['fromDate']) and $_GET['fromDate'] != '') value="{{$_GET['fromDate']}}"
                                        @endif>
                        </div>
                        </td> --}}
                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" @if(isset($_GET['toDate']) and $_GET['toDate'] != '') value="{{$_GET['toDate']}}"
                        @endif>
                    </div>
                    </td> --}}
                    <td>
                        <div class="form-group">
                            <label class="pr-2 pl-2">Products</label>
                            <select class="form-control select2" multiple="multiple" name="product_id[]"
                                autocomplete="off">
                                <option value="">--Select a user--</option>
                                @foreach ($products as $product)
                                <option @if (isset($_GET['product_id']) and in_array($product->id,$_GET['product_id'])) selected
                                    @endif value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-success ml-2">Search</button>
                    </td>

                    </tr>
                    </table>

                    </form>
                </div>
                {{-- End Filter --}}

                <div class="card-body">




                    @if (isset($_GET['product_id']) and $_GET['product_id'] != '')

                    <div class="w-100" id="stockPrint">
                        <h3 class="text-center">{{$global_setting->sub_title ?? ""}}</h3>
                    <h4 class="text-center">
                        {{$global_setting->address ?? ""}}
                    </h4>

                    <p class="text-center">
                        <strong>Inventory Report Product Wise</strong>
                    </p>

                        <p class="text-center">
                            @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                            <strong>Date from:</strong> {{date_format(date_create($_GET['fromDate']), 'd-m-Y')}}
                            @endif
                            @if (isset($_GET['toDate']) and $_GET['toDate'] !='')
                            @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                            ,
                            @endif
                            <strong>Date to:</strong> {{date_format(date_create($_GET['toDate']), 'd-m-Y')}}
                            @endif
                        </p>
                        @php
                        $i = 1;
                        $order_total_price = 0;
                        $order_discount_amount = 0;
                        @endphp
                        <div class="w-100">
                            <div class="table-responsive ajax-data-container pt-3">
                                @foreach ($order_data as $key => $order)


                                <h3>Product Name: {{$order['product_data']->name ?? ""}}</h3>
                                <p><strong>Product Code: {{$order['product_data']->code ?? ""}}</strong></p>
                                <table class="table table-bordered table-sm" style="margin-bottom: 40px !important;"
                                    id="TableData">
                                    <thead class="thead-light">

                                        <tr>
                                            <th>Date</th>
                                            <th>Unit</th>
                                            <th>
                                                (a) <br>
                                                Opening Stock
                                            </th>
                                            <th>
                                                (b) <br>
                                                Initial Stock In
                                            </th>
                                            <th>
                                                (c) <br>
                                                Stock In
                                            </th>
                                            <th>
                                                (d) <br>
                                                Stock Out
                                            </th>
                                            <th>
                                                (e) <br>
                                                Damage
                                            </th>
                                            <th>
                                                (f) = a+b+c-d-e <br>
                                                Balance
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $opening_quantity = 0;
                                        @endphp
                                        @if (count($order['order_details_date_group']) > 0)
                                            @foreach ($order['order_details_date_group'] as $key => $date_group)
                                                @php
                                                    $stock_in = 0;
                                                    $stock_out = 0;
                                                    $damage_qty = 0;
                                                    $initial_stock_in = 0;
                                                @endphp

                                                @foreach ($date_group as $index => $details)
                                                    @php
                                                        // dd($details);
                                                        if ($details->type == 3) {
                                                            $opening_quantity += $details->quantity;
                                                            // if ($index > 0) {
                                                                $initial_stock_in += $details->quantity;
                                                            // }
                                                        }

                                                        if ($details->type == 1) {
                                                            $opening_quantity += $details->quantity;
                                                            $stock_in += $details->quantity;
                                                        }

                                                        if (in_array($details->type,[2,4])) {
                                                            $opening_quantity -= $details->quantity;
                                                            $stock_out += $details->quantity;
                                                        }

                                                        if ($details->type == 5) {
                                                            $opening_quantity -= $details->quantity;
                                                            $damage_qty += $details->quantity;
                                                        }

                                                    @endphp
                                                @endforeach

                                                <tr>
                                                    <td>
                                                        @php
                                                            $date= new DateTime($key)
                                                        @endphp
                                                        {{ $date->format('d-m-Y') ?? "" }}
                                                    </td>
                                                    <td>

                                                        @foreach ($unit_types as $unit_type)
                                                            @if ($unit_type['id'] == ($order['product_data']->unit ?? 0))
                                                                {{$unit_type['name']}}
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{-- {{$date_group}} --}}
                                                        {{($opening_quantity + $stock_out + $damage_qty) - ($stock_in + $initial_stock_in)}}
                                                    </td>
                                                    <td>
                                                        {{$initial_stock_in}}
                                                        {{-- {{($opening_quantity + $stock_out + $damage_qty) - ($stock_in + $initial_stock_in)}} --}}
                                                    </td>
                                                    <td>
                                                        {{$stock_in}}
                                                    </td>
                                                    <td>
                                                        {{$stock_out}}
                                                    </td>
                                                    <td>
                                                        {{$damage_qty}}
                                                    </td>
                                                    <td>
                                                        {{$opening_quantity}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <th colspan="100%">No Data Found</th>
                                        </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <th style="text-align: left" colspan="100%">Printed by: {{auth()->user()->first_name}} {{auth()->user()->last_name}}</th>
                                    </tfoot>
                                </table>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary print_media" onclick="exportData()">Export</button>
                    <button class="btn btn-primary print_media" onclick="printDiv('stockPrint')">Print</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<style>
    @media print {
    tfoot { display: table-footer-group; }
}
@media screen {
    tfoot { display: none; }
}
</style>


@endsection

@push('stackScript')


<script>
    function exportData() {
        var table2excel = new Table2Excel();
        table2excel.export(document.querySelectorAll("#TableData"));
    }

</script>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        location.reload();
    }

</script>

@endpush
