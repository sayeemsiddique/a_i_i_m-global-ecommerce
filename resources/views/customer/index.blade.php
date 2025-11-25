@extends('customer.layout.master')

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="d-flex flex-column-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="bg-success rounded">
                            <div class="text-center">
                                @if ($user->image)
                                    <img class="dashboard-user-image" src="{{asset('storage/users/'.$user->image)}}" />

                                @else
                                    <img class="dashboard-user-image" src="{{asset('assets/media/users/blank.png')}}" />
                                @endif
                                <h5 class="mt-3 pb-3">{{$user->first_name}} {{$user->last_name}}</h5>
                                <p class="m-0">{{$user->email}}</p>
                                <p class="mt-2"> {{$user->mobile}}</p>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-custom gutter-b dash-count-card w3-amber">
                            <!--begin::Body-->
                            <div class="card-body p-0 ">
                                {{-- <a href="#" class="dash-click-card"> --}}
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <i class="icon-xl fas fa-question fa-4x mr-2 w3-text-white"></i>
                                        <div class="d-flex flex-column text-right">
                                            <span
                                                class="font-weight-bolder font-size-h2 text-white">{{ $total_order }}</span>
                                            <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total Orders</span>
                                        </div>
                                    </div>
                                {{-- </a> --}}
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-custom gutter-b dash-count-card w3-teal">
                            <!--begin::Body-->
                            <div class="card-body p-0 ">
                                {{-- <a href="#" class="dash-click-card"> --}}
                                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                        <i class="fas fa-cart-arrow-down fa-4x mr-2 w3-text-white"></i>
                                        <div class="d-flex flex-column text-right">
                                            <span
                                                class="font-weight-bolder font-size-h2">{{ $cart_count }}</span>
                                            <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Products in Cart</span>
                                        </div>
                                    </div>
                                {{-- </a> --}}
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .dashboard-user-image {
            width: 100%;
            max-width: 200px;
            border-radius: 65%;
            height: 200px;
            padding: 20px;
        }
    </style>
@endsection


