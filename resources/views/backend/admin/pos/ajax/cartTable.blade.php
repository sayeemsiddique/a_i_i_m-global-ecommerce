<table class="table table-bordered">
    <thead>
        <tr style="background-color: #6e3cbc !important;">

            <th style="color: #fff !important;">Item</th>
            <th style="color: #fff !important;">Variant</th>
            <th style="color: #fff !important;">Quantity (pcs)</th>
            <th style="color: #fff !important;">Price</th>
        </tr>

    </thead>
    <tbody>
        @isset($cartItems)
        @foreach ($cartItems as $item)
        <tr>
            <td align="left">{{ $item->product ?  $item->product->name : ''}}</td>
            <td>
                @foreach ($item->varientDataInfo as $varientDataInfo)
                    @if ($loop->last)
                        {{$varientDataInfo->data_value}}
                    @else
                        {{$varientDataInfo->data_value}},
                    @endif
                @endforeach
            </td>
            <td style="white-space: nowrap;">

                <input type="text" style="width: 60px; text-align: center;" class="update-cart-quantity{{ $item->id }}"
                    onkeyup="updateCartQuantity({{ $item->id }})" item-id="{{ $item->id }}"
                    value="{{ $item->quantity }}">
                <span class="test"></span>
                <button type="button" class="btn pt-1 btn-delete{{ $item->id }}" onclick="deleteCart({{ $item->id }})"
                    style="margin-top: -8px; margin-left: -10px;" data-id="{{ $item->id }}"><i
                        class="la la-trash w3-text-red"></i></button>
            </td>

            <td align="right">{{ number_format($item->price * $item->quantity, 2)  }}</td>

        </tr>
        @endforeach

        @endisset
    </tbody>
</table>

<div class="card-footer p-0">
    @isset($total_price)

    @if ($total_price > 0)
    <table class="table table-striped mt-4">

        <tr>
            <td align="left"><b>Total</b></td>
            <td colspan="3" align="right"><b>{{ number_format($total_price, 2) }}</b></td>
        </tr>
    </table>
    @endif

    @endisset
</div>
