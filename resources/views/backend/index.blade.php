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

                    @can('total_complete_orders')
                        <div class="col-lg-3 col-xxl-3">
                            <!--begin::Stats Widget 12-->
                            <div class="card card-custom gutter-b dash-count-card w3-green">
                                <!--begin::Body-->
                                <div class="card-body p-0 ">
                                    <a href="{{ route('admin.order.completed_list') }}" class="dash-click-card">
                                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                            <i class="icon-xl fas fa-check-circle fa-4x mr-2 w3-text-white"></i>
                                            <div class="d-flex flex-column text-right">
                                                <span
                                                    class="font-weight-bolder font-size-h2">{{ $total_complete_orders }}</span>
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total Complete
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
                                                <span class="font-weight-bolder font-size-h6 mt-2 w3-text-white">Total Finish
                                                    Products</span>
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
					@can('total_online_money_earn')
						<div class="col-md-6">
							<!--begin::Mixed Widget 14-->
							<div class="card card-custom card-stretch gutter-b">
								<!--begin::Header-->
								<div class="card-header">
									<div class="card-title">
										<a href="{{ route('admin.salesReport.index') }}"><h3 class="card-label">Today's Total Sales (Online)</h3></a>
									</div>
								</div>
								<!--end::Header-->
								<!--begin::Body-->
								<div class="card-body d-flex flex-column">
									<div class="flex-grow-1">
										<div id="kt_mixed_widget_141_chart" style="height: 215px"
											data-value="{{ $totalOnlineMoney ? number_format((float) $totalOnlineMoney, 2, '.', '') : '0' }}">
										</div>
									</div>
								</div>
								<!--end::Body-->
							</div>
							<!--end::Mixed Widget 14-->
						</div>
					@endcan

					{{-- @can('total_money_earn_pos')
						<div class="col-lg-6">
							<!--begin::Mixed Widget 14-->
							<div class="card card-custom card-stretch gutter-b">
								<!--begin::Header-->
								<div class="card-header">
									<div class="card-title">
										<a href="{{ route('admin.pos.orderList') }}"><h3 class="card-label">Today's Total Sales (Sale Center)</h3></a>
									</div>
								</div>
								<div class="card-body d-flex flex-column">
									<div class="flex-grow-1">
										<div id="kt_mixed_widget_14_chart" style="height: 215px" data-value="{{ $totalPosMoney ? number_format((float)$totalPosMoney, 2, '.', '') : '0'}}"></div>
									</div>
								</div>
							</div>
						</div>
					@endcan --}}
				</div>
                <!--end::Dashboard-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->
@endsection
