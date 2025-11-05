<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice-{{ $order->tracking_code ?? ''}}</title>
    <style>
        .card-header {
            background: transparent !important;
        }
        .table {
            width: 100%;
            text-align: left;
        }
        .text-right{
            text-align: right !important;
        }
        .text-left{
            text-align: left !important;
        }
    </style>
</head>
<body>
    <div id="printInvoice">

        <!--begin::Invoice header section-->
        <div class="container">
            <div class="card card-custom border-0">
                <div class="card-body p-0">
                    <div class="row justify-content-center py-8 px-2 px-md-0">

                        <div class="col-md-2">
                            <img loading="lazy" class="" height="auto" width="150px" src="{{ asset('storage/setting') }}/{{ $global_setting->logo ?? '' }}" alt="">
                        </div>

                        <div class="col-md-7"></div>

                        <div class="col-md-3">
                            <span class="d-block"> {{ $global_setting->title ?? '' }} </span>
                            <span class="pt-2 d-block" > {{ $order->address ?? ''}} </span>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!--begin::Order details, User details-->
        <div class="container mb-5">
            <div class="row">
                <table class="table">
                    <tr>
                        <td>
                            <span class="font-weight-bold"><b>Invoice Number:</b> {{ $order->invoice_no = sprintf('%08d', $order->invoice_no) }}</span> <br>
                            <span class="font-weight-bold"><b>Invoice Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br> <br>

                            <span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
                            <span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
                            <span class="font-weight-bold"><b>Status:</b>
                                @if ($order->stage == 0)
                                    Pending
                                @elseif($order->stage == 1)
                                    Order Accepted
                                @elseif($order->stage == 2)
                                    Order Declined
                                @elseif($order->stage == 3)
                                    On Delivery
                                @elseif($order->stage == 4)
                                    Order Complete
                                @elseif($order->stage == 5)
                                    Order Canceled
                                @else
                                    Unknown Status
                                @endif
                            </span> <br>
                            @if (($order->status == 4) || ($order->stage == 5))
                                <span class="font-weight-bold"><b>Order Cancel Reason:</b> {{$order->remark}}</span>
                            @endif
                        </td>
                        <td class="text-right">
                            {{-- @if (isset($order->orderUserInfo) && ($order->orderUserInfo->type == 0))
                        <span class="d-block"><b>User Type :</b> System User</span>
                    @elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 1))
                        <span class="d-block"><b>User Type :</b> Customer</span>
                    @elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 2))
                        <span class="d-block"><b>User Type :</b> Corporate Consumer</span>
                    @elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 3))
                        <span class="d-block"><b>User Type :</b> Dealer</span>
                    @endif --}}

                    <span class="d-block"><b>User Name :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->first_name : ''}} {{ $order->orderUserInfo ? $order->orderUserInfo->last_name : ''}} </span>
    <br>
                    <span class="d-block"><b>Email :</b> {{ $order->email ?? 'N/A'}} </span>
    <br>
                    <span class="d-block"><b>Cell No. :</b> {{ $order->phone ?? 'N/A'}} </span>
    <br>
                    <span class="d-block"><b>Delivery Address :</b> {{ $order->shipping_address ?? 'N/A' }} </span>
    <br>
                    @if ($order->delivery_date)
                        <span class="d-block"><b>Delivery Date :</b> {{ date('d-M-Y', strtotime($order->delivery_date)) ?? 'Not Set Yet!' }} </span>
                    @endif
                        </td>
                    </tr>
                </table>

            </div>
        </div>

        <br> <br>

        <!--begin::Order details product list, all cost-->
        <div class="container top-0 left-0 right-0">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card-header p-0">
                        <h3 class="card-title mb-3 font-weight-bold">Order Items</h3>
                    </div>
                    <div class="table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="font-weight-bold text-muted text-uppercase text-left" >Item Name</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase" >Factory Price</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase" >SD</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase" >VAT</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase" >Quantity (pcs)</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase" >Weight</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase" >Amount</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $subTotal = 0;
                                    $totalProductPrice = 0;
                                @endphp

                                @foreach ($order->orderDetails as $order_detail)
                                    <tr class="font-weight-boldest">
                                        <td class="pt-7 d-flex align-items-center">

                                            {{ $order_detail->productInfo->name ?? '' }}
                                        </td>

                                        <td class="text-right pt-7 align-middle">
                                             {{ number_format($order_detail->f_price, 2, ".", "") }}
                                        </td>
                                        <td class="text-right pt-7 align-middle">
                                             {{ number_format($order_detail->sd_total, 2, ".", "") }}
                                        </td>
                                        <td class="text-right pt-7 align-middle">
                                             {{ number_format($order_detail->vat_total, 2, ".", "") }}
                                        </td>
                                        <td class="text-right pt-7 align-middle">
                                            {{ number_format($order_detail->quantity) }}
                                        </td>
                                        <td class="text-right pt-7 align-middle">
                                            @if ($order_detail->weight and $order_detail->unit)
                                                @if ($order_detail->unit == 1)
                                                    {{number_format((($order_detail->quantity * $order_detail->weight)),2,'.','')}} KG
                                                @elseif ($order_detail->unit == 2)
                                                    {{number_format(($order_detail->quantity * $order_detail->weight),2,'.','')}} M.T
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-primary pt-7 text-right align-middle">
                                             {{ number_format($subTotal = $order_detail->price * $order_detail->quantity, 2, ".", "" )}}
                                        </td>
                                    </tr>

                                    @php
                                        $totalProductPrice += $subTotal;
                                    @endphp
                                @endforeach

                                <!--Show sub-total/total product price-->
                                <tr>
                                    <th class="text-right" colspan="6">Subtotal</th>
                                    <th class="text-right"> {{ number_format($totalProductPrice, 2, ".", "") }}</th>
                                </tr>

                                <!--Show user type discount-->
                                <tr>
                                    @php
                                        $userType = $order->user ? $order->user->type : 100;
                                    @endphp

                                    <th class="text-right" colspan="6">After Deducting TDs ({{ $order->tds }}%) on Commission ({{$order->user_type_discount ?? 0}} %)</th>
                                    <th class="text-right"> {{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
                                </tr>

                                <!--Show order amount (1.5 lakh) commission-->
                                @if ($order->discount_on_amount == 2)
                                    <tr>
                                        <th class="text-right" colspan="5">Order Commission ({{$order->discount_percent_in_total ?? 0}} %)</th>
                                        <th class="text-right"> {{ number_format($order->discount_amount_in_total ?? 0, 2, '.', '') }}</th>
                                    </tr>
                                @endif

                                <!--Show packing charge-->
                                <tr>
                                    <th class="text-right" colspan="6">Packing Charge ({{$order->packType ? $order->packType->name : 'N/A'}})</th>
                                    <th class="text-right"> {{ number_format($order->packing_amount ?? 0, 2, '.', '') }}</th>
                                </tr>

                                @if ($order->other_categories_amount > 0)
                                <tr>
                                    <th class="text-right" colspan="6">Other Charge</th>

                                    <th class="text-right"> {{ number_format($order->other_categories_amount ?? 0, 2, '.', '') }}</th>
                                </tr>
                                @endif

                                <!--Show transportation charge-->
                                <tr>

                                    <th class="text-right" colspan="6">After Imposing VDS ({{ $order->vds }}%) on Carrying Cost</th>

                                    <th class="text-right"> {{ number_format($order->courier_cost ?? 0, 2, '.', '') }}</th>
                                </tr>

                                <!--Show total price-->
                                <tr>
                                    <th class="text-right" colspan="6">Total</th>
                                    <th class="text-right"> {{ number_format($order->grand_total_price?? 0, 2, ".", "") }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-12 mt-8">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Notice</h4>

                        <hr>

                        <p>No refund is applicable after payment accepted!</p>
                      </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
