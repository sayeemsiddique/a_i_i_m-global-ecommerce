@extends('backend.layout.master')

	@section('content')
		<!--begin::Content-->
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
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
									<div class="container-fluid">
										<div class="card card-custom card-shadowless">
											<div class="card-body p-0">
												<div class="row justify-content-center py-8 px-2 px-md-0">

													<div class="col-md-2">
														<div class="d-flex justify-content-between">

															<img class="display-4 font-weight-boldest mb-6 mr-10"  width="150px" src="{{ asset('storage/setting/' . $global_setting->logo) }}" alt="">
														</div>
													</div>

													<div class="col-md-7">
														
													</div>

													<div class="col-md-3">
														<span class="d-block" style="font-size: 15px;"> {{ $global_setting->title ?? '' }} </span>
														<span class="pt-2 d-block" style="font-size: 15px;"> {{ $global_setting->address ?? ''}} </span>
													</div>

												</div>
											</div>
										</div>
									</div>
									
									<!--begin::Order details, User details-->
									<div class="container-fluid mb-5">
										<div class="row">
											<div class="col-md-4">
												
												<span class="font-weight-bold"><b>Invoice Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br> <br>

												<span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
												<span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
												@if ($order->document)
												<span class="font-weight-bold"><b>Order Document:</b> <a download="" href="{{ asset('storage/document') }}/{{$order->document}}">Download</a></span>
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

											</div>
										</div>
									</div>
									<br> <br>
									
									<!--begin::Order details product list, all cost-->
									<div class="position-relative">

										<!--begin:Table-->
										<div class="container-fluid top-0 left-0 right-0">
											<div class="row justify-content-center">
												<div class="col-md-12">
													<div class="card-header p-0">
														<h3 class="card-title mb-3 font-weight-bold">Order Items</h3>
													</div>
													<div class="table-responsive">
														<table class="table table-bordered table-sm table-responseve">
															<thead>
																<tr>
																	<th class="font-weight-bold text-muted text-uppercase text-left">Item Name</th>
																	
																	
																	<th class="text-right font-weight-bold text-muted text-uppercase">Quantity (pcs)</th>
																	{{-- <th class="text-right font-weight-bold text-muted text-uppercase">Weight (M.T)</th> --}}
																	
																</tr>
															</thead>

															<tbody>
																@php
																	$subTotal = 0;
																@endphp
																@foreach ($order->orderDetails as $order_detail)
																	<tr class="font-weight-boldest">
																		<td class="text-left">
																			{{-- <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
																				<div class="symbol-label" style="background-image: url('{{asset('storage/product')}}/{{$order_detail->productInfo->image ?? ""}}')"></div>
																			</div> --}}
																			{{ $order_detail->productInfo->name ?? '' }} </br>
																			@if ($order_detail->varient_id > 0)
																				<span class="text-success">
																					<small>
																						
																							{{ $order_detail->varientDataInfo->varientTypeInfo->name ?? '' }}: {{ $order_detail->varientDataInfo->data_value ?? '' }}
																					</small>
																				</span>
																			@endif
																		</td>
																		
																		<td class="text-right align-middle">
																			{{ number_format($order_detail->quantity) }}
																		</td>
																		
																		{{-- <td class="text-right align-middle">
																			@if ($order_detail->weight and $order_detail->unit)
																				@if ($order_detail->unit == 1)
																					{{number_format((($order_detail->quantity * $order_detail->weight)),2,'.','')}} KG
																				@elseif ($order_detail->unit == 2)
																					{{number_format(($order_detail->quantity * $order_detail->weight),2,'.','')}} M.T
																				@endif
																			@endif
																		</td> --}}

																		

																		
																	</tr>

																@endforeach


																
																
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
										
										
										
										<!--begin::Buttons-->
										<div class="card-footer printHide border-0">
											<div class="row">
												<div class="col-lg-12 text-right">


													<button type="button" class="btn btn-sm btn-primary" onclick="printDiv('printInvoice')">Print Invoice</button>



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
								<img class="" width="150px" src="{{ asset('storage/setting/' . $global_setting->logo) }}" alt="">
							</div>

							<div class="col-md-7"></div>

							<div class="col-md-3">
								<span class="d-block" style="font-size: 15px;"> {{ $global_setting->title ?? '' }} </span>
								<span class="pt-2 d-block" style="font-size: 15px;"> {{ $global_setting->address }} </span>
							</div>


						</div>
					</div>
				</div>
			</div>

			<!--begin::Order details, User details-->
			<div class="container mb-5">
				<div class="row">
					<div class="col-md-4">
						
						<span class="font-weight-bold"><b>Invoice Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br> <br>

						<span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
						<span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
						
						
					</div>
					<div class="col-md-5"></div>
					<div class="col-md-3">
						
					</div>
				</div>
			</div>
			
			<br> <br>

			<!--begin::Order details product list, all cost-->
			<div class="container top-0 left-0 right-0">
				<div class="row justify-content-center">
					<div class="col-md-12">
						<div class="card-header p-0">
							<h3 class="card-title mb-3 font-weight-bold" style="padding: 0 .75rem">Order Items</h3>
						</div>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th class="font-weight-bold text-muted text-uppercase text-left" style="padding: 0 .75rem">Item Name</th>
										
										
										<th class="text-right font-weight-bold text-muted text-uppercase" style="padding: 0 .75rem">Quantity (pcs)</th>
										<th class="text-right font-weight-bold text-muted text-uppercase" style="padding: 0 .75rem">Weight</th>
										
									</tr>
								</thead>

								<tbody>
									@php
										$subTotal = 0;
									@endphp

									@foreach ($order->orderDetails as $order_detail)
										<tr class="font-weight-boldest">
											<td class="pt-7 d-flex align-items-center">
												{{-- <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">
													<div class="symbol-label" style="background-image: url('{{asset('storage/product')}}/{{$order_detail->productInfo->image ?? ""}}')"></div>
												</div> --}}
												{{ $order_detail->productInfo->name ?? '' }}
											</td>

											
											<td class="text-right pt-7 align-middle">
												{{ number_format($order_detail->quantity) }}
											</td>
											<td class="text-right pt-7 align-middle">
												@if ($order_detail->weight and $order_detail->unit)
													@if ($order_detail->unit == 1)
														{{number_format((($order_detail->quantity * $order_detail->weight)),2,'.','')}} KG
													@elseif ($order_detail->unit == 2)
														{{number_format(($order_detail->quantity * $order_detail->weight),2,'.','')}} M.T
													@endif
												@endif
											</td>
											
										</tr>

										
									@endforeach

									


									@if ($order->other_categories_amount > 0)
									<tr>
										<th class="text-right" colspan="6">Other Charge</th>

										<th class="text-right">৳ {{ number_format($order->other_categories_amount ?? 0, 2, '.', '') }}</th>
									</tr>
									@endif

								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!--/Print invoice area-->
		

	@endsection

	@push('stackScript')
		<script>
			function printDiv(divName) {
				var printContents = document.getElementById(divName).innerHTML;
				var originalContents = document.body.innerHTML;

				document.body.innerHTML = printContents;

				window.print();
				location.reload();
				// document.body.innerHTML = originalContents;
			}
		</script>

		<script> 
			$('#stage').on('change', function() {
				let stage = $('#stage').val();

				if(stage == 1) {
					$('.delivery_date_div').show();
					$('#delivery_date').attr('required', 'required');
				} else {
					$('.delivery_date_div').hide();
					$('#delivery_date').removeAttr('required');
				}
			});
		</script>
	@endpush