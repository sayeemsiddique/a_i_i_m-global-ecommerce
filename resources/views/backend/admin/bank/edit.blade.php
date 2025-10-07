@extends('backend.layout.master')

	@section('content')
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						
						<!--end::Subheader-->
						<!--begin::Entry-->
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container-fluid">
								<!--session msg-->
								@include('alerts.alerts')

								<!--begin::Card-->
								<div class="row">
									<div class="col-lg-12">
										<!--begin::Card-->
										<div class="card card-custom example example-compact">
											<div class="card-header">
												<h3 class="card-title">Edit Bank Account</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.bank.update', $bank->id)}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf
                                                @method('patch')

												<div class="card-body">
													
                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Bank Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="name" value="{{$bank->name}}" readonly/>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Branch Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="branch_name" value="{{$bank->branch_name}}"/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Account No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="account_no" value="{{$bank->account_no}}" required/>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Routing No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="routing_no" value="{{$bank->routing_no}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Status</label>
														<div class="col-lg-5 col-sm-12">
															<select class="form-control select2" name="status" id="status" required>
																@if ($bank->status == 1)
																	<option value="1" selected>Active</option>
																	<option value="0">Deactivated</option>
																@else
																	<option value="1">Active</option>
																	<option value="0" selected>Deactivated</option>
																@endif
															</select>
														</div>
													</div>
												</div>

												<div class="card-footer">
													<div class="row">
														<div class="col-lg-9 text-right">
															<button type="submit" class="btn btn-primary font-weight-bold" name="submitButton">Update</button>
														</div>
													</div>
												</div>
											</form>
											<!--end::Form-->
										</div>
										<!--end::Card-->
									</div>
								</div>
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
	@endsection
					