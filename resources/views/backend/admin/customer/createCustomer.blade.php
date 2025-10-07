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
									<h3 class="card-title">Add New Customer</h3>
									<div class="card-toolbar">
										<a href="{{ url()->previous() }}" class="btn btn-primary mr-2">Back</a>
									</div>
								</div>
								
								<!--begin::Form-->
								<form class="form" action="{{route('admin.customer.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
									@csrf

									{{-- hidden --}}
									<input type="hidden" name="type" value="1">

									<div class="card-body">

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">First Name: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="first_name" placeholder="Enter First Name" value="{{old('first_name')}}" required id="first_name" oninput="username()" />
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Last Name: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" value="{{old('last_name')}}" required id="last_name" oninput="username()" />
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Password: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="password" class="form-control" name="password" placeholder="Enter a password with minimum 8 characters" required/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Confirm Password: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Mobile: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="mobile" placeholder="Enter Mobile Number" value="{{old('mobile')}}" required/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Email: <span class="text-danger">*</span> </label>
											<div class="col-lg-5 col-sm-12">
												<input type="email" class="form-control" name="email" placeholder="Enter Email Address" value="{{old('email')}}" required/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Present Address: </label>
											<div class="col-lg-5 col-sm-12">
												<textarea class="form-control" name="present_address" row="2"> {{old('present_address')}}</textarea>
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
					
	<script>
		function username(){
			var f = document.getElementById('fname').value;
			var m = document.getElementById('mname').value;
			var l = document.getElementById('lname').value;
			var fullname = f+' '+m+' '+l;
			document.getElementById('FullUsername').innerHTML = fullname;
		}
	</script>

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
