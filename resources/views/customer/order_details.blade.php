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
                            <h3 class="card-title">Order Details</h3>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">
                        <div>
                            <h4 class="icon-box-title text-capitalize ls-normal mb-0" style="font-weight: 600;">Order Information</h4>
                            <div class="">
                                <p>Name: {{ $user->first_name }} {{ $user->last_name }}</p>
                                <p>Order Date: {{ date('d M Y', strtotime($orderDetails->created_at)) }}</p>
                                <p>Invoice Number: {{ sprintf('%08d', $orderDetails->salePaymentInfo->id ?? 0) }}</p>
                                <p>Order ID: {{ $orderDetails->tracking_code }}</p>
                                <p>Order Status: @foreach (orderStatus() as $key => $order_status)
														@if($orderDetails->status == $key) {{$order_status}} @endif
													@endforeach
                                </p>
                                <p>
                                    Delivery Status: @foreach(deliveryStatus() as $key => $delivery_status)
														@if($orderDetails->delivery_status == $key) {{$delivery_status}} @endif
													@endforeach
                                </p>
                                <p>
                                    Payment Status: @foreach(paymentStatus() as $key => $payment_status)
														@if(($orderDetails->paymentInfo->status ?? 0) == $key) {{$payment_status}} @endif
													@endforeach
                                </p>
                                {{-- @if (count($orderDetails->orderReturnInfos->where('status',1)) > 0)
                                    <label class="">Return Status:</label>
                                    <a href="{{route('returnOrderDetails', Crypt::encryptString($orderDetails->id))}}" target="_blank" class="btn btn-sm btn-primary">
                                        Check Return Status
                                    </a>
                                @endif --}}
                            </div>
                        </div>

                        <h4 class="icon-box-title text-capitalize ls-normal mb-0" style="font-weight: 600;">Ordered Items</h4>
                        <table class="account-orders-table mt-6 table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="order-id text-left">Item Name</th>
                                    <th class="order-date">Price</th>
                                    <th class="order-status">Quantity (pcs)</th>
                                    <th class="order-status text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subTotal = 0;
                                    $totalProductPrice = 0;
                                @endphp

                                @foreach ($orderDetails->orderDetails as $order)
                                    <tr>
                                        <td class="order-id text-left">
                                            {{ $order->product ? $order->product->name : '' }} <br>
                                            @if ($order->varient_id > 0)
                                                @foreach ($order->varientData as $varient)
                                                    <small class="text-info">
                                                        {{$varient->varientTypeInfo->name ?? ''}} : {{$varient->data_value}}
                                                        @if (!$loop->last) , @endif
                                                    </small>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="order-date">{{$global_setting->currency ?? ""}} {{ number_format($order->price, 0, '.', '') }}</td>
                                        <td class="order-date">{{ number_format($order->quantity) ?? 0 }}</td>
                                        @php
                                            $sub_total = $order->price * $order->quantity;
                                        @endphp
                                        <td class="text-right" style="min-width: 170px;">{{$global_setting->currency ?? ""}} {{ number_format($sub_total, 0, '.', '') }}</td>
                                    </tr>

                                    @php
                                        $totalProductPrice += $sub_total;
                                    @endphp
                                @endforeach

                                <!--Show sub-total/total product price-->
                                <tr class="font-weight-bold text-right">
                                    <td colspan="3" class="order-date text-right">Subtotal</td>
                                    <td class="order-date font-weight-bold">{{$global_setting->currency ?? ""}} {{ number_format($orderDetails->total_price, 0, '.', '') }}</td>
                                </tr>

                                <tr class="font-weight-bold text-right">
                                    <td colspan="3" class="order-date text-right">Shipping Cost</td>
                                    <td class="order-date font-weight-bold">{{$global_setting->currency ?? ""}} {{ number_format($orderDetails->shipping_cost, 0, '.', '') }}</td>
                                </tr>

                                @if ($orderDetails->voucher_id > 0 and $orderDetails->voucher_discount > 0)
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Voucher Discount</strong></td>
                                        <td colspan="1" class="order-date font-weight-bold text-right">{{ number_format($orderDetails->voucher_discount, 0, '.', '') }}</td>
                                    </tr>
                                @endif

                                <!--Show total price-->
                                <tr class="font-weight-bold text-right" style="border-top: 1px solid #000;">
                                    <td colspan="3" class="order-date text-right">Grand Total</td>
                                    <td class="order-date">{{$global_setting->currency ?? ""}} {{ number_format($orderDetails->grand_total_price ?? 0, 0,'.','') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

