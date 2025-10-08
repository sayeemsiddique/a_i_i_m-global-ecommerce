@php
    $cart_amount  = 0;
@endphp
<ul class="list-unstyled px-3 pt-3">
    @foreach ($carts as $key => $cart)
    @php
        if ($cart->variation_id == 0) {
            $cart_amount  += (($cart->productInfo->discount_price ?? 0) * $cart->quantity);
        } else {
            $cart_amount  += (($cart->varientInfo->discount_price ?? 0) * $cart->quantity);
        }
    @endphp
        <li class="border-bottom pb-3 mb-3">
            <div class="">
                <ul class="list-unstyled row mx-n2">
                    <li class="px-2 col-auto">
                        <img style="max-width: 100px;" class="img-fluid" src="{{asset('storage/product')}}/{{$cart->productInfo->image ?? ''}}" alt="Image Description">
                    </li>
                    <li class="px-2 col">
                        <h5 class="text-blue font-size-14 font-weight-bold mb-0">{{$cart->productInfo->name ?? ''}}</h5>
                        @if ($cart->variation_id > 0)
                            <span class="font-size-14">
                                <small style="color: #b36a0d;font-weight: bold;">
                                    @foreach (($cart->varientDataInfo ?? []) as $varientDataInfo)
                                        @if ($loop->last)
                                            {{$varientDataInfo->varientTypeInfo->name ?? ''}}: {{$varientDataInfo->data_value}}
                                        @else
                                            {{$varientDataInfo->varientTypeInfo->name ?? ''}}: {{$varientDataInfo->data_value}},
                                        @endif
                                    @endforeach
                                </small>
                            </span> <br/>
                        @endif
                        <span class="font-size-14">{{$cart->quantity}} × ৳@if ($cart->variation_id == 0){{$cart->productInfo->discount_price ?? ''}} @else {{$cart->varientInfo->discount_price ?? 0}} @endif</span>
                    </li>
                    <li class="px-2 col-auto">
                        <a href="#">
                            <i style="cursor: pointer;" data-cart_id="{{$cart->id}}" onclick="removeGuestCart(this)" class="ec ec-close-remove"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    @endforeach
</ul>

<input type="hidden" class="guest_cart_amount" value="{{ $cart_amount }}" />
<input type="hidden" class="guest_cart_quantity" value="{{ count($carts)}}" />

