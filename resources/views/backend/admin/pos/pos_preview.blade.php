@extends('backend.layout.master')

@section('content')
@php
$tds_percent = $global_setting->tds ?? 0;
$vds_percent = $global_setting->vds ?? 0;
$inside_vds_amount = ($global_setting->courier_inside_dhaka * $vds_percent)/100;
$outside_vds_amount = ($global_setting->courier_outside_dhaka * $vds_percent)/100;
$get_discount_after_amount = $global_setting->discount_amount ?? 1500000;
$product_total_price = 0;
$product_factory_total_price = 0;
$other_categories= $global_setting->other_category ?? "";
$get_discount_percentage = $global_setting->discount_percentage ?? 2;
$other_categories_amount= 0;
$has_packing_types = 0;
$category_array=array();
$dealer_15plus_discount_amount = $global_setting->dealer_15plus_discount_amount ?? 0;
if ($other_categories != '') {
    foreach ($inventoryItems as $cart_data) {
        if (in_array(($cart_data->product->category_id ?? 0),explode(",",$other_categories)) ) {
            $other_categories_amount = $global_setting->other_charge ?? 0;
            break;
        }
    }
}

if(count($packing_types)) {

    foreach ($packing_types as  $packingtype) {

        if ($packingtype->category_id != '') {
            array_push($category_array,explode(",",$packingtype->category_id));
            $amount_for_packing = 0;
            foreach ($inventoryItems as $cart_data) {
                if (in_array(($cart_data->product->category_id ?? 0),explode(",",$packingtype->category_id)) ) {
                    $has_packing_types = 1;
                    if ($cart_data->varient_id > 0) {
                        // $amount_for_packing += (($cart_data->varientInfo->discount_price ?? 0) * $cart_data->quantity);
                        $amount_for_packing += (($cart_data->varientInfo->price ?? 0) * $cart_data->quantity);
                    } else {
                        // $amount_for_packing += (($cart_data->product->discount_price ?? 0) * $cart_data->quantity);
                        $amount_for_packing += (($cart_data->product->price ?? 0) * $cart_data->quantity);
                    }

                }
            }
            $packingtype->packing_amount = ($amount_for_packing * $packingtype->charge)/100;

        }
    }
}

@endphp

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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">POS Order Info</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>

                        <li class="breadcrumb-item active">
                            <a class="text-muted">POS Order Info</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--session msg-->
            @include('alerts.alerts')

            <!--begin::row-->
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <form action="{{route('admin.pos.submit')}}" id="save_checkout"  method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="submit" id="" value="submit">
                            <input type="hidden" name="customer" id="" value="{{$customer->id}}">
                        <!--begin::Header-->
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">POS Order Info</h3>
                            </div>

                        </div>
                        <!--end::Header-->

                        <div class="card-body">
                            <div class="position-relative">

                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="product-name text-left">Product</th>
                                                        <th class="product-name text-left">Variant</th>
                                                        <th class="product-name text-left">Quantity</th>
                                                        <th class="product-name text-left">Price</th>
                                                        <th class="product-total text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($inventoryItems as $cart)
                                                    @php
                                                        $cart_product_price_with_sd = 0;
                                                    @endphp
                                                        <tr class="cart_item">
                                                            <td class="text-left">
                                                                {{$cart->product->name ?? ''}}<strong class="product-quantity">× {{$cart->quantity}}</strong>
                                                            </td>
                                                            <td class="text-left">
                                                                @if ($cart->varient_id > 0)
                                                                    @foreach ($cart->varientDataInfo as $varientDataInfo)
                                                                        @if ($loop->last)
                                                                            {{$varientDataInfo->data_value}}
                                                                        @else
                                                                            {{$varientDataInfo->data_value}},
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            <td class="text-left">
                                                                {{$cart->quantity}}
                                                            </td>
                                                            <td class="text-left" style="white-space: nowrap">
                                                                {{$global_setting->currency ?? ""}} @if ($cart->varient_id > 0)
                                                                    {{($cart->varientInfo->discount_price ?? '0.00')}}
                                                                @else
                                                                    {{($cart->product->discount_price ?? '0.00')}}
                                                                @endif
                                                            </td>
                                                            <td class="text-right" style="white-space: nowrap">
                                                                {{$global_setting->currency ?? ""}} @if ($cart->varient_id == 0)
                                                                @php
                                                                    $product_total_price +=  ($cart->product->discount_price ?? 0)  * $cart->quantity;
                                                                    $product_factory_total_price +=  ($cart->product->price ?? 0)  * $cart->quantity;
                                                                    $cart_product_price_with_sd = ((($cart->product->price ?? 0) * $cart->quantity) * ($cart->product->sd ?? 0))/100;
                                                                @endphp
                                                                    {{number_format(($cart->product->discount_price ?? 0)  * $cart->quantity, 2,".","")}}
                                                                @else
                                                                @php
                                                                    $product_total_price +=  ($cart->varientInfo->discount_price ?? 0)  * $cart->quantity;
                                                                    $product_factory_total_price +=  ($cart->varientInfo->price ?? 0)  * $cart->quantity;
                                                                    $cart_product_price_with_sd = ((($cart->varientInfo->price ?? 0) * $cart->quantity) * ($cart->varientInfo->sd ?? 0))/100;
                                                                @endphp
                                                                    {{number_format(($cart->varientInfo->discount_price ?? 0)  * $cart->quantity,2,".","")}}
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                                <tfoot class="mt-3 text-left">



                                                    <tr>
                                                        <th class="text-right" colspan="4">Sub-total: </th>
                                                        <td class="text-right">
                                                            {{$global_setting->currency ?? ""}} {{number_format($product_total_price,2,".","")}}
                                                        </td>
                                                    </tr>
                                                    <tr class="d-none">
                                                        <th class="text-right" colspan="4">Commission</th>
                                                        <td>
                                                            @php
                                                                if ($customer->type == 3) {
                                                                    if ($dealer_15plus_discount_amount > $product_factory_total_price) {
                                                                        $user_discount_percent = $global_setting->dealer_discount_percent ?? 0;
                                                                    } else {
                                                                        $user_discount_percent = $global_setting->dealer_15plus_discount ?? 0;
                                                                    }


                                                                } else {
                                                                    $user_discount_percent = $global_setting->consumer_discount_percent ?? 0;
                                                                }


                                                                // $discount_amount = ($product_total_price * $user_discount_percent)/100;
                                                                $discount_amount = ($product_factory_total_price * $user_discount_percent)/100;
                                                                if ($tds_percent > 0) {
                                                                    $tds_amount = ($discount_amount * $tds_percent) / 100;
                                                                }
                                                            @endphp
                                                            {{$global_setting->currency ?? ""}} {{number_format($discount_amount,2,".","")}} <small>({{$user_discount_percent}}%)</small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-right">After deducting TDS ({{$tds_percent}}%) on commission ({{$user_discount_percent}}%) </th>
                                                        <td class="text-right">

                                                            {{$global_setting->currency ?? ""}} {{number_format($discount_amount - $tds_amount,2,".","")}}
                                                        </td>
                                                    </tr>
                                                    @if ($other_categories_amount > 0)
                                                        <tr>
                                                            <th class="text-right" colspan="4">Other Charge</th>
                                                            <td>
                                                                {{$global_setting->currency ?? ""}} {{number_format($other_categories_amount,2,".","")}}
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    {{-- @endif --}}
                                                    @php
                                                        $in_total = $product_total_price;
                                                    @endphp

                                                    <tr class="d-none">
                                                        {{-- <th>Transportation Charge/Carrying Cost</th> --}}
                                                        <th class="text-right" colspan="4">After imposing VDS ({{$vds_percent}}%) on carrying cost</th>

                                                        <td class="text-right">
                                                            {{$global_setting->currency ?? ""}} <span class="inside_outside_cost">0.00</span>
                                                        </td>
                                                    </tr>
                                                    <tr class="discount_on_amount d-none">
                                                        <th class="discount_on_amount_text text-right" colspan="4"></th>
                                                        <td class="text-right">
                                                            {{$global_setting->currency ?? ""}} <span class="discount_on_amount_number">0.00</span>
                                                        </td>
                                                    </tr>
                                                    @if ($has_packing_types == 1)
                                                        <tr>
                                                            <th class="text-right" colspan="4">Select Product Packing
                                                                <br>
                                                                <small class="text-danger">Packing amount will be added with your total amount</small>
                                                            </th>
                                                            <td style="width: 200px;">
                                                                <select id="packing_type" name="packing_type" class="form-control packing_price" autocomplete="off" required>
                                                                    <option value="">Select</option>
                                                                    @foreach ($packing_types as $packing_type)
                                                                    @if ($packing_type->packing_amount > 0)
                                                                    <option data-packing_amount="{{number_format($packing_type->packing_amount,2,".","")}}" value="{{$packing_type->id}}">{{$packing_type->name}} ({{$global_setting->currency ?? ""}} {{number_format($packing_type->packing_amount,2,".","")}})</option>
                                                                    @endif

                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif


                                                    <tr>
                                                        <th class="text-right" colspan="4">Total</th>
                                                        <td class="text-right">
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

                                                            {{$global_setting->currency ?? ""}} <span class="in_total @if ($still_have_walet_amount <= 0) font-weight-bold @endif" >{{number_format((($in_total + $other_categories_amount) - ($discount_amount - $tds_amount)),2,".","")}}</span>
                                                        </td>
                                                    </tr>
                                                    @if ($still_have_walet_amount > 0)
                                                        <tr>
                                                            <th>
                                                                In my account
                                                            </th>
                                                            <td>
                                                                {{$global_setting->currency ?? ""}} <span class="still_have_walet_amount_text">{{number_format($still_have_walet_amount,2,'.','')}}</span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>
                                                                You have to pay
                                                            </th>
                                                            <td>

                                                                {{$global_setting->currency ?? ""}} <strong class="have_to_pay_text">
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
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-light text-left">
                                                    <tbody>
                                                        <tr>
                                                            <td>First Name:</td>
                                                            <td>{{$customer->first_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Last Name:
                                                            </td>
                                                            <td>{{$customer->last_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Delivery Address
                                                    <span class="text-danger">*</span>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="streetAddress"
                                                                placeholder="Address" aria-label="Address" required=""
                                                                data-msg="Please enter a valid address."
                                                                data-error-class="u-has-error" data-success-class="u-has-success"
                                                                value="{{$customer->present_address}}">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <label class="form-label">
                                                                    Email address
                                                                    <span class="text-danger">*</span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <input type="email" class="form-control" name="emailAddress"
                                                    placeholder="Your email" required=""
                                                    data-msg="Please enter a valid email address."
                                                    data-error-class="u-has-error" data-success-class="u-has-success"
                                                    value="{{$customer->email}}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Phone
                                                            </td>
                                                            <td>
                                                                <input type="text" name="phone" class="form-control"
                                                    placeholder="Mobile" aria-label="Mobile"
                                                    data-msg="Please enter your last name."
                                                    data-error-class="u-has-error" value="{{$customer->mobile}}"
                                                    data-success-class="u-has-success">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-check d-none">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" checked class="form-check-input"
                                                            name="personal_vehicle" value="1"
                                                            autocomplete="off"><strong>I shall use my own
                                                            transport</strong>
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
                                                            <input autocomplete="off" type="checkbox"
                                                                class="form-check-input"
                                                                data-cost="{{number_format($global_setting->courier_inside_dhaka + $inside_vds_amount,2,'.','')}}"
                                                                name="shipping_area" value="1"><strong>Inside
                                                                Dhaka</strong>
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input autocomplete="off" type="checkbox"
                                                                class="form-check-input"
                                                                data-cost="{{number_format($global_setting->courier_outside_dhaka + $outside_vds_amount,2,'.','')}}"
                                                                name="shipping_area" value="2"><strong>Outside
                                                                Dhaka</strong>
                                                        </label>
                                                    </div>
                                                </div>

                                            </div>

                                            @if ($get_discount_after_amount <= $in_total) <div class="col-12">
                                                <br>
                                                <br>
                                                <div class="border-bottom border-color-1 mb-5">
                                                    <h3 class="section-title mb-0 pb-2 font-size-25">Choose Your
                                                        Discount Option <span class="text-danger">*</span></h3>
                                                </div>

                                                <div class="input-group mb-3 border border-success p-3 rounded">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text border-0 bg-white">
                                                            <input style="display: block !important"
                                                                class="discount_on_amount" autocomplete="off"
                                                                name="discount_on_amount" value="1" type="checkbox"
                                                                id="free_shipment">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="free_shipment">
                                                            <h5>Get free delivery</h5>
                                                            <p class="mb-0">No delivery charge will be added.</p>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="input-group mb-3 border border-success p-3 rounded">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text border-0 bg-white">
                                                            <input style="display: block !important"
                                                                class="discount_on_amount" autocomplete="off"
                                                                data-discount_percent={{$get_discount_percentage}}
                                                                name="discount_on_amount" value="2" type="checkbox"
                                                                id="percentage_shipment">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="percentage_shipment">
                                                            <h5>Get discount on total amount</h5>
                                                            <p class="mb-0 discount_percentage">Get
                                                                {{$get_discount_percentage}} % discount on total amount.
                                                            </p>
                                                        </label>
                                                    </div>
                                                </div>
                                        </div>
                                        @endif
                                    </div>


                                </div>
                            </div>



                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary py-3 text-white">Place order</button>
                        </div>
                    </form>
                    </div>
                </div>
                <!--end::Card-->
            </div>
        </div>
        <!--end::row-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->


@endsection

@push('stackScript')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
<script>
    $(".conditional_area").hide();
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
            // $('input[name="shipping_area"]').removeAttr('checked');
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

        // if (!$('input#defaultCheck10').is(':checked')) {

        //     alertify.error("Please click website terms and conditions to agree");
        //     e.preventDefault();
        //     return false;

        // }

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
            // if (payment_method == 1) {

            //     if ($("#bank_id>option:selected").val() == "") {
            //         alertify.error("Please choose bank account");
            //         e.preventDefault();
            //         return false;
            //     }

            //     if ($("input[name='document']").val() == "") {
            //         alertify.error("Bank info document is required");
            //         e.preventDefault();
            //         return false;
            //     }
            // }

            // if (payment_method == 2) {

            //     if ($("input[name='factory_showroom']").val() == "") {
            //         alertify.error("Sender mobile no is required");
            //         e.preventDefault();
            //         return false;
            //     }

            //     if ($("input[name='cash_payment_document']").val() == "") {
            //         alertify.error("Receiver mobile no is required");
            //         e.preventDefault();
            //         return false;
            //     }
            // }

            // if (payment_method == 5) {

            //     if ($("input[name='factory_showroom']").val() == "") {
            //         alertify.error("Factory Side/Showroom name is required");
            //         e.preventDefault();
            //         return false;
            //     }

            //     if ($("input[name='cash_payment_document']").val() == "") {
            //         alertify.error("Document is required");
            //         e.preventDefault();
            //         return false;
            //     }
            // }

            // if (payment_method == 3) {
            //     alertify.error("Please choose other payment option");
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
    });

</script>


@endpush
