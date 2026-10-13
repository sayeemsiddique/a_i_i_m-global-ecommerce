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
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Retail Customer Sales Report</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">Retail Customer Sales Report</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
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
                            <h3 class="card-title">Retail Customer Sales Report</h3>
                            <div class="d-flex align-items-center">
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0">


                            <form class="form-inline" action="{{ route('admin.salesReport.customerFilter') }}" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" value="{{ isset($fromDate) ? $fromDate : ''}}" name="fromDate" value="{{old('fromDate')}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" value="{{ isset($toDate) ? $toDate : '' }}" name="toDate" value="{{old('toDate')}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Retail Customers :</label>
                                                <select name="customer" class="select2 form-control">
                                                    <option value="">--Select Retail Customer--</option>
                                                    @foreach ($customers as $dealer)
                                                        <option  value="{{$dealer->id}}"
                                                            @if (isset($customer))

                                                            {{ ($dealer->id == $customer->id) ? 'selected' : '' }}
                                                            @endif
                                                            >{{$dealer->first_name.' '.$dealer->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" value="{{ isset($orderId) ? $orderId : '' }}" name="orderId" id="orderId" placeholder="Search by Order Id">
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


                        <div class="card-body" id="stockPrint">

                            <div class="table-responsive ajax-data-container pt-3 visible-print">
                                <div class="title_area">
                                    <h3 class="text-center">{{$global_setting->sub_title ?? ""}}</h3>
                                    <h4 class="text-center">
                                        {{$global_setting->address ?? ""}}
                                    </h4>

                                    <p class="text-center">
                                        <strong>Retail Customer Sales Report</strong>
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




                                    @if (isset($_GET['orderId']) and $_GET['orderId'] !='')
                                    <p class="text-center"> <strong>Order ID:</strong> {{$_GET['orderId']}}</p>
                                    @endif
                                </div>

                                <table class="table table-separate table-head-custom table-bordered" id="TableData">
                                    <thead>
                                        {{-- <th colspan="7"></th>
                                        <th>
                                            @isset($dealr)
                                                {{ ucfirst($dealr->first_name).' '.ucfirst($dealr->last_name) }} Sales Report {{ date('Y') }}
                                            @else
                                               All Retail Customer Sales Report {{ date('Y') }}

                                             @endisset
                                        </th>                                               --}}
                                        {{-- <th colspan="7"></th> --}}
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Order Id</th>
                                            {{-- <th>Invoice Id</th> --}}
                                            <th>Date</th>
                                            <th>Product Price</th>
                                            <th>VAT</th>
                                            <th>Other</th>
                                            <th>Packing</th>
                                            <th>Gross Sales</th>
                                            <th>Commission</th>
                                            <th>Carrying Cost</th>
                                            <th>TDS on Commission</th>
                                            <th>VDS on Commission</th>
                                            <th>Net Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $packing = 0;
                                                $TotalsalesGross = 0;
                                                $salePrice = 0;
                                                $totalSalePrice = 0;
                                                $carringcost = 0;
                                                $tds = 0;
                                                $vds = 0;

                                                $factoryPrice = 0;
                                                $vat = 0;
                                                $fitting =0;
                                                $discount =0;
                                        @endphp
                                        @if ($orders->count() > 0)
                                            @php
                                                $i = 1;

                                            @endphp
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{$i}}</td>
                                                    <td>{{$order->user ? $order->user->first_name.' '.$order->user->last_name : ''}}</td>
                                                    <td>{{$order->tracking_code ?? 'N/A'}}</td>
                                                    {{-- <td>{{$order->invoice_no ?? 'N/A'}}</td> --}}
                                                    <td>{{$order->created_at->format('d-M-Y')}}</td>


                                                    <td>
                                                        @php
                                                            $t_factory_price = 0;
                                                            foreach ($order->orderDetails as $key => $orderDetails) {
                                                                $t_factory_price += ($orderDetails->f_price * $orderDetails->quantity);

                                                                $factoryPrice += $t_factory_price;
                                                            }
                                                        @endphp
                                                        {{number_format($t_factory_price, 2)}}
                                                    </td>




                                                    <td>
                                                        {{ $order->orderDetails ? number_format($order->orderDetails->sum('vat_total'), 2) : '0.00' }} <br>
                                                        <small>({{($order->orderDetails->sum('vat')/count($order->orderDetails)) ?? "0.00"}} %)</small>
                                                    </td>
                                                    <td>{{  $order->other_categories_amount ? number_format($order->other_categories_amount,2) : '0.00' }}</td>
                                                    <td>{{  $order->packing_amount ? number_format($order->packing_amount,2) : '0.00' }}</td>
                                                    <td>
                                                        {{-- @if ($order->orderDetail ) --}}
                                                        @php
                                                            $salesGross = 0;
                                                            foreach ($order->orderDetails as $key => $orderDetails) {
                                                                $salesGross += ($orderDetails->f_price * $orderDetails->quantity) + $orderDetails->vat_total;
                                                            }
                                                            $salesGross += $order->other_categories_amount + $order->packing_amount;
                                                        @endphp

                                                        {{ number_format($salesGross, 2) }}

                                                        {{-- @endif     --}}
                                                    </td>
                                                    <td>{{ number_format($order->discount_amount,2)}}</td>
                                                    <td>{{ number_format(($order->courier_cost),2) }}</td>
                                                    <td>{{ number_format(($order->tds_amount ? $order->tds_amount: 0),2) }}</td>
                                                    <td>{{ number_format(($order->vds_amount ? $order->vds_amount : 0),2) }}</td>

                                                    <td>{{ number_format($salePrice = $order->grand_total_price, 2) ?? '0.00' }}</td>
                                                </tr>

                                                @php
                                                    $i++;

                                                        $vat += $order->orderDetail->sum('vat_total');

                                                    $fitting += $order->other_charge;
                                                    $discount += $order->discount_amount;
                                                    $packing += $order->packing_amount;
                                                    $totalSalePrice += $salePrice;
                                                    $TotalsalesGross += $salesGross;
                                                    $carringcost += $order->courier_cost;
                                                    $tds += $order->tds_amount;
                                                    $vds +=$order->vds_amount;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr class="odd"><td valign="top" colspan="100%" class="dataTables_empty text-red">No matching records found</td></tr>
                                        @endif
                                        <tr class="bg-light-success">

                                            <td></td>
                                            {{-- <td></td> --}}
                                            <td></td>
                                            <td></td>
                                            <td><b>Total</b></td>

                                            <td><b>{{ number_format($factoryPrice ?? '0.00',2,'.','') }}</b> </td>
                                            <td><b>{{ number_format($vat ?? '0.00',2,'.','') }}</b> </td>
                                            <td><b>{{ number_format($fitting,2) }}</b></td>
                                            <td><b>{{ number_format($packing,2) }}</b> </td>
                                            <td><b>{{ number_format($TotalsalesGross ?? '0.00',2,'.','') }}</b> </td>
                                            <td><b>{{ number_format($discount,2) }}</b></td>
                                            <td><b>{{ number_format($carringcost,2) }}</b> </td>
                                            <td><b>{{ number_format($tds,2) }}</b> </td>
                                            <td><b>{{ number_format($vds,2) }}</b> </td>
                                            <td><b>{{ number_format($totalSalePrice ?? '0.00',2,'.','') }}</b></td>
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
                            <button class="btn btn-primary " id="noprintbtn" onclick="exportData()">Export</button>
                            <button class="btn btn-primary " id="noprintbtn" onclick="printDiv('stockPrint')">Print</button>
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
