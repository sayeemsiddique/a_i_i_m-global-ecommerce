<table class="table table-striped">
    <thead>
        <tr>


            <th class="text-left">ID</th>
            <th class="text-left">Product Name</th>
            <th class="text-left">Code</th>
            <th class="text-left">Variant</th>
            <th>Quantity (pcs)</th>
            <th>Price (TK)</th>
            <th class="text-left">Add To Cart</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($stock as $stoke)
            <tr style="background: {{ $loop->iteration % 2 == 0 ? '#ecffe5' : '#c2f3ea' }} ;">

                <td class="text-left">{{ $stoke->id }}</td>

                <td class="text-left">{{ $stoke->product ? $stoke->product->name : '' }} ({{ $stoke->product->productCategory->name ?? '' }})</td>

                <td class="text-left">
                    {{ $stoke->product->code ?? '' }}
                </td>

                <td class="text-left">
                    @if ($stoke->varient_id > 0)
                        @foreach ($stoke->varientDataInfo as $varientDataInfo)
                            @if ($loop->last)
                            {{$varientDataInfo->data_value}}
                            @else
                            {{$varientDataInfo->data_value}},
                            @endif
                        @endforeach
                    @else
                        N/A
                    @endif
                    {{-- @if ($varientData = $stoke->productVarient($stoke->varient_id) != '-')
                        {{ $stoke->productVarient($stoke->varient_id)->data_value }}
                    @else
                        -
                    @endif --}}
                </td>

                <td><b><span style="font-size: 20px; color:green;">{{ number_format($stoke->quantity) }}</span></b></td>

                <td>
                    @if ($stoke->product)
                        @if ($stoke->product->discount_price != 0)
                            {{ number_format(($stoke->product->discount_price ?? 0), 2) }}
                        @else 
                            {{ number_format(($stoke->varient->discount_price ?? 0), 2) }}
                        @endif
                    
                    @endif
                </td>
                
                <td class="text-left">
                    @if ($stoke->quantity > 0)
                    <button class="btn add-to-cart btn-danger " onclick="addToCart({{ $stoke }})" data-id="{{ $stoke->id }}">
                        <i class="la la-shopping-cart la-4x"></i>
                    </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
