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
                    <div class="card card-custom example example-compact order-details-section">
                        <div class="card-header">
                            <h3 class="card-title">Order Details</h3>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">
                        <div>
                            <h4 class="icon-box-title text-capitalize ls-normal mb-0" style="font-weight: 600;">Order Information</h4>

                            <div class="d-flex">
                                <div class="flex-fill">
                                    <p>Name: {{ $user->first_name }} {{ $user->last_name }}</p>
                                    <p class="mb-1">Email: {{ $user->email }}</p>
                                    <p class="mb-1">Mobile: {{ $user->mobile }}</p>
                                    <p class="mb-1">Order Date: {{ date('d M Y', strtotime($orderDetails->created_at)) }}</p>
                                    <p class="mb-1">Invoice Number: {{ sprintf('%08d', $orderDetails->salePaymentInfo->id ?? 0) }}</p>
                                    <p class="mb-1">Order ID: {{ $orderDetails->tracking_code }}</p>
                                    <p class="mb-1">Order Status: @foreach (orderStatus() as $key => $order_status)
                                                            @if($orderDetails->status == $key) {{$order_status}} @endif
                                                        @endforeach
                                    </p>
                                    <p class="mb-1">
                                        Delivery Status: @foreach(deliveryStatus() as $key => $delivery_status)
                                                            @if($orderDetails->delivery_status == $key) {{$delivery_status}} @endif
                                                        @endforeach
                                    </p>
                                    <p class="mb-1">
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
                                <div class="flex-fill text-right">
                                    @if ($orderDetails->store_id > 0)
                                        <label class="">
                                            <strong>Store Pickup Location:</strong>
                                        </label>
                                        <p class="mb-0">{{ $orderDetails->storeInfo->name ?? '' }} </p>
                                        <p class="mb-0">{{ $orderDetails->storeInfo->divisionInfo->name ?? ''}}, {{ $orderDetails->storeInfo->districtInfo->name ?? ''}}, {{ $orderDetails->storeInfo->upazilaInfo->name ?? ''}}</p>
                                        <p class="mb-0">{{ $orderDetails->storeInfo->address }}</p>
                                    <br/>
                                    @endif
                                </div>
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

                                @if ($orderDetails->voucher_id > 0 and $orderDetails->voucher_discount > 0)
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Voucher Discount</strong></td>
                                        <td colspan="1" class="order-date font-weight-bold text-right">{{ number_format($orderDetails->voucher_discount, 0, '.', '') }}</td>
                                    </tr>
                                @endif

                                <tr class="font-weight-bold text-right">
                                    <td colspan="3" class="order-date text-right">Shipping Cost</td>
                                    <td class="order-date font-weight-bold">{{$global_setting->currency ?? ""}} {{ number_format($orderDetails->shipping_cost, 0, '.', '') }}</td>
                                </tr>



                                <!--Show total price-->
                                <tr class="font-weight-bold text-right" style="border-top: 1px solid #000;">
                                    <td colspan="3" class="order-date text-right">Grand Total</td>
                                    <td class="order-date">{{$global_setting->currency ?? ""}} {{ number_format($orderDetails->grand_total_price ?? 0, 0,'.','') }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <p>
                            <span id="exportPdfBtn" class="btn btn-bordered border-info">Download Invoice</span>
                        </p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                        <div class="invoice_box-section" style="display:none;">
                            <div id="element-to-print">
                                @include('customer.invoice_template', ['order' => $orderDetails, 'user' => $user])
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('stackScript')
<script src="https://unpkg.com/easyqrcodejs@4.6.0/dist/easy.qrcode.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
document.getElementById('exportPdfBtn').addEventListener('click', function() {
    $('.order-details-section').hide();
    $('.invoice_box-section').show();
    var element = document.getElementById('element-to-print');
    html2pdf(element);
    $('.order-details-section').show();
    $('.invoice_box-section').hide();
});

let options = {
        text: "{{ route('getOrderTrack') }}?tracking_code={{$orderDetails->tracking_code}}&mobile={{$user->mobile}}",
        width: 120,
        height: 120,
        colorDark: "#000000",
        colorLight: "#ffffff",
    };
    new QRCode(document.getElementById("qrcode"), options);
</script>
@endpush


