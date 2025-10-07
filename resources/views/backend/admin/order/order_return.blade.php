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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Order Return</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">Order Return</a>
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
                            <h3 class="card-title">Order Return</h3>
                            <div class="d-flex align-items-center"> 

                                                            
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">
                    
                            <form class="form-inline"  method="GET">
                                <table>
                                    <tr>
                                        
                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" name="order_id" value="{{$_GET['order_id'] ?? ""}}" placeholder="Search by Order ID" autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success mt-2 ml-2">Show</button>
                                        </td>
                                        
                                    </tr>
                                </table>
                                
                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">
                            
                            
                            @if ($order)
                            <hr>

                            <div class="container mb-5">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6">
                                        <span class="font-weight-bold"><b>Invoice Number:</b> {{ $order->invoice_no = sprintf('%08d', $order->invoice_no) }}</span> <br>
                                        <span class="font-weight-bold"><b>Invoice Date:</b> {{ date('d-M-Y') }}</span> <br> <br>

                                        <span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
                                        <span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
                                        <span class="font-weight-bold"><b>Status:</b>
                                            @if ($order->stage == 0)
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($order->stage == 1)
                                                <span class="badge badge-primary">Order Accepted</span>
                                            @elseif($order->stage == 2)
                                                <span class="badge badge-danger">Order Declined</span>
                                            @elseif($order->stage == 3)
                                                <span class="badge badge-primary">On Delivery</span>
                                            @elseif($order->stage == 4)
                                                <span class="badge badge-success">Order Complete</span>
                                            @elseif($order->stage == 5)
                                                <span class="badge badge-danger">Order Canceled</span>
                                            @else
                                                <span class="badge badge-danger">Unknown Status</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-md-7"></div>
                                    <div class="col-md-2">
                                        @if (isset($order->orderUserInfo) && ($order->orderUserInfo->type == 0))
                                            <span class="d-block" style="font-size: 15px;"><b>User Type :</b> System User</span>
                                        @elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 1))
                                            <span class="d-block" style="font-size: 15px;"><b>User Type :</b> Consumer</span>
                                        @elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 2))
                                            <span class="d-block" style="font-size: 15px;"><b>User Type :</b> Corporate Consumer</span>
                                        @elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 3))
                                            <span class="d-block" style="font-size: 15px;"><b>User Type :</b> Dealer</span>
                                        @endif

                                        <span class="d-block" style="font-size: 15px;"><b>User Name :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->first_name : ''}} {{ $order->orderUserInfo ? $order->orderUserInfo->last_name : ''}} </span>

                                        <span class="d-block" style="font-size: 15px;"><b>Email :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->email : ''}} </span>

                                        <span class="d-block" style="font-size: 15px;"><b>Mobile :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->mobile : ''}} </span>

                                        <span class="d-block" style="font-size: 15px;"><b>Address :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->present_address : '' }} </span>

                                    </div>
                                </div>
                            </div>

                            <div class="container top-0 left-0 right-0">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <form action="{{route("admin.order.order_return_confirm")}}" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$order->id}}">
                                            {{-- for calculation --}}
                                            <input class="courier_cost" type="hidden" value="{{$order->courier_cost ? $order->courier_cost:0}}">
                                            {{-- user_type_discount if user is in 2,3 then their discount type --}}
                                            <input class="user_type_discount" type="hidden" value="{{$order->user_type_discount ? $order->user_type_discount:0}}">
                                            <input class="discount_on_amount" type="hidden" value="{{$order->discount_on_amount ? $order->discount_on_amount:0}}">
                                            <input class="discount_percent_in_total" type="hidden" value="{{$order->discount_percent_in_total ? $order->discount_percent_in_total:0}}">
                                            <input class="discount_amount_in_total" type="hidden" value="{{$order->discount_amount_in_total ? $order->discount_amount_in_total:0}}">
                                            <input class="packing_type" type="hidden" value="{{$order->packing_type ? $order->packing_type:0}}">
                                            <input class="packing_amount" type="hidden" value="{{$order->packing_amount ? $order->packing_amount:0}}">
                                            <input class="dealer_discount_percent" type="hidden" value="{{$setting->dealer_discount_percent ?? 0}}">
                                            <input class="consumer_discount_percent" type="hidden" value="{{$setting->consumer_discount_percent ?? 0}}">
                                            {{-- if user checkout more then this amount --}}
                                            <input class="discount_amount" type="hidden" value="{{$setting->discount_amount ?? 0}}">
                                            {{-- if user checkout more then this amount then he get this % duscount--}}
                                            <input class="discount_percentage" type="hidden" value="{{$setting->discount_percentage ?? 0}}">
                                            {{-- for calculation --}}


                                                <table class="table table-responseve">
                                                    <thead>
                                                        <tr>
                                                            <th class="pl-0 font-weight-bold text-muted text-uppercase text-left">Ordered Items</th>
                                                            <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                                                            <th class="text-left font-weight-bold text-muted text-uppercase">Return Qty</th>
                                                            <th class="text-right font-weight-bold text-muted text-uppercase">Unit Price</th>
                                                            <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $subTotal = 0;
                                                            $totalProductPrice = 0;
                                                            $orderUserType = 0;
                                                            // $discount = 0;
                                                            // $discountPrice = 0;
                                                            // $vatAmount = 0;
                                                            // $taxAmount = 0;
                                                            $shippingArea = 0;
                                                            $shippingCharge = 0;
                                                            $shippingPrice = 0;
                                                        @endphp
                                                        @foreach ($order->orderDetails as $order_detail)
                                                            @if ($order_detail->quantity > 0)
                                                            <tr class="font-weight-boldest">
                                                                <td class="border-0 pl-0 pt-7 d-flex align-items-center">
                                                                    <input type="hidden" name="product_id[]" value="{{$order_detail->product_id}}">
                                                                    <input type="hidden" name="varient_id[]" value="{{$order_detail->varient_id}}">
                                                                    <input type="hidden" name="order_details_id[]" value="{{$order_detail->id}}">
                                                                    <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
                                                                        <div class="symbol-label" style="background-image: url('{{asset('storage/product')}}/{{$order_detail->productInfo->image ?? ""}}')"></div>
                                                                    </div>
                                                                    {{$order_detail->productInfo->name ?? ''}}
                                                                </td>
                                                                <td class="text-right pt-7 align-middle">
                                                                    {{$order_detail->quantity}}
                                                                </td>
                                                                
                                                                <td class="text-right pt-7 align-middle">
                                                                    <input autocomplete="off" style="max-width:200px;" type="number" class="form-control" name="qty[]" placeholder="Return Qty" max="{{$order_detail->quantity}}">
                                                                </td>
                                                                <td class="text-right pt-7 align-middle">
                                                                    {{$order_detail->price}}
                                                                </td>
                                                                <td class="text-primary pr-0 pt-7 text-right align-middle">
                                                                    ৳ {{number_format($subTotal = $order_detail->price * $order_detail->quantity,2,".","")}}
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $totalProductPrice += $subTotal;
                                                            @endphp
                                                            @endif
                                                            
                                                        @endforeach
    
                                                        <!--Show area wise shipping charge-->
                                                        <tr>
                                                            @php
                                                                $shippingArea = $order->shipping_area ? $order->shipping_area : 0;
                                                            @endphp
    
                                                            
                                                            <th class="text-right" colspan="4">Shipping Charge</th>
                                                            <th class="text-right">
                                                                ৳ <span>
                                                                    {{$order->courier_cost}}
                                                                </span>
                                                            </th>
                                                            
    
                                                            <!--calculate shipping price and show total-->
                                                            @php
                                                                $shippingPrice = $totalProductPrice + $shippingCharge;
                                                            @endphp
                                                        </tr>
    
                                                        <!--Show total price-->
                                                        
                                                        <tr style="border-top: 1px solid #000;">
                                                            <th class="text-right" colspan="4">Total</th>
                                                            <th class="text-right">৳ {{$order->grand_total_price}}</th>
                                                        </tr>

                                                        <tr style="border-top: 1px solid #000;">
                                                            <th class="text-right" colspan="4">Return Remarks <span class="text-danger">*</span> </th>
                                                            <th class="text-right">
                                                                <textarea required name="remark" class="form-control" placeholder="Your Renarks"></textarea>
                                                            </th>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                                <div class="w-100 float-right">
                                                    <button type="submit" name="whole_return" value="1" class="btn btn-danger">Whole Return Order</button>
                                                    <button type="submit" class="btn btn-primary">Return Order</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection