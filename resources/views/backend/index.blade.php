@extends('backend.layout.master')

@section('content')
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        {{-- <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Hello, {{ Auth::user()->first_name }}
                        {{ Auth::user()->middle_name }} {{ Auth::user()->last_name }}</h5>

                    <!--end::Page Title-->
                </div>
                <!--end::Info-->
            </div>
        </div> --}}
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Dashboard-->

                <!--begin::Row-->
                <div class="row">

                    @can('total_pending_orders')
                        <div class="col-lg-3 col-xxl-3">
                            <!--begin::Stats Widget 12-->
                            <div class="card card-custom gutter-b dash-count-card w3-amber">
                                <!--begin::Body-->
                                <div class="card-body p-0 ">
                                    <a href="{{ route('admin.order.pending_list') }}" class="dash-click-card">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <i class="icon-xl fas fa-question fa-4x mr-2 w3-text-white"></i>
                                            <div class="d-flex flex-column text-right">
                                                <span
                                                    class="font-weight-bolder font-size-h2">{{ $total_pending_orders }}</span>
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total Pending
                                                    Orders</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Stats Widget 12-->
                        </div>
                    @endcan


                    {{-- @can('total_pos_orders')
                        <div class="col-lg-3 col-xxl-3">
                            <!--begin::Stats Widget 12-->
                            <div class="card card-custom gutter-b dash-count-card w3-cyan">
                                <!--begin::Body-->
                                <div class="card-body p-0 ">
                                    <a href="{{ route('admin.pos.orderList') }}" class="dash-click-card">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">

											<i class="icon-xl fas fa-store fa-4x mr-2 w3-text-white"></i>

                                            <div class="d-flex flex-column text-right">
                                                <span class="font-weight-bolder font-size-h2">{{ $total_pos_orders }}</span>
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total POS
                                                    Orders</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Stats Widget 12-->
                        </div>
                    @endcan --}}

                    @can('total_products')
                        <div class="col-lg-3 col-xxl-3">
                            <!--begin::Stats Widget 12-->
                            <div class="card card-custom gutter-b dash-count-card w3-purple">
                                <!--begin::Body-->
                                <div class="card-body p-0 ">
                                    <a href="{{ route('admin.product.index') }}" class="dash-click-card">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <i class="icon-xl fas fa-box fa-4x mr-2 w3-text-white"></i>
                                            <div class="d-flex flex-column text-right">
                                                <span class="font-weight-bolder font-size-h2">{{ $total_products }}</span>
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total Products</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Stats Widget 12-->
                        </div>
                    @endcan

                    @can('total_users')
                        <div class="col-lg-3 col-xxl-3">
                            <!--begin::Stats Widget 12-->
                            <div class="card card-custom gutter-b dash-count-card w3-teal">
                                <!--begin::Body-->
                                <div class="card-body p-0 ">
                                    <a href="{{ route('admin.user.index') }}" class="dash-click-card">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <i class="icon-xl fas fa-user-tag fa-4x mr-2 w3-text-white"></i>
                                            <div class="d-flex flex-column text-right">
                                                <span class="font-weight-bolder font-size-h2">{{ $total_office_users }}</span>
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total Office
                                                    Users</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Stats Widget 12-->
                        </div>
                    @endcan

                    {{-- @can('total_dealers')
                        <div class="col-lg-3 col-xxl-3">
                            <!--begin::Stats Widget 12-->
                            <div class="card card-custom gutter-b dash-count-card w3-blue-grey">
                                <!--begin::Body-->
                                <div class="card-body p-0 ">
                                    <a href="{{ route('admin.customer.all_dealer') }}" class="dash-click-card">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <i class="icon-xl fas fa-briefcase fa-4x mr-2 w3-text-white"></i>
                                            <div class="d-flex flex-column text-right">
                                                <span class="font-weight-bolder font-size-h2">{{ $total_dealers }}</span>
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total
                                                    Dealers</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Stats Widget 12-->
                        </div>
                    @endcan --}}

                    {{-- @can('total_corporate_consumers')
                        <div class="col-lg-3 col-xxl-3">
                            <!--begin::Stats Widget 12-->
                            <div class="card card-custom gutter-b dash-count-card w3-indigo">
                                <!--begin::Body-->
                                <div class="card-body p-0 ">
                                    <a href="{{ route('admin.customer.all_corporate') }}" class="dash-click-card">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <i class="icon-xl fas fa-user-tie fa-4x mr-2 w3-text-white"></i>
                                            <div class="d-flex flex-column text-right">
                                                <span
                                                    class="font-weight-bolder font-size-h2">{{ $total_corporate_consumers }}</span>
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total Corporate
                                                    Consumers</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Stats Widget 12-->
                        </div>
                    @endcan --}}

                    @can('total_customers')
                        <div class="col-lg-3 col-xxl-3">
                            <!--begin::Stats Widget 12-->
                            <div class="card card-custom gutter-b dash-count-card w3-pink">
                                <!--begin::Body-->
                                <div class="card-body p-0 ">
                                    <a href="{{ route('admin.customer.all_customer') }}" class="dash-click-card">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <i class="icon-xl fas fa-user fa-4x mr-2 w3-text-white"></i>
                                            <div class="d-flex flex-column text-right">
                                                <span class="font-weight-bolder font-size-h2">{{ $total_customers }}</span>
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total
                                                    Customers</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Stats Widget 12-->
                        </div>
                    @endcan

                </div>
                <!--end::row-->
				<div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="p-3">
                                <h3>Low Stock Products</h3>
                            </div>
                            <div class="card-body p-3">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-left">
                                                Product Name
                                            </th>
                                            <th>
                                                Quantity
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($low_stocks as $item)
                                            <tr>
                                                <td class="text-left">
                                                    {{$item->product->name ?? ''}} <br>
                                                    @if ($item->quantity > 0)
                                                        <small>
                                                            @foreach ($item->varientDataInfo as $varient)
                                                                <small class="text-info">
                                                                    {{$varient->varientTypeInfo->name ?? ''}}: {{$varient->data_value}}
                                                                    @if (!$loop->last) , @endif
                                                                </small>
                                                            @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    {{$item->quantity}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="p-3">
                                <h3>Monthly Sells</h3>
                            </div>
                            <div class="card-body p-3">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th class="text-left">
                                                Month
                                            </th>
                                            <th class="text-right">
                                                Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($last_5_months_sells as $sell)
                                            <tr>
                                                <td class="text-left">
                                                    {{$sell->month }}
                                                </td>
                                                <td class="text-right">
                                                    {{$sell->net_amount}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
				</div>
                <!--end::Dashboard-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@endsection
