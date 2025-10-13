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
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('index')}}">Home</a></li>
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Cart</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="container">
            <div class="ajax_cart_section">
            </div>
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

@push('script')
<!-- JavaScript -->
{{-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>

<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/> --}}

{{-- data-cart_id --}}
<script>
    $(".remove-cart-alt").click(function () {
        if (confirm('Are you sure to remove this item from your cart')) {
            var cart_id = $(this).attr('data-cart_id');
            var url = "{{route('remove_cart_item')}}?id="+cart_id;
            window.location.replace(url);
        }
    });

    function js_minus_action(that){
        var quantity = $(that).closest(".js-quantity").find('.js-result').val();

        if (quantity > 1 ) {
            $(that).closest(".js-quantity").find('.js-result').val(Number(quantity) - 1);
        } else if (quantity == 1) {
            alertify.error("Quantity can't be bellow 1");
        }
    }

    function js_plus_action(that){

        // console.log(data);
        // stock_quantity
        var quantity = $(that).closest(".js-quantity").find('.js-result').val();
        var in_stock = $(that).closest(".js-quantity").find('.js-plus-action').attr('data-stock_quantity');

        if (Number(quantity) >= Number(in_stock) ) {
            alertify.error("Stock exit");

        } else {
            $(that).closest(".js-quantity").find('.js-result').val(Number(quantity) + 1);
        }
    }

    function quantity_change(that) {
        var quantity = $(that).closest(".js-quantity").find('.js-result').val();
        var in_stock = $(that).closest(".js-quantity").find('.js-result').attr('data-stock_quantity');
        var actual_quantity = $(that).closest(".js-quantity").find('.actual_quantity').val();

        if (Number(quantity) >= Number(in_stock) ) {
            alertify.error("Stock exit");
            quantity = $(that).closest(".js-quantity").find('.js-result').val(actual_quantity);
        }
    }

    $(document).on('ready', function () {
        let guest_id = localStorage.getItem("guest_id");
        if(guest_id) {
            $.ajax({
                url: "{{route('view_cart_section')}}",
                type:"GET",
                data:{
                    guest_id: guest_id,
                },
                success:function(response){
                    if(response) {
                        $('.ajax_cart_section').html(response);
                        // caluculateGuestCartPrice();
                    }
                },
                error: function(error) {
                    // alertify.error(JSON.parse(error.responseText).message);
                }, finally: function() {
                    // caluculateGuestCartPrice();
                }
            });
        }

    });

</script>

@endpush
