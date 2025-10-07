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
												<h3 class="card-title">Edit Variant Value</h3>
											</div>
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.varient_value.update', $varient_value->id)}}" method="post" id="kt_form_1">
												@csrf
                                                @method('patch')

												<div class="card-body">
													
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Variant Type: <span class="text-danger">*</span></label>
														
														<div class="col-lg-5 col-sm-12">
															<select name="varient_type_id" id="varient_type_id" class="form-control"> 
																<option value="">--Select Variant Type--</option>
																
																@foreach ($varient_types as $varient_type)
																	<option value="{{ $varient_type->id }}" {{ $varient_type->id == $varient_value->varient_type_id ? 'selected' : '' }}>{{  $varient_type->name }}</option>
																@endforeach
															</select>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Variant Value: <span class="text-danger">*</span></label>

														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="value" value="{{ $varient_value->value }}"/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Status</label>
														<div class="col-lg-5 col-sm-12">
															<select class="form-control select2" name="status" id="status" required>
																@if ($varient_value->status == 1)
																	<option value="1" selected>Active</option>
																	<option value="0">Deactive</option>
																@else
																	<option value="1">Active</option>
																	<option value="0" selected>Deactive</option>
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
					