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
    $filter_product_name = '';
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
                            <h3 class="card-title">Product Inventory</h3>
                            <div class="d-flex align-items-center">
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0">

                            {{-- <form class="form-inline" action="{{ route('admin.stockReport.filter',['type'=>$type]) }}" method="GET"> --}}
                            <form class="form-inline" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" name="fromDate" @if(isset($_GET['fromDate']) and $_GET['fromDate'] != '') value="{{$_GET['fromDate']}}" @endif>
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
                                                <label class="pr-2 pl-2">Product Category</label>
                                                <select class="form-control select2" name="category_id" id="category_id">
                                                    <option value="">--Select a Category--</option>
                                                    @foreach ($product_category as $category)
                                                        <option @if(isset($_GET['category_id']) and $_GET['category_id'] == $category->id) selected
                                                        @php
                                                            $filter_category_name = $category->name;
                                                        @endphp
                                                        @endif value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Product</label>
                                                <select class="form-control select2" name="product_id" id="product_id">
                                                    <option value="">--Select a Product--</option>
                                                    @foreach ($product_datas as $product)
                                                        <option @if(isset($_GET['product_id']) and $_GET['product_id'] == $product->id) selected
                                                            @php
                                                            $filter_product_name = $product->name;
                                                        @endphp
                                                            @endif value="{{ $product->id }}">{{ ucfirst($product->name) }} [{{ $product->code }}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Stock In/Out</label>
                                                <select class="form-control" name="stockType">
                                                    <option value="">--Select a value--</option>
                                                    <option value="1">Stock In</option>
                                                    <option value="2">Stock Out</option>
                                                </select>
                                            </div>
                                        </td> --}}
                                        {{-- <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" name="order_id" value="{{old('order_id')}}" placeholder="Search by Order ID">
                                            </div>
                                        </td> --}}
                                        <td>
                                            <button type="submit" class="btn btn-success ml-2">Search</button>
                                            <a href="{{route('admin.stockReport.index')}}" class="btn btn-danger ml-2">Reset Search</a>
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
                                        <strong>Product Inventory Report</strong>
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

                                    @if (isset($_GET['category_id']) and $_GET['category_id'] !='')
                                    <p class="text-center"> <strong>Product Category:</strong> {{$filter_category_name}}</p>
                                    @endif


                                    @if (isset($_GET['product_id']) and $_GET['product_id'] !='')
                                    <p class="text-center"> <strong>Product:</strong> {{$filter_product_name}}</p>
                                    @endif
                                </div>

                                <table class="table table-separate table-head-custom table-checkable table-striped" id="TableData">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">Product</th>
                                            <th>Product Code</th>
                                            <th>Variant</th>
                                            <th>Opening Stock</th>
                                            <th>Total Stock In</th>
                                            <th>Total Sales</th>
                                            <th>Total Damage</th>
                                            <th>Current Stock</th>

                                            {{-- <th>Quantity (Pcs)</th> --}}
                                            {{-- <th>Weight (KG)</th> --}}
                                            {{-- <th>Total Weight (KG)</th> --}}
                                            {{-- <th>Price</th> --}}
                                            {{-- <th>Total Price</th> --}}
                                            {{-- <th>Weight (M.T)</th> --}}
                                            <th>Last Update</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                                $i = 1;
                                                $quantity = 0;
                                                $weight = 0;
                                                $totalQuantity = 0;
                                                $subWeight = 0;
                                                $totalWeight = 0;
                                                $price = 0;
                                                $subPrice = 0;
                                                $totalPrice = 0;
                                                $total_initial_stock_quantity = 0;
                                                $total_stock_quantity_except_initial = 0;
                                                $total_stockout_quantity = 0;
                                                $total_damage_quantity = 0;
                                                $total_current_stock = 0;
                                            @endphp
                                        @if ($products->count() > 0)

                                            @foreach ($products as $product)
                                            @php
                                                $initial_stock_quantity = 0;
                                                $stock_quantity_except_initial = 0;
                                                $stockout_quantity = 0;
                                                $damage_quantity = 0;
                                                $initial_stock_quantity_array = [];
                                                $stock_quantity_except_initial_array = [];
                                                $damage_quantity_array = [];
                                                $stockout_quantity_array = [];
                                                $in_stock_quantity_array = [];
                                                $in_stock_weight_array = [];
                                                $in_stock_unit_array = [];
                                                $weight_array = [];
                                                $in_stock_created_array = [];
                                                $varient_price_array = [];
                                            @endphp



                                                    @if ($product->has_varient == 1)

                                                        @foreach ($product->productVarient as $index_id => $productVarient)
                                                            @php
                                                                $initial_stock_quantity_varient = 0;
                                                                $stock_quantity_except_initial_varient = 0;
                                                                $stockout_quantity_varient = 0;
                                                                $damage_quantity_varient = 0;

                                                                // $in_stock_quantity_array[] = $productVarient->productStock->quantity ?? 0;
                                                                $in_stock_created_array[] = $productVarient->productStock->created_at ?? 0;

                                                                $varient_price_array[] = $productVarient->price ?? 0;

                                                                $product_order_details_info_query = \App\Models\OrderDetail::where('varient_id', $productVarient->id);
                                                                    // $product_order_details_info = $product->orderDetailsInfo;
                                                                if (isset($_GET['fromDate']) and $_GET['fromDate'] !='') {
                                                                    $product_order_details_info_query->whereDate('created_at','>=',$_GET['fromDate']);
                                                                }

                                                                if (isset($_GET['toDate']) and $_GET['toDate'] !='') {
                                                                    $product_order_details_info_query->whereDate('created_at','<=',$_GET['toDate']);
                                                                }

                                                                $product_order_details_info = $product_order_details_info_query->latest()->get();
                                                            @endphp

                                                            {{-- @foreach ($productVarient->orderDetailsVarientInfo as $orderDetailsVarientInfo) --}}
                                                            @foreach ($product_order_details_info as $orderDetailsVarientInfo)

                                                                @php
                                                                    if (($orderDetailsVarientInfo->orderInfo->type ?? 0) == 3) {

                                                                        $initial_stock_quantity_varient += $orderDetailsVarientInfo->quantity;
                                                                    } else if (($orderDetailsVarientInfo->orderInfo->type ?? 0) == 1) {

                                                                        $stock_quantity_except_initial_varient += $orderDetailsVarientInfo->quantity;

                                                                    } else if (in_array(($orderDetailsVarientInfo->orderInfo->type ?? 0), [2]) and in_array(($orderDetailsVarientInfo->orderInfo->stage ?? 0), [3,4])) {

                                                                        $stockout_quantity_varient += $orderDetailsVarientInfo->quantity;

                                                                    } else if (in_array(($orderDetailsVarientInfo->orderInfo->type ?? 0), [4]) and in_array(($orderDetailsVarientInfo->orderInfo->stage ?? 0), [3,4])) {

                                                                        $stockout_quantity_varient += $orderDetailsVarientInfo->quantity;

                                                                    } else if (in_array(($orderDetailsVarientInfo->orderInfo->type ?? 0), [5])) {

                                                                        $damage_quantity_varient += $orderDetailsVarientInfo->quantity;

                                                                    } else if (in_array(($orderDetailsVarientInfo->orderInfo->type ?? 0), [2])) {

                                                                        if (in_array(($orderDetailsVarientInfo->orderInfo->status ?? 0),[1,3]) and in_array(($orderDetailsVarientInfo->orderInfo->stage ?? 0),[3,4])) {
                                                                            $stockout_quantity_varient += $orderDetailsVarientInfo->quantity;
                                                                        }

                                                                    }
                                                                @endphp


                                                            @endforeach

                                                            @php
                                                                $initial_stock_quantity_array[] = $initial_stock_quantity_varient;
                                                                $stock_quantity_except_initial_array[] = $stock_quantity_except_initial_varient;
                                                                $damage_quantity_array[] = $damage_quantity_varient;
                                                                $stockout_quantity_array[] = $stockout_quantity_varient;
                                                                $in_stock_weight_array[] = $productVarient->weight;
                                                                $in_stock_unit_array[] = $productVarient->unit;
                                                            @endphp






                                                            <tr>
                                                                <td>
                                                                    @if ($loop->first)
                                                                    {{$i}}
                                                                    @endif
                                                                    {{-- <small>({{++$index_id}})</small> --}}
                                                                </td>

                                                                <td class="text-left">
                                                                    {{-- <img width="80px" src="{{asset('storage/product/'.$product->image ?? '')}}" alt="{{$product->name ?? ''}}"> --}}
                                                                    @if ($loop->first)
                                                                    {{$product->name}}
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    @if ($loop->first)
                                                                        {{$product->code}}
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    @foreach ($productVarient->productVarientData as $VarientData)
                                                                        {{$VarientData->data_value}}

                                                                        @if ($loop->last)

                                                                        @else
                                                                        ,
                                                                        @endif
                                                                    @endforeach

                                                                </td>

                                                                <td>
                                                                    {{$initial_stock_quantity_varient}}

                                                                </td>
                                                                <td>
                                                                    {{$stock_quantity_except_initial_varient}}
                                                                </td>

                                                                <td>
                                                                    {{$stockout_quantity_varient}}

                                                                </td>

                                                                <td>
                                                                    {{$damage_quantity_varient}}
                                                                </td>

                                                                <td>
                                                                    @php
                                                                        $in_stock_quantity = ($initial_stock_quantity_varient + $stock_quantity_except_initial_varient) - ($stockout_quantity_varient + $damage_quantity_varient);
                                                                    @endphp
                                                                    {{ $in_stock_quantity }}
                                                                </td>

                                                                {{-- <td>
                                                                    {{$productVarient->price ?? 0}}
                                                                </td> --}}



                                                                {{-- <td>
                                                                    {{($productVarient->price ?? 0) * $in_stock_quantity}}
                                                                </td> --}}

                                                                {{-- <td>

                                                                        @php
                                                                            if ($in_stock_quantity > 0 and $productVarient->weight > 0 and $productVarient->unit > 0) {
                                                                                if ($productVarient->unit == 1) {
                                                                                    $product_weight = ($in_stock_quantity_data * $in_stock_weight_array[$index1]);
                                                                                } else if($productVarient->unit == 2) {
                                                                                    $product_weight = (($in_stock_quantity_data * 1000) * $in_stock_weight_array[$index1]);
                                                                                } else {
                                                                                    $product_weight = 0;
                                                                                }
                                                                            } else {
                                                                                $product_weight = 0;
                                                                            }
                                                                        @endphp
                                                                    {{number_format($product_weight,2,'.','')}}
                                                                </td> --}}

                                                                <td>
                                                                    @if (($productVarient->productStock->created_at ?? '') != '')
                                                                        {{ $productVarient->productStock->created_at->format('d-M-Y') }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        @foreach ($initial_stock_quantity_array as $keyin => $initial_stock_quantity_data)
                                                            @php
                                                                $total_initial_stock_quantity += $initial_stock_quantity_data;
                                                                $in_stock_quantity_array[] = ($initial_stock_quantity_data + $stock_quantity_except_initial_array[$keyin]) - ($stockout_quantity_array[$keyin] + $damage_quantity_array[$keyin]);
                                                            @endphp
                                                        @endforeach

                                                        @foreach ($stock_quantity_except_initial_array as $stock_quantity_except_initial_data)
                                                            @php
                                                                $total_stock_quantity_except_initial += $stock_quantity_except_initial_data;
                                                            @endphp

                                                        @endforeach

                                                        @foreach ($stockout_quantity_array as $stockout_quantity_data)
                                                            @php
                                                                $total_stockout_quantity += $stockout_quantity_data;
                                                            @endphp

                                                        @endforeach

                                                        @foreach ($damage_quantity_array as $damage_quantity_data)
                                                            @php
                                                                $total_damage_quantity += $damage_quantity_data;
                                                            @endphp

                                                        @endforeach

                                                        @foreach ($in_stock_quantity_array as $in_stock_quantity_data)
                                                            @php
                                                                $total_current_stock += $in_stock_quantity_data;
                                                            @endphp

                                                        @endforeach

                                                        @foreach ($varient_price_array as $index => $varient_price_data)
                                                            @php
                                                                $totalPrice += ($varient_price_data * ($in_stock_quantity_array[$index] ?? 0));
                                                            @endphp

                                                        @endforeach

                                                        @foreach ($in_stock_quantity_array as $index1 => $in_stock_quantity_data)
                                                            @php
                                                                if ($in_stock_quantity_data > 0 and $in_stock_weight_array[$index1] > 0 and $in_stock_unit_array[$index1] > 0) {
                                                                    if ($in_stock_unit_array[$index1] == 1) {
                                                                        // $totalWeight += ($in_stock_quantity_data * $in_stock_weight_array[$index1]);
                                                                        $weight_array[] = ($in_stock_quantity_data * $in_stock_weight_array[$index1]);
                                                                    } else if($in_stock_unit_array[$index1] == 1) {
                                                                        // $totalWeight += (($in_stock_quantity_data * 1000) * $in_stock_weight_array[$index1]);
                                                                        $weight_array[] = (($in_stock_quantity_data * 1000) * $in_stock_weight_array[$index1]);
                                                                    } else {
                                                                        $weight_array[] = 0;
                                                                    }
                                                                } else {
                                                                    $weight_array[] = 0;
                                                                }
                                                            @endphp
                                                        @endforeach

                                                        @foreach ($weight_array as $weight_Index)
                                                            @php
                                                                $totalWeight += $weight_Index;
                                                            @endphp
                                                            {{-- {{number_format($weight_Index,2,'.','')}} --}}


                                                        @endforeach



                                                    @else
                                                        <tr>
                                                            <td>{{$i}}</td>

                                                            <td class="text-left">
                                                                {{-- <img width="80px" src="{{asset('storage/product/'.$product->image ?? '')}}" alt="{{$product->name ?? ''}}"> --}}
                                                                {{$product->name}}
                                                            </td>

                                                            <td>{{$product->code}}</td>

                                                            <td></td>

                                                            <td>
                                                                @php
                                                                    $product_order_details_info_query = \App\Models\OrderDetail::where('product_id', $product->id);
                                                                    // $product_order_details_info = $product->orderDetailsInfo;
                                                                    if (isset($_GET['fromDate']) and $_GET['fromDate'] !='') {
                                                                        $product_order_details_info_query->whereDate('created_at','>=',$_GET['fromDate']);
                                                                    }

                                                                    if (isset($_GET['toDate']) and $_GET['toDate'] !='') {
                                                                        $product_order_details_info_query->whereDate('created_at','<=',$_GET['toDate']);
                                                                    }

                                                                    $product_order_details_info = $product_order_details_info_query->latest()->get();
                                                                    foreach($product_order_details_info as $orderDetailsInfo) {
                                                                        if (($orderDetailsInfo->orderInfo->type ?? 0) == 3) {

                                                                            $initial_stock_quantity += $orderDetailsInfo->quantity;
                                                                            $total_initial_stock_quantity += $orderDetailsInfo->quantity;

                                                                        } else if (($orderDetailsInfo->orderInfo->type ?? 0) == 1) {

                                                                            $total_stock_quantity_except_initial += $orderDetailsInfo->quantity;
                                                                            $stock_quantity_except_initial += $orderDetailsInfo->quantity;

                                                                        } else if (in_array(($orderDetailsInfo->orderInfo->type ?? 0), [4]) and in_array(($orderDetailsInfo->orderInfo->stage ?? 0), [3,4])) {

                                                                            $total_stockout_quantity += $orderDetailsInfo->quantity;
                                                                            $stockout_quantity += $orderDetailsInfo->quantity;

                                                                        } else if (in_array(($orderDetailsInfo->orderInfo->type ?? 0), [5])) {

                                                                            $total_damage_quantity += $orderDetailsInfo->quantity;
                                                                            $damage_quantity += $orderDetailsInfo->quantity;

                                                                        } else if (in_array(($orderDetailsInfo->orderInfo->type ?? 0), [2])) {

                                                                            if (in_array(($orderDetailsInfo->orderInfo->status ?? 0),[1,3]) and in_array(($orderDetailsInfo->orderInfo->stage ?? 0),[4,3])) {
                                                                                $total_stockout_quantity += $orderDetailsInfo->quantity;
                                                                                $stockout_quantity += $orderDetailsInfo->quantity;
                                                                            }


                                                                        }

                                                                    }
                                                                @endphp
                                                                {{number_format($initial_stock_quantity,0,'.','')}}
                                                            </td>


                                                            <td>
                                                                {{number_format($stock_quantity_except_initial,0,'.','')}}

                                                            </td>

                                                            <td>
                                                                {{number_format($stockout_quantity,0,'.','')}}

                                                            </td>
                                                            <td>
                                                                {{number_format($damage_quantity,0,'.','')}}
                                                            </td>

                                                            <td>

                                                                {{-- stock balance --}}
                                                                @php
                                                                    $current_stock = ($initial_stock_quantity + $stock_quantity_except_initial)- ($damage_quantity + $stockout_quantity);
                                                                @endphp

                                                                @if ($current_stock < 0)
                                                                    @php
                                                                        $current_stock = 0;
                                                                    @endphp

                                                                @endif
                                                                @php
                                                                    $total_current_stock += $current_stock;
                                                                @endphp
                                                                {{number_format($current_stock,0,'.','')}}

                                                            </td>

                                                            {{-- <td>
                                                                {{$product->price}}
                                                            </td> --}}

                                                            {{-- <td>
                                                                @php
                                                                    $subPrice = $current_stock * $product->price;
                                                                @endphp
                                                                {{ number_format($subPrice,2,'.','') }}
                                                            </td> --}}

                                                            {{-- <td>
                                                                @if ($product->weight and $product->unit)
                                                                @if ($product->unit == 1)
                                                                    {{number_format(($product->weight * $current_stock), 2 , '.','')}}
                                                                    @php
                                                                        $totalWeight += ($product->weight * $current_stock);
                                                                    @endphp
                                                                @elseif($product->unit == 2)
                                                                    {{number_format((($product->weight * 1000) * $current_stock), 2 , '.','')}}
                                                                    @php
                                                                        $totalWeight += (($product->weight * 1000) * $current_stock);
                                                                    @endphp
                                                                @endif

                                                                @endif
                                                            </td> --}}

                                                            <td>
                                                                {{-- @if (isset($product->stock->updated_at))
                                                                    {{ $product->stock->updated_at->format('d-M-Y') }}
                                                                @elseif(isset($product->stock->created_at))
                                                                    {{ $product->stock->created_at->format('d-M-Y') }}
                                                                @endif --}}
                                                            </td>
                                                        </tr>



                                                    @endif
                                                @php
                                                    $i++;
                                                    // $totalQuantity += $current_stock;
                                                    // $totalWeight += $subWeight;
                                                    $totalPrice += $subPrice;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr class="odd">
                                                <td valign="top" colspan="100%" class="dataTables_empty">No matching records found</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Total</th>
                                            <th>{{$total_initial_stock_quantity ?? 0}} (PCS)</th>
                                            <th>{{$total_stock_quantity_except_initial ?? 0}} (PCS)</th>
                                            <th>{{$total_stockout_quantity ?? 0}} (PCS)</th>
                                            <th>{{$total_damage_quantity ?? 0}} (PCS)</th>
                                            <th>{{$total_current_stock ?? 0}} (PCS)</th>
                                            {{-- <th></th> --}}
                                            {{-- <th>{{number_format($totalPrice,2,'.','')}} (TK)</th> --}}
                                            {{-- <th>{{number_format(($totalWeight/100),2,'.','')}}</th> --}}
                                            <th></th>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-light-success">
                                        <th style="text-align: left" colspan="100%">Printed by: {{auth()->user()->first_name}} {{auth()->user()->last_name}}</th>
                                        {{-- <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th>{{$total_initial_stock_quantity ?? 0}} (PCS)</th>
                                        <th>{{$total_stock_quantity_except_initial ?? 0}} (PCS)</th>
                                        <th>{{$total_stockout_quantity ?? 0}} (PCS)</th>
                                        <th>{{$total_damage_quantity ?? 0}} (PCS)</th>
                                        <th>{{$total_current_stock ?? 0}} (PCS)</th>
                                        <th></th>
                                        <th>{{number_format($totalPrice,2,'.','')}} (TK)</th>
                                        <th>{{number_format(($totalWeight/100),2,'.','')}}</th>
                                        <th></th> --}}
                                    </tfoot>
                                    {{-- <tfoot class="table_footer">
                                        <th colspan="100%">Printed by: {{auth()->user()->first_name}} {{auth()->user()->last_name}}</th>

                                    </tfoot> --}}
                                </table>


                            </div>

                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary print_media" onclick="exportData()">Export</button>
                            <button class="btn btn-primary print_media" onclick="printDiv('stockPrint','{{auth()->user()->first_name}} {{auth()->user()->first_name}}')">Print</button>
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
        function printDiv(divName,user_name) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

@endpush
