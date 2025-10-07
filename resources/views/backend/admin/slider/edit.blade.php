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
									<h3 class="card-title">Edit Slider</h3>
									<div class="card-toolbar">
										<a href="{{url()->previous()}}" class="btn btn-primary btn-xsm mr-2">Back</a>
										
									</div>
								</div>
								
								<!--begin::Form-->
								<form class="form" action="{{route('admin.slider.update',$slider)}}" method="post" id="kt_form_1" enctype="multipart/form-data">
									@csrf
									{{-- @method('PATCH') --}}
									<div class="card-body">
										
										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Title: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="title" placeholder="Enter Name" value="{{$slider->title}}" required/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Sub Title:</label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="sub_title" placeholder="Enter Sub Title" value="{{$slider->sub_title}}" />
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Link: <span class="text-danger"></span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="link" placeholder="Enter Link" value="{{$slider->link}}"/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Image: <span class="text-danger">*</span>
												
											</label>
											<div class="col-lg-5 col-sm-12">
												@if ($slider->image!='')
												<img style="width: 150px;" src="{{url('/')}}/storage/slider/{{$slider->image}}" alt="{{$slider->title}}">
												@endif 
												<input type="file" class="form-control mt-2" name="image" placeholder="Enter Image"  />
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Serial No: <span class="text-danger"></span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="number" class="form-control" name="sl" placeholder="Enter Serial No" value="{{$slider->sl}}"/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Status</label>
											<div class="checkbox-list mt-4">
												
												<label class="checkbox col-lg-5 col-sm-12">
												<input autocomplete="off" type="checkbox" @if($slider->status==1) checked @endif name="status" value="1"/>
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
		<script> 
			var avatar5 = new KTImageInput('kt_image_5');
			var avatar6 = new KTImageInput('kt_image_6');

			avatar5.on('cancel', function(imageInput) {
				// swal.fire({
				//     title: 'Image successfully changed !',
				//     type: 'success',
				//     buttonsStyling: false,
				//     confirmButtonText: 'Awesome!',
				//     confirmButtonClass: 'btn btn-primary font-weight-bold'
				// });
			});

			avatar5.on('change', function(imageInput) {});

			avatar5.on('remove', function(imageInput) {});

			avatar6.on('cancel', function(imageInput) {});

			avatar6.on('change', function(imageInput) {});

			avatar6.on('remove', function(imageInput) {});
		</script>
	@endpush
