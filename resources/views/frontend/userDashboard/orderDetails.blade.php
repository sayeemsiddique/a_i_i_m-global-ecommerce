@extends('customer.layout.master')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="cart-page">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Order Details</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="container account-page">
            <div class="mb-8">
                @if ($user->type == 3)
                    <h1 class="text-center">Dealer Account</h1>
                @elseif ($user->type == 2)
                    <h1 class="text-center">Corporate Consumer Account</h1>
                @else
                    <h1 class="text-center">Customer Account</h1>
                @endif
            </div>

            <div class="tab tab-vertical row gutter-lg">

                {{-- @include('frontend.layout.accountMenu') --}}

                <div class="tab-content mb-6" style="padding: 1rem;">
                    
                    <div class="tab-pane mb-4 active in">
                        <div class="icon-box icon-box-side icon-box-light">
                            <span class="icon-box-icon icon-orders">
                                <i class="w-icon-orders"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title text-capitalize ls-normal mb-0" style="font-weight: 600;">Order Details</h4>
                            </div>
                        </div>

                        @include('alerts.alerts')

                        <table class="address-table table">
                            <tbody>
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>

                                    <th>Order Date:</th>
                                    <td>{{ date('d M Y', strtotime($orderDetails->created_at)) }}</td>
                                </tr>


                                <tr>
                                    <th>Order ID:</th>
                                    <td>{{ $orderDetails->tracking_code ?? '' }}</td>

                                    <th>Delivery Address:</th>
                                    <td>{{ $orderDetails->shipping_address ?? '' }}</td>
                                </tr>
                                <tr class="order-status">
                                    <th>Order Status</th>
                                    <td>
                                        @if ($orderDetails->stage == 0)
                                            <span class="badge" style="background:#144ceb; color:white;">Pending</span>
                                        @elseif($orderDetails->stage == 1)
                                            <span class="badge badge-primary text-whiteAfter Deducting TDS (10%) on Commission">Order Accepted</span>
                                        @elseif($orderDetails->stage == 2)
                                            <span class="badge badge-danger">Order Declined</span>
                                        @elseif($orderDetails->stage == 3)
                                            <span class="badge badge-primary text-whiteAfter Deducting TDS (10%) on Commission">On Delivery</span>
                                        @elseif($orderDetails->stage == 4)
                                            <span class="badge badge-success">Order Complete</span>
                                        @elseif($orderDetails->stage == 5)
                                            <span class="badge badge-danger">Order Canceled</span>
                                        @else
                                            <span class="badge badge-danger">Unknown Status</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="icon-box-title text-capitalize ls-normal mb-0" style="font-weight: 600;">Ordered Items</h4>
                        <table class="account-orders-table mb-6 table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="order-id">Item Name</th>
                                    <th class="order-date">Factory Price</th>
                                    <th class="order-date">SD & VAT</th>
                                    <th class="order-status">Quantity (pcs)</th>
                                    <th class="order-status">Weight</th>
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
                                        <td class="order-id">{{ $order->product ? $order->product->name : '' }}</td>
                                        <td class="order-date">৳ {{ number_format($order->f_price, 2, '.', '') }}</td>
                                        <td class="order-date">৳ {{ number_format($order->sd_total, 2, '.', '') }} & ৳ {{ number_format($order->vat_total, 2, '.', '') }}</td>
                                        <td class="order-date">{{ number_format($order->quantity) ?? 0 }}</td>
                                        @php
                                            $sub_total = $order->price * $order->quantity;
                                        @endphp
                                        <td class="order-date">
                                            @if ($order->weight and $order->unit)
                                                @if ($order->unit == 1)
                                                    {{number_format((($order->quantity * $order->weight)),2,'.','')}} KG
                                                @elseif ($order->unit == 2)
                                                    {{number_format(($order->quantity * $order->weight),2,'.','')}} M.T
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-right" style="min-width: 170px;">৳ {{ number_format($sub_total, 2, '.', '') }}</td>
                                    </tr>

                                    @php
                                        $totalProductPrice += $sub_total;
                                    @endphp
                                @endforeach

                                <!--Show sub-total/total product price-->
                                <tr class="font-weight-bold text-right">
                                    <td colspan="5" class="order-date text-right">Subtotal</td>
                                    <td class="order-date font-weight-bold">৳ {{ number_format($totalProductPrice, 2, '.', '') }}</td>
                                </tr>

                                <!--Show user type discount-->
                                <tr class="font-weight-bold text-right">
                                    @php
                                        $userType = $orderDetails->user ? $orderDetails->user->type : 100;
                                    @endphp

                                    @if ($userType == 3)
                                        <td colspan="5" class="order-date text-right">After Deducting TDS ({{ $orderDetails->tds }}%) on Commission ({{ $orderDetails->user_type_discount ?? 0 }} %)</td>
                                        <td class="order-date">৳ {{ number_format($orderDetails->discount_amount ?? 0, 2,'.','') }}</td>
                                    @else
                                        <td colspan="5" class="order-date text-right">After Deducting TDS ({{ $orderDetails->tds }}%) on Commission ({{$orderDetails->user_type_discount ?? 0}} %)</td>
                                        <td class="order-date">৳ {{ number_format($orderDetails->discount_amount ?? 0, 2,'.','') }}</td>
                                    @endif
                                </tr>

                                <!--Show order amount (1.5 lakh) commission-->
                                @if ($orderDetails->discount_on_amount == 2)
                                    <tr class="font-weight-bold text-right">
                                        <td colspan="5" class="order-date text-right">Order Commission ({{$orderDetails->discount_percent_in_total ?? 0}} %)</td>
                                        <td class="order-date">৳ {{number_format($orderDetails->discount_amount_in_total ?? 0, 2,'.','')}}</td>	
                                    </tr>
                                @endif

                                <!--Show packing charge-->
                                <tr class="font-weight-bold text-right">
                                    <td colspan="5" class="order-date text-right">Packing Charge ({{$orderDetails->packType ? $orderDetails->packType->name : 'N/A'}})</td>
                                    <td class="order-date">৳ {{number_format($orderDetails->packing_amount ?? 0, 2,'.','')}}</td>
                                </tr>

                                <!--Show transportation charge-->
                                <tr class="font-weight-bold text-right">
                                    {{-- <td class="order-date">Transportation Charge</td> --}}
                                    <td colspan="5" class="order-date text-right">After Imposing VDS ({{ $orderDetails->vds }}%) on Carrying Cost</td>
                                    <td class="order-date">৳ {{number_format($orderDetails->courier_cost ?? 0, 2,'.','')}}</td>
                                </tr>

                                <!--Show total price-->
                                <tr class="font-weight-bold text-right" style="border-top: 1px solid #000;">
                                    <td colspan="5" class="order-date text-right">Total</td>
                                    <td class="order-date">৳ {{ number_format($orderDetails->grand_total_price ?? 0, 2,'.','') }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                    </div>

                </div>
                
            </div>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

@push('script')
    <script>
        function previewFiles() {
            var preview = document.querySelector('img#imagePreview1');
            var file = document.querySelector('input#imageUpload1').files[0];
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush