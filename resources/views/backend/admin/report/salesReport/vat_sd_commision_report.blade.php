@extends('backend.layout.master')

@section('content')

@php
    $user_types = array(
        [
            'id' => 1,
            'name' => 'Customer'
        ],
        [
            'id' => 2,
            'name' => 'Corporate Consumer'
        ],
        [
            'id' => 3,
            'name' => 'Dealer'
        ],
    );
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
                            <h3 class="card-title">VAT, SD, Commission and TDS Report</h3>
                            <div class="d-flex align-items-center">             
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">
                    
                            <form class="form-inline" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">User Type</label>
                                                <select class="form-control select2" name="type" autocomplete="off">
                                                    <option value="">--Select a user type--</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type'] == 1) selected @endif value="1">Customer</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type'] == 2) selected @endif value="2">Corporate Consumer</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type'] == 3) selected @endif value="3">Dealer</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">User</label>
                                                <select class="form-control select2" name="user_id" autocomplete="off">
                                                    <option value="">--Select a user--</option>
                                                    @foreach ($users as $user)
                                                        <option @if (isset($_GET['user_id']) and $_GET['user_id'] == $user->id) selected @endif value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>

                                        <div class="form-group">
                                            <label class="pr-2 pl-2">From :</label>
                                            <input class="form-control" type="date" @if (isset($_GET['fromDate']) and $_GET['fromDate'] != '') value="{{$_GET['fromDate']}}" @endif name="fromDate">
                                        </div>
                                        <div class="form-group">
                                            <label class="pr-2 pl-2">To :</label>
                                            <input class="form-control" type="date" @if (isset($_GET['toDate']) and $_GET['toDate'] != '') value="{{$_GET['toDate']}}" @endif name="toDate">
                                        </div>
                                        <div class="form-group">
                                            <label class="pr-2 pl-2">Order ID :</label>
                                            <input class="form-control" type="number" @if (isset($_GET['order_id']) and $_GET['order_id'] != '') value="{{$_GET['order_id']}}" @endif name="order_id" placeholder="Enter Order ID">
                                        </div>
                                        <td>
                                            <button type="submit" class="btn btn-success ml-2">Show</button>
                                            <a href="{{route('admin.salesReport.vat_sd_cmmmission')}}" class="btn btn-primary ml-2">Reset</a>
                                        </td>
                                        
                                    </tr>
                                </table>
                                
                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">
                            
                                {{-- @if (isset($_GET['user_id']) and $_GET['user_id'] != '') --}}
                                <div class="w-100" id="stockPrint">
                                    {{-- <h4 class="text-center">VAT, SD, Commission Report</h4> --}}
                                <div class="w-100 text-center">
                                    <h3 class="text-center">{{$global_setting->sub_title ?? ""}}</h3>
                                    <h4 class="text-center">
                                        {{$global_setting->address ?? ""}}
                                    </h4>
    
                                    <p class="text-center">
                                        <strong>VAT, SD, Commission and TDS Report</strong>
                                    </p>
                                    
                                    @if ($user_data)
                                    
                                        <p><strong>User:</strong> {{$user_data->first_name}} {{$user->last_name}}</p>
                                        <p><strong>Email:</strong> {{$user_data->email}}</p>
                                        <p><strong>Phone:</strong> {{$user_data->mobile}}</p>
                                        
                                    @endif
                                    @if (isset($_GET['type']) and $_GET['type'] != '')
                                        @foreach ($user_types as $user_type)
                                            @if ($user_type['id'] == $_GET['type'])
                                                <strong>User Type:</strong> {{$user_type['name']}}
                                            @endif
                                        @endforeach
                                    @endif

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

                                    @if (isset($_GET['order_id']) and $_GET['order_id'] != '')
                                        <p>
                                            <strong>Order ID:</strong> {{$_GET['order_id']}}
                                        </p>
                                    @endif
                                    
                                </div>
                                @php
                                    $i = 1;
                                    $order_total_price = 0;
                                    $order_discount_amount = 0;
                                    $order_discount_amount_in_total = 0;
                                    $total_sd_amount = 0;
                                    $total_vat_amount = 0;
                                    $total_tds_amount = 0;
                                    $total_vds_amount = 0;
                                @endphp
                                    <div class="table-responsive ajax-data-container pt-3">
                                        <table class="table table-separate table-head-custom table-checkable table-striped" id="TableData">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="text-left">Order ID</th>
                                                    <th>Date</th>
                                                    <th>User Name</th>
                                                    <th>User Type</th>
                                                    <th class="text-right">SD (TK)</th>
                                                    <th class="text-right">Vat (TK)</th>
                                                    <th class="text-right">TDS (TK)</th>
                                                    <th class="text-right">VDS (TK)</th>
                                                    <th class="text-right">User type Commission (TK)</th>
                                                    <th class="text-right">Other Commission (TK)</th>
                                                    {{-- <th>Grand total amount (TK)</th> --}}
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($orders->count() > 0)
                                                    
                                                    @foreach ($orders as $key => $order)
                                                        @php
                                                        $sd_amount = 0;
                                                        $vat_amount = 0;
                                                        $tds_amount = 0;
                                                        $vds_amount = 0;
                                                            // $orderDetails = App\Models\OrderDetail::where('order_id', $order->id)->get();
                                                        @endphp
                                                        {{-- @foreach ($orderDetails as $od) --}}
                                                            <tr>
                                                                <td>{{++$key}}</td>
                                                                <td class="text-left">
                                                                    {{$order->tracking_code}}
                                                                </td>
                                                                <td>
                                                                    {{$order->created_at->format('d-M-Y')}}
                                                                </td>
                                                                <td>
                                                                    {{$order->orderUserInfo->first_name ?? ''}} {{$order->orderUserInfo->last_name ?? ""}}
                                                                </td>
                                                                <td>
                                                                    @foreach ($user_types as $user_type)
                                                                        @if ($user_type['id'] == ($order->orderUserInfo->type ?? 0))
                                                                            {{$user_type['name']}}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td class="text-right">
                                                                    @php
                                                                        $sd_amount = $order->orderDetails->sum('sd_total');
                                                                        $vat_amount = $order->orderDetails->sum('vat_total');
                                                                        $tds_amount = $order->tds_amount;
                                                                        $vds_amount = $order->vds_amount;
                                                                    @endphp
                                                                    
                                                                    {{-- @foreach ($order->orderDetails as $orderDetails)
                                                                        
                                                                        @php
                                                                            $included_sd_amount = 0; // sd amount added with product price
                                                                            $order_detail_total_amount = ($orderDetails->quantity * $orderDetails->price);
                                                                            $order_detail_sd_percent = $orderDetails->productInfo->sd ?? 0;
                                                                            $order_detail_vat_percent = $orderDetails->productInfo->vat ?? 0;
                                                                            if ($order_detail_total_amount > 0) {
                                                                                if ($order_detail_sd_percent > 0) {
                                                                                    $sd_amount += ($order_detail_total_amount * $order_detail_sd_percent)/100;
                                                                                    $included_sd_amount = $order_detail_total_amount + (($order_detail_total_amount * $order_detail_sd_percent)/100);
                                                                                }
                                                                                
                                                                                if ($included_sd_amount > 0) {
                                                                                    if ($order_detail_vat_percent > 0) {
                                                                                        $vat_amount += ($included_sd_amount * $order_detail_vat_percent)/100;
                                                                                    }
                                                                                }
                                                                            }
                                                                        @endphp
                                                                    @endforeach --}}
                                                                    @php
                                                                        $total_sd_amount += $sd_amount;
                                                                        $total_vat_amount += $vat_amount;
                                                                        $total_tds_amount += $tds_amount;
                                                                        $total_vds_amount += $vds_amount;
                                                                    @endphp
                                                                    {{number_format($sd_amount,2,'.','')}} <small>({{($order->orderDetails->sum('sd')/count($order->orderDetails)) ?? "0.00"}} %)</small>
                                                                </td>
                                                                <td class="text-right">
                                                                    
                                                                    
                                                                    {{number_format($vat_amount,2,'.','')}} 
                                                                    <small>({{($order->orderDetails->sum('vat')/count($order->orderDetails)) ?? "0.00"}} %)</small>
                                                                </td>

                                                                <td class="text-right">
                                                                    
                                                                    
                                                                    {{number_format($tds_amount, 2, '.', '')}}
                                                                </td>
                                                                
                                                                <td class="text-right">
                                                                    
                                                                    
                                                                    {{number_format($vds_amount, 2, '.', '')}}
                                                                </td>

                                                                <td class="text-right">
                                                                    
                                                                    
                                                                    {{number_format($vds_amount, 2, '.', '')}}
                                                                </td>

                                                                <td class="text-right">
                                                                    @php
                                                                        $order_discount_amount += $order->discount_amount;
                                                                    @endphp
                                                                    
                                                                    {{$order->discount_amount}}
                                                                    @if ($order->user_type_discount > 0)
                                                                     ({{$order->user_type_discount}} %)
                                                                    @endif
                                                                    
                                                                    
                                                                </td>
                                                                
                                                                {{-- <td class="text-right">
                                                                    @php
                                                                        $order_discount_amount_in_total += $order->other_categories_amount;
                                                                    @endphp
                                                                    {{$order->other_categories_amount}}
                                                                    {{$order->discount_amount_in_total}}
                                                                    @if ($order->discount_on_amount == 2)
                                                                         ({{$order->discount_percent_in_total}} %)
                                                                    @endif
                                                                    
                                                                </td> --}}
                                                                
                                                            </tr>
                                                            
                                                        {{-- @endforeach --}}
                                                        {{-- @php
                                                            $i++;
                                                        @endphp --}}
                                                    @endforeach
                                                @else
                                                    <tr class="odd"><td valign="top" colspan="100%" class="dataTables_empty">No matching records found</td></tr>
                                                @endif
                                                <tr class="bg-light-success">
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="text-right">{{number_format($total_sd_amount,2,'.','')}}</th>
                                                    <th class="text-right">{{number_format($total_vat_amount,2,'.','')}}</th>
                                                    <th class="text-right">{{number_format($total_tds_amount, 2, '.', '')}}</th>
                                                    <th class="text-right">{{number_format($total_vds_amount, 2, '.', '')}}</th>
                                                    <th class="text-right">{{number_format($order_discount_amount,2,'.','')}}</th>
                                                    <th class="text-right">{{number_format($order_discount_amount_in_total,2,'.','')}}</th>
                                                
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-light-success">
                                                    
                                                <th style="text-align: left" colspan="100%">Printed by: {{auth()->user()->first_name}} {{auth()->user()->last_name}}</th>
                                                {{-- <th></th> --}}
                                            </tfoot>
                                        </table>
                                        
                                        
                                    </div>
                                </div>
                                <button class="btn btn-primary print_media" onclick="exportData()">Export</button>
                                <button class="btn btn-primary print_media" onclick="printDiv('stockPrint')">Print</button>
                                {{-- @endif --}}
                            
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

        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();   
        });
    </script>

@endpush