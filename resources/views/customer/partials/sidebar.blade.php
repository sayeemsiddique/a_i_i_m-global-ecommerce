<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <div class="brand flex-column-auto" id="kt_brand" style="padding: 10px">
        <a href="{{ route('index') }}" class="brand-logo">
            <img alt="Logo" src="{{ asset('storage/setting/' . $global_setting->logo) }}" style="max-height: 45px;"/>
            {{-- <h6 class="mt-1 ml-5" style="color: #f1f1f1; font-size:12px;">{{ $global_setting->sub_title ?? '' }}</h6> --}}
        </a>
    </div>
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper" style="background: #FFF !important;">
        <div id="kt_aside_menu" class="aside-menu mb-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
            <ul class="menu-nav">
                <li class="menu-item {{ request()->routeIs('account') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{route('account')}}" class="menu-link">
                        <span class="svg-icon menu-icon" >
                            <i style="text-shadow: 3px 3px #eaeaea;" class="fas fa-th"></i>
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('account_orders') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ route('account_orders') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i style="text-shadow: 3px 3px #eaeaea;" class="fas fa-shopping-bag"></i>
                        </span>
                        <span class="menu-text">Orders</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('order_return') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ route('order_return') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i style="text-shadow: 3px 3px #eaeaea;" class="fas fa-exchange-alt"></i>
                        </span>
                        <span class="menu-text">Order Return</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('shipping_address.index') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ route('shipping_address.index') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i style="text-shadow: 3px 3px #eaeaea;" class="fas fa-map-marker-alt"></i>
                        </span>
                        <span class="menu-text">Addresses</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('accountDetails') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ route('accountDetails') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i style="text-shadow: 3px 3px #eaeaea;" class="fas fa-user"></i>
                        </span>
                        <span class="menu-text">Update Profile</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('accountPassword') ? 'menu-item-active' : '' }}" aria-haspopup="true">
                    <a href="{{ route('accountPassword') }}" class="menu-link">
                        <span class="svg-icon menu-icon">
                            <i style="text-shadow: 3px 3px #eaeaea;" class="fas fa-key"></i>
                        </span>
                        <span class="menu-text">Update Password</span>
                    </a>
                </li>
                <li class="menu-item" aria-haspopup="true">
                    <a href="{{ route('user_logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="svg-icon menu-icon">
                            <i style="text-shadow: 3px 3px #eaeaea;" class="fas fa-sign-out-alt"></i>
                        </span>
                        <span class="menu-text">Logout</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
