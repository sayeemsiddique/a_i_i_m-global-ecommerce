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
												<h3 class="card-title">Edit {{ $user->first_name }} {{ $user->last_name }} user</h3>

												{{-- <div class="card-toolbar">
													<a href="{{ url()->previous() }}" class="btn btn-primary btn-xsm mr-2">Back</a>
												</div> --}}
											</div>											
											
											<!--begin::Form-->
											<form class="form" action="{{ route('admin.user.update', $user->id) }}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf
                                                @method('patch')

												<div class="card-body">
													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Profile Photo: </label>

														<div class="col-lg-5 col-sm-12">
															<div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="background-image: url({{asset('assets/media/users/blank.png')}})">
																<div class="image-input-wrapper" style="background-image: url({{asset('storage/users/' . $user->image )}})"></div>
															   
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
														</div>
													</div>

                                                    <div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">First Name:  <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="first_name" placeholder="Enter First Name" value="{{ $user->first_name }}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Last Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" value="{{ $user->last_name }}" required/>
														</div>
													</div>

													{{-- @if ($user->corporation_name)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">Corporation Name: <span class="text-danger"></span></label>
															<div class="col-lg-5 col-sm-12">
																<textarea class="form-control" name="corporation_name" row="2" > {{ $user->corporation_name }}</textarea>
															</div>
														</div>
													@endif --}}

													@if ($user->role_id != 7)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">Role: <span class="text-danger">*</span></label>
															<div class="col-lg-5 col-sm-12">
																<select class="form-control select2" name="role_id" id="role_id" required>
																	@foreach ($roles as $role)
																		<option value="{{ $role->id }}" {{ ($role->id == $user->role_id) ? 'selected' : '' }}>{{ $role->name }}</option>
																	@endforeach
																</select>
															</div>
														</div>
													@endif

													@if ($user->role_id != 7)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">Department: <span class="text-danger">*</span></label>
															<div class="col-lg-5 col-sm-12">
																<select class="form-control select2" name="department_id" id="department_id" required>
																	@foreach ($departments as $department)
																		<option value="{{ $department->id }}" {{ ($department->id == $user->department_id) ? 'selected' : '' }}>{{ $department->name }}</option>
																	@endforeach
																</select>
															</div>
														</div>
													@endif

													@if ($user->role_id != 7)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">Level: <span class="text-danger">*</span></label>

															<div class="col-lg-5 col-sm-12">
																<select class="form-control select2" name="level_id" id="level_id" required>
																	@if ($user->level_id == 1)
																		<option value="1" selected>Management Level</option>
																		<option value="2">Authorized Level</option>
																	@elseif($user->level_id == 2)
																		<option value="1">Management Level</option>
																		<option value="2" selected>Authorized Level</option>
																	@else 
																		<option value="1">Management Level</option>
																		<option value="2">Authorized Level</option>
																	@endif
																</select>
															</div>
														</div>
													@endif
													
													@if ($user->role_id != 7)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">Designation: <span class="text-danger">*</span></label>
															<div class="col-lg-5 col-sm-12">
															<select class="form-control select2" name="designation_id" id="designation_id" required>
																@foreach ($designations as $designation)
																	<option value="{{ $designation->id }}" {{ ($designation->id == $user->designation_id) ? 'selected' : '' }}>{{ $designation->name }}</option>
																@endforeach
															</select>
															</div>
														</div>
													@endif

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Mobile: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="mobile" placeholder="Enter Mobile Number" value="{{ $user->mobile }}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Email: </label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="email" placeholder="Enter Email Address" value="{{ $user->email }}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Present Address: </label>
														<div class="col-lg-5 col-sm-12">
															<textarea class="form-control" name="present_address" row="2" > {{ $user->present_address ? $user->present_address : '' }}</textarea>
														</div>
													</div>

													@if ($user->role_id != 7)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">Permanent Address: <span class="text-danger"></span></label>
															<div class="col-lg-5 col-sm-12">
																<textarea class="form-control" name="permanent_address" row="2" > {{ $user->permanent_address }}</textarea>
															</div>
														</div>
													@endif

													@if ($user->nid_no)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">NID: <span class="text-danger">*</span></label>
															<div class="col-lg-5 col-sm-12">
																<input type="text" class="form-control" name="nid_no" placeholder="Enter NID" value="{{ $user->nid_no }}" required/>
															</div>
														</div>
													@endif

													@if ($user->nid)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">NID Picture: <span class="text-danger">*</span></label>

															<div class="col-lg-5 col-sm-12">
																<div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="background-image: url({{asset('assets/media/users/blank.png')}})">
																	<div class="image-input-wrapper" style="background-image: url({{asset('storage/nid/' . $user->nid )}})"></div>
																
																	<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Photo">
																		<i class="fa fa-pen icon-sm text-muted"></i>
																		<input type="file" name="nid" accept=".png, .jpg, .jpeg"/>
																	</label>
																
																	<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Photo">
																	<i class="ki ki-bold-close icon-xs text-muted"></i>
																	</span>
																
																	<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove Photo">
																	<i class="ki ki-bold-close icon-xs text-muted"></i>
																	</span>
																</div>
															</div>
														</div>
													@endif

													@if ($user->tin)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">TIN Picture: </label>

															<div class="col-lg-5 col-sm-12">
																<div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="background-image: url({{asset('assets/media/users/blank.png')}})">
																	<div class="image-input-wrapper" style="background-image: url({{asset('storage/tin/' . $user->tin )}})"></div>
																
																	<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Photo">
																		<i class="fa fa-pen icon-sm text-muted"></i>
																		<input type="file" name="tin" accept=".png, .jpg, .jpeg"/>
																	</label>
																
																	<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Photo">
																	<i class="ki ki-bold-close icon-xs text-muted"></i>
																	</span>
																
																	<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove Photo">
																	<i class="ki ki-bold-close icon-xs text-muted"></i>
																	</span>
																</div>
															</div>
														</div>
													@endif

													@if ($user->tin_no)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">TIN ID: <span class="text-danger"></span></label>
															<div class="col-lg-5 col-sm-12">
																<input type="text" class="form-control" name="nid_no" placeholder="Enter NID" value="{{ $user->tin_no }}" required/>
															</div>
														</div>
													@endif

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Status: </label>
														<div class="col-lg-5 col-sm-12">
															<select class="form-control select2" name="status" id="status" required>
																@if ($user->status == 1)
																	<option value="3">Pending</option>
																	<option value="1" selected>Approved</option>
																	<option value="0">Blocked</option>
																	<option value="2">Deleted</option>
																@elseif ($user->status == 0)
																	<option value="3">Pending</option>
																	<option value="1">Approved</option>
																	<option value="0" selected>Blocked</option>
																	<option value="2">Deleted</option>
																@elseif ($user->status == 2)
																	<option value="3">Pending</option>
																	<option value="1">Approved</option>
																	<option value="0">Blocked</option>
																	<option value="2" selected>Deleted</option>
																@elseif ($user->status == 3)
																	<option value="3" selected>Pending</option>
																	<option value="1">Approved</option>
																	<option value="0">Blocked</option>
																	<option value="2">Deleted</option>
																@endif
															</select>
														</div>
													</div>

													@if ($user->signature)
														<div class="form-group row">
															<label class="col-form-label text-right col-lg-4 col-sm-12">Old Signature: </label>
															
															<div class="col-lg-5 col-sm-12">
																<img src="{{ asset('storage/signatures/' . $user->signature) }}" alt="Photo" style="max-width: 80px;">
															</div>
														</div>
													@endif

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Upload New Signature: </label>

														<div class="col-lg-5 col-sm-12">
															<input type="file" class="form-control" name="signature" />
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

	@push('stackScript')
		<script> 
			var avatar5 = new KTImageInput('kt_image_5');

			avatar5.on('cancel', function(imageInput) {
				// swal.fire({
				//     title: 'Image successfully changed !',
				//     type: 'success',
				//     buttonsStyling: false,
				//     confirmButtonText: 'Awesome!',
				//     confirmButtonClass: 'btn btn-primary font-weight-bold'
				// });
			});

			avatar5.on('change', function(imageInput) {
				// swal.fire({
				//     title: 'Image successfully changed !',
				//     type: 'success',
				//     buttonsStyling: false,
				//     confirmButtonText: 'Awesome!',
				//     confirmButtonClass: 'btn btn-primary font-weight-bold'
				// });
			});

			avatar5.on('remove', function(imageInput) {
				// swal.fire({
				//     title: 'Image successfully removed !',
				//     type: 'error',
				//     buttonsStyling: false,
				//     confirmButtonText: 'Got it!',
				//     confirmButtonClass: 'btn btn-primary font-weight-bold'
				// });
			});
		</script>
	@endpush
					