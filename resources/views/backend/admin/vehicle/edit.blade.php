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
												<h3 class="card-title">Edit Vehicle</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.vehicle.update', $vehicle->id)}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf
                                                @method('patch')

												<div class="card-body">

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle Type: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<select name="type" id="type" class="form-control" required> 
																@if ($vehicle->type == 1)
																	<option value="1" selected>Van</option>
																	<option value="2">Truck</option>
																	<option value="3">Pickup</option>
																@elseif ($vehicle->type == 2)
																	<option value="1">Van</option>
																	<option value="2" selected>Truck</option>
																	<option value="3">Pickup</option>
																@else
																	<option value="1">Van</option>
																	<option value="2">Truck</option>
																	<option value="3" selected>Pickup</option>
																@endif
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="vehicle_no" value="{{$vehicle->vehicle_no}}" required/>
														</div>
													</div>
                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="name" value="{{$vehicle->name}}" required/>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle Weight: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="weight" value="{{$vehicle->weight}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Plate No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="plate_no" value="{{$vehicle->plate_no}}" required/>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">License No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="license_no" value="{{$vehicle->license_no}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">License Image: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<img src="{{ asset('storage/license/' . $vehicle->license) }}" alt="License" style="max-width: 80px;">
														</div>
													</div>

													<input type="hidden" name="license" value="{{$vehicle->license}}">

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Enter New License Image: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="file" class="form-control" name="new_license" accept="jpg, png, jpeg"/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Status</label>
														<div class="col-lg-5 col-sm-12">
															<select class="form-control select2" name="status" id="status" required>
																@if ($vehicle->status == 1)
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
					