@php
    $link = URL::current();
@endphp

<ul class="nav nav-tabs mb-6 nav-custom-design" role="tablist">
    <li class="nav-item">
        <a href="{{route('account')}}" class="nav-link {{strpos($link, 'accountDashboard') ? 'active' : ''}}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a href="{{route('account_orders')}}" class="nav-link {{strpos($link, 'order') ? 'active' : ''}}">Orders</a>
    </li>
    {{-- <li class="nav-item">
        <a href="{{route('account_address')}}" class="nav-link {{strpos($link, 'address') ? 'active' : ''}}">Addresses</a>
    </li> --}}
    <li class="nav-item">
        <a href="{{route('accountDetails')}}" class="nav-link  {{strpos($link, 'accountDetails') ? 'active' : ''}}">Account details</a>
    </li>
    <li class="nav-item">
        <a href="{{route('accountPassword')}}" class="nav-link {{strpos($link, 'accountPassword') ? 'active' : ''}}">Password</a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user_logout') }}" class="nav-link">Logout</a>
    </li>
</ul>

<style>
    .nav-custom-design .nav-link {
        border-bottom: 1px solid #f74953 !important
    }
    .nav-custom-design .nav-link.active {
        /* background-color: #b6bbc0ff;
        color: #fff;
        font-weight: bold; */
    }
    .nav-custom-design .nav-link:hover {
        /* background-color: #f74953;
        color: #f8f9fa; */
    }
</style>
