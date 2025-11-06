@extends('frontend.layout.master_alt')

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

                @include('frontend.layout.accountMenu')

                <div class="tab-content mb-6" style="padding: 1rem;">

                    <div class="tab-pane mb-4 active in" id="account-orders">
                        <div class="icon-box icon-box-side icon-box-light">
                            <span class="icon-box-icon icon-orders">
                                <i class="w-icon-orders"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title text-capitalize ls-normal mb-0" style="font-weight: 600;">Order Details</h4>
                            </div>
                        </div>

                        @include('alerts.alerts')

                        <table class="address-table table table-borderless">
                            <tbody>
                                <tr>
                                    <th class="w-25">Order ID:</th>
                                    <td class="w-25">{{ $order->tracking_code ?? '' }}</td>
                                    <th colspan="6"></th>

                                </tr>
                                <tr>
                                    <th class="w-25">Order Date:</th>
                                    <td class="w-25">{{ date('d M Y', strtotime($order->created_at)) }}</td>
                                    <th colspan="6"></th>

                                </tr>
                                <tr>
                                    {{-- <th class="w-25">Shipping Address:</th> --}}
                                    <th class="w-25">Delivery Address:</th>
                                    <td class="w-25">{{ $order->shipping_address ?? '' }}</td>
                                    <th colspan="6"></th>

                                </tr>
                                <tr class="order-status">
                                    <th class="w-25">Order Status</th>
                                    <th class="w-25">
                                        @if ($order->stage == 0)
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($order->stage == 1)
                                            <span class="badge badge-primary">Order Accepted</span>
                                        @elseif($order->stage == 2)
                                            <span class="badge badge-danger">Order Declined</span>
                                        @elseif($order->stage == 3)
                                            <span class="badge badge-primary">On Delivery</span>
                                        @elseif($order->stage == 4)
                                            <span class="badge badge-success">Order Complete</span>
                                        @elseif($order->stage == 5)
                                            <span class="badge badge-danger">Order Canceled</span>
                                        @else
                                            <span class="badge badge-danger">Unknown Status</span>
                                        @endif
                                    </th>
                                    <th colspan="6"></th>

                                </tr>
                            </tbody>
                        </table>

                        <h4 class="icon-box-title text-capitalize ls-normal mb-0" style="font-weight: 600;">Product List</h4>
                        <form action="{{route('orderExchangePost',$order->id)}}" id="order_exchange" method="post">

                            <table class="shop-table account-orders-table mb-6 table table-area" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="order-id">Product</th>
                                        <th class="order-id">Variant</th>
                                        <th class="order-status">Quantity</th>
                                        <th class="order-date text-right">Price</th>
                                        <th class="order-status text-right">Total Price</th>
                                        <th class="order-status d-none">
                                            <span style="cursor: pointer;" class="btn btn-info font-weight-bolder font-size-sm mr-3 add_more">+</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subTotal = 0;
                                        $totalProductPrice = 0;
                                    @endphp
                                    @foreach ($order->orderDetails as $order_detail)

                                        @if ($order_detail->quantity > 0)
                                            <tr>
                                                <td class="order-id">
                                                    <select onchange="get_varient_data(this)" name="product_id" class="form-control select2 product_id" autocomplete="off">
                                                        <option value="">Select</option>
                                                        @foreach ($products as $product)
                                                            <option data-has_varient="{{$product->has_varient}}" data-product_price="{{$product->discount_price}}" @if ($product->id == $order_detail->product_id)
                                                                selected
                                                            @endif value="{{$product->id}}">{{$product->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="varient-data">
                                                    <select onchange="calculate_varient_data(this)" name="varient_id" class="form-control varient_id" autocomplete="off">
                                                        <option value="">Select</option>
                                                        @if ($order_detail->varient_id > 0)
                                                            @foreach ($order_detail->product_varient as $varient)
                                                                <option @if ($varient->id == $order_detail->varient_id)
                                                                    selected
                                                                @endif data-product_price="{{$varient->discount_price}}" data-quantity="{{$varient->productStock->quantity ?? 0}}" value="{{$varient->id}}">
                                                                    @foreach ($varient->productVarientData as $VarientData)
                                                                        {{$VarientData->data_value}} @if (!$loop->last)
                                                                            and
                                                                        @endif
                                                                    @endforeach
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>

                                                <td class="order-date">
                                                    <input onchange="calculate_quantity_data(this)" type="number" placeholder="Enter Quantity" class="form-control product_quantiy" name="quantiy[]" value="{{ number_format($order_detail->quantity) }}" autocomplete="off">
                                                </td>
                                                <td class="order-date text-right">
                                                    {{$global_setting->currency ?? ""}} <span class="single_product_price">
                                                        {{number_format($order_detail->price, 2,'.','')}}
                                                    </span>
                                                </td>
                                                <td class="order-date text-right">
                                                    {{$global_setting->currency ?? ""}} <span class="product_total_price">
                                                        {{number_format($subTotal += $order_detail->price * $order_detail->quantity, 2,'.','')}}
                                                    </span>
                                                </td>

                                                <td class="d-none">
                                                    <span onclick="remove_tr(this)" style="cursor: pointer;" class="btn btn-danger font-weight-bolder font-size-sm mr-3 remove_more">-</span>
                                                </td>
                                            </tr>
                                            @php
                                                $totalProductPrice += $subTotal;
                                            @endphp
                                        @endif

                                    @endforeach

                                    <!--Show sub-total/total product price-->
                                    {{-- <tr>
                                        <th class="order-date"></th>
                                        <th class="order-date"></th>
                                        <th class="order-date">Subtotal</th>
                                        <th class="order-date">{{$global_setting->currency ?? ""}} {{number_format($totalProductPrice,2,'.','')}}</th>
                                    </tr> --}}

                                    <!--Show user type discount-->
                                    {{-- <tr>
                                        @php
                                            $userType = $order->user ? $order->user->type : 100;
                                        @endphp
                                        @if (($userType == 2) || ($userType == 3))
                                            <th class="order-date"></th>
                                            <th class="order-date"></th>
                                            <th class="order-date">Discount ({{$order->user_type_discount ?? 0}} %)</th>
                                            <th class="order-date">{{$global_setting->currency ?? ""}} {{number_format($order->discount_amount ?? 0, 2,'.','')}}</th>
                                        @else
                                            <th class="order-date"></th>
                                            <th class="order-date"></th>
                                            <th class="order-date">Discount ({{$order->user_type_discount ?? 0}} %)</th>
                                            <th class="order-date">{{$global_setting->currency ?? ""}} {{number_format($order->discount_amount ?? 0, 2,'.','')}}</th>
                                        @endif
                                    </tr> --}}

                                    <!--Show order amount (1.5 lakh) commission-->
                                    {{-- @if ($order->discount_on_amount == 2)
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th class="order-date">Order Commission ({{$order->discount_percent_in_total ?? 0}} %)</th>
                                            <th class="order-date">{{$global_setting->currency ?? ""}} {{number_format($order->discount_amount_in_total ?? 0, 2,'.','')}}</th>
                                        </tr>
                                    @endif --}}

                                    <!--Show packing charge-->
                                    {{-- <tr>
                                        <th></th>
                                        <th></th>
                                        <th class="order-date">Packing Charge ({{$order->packType ? $order->packType->name : 'N/A'}})</th>
                                        <th class="order-date">{{$global_setting->currency ?? ""}} {{number_format($order->packing_amount ?? 0, 2,'.','')}}</th>
                                    </tr> --}}

                                    <!--Show transportation charge-->
                                    {{-- <tr>
                                        <th></th>
                                        <th></th>
                                        <th class="order-date">Transportation Charge</th>
                                        <th class="order-date">{{$global_setting->currency ?? ""}} {{number_format($order->courier_cost ?? 0, 2,'.','')}}</th>
                                    </tr> --}}

                                    <!--Show total price-->
                                    {{-- <tr style="border-top: 1px solid #000;">
                                        <th></th>
                                        <th></th>
                                        <th class="order-date">Total</th>
                                        <th class="order-date">{{$global_setting->currency ?? ""}} {{$order->grand_total_price ?? 0}}</th>
                                    </tr> --}}
                                </tbody>
                            </table>
                            <div class="row">

                                <div class="col-12 text-right">
                                    <input type="hidden" class="total_price" value="{{number_format($totalProductPrice,2,'.','')}}">
                                    <p>Sub Total: <span class="sub_total">{{number_format($totalProductPrice,2,'.','')}}</span></p>
                                </div>
                                <div class="col-12 text-right">
                                    <input type="hidden" class="grand_total_price" value="{{$order->grand_total_price ?? 0}}">
                                    <p>Grand Total: <span class="grand_total">{{number_format($order->grand_total_price,2,'.','')}}</span></p>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">Make exchange Request</button>
                        </form>

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

        function remove_tr(that) {
            $(that).closest('tr').remove();
        }

        $('.add_more').click(function() {
            var clone = $(".table-area tbody tr:first-child").clone();
            $(".table-area tbody").append(clone);
            $(".table-area tbody tr:last-child td").find('input').val('');
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endpush

@push('css')
	<style>
		.table-area tbody tr:first-child .remove_more {
			display: none;
		}

        .select2-container--default .select2-selection--single {
            border: 1px solid #aaaaaa6b !important;
        }
        .form-control {
            border-radius: 4px !important;
        }

        .select2-container .select2-selection--single {
            height: 45px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 43px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
	</style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <script>
        function get_varient_data(that) {

            var product_id = $(that).find(":selected").val();

            let url= "{{route('get_product_varients')}}?product_id="+product_id;

            if (product_id ) {
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function (result) {
                        $(that).closest('tr').find('.varient-data select').empty();
                        $(that).closest('tr').find('.varient-data select').append(result);

                    },
                });
            } else {
                $(that).closest('tr').find('.varient-data select').empty();
                $(that).closest('tr').find('.varient-data select').append("<option value=''>Select</option>");
            }

            var selected_product_length = $(that).closest('tr').find(".product_id>option:not([value='']):selected").length;
            var product_price = 0;
            var varient_price = 0;
            var quantity_value = $(that).closest('tr').find('.product_quantiy').val();

            if (!quantity_value) {
                quantity_value = 0;
            }

            if (selected_product_length > 0) {
                var varient_length = $(that).closest('tr').find(".varient_id>option:not([value=''])").length;

                product_price = $(that).closest("tr").find(".product_id>option:not([value='']):selected").attr("data-product_price");
                //if (varient_length > 0) { means has varient
                if (varient_length > 0) {



                    if (!product_price) {
                        product_price = 0;
                    }

                    $(that).closest('tr').find('.single_product_price').text(Number(product_price).toFixed(2));
                    var this_row_total_price = Number(quantity_value) * Number(product_price);
                    $(that).closest('tr').find('.product_total_price').text(Number(this_row_total_price).toFixed(2));
                } else {
                    $(that).closest('tr').find('.single_product_price').text(Number(product_price).toFixed(2));
                    $(that).closest('tr').find('.product_total_price').text(Number(0).toFixed(2));
                }



            } else {
                $(that).closest('tr').find('.single_product_price').text('0.00');
                $(that).closest('tr').find('.product_total_price').text('0.00');
            }

            calculate_total_order();

        }

        function calculate_varient_data(that) {


            var product_price = 0;
            var varient_price = 0;
            var quantity_value = $(that).closest('tr').find('.product_quantiy').val();

            if (!quantity_value) {
                quantity_value = 0;
            }


                var varient_length = $(that).closest('tr').find(".varient_id>option:not([value=''])").length;


                //if (varient_length > 0) { means has varient
                if (varient_length > 0) {

                    varient_price = $(that).closest("tr").find(".varient_id>option:not([value='']):selected").attr("data-price");


                    if (!varient_price) {
                        varient_price = 0;
                    }

                    $(that).closest('tr').find('.single_product_price').text(Number(varient_price).toFixed(2));
                    var this_row_total_price = Number(quantity_value) * Number(varient_price);
                    $(that).closest('tr').find('.product_total_price').text(Number(this_row_total_price).toFixed(2));

                }


        }

        function calculate_quantity_data(that) {


            var product_price = 0;
            var varient_price = 0;
            var quantity_value = $(that).closest('tr').find('.product_quantiy').val();

            if (!quantity_value) {
                quantity_value = 0;
            }


                var varient_length = $(that).closest('tr').find(".varient_id>option:not([value=''])").length;
                var product_length = $(that).closest('tr').find(".product_id>option:not([value=''])").length;


                //if (varient_length > 0) { means has varient
                if (varient_length > 0) {

                    varient_price = $(that).closest("tr").find(".varient_id>option:not([value='']):selected").attr("data-price");


                    if (!varient_price) {
                        varient_price = 0;
                    }

                    $(that).closest('tr').find('.single_product_price').text(Number(varient_price).toFixed(2));
                    var this_row_total_price = Number(quantity_value) * Number(varient_price);
                    $(that).closest('tr').find('.product_total_price').text(Number(this_row_total_price).toFixed(2));

                } else {

                    if (product_length > 0) {
                        product_price = $(that).closest("tr").find(".product_id>option:not([value='']):selected").attr("data-product_price");

                        $(that).closest('tr').find('.single_product_price').text(Number(product_price).toFixed(2));
                        var this_row_total_price = Number(quantity_value) * Number(product_price);
                        $(that).closest('tr').find('.product_total_price').text(Number(this_row_total_price).toFixed(2));

                    } else {
                        $(that).closest('tr').find('.single_product_price').text(Number(0).toFixed(2));
                        $(that).closest('tr').find('.product_total_price').text(Number(0).toFixed(2));
                    }

                }


        }

        function calculate_total_order(){
            var sub_total = 0;
            var grand_total = 0;
            // alert();
            $('#order_exchange table > tbody > tr').each(function(index) {
                // console.log(index);
                var product_length = $(this).closest('tr').find(".product_id>option:not([value=''])").length;
                var has_varient = 0;
                var product_price = 0;
                var varient_length = $(this).closest('tr').find(".varient_id>option:not([value=''])").length;
console.log(varient_length);
                if (varient_length > 0) {
                    product_price = $(this).closest('tr').find(".varient_id>option:not([value=''])").attr('data-price');
                } else {
                    product_price = $(this).closest('tr').find(".product_id>option:not([value=''])").attr('data-product_price');
                }

                if (!product_price) {
                    product_price = 0;
                }

                var product_quantiy = $(this).closest('tr').find(".product_quantiy").val();
                if (!product_quantiy) {
                    product_quantiy = 0;
                }

                // console.log(Number(product_quantiy));
                // console.log(Number(product_price));

                sub_total += Number(product_quantiy) * Number(product_price);
                grand_total += Number(product_quantiy) * Number(product_price);

            });

            $(".sub_total").text(Number(sub_total).toFixed(2));
            $(".grand_total").text(Number(grand_total).toFixed(2));


        }

        // $('#order_exchange').on('submit',function(e){

        // });
    </script>

@endpush
