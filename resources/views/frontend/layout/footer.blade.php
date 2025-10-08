@php
    $main_categories = App\Models\Category::withCount('SellProducts')
                                ->where([
                                    'parent_id' => 0,
                                    'status' => 1,
                                ])->orderBy('sl', 'asc')
                                ->limit(4)->get();
@endphp

<!-- ========== FOOTER ========== -->
<footer>


    <!-- Footer-bottom-widgets -->
    <div class="pt-8 pb-4 bg-gray-13">
        <div class="container mt-1">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <a href="#" class="d-inline-block">
                            <img loading="lazy" style="max-width: 220px;" src="{{ asset('storage/setting/' . $global_setting->logo) }}" alt="" srcset="">
                        </a>
                    </div>
                    <div class="mb-4">
                        <div class="row no-gutters">
                            <div class="col-auto">
                                <i class="ec ec-support text-primary font-size-56"></i>
                            </div>
                            <div class="col pl-3">
                                <div class="font-size-13 font-weight-light">Any questions?</div>
                                <a href="tel:{{ $global_setting->mobile }}" class="font-size-20 text-gray-90"> {{ $global_setting->mobile }}@if($global_setting->phone !=''), @endif {{ $global_setting->phone }} </a>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h6 class="mb-1 font-weight-bold">Contact info</h6>
                        <address class="">
                            {{ $global_setting->sub_title }} 
                            <br>
                            {{ $global_setting->address }}
                        </address>
                    </div>
                    <div class="my-4 my-md-4">
                        <ul class="list-inline mb-0 opacity-7">
                            @if ($global_setting->fb_link != '')
                                <li class="list-inline-item mr-0">
                                    <a class="btn font-size-20 btn-icon btn-soft-dark btn-bg-transparent rounded-circle"
                                        href="{{ $global_setting->fb_link }}">
                                        <span class="fab fa-facebook-f btn-icon__inner"></span>
                                    </a>
                                </li>
                            @endif

                            @if ($global_setting->twitter_link != '')
                                <li class="list-inline-item mr-0">
                                    <a class="btn font-size-20 btn-icon btn-soft-dark btn-bg-transparent rounded-circle"
                                        href="{{ $global_setting->twitter_link }}">
                                        <span class="fab fa-twitter btn-icon__inner"></span>
                                    </a>
                                </li>
                            @endif

                            @if ($global_setting->youtube_link != '')
                                <li class="list-inline-item mr-0">
                                    <a class="btn font-size-20 btn-icon btn-soft-dark btn-bg-transparent rounded-circle"
                                        href="{{ $global_setting->youtube_link }}">
                                        <span class="fab fa-youtube btn-icon__inner"></span>
                                    </a>
                                </li>
                            @endif

                            @if ($global_setting->instagram_link != '')
                                <li class="list-inline-item mr-0">
                                    <a class="btn font-size-20 btn-icon btn-soft-dark btn-bg-transparent rounded-circle"
                                        href="{{ $global_setting->instagram_link }}">
                                        <span class="fab fa-instagram btn-icon__inner"></span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-12 col-md mb-4 mb-md-0">
                            <h6 class="mb-3 font-weight-bold">Customer Care</h6>
                            <!-- List Group -->
                            <ul class="list-group list-group-flush list-group-borderless mb-0 list-group-transparent">
                                @if (Auth::check())
                                    <li><a class="list-group-item list-group-item-action" href="{{ route('account') }}">My Account</a></li>
                                @else
                                    <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border">
                                        <!-- Account Sidebar Toggle Button -->
                                        <a id="sidebarNavToggler" href="javascript:;" role="button" class="u-header-topbar__nav-link login_js" style="color: black !important"
                                            aria-controls="sidebarContent"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                            data-unfold-event="click"
                                            data-unfold-hide-on-scroll="false"
                                            data-unfold-target="#sidebarContent"
                                            data-unfold-type="css-animation"
                                            data-unfold-animation-in="fadeInRight"
                                            data-unfold-animation-out="fadeOutRight"
                                            data-unfold-duration="500">
                                            Sign in 
                                        </a>
                                        <!-- End Account Sidebar Toggle Button -->
                                    </li>
                                @endif

                                <li><a class="list-group-item list-group-item-action" href="{{ route('front.page', 1) }}">About Us</a></li>
                                <li><a class="list-group-item list-group-item-action" href="{{ route('front.page', 2) }}">Contact Us</a></li>
                                <li><a class="list-group-item list-group-item-action" href="{{ route('front.page', 3) }}">Privacy Policy</a></li>
                                <li><a class="list-group-item list-group-item-action" href="{{ route('front.page', 4) }}">Return and Refund Policy</a></li>
                                <li><a class="list-group-item list-group-item-action" href="{{ route('front.page', 5) }}">Terms and Conditions</a></li>

                                <li><a class="list-group-item list-group-item-action" href="{{ route('order_track') }}">Order Tracking</a></li>

                            </ul>
                            <!-- End List Group -->
                        </div>
                        
                        <div class="col-12 col-md mb-4 mb-md-0">
                            <h6 class="mb-3 font-weight-bold">Categories</h6>
                            <!-- List Group -->
                            <ul class="list-group list-group-flush list-group-borderless mb-0 list-group-transparent">
                                @foreach ($main_categories as $categories)
                                    <li>
                                        <a class="list-group-item list-group-item-action" href="{{ route('store.grid')}}?c[]={{ $categories->id }}">{{ $categories->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <!-- End List Group -->
                        </div>

                        {{-- <div class="col-12 col-md mb-4 mb-md-0">
                            <!-- List Group -->
                            <ul
                                class="list-group list-group-flush list-group-borderless mb-0 list-group-transparent mt-md-6">
                                <li><a class="list-group-item list-group-item-action" href="#">About Us</a></li>
                                <li><a class="list-group-item list-group-item-action" href="{{route('contactus')}}">Contact</a></li>
                            </ul>
                            <!-- End List Group -->
                        </div> --}}

                    </div>
                </div>

                <div class="col-lg-4"> 
                    {{-- <div class="ssl-banner"> 
                        <img loading="lazy" src="{{ asset('frontend/ssl.jpg') }}" alt="SSL Banner" style="max-width: 100%;">
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer-bottom-widgets -->
    <!-- Footer-copy-right -->
    <div class="bg-gray-14 py-2">
        <div class="container">
            <div class="flex-center-between d-block d-md-flex">
                <div class="mb-3 mb-md-0">{{ date('Y') }} © <a href="#" class="font-weight-bold text-gray-90">{{ $global_setting->title }}</a> - {{ $global_setting->copyright }}</div>

                <div class="mb-3 mb-md-0">Design and Developed by - <a href="https://sebpo.com/" class="font-weight-bold text-gray-90">ServicEngine Ltd.</a></div>

                {{-- <div class="text-md-right">
                    <span class="d-inline-block bg-white border rounded p-1">
                        <img loading="lazy" class="max-width-5" src="{{asset('frontend/assets/img/100X60/img1.jpg')}}"
                            alt="Image Description">
                    </span>
                    <span class="d-inline-block bg-white border rounded p-1">
                        <img loading="lazy" class="max-width-5" src="{{asset('frontend/assets/img/100X60/img2.jpg')}}"
                            alt="Image Description">
                    </span>
                    <span class="d-inline-block bg-white border rounded p-1">
                        <img loading="lazy" class="max-width-5" src="{{asset('frontend/assets/img/100X60/img3.jpg')}}"
                            alt="Image Description">
                    </span>
                    <span class="d-inline-block bg-white border rounded p-1">
                        <img loading="lazy" class="max-width-5" src="{{asset('frontend/assets/img/100X60/img4.jpg')}}"
                            alt="Image Description">
                    </span>
                    <span class="d-inline-block bg-white border rounded p-1">
                        <img loading="lazy" class="max-width-5" src="{{asset('frontend/assets/img/100X60/img5.jpg')}}"
                            alt="Image Description">
                    </span>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- End Footer-copy-right -->
</footer>
<!-- ========== END FOOTER ========== -->

<!-- ========== SECONDARY CONTENTS ========== -->
<!-- Account Sidebar Navigation -->

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
<script src="{{asset('frontend/assets/vendor/jquery.countdown.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/hs-megamenu/src/hs.megamenu.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/svg-injector/dist/svg-injector.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/typed.js/lib/typed.min.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/slick-carousel/slick/slick.js')}}"></script>
<script src="{{asset('frontend/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>

<!-- JS -->
<script src="{{asset('frontend/assets/js/hs.core.js')}}"></script>
<script src="{{asset('frontend/assets/js/jquery.jqZoom.js')}}"></script>
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
<script src="{{asset('frontend/assets/js/components/hs.svg-injector.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.go-to.js')}}"></script>
<script src="{{asset('frontend/assets/js/components/hs.selectpicker.js')}}"></script>

<script src="{{asset('frontend/assets/js/components/hs.quantity-counter.js')}}"></script>

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

    $(document).on('ready', function () {
        let guest_id = localStorage.getItem("guest_id");
        if(guest_id) {
            $.ajax({
                url: "{{route('guest_cart_view')}}",
                type:"GET",
                data:{
                    guest_id: guest_id,
                },
                success:function(response){
                    if(response) {
                        $('.guest_user_cart_section').html(response);
                        caluculateGuestCartPrice();
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



@stack('script')

</body>

</html>