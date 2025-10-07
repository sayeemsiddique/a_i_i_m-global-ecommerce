@extends('backend.layout.master')

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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Dealer Commission Report</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">Dealer Commission Report</a>
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
                            <h3 class="card-title">Dealer Commission Report</h3>
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
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date"  name="fromDate" @if(isset($_GET['fromDate']) and $_GET['fromDate'] != '') value="{{$_GET['fromDate']}}" @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" @if(isset($_GET['toDate']) and $_GET['toDate'] != '') value="{{$_GET['toDate']}}" @endif>
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
                                        <td>
                                            <button type="submit" class="btn btn-success ml-2">Search</button>
                                        </td>
                                        
                                    </tr>
                                </table>
                                
                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">
                            

                            <h3 class="text-center">{{$global_setting->sub_title ?? ""}}</h3>
                                <h4 class="text-center">
                                    {{$global_setting->address ?? ""}}
                                </h4>

                                <p class="text-center">
                                    <strong>Dealer Commission Report</strong>
                                </p>
                            
                                @if (isset($_GET['user_id']) and $_GET['user_id'] != '')
                                
                                <div class="w-100" id="stockPrint">
                                    
                                    
                                    <div class="w-100 text-center">
                                        <p><strong>User:</strong> {{$user_data->first_name}} {{$user->last_name}}</p>
                                        <p><strong>Email:</strong> {{$user_data->email}}</p>
                                        <p><strong>Phone:</strong> {{$user_data->mobile}}</p>
                                    </div>
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
                                    <div class="table-responsive ajax-data-container pt-3">
                                        <table class="table table-separate table-head-custom table-checkable table-striped" id="TableData">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="text-left">Order ID</th>
                                                    <th>Date</th>
                                                    <th>Dealer Name</th>
                                                    <th class="text-right">Commision on order amount (TK)</th>
                                                    <th>Commision (%)</th>
                                                    <th class="text-right">Commision (TK)</th>
                                                    {{-- <th>Grand total amount (TK)</th> --}}
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($orders->count() > 0)
                                                    
                                                    @foreach ($orders as $key => $order)
                                                        @php
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
                                                                <td class="text-right">
                                                                    @php
                                                                        $order_total_price += $order->total_price;
                                                                        $order_discount_amount += $order->discount_amount;
                                                                    @endphp

                                                                    {{ $order->total_price }}
                                                                    
                                                                </td>
                                                                <td>
                                                                    {{ $order->user_type_discount }}
                                                                </td>
                                                                <td class="text-right">
                                                                    {{ $order->discount_amount }}
                                                                    
                                                                </td>
                                                                {{-- <td>
                                                                    {{$order->grand_total_price}}
                                                                </td> --}}
                                                            </tr>
                                                            @php
                                                                // $totalPrice += $subPrice;
                                                                // $totalQuantity += $quantity;
                                                            @endphp
                                                        {{-- @endforeach --}}
                                                        {{-- @php
                                                            $i++;
                                                        @endphp --}}
                                                    @endforeach
                                                @else
                                                    <tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>
                                                @endif
                                                <tr class="bg-light-success">
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="text-right"><strong>Total:</strong> {{number_format($order_total_price,2,'.','')}} </th>
                                                    <th></th>
                                                    <th class="text-right"><strong>Total:</strong> {{number_format($order_discount_amount,2,'.','')}}</th>
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