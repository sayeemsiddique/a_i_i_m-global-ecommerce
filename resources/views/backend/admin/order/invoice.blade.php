@extends('backend.layout.master')

	@section('content')

		<!--begin::Content-->
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
			<!--begin::Subheader-->
			<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
				<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
					<!--begin::Info-->
					<div class="d-flex align-items-center flex-wrap mr-1">
						<!--begin::Page Heading-->
						<div class="d-flex align-items-baseline flex-wrap mr-5">
							<!--begin::Page Title-->
							<h5 class="text-dark font-weight-bold my-1 mr-5">Order Details</h5>
							<!--end::Page Title-->
							<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
								<li class="breadcrumb-item">
									<a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
								</li>

								@can('all_order')
									<li class="breadcrumb-item">
										<a href="{{route('admin.order.index')}}" class="text-muted">All Order</a>
									</li>
								@endcan

								<li class="breadcrumb-item active">
									<a class="text-muted">Order Details</a>
								</li>
							</ul>
							<!--end::Breadcrumb-->
						</div>
						<!--end::Page Heading-->
					</div>
					<!--end::Info-->
				</div>
			</div>
			<!--end::Subheader-->
			<!--begin::Entry-->
			<div class="d-flex flex-column-fluid">
				<!--begin::Container-->
				<div class="container-fluid">
					<!--session msg-->
					@include('alerts.alerts')

					<!--begin::row-->
					<div class="row">
						<div class="col-lg-12">
							<!--begin::Card-->
							<div class="card card-custom">
								<!--begin::Header-->
								<div class="card-header py-3">
									<div class="card-title align-items-start flex-column">
										<h3 class="card-label font-weight-bolder text-dark">Order Details</h3>
									</div>

								</div>
								<!--end::Header-->

								<div class="card-body p-0">
									<!--begin::Order details header section-->
									<div class="container">
										<div class="card card-custom card-shadowless">
											<div class="card-body p-0">
												<div class="row justify-content-center py-8 px-2 px-md-0">

													<div class="col-md-2">
														<div class="d-flex justify-content-between">

															<img class="display-4 font-weight-boldest mb-6 mr-10" height="100%" width="100%" src="{{ asset('storage/setting/' . $setting->logo) }}" alt="">
														</div>
													</div>

													<div class="col-md-7">
														
													</div>

													<div class="col-md-3">
														<span class="pt-10 d-block" style="font-size: 15px;"> {{ $global_setting->title ?? '' }} </span>
														<span class="pt-2 d-block" style="font-size: 15px;"> {{$setting->address ?? ''}} </span>
													</div>

												</div>
											</div>
										</div>
									</div>
									
									<!--begin::Order details, User details-->
									<div class="container mb-5">
										<div class="row">
											<div class="col-md-4">
												<span class="font-weight-bold"><b>Invoice Number:</b> {{ $order->invoice_no = sprintf('%08d', $order->invoice_no) }}</span> <br>
												<span class="font-weight-bold"><b>Invoice Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br> <br>

												<span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
												<span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
												<span class="font-weight-bold"><b>Status:</b>
													@if ($order->stage == 0)
														<span class="badge" style="background: blue;
														color: white;">Pending</span>
													@elseif($order->stage == 1)
														<span class="badge badge-primary">Order Accepted</span>
													@elseif($order->stage == 2)
														<span class="badge badge-danger">Order Declined</span>
													@elseif($order->stage == 3)
														<span class="badge badge-primary">On Delivery</span>
													@elseif($order->stage == 4)
														<span class="badge badge-success">Order Complete</span>
													@elseif($order->stage == 5)
														<span class="badge badge-danger">Order Canceled</span>
													@else
														<span class="badge badge-danger">Unknown Status</span>
													@endif
												</span> <br>

												@if (($order->status == 4) || ($order->stage == 5))
													<span class="font-weight-bold"><b>Order Cancel Reason:</b> {{$order->remark}}</span>
												@endif
												
											</div>

											<div class="col-md-5"></div>

											<div class="col-md-3">
												@if (isset($order->orderUserInfo) && ($order->orderUserInfo->type == 0))
													<span class="d-block" style="font-size: 15px;"><b>User Type :</b> System User</span>
												@elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 1))
													<span class="d-block" style="font-size: 15px;"><b>User Type :</b> Customer</span>
												@elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 2))
													<span class="d-block" style="font-size: 15px;"><b>User Type :</b> Corporate Consumer</span>
												@elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 3))
													<span class="d-block" style="font-size: 15px;"><b>User Type :</b> Dealer</span>
												@endif

												<span class="d-block" style="font-size: 15px;"><b>User Name :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->first_name : ''}} {{ $order->orderUserInfo ? $order->orderUserInfo->last_name : ''}} </span>

												<span class="d-block" style="font-size: 15px;"><b>Email :</b> {{ $order->email ?? 'N/A'}} </span>

												<span class="d-block" style="font-size: 15px;"><b>Cell No. :</b> {{ $order->phone ?? 'N/A'}} </span>

												<span class="d-block" style="font-size: 15px;"><b>Delivery Address :</b> {{ $order->shipping_address ?? 'N/A' }} </span>
											</div>
										</div>
									</div>
									<br> <br>
									
									<!--begin::Order details product list, all cost-->
									<div class="position-relative">

										<!--begin:Table-->
										<div class="container top-0 left-0 right-0">
											<div class="row justify-content-center">
												<div class="col-md-12">
													<div class="card-header p-0">
														<h3 class="card-title mb-3 font-weight-bold">Order Items</h3>
													</div>
													<div class="table-responsive">
														<table class="table table-responseve">
															<thead>
																<tr>
																	<th class="pl-0 font-weight-bold text-muted text-uppercase text-left">Ordered Items</th>
																	<th class="text-right font-weight-bold text-muted text-uppercase">Qty (pcs)</th>
																	<th class="text-right font-weight-bold text-muted text-uppercase">Unit Price</th>
																	<th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
																</tr>
															</thead>
															<tbody>
																@php
																	$subTotal = 0;
																	$totalProductPrice = 0;
																@endphp
																@foreach ($order->orderDetails as $order_detail)
																	<tr class="font-weight-boldest">
																		<td class="border-0 pl-0 pt-7 d-flex align-items-center">
																			{{-- <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
																				<div class="symbol-label" style="background-image: url('{{asset('storage/product')}}/{{$order_detail->productInfo->image ?? ""}}')"></div>
																			</div> --}}
																			{{$order_detail->productInfo->name ?? ''}}
																		</td>
																		<td class="text-right pt-7 align-middle">
																			{{number_format($order_detail->quantity)}}
																		</td>
																		<td class="text-right pt-7 align-middle">
																			{{ number_format($order_detail->price, 2, ".", "") }}
																		</td>
																		<td class="text-primary pr-0 pt-7 text-right align-middle">
																			৳ {{ number_format($subTotal = $order_detail->price * $order_detail->quantity, 2, ".", "") }}
																		</td>
																	</tr>
																	@php
																		$totalProductPrice += $subTotal;
																	@endphp
																@endforeach

																<!--Show sub-total/total product price-->
																<tr>
																	<th class="text-right" colspan="3">Subtotal</th>
																	<th class="text-right">৳ {{ number_format($totalProductPrice, 2, ".", "") }}</th>
																</tr>

																<!--Show user type discount-->
																<tr>
																	@php
																		$userType = $order->user ? $order->user->type : 100;
																	@endphp

																	@if (($userType == 2) || ($userType == 3))
																		<th class="text-right" colspan="3">Discount ({{$order->user_type_discount ?? 0}} %)</th>
																		<th class="text-right">৳ {{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
																	@else
																		<th class="text-right" colspan="3">Discount ({{$order->user_type_discount ?? 0}} %)</th>
																		<th class="text-right">৳ {{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
																	@endif
																</tr>

																<!--Show order amount (1.5 lakh) commission-->
																@if ($order->discount_on_amount == 2)
																	<tr>
																		<th class="text-right" colspan="3">Order Commission ({{ $order->discount_percent_in_total ?? 0 }} %)</th>
																		<th class="text-right">৳ {{ number_format($order->discount_amount_in_total ?? 0, 2, '.', '')}}</th>	
																	</tr>
																@endif

																<!--Show packing charge-->
																<tr>
																	<th class="text-right" colspan="3">Packing Charge ({{$order->packType ? $order->packType->name : 'N/A'}})</th>
																	<th class="text-right">৳ {{ number_format($order->packing_amount ?? 0, 2, '.', '') }}</th>
																</tr>

																<!--Show transportation charge-->
																<tr>
																	{{-- <th class="text-right" colspan="3">Transportation Charge</th> --}}
																	<th class="text-right" colspan="3">Delivery Charge</th>

																	<th class="text-right">৳ {{ number_format($order->courier_cost ?? 0, 2, '.', '') }}</th>
																</tr>
		
																<!--Show total price-->
																<tr style="border-top: 1px solid #000;">
																	<th class="text-right" colspan="3">Total</th>
																	<th class="text-right">৳ {{ number_format($order->grand_total_price, 2, ".", "") }}</th>
																</tr>
																
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										
										<!--begin::Payment info-->
										<div class="container">
											<div class="row justify-content-center pb-10">
												<div class="col-md-12">
													<div class="card-header p-0">
														<h5 class="card-title mb-3 font-weight-bold">Payment Information</h5>
													</div>

													@if ($order->paymentInfo ? $order->paymentInfo->payment_method : 0)

														@if ($order->paymentInfo->payment_method == 1)
															<table class="table">
																<thead>
																	<tr>
																		<th class="font-weight-bold text-muted text-uppercase">Payment Type</th>
																		<th class="font-weight-bold text-muted text-uppercase">Document</th>
																		<th class="font-weight-bold text-muted text-uppercase">Payment Status</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="font-weight-bolder">
																		<td>Bank Payment</td>
																		<td>
																			<a href="{{asset('storage/document/'.$payment->document)}}" download>
																				<i class="las la-file-invoice" style="font-size: 60px; color:blue;"></i>
																			</a>
																		</td>
																		<td>
																			@if ($order->payment_status == 1)
																				<span class="badge badge-success btn-sm">Complete</span>
																			@elseif($order->payment_status == 0)
																				<span class="badge badge-warning btn-sm">Pending</span>
																			@elseif($order->payment_status == 2)
																				<span class="badge badge-danger btn-sm">Failed</span>
																			@else
																				<span class="badge badge-danger btn-sm">Status Error</span>
																			@endif
																		</td>
																	</tr>
																</tbody>
															</table>																	
														@elseif($order->paymentInfo->payment_method == 2)
															<table class="table">
																<thead>
																	<tr>
																		<th class="font-weight-bold text-muted text-uppercase">Payment Type</th>
																		<th class="font-weight-bold text-muted text-uppercase">Sender Number</th>
																		<th class="font-weight-bold text-muted text-uppercase">Receiver Number</th>
																		<th class="font-weight-bold text-muted text-uppercase">Document</th>
																		<th class="font-weight-bold text-muted text-uppercase">Payment Status</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="font-weight-bolder">
																		<td>Mobile Banking</td>
																		<td>{{$payment->mb_sender_no ?? 'N/A'}}</td>
																		<td>{{$payment->mb_receiver_no ?? 'N/A'}}</td>
																		<td>
																			<a href="{{asset('storage/mb_document/'.$payment->mb_document)}}" download>
																				<i class="las la-file-invoice" style="font-size: 60px; color:blue;"></i>
																			</a>
																		</td>
																		<td>
																			@if ($order->payment_status == 1)
																				<span class="badge badge-success btn-sm">Complete</span>
																			@elseif($order->payment_status == 0)
																				<span class="badge badge-warning btn-sm">Pending</span>
																			@elseif($order->payment_status == 2)
																				<span class="badge badge-danger btn-sm">Failed</span>
																			@else
																				<span class="badge badge-danger btn-sm">Status Error</span>
																			@endif
																		</td>
																	</tr>
																</tbody>
															</table>
														@elseif($order->paymentInfo->payment_method == 3)
															<table class="table">
																<thead>
																	<tr>
																		<th class="font-weight-bold text-muted text-uppercase">Payment Type</th>
																		<th class="font-weight-bold text-muted text-uppercase">Payment Status</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="font-weight-bolder">
																		<td>SSL Payment</td>
																		<td>
																			@if ($order->payment_status == 1)
																				<span class="badge badge-success btn-sm">Complete</span>
																			@elseif($order->payment_status == 0)
																				<span class="badge badge-warning btn-sm">Pending</span>
																			@elseif($order->payment_status == 2)
																				<span class="badge badge-danger btn-sm">Failed</span>
																			@else
																				<span class="badge badge-danger btn-sm">Status Error</span>
																			@endif
																		</td>
																	</tr>
																</tbody>
															</table>
														@elseif($order->paymentInfo->payment_method == 5)
															<table class="table">
																<thead>
																	<tr>
																		<th class="font-weight-bold text-muted text-uppercase">Payment Type</th>
																		<th class="font-weight-bold text-muted text-uppercase">Factory/Showroom</th>
																		<th class="font-weight-bold text-muted text-uppercase">Document</th>
																		<th class="font-weight-bold text-muted text-uppercase">Payment Status</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="font-weight-bolder">
																		<td>Cash Payment</td>
																		<td>{{$payment->factory_showroom ?? 'N/A'}}</td>
																		<td>
																			<a href="{{asset('storage/cash_payment_document/'.$payment->cash_payment_document)}}" download>
																				<i class="las la-file-invoice" style="font-size: 60px; color:blue;"></i>
																			</a>
																		</td>
																		<td>
																			@if ($order->payment_status == 1)
																				<span class="badge badge-success btn-sm">Complete</span>
																			@elseif($order->payment_status == 0)
																				<span class="badge badge-warning btn-sm">Pending</span>
																			@elseif($order->payment_status == 2)
																				<span class="badge badge-danger btn-sm">Failed</span>
																			@else
																				<span class="badge badge-danger btn-sm">Status Error</span>
																			@endif
																		</td>
																	</tr>
																</tbody>
															</table>
														@else
															Error on Payment
														@endif

													@endif
													
												</div>
											</div>
										</div>
										
										<!--begin::Buttons-->
										<div class="card-footer printHide">
											<div class="row">
												<div class="col-lg-12 text-right">

													@if (($order->status != 4) || ($order->stage != 5))
														@can('manage_order_status')
															<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#manageOrderStatus">Manage Order Status</button>
														@endcan
													@endif

													<button type="button" class="btn btn-sm btn-primary" onclick="printDiv('printInvoice')">Print Invoice</button>

													@if (($order->stage != 0 || $order->stage != 2 || $order->stage != 5))
														<button type="button" class="btn btn-sm btn-info" onclick="printDiv('printChalanOne')">Chalan (Copy One)</button>
														<button type="button" class="btn btn-sm btn-info" onclick="printDiv('printChalanTwo')">Chalan (Copy Two)</button>
													@endif

													@can('deliver_order')
														@if ($order->status == 1 && $order->delivery_status == 0)
															<a href="{{ route('admin.order.weight_cal', $order->id) }}" class="btn btn-sm btn-primary">Gatepass (Office Copy)</a>

															<a href="{{ route('admin.order.weight_cal', $order->id) }}" class="btn btn-sm btn-primary">Gatepass (Customer Copy)</a>
														@endif
													@endcan

												</div>
											</div>
										</div>

									</div>

									<!--end::Invoice Body-->
									
								</div> {{-- Details tab end --}}
							</div>
							<!--end::Card-->
						</div>
					</div>
					<!--end::row-->
				</div>
				<!--end::Container-->
			</div>
			<!--end::Entry-->
		</div>
		<!--end::Content-->

		<!--Print invoice area-->
		<div id="printInvoice" style="display: none;">

			<!--begin::Invoice header section-->
			<div class="container">
				<div class="card card-custom card-shadowless">
					<div class="card-body p-0">
						<div class="row justify-content-center py-8 px-2 px-md-0">

							<div class="col-md-2">
								<div class="d-flex justify-content-between">

									<img class="display-4 font-weight-boldest mb-6 mr-10"
										height="100%" width="100%"
										src="{{ asset('storage/setting/'.$setting->logo) }}"
										alt="">
								</div>
								{{-- <div class="border-bottom w-100"></div> --}}
							</div>

							<div class="col-md-7"></div>

							<div class="col-md-3">
								<span class="pt-10 d-block" style="font-size: 15px;"> {{ $global_setting->title ?? '' }} </span>
								<span class="pt-2 d-block" style="font-size: 15px;"> {{ $setting->address }} </span>
							</div>


						</div>
					</div>
				</div>
			</div>

			<!--begin::Order details, User details-->
			<div class="container mb-5">
				<div class="row">
					<div class="col-md-4">
						<span class="font-weight-bold"><b>Invoice Number:</b> {{ $order->invoice_no = sprintf('%08d', $order->invoice_no) }}</span> <br>
						<span class="font-weight-bold"><b>Invoice Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br> <br>

						<span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
						<span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
						<span class="font-weight-bold"><b>Status:</b>
							@if ($order->stage == 0)
								Pending
							@elseif($order->stage == 1)
								Order Accepted
							@elseif($order->stage == 2)
								Order Declined
							@elseif($order->stage == 3)
								On Delivery
							@elseif($order->stage == 4)
								Order Complete
							@elseif($order->stage == 5)
								Order Canceled
							@else
								Unknown Status
							@endif
						</span> <br>
						@if (($order->status == 4) || ($order->stage == 5))
							<span class="font-weight-bold"><b>Order Cancel Reason:</b> {{$order->remark}}</span>
						@endif
						
					</div>
					<div class="col-md-5"></div>
					<div class="col-md-3">
						@if (isset($order->orderUserInfo) && ($order->orderUserInfo->type == 0))
							<span class="d-block" style="font-size: 15px;"><b>User Type :</b> System User</span>
						@elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 1))
							<span class="d-block" style="font-size: 15px;"><b>User Type :</b> Customer</span>
						@elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 2))
							<span class="d-block" style="font-size: 15px;"><b>User Type :</b> Corporate Consumer</span>
						@elseif(isset($order->orderUserInfo) && ($order->orderUserInfo->type == 3))
							<span class="d-block" style="font-size: 15px;"><b>User Type :</b> Dealer</span>
						@endif

						<span class="d-block" style="font-size: 15px;"><b>User Name :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->first_name : ''}} {{ $order->orderUserInfo ? $order->orderUserInfo->last_name : ''}} </span>

						<span class="d-block" style="font-size: 15px;"><b>Email :</b> {{ $order->email ?? 'N/A'}} </span>

						<span class="d-block" style="font-size: 15px;"><b>Cell No. :</b> {{ $order->phone ?? 'N/A'}} </span>

						<span class="d-block" style="font-size: 15px;"><b>Delivery Address :</b> {{ $order->shipping_address ?? 'N/A' }} </span>
					</div>
				</div>
			</div>
			<br> <br>

			<!--begin::Order details product list, all cost-->
			<div class="container top-0 left-0 right-0">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<div class="card-header p-0">
							<h3 class="card-title mb-3 font-weight-bold">Order Items</h3>
						</div>
						<div class="table-responsive">
							<table class="table table-responseve">
								<thead>
									<tr>
										<th class="pl-0 font-weight-bold text-muted text-uppercase text-left">Ordered Items</th>
										<th class="text-right font-weight-bold text-muted text-uppercase">Qty (pcs)</th>
										<th class="text-right font-weight-bold text-muted text-uppercase">Unit Price</th>
										<th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
									</tr>
								</thead>
								<tbody>
									@php
										$subTotal = 0;
										$totalProductPrice = 0;
									@endphp
									@foreach ($order->orderDetails as $order_detail)
										<tr class="font-weight-boldest">
											<td class="border-0 pl-0 pt-7 d-flex align-items-center">
												<div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
													<div class="symbol-label" style="background-image: url('{{asset('storage/product')}}/{{$order_detail->productInfo->image ?? ""}}')"></div>
												</div>
												{{$order_detail->productInfo->name ?? ''}}
											</td>
											<td class="text-right pt-7 align-middle">
												{{number_format($order_detail->quantity)}}
											</td>
											<td class="text-right pt-7 align-middle">
												৳ {{ number_format($order_detail->price, 2, ".", "") }}
											</td>
											<td class="text-primary pr-0 pt-7 text-right align-middle">
												৳ {{number_format($subTotal = $order_detail->price * $order_detail->quantity,2,".","")}}
											</td>
										</tr>
										@php
											$totalProductPrice += $subTotal;
										@endphp
									@endforeach

									<!--Show sub-total/total product price-->
									<tr>
										<th class="text-right" colspan="3">Subtotal</th>
										<th class="text-right">৳ {{ number_format($totalProductPrice, 2, ".", "") }}</th>
									</tr>

									<!--Show user type discount-->
									<tr>
										@php
											$userType = $order->user ? $order->user->type : 100;
										@endphp

										@if (($userType == 2) || ($userType == 3))
											<th class="text-right" colspan="3">Discount ({{$order->user_type_discount ?? 0}} %)</th>
											<th class="text-right">৳ {{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
										@else
											<th class="text-right" colspan="3">Discount ({{$order->user_type_discount ?? 0}} %)</th>
											<th class="text-right">৳ {{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
										@endif
									</tr>

									<!--Show order amount (1.5 lakh) commission-->
									@if ($order->discount_on_amount == 2)
										<tr>
											<th class="text-right" colspan="3">Order Commission ({{$order->discount_percent_in_total ?? 0}} %)</th>
											<th class="text-right">৳ {{ number_format($order->discount_amount_in_total ?? 0, 2, '.', '') }}</th>	
										</tr>
									@endif

									<!--Show packing charge-->
									<tr>
										<th class="text-right" colspan="3">Packing Charge ({{$order->packType ? $order->packType->name : 'N/A'}})</th>
										<th class="text-right">৳ {{ number_format($order->packing_amount ?? 0, 2, '.', '') }}</th>
									</tr>

									<!--Show transportation charge-->
									<tr>
										{{-- <th class="text-right" colspan="3">Transportation Charge</th> --}}
										<th class="text-right" colspan="3">Delivery Charge</th>

										<th class="text-right">৳ {{ number_format($order->courier_cost ?? 0, 2, '.', '') }}</th>
									</tr>

									<!--Show total price-->
									
									<tr style="border-top: 1px solid #000;">
										<th class="text-right" colspan="3">Total</th>
										<th class="text-right">৳ {{ number_format($order->grand_total_price?? 0, 2, ".", "") }}</th>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/Print invoice area-->

		<!--Print chalan one area-->
		<div id="printChalanOne" class="container" style="display: none;">
			<div class="card card-custom m-9">
				<div class="card-header mt-5" style="border-bottom: 1px solid #fff">
					
					<div class="col-md-6 offset-md-3 text-center mt-4" style="line-height: 100%">
						<h3>চালান পত্র</h3>
						<p class="font-weight-bold">[বিধি ৪০ এর উপ-বিধি (১) এর দফা (গ) ও দফা (চ) দ্রষ্টব্য]</p>
					</div>
					<div class="col-md-3">
						<p class="font-weight-bold text-right">প্রথম কপি</p>
						<p class="font-weight-bold text-right">মূসক-৬.৩</p>
					</div>
				</div>
				<div class="card-body" style="padding-top: 0px;">

					<div class="row">
						<div class="col-md-9">
							<table>
								<tr>
									<th>ব্যবসা প্রতিষ্ঠানের নাম : </th>
									<td>বাংলাদেশ ইনসুলেটর এন্ড স্যানিটারীওয়্যার লিঃ</td>
								</tr>
								<tr>
									<th>ঠিকানা : </th>
									<td>বক্স নগর, মিরপুর, ঢাকা।</td>
								</tr>
								<tr>
									<th>করদাতা সনাক্তকরণ সংখ্যা :</th>
									<td>৭৫১৫৩৫৮৮৩৬৪৫</td>
								</tr>
								<tr>
									<th>ক্রেতার নাম :</th>
									<td>{{ $order->orderUserInfo ? $order->orderUserInfo->first_name : ''}} {{ $order->orderUserInfo ? $order->orderUserInfo->last_name : ''}}</td>
								</tr>
								<tr>
									<th>ঠিকানা :</th>
									<td>{{ $order->orderUserInfo ? $order->orderUserInfo->present_address : '' }}</td>
								</tr>
								<tr>
									<th>করদাতা বিআইএন :</th>
									<td>০০০০০২৯২৬-০০০২</td>
								</tr>
								<tr>
									<th>পণ্যের চূড়ান্ত গন্তব্য স্থল :</th>
									<td>{{ $order->orderUserInfo ? $order->orderUserInfo->present_address : '' }}</td>
								</tr>
								<tr>
									<th>যানবাহনের প্রকৃতি এবং নম্বর :</th>
									<td></td>
								</tr>
							</table>
						</div>
						<div class="col-md-3">
							<table>
								<tr>
									<th>চালান পত্রের নম্বর :</th>
									<td>{{ $order->invoice_no = sprintf('%08d', $order->invoice_no) }}</td>
								</tr>
								<tr>
									<th>ইস্যুর তারিখ :</th>
									<td>{{date('d M Y')}}</td>
								</tr>
								<tr>
									<th>ইস্যুর সময় :</th>
									<td>{{date('h:i:s')}}</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="table-responsive ajax-data-container pt-3">
						<table class="table">
							<thead>
								<tr>
									<th style="border: 1px solid #000" align="moddle">ক্রমিক <br> নং</th>
									<th style="border: 1px solid #000" align="moddle">পণ্য বা <br> সেবার বর্ণনা <br> (প্রযোজ্য ক্ষেত্রে <br> ব্রান্ড নামসহ)</th>
									<th style="border: 1px solid #000" align="moddle">সরবরাহের <br> একক</th>
									<th style="border: 1px solid #000" align="moddle">পরিমাণ</th>
									<th style="border: 1px solid #000" align="moddle">একক <br> মূল্য <br> (টাকায়)</th>
									<th style="border: 1px solid #000" align="moddle">মোট <br> মূল্য <br>(টাকায়)</th>
									<th style="border: 1px solid #000" align="moddle">সম্পূরক <br> শুল্কের <br> পরিমাণ <br> (টাকায়)</th>
									<th style="border: 1px solid #000" align="moddle">মূল্য সংযোজন <br> করের হার / <br> সুনির্দিষ্ট কর</th>
									<th style="border: 1px solid #000" align="moddle">মূল্য <br> সংযোজন কর / <br> সুনির্দিষ্ট করের <br> পরিমাণ (টাকায়)</th>
									<th style="border: 1px solid #000" align="moddle">সকল প্রকার <br> শুল্ক ও করসহ <br> মূল্য</th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = 1;
									$qty = 0;
									$singlePrice = 0;
									$totalQtyPrice = 0;
									$allProductPrice = 0;
									$productSdValue = 0;
									$productVatValue = 0;
									
								@endphp
								@foreach ($order->orderDetails as $od)

									<tr>
										<td style="border: 1px solid #000" align="middle">{{$i}}</td>
										<td style="border: 1px solid #000" align="middle">{{$od->productInfo ? $od->productInfo->name : 'N/A'}}</td>
										<td style="border: 1px solid #000" align="middle">
											{{-- @if (!isset($od->productInfo) || (empty($od->productInfo->unit) || ($od->productInfo->unit == NULL)))
												Pcs
											@elseif(isset($od->productInfo) && ($od->productInfo->unit == 1))
												KG
											@elseif(isset($od->productInfo) && ($od->productInfo->unit == 2))
												MT
											@endif --}}
											
											pcs
										</td>
										<td style="border: 1px solid #000" align="middle">{{$qty = $od->quantity ?? 0}}</td>

										@if ($od->productInfo->has_varient == 1)
											<td style="border: 1px solid #000" align="middle">{{ $singlePrice = $od->varient->price ?? 0 }}</td>
										@else
											<td style="border: 1px solid #000" align="middle">{{ $singlePrice = $od->productInfo->price ?? 0 }}</td>
										@endif

										<td style="border: 1px solid #000" align="middle">{{ $totalQtyPrice = $qty * $singlePrice }}</td>

										@php
											// store all product price
											$allProductPrice += $totalQtyPrice;
										@endphp

										<td style="border: 1px solid #000" align="middle">
											{{-- Display Only SD value of product --}}
											@if(empty($od->productInfo->sd) || ($od->productInfo->sd == NULL) || !isset($od->productInfo->sd))
												0.00
											@else
												{{$productSdValue = ($totalQtyPrice * $od->productInfo->sd)/100}}
											@endif

											@php
											// store product price include sd value
												$productWithSdPrice = $totalQtyPrice + $productSdValue;
											@endphp
										</td>

										<td style="border: 1px solid #000" align="middle">
											@if (!isset($od->productInfo) || (empty($od->productInfo->vat) || ($od->productInfo->vat == NULL)))
												0.00
											@else
												{{$od->productInfo->vat.' %'}}
											@endif
										</td>

										<td style="border: 1px solid #000" align="middle">
											{{-- Display Only VAT of product (product + sd value) --}}
											@if (empty($od->productInfo->vat) || $od->productInfo->vat == NULL || !isset($od->productInfo))
												0.00
											@else
												{{$productVatValue = ($productWithSdPrice * $od->productInfo->vat)/100}}
											@endif
											
											@php
											// store product price include sd value include vat value
												$productWithSdPriceVatPrice = ($productWithSdPrice + $productVatValue) * $qty;
											@endphp
										</td>

										<!--<td style="border: 1px solid #000" align="middle">{{ $productWithSdPriceVatPrice }}</td>-->
										<td style="border: 1px solid #000" align="middle">{{$singlePrice = $od->price * $qty}}</td>
									</tr>

									@php
										$i++;
									@endphp

								@endforeach
									{{-- <tr>
										<th colspan="9" class="text-right">উপ-মোট মূল্য:</th>
										<th class="text-right">{{number_format($allProductPrice ?? 0, 2, '.', '')}}</th>
									</tr>

									<tr>
										@php
											$userType = $order->user ? $order->user->type : 100;
										@endphp

										@if (($userType == 2) || ($userType == 3))
											<th class="text-right" colspan="9">ছাড় ({{$order->user_type_discount ?? 0}} %)</th>
											<th class="text-right">{{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
										@else
											<th class="text-right" colspan="9">ছাড় ({{$order->user_type_discount ?? 0}} %)</th>
											<th class="text-right">{{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
										@endif
									</tr>

									@if ($order->discount_on_amount == 2)
										<tr>
											<th class="text-right" colspan="9">ক্রয় কমিশন ({{ $order->discount_percent_in_total ?? 0 }} %)</th>
											<th class="text-right">{{ number_format($order->discount_amount_in_total ?? 0, 2, '.', '')}}</th>	
										</tr>
									@endif

									<tr>
										<th class="text-right" colspan="9">প্যাকিং চার্জ ({{$order->packType ? $order->packType->name : 'N/A'}})</th>
										<th class="text-right">{{ number_format($order->packing_amount ?? 0, 2, '.', '') }}</th>
									</tr>

									<tr>
										<th class="text-right" colspan="9">পরিবহন খরচ</th>
										<th class="text-right">{{ number_format($order->courier_cost ?? 0, 2, '.', '') }}</th>
									</tr>

									<tr style="border-top: 1px solid #000;">
										<th class="text-right" colspan="9">মোট মূল্য</th>
										<th class="text-right">{{ number_format($order->grand_total_price, 2, ".", "") }}</th>
									</tr> --}}
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-8">
							<p>প্রতিষ্ঠান কতৃপক্ষের দায়িত্বপ্রাপ্ত ব্যক্তির নাম : <span></span> </p>
							<p>পদবি : <span></span> </p>
							<p>স্বাক্ষর : <span></span> </p>
							<p>সীল : <span></span> </p>
							<p>উৎসে কর্তনযোগ্য সরবরাহের ক্ষেত্রে ফরমটি সমন্বিত কর চালানপত্র ও উৎসে কর কর্তন সনদপত্র হিসেবে বিবেচিত হইবে এবং উহা উৎসে কর কর্তনযোগ্য সরবরাহের ক্ষেত্রে প্রযোজ্য হবে।</p>
							<br><br><br>
							<p>{{$allProductPrice.' TK' ?? 'Undefined Product Price, SD or VAT'}}</p>
							<p><span style="border-top: 1px solid #000"><b>সকল প্রকার কর ব্যতীত মূল্য</b></span></p>
						</div>
						
						<div class="col-md-4 text-right mt-40">
							<p>প্রস্তুতকারক</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/Print chalan one area-->

		<!--Print chalan two area -->
		<div id="printChalanTwo" class="container" style="display: none;">
			<div class="card card-custom m-9">
				<div class="card-header mt-5" style="border-bottom: 1px solid #fff">
					
					<div class="col-md-6 offset-md-3 text-center mt-4" style="line-height: 100%">
						<h3>চালান পত্র</h3>
						<p class="font-weight-bold">[বিধি ৪০ এর উপ-বিধি (১) এর দফা (গ) ও দফা (চ) দ্রষ্টব্য]</p>
					</div>
					<div class="col-md-3">
						<p class="font-weight-bold text-right">দ্বিতীয় কপি</p>
						<p class="font-weight-bold text-right">মূসক-৬.৩</p>
					</div>
				</div>
				<div class="card-body" style="padding-top: 0px;">

					<div class="row">
						<div class="col-md-9">
							<table>
								<tr>
									<th>ব্যবসা প্রতিষ্ঠানের নাম : </th>
									<td>বাংলাদেশ ইনসুলেটর এন্ড স্যানিটারীওয়্যার লিঃ</td>
								</tr>
								<tr>
									<th>ঠিকানা : </th>
									<td>বক্স নগর, মিরপুর, ঢাকা।</td>
								</tr>
								<tr>
									<th>করদাতা সনাক্তকরণ সংখ্যা :</th>
									<td>৭৫১৫৩৫৮৮৩৬৪৫</td>
								</tr>
								<tr>
									<th>ক্রেতার নাম :</th>
									<td>{{ $order->orderUserInfo ? $order->orderUserInfo->first_name : ''}} {{ $order->orderUserInfo ? $order->orderUserInfo->last_name : ''}}</td>
								</tr>
								<tr>
									<th>ঠিকানা :</th>
									<td>{{ $order->orderUserInfo ? $order->orderUserInfo->present_address : '' }}</td>
								</tr>
								<tr>
									<th>করদাতা বিআইএন :</th>
									<td>০০০০০২৯২৬-০০০২</td>
								</tr>
								<tr>
									<th>পণ্যের চূড়ান্ত গন্তব্য স্থল :</th>
									<td>{{ $order->orderUserInfo ? $order->orderUserInfo->present_address : '' }}</td>
								</tr>
								<tr>
									<th>যানবাহনের প্রকৃতি এবং নম্বর :</th>
									<td></td>
								</tr>
							</table>
						</div>
						<div class="col-md-3">
							<table>
								<tr>
									<th>চালান পত্রের নম্বর :</th>
									<td>{{ $order->invoice_no = sprintf('%08d', $order->invoice_no) }}</td>
								</tr>
								<tr>
									<th>ইস্যুর তারিখ :</th>
									<td>{{date('d M Y')}}</td>
								</tr>
								<tr>
									<th>ইস্যুর সময় :</th>
									<td>{{date('h:i:s')}}</td>
								</tr>
							</table>
						</div>
					</div>

					<div class="table-responsive ajax-data-container pt-3">
						<table class="table">
							<thead>
								<tr>
									<th style="border: 1px solid #000" align="moddle">ক্রমিক <br> নং</th>
									<th style="border: 1px solid #000" align="moddle">পণ্য বা <br> সেবার বর্ণনা <br> (প্রযোজ্য ক্ষেত্রে <br> ব্রান্ড নামসহ)</th>
									<th style="border: 1px solid #000" align="moddle">সরবরাহের <br> একক</th>
									<th style="border: 1px solid #000" align="moddle">পরিমাণ</th>
									<th style="border: 1px solid #000" align="moddle">একক <br> মূল্য <br> (টাকায়)</th>
									<th style="border: 1px solid #000" align="moddle">মোট <br> মূল্য <br>(টাকায়)</th>
									<th style="border: 1px solid #000" align="moddle">সম্পূরক <br> শুল্কের <br> পরিমাণ <br> (টাকায়)</th>
									<th style="border: 1px solid #000" align="moddle">মূল্য সংযোজন <br> করের হার / <br> সুনির্দিষ্ট কর</th>
									<th style="border: 1px solid #000" align="moddle">মূল্য <br> সংযোজন কর / <br> সুনির্দিষ্ট করের <br> পরিমাণ (টাকায়)</th>
									<th style="border: 1px solid #000" align="moddle">সকল প্রকার <br> শুল্ক ও করসহ <br> মূল্য</th>
								</tr>
							</thead>
							<tbody>
								@php
									$i = 1;
									$qty = 0;
									$singlePrice = 0;
									$totalQtyPrice = 0;
									$allProductPrice = 0;
									$productSdValue = 0;
									$productVatValue = 0;
									
								@endphp
								@foreach ($order->orderDetails as $od)
									<tr>
										<td style="border: 1px solid #000" align="middle">{{$i}}</td>
										<td style="border: 1px solid #000" align="middle">{{$od->productInfo ? $od->productInfo->name : 'N/A'}}</td>
										<td style="border: 1px solid #000" align="middle">
											{{-- @if (!isset($od->productInfo) || (empty($od->productInfo->unit) || ($od->productInfo->unit == NULL)))
												Pcs
											@elseif(isset($od->productInfo) && ($od->productInfo->unit == 1))
												KG
											@elseif(isset($od->productInfo) && ($od->productInfo->unit == 2))
												MT
											@endif --}}
											pcs
										</td>
										<td style="border: 1px solid #000" align="middle">{{$qty = $od->quantity ?? 0}}</td>
										@if ($od->productInfo->has_varient == 1)
											<td style="border: 1px solid #000" align="middle">{{$singlePrice = $od->productInfo->varient->price ?? 0}}</td>
										@else
											<td style="border: 1px solid #000" align="middle">{{$singlePrice = $od->productInfo->price ?? 0}}</td>
										@endif
										<td style="border: 1px solid #000" align="middle">{{$totalQtyPrice = $qty * $singlePrice}}</td>
										@php
											// store all product price
											$allProductPrice += $totalQtyPrice;
										@endphp
										<td style="border: 1px solid #000" align="middle">
											{{-- Display Only SD value of product --}}
											@if(empty($od->productInfo->sd) || ($od->productInfo->sd == NULL) || !isset($od->productInfo->sd))
												0.00
											@else
												{{$productSdValue = ($totalQtyPrice * $od->productInfo->sd)/100}}
											@endif
											@php
											// store product price include sd value
												$productWithSdPrice = $totalQtyPrice + $productSdValue;
											@endphp
										</td>
										<td style="border: 1px solid #000" align="middle">
											@if (!isset($od->productInfo) || (empty($od->productInfo->vat) || ($od->productInfo->vat == NULL)))
												0.00
											@else
												{{$od->productInfo->vat.' %'}}
											@endif
										</td>
										<td style="border: 1px solid #000" align="middle">
											{{-- Display Only VAT of product (product + sd value) --}}
											@if (empty($od->productInfo->vat) || $od->productInfo->vat == NULL || !isset($od->productInfo))
												0.00
											@else
												{{$productVatValue = ($productWithSdPrice * $od->productInfo->vat)/100}}
											@endif
											@php
											// store product price include sd value include vat value
												$productWithSdPriceVatPrice = $productWithSdPrice + $productVatValue;
											@endphp
										</td>
										{{-- <td style="border: 1px solid #000" align="middle">{{ $productWithSdPriceVatPrice }}</td> --}}
										<td style="border: 1px solid #000" align="middle">{{$singlePrice = $od->price * $qty}}</td>
									</tr>
									@php
										$i++;
									@endphp
								@endforeach
									{{-- <tr>
										<th colspan="9" class="text-right">উপ-মোট মূল্য:</th>
										<th class="text-right">{{number_format($allProductPrice ?? 0, 2, '.', '')}}</th>
									</tr>

									<tr>
										@php
											$userType = $order->user ? $order->user->type : 100;
										@endphp

										@if (($userType == 2) || ($userType == 3))
											<th class="text-right" colspan="9">ছাড় ({{$order->user_type_discount ?? 0}} %)</th>
											<th class="text-right">{{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
										@else
											<th class="text-right" colspan="9">ছাড় ({{$order->user_type_discount ?? 0}} %)</th>
											<th class="text-right">{{ number_format($order->discount_amount ?? 0, 2, '.', '') }}</th>
										@endif
									</tr>

									@if ($order->discount_on_amount == 2)
										<tr>
											<th class="text-right" colspan="9">ক্রয় কমিশন ({{ $order->discount_percent_in_total ?? 0 }} %)</th>
											<th class="text-right">{{ number_format($order->discount_amount_in_total ?? 0, 2, '.', '')}}</th>	
										</tr>
									@endif

									<tr>
										<th class="text-right" colspan="9">প্যাকিং চার্জ ({{$order->packType ? $order->packType->name : 'N/A'}})</th>
										<th class="text-right">{{ number_format($order->packing_amount ?? 0, 2, '.', '') }}</th>
									</tr>

									<tr>
										<th class="text-right" colspan="9">পরিবহন খরচ</th>
										<th class="text-right">{{ number_format($order->courier_cost ?? 0, 2, '.', '') }}</th>
									</tr>

									<tr style="border-top: 1px solid #000;">
										<th class="text-right" colspan="9">মোট মূল্য</th>
										<th class="text-right">{{ number_format($order->grand_total_price, 2, ".", "") }}</th>
									</tr> --}}
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-8">
							<p>প্রতিষ্ঠান কতৃপক্ষের দায়িত্বপ্রাপ্ত ব্যক্তির নাম : <span></span> </p>
							<p>পদবি : <span></span> </p>
							<p>স্বাক্ষর : <span></span> </p>
							<p>সীল : <span></span> </p>
							<p>উৎসে কর্তনযোগ্য সরবরাহের ক্ষেত্রে ফরমটি সমন্বিত কর চালানপত্র ও উৎসে কর কর্তন সনদপত্র হিসেবে বিবেচিত হইবে এবং উহা উৎসে কর কর্তনযোগ্য সরবরাহের ক্ষেত্রে প্রযোজ্য হবে।</p>
							<br><br><br>
							<p>{{$allProductPrice.' TK' ?? 'Undefined Product Price, SD or VAT'}}</p>
							<p><span style="border-top: 1px solid #000"><b>সকল প্রকার কর ব্যতীত মূল্য</b></span></p>
						</div>
						
						<div class="col-md-4 text-right mt-40">
							<p>প্রস্তুতকারক</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/Print chalan two area -->

		{{-- Update status modal --}}
		<div class="modal fade" id="manageOrderStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Order Status</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>
				<div class="modal-body">
					<form action="{{route('admin.order.orderStatusUpdate')}}" method="POST">
						@csrf
						{{-- Hidden file --}}
						<input type="hidden" name="orderId" value="{{$order->id}}" required>

						<div class="form-group row">
						  
							@if(($order->stage === NULL))
								<label for="stage" class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-8">
									<select class="form-control" id="stage" name="stage" required>
										<option value="0" selected>Pending</option>
									</select>
								</div>
							@elseif ($order->stage == 0)
								<label for="stage" class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-8">
									<select class="form-control" id="stage" name="stage" required>
										<option value="0" selected>Pending</option>
										<option value="1">Payment Approve / Order Accept</option>
										<option value="2">Payment Reject / Order Decline</option>
									</select>
								</div>
							@elseif ($order->stage == 1)
								<label for="stage" class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-8">
									<select class="form-control" id="stage" name="stage" required>
										<option value="1" selected>Payment Approve / Order Accept</option>
										<option value="0">Pending</option>
										<option value="2">Payment Reject / Order Decline</option>
										<option value="3">On Delivery</option>
									</select>
								</div>
							@elseif($order->stage == 2)
								<label for="stage" class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-8">
									<select class="form-control" id="stage" name="stage" required>
										<option value="2" selected>Payment Reject / Order Decline</option>
										<option value="0">Pending</option>
										<option value="1">Payment Approve / Order Accept</option>
										<option value="3">On Delivery</option>
										<option value="4">Delivered / Order Complete</option>
									</select>
								</div>
							@elseif($order->stage == 3)
								<label for="stage" class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-8">
									<select class="form-control" id="stage" name="stage" required>
										<option value="3" selected>On Delivery</option>
										<option value="0">Pending</option>
										<option value="2">Payment Reject / Order Decline</option>
										<option value="4">Delivered / Order Complete</option>
									</select>
								</div>
							@elseif($order->stage == 4)
								<label for="stage" class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-8">
									<select class="form-control" id="stage" name="stage" required>
										<option value="4" selected>Delivered / Order Complete</option>
										<option value="0">Pending</option>
										<option value="1">Payment Approve / Order Accept</option>
										<option value="2">Payment Reject / Order Decline</option>
										<option value="3">On Delivery</option>
									</select>
								</div>
							@else
								<label for="stage" class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-8">
									<select class="form-control" id="stage" name="stage" required>
										<option value="0" selected>Pending</option>
									</select>
								</div>
							@endif
							
						</div>

						<div class="form-group row delivery_date_div" style="display: none;"> 
							<label for="stage" class="col-sm-4 col-form-label">Delivery Date:<span class="text-danger">*</span></label>

							<div class="col-sm-8">
								<input type="date" class="form-control" name="delivery_date" id="delivery_date">
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-8">
								<button type="submit" class="btn btn-success float-right">Update</button>
							</div>
							<div class="col-sm-4">
								<button type="button" class="btn btn-danger float-left" data-dismiss="modal">Close</button>
							</div>
						</div>

					</form>
				</div>
				<div class="modal-footer">
				{{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button> --}}
				</div>
			</div>
			</div>
		</div>

	@endsection

	@push('stackScript')
		<script>
			function printDiv(divName) {
				var printContents = document.getElementById(divName).innerHTML;
				var originalContents = document.body.innerHTML;

				document.body.innerHTML = printContents;

				window.print();

				document.body.innerHTML = originalContents;
			}
		</script>
	@endpush