<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            {{-- <th class="text-left">Product Type</th> --}}
            <th class="text-left">Product Name</th>
            <th>Product Code</th>
            <th>Product Variant</th>
            <th>Damage Quantity</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($orders->count() > 0)
        @php
            $i = (($orders->currentPage() - 1) * $orders->perPage() + 1);
        @endphp
            @foreach ($orders as $order)
                <tr>
                    <td>
                        {{ $i }}
                    </td>

                    {{-- <td align="left">
                        @if ($order->productInfo)
                            @if ($order->productInfo->type == 2)
                                Store Product
                            @else
                                Finished Product
                            @endif
                        @else
                            Invalid Type
                        @endif
                    </td> --}}
                    
                    <td align="left">{{ $order->productInfo->name ?? '' }}</td>

                    <td>{{ $order->productInfo->code ?? 'N/A' }}</td>

                    <td>
                        @if (count($order->varientData) > 0)
                            @foreach ($order->varientData as $item)
                                {{ $item->data_value }}
                            @endforeach
                        @else
                            N/A
                        @endif
                    </td>

                    <td>{{ number_format($order->damage_quantity ?? 0) }}</td>

                    <td>
                        @php
                            $date= new DateTime($order->damage_created)
                        @endphp
                        {{ $date->format('Y-m-d H:i:s') ?? "" }}
                    </td>
                    <td>
                        @can('delete_damage')

                            <a onclick="return confirm('Are you sure to delete?')" href="{{route('admin.productDamage.delete', $order->order_id)}}" class="btn btn-sm btn-clean btn-icon" title="Delete">
                                <i class="la la-remove"></i>
                            </a>
                        @endcan
                    </td>
                </tr>

                @php
                    $i++;
                @endphp

            @endforeach
        @else
            <tr class="odd"><td valign="top" colspan="11" class="dataTables_empty">No matching records found</td></tr>
        @endif
    </tbody>
</table>