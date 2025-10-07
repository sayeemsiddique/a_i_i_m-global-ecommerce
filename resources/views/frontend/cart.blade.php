@extends('frontend.layout.master_alt')

@section('content')

@php
    $product_total_price = 0;
    $discount_amount = 0;
@endphp

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="cart-page">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('index')}}">Home</a></li>
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="container">
            
            <div class="mb-4">
                <h1 class="text-center">My Cart</h1>
            </div>

            @if (count($carts) > 0)
            <form class="mb-4" action="{{route('update_cart')}}" method="post">
                @csrf

                <div class="cart-table">
                    <table class="table" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="product-name">
                                    <strong>SL</strong>
                                </th>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">
                                    <strong>Product</strong>
                                </th>
                                {{-- <th class="product-price">
                                    <strong>Price</strong>
                                </th> --}}
                                {{-- <th class="product-quantity w-lg-15">SD</th> --}}
                                {{-- <th class="product-quantity w-lg-15">VAT</th> --}}
                                <th class="product-quantity w-lg-15" style="min-width: 160px;">
                                    <strong>Quantity</strong>
                                </th>
                                <th class="product-price text-right">
                                    <strong>Unit Price</strong>
                                </th>
                                <th class="product-subtotal text-right">
                                    <strong>Total</strong>
                                </th>
                                <th class="product-remove">&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($carts as $key => $cart)
                            <tr class="border-bottom">
                                <td>
                                    {{++$key}}
                                </td>

                                <td class="d-md-table-cell">
                                    <a href="{{route('product-detail', Crypt::encryptString($cart->product_id))}}?slug={{$cart->productInfo->slug ?? ''}}"><img loading="lazy" class="img-fluid max-width-100 p-1 border border-color-1" src="{{asset('storage/product')}}/{{$cart->productInfo->image ?? ''}}" alt="Image Description"></a>
                                </td>

                                <td data-title="Product">
                                    <a href="{{route('product-detail', Crypt::encryptString($cart->product_id))}}?slug={{$cart->productInfo->slug ?? ''}}" class="text-gray-90">{{$cart->productInfo->name ?? ''}}</a>
                                    
                                    @if ($cart->variation_id > 0)
                                        <span class="text-success">
                                            <small>
                                                @foreach (($cart->varientDataInfo ?? []) as $varientDataInfo)
                                                    @if ($loop->last)
                                                        {{$varientDataInfo->varientTypeInfo->name ?? ''}}: {{$varientDataInfo->data_value}}
                                                    @else
                                                        {{$varientDataInfo->varientTypeInfo->name ?? ''}}: {{$varientDataInfo->data_value}},
                                                    @endif
                                                @endforeach
                                            </small>
                                        </span>
                                    @endif
                                </td>

                                {{-- <td data-title="Price" style="white-space: nowrap;">
                                    <span class="">৳ @if ($cart->variation_id == 0){{$cart->productInfo->price ?? ''}} @else {{$cart->varientInfo->price ?? 0}} @endif</span>
                                </td> --}}

                                {{-- <td style="white-space: nowrap;">
                                    <span class="">
                                        ৳
                                        @if ($cart->variation_id > 0)
                                            @php
                                                $price_with_sd = (($cart->varientInfo->price ?? 0) * ($cart->varientInfo->sd ?? 0))/100;
                                            @endphp
                                            {{ number_format($price_with_sd,2,'.','') }} ( {{$cart->varientInfo->sd ?? 0 }} %)
                                        @else 
                                            @php
                                                $price_with_sd = (($cart->productInfo->price ?? 0) * ($cart->productInfo->sd ?? 0))/100;
                                            @endphp
                                            {{ number_format($price_with_sd,2,'.','') }} ( {{$cart->productInfo->sd ?? 0 }} %)
                                        @endif
                                    </span>
                                </td> --}}

                                {{-- <td style="white-space: nowrap;">
                                    <span class="">
                                        ৳
                                        @if ($cart->variation_id > 0)
                                            @php
                                                $price_with_vat = ((($cart->varientInfo->price ?? 0) + $price_with_sd) * ($cart->varientInfo->vat ?? 0))/100;
                                            @endphp
                                            {{ number_format($price_with_vat,2,'.','') }} ( {{$cart->varientInfo->vat ?? 0 }} %)
                                        @else 
                                            @php
                                                $price_with_vat = (($cart->productInfo->price ?? 0) * ($cart->productInfo->vat ?? 0))/100;
                                            @endphp
                                            {{ number_format($price_with_vat,2,'.','') }} ( {{$cart->productInfo->vat ?? 0 }} %)
                                        @endif
                                    </span>
                                </td> --}}

                                <td data-title="Quantity">
                                    <span class="sr-only">Quantity</span>
                                    <!-- Quantity -->
                                    @php
                                        $in_stock = $cart->stockInfo($cart->product_id, $cart->variation_id)->quantity ?? 0;
                                        if(!$in_stock){
                                            $in_stock = 0;
                                        }
                                    @endphp

                                    <div class="border rounded-pill py-1 px-3 border-color-1">
                                        <div class="js-quantity row align-items-center">
                                            <div class="col">
                                                <input type="hidden" name="cart_id[]" value="{{$cart->id}}">
                                                <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none" type="text" value="{{ $cart->quantity }}" onkeyup="quantity_change(this)" autocomplete="off" name="quantity[]" data-stock_quantity="{{ $in_stock }}">
                                                <input type="hidden" class="actual_quantity" value="{{ number_format($cart->quantity) }}">
                                            </div>
                                            <div class="col-auto pr-1">
                                                <a onclick="js_minus_action(this)" class="js-minus-action btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
                                                    <small class="fas fa-minus btn-icon__inner"></small>
                                                </a>
                                                <a data-stock_quantity="{{ $in_stock }}" onclick="js_plus_action(this)" class="js-plus-action btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
                                                    <small class="fas fa-plus btn-icon__inner"></small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Quantity -->
                                </td>

                                <td data-title="Price" style="white-space: nowrap;" class="text-right">
                                    <span class="">৳ @if ($cart->variation_id == 0){{$cart->productInfo->discount_price ?? ''}} @else {{$cart->varientInfo->discount_price ?? 0}} @endif</span>
                                </td>

                                <td data-title="Total" style="white-space: nowrap;">
                                    <span class="total_amount d-block text-right">
                                        ৳ @if ($cart->variation_id == 0)
                                            @php
                                                $product_total_price +=  ($cart->productInfo->discount_price ?? 0)  * $cart->quantity;
                                            @endphp
                                            {{number_format((($cart->productInfo->discount_price ?? 0)  * $cart->quantity),2,".","")}}
                                            
                                        @else
                                            @php
                                                $product_total_price +=  ($cart->varientInfo->discount_price ?? 0)  * $cart->quantity;
                                            @endphp
                                            {{number_format((($cart->varientInfo->discount_price ?? 0) * $cart->quantity),2,".","")}}
                                            
                                        @endif
                                    </span>
                                </td>

                                <td class="text-right">
                                    <a href="#" class="text-danger font-size-20 remove-cart-alt" title="Remove" data-cart_id="{{$cart->id}}"> <i class="fa fa-trash"></i> </a>
                                </td>
                            </tr>
                            @endforeach

                            @php
                                $total_vat = 0;
                                $total_tax = 0;
                                $in_total = $product_total_price - $discount_amount;

                                // if ($setting->vat > 0) {
                                //     $total_vat = ($in_total * $setting->vat) / 100;
                                // }

                                // if ($setting->tax > 0) {
                                //    $total_tax = (($in_total * $setting->tax) / 100);
                                // }
                            @endphp

                            <tr class="border-top space-top-2 justify-content-center">
                                <td class="text-right font-weight-bold" colspan="5">Total</td>
                                <td data-title="Total" colspan="2">
                                    <strong><span class="amount">৳
                                        {{ number_format(($in_total + $total_tax + $total_vat),2,".","") }}
                                    </span></strong>
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="10" class="space-top-2 justify-content-center">
                                    <div class="pt-md-3">
                                        <div class="d-block d-md-flex flex-center-between">
                                            <div class="mb-3 mb-md-0 w-xl-40">
                                                <!-- Apply coupon Form -->
                                                
                                                    {{-- <label class="sr-only" for="subscribeSrEmailExample1">Coupon code</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="text" id="subscribeSrEmailExample1" placeholder="Coupon code" aria-label="Coupon code" aria-describedby="subscribeButtonExample2" required="">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-block btn-dark px-4" type="button" id="subscribeButtonExample2"><i class="fas fa-tags d-md-none"></i><span class="d-none d-md-inline">Apply coupon</span></button>
                                                        </div>
                                                    </div> --}}
                                                
                                                <!-- End Apply coupon Form -->
                                            </div>
                                            <div class="d-md-flex">
                                                <button type="submit" class="btn btn-success px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block text-white">Update Cart</button>
                                                <button type="submit" name="checkout" value="1" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block text-white">Proceed to checkout</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-8 cart-total">
                    <div class="row">
                        <div class="col-xl-5 col-lg-6 offset-lg-6 offset-xl-7 col-md-8 offset-md-4">
                            {{-- <div class="border-bottom border-color-1 mb-3">
                                <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Cart Total</h3>
                            </div>
                            <table class="table mb-3 mb-md-0">
                                <tbody>
                                    <tr class="cart-subtotal">
                                        <th>Sub-total</th>
                                        <td data-title="Subtotal"><span class="amount">৳ {{number_format($product_total_price,2,".","")}}</span></td>
                                    </tr>
                                    @if (auth()->check() and in_array(auth()->user()->type,[2,3]))
                                        <tr class="shipping">
                                            <th>Discount</th>
                                            <td data-title="Shipping">
                                                @php
                                                    if (auth()->user()->type == 2) {
                                                        $user_discount_percent = $setting->consumer_discount_percent ?? 0;
                                                    } else {
                                                        $user_discount_percent = $setting->dealer_discount_percent ?? 0;
                                                    }
                                                    $discount_amount = ($product_total_price * $user_discount_percent)/100;
                                                @endphp
                                                <span class="amount">৳ {{number_format($discount_amount,2,".","")}} <small>({{$user_discount_percent}}%)</small></span>
                                                
                                            </td>
                                        </tr>
                                    @endif
                                    @php
                                        $in_total = $product_total_price - $discount_amount;
                                    @endphp
                                    {{-- <tr class="order-vat">
                                        <th>VAT</th>
                                        <td data-title="Vat">
                                            
                                                <span class="amount">
                                                    @php
                                                        $total_vat = 0;
                                                        $in_total = $product_total_price - $discount_amount;
                                                        if ($setting->vat > 0) {
                                                            $total_vat = ($in_total * $setting->vat) / 100;
                                                        }
                                                    @endphp
                                                    {{$setting->vat}} %
                                                </span>
                                            
                                        </td>
                                    </tr> --}}
                                    
                                    {{-- <tr class="order-tax">
                                        <th>SD</th>
                                        <td data-title="Tax">
                                            
                                                <span class="amount">
                                                    @php
                                                        $total_tax = 0;
                                                        if ($setting->tax > 0) {
                                                            $total_tax = (($in_total * $setting->tax) / 100);
                                                        }
                                                    @endphp
                                                    {{$setting->tax}} %
                                                </span>
                                            
                                        </td>
                                    </tr>
                                    
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td data-title="Total"><strong><span class="amount">৳
                                            {{-- {{number_format(($in_total + $total_tax + $total_vat),2,".","")}}
                                            {{number_format(($in_total),2,".","")}}
                                        </span></strong></td>
                                    </tr>
                                </tbody>
                            </table> --}}

                            {{-- <a href="{{route('checkout')}}" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-md-none">Proceed to checkout</a> --}}
                            <button type="submit" class="btn btn-success ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-md-none text-white">Update Cart</button>
                            <button type="submit" name="checkout" value="1" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5 w-100 w-md-auto d-md-none mt-3 text-white">Proceed to Checkout</button>
                            
                        </div>
                    </div>
                </div>
            </form>

            @else
                <h2 class="text-center mb-5">
                    Your cart is empty
                </h2>
            @endif
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

@push('script')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

{{-- data-cart_id --}}
<script>
    $(".remove-cart-alt").click(function () {
        if (confirm('Are you sure to remove this item from your cart')) {
            var cart_id = $(this).attr('data-cart_id');
            var url = "{{route('remove_cart_item')}}?id="+cart_id;
            window.location.replace(url);
        }
    });

    function js_minus_action(that){
        var quantity = $(that).closest(".js-quantity").find('.js-result').val();
        
        if (quantity > 1 ) {
            $(that).closest(".js-quantity").find('.js-result').val(Number(quantity) - 1);
        } else if (quantity == 1) {
            alertify.error("Quantity can't be bellow 1");
        }
    }
    
    function js_plus_action(that){
        
        // console.log(data);
        // stock_quantity
        var quantity = $(that).closest(".js-quantity").find('.js-result').val();
        var in_stock = $(that).closest(".js-quantity").find('.js-plus-action').attr('data-stock_quantity');
        
        if (Number(quantity) >= Number(in_stock) ) {
            alertify.error("Stock exit");
            
        } else {
            $(that).closest(".js-quantity").find('.js-result').val(Number(quantity) + 1);
        }
    }

    function quantity_change(that) {
        var quantity = $(that).closest(".js-quantity").find('.js-result').val();
        var in_stock = $(that).closest(".js-quantity").find('.js-result').attr('data-stock_quantity');
        var actual_quantity = $(that).closest(".js-quantity").find('.actual_quantity').val();
        
        if (Number(quantity) >= Number(in_stock) ) {
            alertify.error("Stock exit");
            quantity = $(that).closest(".js-quantity").find('.js-result').val(actual_quantity);
        }
    }
        
</script>

@endpush