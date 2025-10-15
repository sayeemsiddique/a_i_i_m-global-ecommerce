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
									<h3 class="card-title">Add New Page</h3>
								</div>


								<!--begin::Form-->
								<form class="form" action="{{route('admin.page.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
									@csrf

									<input type="hidden" name="type" value="1">

									<div class="card-body">

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-2 col-sm-12">Title: <span class="text-danger">*</span></label>
											<div class="col-lg-10 col-sm-12">
												<input type="text" class="form-control" name="title" placeholder="Enter Name" value="{{old('title')}}" required/>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-form-label text-right col-lg-2 col-sm-12">Serial:</label>
											<div class="col-lg-10 col-sm-12">
												<input type="number" class="form-control" name="sl" placeholder="Enter Serial" value="{{old('sl')}}"/>
											</div>
										</div>


										{{-- <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Description (Bangla):</label>
											<div class="col-lg-5 col-sm-12">
												<textarea class="form-control summernote" name="description_bn" row="2" placeholder="Enter Description"> {{old('description_bn')}}</textarea>
											</div>
										</div> --}}

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-2 col-sm-12">Description:</label>
											<div class="col-lg-10 col-sm-12">
												<textarea class="form-control summernote" name="description_en" row="2" placeholder="Enter Description"> {{old('description_en')}}</textarea>
											</div>
										</div>

                                        <div class="form-group row">
                                            <label class="col-form-label text-right col-lg-2 col-sm-12">Position:</label>
                                            <div class="col-lg-10 col-sm-12">
                                                <select class="form-control" name="type" id="type">
                                                    <option value="">Select</option>
                                                    <option value="1">Header</option>
                                                    <option value="2">Footer</option>
                                                </select>
                                            </div>
                                        </div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-2 col-sm-12">Status: </label>
											<div class="checkbox-list mt-4">
												<label class="checkbox col-lg-10 col-sm-12">
												<input type="checkbox" name="status" value="1" checked />
												<span></span></label>
											</div>
										</div>


									</div>

									<div class="card-footer">
										<div class="row">
											<div class="col-md-12 text-right">
												<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
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
