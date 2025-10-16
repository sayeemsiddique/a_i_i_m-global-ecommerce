<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<meta charset="utf-8" />
		<title>{{ $global_setting->title ?? '' }} | Dashboard</title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('storage/setting') }}/{{ $global_setting->logo ?? '' }}">

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
		<!--end::Fonts-->

		@include('backend.partials.css')
		<!--end::Layout Themes-->

		<style>
			@media  print {
				#noprintbtn {
				display: none;
				}
			}
		</style>

		<style>
			.unread_counter {
				background: #c46622;
				margin-top: -22px;
				padding: 0 6px;
				border-radius: 10px;
				font-size: 15px;
				color: white;
				font-weight: bolder;
				margin-left: -5px;
			}


			.checkbox.checkbox-light-success > span {
				background-color: #fdfdfd;
				border: 1px solid #0b0a0a;
			}
			.checkbox.checkbox-light-success > input:checked ~ span {
				background-color: #0b0a0a;
			}

			.btn-xsm {
				padding: 3px 10px;
			}

			.image-input .image-input-wrapper {
				background-position: center;
			}

			.btn.btn-clean:not(:disabled):not(.disabled).active, .btn.btn-clean:not(:disabled):not(.disabled):active:not(.btn-text), .show .btn.btn-clean.btn-dropdown, .show>.btn.btn-clean.dropdown-toggle {
				background-color: #6D3CBB;
			}

            .header {
                background: #0A50A0 !important;
            }

		</style>

		<style>
			@media only screen and (max-width: 768px) {
				#kt_content {
					margin-left: 0px;
				}
			}
		</style>

		@stack('css')

		<link rel="shortcut icon" href="{{ asset('storage/setting/' . $global_setting->logo) }}" />
	</head>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

		<div class="bbs-loader-wrapper" id="loader-1">
			<div id="loader"></div>
		</div>

		<!--begin::Main-->
		<!--begin::Header Mobile-->
		<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
			<!--begin::Logo-->
			<a href="{{ route('index') }}">
				<img style="height: 52px;" alt="Logo" src="{{ asset('storage/setting/' . $global_setting->logo) }}" />
			</a>
			<!--end::Logo-->
			<!--begin::Toolbar-->
			<div class="d-flex align-items-center">
				<!--begin::Aside Mobile Toggle-->
				<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
					<span></span>
				</button>
				<!--end::Aside Mobile Toggle-->
				<!--begin::Header Menu Mobile Toggle-->
				<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
					<span></span>
				</button>
				<!--end::Header Menu Mobile Toggle-->
				<!--begin::Topbar Mobile Toggle-->
				<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
					<span class="svg-icon svg-icon-xl">
						<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<polygon points="0 0 24 0 24 24 0 24" />
								<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
								<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
							</g>
						</svg>
						<!--end::Svg Icon-->
					</span>
				</button>
				<!--end::Topbar Mobile Toggle-->
			</div>
			<!--end::Toolbar-->
		</div>
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">

				<!--begin::Aside-->
				@include('customer.partials.sidebar')
				<!--end::Aside-->

				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">
						<!--begin::Container-->
						<div class="container-fluid d-flex align-items-stretch justify-content-between">
							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
								<!--begin::Header Menu-->
								<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
									<!--begin::Header Nav-->
									<ul class="menu-nav">
										<li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active">
											<a href="{{ route('admin.index') }}" class="">

												<span><h2>Dashboard</h2></span>
												<i class="menu-arrow"></i>
											</a>
										</li>
									</ul>
									<!--end::Header Nav-->
								</div>
								<!--end::Header Menu-->
							</div>
							<!--end::Header Menu Wrapper-->
							<!--begin::Topbar-->
							<div class="topbar">
								<!--begin::Search-->
								{{-- <div class="dropdown" id="kt_quick_search_toggle">
									<!--begin::Toggle-->
									<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
										<div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
											<span class="svg-icon svg-icon-xl svg-icon-primary">
												<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24" />
														<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
														<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
													</g>
												</svg>
												<!--end::Svg Icon-->
											</span>
										</div>
									</div>
									<!--end::Toggle-->
									<!--begin::Dropdown-->
									<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
										<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
											<!--begin:Form-->
											<form method="get" class="quick-search-form">
												<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text">
															<span class="svg-icon svg-icon-lg">
																<!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
																<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																	<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																		<rect x="0" y="0" width="24" height="24" />
																		<path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																		<path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
																	</g>
																</svg>
																<!--end::Svg Icon-->
															</span>
														</span>
													</div>
													<input type="text" class="form-control" placeholder="Search..." />
													<div class="input-group-append">
														<span class="input-group-text">
															<i class="quick-search-close ki ki-close icon-sm text-muted"></i>
														</span>
													</div>
												</div>
											</form>
											<!--end::Form-->
											<!--begin::Scroll-->
											<div class="quick-search-wrapper scroll" data-scroll="true" data-height="325" data-mobile-height="200"></div>
											<!--end::Scroll-->
										</div>
									</div>
									<!--end::Dropdown-->
								</div> --}}
								<!--end::Search-->
								<!--begin::Notifications-->
								@php
									$user = Auth::user();
									$unread  = \App\Models\Notify::where('status', 1)->latest()->get();
									$totalCount = count($unread);
								@endphp

								@can('notification', $user)

									<div class="dropdown">

										<!--begin::Toggle-->
										<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
											<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
												<i class="fa fa-2x fa-bell" style="color: #FF9800"></i>

												@if ($totalCount > 0)
													<span style="color:white; font-weight: bold; margin-bottom: 25px; background: red; height: 23px; width: 20px; text-align: center; border-radius: 10px;">{{$totalCount}}</span>
												@else
													<span style="color:white; font-weight: bold; margin-bottom: 25px; background: green; height: 23px; width: 20px; text-align: center; border-radius: 10px;">0</span>
												@endif
											</div>
										</div>
										<!--end::Toggle-->
										<!--begin::Dropdown-->
										<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
											<form>
												<!--begin::Header-->
												<div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url({{ asset('assets/media/misc/bg-1.jpg') }})">
													<!--begin::Title-->
													<h4 class="d-flex flex-center rounded-top">
														<span class="text-white">All Notifications</span>
														@if ($totalCount > 0)
															<span class="btn btn-text btn-danger btn-sm font-weight-bold btn-font-md ml-2">{{ $totalCount }}</span>
														@else
															<span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">0</span>
														@endif
													</h4>
													<!--end::Title-->

												</div>
												<!--end::Header-->
												<!--begin::Content-->
												<div class="tab-content">
													<!--begin::Tabpane-->
													<div class="tab-pane active show" role="tabpanel">

														<!--begin::Nav-->
														<div class="navi navi-hover scroll" data-scroll="true" data-height="330" data-mobile-height="200">
															@if (count($unread) > 0)

																{{-- Get all New notifications --}}
																@foreach ($unread as $ur)

																	<!--begin::Item-->
																	<a href="{{route('notificationRedirect', [$ur->id, $ur->type])}}" class="navi-item goNotification" style="background: #EBF9CF">
																		<div class="navi-link">
																			<div class="navi-icon mr-2">
																				<i class="flaticon2-notification text-primary"></i>
																			</div>

																			<div class="navi-text mr-2">

																				<div class="font-weight-bold">
																					{{ $ur->data }}
																				</div>
																				<div class="text-muted">{{ date('d M, Y h:i a', strtotime($ur->created_at)) }}</div>
																			</div>

																			<button class="navi-icon d-inline-block" style="background: none; border: none;"  onclick="notificationMarkAsRead({{ $ur->id }})">
																				<i class="fa fa-times text-danger"></i>
																			</button>
																		</div>
																	</a>
																	<!--end::Item-->

																@endforeach
															@else
																<!--begin::Nav-->
																<div class="d-flex flex-center text-center text-muted min-h-200px">All caught up!
																	<br />No new notifications.
																</div>
																<!--end::Nav-->
															@endif
														</div>
														<!--end::Nav-->
													</div>
													<!--end::Tabpane-->

													<!--end::Tabpane-->
												</div>
												<!--end::Content-->
											</form>
										</div>
										<!--end::Dropdown-->
									</div>
									<!--end::Notifications-->
								@endcan

								<div class="topbar-item">
									<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										{{-- <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span> --}}
										<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ ucfirst( Auth::user()->first_name) }}</span>
										<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
											<span class="symbol-label font-size-h5 font-weight-bold">{{ ucfirst(substr(Auth::user()->username, 0, 1)) }}</span>
										</span>
									</div>
								</div>
								<!--end::User-->
							</div>
							<!--end::Topbar-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Header-->
