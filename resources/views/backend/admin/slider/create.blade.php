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
									<h3 class="card-title">Add New Slider</h3>
								</div>
								
								<!--begin::Form-->
								<form class="form" action="{{route('admin.slider.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
									@csrf

									<div class="card-body">

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Title: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="title" placeholder="Enter Title" required value="{{ old('title') }}"/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Sub Title:</label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="sub_title" placeholder="Enter Sub title" value="{{old('sub_title')}}" />
											</div>
										</div>
										
										
										
										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Link: </label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="link" placeholder="Enter Link" value="{{old('link')}}"/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Image: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="file" class="form-control" name="image" required />
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Serial No: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="number" class="form-control" name="sl" placeholder="Enter Serial No" required/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Status: </label>
											<div class="checkbox-list mt-4">
												
												<label class="checkbox col-lg-5 col-sm-12">
												<input type="checkbox" name="status" value="1"/>
												<span></span></label>
											</div>
										</div>

									</div>

									<div class="card-footer">
										<div class="row">
											<div class="col-lg-9 text-right">
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
		
	@endpush
