@extends('customer.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Search Order</h3>
                            <div class="d-flex align-items-center">
                                <a class="btn btn-success btn-sm" href="{{route('return_order_list')}}">Return List</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="mt-0 mb-5">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" placeholder="Enter Order No" name="order_no" value="{{ request()->order_no }}">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex">
                                            <div class="">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>


                        <div class="table-responsive">
                            @if ($order)
                            <form action="{{route('return_order')}}" method="post">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ Crypt::encryptString($order->id) }}">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-left">Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Return Quantity</th>
                                            {{-- <th>Return Reason</th> --}}
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetails as $orderProduct)
                                            @php
                                                $returned_orders = $orderProduct->returnOrderInfo->whereIn('status', [0,1])->where('user_id', auth()->user()->id);
                                                $return_quantity = 0;
                                                // dd($returned_orders);
                                                if (count($returned_orders) > 0) {
                                                    foreach ($returned_orders as $key => $returned_order) {
                                                        foreach ($returned_order->orderDetails as $key => $returnOrderDetails) {
                                                            if ($returnOrderDetails->order_detail_id == $orderProduct->id) {
                                                                $return_quantity += $returnOrderDetails->quantity;
                                                            }

                                                        }
                                                    }
                                                }


                                            @endphp
                                            @if (($orderProduct->quantity - $return_quantity) > 0)

                                                <tr>
                                                    <td class="text-left">
                                                        {{ $orderProduct->productInfo->name ?? ''}} <br>
                                                        @if ($orderProduct->varient_id > 0)
                                                            @foreach ($orderProduct->varientData as $varient)
                                                                <small class="text-info">
                                                                    {{$varient->varientTypeInfo->name ?? ''}} : {{$varient->data_value}}
                                                                    @if (!$loop->last) , @endif
                                                                </small>
                                                            @endforeach
                                                        @endif

                                                    </td>
                                                    <td>{{ number_format(($orderProduct->quantity - $return_quantity), 0, '.', '') }}</td>
                                                    <td>{{ number_format($orderProduct->price, 0, '.', '') }}</td>
                                                    <td>{{ number_format((($orderProduct->quantity - $return_quantity) * $orderProduct->price), 0, '.', '') }}</td>
                                                    <td>
                                                        <input type="number" min="0" max="{{ ($orderProduct->quantity - $return_quantity) }}" name="details_id[{{Crypt::encryptString($orderProduct->id)}}]" class="form-control" placeholder="Return Quantity" />
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        @if ($order->voucher_id > 0 and $order->voucher_discount > 0)
                                            <tr>
                                                <td colspan="4" class="text-right"><strong>Voucher Discount</strong></td>
                                                <td colspan="1" class="text-right">{{ number_format($order->voucher_discount, 0, '.', '') }}</td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Shipping Cost</strong></td>
                                            <td colspan="1" class="text-right">{{ number_format($order->shipping_cost, 0, '.', '') }}</td>
                                        </tr>

                                        {{-- <tr>
                                            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                                            <td colspan="1" class="text-right">{{ number_format($order->grand_total_price, 0, '.', '') }}</td>
                                        </tr> --}}
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Return Reason</strong></td>
                                            <td colspan="2" class="text-right">
                                                <textarea class="form-control" placeholder="Enter return reason" name="reason"></textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary text-right">Submit Return Request</button>
                                </div>
                            </form>
                            @else
                            <p>Search by order no to return</p>
                            @endif
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

