@extends('backend.layout.master')

	@section('content')
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						
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
												<h3 class="card-title">Add New Vehicle</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.vehicle.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf

												<div class="card-body">

                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle Type: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<select name="type" id="type" class="form-control" required> 
																<option value="">--Select Vehicle Type--</option>
																<option value="1">Van</option>
																<option value="2">Truck</option>
																<option value="3">Pickup</option>
															</select>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="vehicle_no" placeholder="Enter Vehicle No." value="{{old('vehicle_no')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="name" placeholder="Enter Vehicle Name" value="{{old('name')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle Weight (In Metric Ton): <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="number" step="0.01" class="form-control" name="weight" placeholder="Enter Vehicle Weight (In Metric Ton)" value="{{old('weight')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Plate No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="plate_no" placeholder="Enter Plate N0." value="{{old('plate_no')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle License No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="license_no" placeholder="Enter Vehicle License N0." value="{{old('license_no')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">License Image: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="file" class="form-control" name="license" accept="jpg, png, jpeg" required/>
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
					