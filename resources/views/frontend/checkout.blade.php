@extends('frontend.layout.master_alt')

@push('css')
    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

    <style>
        .conditional_area {
            margin-left: 20px;
        }
        .address-option {
            border-radius: 8px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: border-color 0.3s, background-color 0.3s;
        }

        .address-option:hover {
            border-color: #f74953;
            background-color: #f8f9fa;
        }

        .address-option input[type="radio"] {
            display: none;
        }

        .address-option input[type="radio"]:checked + .address-content {
            border: 2px solid #9bbfe6;
            background-color: #e9f5ff;
            box-shadow: 0 0 3px 1px #9bbfe6;
        }

        .address-content {
            border-radius: 6px;
            padding: 15px;
            background: #dddddd2e;
            border: 1px solid #cacaca;
        }

        .address-category {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.85rem;
            color: #6c757d;
        }

        .voucher_section_area {
            display: none;
        }
    </style>
@endpush

@section('content')
    @php
        $product_total_price = 0;
        $discount_amount = 0;
    @endphp
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="checkout-page">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('index') }}">Home</a></li>

                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="container">
            <div class="mb-5">
                <h1 class="text-center">Checkout</h1>
            </div>

            <form action="{{ route('checkout_complete') }}" id="complete_checkout"  method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-5 order-lg-2 mb-7 mb-lg-0">
                        <div class="pl-lg-3 ">
                            <div class="bg-gray-1 rounded-lg">
                                <!-- Order Summary -->
                                <div class="p-4 mb-4 checkout-table">
                                    <!-- Title -->
                                    <div class="border-bottom border-color-1 mb-5">
                                        <h3 class="section-title mb-0 pb-2 font-size-25">Your order</h3>
                                    </div>
                                    <!-- End Title -->

                                    <div class="input-group mb-3">
                                        <input autocomplete="off" type="text" class="form-control discount_code" placeholder="Discount code" aria-label="Apply Discount Code" aria-describedby="button-discount-code-addon" name="discount_code">
                                        <div class="input-group-append">
                                            <span class="btn btn-success" style="cursor: pointer;" onclick="applyVoucherDiscount(this)">Apply</span>
                                        </div>
                                    </div>

                                    <!-- Product Content -->
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carts as $cart)
                                                <tr class="cart_item">
                                                    <td>
                                                        {{$cart->productInfo->name ?? ''}}<strong class="product-quantity">× {{$cart->quantity}}</strong>
                                                    </td>
                                                    <td style="min-width: 100px;">
                                                        {{$global_setting->currency ?? ""}}   @if ($cart->variation_id == 0)
                                                                @php
                                                                    $product_total_price +=  ($cart->productInfo->discount_price ?? 0)  * $cart->quantity;
                                                                @endphp
                                                                {{number_format((($cart->productInfo->discount_price ?? 0)  * $cart->quantity),0,".","")}}

                                                            @else
                                                                @php
                                                                    $product_total_price +=  ($cart->varientInfo->discount_price ?? 0)  * $cart->quantity;
                                                                @endphp
                                                                {{number_format((($cart->varientInfo->discount_price ?? 0) * $cart->quantity),0,".","")}}

                                                            @endif

                                                    </td>
                                                </tr>
                                                <input type="hidden" name="cart_id[]" value="{{Crypt::encryptString($cart->id)}}">
                                            @endforeach

                                        </tbody>
                                        <tfoot class="mt-3">
                                            <tr>
                                                <th>Sub-total</th>
                                                <td>
                                                    {{$global_setting->currency ?? ""}} {{number_format($product_total_price,0,".","")}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Shipping Cost</th>
                                                <td>
                                                    {{$global_setting->currency ?? ""}}
                                                    @if (count($shipping_addresses) == 1)
                                                        @php
                                                            $first_shipping = $shipping_addresses->first();
                                                        @endphp
                                                        <span class="shipping_cost" >{{round($first_shipping->divisionInfo->shipping_cost ?? 0)}}</span>
                                                    @else
                                                    <span class="shipping_cost" >0</span>
                                                    @endif

                                                </td>
                                            </tr>
                                            <tr class="voucher_section_area">
                                                <th>Voucher Discount</th>
                                                <td>
                                                    {{$global_setting->currency ?? ""}} <span class="voucher_discount_amount">0</span>
                                                </td>
                                            </tr>



                                            <tr>
                                                <th>Total</th>
                                                <td>


                                                    {{$global_setting->currency ?? ""}} <span class="in_total" >0</span>
                                                </td>
                                            </tr>

                                        </tfoot>
                                    </table>
                                    <!-- End Product Content -->
                                    <div class="border-top border-width-3 border-color-1 pt-3 mb-3">
                                        <!-- Basics Accordion -->
                                        <small>
                                            Delivery Option <span class="text-danger">*</span>
                                        </small>
                                        <div id="basicsAccordion1">
                                            <!-- Manual payment Card -->
                                            {{-- <div class="border-bottom border-color-1 border-dotted-bottom">
                                                <div class="p-3" id="basicsHeadingOne">
                                                    <div class="custom-control custom-radio">
                                                        <input type="checkbox" class="custom-control-input" id="stylishRadio1" name="delivery_option" value="1" autocomplete="off">

                                                        <label class="custom-control-label form-label" for="stylishRadio1" data-toggle="collapse" data-target="#basicsCollapseOnee" aria-expanded="true" aria-controls="basicsCollapseOnee">
                                                            Cash On Delivery
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border-bottom border-color-1 border-dotted-bottom">
                                                <div class="p-3" id="basicsHeadingTwo">
                                                    <div class="custom-control custom-radio">
                                                        <input type="checkbox" class="custom-control-input" id="stylishRadioSSL" name="delivery_option" value="2" autocomplete="off">

                                                        <label class="custom-control-label form-label" for="stylishRadioSSL" data-toggle="collapse" data-target="#basicsCollapseSLL" aria-expanded="true" aria-controls="basicsCollapseSLL">
                                                            Pay With SSLCOMMEZ
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="border-bottom border-color-1 border-dotted-bottom">
                                                <div class="p-3" id="basicsHeadingOne">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="stylishRadio1" name="delivery_option" value="1" autocomplete="off">
                                                        <label class="custom-control-label form-label" for="stylishRadio1" data-toggle="collapse" data-target="#basicsCollapseOnee" aria-expanded="true" aria-controls="basicsCollapseOnee">
                                                            Cash On Delivery
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="border-bottom border-color-1 border-dotted-bottom">
                                                <div class="p-3" id="basicsHeadingTwo">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="custom-control-input" id="stylishRadioSSL" name="delivery_option" value="2" autocomplete="off">
                                                        <label class="custom-control-label form-label" for="stylishRadioSSL" data-toggle="collapse" data-target="#basicsCollapseSLL" aria-expanded="true" aria-controls="basicsCollapseSLL">
                                                            Pay With SSLCOMMERZ
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Card -->



                                        </div>
                                        <!-- End Basics Accordion -->
                                    </div>

                                    <div class="form-group d-flex align-items-center justify-content-between px-3 mb-5">
                                        <span style="margin-top: -12%; padding-right: 3px;" class="text-danger">*</span>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck10" required
                                                data-msg="Please agree terms and conditions."
                                                data-error-class="u-has-error"
                                                data-success-class="u-has-success">
                                            <label class="form-check-label font-weight-bold" for="defaultCheck10">
                                                I have read and agreed to the website <a href="https://snehodigital.com/page-info/terms-and-conditions" class="text-blue">terms and conditions</a>, <a href="https://snehodigital.com/page-info/return-refund-policy" class="text-blue">refund-return policy </a> and <a href="https://snehodigital.com/page-info/privacy-policy" class="text-blue">privacy policy </a>
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary-dark-w btn-block btn-pill font-size-20 mb-3 py-3 text-white">Place order</button>
                                </div>
                                <!-- End Order Summary -->
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 order-lg-1">
                        <div class="pb-7 mb-7">
                            <!-- Title -->
                            <div class="border-bottom border-color-1 mb-3">
                                <h3 class="section-title mb-0 pb-2 font-size-25">Account Info</h3>
                            </div>
                            <div class="w-100">
                                <p class="m-0">Name: {{auth()->user()->first_name}} {{auth()->user()->last_name}}</p>
                                <p class="m-0">Email address: {{auth()->user()->email}}</p>
                                <p class="m-0">Phone: {{auth()->user()->mobile}}</p>
                            </div>
                            <div class="border-bottom border-color-1 mb-3 mt-3">
                                <h3 class="section-title mb-0 pb-2 font-size-25">Choosing Shipping Address</h3>
                            </div>

                            <div class="w-100">
                                <div class="row">
                                    @if (count($shipping_addresses) == 0)
                                        <div class="col-12">

                                            <p class="text-danger">No shipping address found. Please add a shipping address first. <a href="{{ route('shipping_address.create') }}@if(isset($_GET['cart_id']))?cart_id={{$_GET['cart_id']}} @endif">Add</a></p>
                                        </div>
                                    </div>

                                    @endif
                                    @foreach ($shipping_addresses as $address)
                                        <div class=col-md-6>
                                            <label class="address-option d-block">
                                                <input data-shippingcost="{{$address->divisionInfo->shipping_cost ?? 0}}" type="radio" name="shipping_address" value="{{$address->id}}" autocomplete="off" @if($address->default_shipping == 1) checked @endif>
                                                <div class="address-content">
                                                    <div class="address-category">{{$address->address_type}}</div>
                                                    <div><strong>{{ $address->recipient_name }}</strong></div>
                                                    <div>📞 {{ $address->phone_no }}</div>
                                                    <div>{{ $address->divisionInfo->name ?? ''}}, {{ $address->districtInfo->name ?? ''}}, {{ $address->upazilaInfo->name ?? ''}}</div>
                                                    <div>{{ $address->address }}</div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <p>Delivery Time: Inside Dhaka - 5 days & Outside Dhaka - 10 days</p>

                            </div>

                            <!-- End Billing Form -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

@push('script')
    <!-- JavaScript -->
    {{-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> --}}

    <script>

        $(document).ready(function(){

            window.updateTotal = function() {
                var product_total = {{$product_total_price}};
                let voucher_discount = $('.voucher_discount_amount').text();
                var shipping_cost = $('.shipping_cost').text();
                var in_total = (parseFloat(product_total) + parseFloat(shipping_cost)) - Number(voucher_discount);
                $('.in_total').text(in_total.toFixed(0));
            }

            // function updateTotal(){
            //     var product_total = {{$product_total_price}};
            //     let voucher_discount = $('.voucher_discount_amount').text();
            //     var shipping_cost = $('.shipping_cost').text();
            //     var in_total = (parseFloat(product_total) + parseFloat(shipping_cost)) - Number(voucher_discount);
            //     $('.in_total').text(in_total.toFixed(0));
            // }
            updateTotal();

            $('input[name="shipping_address"]').on('change', function(){
                var shipping_cost = $(this).data('shippingcost');
                $('.shipping_cost').text(parseFloat(shipping_cost).toFixed(0));
                updateTotal();
            });



            $("#complete_checkout").on("submit", function (e) {
                e.preventDefault(); // stop immediate submission
                let shipping_address_checked = $('input[name="shipping_address"]:checked').length;
                if(shipping_address_checked == 0){
                    alertify.error('Please select a shipping address.');
                    return;
                }


                let delivery_option = $('input[name="delivery_option"]:checked').length;
                if(delivery_option == 0){
                    alertify.error('Delivery option is required');
                    return;
                }
                // let name = $("#name").val().trim();
                // let email = $("#email").val().trim();

                // if (name === "" || email === "") {
                // alert("All fields are required.");
                // return; // don’t submit
                // }

                // // Example: validate email format
                // let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                // if (!emailPattern.test(email)) {
                // alert("Please enter a valid email.");
                // return;
                // }

                this.submit();
            });
        });

        function applyVoucherDiscount(that){
                var discount_code = $('.discount_code').val();
                if(discount_code == ''){
                    alertify.error('Please enter a discount code');
                    return;
                }
                const customFormData = new FormData();
                customFormData.append('discount_code', $('.discount_code').val());
                customFormData.append('_token', $("input[name='_token']").val());
                let cart_ids = [];
                $('input[name^="cart_id"]').each(function() {
                    cart_ids.push($(this).val()); // Get the value of each input
                    console.log($(this).val());
                });
                customFormData.append('cart_id', cart_ids);

                $.ajax({
                    url: "{{ route('apply_discount_orrder') }}",
                    data: customFormData,
                    processData: false,
                    contentType: false,
                    method: 'POST',
                    success: function(response){
                        $('.voucher_section_area').css('display','revert');
                        if (response.success) {
                            $('.voucher_discount_amount').text(response.discount);
                            // $('.in_total').text(response.new_total);
                        }
                        updateTotal();
                    },
                    error: function() {
                        $('.voucher_section_area').css('display','none');
                        $('.voucher_discount_amount').text('0');
                        updateTotal();
                        alertify.error('Failed to apply discount. Please try again.');
                    }
                });
            }
    </script>
@endpush
