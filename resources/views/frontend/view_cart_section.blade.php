@php
    $product_total_price = 0;
    $discount_amount = 0;
@endphp
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
                            <br/>
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
                            <a href="#" onclick="deleteFromCart(this)" class="text-danger font-size-20 remove-cart-alt" title="Remove" data-cart_id="{{$cart->id}}"> <i class="fa fa-trash"></i> </a>
                        </td>
                    </tr>
                    @endforeach

                    @foreach ($guest_carts as $key => $guest_cart)
                    <tr class="border-bottom">
                        <td>
                            {{++$key}}
                        </td>

                        <td class="d-md-table-cell">
                            <a href="{{route('product-detail', Crypt::encryptString($guest_cart->product_id))}}?slug={{$guest_cart->productInfo->slug ?? ''}}"><img loading="lazy" class="img-fluid max-width-100 p-1 border border-color-1" src="{{asset('storage/product')}}/{{$guest_cart->productInfo->image ?? ''}}" alt="Image Description"></a>
                        </td>

                        <td data-title="Product">
                            <a href="{{route('product-detail', Crypt::encryptString($guest_cart->product_id))}}?slug={{$guest_cart->productInfo->slug ?? ''}}" class="text-gray-90">{{$guest_cart->productInfo->name ?? ''}}</a>
                            <br/>
                            @if ($guest_cart->variation_id > 0)
                                <span class="text-success">
                                    <small>
                                        @foreach (($guest_cart->varientDataInfo ?? []) as $varientDataInfo)
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

                        <td data-title="Quantity">
                            <span class="sr-only">Quantity</span>
                            <!-- Quantity -->
                            @php
                                $in_stock = $guest_cart->stockInfo($guest_cart->product_id, $guest_cart->variation_id)->quantity ?? 0;
                                if(!$in_stock){
                                    $in_stock = 0;
                                }
                            @endphp

                            <div class="border rounded-pill py-1 px-3 border-color-1">
                                <div class="js-quantity row align-items-center">
                                    <div class="col">
                                        <input type="hidden" name="cart_id[]" value="{{$guest_cart->id}}">
                                        <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none" type="text" value="{{ $guest_cart->quantity }}" onkeyup="quantity_change(this)" autocomplete="off" name="quantity[]" data-stock_quantity="{{ $in_stock }}">
                                        <input type="hidden" class="actual_quantity" value="{{ number_format($guest_cart->quantity) }}">
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
                            <span class="">৳ @if ($guest_cart->variation_id == 0){{$guest_cart->productInfo->discount_price ?? ''}} @else {{$guest_cart->varientInfo->discount_price ?? 0}} @endif</span>
                        </td>

                        <td data-title="Total" style="white-space: nowrap;">
                            <span class="total_amount d-block text-right">
                                ৳ @if ($guest_cart->variation_id == 0)
                                    @php
                                        $product_total_price +=  ($guest_cart->productInfo->discount_price ?? 0)  * $guest_cart->quantity;
                                    @endphp
                                    {{number_format((($guest_cart->productInfo->discount_price ?? 0)  * $guest_cart->quantity),2,".","")}}

                                @else
                                    @php
                                        $product_total_price +=  ($guest_cart->varientInfo->discount_price ?? 0)  * $guest_cart->quantity;
                                    @endphp
                                    {{number_format((($guest_cart->varientInfo->discount_price ?? 0) * $guest_cart->quantity),2,".","")}}

                                @endif
                            </span>
                        </td>

                        <td class="text-right">
                            <a href="#" class="text-danger font-size-20 guest-remove-cart-alt" title="Remove" data-cart_id="{{$guest_cart->id}}"> <i class="fa fa-trash"></i> </a>
                        </td>
                    </tr>
                    @endforeach

                    @php
                        $total_vat = 0;
                        $total_tax = 0;
                        $in_total = $product_total_price - $discount_amount;

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
