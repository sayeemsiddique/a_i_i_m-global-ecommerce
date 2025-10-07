<option value="">Select</option>
@foreach ($datas->productVarient as $productVarient)

    <option data-price="{{$productVarient->discount_price}}" data-quantity="{{$productVarient->productStock->quantity ?? 0}}" value="{{$productVarient->id}}">
        @foreach ($productVarient->productVarientData as $VarientData)
            {{$VarientData->data_value}} @if (!$loop->last)
                and
            @endif
        @endforeach
    </option>
@endforeach