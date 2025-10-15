<!-- ========== FOOTER ========== -->

<x-front-footer />



@include('frontend.partials.rightSidebar')

<!-- End Account Sidebar Navigation -->
<!-- ========== END SECONDARY CONTENTS ========== -->
<!-- Go to Top -->
<a class="js-go-to u-go-to" href="#"
data-position='{"bottom": 15, "right": 15 }'
data-type="fixed"
data-offset-top="400"
data-compensation="#header"
data-show-effect="slideInUp"
data-hide-effect="slideOutDown">
<span class="fas fa-arrow-up u-go-to__inner"></span>
</a>
<!-- End Go to Top -->

<!-- JS Global Compulsory -->
<script src="{{asset('frontend/assets/vendor/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/jquery-migrate/dist/jquery-migrate.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/bootstrap/bootstrap.min.js')}}"></script>

<!-- JS Implementing Plugins -->
<script src="{{asset('frontend/assets/vendor/appear.js')}}"></script>
{{-- <script src="{{asset('frontend/assets/vendor/jquery.countdown.min.js')}}"></script> --}}
<script src="{{asset('frontend/assets/vendor/hs-megamenu/src/hs.megamenu.js')}}"></script>
{{-- <script src="{{asset('frontend/assets/vendor/svg-injector/dist/svg-injector.min.js')}}"></script> --}}
<script src="{{asset('frontend/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/typed.js/lib/typed.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/slick-carousel/slick/slick.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>

<!-- JS -->
<script src="{{asset('frontend/assets/js/hs.core.js')}}"></script>
{{-- <script src="{{asset('frontend/assets/js/jquery.jqZoom.js')}}"></script> --}}
<script src="{{asset('frontend/assets/js/components/hs.countdown.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.header.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.hamburgers.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.unfold.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.focus-state.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.malihu-scrollbar.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.validation.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.fancybox.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.onscroll-animation.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.slick-carousel.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.show-animation.js')}}"></script>
{{-- <script src="{{asset('frontend/assets/js/components/hs.svg-injector.js')}}"></script> --}}
<script src="{{asset('frontend/assets/js/components/hs.go-to.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.selectpicker.js')}}"></script>

<script src="{{asset('frontend/assets/js/components/hs.quantity-counter.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- JS Plugins Init. -->
<script>

$(window).on('load', function () {
    // initialization of HSMegaMenu component
    $('.js-mega-menu').HSMegaMenu({
        event: 'hover',
        direction: 'horizontal',
        pageContainer: $('.container'),
        breakpoint: 767.98,
        hideTimeOut: 0
    });

    // initialization of svg injector module
    $.HSCore.components.HSSVGIngector.init('.js-svg-injector');
});
// initialization of HSScrollNav component


$(document).on('ready', function () {
    // initialization of header
    $.HSCore.components.HSHeader.init($('#header'));

    // initialization of animation
    $.HSCore.components.HSOnScrollAnimation.init('[data-animation]');

    // initialization of unfold component
    $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
        afterOpen: function () {
            $(this).find('input[type="search"]').focus();
        }
    });

    // initialization of popups
    $.HSCore.components.HSFancyBox.init('.js-fancybox');

    @if (request()->route()->getName() == 'store.grid')
        $.HSCore.components.HSRangeSlider.init('.js-range-slider');
    @endif

    // initialization of countdowns
    var countdowns = $.HSCore.components.HSCountdown.init('.js-countdown', {
        yearsElSelector: '.js-cd-years',
        monthsElSelector: '.js-cd-months',
        daysElSelector: '.js-cd-days',
        hoursElSelector: '.js-cd-hours',
        minutesElSelector: '.js-cd-minutes',
        secondsElSelector: '.js-cd-seconds'
    });

    // initialization of malihu scrollbar
    $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));

    // initialization of forms
    $.HSCore.components.HSFocusState.init();

    // initialization of form validation
    $.HSCore.components.HSValidation.init('.js-validate', {
        rules: {
            confirmPassword: {
                equalTo: '#signupPassword'
            }
        }
    });

    // initialization of show animations
    $.HSCore.components.HSShowAnimation.init('.js-animation-link');

    // initialization of slick carousel
    $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');

    // initialization of go to
    $.HSCore.components.HSGoTo.init('.js-go-to');

    // initialization of hamburgers
    $.HSCore.components.HSHamburgers.init('#hamburgerTrigger');

    // initialization of unfold component
    $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
        beforeClose: function () {
            $('#hamburgerTrigger').removeClass('is-active');
        },
        afterClose: function() {
            $('#headerSidebarList .collapse.show').collapse('hide');
        }
    });

    $('#headerSidebarList [data-toggle="collapse"]').on('click', function (e) {
        e.preventDefault();

        var target = $(this).data('target');

        if($(this).attr('aria-expanded') === "true") {
            $(target).collapse('hide');
        } else {
            $(target).collapse('show');
        }
    });

    // initialization of unfold component
    $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));

    // initialization of select picker
    $.HSCore.components.HSSelectPicker.init('.js-select');
});


$(".signup_js").click(function(){
    $('#login').css("display","none");
    $('#login').css("opacity",0);
    $('#signup').css("display","block");
    $('#signup').css("opacity",1);
});

$(".login_js").click(function(){
    $('#login').css("display","block");
    $('#login').css("opacity",1);
    $('#signup').css("display","none");
    $('#signup').css("opacity",0);
});

$("#sidebarNavToggler1").click(function(){
    $('.mobile-display-option').removeClass("d-none");
});

$('#pass-eye').on('click', function() {
    let attr = $('#signupPassword').attr('type');

    if (attr === 'password') {
        $('#signupPassword').attr('type', 'text');
    } else {
        $('#signupPassword').attr('type', 'password');
    }
});

$('#conf-pass-eye').on('click', function() {
    let attr = $('#signupConfirmPassword').attr('type');

    if (attr === 'password') {
        $('#signupConfirmPassword').attr('type', 'text');
    } else {
        $('#signupConfirmPassword').attr('type', 'password');
    }
});

$('#log-pass-eye').on('click', function() {
    let attr = $('#signinPassword').attr('type');

    if (attr === 'password') {
        $('#signinPassword').attr('type', 'text');
    } else {
        $('#signinPassword').attr('type', 'password');
    }
});

    function  caluculateGuestCartPrice() {
        let cart_amoutnt = $('.cart_price_span').text();
        let cart_quantity = $('.cart_quantity').text();
        let guest_cart_amoutnt = $('.guest_cart_amount').val();
        let guest_cart_quantity = $('.guest_cart_quantity').val();
        let final_cart_amount = Number(cart_amoutnt) + Number(guest_cart_amoutnt);
        $('.custom_cart_price_span').text(final_cart_amount.toFixed(2));
        $('.custom_cart_quantity').text(Number(cart_quantity) + Number(guest_cart_quantity));

    }

    function removeGuestCart(that) {
        if (confirm('Are you sure to remove this item from your cart')) {
            var cart_id = $(that).closest('a').find('i').attr('data-cart_id');
            var url = "{{route('remove_guest_cart_item')}}?id="+cart_id;
            window.location.replace(url);
        }
    }

    // $(document).on('ready', function () {
    //     let guest_id = localStorage.getItem("guest_id");
    //     if(guest_id) {
    //         $.ajax({
    //             url: "{{route('guest_cart_view')}}",
    //             type:"GET",
    //             data:{
    //                 guest_id: guest_id,
    //             },
    //             success:function(response){
    //                 if(response) {
    //                     $('.guest_user_cart_section').html(response);
    //                     caluculateGuestCartPrice();
    //                 }
    //             },
    //             error: function(error) {
    //                 // alertify.error(JSON.parse(error.responseText).message);
    //             }, finally: function() {
    //                 // caluculateGuestCartPrice();
    //             }
    //         });
    //     }

    // });

</script>



@stack('script')

</body>

</html>
