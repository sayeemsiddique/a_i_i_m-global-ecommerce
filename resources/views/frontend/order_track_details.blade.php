@extends('frontend.layout.master_alt')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->

    <main id="content" role="main">

        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('index') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Track your
                                Order</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>


        <div class="container">
            <style>
                @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

                body {
                    background-color: #eeeeee;
                    font-family: 'Open Sans', serif
                }

                .card {
                    position: relative;
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    -webkit-box-orient: vertical;
                    -webkit-box-direction: normal;
                    -ms-flex-direction: column;
                    flex-direction: column;
                    min-width: 0;
                    word-wrap: break-word;
                    background-color: #fff;
                    background-clip: border-box;
                    border: 1px solid rgba(0, 0, 0, 0.1);
                    border-radius: 0.10rem
                }

                .card-header:first-child {
                    border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
                }

                .card-header {
                    padding: 0.75rem 1.25rem;
                    margin-bottom: 0;
                    background-color: #fff;
                    border-bottom: 1px solid rgba(0, 0, 0, 0.1)
                }

                .track {
                    position: relative;
                    background-color: #ddd;
                    height: 7px;
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    margin-bottom: 60px;
                    margin-top: 100px
                }

                .track .step {
                    -webkit-box-flex: 1;
                    -ms-flex-positive: 1;
                    flex-grow: 1;
                    width: 25%;
                    margin-top: -18px;
                    text-align: center;
                    position: relative
                }

                .track .step.active:before {
                    background: #FF5722
                }

                .track .step::before {
                    height: 7px;
                    position: absolute;
                    content: "";
                    width: 100%;
                    left: 0;
                    top: 18px
                }

                .track .step.active .icon {
                    background: #ee5435;
                    color: #fff
                }

                .track .icon {
                    display: inline-block;
                    width: 40px;
                    height: 40px;
                    line-height: 40px;
                    position: relative;
                    border-radius: 100%;
                    background: #ddd
                }

                .track .step.active .text {
                    font-weight: 400;
                    color: #000
                }

                .track .text {
                    display: block;
                    margin-top: 7px
                }

                .itemside {
                    position: relative;
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    width: 100%
                }

                .itemside .aside {
                    position: relative;
                    -ms-flex-negative: 0;
                    flex-shrink: 0
                }

                .img-sm {
                    width: 80px;
                    height: 80px;
                    padding: 7px
                }

                ul.row,
                ul.row-sm {
                    list-style: none;
                    padding: 0
                }

                .itemside .info {
                    padding-left: 15px;
                    padding-right: 7px
                }

                .itemside .title {
                    display: block;
                    margin-bottom: 5px;
                    color: #212529
                }

                p {
                    margin-top: 0;
                    margin-bottom: 1rem
                }

                .btn-warning {
                    color: #ffffff;
                    background-color: #ee5435;
                    border-color: #ee5435;
                    border-radius: 1px
                }

                .btn-warning:hover {
                    color: #ffffff;
                    background-color: #ff2b00;
                    border-color: #ff2b00;
                    border-radius: 1px
                }
            </style>
            <div class="mx-xl-10">
                <div class="mb-6 text-center">
                    <h1 class="mb-6">Thanks for your query.</h1>

                </div>
                <div class="my-4 my-xl-8" style="min-height: 200px;">


                    @isset($order)

                        <div class="track">

                            <div class="step @if($order->status == 0) active @elseif($order->status == 1) active @elseif($order->status == 2) active @endif">
                                <span class="icon">
                                    <i class="fa fa-paper-plane"></i>
                                </span>
                                <span class="text">
                                    @if($order->status == 0) Pending @elseif($order->status == 1) Approved @elseif($order->status == 2) Declined @endif
                                </span>
                            </div>

                            <div class="step @if(in_array($order->delivery_status, [1,2,3])) active @endif ">
                                <span class="icon">
                                    <i class="fa fa-truck"></i>
                                </span>
                                <span class="text"> On Delivery </span>
                            </div>

                            <div class="step @if(in_array($order->delivery_status, [3])) active @endif ">
                                <span class="icon">
                                    <i class="fa fa-box"></i>
                                </span>
                                <span class="text">Delivered</span>
                            </div>

                            {{-- @if ($order->stage == 2)

                            <div class="step @if($order->stage == 0) active @elseif($order->stage == 2) active  @endif">
                                <span class="icon">
                                    <i class="fa fa-times"></i>
                                </span>
                                <span class="text">Reject</span>
                            </div>
                            @endif
                            @if ($order->stage == 5)

                            <div class="step @if($order->stage == 0) active @elseif($order->stage == 5) active  @endif">
                                <span class="icon">
                                    <i class="fa fa-times"></i>
                                </span>
                                <span class="text">Cancel</span>
                            </div>
                            @endif

                            <div class="step @if($order->stage == 3) active @elseif($order->stage == 1) active @elseif($order->stage == 4) active  @else  @endif ">
                                <span class="icon"> <i class="fa fa-check"></i>
                                </span>
                                <span class="text"> Confirmed</span>
                            </div>
                            <div class="step @if($order->stage == 3) active @elseif($order->stage == 4) active  @else  @endif ">
                                <span class="icon">
                                    <i class="fa fa-truck"></i>
                                </span>
                                <span class="text"> On Delivery </span>
                            </div>
                            <div class="step @if($order->stage == 4) active @endif">
                                <span class="icon">
                                    <i class="fa fa-box"></i>
                                </span>
                                <span class="text">Delivered</span>
                            </div> --}}
                        </div>

                    @else
                        <h4 class="text-center text-red"><i class="fa fa-times fa-5x"></i></h4>
                        <h5 class="text-center text-red">No Order Found</h5>
                        <div class="text-center">
                            <a href="{{ route('order_track') }}" class="btn btn-primary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">Search Again</a>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </main>
@endsection
