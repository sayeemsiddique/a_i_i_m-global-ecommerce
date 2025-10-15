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
                </div>
                <div class="col-lg-5">
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

                                @foreach ($pages as $page)
                                    <li>
                                        <a class="list-group-item list-group-item-action" href="{{ route('front.page_info', $page->slug) }}?page-id={{Crypt::encryptString($page->id)}}">{{ $page->title }}</a>
                                    </li>
                                @endforeach


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

                <div class="col-lg-3">
                    <div class="mb-4">
                        <h6 class="mb-3 font-weight-bold">Contact info</h6>
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
                <div class="mb-3 mb-md-0">{{ date('Y') }} © <a href="#" class="font-weight-bold text-gray-90">{{ $global_setting->title }}</a> - </div>

                <div class="mb-3 mb-md-0">Design and Developed by - <a href="#" class="font-weight-bold text-gray-90">{{ $global_setting->copyright }}</a></div>

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
