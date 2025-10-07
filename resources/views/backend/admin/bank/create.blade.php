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
												<h3 class="card-title">Add New Bank Account</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.bank.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf

												<div class="card-body">

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Bank Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<select name="name" id="name" class="form-control select2"> 
																<option value="">--Select Bank--</option>
																<option value="Agrani Bank Limited">Agrani Bank Limited</option>
																<option value="Bangladesh Development Bank">Bangladesh Development Bank</option>
																<option value="BASIC Bank Limited">BASIC Bank Limited</option>
																<option value="Janata Bank Limited">Janata Bank Limited</option>
																<option value="Rupali Bank Limited">Rupali Bank Limited</option>
																<option value="Sonali Bank Limited">Sonali Bank Limited</option>
																<option value="Uttora Bank Limited">Uttora Bank Limited</option>
															</select>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Branch Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="branch_name" placeholder="Enter Branch Name" value="{{old('branch_name')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Account No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="account_no" placeholder="Enter Account No." value="{{old('account_no')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Routing No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="routing_no" placeholder="Enter Routing No." value="{{old('routing_no')}}" required/>
														</div>
													</div>
												</div>

												<div class="card-footer">
													<div class="row">
														<div class="col-lg-9 text-right">
															<button type="submit" class="btn btn-primary font-weight-bold" name="submitButton">Save</button>
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
					