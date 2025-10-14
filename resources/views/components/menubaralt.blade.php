<!-- ========== HEADER ========== -->
<header id="header" class="u-header u-header-left-aligned-nav">
    <div class="u-header__section">
        <!-- Topbar -->
        <div class="u-header-topbar py-2 d-none d-xl-block">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="topbar-left">
                        <a href="#" class="text-gray-110 font-size-13 u-header-topbar__nav-link">Welcome to {{ $global_setting->title ?? 'AIIM Global' }}</a>
                    </div>
                    <div class="topbar-right ml-auto">
                        <ul class="list-inline mb-0">

                            <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border">
                                <a href="{{route('order_track')}}" class="u-header-topbar__nav-link"><i class="ec ec-transport mr-1"></i> Track Your Order</a>
                            </li>


                                @if (Auth::check())
                                    <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border">
                                        <a href="{{ route('account') }}" class="u-header-topbar__nav-link text-success"><i class="ec ec-user mr-1"></i> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
                                    </li>
                                @else
                                    <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border">
                                        <a id="sidebarNavToggler" href="javascript:;" role="button" class="u-header-topbar__nav-link signup_js"
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
                                            <i class="ec ec-user mr-1"></i> Register
                                        </a>
                                    </li>
                                    <li class="list-inline-item mr-0 u-header-topbar__nav-item u-header-topbar__nav-item-border">
                                        <a id="sidebarNavToggler" href="javascript:;" role="button" class="u-header-topbar__nav-link login_js"
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
                                            <i class="ec ec-newsletter mr-1"></i> Sign in
                                        </a>
                                    </li>
                                @endif



                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Topbar -->

        <!-- Logo and Menu -->
        <div class="py-2 py-xl-4 bg-primary-down-lg">
            <div class="container my-0dot5 my-xl-0">
                @include('alerts.alerts')
                <div class="row align-items-center">
                    <!-- Logo-offcanvas-menu -->
                    <div class="col-auto">
                        <!-- Nav -->
                        <nav class="navbar navbar-expand u-header__navbar py-0 justify-content-xl-between max-width-270 min-width-270">
                            <!-- Logo -->
                            <a class="order-1 order-xl-0 navbar-brand u-header__navbar-brand u-header__navbar-brand-center" href="{{route('index')}}" aria-label="Electro">
                                <img src="{{ asset('storage/setting') }}/{{ $global_setting->logo ?? '' }}" alt="" srcset="">
                            </a>
                            <!-- End Logo -->

                            <!-- Fullscreen Toggle Button -->
                            <button id="sidebarHeaderInvokerMenu" type="button" class="navbar-toggler d-block btn u-hamburger mr-3 mr-xl-0"
                                aria-controls="sidebarHeader"
                                aria-haspopup="true"
                                aria-expanded="false"
                                data-unfold-event="click"
                                data-unfold-hide-on-scroll="false"
                                data-unfold-target="#sidebarHeader1"
                                data-unfold-type="css-animation"
                                data-unfold-animation-in="fadeInLeft"
                                data-unfold-animation-out="fadeOutLeft"
                                data-unfold-duration="500">
                                <span id="hamburgerTriggerMenu" class="u-hamburger__box">
                                    <span class="u-hamburger__inner"></span>
                                </span>
                            </button>
                            <!-- End Fullscreen Toggle Button -->
                        </nav>
                        <!-- End Nav -->

                        <!-- ========== HEADER SIDEBAR ========== -->
                        <aside id="sidebarHeader1" class="u-sidebar u-sidebar--left" aria-labelledby="sidebarHeaderInvokerMenu">
                            <div class="u-sidebar__scroller">
                                <div class="u-sidebar__container">
                                    <div class="u-header-sidebar__footer-offset pb-0">
                                        <!-- Toggle Button -->
                                        <div class="position-absolute top-0 right-0 z-index-2 pt-4 pr-7">
                                            <button type="button" class="close ml-auto"
                                                aria-controls="sidebarHeader"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                data-unfold-event="click"
                                                data-unfold-hide-on-scroll="false"
                                                data-unfold-target="#sidebarHeader1"
                                                data-unfold-type="css-animation"
                                                data-unfold-animation-in="fadeInLeft"
                                                data-unfold-animation-out="fadeOutLeft"
                                                data-unfold-duration="500">
                                                <span aria-hidden="true"><i class="ec ec-close-remove text-gray-90 font-size-20"></i></span>
                                            </button>
                                        </div>
                                        <!-- End Toggle Button -->

                                        <!-- Content -->
                                        <div class="js-scrollbar u-sidebar__body">
                                            <div id="headerSidebarContent" class="u-sidebar__content u-header-sidebar__content">
                                                <!-- Logo -->
                                                <a class="d-flex ml-0 navbar-brand u-header__navbar-brand u-header__navbar-brand-vertical" href="{{route('index')}}" aria-label="AIIM Global">
                                                    <img src="{{ asset('storage/setting') }}/{{ $global_setting->logo ?? '' }}" alt="" srcset="">
                                                </a>
                                                <!-- End Logo -->

                                                <!-- List -->
                                                <ul id="headerSidebarList" class="u-header-collapse__nav">
                                                    @foreach ($categories as $category)
                                                        @if (count($category->childTreeInfo) > 0)
                                                            <!-- Home Section -->
                                                            <li class="u-has-submenu u-header-collapse__submenu">
                                                                <a class="u-header-collapse__nav-link u-header-collapse__nav-pointer" href="javascript:;" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="headerSidebarHomeCollapse" data-target="#headerSidebarHomeCollapse">
                                                                    {{$category->name}}
                                                                </a>

                                                                <div id="headerSidebarHomeCollapse" class="collapse" data-parent="#headerSidebarContent">
                                                                    <ul id="headerSidebarHomeMenu" class="u-header-collapse__nav-list">
                                                                        @foreach ($category->childTreeInfo as $childTreeInfo)
                                                                            <li><a class="u-header-collapse__submenu-nav-link" href="{{route('store.grid')}}?c[]={{$childTreeInfo->id}}">{{$childTreeInfo->name}}</a></li>

                                                                            @if (count($childTreeInfo->childTreeInfo) > 0)
                                                                                @foreach ($childTreeInfo->childTreeInfo as $childrenTreeInfo)
                                                                                    <li><a class="u-header-collapse__submenu-nav-link" href="{{route('store.grid')}}?c[]={{$childrenTreeInfo->id}}">--{{$childrenTreeInfo->name}}</a></li>
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <!-- End Home Section -->
                                                        @else
                                                        <li class="">
                                                            <a class="u-header-collapse__nav-link font-weight-bold" href="{{route('store.grid')}}?c[]={{$category->id}}">
                                                                {{$category->name}}
                                                            </a>
                                                        </li>
                                                        @endif
                                                    @endforeach


                                                </ul>
                                                <!-- End List -->
                                            </div>
                                        </div>
                                        <!-- End Content -->
                                    </div>
                                </div>
                            </div>
                        </aside>
                        <!-- ========== END HEADER SIDEBAR ========== -->
                    </div>
                    <!-- End Logo-offcanvas-menu -->
                    <!-- Primary Menu -->
                    <div class="col d-none d-xl-block">
                        <!-- Nav -->
                        <nav class="js-mega-menu navbar navbar-expand-md u-header__navbar u-header__navbar--no-space">
                            <!-- Navigation -->
                            <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
                                <ul class="navbar-nav u-header__navbar-nav">
                                    <!-- Home -->
                                    <!-- Home -->
                                    <li class="nav-item u-header__nav-item">
                                        <a class="nav-link u-header__nav-link" href="{{route('index')}}">Home</a>
                                    </li>
                                    <!-- End Home -->

                                    <!-- About us -->
                                    <li class="nav-item u-header__nav-item">
                                        <a class="nav-link u-header__nav-link" href="{{route('aboutus')}}">About us</a>
                                    </li>
                                    <!-- End About us -->

                                    <!-- FAQs -->
                                    <li class="nav-item u-header__nav-item">
                                        <a class="nav-link u-header__nav-link" href="{{route('store.grid')}}">Shop</a>
                                    </li>
                                    <!-- End FAQs -->



                                    <!-- Contact Us -->
                                    <li class="nav-item u-header__nav-item">
                                        <a class="nav-link u-header__nav-link" href="{{route('contactus')}}">Contact Us</a>
                                    </li>
                                    <!-- End Contact Us -->
                                </ul>
                            </div>
                            <!-- End Navigation -->
                        </nav>
                        <!-- End Nav -->
                    </div>
                    <!-- End Primary Menu -->
                    <!-- Customer Care -->
                    <div class="d-none d-xl-block col-md-auto">
                        <div class="d-flex">
                            <i class="ec ec-support font-size-50 text-primary"></i>
                            <div class="ml-2">
                                <div class="phone">
                                    <strong>Support</strong> <a href="tel:{{$global_setting->mobile ?? ""}}" class="text-gray-90">{{$global_setting->mobile ?? ""}}</a>
                                </div>
                                <div class="email">
                                    E-mail: <a href="mailto:{{$global_setting->email ?? ""}}?subject=Help Need" class="text-gray-90">{{$global_setting->email ?? ""}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Customer Care -->
                    <!-- Header Icons -->
                    <div class="d-xl-none col col-xl-auto text-right text-xl-left pl-0 pl-xl-3 position-static">
                        <div class="d-inline-flex">
                            <ul class="d-flex list-unstyled mb-0 align-items-center">
                                <!-- Search -->
                                <li class="col d-xl-none px-2 px-sm-3 position-static">
                                    <a id="searchClassicInvoker" class="font-size-22 text-gray-90 text-lh-1 btn-text-secondary" href="javascript:;" role="button"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Search"
                                        aria-controls="searchClassic"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        data-unfold-target="#searchClassic"
                                        data-unfold-type="css-animation"
                                        data-unfold-duration="300"
                                        data-unfold-delay="300"
                                        data-unfold-hide-on-scroll="true"
                                        data-unfold-animation-in="slideInUp"
                                        data-unfold-animation-out="fadeOut">
                                        <span class="ec ec-search"></span>
                                    </a>

                                    <!-- Input -->
                                    <div id="searchClassic" class="dropdown-menu dropdown-unfold dropdown-menu-right left-0 mx-2" aria-labelledby="searchClassicInvoker">
                                        <form class="js-focus-state input-group px-3" action="{{route('store.grid')}}" method="GET">
                                            <input class="form-control" name="searchProduct" type="text" placeholder="Search Product" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary px-3" type="submit"><i class="font-size-18 ec ec-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- End Input -->
                                </li>
                                <!-- End Search -->


                                <li class="col d-xl-none px-2 px-sm-3"><a href="{{route('account')}}" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="My Account"><i class="font-size-22 ec ec-user"></i></a></li>
                                <li class="col pr-xl-0 px-2 px-sm-3">
                                    <a href="{{route('cart')}}" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="Cart">
                                        <i class="font-size-22 ec ec-shopping-bag"></i>
                                        <span class="width-22 height-22 bg-dark position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 text-white custom_cart_quantity">{{count($carts)}}</span>
                                        <span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3">



                                            @php
                                            $cart_amount  = 0;
                                            if (count($carts) > 0){
                                                foreach ($carts as $key => $cart) {
                                                    if ($cart->variation_id == 0) {
                                                        $cart_amount  += (($cart->productInfo->discount_price ?? 0) * $cart->quantity);
                                                    } else {
                                                        $cart_amount  += (($cart->varientInfo->discount_price ?? 0) * $cart->quantity);
                                                    }
                                                }
                                            }
                                            @endphp

                                            ৳ <span class="cart_price_span custom_cart_price_span">{{number_format($cart_amount,2,".","")}}</span>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Header Icons -->
                </div>
            </div>
        </div>
        <!-- End Logo and Menu -->

        <!-- Vertical-and-Search-Bar -->
        <div class="d-none d-xl-block bg-primary">
            <div class="container">
                <div class="row align-items-stretch min-height-50">
                    <!-- Vertical Menu -->
                    <div class="col-md-auto d-none d-xl-flex align-items-end">
                        <div class="max-width-270 min-width-270">
                            <!-- Basics Accordion -->
                            <div id="basicsAccordion">
                                <!-- Card -->
                                <div class="card border-0 rounded-0">
                                    <div class="card-header bg-primary rounded-0 card-collapse border-0" id="basicsHeadingOne">
                                        <button type="button" class="btn-link btn-remove-focus btn-block d-flex card-btn py-3 text-lh-1 px-4 shadow-none btn-primary rounded-top-lg border-0 font-weight-bold text-gray-90"
                                            data-toggle="collapse"
                                            data-target="#basicsCollapseOne"
                                            aria-expanded="true"
                                            aria-controls="basicsCollapseOne">
                                            <span class="pl-1 text-gray-90">Shop By Category</span>
                                            <span class="text-gray-90 ml-3">
                                                <span class="ec ec-arrow-down-search"></span>
                                            </span>
                                        </button>
                                    </div>
                                    <div id="basicsCollapseOne" class="collapse vertical-menu v1"
                                        aria-labelledby="basicsHeadingOne"
                                        data-parent="#basicsAccordion">
                                        <div class="card-body p-0">
                                            <nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space hs-menu-initialized">
                                                <div id="navBar" class="collapse navbar-collapse u-header__navbar-collapse">
                                                    <ul class="navbar-nav u-header__navbar-nav border-primary border-top-0">


                                                        @foreach ($categories as $category)
                                                        @if (count($category->childTreeInfo) > 0)
                                                            <!-- Nav Item MegaMenu -->
                                                            <li class="nav-item hs-has-mega-menu u-header__nav-item"
                                                            data-event="hover"
                                                            data-animation-in="slideInUp"
                                                            data-animation-out="fadeOut"
                                                            data-position="left">
                                                            <a id="basicMegaMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle" href="javascript:;" aria-haspopup="true" aria-expanded="false">{{$category->name}}</a>

                                                            <!-- Nav Item - Mega Menu -->
                                                            <div class="hs-mega-menu vmm-tfw u-header__sub-menu" aria-labelledby="basicMegaMenu">
                                                                <div class="row u-header__mega-menu-wrapper" style="background: white;">
                                                                    <div class="col mb-3 mb-sm-0">
                                                                        <span class="u-header__sub-menu-title">
                                                                            <a  href="{{route('store.grid')}}?c[]={{$category->id}}">{{$category->name}}</a>
                                                                        </span>
                                                                        <ul class="u-header__sub-menu-nav-group mb-3">
                                                                            @foreach ($category->childTreeInfo as $childTreeInfo)

                                                                                <li><a class="nav-link u-header__sub-menu-nav-link" href="{{route('store.grid')}}?c[]={{$childTreeInfo->id}}">{{$childTreeInfo->name}}</a></li>
                                                                                @if (count($childTreeInfo->childTreeInfo) > 0)
                                                                                    @foreach ($childTreeInfo->childTreeInfo as $childrenTreeInfo)
                                                                                        <li><a class="nav-link u-header__sub-menu-nav-link" href="{{route('store.grid')}}?c[]={{$childrenTreeInfo->id}}">--{{$childrenTreeInfo->name}}</a></li>
                                                                                    @endforeach

                                                                                @endif
                                                                            @endforeach



                                                                        </ul>
                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <!-- End Nav Item - Mega Menu -->
                                                            </li>
                                                            <!-- End Nav Item MegaMenu-->
                                                        @else
                                                            <li class="nav-item u-header__nav-item"
                                                            data-event="hover"
                                                            data-position="left">
                                                                <a href="#" class="nav-link u-header__nav-link font-weight-bold">
                                                                    {{$category->name}}
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @endforeach


                                                    </ul>
                                                </div>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>
                            <!-- End Basics Accordion -->
                        </div>
                    </div>
                    <!-- End Vertical Menu -->
                    <!-- Search bar -->
                    <div class="col align-self-center">
                        <!-- Search-Form -->
                        <form class="js-focus-state" action="{{route('store.grid')}}" method="GET">
                            <label class="sr-only" for="searchProduct">Search</label>
                            <div class="input-group">
                                <input type="text" class="form-control py-2 pl-5 font-size-15 border-0 height-40 rounded-left-pill" name="searchProduct" id="searchProduct" placeholder="Search for Products" aria-label="Search for Products" aria-describedby="searchProduct1" required>
                                <div class="input-group-append">
                                    <!-- Select -->
                                    {{-- <select class="js-select selectpicker dropdown-select custom-search-categories-select"
                                        data-style="btn height-40 text-gray-60 font-weight-normal border-0 rounded-0 bg-white px-5 py-2">
                                        <option value="one" selected>All Categories</option>
                                        <option value="two">Two</option>
                                        <option value="three">Three</option>
                                        <option value="four">Four</option>
                                    </select> --}}
                                    <!-- End Select -->
                                    <button class="btn btn-dark height-40 py-2 px-3 rounded-right-pill" type="submit" id="searchProduct1">
                                        <span class="ec ec-search font-size-24"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- End Search-Form -->
                    </div>
                    <!-- End Search bar -->
                    <!-- Header Icons -->
                    <div class="col-md-auto align-self-center">
                        <div class="d-flex">
                            <ul class="d-flex list-unstyled mb-0">


                                <li class="col d-xl-none px-2 px-sm-3"><a href="{{route('account')}}" class="text-gray-90" data-toggle="tooltip" data-placement="top" title="My Account"><i class="font-size-22 ec ec-user"></i></a></li>
                                <li class="col pr-xl-0 px-2 px-sm-3 d-xl-none">
                                    <a href="{{ route('cart') }}" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="Cart">
                                        <i class="font-size-22 ec ec-shopping-bag"></i>
                                        <span class="bg-lg-down-black width-22 height-22 bg-primary position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12" style="border: 1px solid #333e48;">0</span>
                                        <span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3 ">৳ <span class="custom_cart_price_span">0.00</span></span>
                                    </a>
                                </li>
                                <li class="col pr-xl-0 px-2 px-sm-3 d-none d-xl-block">
                                    <div id="basicDropdownHoverInvoker" class="text-gray-90 position-relative d-flex " data-toggle="tooltip" data-placement="top" title="Cart"
                                        aria-controls="basicDropdownHover"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        data-unfold-event="click"
                                        data-unfold-target="#basicDropdownHover"
                                        data-unfold-type="css-animation"
                                        data-unfold-duration="300"
                                        data-unfold-delay="300"
                                        data-unfold-hide-on-scroll="true"
                                        data-unfold-animation-in="slideInUp"
                                        data-unfold-animation-out="fadeOut">
                                        <i class="font-size-22 ec ec-shopping-bag"></i>
                                        <span class="bg-lg-down-black width-22 height-22 bg-primary position-absolute d-flex align-items-center justify-content-center rounded-circle left-12 top-8 font-weight-bold font-size-12 cart_quantity custom_cart_quantity" style="border: 1px solid #333e48;">{{count($carts)}}</span>
                                        <span class="d-none d-xl-block font-weight-bold font-size-16 text-gray-90 ml-3">


                                            ৳ <span class="custom_cart_price_span">{{number_format($cart_amount,2,".","")}}</span>
                                        </span>
                                    </div>
                                    <div id="basicDropdownHover" class="cart-dropdown dropdown-menu dropdown-unfold border-top border-top-primary mt-3 border-width-2 border-left-0 border-right-0 border-bottom-0 left-auto right-0" aria-labelledby="basicDropdownHoverInvoker">
                                        <ul class="list-unstyled px-3 pt-3">
                                            @foreach ($carts as $key => $cart)
                                                <li class="border-bottom pb-3 mb-3">
                                                    <div class="">
                                                        <ul class="list-unstyled row mx-n2">
                                                            <li class="px-2 col-auto">
                                                                <img style="max-width: 100px;" class="img-fluid" src="{{asset('storage/product')}}/{{$cart->productInfo->image ?? ''}}" alt="Image Description">
                                                            </li>
                                                            <li class="px-2 col">
                                                                <h5 class="text-blue font-size-14 font-weight-bold mb-0">{{$cart->productInfo->name ?? ''}}</h5>
                                                                @if ($cart->variation_id > 0)
                                                                    <span class="font-size-14">
                                                                        <small style="color: #b36a0d;font-weight: bold;">
                                                                            @foreach (($cart->varientDataInfo ?? []) as $varientDataInfo)
                                                                                @if ($loop->last)
                                                                                    {{$varientDataInfo->varientTypeInfo->name ?? ''}}: {{$varientDataInfo->data_value}}
                                                                                @else
                                                                                    {{$varientDataInfo->varientTypeInfo->name ?? ''}}: {{$varientDataInfo->data_value}},
                                                                                @endif
                                                                            @endforeach
                                                                        </small>
                                                                    </span> <br/>
                                                                @endif
                                                                <span class="font-size-14">{{$cart->quantity}} × ৳@if ($cart->variation_id == 0){{$cart->productInfo->discount_price ?? ''}} @else {{$cart->varientInfo->discount_price ?? 0}} @endif</span>
                                                            </li>
                                                            <li class="px-2 col-auto">
                                                                <a href="#" class="text-gray-90"><i data-cart_id="{{$cart->id}}" class="remove-cart ec ec-close-remove"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="guest_user_cart_section">

                                        </div>
                                        <div class="flex-center-between px-4 pt-2">
                                            <a href="{{ route('cart') }}" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5">View cart</a>
                                            <a href="{{route('checkout')}}" class="btn btn-primary-dark-w ml-md-2 px-5 px-md-4 px-lg-5">Checkout</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Header Icons -->
                </div>
            </div>
        </div>
        <!-- End Vertical-and-secondary-menu -->
    </div>
</header>
<!-- ========== END HEADER ========== -->


@push('script')
{{-- data-cart_id --}}
<script>
    $(".remove-cart").click(function () {
        if (confirm('Are you sure to remove this item from your cart')) {
            var cart_id = $(this).closest('a').find('i').attr('data-cart_id');
            var url = "{{route('remove_cart_item')}}?id="+cart_id;
            window.location.replace(url);
        }
    });
</script>
@endpush
