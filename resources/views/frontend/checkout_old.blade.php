@extends('frontend.layout.master_alt')

@push('css')
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

    <style>
        .conditional_area {
            margin-left: 20px;
        }
        #sslczPayBtn {
            text-transform: uppercase;
            border: 0;
            background: #1ac675;
            border-radius: 35px;
            padding: 10px 25px;
            color: white;
        }
        #sslczPayBtn h4{
            font-weight: 900;
        }
    </style>
@endpush

@section('content')
    @php
        $product_total_price = 0;
        $product_factory_total_price = 0;
        $discount_amount = 0;
        $tds_amount = 0;
        $total_sd = 0;
        $total_vat = 0;
        $tds_amount = 0;
        $get_discount_after_amount = $setting->discount_amount ?? 1500000;
        $get_discount_percentage = $setting->discount_percentage ?? 2;


        $packing_normal = $setting->packing_normal ?? 0;
        $packing_standard = $setting->packing_standard ?? 0;
        $dealer_15plus_discount_amount = $setting->dealer_15plus_discount_amount ?? 0;
        $tds_percent = $setting->tds ?? 0;
        $vds_percent = $setting->vds ?? 0;


        $packing_category_array = array();
        $has_packing_types = 0;
        $category_array=array();
        $other_categories= $setting->other_category ?? "";
        $other_categories_amount= 0;
        $allow_2_percent_discount= 0;

        if ($other_categories != '') {
            foreach ($carts as $cart_data) {
                if (in_array(($cart_data->productInfo->category_id ?? 0),explode(",",$other_categories)) ) {
                    $other_categories_amount = $setting->other_charge ?? 0;
                    break;
                }
            }
        }


        $inside_vds_amount = ($setting->courier_inside_dhaka * $vds_percent)/100;
        $outside_vds_amount = ($setting->courier_outside_dhaka * $vds_percent)/100;


        if(count($packing_types)) {

            foreach ($packing_types as  $packingtype) {

                if ($packingtype->category_id != '') {
                    array_push($category_array,explode(",",$packingtype->category_id));
                    $amount_for_packing = 0;
                    foreach ($carts as $cart_data) {
                        if (in_array(($cart_data->productInfo->category_id ?? 0),explode(",",$packingtype->category_id)) ) {
                            $has_packing_types = 1;
                            if ($cart_data->variation_id > 0) {
                                // $amount_for_packing += (($cart_data->varientInfo->discount_price ?? 0) * $cart_data->quantity);
                                $amount_for_packing += (($cart_data->varientInfo->price ?? 0) * $cart_data->quantity);
                            } else {
                                // $amount_for_packing += (($cart_data->productInfo->discount_price ?? 0) * $cart_data->quantity);
                                $amount_for_packing += (($cart_data->productInfo->price ?? 0) * $cart_data->quantity);
                            }

                        }
                    }
                    $packingtype->packing_amount = ($amount_for_packing * $packingtype->charge)/100;

                }
            }
        }

        $category_array = call_user_func_array('array_merge', $category_array);
    @endphp

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="checkout-page">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('index') }}">Home</a></li>

                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="container">
            <div class="mb-5">
                <h1 class="text-center">Checkout</h1>
            </div>

            <form action="{{ route('checkout_complete') }}" id="save_checkout"  method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-5 order-lg-2 mb-7 mb-lg-0">
                        <div class="pl-lg-3 ">
                            <div class="bg-gray-1 rounded-lg">
                                <!-- Order Summary -->
                                <div class="p-4 mb-4 checkout-table">
                                    <!-- Title -->
                                    <div class="border-bottom border-color-1 mb-5">
                                        <h3 class="section-title mb-0 pb-2 font-size-25">Your order</h3>
                                    </div>
                                    <!-- End Title -->

                                    <!-- Product Content -->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carts as $cart)
                                            @php
                                                $cart_product_price_with_sd = 0;

                                                if (($cart->productInfo->productCategory->allow_discount ?? 0) == 1) {
                                                    $allow_2_percent_discount = 1;
                                                }
                                            @endphp
                                                <tr class="cart_item">
                                                    <td>
                                                        {{$cart->productInfo->name ?? ''}}<strong class="product-quantity">× {{$cart->quantity}}</strong>
                                                    </td>
                                                    <td>
                                                        ৳ @if ($cart->variation_id == 0)
                                                        @php
                                                            $product_total_price +=  ($cart->productInfo->discount_price ?? 0)  * $cart->quantity;
                                                            $product_factory_total_price +=  ($cart->productInfo->price ?? 0)  * $cart->quantity;
                                                            // $total_sd += $cart_product_price_with_sd = ((($cart->productInfo->price ?? 0) * $cart->quantity) * ($cart->productInfo->sd ?? 0))/100;
                                                            $cart_product_price_with_sd = ((($cart->productInfo->price ?? 0) * $cart->quantity) * ($cart->productInfo->sd ?? 0))/100;
                                                            $total_sd += $cart_product_price_with_sd;
                                                            // $total_vat += (($cart_product_price_with_sd + ($cart->productInfo->price ?? 0)) * ($cart->productInfo->vat ?? 0))/100;
                                                            // $total_vat += ($cart_product_price_with_sd + (($cart->productInfo->price ?? 0) * $cart->quantity))/100;
                                                            $total_vat += (($cart_product_price_with_sd + (($cart->productInfo->price ?? 0) * $cart->quantity)) * $cart->productInfo->vat)/100;
                                                        @endphp
                                                            {{number_format(($cart->productInfo->price ?? 0)  * $cart->quantity, 2,".","")}}
                                                        @else
                                                        @php
                                                            $product_total_price +=  ($cart->varientInfo->discount_price ?? 0)  * $cart->quantity;
                                                            $product_factory_total_price +=  ($cart->varientInfo->price ?? 0)  * $cart->quantity;
                                                            $cart_product_price_with_sd = ((($cart->varientInfo->price ?? 0) * $cart->quantity) * ($cart->varientInfo->sd ?? 0))/100;
                                                            $total_sd += $cart_product_price_with_sd;
                                                            // $total_vat += (($cart_product_price_with_sd + ($cart->varientInfo->price ?? 0)) * ($cart->varientInfo->vat ?? 0))/100;
                                                            $total_vat += (($cart_product_price_with_sd + (($cart->varientInfo->price ?? 0) * $cart->quantity)) * $cart->varientInfo->vat)/100;
                                                        @endphp
                                                            {{-- {{number_format(($cart->varientInfo->discount_price ?? 0)  * $cart->quantity,2,".","")}} --}}
                                                            {{number_format(($cart->varientInfo->price ?? 0)  * $cart->quantity,2,".","")}}
                                                        @endif


                                                        {{-- {{dd($category_array)}} --}}
                                                        {{-- @if (in_array(($cart->productInfo->category_id ?? 0),$category_array))
                                                            <select id="packing_type" name="packing_type[{{$cart->product_id}}]" class="form-control packing_price" autocomplete="off" required>
                                                                <option value="">Select</option>
                                                                @foreach ($packing_types as $packing_type)
                                                                    @if ($packing_type->charge > 0 and $packing_type->category_id != "")
                                                                    @if (in_array(($cart->productInfo->category_id ?? 0),explode(',',$packing_type->category_id)))
                                                                    @php
                                                                        if ($cart->variation_id > 0) {
                                                                            $amount_for_packing = (($cart->varientInfo->discount_price ?? 0) * $cart->quantity);
                                                                        } else {
                                                                            $amount_for_packing = (($cart->productInfo->discount_price ?? 0) * $cart->quantity);
                                                                        }
                                                                    @endphp
                                                                            <option data-packing_amount="{{number_format((($amount_for_packing * $packing_type->charge)/100),2,".","")}}" value="{{$packing_type->id}}">{{$packing_type->name}} (৳ {{number_format((($amount_for_packing * $packing_type->charge)/100),2,".","")}})
                                                                            </option>
                                                                        @endif
                                                                    @endif

                                                                @endforeach
                                                            </select>
                                                        @endif --}}

                                                    </td>
                                                </tr>
                                                <input type="hidden" name="cart_id[]" value="{{$cart->id}}">
                                            @endforeach

                                        </tbody>
                                        <tfoot class="mt-3">

                                            <tr>
                                                <th>SD</th>
                                                <td>
                                                    ৳ {{number_format($total_sd,2,".","")}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>VAT</th>
                                                <td>
                                                    ৳ {{number_format($total_vat,2,".","")}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Sub-total</th>
                                                <td>
                                                    ৳ {{number_format($product_total_price,2,".","")}}
                                                </td>
                                            </tr>
                                            {{-- @if (auth()->check() and in_array(auth()->user()->type,[2,3])) --}}
                                            <tr class="d-none">
                                                <th>Commission</th>
                                                <td>
                                                    @php
                                                        if (auth()->user()->type == 3) {
                                                            if ($dealer_15plus_discount_amount > $product_factory_total_price) {
                                                                $user_discount_percent = $setting->dealer_discount_percent ?? 0;
                                                            } else {
                                                                $user_discount_percent = $setting->dealer_15plus_discount ?? 0;
                                                            }


                                                        } else if(auth()->user()->type == 2) {
                                                            $user_discount_percent = $setting->consumer_discount_percent ?? 0;
                                                        } else {
                                                            $user_discount_percent = 0;
                                                        }


                                                        // $discount_amount = ($product_total_price * $user_discount_percent)/100;
                                                        $discount_amount = ($product_factory_total_price * $user_discount_percent)/100;
                                                        if ($tds_percent > 0) {
                                                            $tds_amount = ($discount_amount * $tds_percent) / 100;
                                                        }
                                                    @endphp
                                                    ৳ {{number_format($discount_amount,2,".","")}} <small>({{$user_discount_percent}}%)</small>
                                                </td>
                                            </tr>
                                            <tr @if(!in_array(auth()->user()->type,[2,3])) class="d-none" @endif>
                                                <th>After deducting TDS ({{$tds_percent}}%) on commission ({{$user_discount_percent}}%) </th>
                                                <td>

                                                    ৳ {{number_format($discount_amount - $tds_amount,2,".","")}}
                                                </td>
                                            </tr>
                                            @if ($other_categories_amount > 0)
                                                <tr>
                                                    <th>Other Charge</th>
                                                    <td>
                                                        ৳ {{number_format($other_categories_amount,2,".","")}}
                                                    </td>
                                                </tr>
                                            @endif

                                            {{-- @endif --}}
                                            @php
                                                $in_total = $product_total_price;
                                            @endphp

                                            <tr>
                                                {{-- <th>Transportation Charge/Carrying Cost</th> --}}
                                                <th>After imposing VDS ({{$vds_percent}}%) on carrying cost</th>

                                                <td>
                                                    ৳ <span class="inside_outside_cost">0.00</span>
                                                </td>
                                            </tr>
                                            <tr class="discount_on_amount d-none">
                                                <th class="discount_on_amount_text"></th>
                                                <td>
                                                    ৳ <span class="discount_on_amount_number">0.00</span>
                                                </td>
                                            </tr>
                                            @if ($has_packing_types == 1)
                                                <tr>
                                                    <th>Select Product Packing
                                                        <br>
                                                        <small class="text-danger">Packing amount will be added with your total amount</small>
                                                    </th>
                                                    <td style="width: 200px;">
                                                        <select id="packing_type" name="packing_type" class="form-control packing_price" autocomplete="off" required>
                                                            <option value="">Select</option>
                                                            @foreach ($packing_types as $packing_type)
                                                            {{-- @if ($packing_type->packing_amount) --}}
                                                            <option data-packing_amount="{{number_format($packing_type->packing_amount,2,".","")}}" value="{{$packing_type->id}}">{{$packing_type->name}} (৳ {{number_format($packing_type->packing_amount,2,".","")}})</option>
                                                            {{-- @endif --}}

                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endif


                                            <tr>
                                                <th>Total</th>
                                                <td>
                                                    <input type="hidden" class="total_price" name="total_price" value="{{$in_total}}">
                                                    <input type="hidden" class="product_factory_total_price" name="product_factory_total_price" value="{{$product_factory_total_price}}">
                                                    <input type="hidden" name="discount_amount" value="{{$discount_amount}}">
                                                    <input type="hidden" name="tds_percent" value="{{$tds_percent}}">
                                                    <input type="hidden" name="tds_amount" value="{{$tds_amount}}">
                                                    <input type="hidden" name="vds_percent" value="{{$vds_percent}}">
                                                    <input type="hidden" name="inside_vds_amount" value="{{$inside_vds_amount}}">
                                                    <input type="hidden" name="outside_vds_amount" value="{{$outside_vds_amount}}">
                                                    {{-- from settings table --}}
                                                    <input type="hidden" name="other_categories_amount" value="{{$other_categories_amount}}">
                                                    <input type="hidden" name="still_have_walet_amount" value="{{$still_have_walet_amount}}">

                                                    <input type="hidden" class="grand_total_price" name="grand_total_price" value="{{number_format((($in_total + $other_categories_amount) - ($discount_amount - $tds_amount)),2,".","")}}">

                                                    @if ($still_have_walet_amount >= (($in_total + $other_categories_amount) - ($discount_amount - $tds_amount)))
                                                        <input type="hidden" class="paid_from_walet" name="paid_from_walet" value="0">
                                                    @else
                                                    <input type="hidden" class="paid_from_walet" name="paid_from_walet" value="{{number_format((($in_total + $other_categories_amount) - ($discount_amount - $tds_amount)) - $still_have_walet_amount,2,'.','')}}">

                                                    @endif

                                                    ৳ <span class="in_total @if ($still_have_walet_amount <= 0) font-weight-bold @endif" >{{number_format((($in_total + $other_categories_amount) - ($discount_amount - $tds_amount)),2,".","")}}</span>
                                                </td>
                                            </tr>
                                            @if ($still_have_walet_amount > 0)
                                                <tr>
                                                    <th>
                                                        In my account
                                                    </th>
                                                    <td>
                                                        ৳ <span class="still_have_walet_amount_text">{{number_format($still_have_walet_amount,2,'.','')}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        You have to pay
                                                    </th>
                                                    <td>

                                                        ৳ <strong class="have_to_pay_text">
                                                            @if ($still_have_walet_amount >= (($in_total + $other_categories_amount) - ($discount_amount - $tds_amount)))
                                                                0.00
                                                            @else
                                                            {{number_format((($in_total + $other_categories_amount) - ($discount_amount - $tds_amount)) - $still_have_walet_amount,2,'.','')}}
                                                            @endif

                                                        </strong>
                                                    </td>
                                                </tr>
                                            @endif

                                        </tfoot>
                                    </table>
                                    <!-- End Product Content -->
                                    <div class="border-top border-width-3 border-color-1 pt-3 mb-3">
                                        <!-- Basics Accordion -->
                                        <div id="basicsAccordion1">
                                            <!-- Manual payment Card -->
                                            <div class="border-bottom border-color-1 border-dotted-bottom">
                                                <div class="p-3" id="basicsHeadingOne">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="stylishRadio1" name="stylishRadio" value="1" checked autocomplete="off">

                                                        <label class="custom-control-label form-label" for="stylishRadio1" data-toggle="collapse" data-target="#basicsCollapseOnee" aria-expanded="true" aria-controls="basicsCollapseOnee">
                                                            Manual Payment
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="basicsCollapseOnee" class="collapse show border-top border-color-1 border-dotted-top bg-dark-lighter"
                                                    aria-labelledby="basicsHeadingOne"
                                                    data-parent="#basicsAccordion1">
                                                    <div class="p-4">
                                                        <div class="form-group">
                                                            <label for="sel1">Select account: <small class="text-danger">*</small></label>
                                                            <select class="form-control" id="bank_id" name="bank_id" autocomplete="off">
                                                                <option value="">Select</option>
                                                                @foreach ($banks as $bank)
                                                                    <option value="{{$bank->id}}">{{$bank->name}} A/C: {{$bank->account_no}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Document: <small class="text-danger">*</small></label>
                                                            <input type="file" class="form-control" name="document" accept=".png, .jpg, .jpeg, .doc, .docx, .xlsx, .pdf" autocomplete="off">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Card -->

                                            <!-- Cash payment Card -->
                                            <div class="border-bottom border-color-1 border-dotted-bottom">
                                                <div class="p-3" id="basicsHeadingTwo">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="stylishRadio2" name="stylishRadio" value="5" autocomplete="off">
                                                        <label class="custom-control-label form-label" for="stylishRadio2"
                                                            data-toggle="collapse"
                                                            data-target="#CashPayment"
                                                            aria-expanded="false"
                                                            aria-controls="CashPayment">
                                                            Cash Payment
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="CashPayment" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                                    aria-labelledby="basicsHeadingTwo"
                                                    data-parent="#basicsAccordion1">
                                                    <div class="p-4">
                                                        <div class="form-group">
                                                            <label>Factory Side/Showroom : <small class="text-danger">*</small></label>
                                                            <input type="text" class="form-control" name="factory_showroom" placeholder="Factory Side/Showroom Name" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Document: <small class="text-danger">*</small></label>
                                                            <input type="file" class="form-control" name="cash_payment_document" autocomplete="off" accept=".png, .jpg, .jpeg, .doc, .docx, .xlsx, .pdf">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Card -->

                                            <!-- Card -->
                                            <div class="border-bottom border-color-1 border-dotted-bottom">
                                                <!--<div class="p-3" id="basicsHeadingTwo">-->
                                                <!--    <div class="custom-control custom-radio">-->
                                                <!--        <input type="radio" class="custom-control-input" id="FourstylishRadio2" name="stylishRadio" value="2">-->
                                                <!--        <label class="custom-control-label form-label" for="FourstylishRadio2"-->
                                                <!--            data-toggle="collapse"-->
                                                <!--            data-target="#basicsCollapseTwo"-->
                                                <!--            aria-expanded="false"-->
                                                <!--            aria-controls="basicsCollapseTwo">-->
                                                <!--            Bkash / Nagad-->
                                                <!--        </label>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                <div id="basicsCollapseTwo" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                                    aria-labelledby="basicsHeadingTwo"
                                                    data-parent="#basicsAccordion1">
                                                    <div class="p-4">
                                                        <div class="form-group">
                                                            <label for="">Sender Mobile No: <small class="text-danger">*</small></label>
                                                            {{-- mb = mobile banking --}}
                                                            <input type="number" class="form-control" name="mb_sender_no">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Receiver Mobile No: <small class="text-danger">*</small></label>
                                                            {{-- mb = mobile banking --}}
                                                            <input type="number" class="form-control" name="mb_receiver_no">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Document: <small class="text-danger">*</small></label>
                                                            <input type="file" class="form-control" name="mb_document">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Card -->

                                            <div class="border-bottom border-color-1 border-dotted-bottom">
                                                <div class="p-3" id="basicsHeadingFour">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="FourstylishRadio1" name="stylishRadio" value="3">
                                                        <label class="custom-control-label form-label" for="FourstylishRadio1"
                                                            data-toggle="collapse"
                                                            data-target="#basicsCollapseFour"
                                                            aria-expanded="false"
                                                            aria-controls="basicsCollapseFour">
                                                            Online Payment by SSLCOMMERZ
                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="basicsCollapseFour" class="collapse border-top border-color-1 border-dotted-top bg-dark-lighter"
                                                    aria-labelledby="basicsHeadingFour"
                                                    data-parent="#basicsAccordion1">
                                                    <div class="p-4 d-none">
                                                        <button class="your-button-class" id="sslczPayBtn"
                                                                    token="if you have any token validation"
                                                                    postdata="your javascript arrays or objects which requires in backend"
                                                                    order="If you already have the transaction generated for current order"
                                                                    endpoint="{{ url('/pay-via-ajax') }}">
                                                                    <h4>Pay Now by sslcommerz</span></h4>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- End Basics Accordion -->
                                    </div>

                                    <div class="form-group d-flex align-items-center justify-content-between px-3 mb-5">
                                        <span style="margin-top: -12%; padding-right: 3px;" class="text-danger">*</span>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck10" required
                                                data-msg="Please agree terms and conditions."
                                                data-error-class="u-has-error"
                                                data-success-class="u-has-success">
                                            <label class="form-check-label font-weight-bold" for="defaultCheck10">
                                                I have read and agreed to the website <a href="#" class="text-blue">terms and conditions</a>, <a href="#" class="text-blue">refund-return policy </a> and <a href="#" class="text-blue">privacy policy </a>
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary-dark-w btn-block btn-pill font-size-20 mb-3 py-3 text-white">Place order</button>
                                </div>
                                <!-- End Order Summary -->
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 order-lg-1">
                        <div class="pb-7 mb-7">
                            <!-- Title -->
                            <div class="border-bottom border-color-1 mb-5">
                                <h3 class="section-title mb-0 pb-2 font-size-25">Billing details</h3>
                            </div>
                            <!-- End Title -->

                            <!-- Billing Form -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                First name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="firstName" placeholder="First name" aria-label="First name" required="" data-msg="Please enter your frist name." data-error-class="u-has-error" data-success-class="u-has-success" autocomplete="off" value="{{auth()->user()->first_name}}" required readonly>
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Last name

                                            </label>
                                            <input type="text" class="form-control" name="lastName" placeholder="Last name" aria-label="Last name" required="" data-msg="Please enter your last name." data-error-class="u-has-error" data-success-class="u-has-success" required value="{{auth()->user()->last_name}}" readonly>
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="w-100"></div>

                                    <div class="col-md-12">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Delivery Address
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="streetAddress" placeholder="Address" aria-label="Address" required="" data-msg="Please enter a valid address." data-error-class="u-has-error" data-success-class="u-has-success" value="{{auth()->user()->present_address}}">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="w-100"></div>

                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Email address
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control" name="emailAddress" placeholder="Your email"  required="" data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success" value="{{auth()->user()->email}}">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="col-md-6">
                                        <!-- Input -->
                                        <div class="js-form-message mb-6">
                                            <label class="form-label">
                                                Phone
                                            </label>
                                            <input type="text" name="phone" class="form-control" placeholder="Mobile" aria-label="Mobile" data-msg="Please enter your last name." data-error-class="u-has-error" value="{{auth()->user()->mobile}}" data-success-class="u-has-success">
                                        </div>
                                        <!-- End Input -->
                                    </div>

                                    <div class="w-100"></div>
                                </div>


                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" name="personal_vehicle" value="1" autocomplete="off"><strong>I shall use my own transport</strong>
                                            </label>
                                            <br>
                                            <br>
                                        </div>

                                        <div class="w-100 conditional_area">
                                            <div>
                                                {{-- <h5 class="mb-0">Select Courier Option</h5> --}}
                                                <h5 class="mb-0">Select Delivery Option</h5>

                                                <small>(If you want to get your product by courier)</small>
                                                <br>
                                                <br>
                                            </div>



                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input autocomplete="off" type="checkbox" class="form-check-input" data-cost="{{number_format($setting->courier_inside_dhaka + $inside_vds_amount,2,'.','')}}" name="shipping_area" value="1"><strong>Inside Dhaka</strong>
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input autocomplete="off" type="checkbox" class="form-check-input" data-cost="{{number_format($setting->courier_outside_dhaka + $outside_vds_amount,2,'.','')}}" name="shipping_area" value="2"><strong>Outside Dhaka</strong>
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                    @if ($get_discount_after_amount <= $in_total)
                                        <div class="col-12">
                                            <br>
                                            <br>
                                            <div class="border-bottom border-color-1 mb-5">
                                                <h3 class="section-title mb-0 pb-2 font-size-25">Choose Your Discount Option <span class="text-danger">*</span></h3>
                                            </div>

                                            <div class="input-group mb-3 border border-success p-3 rounded">
                                                <div class="input-group-prepend">
                                                <div class="input-group-text border-0">
                                                    <input style="display: block !important" class="discount_on_amount" autocomplete="off" name="discount_on_amount" value="1" type="checkbox" id="free_shipment">
                                                </div>
                                                </div>
                                                <div>
                                                <label for="free_shipment">
                                                    <h5>Get free delivery</h5>
                                                    <p class="mb-0">No delivery charge will be added.</p>
                                                </label>
                                                </div>
                                            </div>
                                            @if ($allow_2_percent_discount == 1)
                                                <div class="input-group mb-3 border border-success p-3 rounded">
                                                    <div class="input-group-prepend">
                                                    <div class="input-group-text border-0">
                                                        <input style="display: block !important" class="discount_on_amount" autocomplete="off" data-discount_percent={{$get_discount_percentage}} name="discount_on_amount" value="2" type="checkbox" id="percentage_shipment">
                                                    </div>
                                                    </div>
                                                    <div>
                                                    <label for="percentage_shipment">
                                                        <h5>Get discount on total amount</h5>
                                                        <p class="mb-0 discount_percentage">Get {{$get_discount_percentage}} % discount on total amount.</p>
                                                    </label>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    @else
                                        @if ($allow_2_percent_discount == 1)
                                            <div class="input-group mb-3 border border-danger p-3 rounded mt-5">

                                                <div>
                                                    <label for="free_shipment">
                                                        <h5>Get Discount</h5>
                                                        <p class="mb-0">Get free delivery or 2% discount on ordering over ৳ {{$get_discount_after_amount}} or more </p>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="input-group mb-3 border border-success p-3 rounded mt-2">

                                        <div>
                                            <label for="">
                                                <h5>Delivery Time</h5>
                                                <p class="mb-0">Get your delivery within 4 to 7 days.</p>
                                            </label>
                                        </div>
                                    </div>

                                </div>

                            <!-- End Billing Form -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

@push('script')
    <!-- JavaScript -->
    {{-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> --}}

    <script>
        $('input[name="personal_vehicle"]').click(function() {
            if($(this).is(":checked")) {
                var discount_on_amount_length = $('input[name="discount_on_amount"]:checked').length;
                var packing_type_length = $("#packing_type>option:not([value='']):selected").length;
                var total_value = $(".total_price").val();
                var factory_product_total_value = $(".product_factory_total_price").val();
                var discount_amount = $("input[name='discount_amount']").val();
                var discounted_amount = 0;
                var inside_outside_cost = 0;
                var packing_amount = 0;
                var other_categories_amount = $('input[name="other_categories_amount"]').val();
                var tds_amount = $('input[name="tds_amount"]').val();
                var still_have_walet_amount = $('input[name="still_have_walet_amount"]').val();
                if (!still_have_walet_amount) {
                    still_have_walet_amount = 0;
                }

                if (discount_on_amount_length > 0) {
                    if ($('input[name="discount_on_amount"]:checked').val() == 2) {
                        var discount_percent = $('input[name="discount_on_amount"]:checked').attr('data-discount_percent');
                        discounted_amount = ((Number(factory_product_total_value) - Number(discount_amount) + Number(tds_amount)) * Number(discount_percent))/100;
                    }

                }

                if (packing_type_length > 0) {
                    packing_amount = $("#packing_type>option:not([value='']):selected").attr("data-packing_amount");
                }

                $('.inside_outside_cost').text(Number(inside_outside_cost).toFixed(2));
                $('.discount_on_amount_number').text(Number(discounted_amount).toFixed(2));
                var in_total_text = Number($(".total_price").val()) - Number(discounted_amount) - Number(discount_amount) + Number(packing_amount) + Number(tds_amount) + Number(other_categories_amount);

                $(".in_total").text(Number(in_total_text).toFixed(2));
                $(".grand_total_price").val(Number(in_total_text).toFixed(2));

                if (Number(in_total_text) > Number(still_have_walet_amount)) {
                    $('.have_to_pay_text').text(Number( Number(in_total_text) - Number(still_have_walet_amount) ).toFixed(2));
                    $('.paid_from_walet').val(Number(still_have_walet_amount).toFixed(2));
                } else {
                    $('.have_to_pay_text').text("0.00");
                    $('.paid_from_walet').val(Number(in_total_text).toFixed(2));
                }

                $(".conditional_area").hide();
                $('input[name="shipping_area"]').removeAttr('checked');

            } else {
                $(".conditional_area").show();
            }
        });

        $('input[name="shipping_area"]').click(function() {
                var cost = $(this).attr("data-cost");

                var discount_on_amount_length = $('input[name="discount_on_amount"]:checked').length;

                var discount_amount = 0;
                var packing_amount = 0;

                var packing_type_length = $("#packing_type>option:not([value='']):selected").length;

                var hidden_discount_amount = $("input[name='discount_amount']").val();
                var still_have_walet_amount = $("input[name='still_have_walet_amount']").val();

                if (packing_type_length > 0) {
                    packing_amount = $("#packing_type>option:not([value='']):selected").attr("data-packing_amount");
                }

                if (!packing_amount) {
                    packing_amount = 0;
                }

                var other_categories_amount = $('input[name="other_categories_amount"]').val();
                var tds_amount = $('input[name="tds_amount"]').val();

                if (discount_on_amount_length > 0) {
                    if ($('input[name="discount_on_amount"]:checked').val() == 2) {
                        var total_value = $(".total_price").val();
                        var product_factory_total_price = $(".product_factory_total_price").val();
                        var discount_percent = $('input[name="discount_on_amount"]:checked').attr('data-discount_percent');


                        var discounted_amount = ((Number(product_factory_total_price) - Number(hidden_discount_amount) + Number(tds_amount)) * Number(discount_percent))/100;
                        $('.discount_on_amount_number').text(Number(discounted_amount).toFixed(2));
                        discount_amount = Number(discounted_amount);

                    }

                    if ($('input[name="discount_on_amount"]:checked').val() == 1) {
                        cost = 0;
                    }
                }

                if($(this).is(":checked")) {

                    $(".inside_outside_cost").text(Number(cost).toFixed(2));
                    var in_total_text = Number(cost) + Number($(".total_price").val()) - Number(hidden_discount_amount) - Number(discount_amount) + Number(packing_amount) + Number(tds_amount) + Number(other_categories_amount);
                    $(".in_total").text(Number(in_total_text).toFixed(2));
                    $(".grand_total_price").val(Number(in_total_text).toFixed(2));

                    if (Number(in_total_text) > Number(still_have_walet_amount)) {
                        $('.have_to_pay_text').text(Number( Number(in_total_text) - Number(still_have_walet_amount) ).toFixed(2));
                        $('.paid_from_walet').val(Number(still_have_walet_amount).toFixed(2));
                    } else {
                        $('.have_to_pay_text').text("0.00");
                        $('.paid_from_walet').val(Number(in_total_text).toFixed(2));
                    }

                } else {
                    $(".inside_outside_cost").text("0.00");
                    var in_total_text = Number($(".total_price").val()) + Number(discount_amount) - Number(hidden_discount_amount) + Number(packing_amount) + Number(tds_amount) + Number(other_categories_amount);
                    $(".in_total").text(Number(in_total_text).toFixed(2));
                    $(".grand_total_price").val(Number(in_total_text).toFixed(2));
                    if (Number(in_total_text) > Number(still_have_walet_amount)) {
                        $('.have_to_pay_text').text(Number( Number(in_total_text) - Number(still_have_walet_amount) ).toFixed(2));
                        $('.paid_from_walet').val(Number(still_have_walet_amount).toFixed(2));
                    } else {
                        $('.have_to_pay_text').text("0.00");
                        $('.paid_from_walet').val(Number(in_total_text).toFixed(2));
                    }
                }
        });

        $('input[name="discount_on_amount"]').on('change', function() {
            $('input[name="discount_on_amount"]').not(this).prop('checked', false);
        });

        $('#packing_type').on('change', function() {

            var packing_type = $(this).find(':selected').val();
            if (packing_type) {

                var discount_on_amount_length = $('input[name="discount_on_amount"]:checked').length;
                var shipping_area = $('input[name="shipping_area"]:checked').length;
                var shipping_area_cost = 0;
                var packing_amount = 0;
                var discount_on_amount_number = 0;
                var discount_amount = $('input[name="discount_amount"]').val();
                var other_categories_amount = $('input[name="other_categories_amount"]').val();
                var tds_amount = $('input[name="tds_amount"]').val();
                var still_have_walet_amount = $('input[name="still_have_walet_amount"]').val();

                if (shipping_area > 0) {
                    shipping_area_cost = $('input[name="shipping_area"]:checked').attr("data-cost");

                }

                packing_amount = $('#packing_type').find(':selected').attr("data-packing_amount");

                if (discount_on_amount_length > 0) {

                    if ($('input[name="discount_on_amount"]:checked').val() == 2) {
                        discount_on_amount_number = $('.discount_on_amount_number').text();

                    }

                }
                var in_total_text = (Number($(".total_price").val()) + Number(shipping_area_cost) + Number(other_categories_amount) + Number(packing_amount)) - (Number(discount_on_amount_number) + (Number(discount_amount) - Number(tds_amount)));
                $(".in_total").text(Number(in_total_text).toFixed(2));
                $(".grand_total_price").val(Number(in_total_text).toFixed(2));

                if (Number(in_total_text) > Number(still_have_walet_amount)) {
                    $('.have_to_pay_text').text(Number( Number(in_total_text) - Number(still_have_walet_amount) ).toFixed(2));
                    $('.paid_from_walet').val(Number(still_have_walet_amount).toFixed(2));
                } else {
                    $('.have_to_pay_text').text("0.00");
                    $('.paid_from_walet').val(Number(in_total_text).toFixed(2));
                }

            } else {
                var discount_on_amount_length = $('input[name="discount_on_amount"]:checked').length;
                var shipping_area = $('input[name="shipping_area"]:checked').length;
                var shipping_area_cost = 0;
                var discount_on_amount_number = 0;

                if (shipping_area > 0) {
                    shipping_area_cost = $('input[name="shipping_area"]:checked').attr("data-cost");

                }

                if (discount_on_amount_length > 0) {
                    if ($('input[name="discount_on_amount"]:checked').val() == 2) {
                        discount_on_amount_number = $('.discount_on_amount_number').text();

                    }

                }
                var discount_amount = $('input[name="discount_amount"]').val();

                var other_categories_amount = $('input[name="other_categories_amount"]').val();
                var tds_amount = $('input[name="tds_amount"]').val();

                var in_total_text = (Number($(".total_price").val()) + Number(shipping_area_cost) + Number(other_categories_amount)) - (Number(discount_on_amount_number) + (Number(discount_amount) - Number(tds_amount)));

                $(".in_total").text(Number(in_total_text).toFixed(2));
                $(".grand_total_price").val(Number(in_total_text).toFixed(2));

                if (Number(in_total_text) > Number(still_have_walet_amount)) {
                    $('.have_to_pay_text').text(Number( Number(in_total_text) - Number(still_have_walet_amount) ).toFixed(2));
                    $('.paid_from_walet').val(Number(still_have_walet_amount).toFixed(2));
                } else {
                    $('.have_to_pay_text').text("0.00");
                    $('.paid_from_walet').val(Number(in_total_text).toFixed(2));
                }

            }
        });


        @if ($get_discount_after_amount <= $in_total)
            $('input[name="discount_on_amount"]').on('change', function() {

                var discount_on_amount_length = $('input[name="discount_on_amount"]:checked').length;
                var shipping_area_length = $('input[name="shipping_area"]:checked').length;
                var packing_type_length = $("#packing_type>option:not([value='']):selected").length;

                var discount_on_amount_number = 0;
                var shipping_area_cost = 0;
                var packing_amount = 0;

                if (shipping_area_length > 0) {
                    shipping_area_cost = $('input[name="shipping_area"]:checked').attr("data-cost");
                }

                if (packing_type_length > 0) {
                    packing_amount = $("#packing_type>option:not([value='']):selected").attr("data-packing_amount");
                }

                var discount_amount = $('input[name="discount_amount"]').val();
                var still_have_walet_amount = $('input[name="still_have_walet_amount"]').val();

                var other_categories_amount = $('input[name="other_categories_amount"]').val();
                var tds_amount = $('input[name="tds_amount"]').val();

                if (discount_on_amount_length > 0) {
                    if ($('input[name="discount_on_amount"]:checked').val() == 2) {


                        $('.discount_on_amount').removeClass("d-none");

                        var discount_percent= $('input[name="discount_on_amount"]:checked').attr("data-discount_percent");

                        // var t_discount_amoun = ((Number($(".total_price").val()) - Number(discount_amount)) * discount_percent)/100;
                        var t_discount_amoun = ((Number($(".product_factory_total_price").val()) - Number(discount_amount) + Number(tds_amount)) * discount_percent)/100;

                        $('.discount_on_amount_number').text(Number(t_discount_amoun).toFixed(2));
                        discount_on_amount_number = t_discount_amoun;


                        $('.discount_on_amount_text').text("Get "+discount_percent+" % discount in total price");



                        var in_total_text = Number($(".total_price").val()) - Number(discount_on_amount_number) + Number(shipping_area_cost) + Number(packing_amount) - Number(discount_amount) + Number(tds_amount) + Number(other_categories_amount);
                        $(".in_total").text(Number(in_total_text).toFixed(2));
                        $(".grand_total_price").val(Number(in_total_text).toFixed(2));

                        if (Number(in_total_text) > Number(still_have_walet_amount)) {
                            $('.have_to_pay_text').text(Number( Number(in_total_text) - Number(still_have_walet_amount) ).toFixed(2));
                            $('.paid_from_walet').val(Number(still_have_walet_amount).toFixed(2));
                        } else {
                            $('.have_to_pay_text').text("0.00");
                            $('.paid_from_walet').val(Number(in_total_text).toFixed(2));
                        }

                    }
                    if($('input[name="discount_on_amount"]:checked').val() == 1) {

                        shipping_area_cost = 0;
                        $('.discount_on_amount').addClass("d-none");
                        var in_total_text = Number($(".total_price").val()) + Number(packing_amount) - Number(discount_amount) + Number(shipping_area_cost) + Number(tds_amount) + Number(other_categories_amount);
                        $(".in_total").text(Number(in_total_text).toFixed(2));
                        $(".grand_total_price").val(Number(in_total_text).toFixed(2));
                        $('.discount_on_amount_number').text("0.00");

                        if (Number(in_total_text) > Number(still_have_walet_amount)) {
                            $('.have_to_pay_text').text(Number( Number(in_total_text) - Number(still_have_walet_amount) ).toFixed(2));
                            $('.paid_from_walet').val(Number(still_have_walet_amount).toFixed(2));
                        } else {
                            $('.have_to_pay_text').text("0.00");
                            $('.paid_from_walet').val(Number(in_total_text).toFixed(2));
                        }

                    }
                } else {
                    var in_total_text = Number($(".total_price").val()) + Number(shipping_area_cost) + Number(packing_amount) - Number(discount_amount) + Number(tds_amount) + Number(other_categories_amount);
                    $(".in_total").text(Number(in_total_text).toFixed(2));
                    $(".grand_total_price").val(Number(in_total_text).toFixed(2));
                    $('.discount_on_amount').addClass("d-none");
                    $('.discount_on_amount_number').text("0.00");

                    if (Number(in_total_text) > Number(still_have_walet_amount)) {
                        $('.have_to_pay_text').text(Number( Number(in_total_text) - Number(still_have_walet_amount) ).toFixed(2));
                        $('.paid_from_walet').val(Number(still_have_walet_amount).toFixed(2));
                    } else {
                        $('.have_to_pay_text').text("0.00");
                        $('.paid_from_walet').val(Number(in_total_text).toFixed(2));
                    }

                }



                $(".inside_outside_cost").text(Number(shipping_area_cost).toFixed(2));


            });
        @endif
        // $('input[name="shipping_area"]').on('click', function() {
        //     $(this).siblings('input[name="shipping_area"]').not(this).prop('checked', false);
        // });

        $('input[name="shipping_area"]').on('change', function() {
            $('input[name="shipping_area"]').not(this).prop('checked', false);
        });

        $('#save_checkout').on('submit',function(e){
            // e.preventDefault();

            // var formData = new FormData(this);

            if ($('input#shippingdiffrentAddress').is(':checked')) {
                if($("input[name='shipping_address']").val() == ""){
                    alertify.error("Please add delivery address");
                    e.preventDefault();
                    return false;
                }
            }

            if (!$('input#defaultCheck10').is(':checked')) {

                alertify.error("Please click website terms and conditions to agree");
                e.preventDefault();
                return false;

            }

            var still_have_walet_amount = $("input[name='still_have_walet_amount']").val();

            @if ($get_discount_after_amount <= $in_total)
            var discount_on_amount_length = $('input[name="discount_on_amount"]:checked').length;
            var personal_vehicle_length = $('input[name="personal_vehicle"]:checked').length;

                if (discount_on_amount_length == 0) {
                    alertify.error("Please choose your discount option");
                        e.preventDefault();
                        return false;
                }

                if (discount_on_amount_length == 1) {
                    if ($('input[name="discount_on_amount"]:checked').val() == 1) {
                        if (personal_vehicle_length == 1) {
                            alertify.error("You already using your own transport, please select 'Get discount on total amount' option");
                            e.preventDefault();
                            return false;
                        }
                    }

                }

            @endif

            if ($('input[name="personal_vehicle"]').is(':checked')) {

            } else {
                if($("input[name='shipping_area']").is(':checked')) {

                } else {
                    alertify.error("Please choose your delivery area");
                    e.preventDefault();
                    return false;
                }
            }

            var payment_method = $('input[name="stylishRadio"]:checked').val();
            // console.log(payment_method);
            // return false;
            // var paid_from_walet = $('input[name="paid_from_walet"]').val();
            var have_to_pay_text = $('input[name="have_to_pay_text"]').text();
            var emailAddress = $('input[name="emailAddress"]').val();
            var phone = $('input[name="phone"]').val();
            var streetAddress = $('input[name="streetAddress"]').val();

            if (!emailAddress) {
                alertify.error("Please fill up your email address");
                e.preventDefault();
                return false;
            }
            // if (!phone) {
            //     alertify.error("Please fill up your mobile number");
            //     e.preventDefault();
            //     return false;
            // }
            if (!streetAddress) {
                alertify.error("Please fill up your delivery address");
                e.preventDefault();
                return false;
            }

            if (!have_to_pay_text) {
                if (Number(still_have_walet_amount) > 0) {
                    if (Number($('.in_total').text()) <= Number(still_have_walet_amount)) {
                        have_to_pay_text = 0;
                    } else {
                        have_to_pay_text = Number($('.in_total').text()) - Number(still_have_walet_amount);
                    }
                } else {
                    have_to_pay_text = $('.in_total').text();
                }

            }

            if (Number(have_to_pay_text) > 0) {
                if (payment_method == 1) {

                    if ($("#bank_id>option:selected").val() == "") {
                        alertify.error("Please choose bank account");
                        e.preventDefault();
                        return false;
                    }

                    if ($("input[name='document']").val() == "") {
                        alertify.error("Bank info document is required");
                        e.preventDefault();
                        return false;
                    }
                }

                if (payment_method == 2) {

                    if ($("input[name='factory_showroom']").val() == "") {
                        alertify.error("Sender mobile no is required");
                        e.preventDefault();
                        return false;
                    }

                    if ($("input[name='cash_payment_document']").val() == "") {
                        alertify.error("Receiver mobile no is required");
                        e.preventDefault();
                        return false;
                    }
                }

                if (payment_method == 5) {

                    if ($("input[name='factory_showroom']").val() == "") {
                        alertify.error("Factory Side/Showroom name is required");
                        e.preventDefault();
                        return false;
                    }

                    if ($("input[name='cash_payment_document']").val() == "") {
                        alertify.error("Document is required");
                        e.preventDefault();
                        return false;
                    }
                }

                // if (payment_method == 3) {
                //     alertify.error("Please use online payment option");
                //     e.preventDefault();
                //     return false;
                // }
            }





            @if ($has_packing_types == 1)
            var packing_type_length = $("#packing_type>option:not([value='']):selected").length;
            if (packing_type_length == 0) {
                alertify.error("Please select packing type");
                    e.preventDefault();
                    return false;
            }
            @endif

            if (Number(have_to_pay_text) > 0) {
                // if (payment_method == 3) {
                //     alertify.error("Please choose other payment option");
                //     e.preventDefault();
                //     return false;
                // }
            }
        });


        // $('input[name="stylishRadio"]').click(function(){
        //     var formData = new FormData($('#save_checkout')[0]),
        //     let = online_payment_checked = $('input[name="stylishRadio"]:checked').val();
        //     if (online_payment_checked == 3) {
        //         $('#basicsCollapseFour').removeClass("d-none");
        //         if ($('input#shippingdiffrentAddress').is(':checked')) {
        //             if($("input[name='shipping_address']").val() == ""){
        //                 alertify.error("Please add delivery address");
        //                 $('#basicsCollapseFour').addClass("d-none");
        //                 return false;
        //             }
        //         }

        //         if (!$('input#defaultCheck10').is(':checked')) {

        //             alertify.error("Please click website terms and conditions to agree");
        //             $('#basicsCollapseFour').addClass("d-none");
        //             return false;

        //         }

        //         var still_have_walet_amount = $("input[name='still_have_walet_amount']").val();

        //         @if ($get_discount_after_amount <= $in_total)
        //             var discount_on_amount_length = $('input[name="discount_on_amount"]:checked').length;
        //             var personal_vehicle_length = $('input[name="personal_vehicle"]:checked').length;

        //             if (discount_on_amount_length == 0) {
        //                 alertify.error("Please choose your discount option");
        //                 $('#basicsCollapseFour').addClass("d-none");
        //                 return false;
        //             }

        //             if (discount_on_amount_length == 1) {
        //                 if ($('input[name="discount_on_amount"]:checked').val() == 1) {
        //                     if (personal_vehicle_length == 1) {
        //                         $('#basicsCollapseFour').addClass("d-none");
        //                         alertify.error("You already using your own transport, please select 'Get discount on total amount' option");
        //                         return false;
        //                     }
        //                 }

        //             }
        //         @endif

        //         if ($('input[name="personal_vehicle"]').is(':checked')) {

        //         } else {
        //             if($("input[name='shipping_area']").is(':checked')) {

        //             } else {
        //                 $('#basicsCollapseFour').addClass("d-none");
        //                 alertify.error("Please choose your delivery area");
        //                 return false;
        //             }
        //         }

        //         var payment_method = $('input[name="stylishRadio"]:checked').val();
        //         var have_to_pay_text = $('input[name="have_to_pay_text"]').text();
        //         var emailAddress = $('input[name="emailAddress"]').val();
        //         var phone = $('input[name="phone"]').val();
        //         var streetAddress = $('input[name="streetAddress"]').val();

        //         if (!emailAddress) {
        //             $('#basicsCollapseFour').addClass("d-none");
        //             alertify.error("Please fill up your email address");
        //             return false;
        //         }
        //         if (!phone) {
        //             $('#basicsCollapseFour').addClass("d-none");
        //             alertify.error("Please fill up your mobile number");
        //             return false;
        //         }
        //         if (!streetAddress) {
        //             $('#basicsCollapseFour').addClass("d-none");
        //             alertify.error("Please fill up your delivery address");
        //             return false;
        //         }
        //         @if ($has_packing_types == 1)
        //             var packing_type_length = $("#packing_type>option:not([value='']):selected").length;
        //             if (packing_type_length == 0) {
        //                 $('#basicsCollapseFour').addClass("d-none");
        //                 alertify.error("Please select packing type");
        //                 return false;
        //             }
        //         @endif

        //         $.ajax({
        //             url: "{{route('update_cart_data')}}",
        //             type: "post",
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             success: function (response) {
        //             },
        //             error: function(jqXHR, textStatus, errorThrown) {
        //                 alertify.error("Something went wrong, please reload the page and ckeckout");
        //             }
        //         });
        //     }
        // });

    </script>

    {{-- <script>
        var obj = {};
        obj.cus_name = $("input[name='firstName']").val();
        obj.cus_phone = $("input[name='phone']").val();
        obj.cus_email = $("input[name='emailAddress']").val();
        obj.cus_addr1 = $("input[name='streetAddress']").val();
        obj.amount = $('.in_total').text();
        obj.user_id = {{auth()->user()->id}};
        obj.type = {{auth()->user()->type ?? '00'}};
        $('#sslczPayBtn').prop('postdata', obj);
        (function (window, document) {
            var loader = function () {
                var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
                script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
                // script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
                tag.parentNode.insertBefore(script, tag);
            };
            window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
        })(window, document);
    </script> --}}
@endpush
