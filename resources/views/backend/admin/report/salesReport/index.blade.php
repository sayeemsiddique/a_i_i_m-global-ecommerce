@extends('backend.layout.master')

@push('css')
    <style>
        @media print {
            #stockPrint{
                width: 100%;
                height: 100%;
                }
            .visible-print{
                display: block;
                width: auto;
                height: auto;
                overflow: visible;
            }
        }
        table{
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
@php
    $filter_category_name = '';
@endphp
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">

                        <div class="card-header">
                            <h3 class="card-title">Sales Report</h3>
                            <div class="d-flex align-items-center">
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">

                            <form class="form-inline" method="GET">
                                <style>
                                    table{
                                        white-space: nowrap;
                                    }
                                </style>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" name="fromDate" @if (isset($_GET['fromDate']) and $_GET['fromDate']!='')
                                                value="{{$_GET['fromDate']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" @if (isset($_GET['toDate']) and $_GET['toDate']!='')
                                                value="{{$_GET['toDate']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Category :</label>

                                                <select name="category" class="form-control" id="category">
                                                    <option value="">--Select Category--</option>
                                                    @foreach ($categories as $category)
                                                    <option @if (isset($_GET['category']) and $_GET['category']== $category->id)
                                                    selected
                                                    @php
                                                        $filter_category_name = $category->name;
                                                    @endphp
                                                @endif value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>

                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Product</label>
                                                <select class="form-control select2" name="product_id" id="product_id">
                                                    <option value="">--Select a Product--</option>
                                                    @foreach ($product_datas as $product)
                                                        <option @if(isset($_GET['product_id']) and $_GET['product_id'] == $product->id) selected @endif value="{{ $product->id }}">{{ ucfirst($product->name) }} [{{ $product->code }}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" name="orderId"  id="orderId" placeholder="Search by Order Id" @if (isset($_GET['orderId']) and $_GET['orderId']!='')
                                                value="{{$_GET['orderId']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success ml-2">Search</button>
                                            <a class="btn btn-danger ml-2" href="{{route('admin.salesReport.index')}}">Reset Search</a>
                                        </td>

                                    </tr>
                                </table>

                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body" id="stockPrint">
                            <div class="table-responsive ajax-data-container pt-3 visible-print">
                                {{-- <p>Total Completed Orders: {{count($orders)}}</p> --}}
                                <div class="title_area">
                                    <h3 class="text-center">{{$global_setting->sub_title ?? ""}}</h3>
                                    <h4 class="text-center">
                                        {{$global_setting->address ?? ""}}
                                    </h4>

                                    <p class="text-center">
                                        <strong>Sales Report</strong>
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


                                    @if (isset($_GET['category']) and $_GET['category'] !='')
                                    <p class="text-center"> <strong>Category:</strong> {{$filter_category_name}}</p>
                                    @endif

                                    @if (isset($_GET['orderId']) and $_GET['orderId'] !='')
                                    <p class="text-center"> <strong>Order ID:</strong> {{$_GET['orderId']}}</p>
                                    @endif
                                </div>
                                <table class="table table-bordered table-striped" id="TableData">
                                    <thead>

                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Order Id</th>
                                            {{-- <th>Invoice Id</th> --}}
                                            <th>Date</th>
                                            {{-- <th>Factory Price</th> --}}
                                            <th>Quantity</th>
                                            {{-- <th>SD</th> --}}
                                            {{-- <th>VAT</th> --}}
                                            {{-- <th>Other</th> --}}
                                            {{-- <th>Packing</th> --}}
                                            {{-- <th>Gross <br> Sales</th> --}}
                                            {{-- <th>Commission</th> --}}
                                            {{-- <th>Carrying Cost</th> --}}
                                            {{-- <th>TDS <br> on <br> Commission</th> --}}
                                            {{-- <th>VDS <br> on <br> Commission</th> --}}
                                            <th>Total</th>
                                            {{-- <th>Weight</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                                $i = 1;
                                                $packing = 0;
                                                $TotalsalesGross = $salesGross= 0;
                                                $salePrice = 0;
                                                $totalSalePrice = 0;
                                                $carringcost = 0;
                                                $tds = 0;
                                                $vds = 0;

                                                $factoryPrice = 0;
                                                $sd = 0;
                                                $vat = 0;
                                                $fitting =0;
                                                $discount =0;
                                                $total_weight =0;
                                            @endphp
                                        @if ($orders->count() > 0)

                                            @foreach ($orders as $order)
                                                @php
                                                    $order_weight = 0;
                                                @endphp
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$order->orderUserInfo ? $order->orderUserInfo->first_name.' '.$order->orderUserInfo->last_name : ''}}</td>
                                                    <td>{{$order->tracking_code ?? 'N/A'}}</td>
                                                    {{-- <td>{{$order->invoice_no ?? 'N/A'}}</td> --}}
                                                    <td>{{$order->created_at->format('d-M-Y')}}</td>
                                                        @php
                                                            // $factory_price = 0;
                                                            $quantity = 0;
                                                        @endphp
                                                        @foreach ($order->orderDetails as $orderDetails)
                                                            @php
                                                            // $factory_price += $orderDetails->f_price * $orderDetails->quantity;
                                                            $factoryPrice += $orderDetails->f_price * $orderDetails->quantity;
                                                            $quantity += $orderDetails->quantity;

                                                            @endphp
                                                        @endforeach
                                                    {{-- <td>

                                                        {{$factory_price ?? "0.00"}}
                                                    </td> --}}

                                                    <td>
                                                        {{$quantity}}
                                                    </td>

                                                    {{-- <td>
                                                        {{$order->orderDetails->sum('sd_total') ?? "0.00"}} <br>
                                                        <small>({{($order->orderDetails->sum('sd')/count($order->orderDetails)) ?? "0.00"}} %)</small>
                                                    </td> --}}

                                                    {{-- <td>
                                                        {{$order->orderDetails->sum('vat_total') ?? "0.00"}} <br>
                                                        <small>({{($order->orderDetails->sum('vat')/count($order->orderDetails)) ?? "0.00"}} %)</small>
                                                    </td> --}}
                                                    {{-- <td>{{  $order->other_charge ? number_format($order->other_charge,2) : '0.00' }}</td> --}}
                                                    {{-- <td>{{  $order->other_categories_amount ? number_format($order->other_categories_amount,2) : '0.00' }}</td> --}}
                                                    {{-- <td>{{  $order->packing_amount ? number_format($order->packing_amount,2) : '0.00' }}</td> --}}
                                                    {{-- <td>

                                                        @php
                                                            $salesGross = 0;
                                                            foreach ($order->orderDetails as $key => $orderDetails) {
                                                                $salesGross += (($orderDetails->f_price ?? 0) * ($orderDetails->quantity ?? 0)) + ($orderDetails->sd_total ?? 0) + ($orderDetails->vat_total ?? 0);

                                                                if ($orderDetails->weight and $orderDetails->unit) {
                                                                    if ($orderDetails->unit == 1) {
                                                                        $order_weight += $orderDetails->weight * $orderDetails->quantity;
                                                                    } else if ($orderDetails->unit == 2) {
                                                                        $order_weight += ($orderDetails->weight * 1000) * $orderDetails->quantity;
                                                                    }
                                                                }
                                                            }
                                                            $salesGross = $salesGross + ($order->packing_amount ?? 0);

                                                            $total_weight += $order_weight;
                                                        @endphp

                                                        {{ number_format($salesGross, 2) }}


                                                    </td> --}}
                                                    {{-- <td>{{ number_format($order->discount_amount,2)}}</td> --}}
                                                    {{-- <td>{{ number_format($order->courier_cost,2) }}</td> --}}
                                                    {{-- <td>{{ number_format($order->tds_amount,2) }}</td> --}}
                                                    {{-- <td>{{ number_format($order->vds_amount,2) }}</td> --}}

                                                    <td>{{$salePrice = $order->grand_total_price ?? 0}}</td>
                                                    {{-- <td>
                                                        {{number_format($order_weight/100,2,'.','')}}
                                                    </td> --}}
                                                </tr>

                                                @php
                                                    $i++;

                                                        // $factoryPrice += $order->orderDetails->sum('f_price') ?? 0;
                                                    //     $sd += $order->orderDetails->sum('sd_total') ?? 0;
                                                    //     $vat += $order->orderDetails->sum('vat_total') ?? 0;

                                                    // $fitting += $order->other_charge;
                                                    // $discount += $order->discount_amount;
                                                    // $packing += $order->packing_amount;
                                                    $totalSalePrice += $salePrice;
                                                    // $TotalsalesGross += $salesGross;
                                                    // $carringcost += $order->courier_cost;
                                                    // $tds += $order->tds_amount;
                                                    // $vds +=$order->vds_amount;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr class="odd"><td valign="top" colspan="1005" class="dataTables_empty">No matching records found</td></tr>
                                        @endif
                                        <tr class="bg-light-success">

                                            <td></td>
                                            {{-- <td></td> --}}
                                            <td></td>
                                            <td></td>
                                            <td><b>Total</b></td>

                                            {{-- <td><b>{{ number_format($factoryPrice ?? '0.00',2,'.','') }}</b> </td> --}}
                                            <td></td>
                                            {{-- <td><b>{{ number_format($sd ?? '0.00',2,'.','') }}</b> </td> --}}
                                            {{-- <td><b>{{ number_format($vat ?? '0.00',2,'.','') }}</b> </td> --}}
                                            {{-- <td><b>{{ number_format($fitting,2) }}</b></td> --}}
                                            {{-- <td><b>{{ number_format($packing,2) }}</b> </td> --}}
                                            {{-- <td><b>{{ number_format($TotalsalesGross ?? '0.00',2,'.','') }}</b> </td> --}}
                                            {{-- <td><b>{{ number_format($discount,2) }}</b></td> --}}
                                            {{-- <td><b>{{ number_format($carringcost,2) }}</b> </td> --}}
                                            {{-- <td><b>{{ number_format($tds,2) }}</b> </td> --}}
                                            {{-- <td><b>{{ number_format($vds,2) }}</b> </td> --}}
                                            <td><b>{{ number_format($totalSalePrice ?? '0.00',2,'.','') }}</b></td>
                                            {{-- <td><b>{{ number_format($total_weight,2,'.','') }}</b></td> --}}
                                        </tr>
                                    </tbody>

                                    <tfoot>
                                        <tr class="bg-light-success">
                                            <th style="text-align: left" colspan="100%">Printed by: {{auth()->user()->first_name}} {{auth()->user()->last_name}}</th>
                                        </tr>
                                    </tfoot>

                                </table>


                            </div>

                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary print_media" onclick="exportData()">Export</button>
                            <button class="btn btn-primary print_media" onclick="printDiv('stockPrint')">Print</button>
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
    {{-- <script>
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.order.delete", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
            url = url.replace(':id', data_id );

            Swal.fire({
                title: 'Are you sure ?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Status Changed Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        });
    </script> --}}

    <script>
        function exportData(){
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
        }
    </script>

@endpush
