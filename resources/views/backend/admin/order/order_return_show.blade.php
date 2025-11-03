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
										<h3 class="card-label font-weight-bolder text-dark">Returned Order Details</h3>
									</div>

                                    <div class="d-flex align-items-center">
                                        <a target="_blank" class="btn btn-primary font-weight-bold" href="{{route('admin.order.show', Crypt::encryptString($orderReturn->order_id))}}">
                                            View Main Order
                                        </a>
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

															<img class="display-4 font-weight-boldest mb-6 mr-10" height="100%" width="100%" src="{{ asset('storage/setting/' . $global_setting->logo) }}" alt="">
														</div>
													</div>

													<div class="col-md-7">

													</div>

													<div class="col-md-3">
														<span class="pt-10 d-block" style="font-size: 15px;"> {{ $global_setting->title ?? '' }} </span>
														<span class="pt-2 d-block" style="font-size: 15px;"> {{$global_setting->address ?? ''}} </span>
													</div>

												</div>
											</div>
										</div>
									</div>

									<!--begin::Order details, User details-->
									<div class="container-fluid mb-5">
										<div class="row">
											<div class="col-md-4">
												<span class="font-weight-bold"><b>Invoice Number:</b> {{ $orderReturn->invoice_no }}</span> <br>
												{{-- <span class="font-weight-bold"><b>Invoice Date:</b> {{ date('d-M-Y', strtotime($orderReturn->created_at)) }}</span> <br> <br> --}}

												<span class="font-weight-bold"><b>Order ID:</b> {{ $orderReturn->tracking_code ?? 'N/A' }}</span> <br>
												<span class="font-weight-bold"><b>Order Date:</b> {{ date('d-M-Y', strtotime($orderReturn->created_at)) }}</span> <br>
												<span class="font-weight-bold">
                                                    <b>Status:</b>
                                                    @foreach (returnOrderStatus() as $key => $order_status)
														@if($orderReturn->status == $key) <span class="badge badge-info">{{$order_status}}</span> @endif
													@endforeach
                                                </span><br>

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
														<table class="table table-bordered table-striped">
															<thead>
																<tr>
																	<th class="text-left">Item Name</th>
																	<th class="text-right">Price</th>
																	<th class="text-right">Quantity (pcs)</th>
																	<th class="text-right">Amount</th>
																</tr>
															</thead>

															<tbody>
																@php
																	$subTotal = 0;
																	$totalProductPrice = 0;
																@endphp
																@foreach ($orderReturn->orderDetails as $order_detail)
																	<tr>
																		<td class="text-left">
																			{{ $order_detail->productInfo->name ?? '' }} <br>
                                                                            @if ($order_detail->varient_id > 0)
                                                                                @foreach ($order_detail->varientDataInfo as $varient)
                                                                                    <small class="text-info">
                                                                                        {{$varient->varientTypeInfo->name ?? ''}}: {{$varient->data_value}}
                                                                                        @if (!$loop->last) , @endif
                                                                                    </small>
                                                                                @endforeach
                                                                            @endif
																		</td>

																		<td class="text-right">
																			{{ number_format($order_detail->price, 2, ".", "") }}
																		</td>

																		<td class="text-right">
																			{{ number_format($order_detail->quantity) }}
																		</td>

																		@php
																			$sub_total = $order_detail->price * $order_detail->quantity;
																		@endphp

																		<td class="text-primary pt-7 text-right align-middle">
																			৳ {{ number_format($sub_total, 2, ".", "") }}
																		</td>
																	</tr>

																	@php
																		$totalProductPrice += $sub_total;
																	@endphp
																@endforeach

																<!--Show sub-total/total product price-->
																<tr>
																	<th class="text-right" colspan="3">Total</th>
																	<th class="text-right">৳ {{ number_format($totalProductPrice, 2, ".", "") }}</th>
																</tr>

															</tbody>
														</table>
													</div>
												</div>
                                                <div class="col-md-12 mt-5">
                                                    @can('manage_order_status')
                                                        <button type="button" class="btn btn-sm btn-success mb-4" data-toggle="modal" data-target="#manageOrderStatus">Manage Order Status</button>

                                                        <div class="modal fade" id="manageOrderStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLongTitle">Order Status</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('admin.order.returnOrderStatusUpdate')}}" method="POST">
                                                                        @csrf
                                                                        {{-- Hidden file --}}
                                                                        <input type="hidden" name="orderId" value="{{$orderReturn->id}}" required>

                                                                        <div class="form-group">

                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th class="text-left">Product Name</th>
                                                                                        <th>Return Quantity</th>
                                                                                        <th>Return to Stock</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($orderReturn->orderDetails as $orderDetail)
                                                                                        <tr>
                                                                                            <td class="text-left">{{ $orderDetail->productInfo->name ?? '' }}</td>
                                                                                            <td>{{ number_format($orderDetail->quantity) }}</td>
                                                                                            <td>
                                                                                                <input autocomplete="off" type="checkbox" @if($orderDetail->stock_status == 1) checked @endif name="return_to_stock[{{$orderDetail->id}}]" value="1">
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>

                                                                        </div>
                                                                        <div class="form-group row">

                                                                            <label for="status" class="col-sm-4 col-form-label">Order Status</label>
                                                                            <div class="col-sm-8">
                                                                                <select autocomplete="off" class="form-control" id="status" name="status" required>
                                                                                    <option value="">Select</option>
                                                                                    @foreach (returnOrderStatus() as $key => $order_status)
                                                                                        <option @if($orderReturn->status == $key) selected @endif value="{{$key}}">{{$order_status}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <small>'Return to Stock' only acceptable when status: Order Accept </small>
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group row">

                                                                            <label for="payment_status" class="col-sm-4 col-form-label">Payment Status</label>
                                                                            <div class="col-sm-8">
                                                                                <select autocomplete="off" class="form-control" id="payment_status" name="payment_status" required>
                                                                                    <option value="">Select</option>
                                                                                    @foreach(returnPaymentStatus() as $key => $payment_status)
                                                                                        <option @if(($orderReturn->paymentInfo->status ?? 0) == $key) selected @endif value="{{$key}}">{{$payment_status}}</option>
                                                                                    @endforeach
                                                                                </select>
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
                                                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
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
