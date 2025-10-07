@extends('frontend.layout.master_alt')

@push('css')
    <style> 
        .bg-gr-purple{
            background: #8E2DE2;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #4A00E0, #8E2DE2);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #4A00E0, #8E2DE2); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
            
        .bg-gr-blue{
            background: #0052D4;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #6FB1FC, #4364F7, #0052D4);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #6FB1FC, #4364F7, #0052D4); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
            
        .bg-gr-green{
            background: #00b09b;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #96c93d, #00b09b);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #96c93d, #00b09b); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
        
        .bg-gr-red{
            background: #ED213A;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #93291E, #ED213A);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #93291E, #ED213A); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
        
        #account-dashboard .icon-box p {
            color: #fff;
        }
        #account-dashboard .icon-box:hover p {
          color: #fff;
        }
        
        #account-dashboard p a:hover {
          text-decoration: none;
        }
    </style>
@endpush

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
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">My Account</li>
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
                    {{-- user type 1 == customer --}}
                    <h1 class="text-center">Customer Account</h1>
                @endif
            </div>

            <div class="tab tab-vertical row gutter-lg">
                
                @include('frontend.layout.accountMenu')

                <div class="tab-content mb-6" style="padding: 1rem;">

                    <div class="tab-pane active in" id="account-dashboard">
                        <!--<p class="greeting">-->
                        <!--    Hello-->
                        <!--    <span class="text-dark font-weight-bold">-->
                        <!--        @if (Auth::check())-->
                        <!--            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}-->
                        <!--        @endif-->
                        <!--    </span>-->
                        <!--    {{-- (not-->
                        <!--    <span class="text-dark font-weight-bold">John Doe</span>?-->
                        <!--    <a href="#" class="text-primary">Log out</a>) --}}-->
                        <!--</p>-->

                        @include('alerts.alerts')

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-4">
                                <div class="bg-gr-green">
                                    <a href="{{route('account_orders')}}">
                                        <div class="icon-box text-center">
                                            <span class="icon-box-icon icon-orders">
                                                <i class="w-icon-orders"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <p class="text-uppercase mb-0">Orders</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-4">
                                <div class="bg-gr-blue">
                                    <a href="{{route('account_address')}}">
                                        <div class="icon-box text-center">
                                            <span class="icon-box-icon icon-address">
                                                <i class="w-icon-map-marker"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <p class="text-uppercase mb-0">Addresses</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-4">
                                <div class="bg-gr-purple">
                                    <a href="{{route('accountDetails')}}">
                                        <div class="icon-box text-center">
                                            <span class="icon-box-icon icon-account">
                                                <i class="w-icon-user"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <p class="text-uppercase mb-0">Account Details</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-4">
                                <div class="bg-gr-red">
                                    <a href="#">
                                        <div class="icon-box text-center">
                                            <span class="icon-box-icon icon-logout">
                                                {{-- Wallet Amount --}}
                                                <i class="w-icon-user"></i>
                                            </span>
                                            <div class="icon-box-content">
    
                                                <p  class="text-uppercase mb-0">
                                                    <a class="text-white" href="{{ route('user_logout') }}">Logout</a>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
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
    </script>
@endpush