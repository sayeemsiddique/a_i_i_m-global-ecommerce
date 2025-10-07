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
												<h3 class="card-title">Edit {{ $varienttype->name }}</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.varienttype.update', $varienttype->id)}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf
                                                @method('patch')

												<div class="card-body">

                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Variant type Name *</label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="name" placeholder="Enter Variant type Name" value="{{$varienttype->name}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Status</label>
														<div class="col-lg-5 col-sm-12">
															<select class="form-control select2" name="status" id="status" required>
																@if ($varienttype->status == 1)
																	<option value="1" selected>Active</option>
																	<option value="0">Inactive</option>
																@else
																	<option value="1">Active</option>
																	<option value="0" selected>Inactive</option>
																@endif
															</select>
														</div>
													</div>
												</div>

												<div class="card-footer">
													<div class="row">
														<div class="col-lg-9 text-right">
															<button type="submit" class="btn btn-primary font-weight-bold">Update</button>
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


	@push('stackScript')

	@endpush
					