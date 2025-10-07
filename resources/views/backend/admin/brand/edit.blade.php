@extends('backend.layout.master')

	@section('content')
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						
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
												<h3 class="card-title">Edit {{ $brand->name }}</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.brand.update', $brand->id)}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf
                                                @method('patch')

												<div class="card-body">

                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Brand Name *</label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="name" placeholder="Enter Brand Name" value="{{$brand->name}}" required/>
														</div>
													</div>

                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Description: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<textarea placeholder="Description" class="form-control summernote" name="description" id="" cols="30" rows="10">{{$brand->description}}</textarea>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">
															<img style="width: 50px" src="{{asset('storage/brand')}}/{{$brand->image}}" alt="">
															Image:
														</label>
														<div class="col-lg-5 col-sm-12">
															<input type="file" class="form-control" name="image" placeholder="Enter Image"/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">
															<img style="width: 50px" src="{{asset('storage/brand')}}/{{$brand->banner}}" alt="">
															Banner:</label>
														<div class="col-lg-5 col-sm-12">
															<input type="file" class="form-control" name="banner" placeholder="Enter Banner"/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Status</label>
														<div class="col-lg-5 col-sm-12">
															<select class="form-control select2" name="status" id="status" required>
																@if ($brand->status == 1)
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
	<script src="assets/js/pages/crud/forms/editors/summernote.js"></script>
	<script>
		$(document).ready(function() {
			$('.summernote').summernote({
				height: 200,
			});
		});
	</script>
	@endpush
					