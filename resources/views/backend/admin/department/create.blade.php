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
												<h3 class="card-title">Add New Department</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.department.store')}}" method="post" id="kt_form_1">
												@csrf

												<div class="card-body">
                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="name" placeholder="Enter Department Name" value="{{old('name')}}" required/>
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
					