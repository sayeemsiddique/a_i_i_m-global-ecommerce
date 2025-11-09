@extends('backend.layout.master')

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
                            <h3 class="card-title">Order Return</h3>
                            <div class="d-flex align-items-center">


                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0">

                            <form class="form-inline"  method="GET">
                                <table>
                                    <tr>

                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" name="order_id" value="{{$_GET['order_id'] ?? ""}}" placeholder="Search by Order ID" autocomplete="off">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success mt-2 ml-2">Show</button>
                                        </td>

                                    </tr>
                                </table>

                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">


                            @if ($order)

                            <form action="{{route('admin.order.order_return_confirm')}}" method="post">
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
                                                $returned_orders = $orderProduct->returnOrderInfo->where('status', 0)->where('user_id', $order->user_id);
                                                $return_quantity = 0;
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
                                                    <td>{{ number_format(($orderProduct->quantity - $return_quantity), 2, '.', '') }}</td>
                                                    <td>{{ number_format($orderProduct->price, 2, '.', '') }}</td>
                                                    <td>{{ number_format((($orderProduct->quantity - $return_quantity) * $orderProduct->price), 2, '.', '') }}</td>
                                                    <td>
                                                        <input type="number" min="0" max="{{ ($orderProduct->quantity - $return_quantity) }}" name="details_id[{{Crypt::encryptString($orderProduct->id)}}]" class="form-control" placeholder="Return Quantity" />
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Shipping Cost</strong></td>
                                            <td colspan="1" class="text-right">{{ number_format($order->shipping_cost, 2, '.', '') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                                            <td colspan="1" class="text-right">{{ number_format($order->grand_total_price, 2, '.', '') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Payment Status</strong></td>
                                            <td colspan="1" class="text-right">
                                                <select autocomplete="off" class="form-control" id="payment_status" name="payment_status" required>
                                                    <option value="">Select</option>
                                                    @foreach(returnPaymentStatus() as $key => $payment_status)
                                                        <option value="{{$key}}">{{$payment_status}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
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
                            {{-- <hr> --}}

                            {{-- <div class=" mb-5">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6">

                                        <span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
                                        <span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
                                            <label class="">Order Status:</label>
													@foreach (orderStatus() as $key => $order_status)
														@if($order->status == $key) {{$order_status}} @endif
													@endforeach


												<br/>



													<label class="">Delivery Status:</label>
													@foreach(deliveryStatus() as $key => $delivery_status)
														@if($order->delivery_status == $key) {{$delivery_status}} @endif
													@endforeach


												<br/>



													<label class="">Payment Status:</label>
													@foreach(paymentStatus() as $key => $payment_status)
														@if(($order->paymentInfo->status ?? 0) == $key) {{$payment_status}} @endif
													@endforeach

                                        </span>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-3">

                                        <span class="d-block" style="font-size: 15px;"><b>User Name :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->first_name : ''}} {{ $order->orderUserInfo ? $order->orderUserInfo->last_name : ''}} </span>

                                        <span class="d-block" style="font-size: 15px;"><b>Email :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->email : ''}} </span>

                                        <span class="d-block" style="font-size: 15px;"><b>Mobile :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->mobile : ''}} </span>

                                        <span class="d-block" style="font-size: 15px;"><b>Address :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->present_address : '' }} </span>

                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class=" top-0 left-0 right-0">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <form action="{{route("admin.order.order_return_confirm")}}" method="post">
                                                @csrf
                                                <input type="hidden" name="order_id" value="{{$order->id}}">


                                                <table class="table table-bordered table-responseve">
                                                    <thead class="bg-primary">
                                                        <tr>
                                                            <th class="text-left">Ordered Items</th>
                                                            <th class="text-center">Qty</th>
                                                            <th class="">Return Qty</th>
                                                            <th class="text-right">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $subTotal = 0;
                                                            $totalProductPrice = 0;
                                                            $orderUserType = 0;
                                                            $shippingArea = 0;
                                                            $shippingCharge = 0;
                                                            $shippingPrice = 0;
                                                        @endphp
                                                        @foreach ($order->orderDetails as $order_detail)
                                                            @if ($order_detail->quantity > 0)
                                                            <tr class="font-weight-boldest">
                                                                <td class="border-0 pl-0 pt-7 d-flex align-items-center">
                                                                    <input type="hidden" name="product_id[]" value="{{$order_detail->product_id}}">
                                                                    <input type="hidden" name="varient_id[]" value="{{$order_detail->varient_id}}">
                                                                    <input type="hidden" name="order_details_id[]" value="{{$order_detail->id}}">
                                                                    <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
                                                                        <div class="symbol-label" style="background-image: url('{{asset('storage/product')}}/{{$order_detail->productInfo->image ?? ""}}')"></div>
                                                                    </div>
                                                                    {{$order_detail->productInfo->name ?? ''}}
                                                                </td>
                                                                <td class="text-right pt-7 align-middle">
                                                                    {{$order_detail->quantity}}
                                                                </td>

                                                                <td class="text-right pt-7 align-middle">
                                                                    <input autocomplete="off" type="number" class="form-control" name="qty[{{$order_detail->id}}]" placeholder="Return Qty" max="{{$order_detail->quantity}}">
                                                                </td>
                                                                <td class="text-right pt-7 align-middle">
                                                                    {{$order_detail->price}}
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $totalProductPrice += $subTotal;
                                                            @endphp
                                                            @endif

                                                        @endforeach

                                                        <tr>
                                                            @php
                                                                $shippingArea = $order->shipping_area ? $order->shipping_area : 0;
                                                            @endphp


                                                            <th class="text-right" colspan="3">Shipping Charge</th>
                                                            <th class="text-right">
                                                                {{$global_setting->currency ?? ""}} <span>
                                                                    {{$order->shipping_cost}}
                                                                </span>
                                                            </th>

                                                            @php
                                                                $shippingPrice = $totalProductPrice + $shippingCharge;
                                                            @endphp
                                                        </tr>


                                                        <tr style="border-top: 1px solid #000;">
                                                            <th class="text-right" colspan="3">Total</th>
                                                            <th class="text-right">{{$global_setting->currency ?? ""}} {{$order->grand_total_price}}</th>
                                                        </tr>

                                                        <tr style="border-top: 1px solid #000;">
                                                            <th class="text-right" colspan="3">Return Remarks <span class="text-danger">*</span> </th>
                                                            <th class="text-right">
                                                                <textarea required name="remark" class="form-control" placeholder="Your Remarks"></textarea>
                                                            </th>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <div class="w-100 float-right">
                                                    <button type="submit" name="whole_return" value="1" class="btn btn-danger">Whole Return Order</button>
                                                    <button type="submit" class="btn btn-primary">Return Order</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div> --}}
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
