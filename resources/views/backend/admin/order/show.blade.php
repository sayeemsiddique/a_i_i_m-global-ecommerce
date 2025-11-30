@extends('backend.layout.master')

@push('css')
	<style>
		@media only screen and (max-width: 768px) {
			.card-footer.printHide .col-lg-12 {
				text-align: center !important;
			}

			.card-footer.printHide .col-lg-12 button, .card-footer.printHide .col-lg-12 a {
				width: 100%;
				margin-bottom: 8px;
			}

			#kt_content {
				margin-left: 0px;
			}
		}
	</style>
@endpush


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
								<div class="card-header py-3 d-block">
									<div class="card-title d-block">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <h3 class="card-label font-weight-bolder text-dark">Order Details</h3>
                                            </div>
                                            <div class="">
                                                <span id="exportPdfBtn" class="btn btn-bordered border-info btn-sm">Download Invoice</span>
                                            </div>
                                        </div>

									</div>

								</div>
								<!--end::Header-->

								<div class="card-body order-details-section">
									<!--begin::Order details header section-->

										<div class="card card-custom card-shadowless">
											<div class="card-body p-0">
												<div class="row justify-content-center py-8 px-2 px-md-0">

													<div class="col-md-2">
														<div class="d-flex justify-content-between">
															<img class="display-4 font-weight-boldest mb-6 mr-10" height="100%" width="100%" style="max-width: 100px;" src="{{ asset('storage/setting/' . $global_setting->logo) }}" alt="">
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


									<!--begin::Order details, User details-->

										<div class="row">
											<div class="col-md-4">
												<span class="font-weight-bold"><b>Invoice Number:</b> {{ sprintf('%08d', $order->salePaymentInfo->id ?? 0) }}</span> <br>
												{{-- <span class="font-weight-bold"><b>Invoice Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br> <br> --}}

												<span class="font-weight-bold"><b>Order ID:</b> {{ $order->tracking_code }}</span> <br>
												<span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($order->created_at)) }}</span> <br>
												{{-- <span class="font-weight-bold"><b>Status:</b>
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
												</span> <br> --}}

												{{-- @if (($order->status == 4) || ($order->stage == 5))
													<span class="font-weight-bold"><b>Order Cancel Reason:</b> {{$order->remark}}</span>
												@endif --}}


													<label class="">Order Status:</label>
													@foreach (orderStatus() as $key => $order_status)
														@if($order->status == $key) {{$order_status}} @endif
													@endforeach


												<br/>



													<label class="">Delivery Status:</label>
													@foreach(deliveryStatus() as $key => $delivery_status)
														@if($order->delivery_status == $key) {{$delivery_status}} @endif
													@endforeach


												<br/>



													<label class="">Payment Status:</label>
													@foreach(paymentStatus() as $key => $payment_status)
														@if(($order->paymentInfo->status ?? 0) == $key) {{$payment_status}} @endif
													@endforeach

                                                <br/>




                                                    @if (count($order->orderReturnInfos->where('status',1)) > 0)
                                                    <label class="">Return Status:</label>
                                                        <a href="{{route('admin.order.order_return_list')}}?main_order_id={{$order->tracking_code}}" target="_blank" rel="noopener noreferrer">
                                                            Check Return Status
                                                        </a>
                                                    @endif


											</div>

											<div class="col-md-5"></div>

											<div class="col-md-3">

												<span class="d-block" style="font-size: 15px;"><b>User Name :</b> {{ $order->orderUserInfo ? $order->orderUserInfo->first_name : ''}} {{ $order->orderUserInfo ? $order->orderUserInfo->last_name : ''}} </span>

												<span class="d-block" style="font-size: 15px;"><b>Email :</b> {{ $order->orderUserInfo->email ?? ''}} </span>

												<span class="d-block" style="font-size: 15px;"><b>Mobile :</b> {{ $order->orderUserInfo->mobile ?? ''}} </span>

												<span class="d-block" style="font-size: 15px;"><b>Delivery Address :</b>  </span>
												Recipient name: {{ $order->shippingAddressInfo->recipient_name ?? '' }} <br/>
												Recipient Mobile: {{ $order->shippingAddressInfo->phone_no ?? '' }} <br/>
												Recipient Address: {{ $order->shippingAddressInfo->address ?? '' }}, {{ $order->shippingAddressInfo->upazilaInfo->name ?? '' }}, {{ $order->shippingAddressInfo->districtInfo->name ?? '' }}, {{ $order->shippingAddressInfo->divisionInfo->name ?? '' }}

                                                @if ($order->store_id > 0)
                                                <br>
                                                    <label class="">
                                                        <strong>Store Pickup Location:</strong>
                                                    </label>
                                                    <p class="mb-0">{{ $order->storeInfo->name ?? '' }} </p>
                                                    <p class="mb-0">{{ $order->storeInfo->divisionInfo->name ?? ''}}, {{ $order->storeInfo->districtInfo->name ?? ''}}, {{ $order->storeInfo->upazilaInfo->name ?? ''}}</p>
                                                    <p class="mb-0">{{ $order->storeInfo->address }}</p>
                                                <br/>
                                                @endif

											</div>
										</div>


										<!--begin:Table-->
										<div class="top-0 left-0 right-0">
											<div class="row justify-content-center">
												<div class="col-md-12">
													<div class="card-header p-0">
														<h3 class="card-title mb-3 font-weight-bold">Order Items</h3>
													</div>
													<div class="table-responsive">
														<table class="table table-responseve">
															<thead>
																<tr>
																	<th class="pl-0 font-weight-bold text-muted text-uppercase text-left">Item Name</th>
																	<th class="text-right font-weight-bold text-muted text-uppercase">Quantity (pcs)</th>
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
																		<td class="pl-0 pt-7 text-left">
																			{{ $order_detail->productInfo->name ?? '' }} <br/>
																			@if ($order_detail->varient_id > 0)
																				<span class="text-success">
																					<small>
																							{{ $order_detail->varientDataInfo->varientTypeInfo->name ?? '' }}: {{ $order_detail->varientDataInfo->data_value ?? '' }}
																					</small>
																				</span>
																			@endif
																		</td>

																		<td class="text-right pt-7 align-middle">
																			{{ number_format($order_detail->quantity) }}
																		</td>

																		@php
																			$sub_total = $order_detail->price * $order_detail->quantity;
																		@endphp

																		<td class="text-primary pt-7 text-right align-middle">
																			{{$global_setting->currency ?? ""}} {{ number_format($sub_total, 0, ".", "") }}
																		</td>
																	</tr>

																	@php
																		$totalProductPrice += $sub_total;
																	@endphp
																@endforeach

																<!--Show sub-total/total product price-->

																<tr>
																	<th class="text-right" colspan="2">Subtotal</th>
																	<th class="text-right">{{$global_setting->currency ?? ""}} {{ number_format($order->total_price, 0, ".", "") }}</th>
																</tr>
                                                                @if ($order->voucher_id > 0 and $order->voucher_discount > 0)
                                                                    <tr>
                                                                        <td colspan="2" class="text-right"><strong>Voucher Discount</strong></td>
                                                                        <td colspan="1" class="text-right">{{$global_setting->currency ?? ""}} {{ number_format($order->voucher_discount, 0, '.', '') }}</td>
                                                                    </tr>
                                                                @endif

																<tr>
																	<th class="text-right" colspan="2">Shipping Cost</th>
																	<th class="text-right">{{$global_setting->currency ?? ""}} {{ number_format($order->shipping_cost, 0, ".", "") }}</th>
																</tr>



																<!--Show total price-->
																<tr style="border-top: 1px solid #000;">
																	<th class="text-right" colspan="2">Total</th>
																	<th class="text-right">{{$global_setting->currency ?? ""}} {{ number_format($order->grand_total_price, 0, ".", "") }}</th>
																</tr>

															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>

										<!--begin::Buttons-->
										<div class="card-footer printHide">
											<div class="row">
												<div class="col-lg-6 text-left">
                                                    @if($order->status == 2)
                                                        <span class="text-danger font-weight-bold">
                                                            Decline Reason: {{ $order->remark ?? '' }}
                                                        </span>
                                                    @endif
                                                </div>
												<div class="col-lg-6 text-right">



													@if (($order->status != 2))
														@can('manage_order_status')
															<button type="button" class="btn btn-sm btn-success mb-4" data-toggle="modal" data-target="#manageOrderStatus">Manage Order Status</button>
														@endcan
													@endif

													{{-- <button type="button" class="btn btn-sm btn-primary mb-4" onclick="printDiv('printInvoice','invoice_{{$order->tracking_code}}')">Print Invoice</button> --}}

												</div>
											</div>
										</div>



									<!--end::Invoice Body-->

								</div> {{-- Details tab end --}}

                                <div class="invoice_box-section" style="display:none;">
                                    <div id="element-to-print">
                                        @include('backend.admin.order.invoice_template', ['order' => $order, 'user' => $order->orderUserInfo])
                                    </div>
                                </div>

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


		<!--/Print chalan one area-->

		<!--Print chalan two area -->

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

							<label for="stage" class="col-sm-4 col-form-label">Order Status</label>
							<div class="col-sm-8">
								<select class="form-control" id="stage" name="stage" required>
									<option value="">Select</option>
									@foreach (orderStatus() as $key => $order_status)
										<option @if($order->status == $key) selected @endif value="{{$key}}">{{$order_status}}</option>
									@endforeach
								</select>
							</div>

						</div>

						<div class="form-group row">

							<label for="delivery_status" class="col-sm-4 col-form-label">Delivery Status</label>
							<div class="col-sm-8">
								<select class="form-control" id="delivery_status" name="delivery_status" required>
									<option value="">Select</option>
									@foreach(deliveryStatus() as $key => $delivery_status)
										<option @if($order->delivery_status == $key) selected @endif value="{{$key}}">{{$delivery_status}}</option>
									@endforeach
								</select>
							</div>

						</div>

						<div class="form-group row">

							<label for="payment_status" class="col-sm-4 col-form-label">Payment Status</label>
							<div class="col-sm-8">
								<select class="form-control" id="payment_status" name="payment_status" required>
									<option value="">Select</option>
									@foreach(paymentStatus() as $key => $payment_status)
										<option @if(($order->paymentInfo->status ?? 0) == $key) selected @endif value="{{$key}}">{{$payment_status}}</option>
									@endforeach
								</select>
							</div>

						</div>

						<div class="form-group row delivery_date_div" style="display: none;">
							<label for="stage" class="col-sm-4 col-form-label">Delivery Date:<span class="text-danger">*</span></label>

							<div class="col-sm-8">
								<input type="date" class="form-control" name="delivery_date" id="delivery_date">
							</div>
						</div>

						<div class="row">
							<div class="col-8">
								<button type="submit" class="btn btn-success">Update</button>
							</div>
							<div class="col-4">
								<button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
							</div>
						</div>

					</form>
				</div>
				<div class="modal-footer">

				</div>
			</div>
			</div>
		</div>

	@endsection

	@push('stackScript')
    <script src="https://unpkg.com/easyqrcodejs@4.6.0/dist/easy.qrcode.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

		<script>
			function printDiv(divName,title_name) {
				document.title = title_name;
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

				if(stage == 3) {
					$('.delivery_date_div').show();
					$('#delivery_date').attr('required', 'required');
				} else {
					$('.delivery_date_div').hide();
					$('#delivery_date').removeAttr('required');
				}
			});
		</script>

        <script>
            document.getElementById('exportPdfBtn').addEventListener('click', function() {
                $('.order-details-section').hide();
                $('.invoice_box-section').show();
                var element = document.getElementById('element-to-print');
                var opt = {
                    filename:     'order-{{$order->tracking_code}}.pdf',
                };
                html2pdf(element,opt);
                $('.order-details-section').show();
                $('.invoice_box-section').hide();
            });

let options = {
        text: "{{ route('getOrderTrack') }}?tracking_code={{$order->tracking_code}}&mobile={{$order->orderUserInfo->mobile ?? ''}}",
        width: 120,
        height: 120,
        colorDark: "#000000",
        colorLight: "#ffffff",
    };
    new QRCode(document.getElementById("qrcode"), options);
        </script>
	@endpush

