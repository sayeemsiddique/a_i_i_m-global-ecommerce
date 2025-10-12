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
									<h3 class="card-title">Add New Dealer</h3>
									<div class="card-toolbar">
										<a href="{{ url()->previous() }}" class="btn btn-primary mr-2">Back</a>
									</div>
								</div>
								
								<!--begin::Form-->
								<form class="form" action="{{route('admin.customer.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
									@csrf

                                    {{-- hidden --}}
									<input type="hidden" name="type" value="3">

									<div class="card-body">

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Upload Profile Photo: </label>
											<div class="col-lg-5 col-sm-12">
												<div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="background-image: url({{asset('assets/media/users/blank.png')}})">
													<div class="image-input-wrapper"></div>
													
													<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Photo">
														<i class="fa fa-pen icon-sm text-muted"></i>
														<input type="file" name="image" accept=".png, .jpg, .jpeg"/>
													</label>
													
													<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Photo">
														<i class="ki ki-bold-close icon-xs text-muted"></i>
													</span>
													
													<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove Photo">
														<i class="ki ki-bold-close icon-xs text-muted"></i>
													</span>
													
												</div>
												<h2 id="FullUsername"></h2>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">First Name: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="first_name" placeholder="Enter First Name" value="{{old('first_name')}}" required id="first_name" />
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Last Name: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" value="{{old('last_name')}}" required id="last_name" />
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
											<label class="col-form-label text-right col-lg-4 col-sm-12">Present Address: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<textarea class="form-control" name="present_address" row="2" required> {{old('present_address')}}</textarea>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">NID: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="nid_no" placeholder="Enter NID" value="{{old('nid_no')}}" required/>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">NID Image: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="file" class="form-control" name="nid" required/>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">BIN: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="bin_no" placeholder="Enter BIN" value="{{old('bin_no')}}" required/>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">BIN Image: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="file" class="form-control" name="bin" required/>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">TIN: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" name="tin_no" placeholder="Enter TIN" value="{{old('tin_no')}}" required/>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">TIN Image: <span class="text-danger">*</span></label>
											<div class="col-lg-5 col-sm-12">
												<input type="file" class="form-control" name="tin" required/>
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
