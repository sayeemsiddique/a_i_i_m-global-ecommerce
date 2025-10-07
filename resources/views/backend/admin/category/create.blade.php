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
												<h3 class="card-title">Add New Category</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.category.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf

												{{-- <input type="hidden" name="parent_id" value="0"> --}}

												<div class="card-body">
                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="name" placeholder="Enter Category Name" value="{{old('name')}}" required/>
														</div>
													</div>
                                                    {{-- <input type="hidden" name="parent_id" value="0" id=""> --}}
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Parent Category:</label>
														<div class="col-lg-5 col-sm-12">
															<select class="form-control" name="parent_id">
																<option value="0">Select</option>
																@foreach ($categories as $category)
																	<option value="{{$category->id}}">{{$category->name}}</option>
																@endforeach
																
															</select>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Description: <span class="text-danger"></span></label>
														<div class="col-lg-5 col-sm-12">
															<textarea placeholder="Description" class="form-control summernote" name="description" id="" cols="30" rows="10"></textarea>
														</div>
													</div>

                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Image:</label>
														<div class="col-lg-5 col-sm-12">
															<input type="file" class="form-control" name="image" placeholder="Enter Image"/>
														</div>
													</div>
                                                    
													{{-- <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Banner:</label>
														<div class="col-lg-5 col-sm-12">
															<input type="file" class="form-control" name="banner" placeholder="Enter Banner"/>
														</div>
													</div> --}}
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Serial:</label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="sl" placeholder="Enter Category serial" value="{{old('sl')}}"/>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Status:</label>
														<div class="col-lg-5 col-sm-12">
															<span class="switch">
																<label>
																	<input type="checkbox" name="status" checked value="1" />
																	<span></span>
																</label>
															</span>
														</div>
													</div>

												</div>

												<div class="card-footer">
													<div class="row">
														<div class="col-lg-9 text-right">
															<button type="submit" class="btn btn-primary font-weight-bold" >Save</button>
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
					