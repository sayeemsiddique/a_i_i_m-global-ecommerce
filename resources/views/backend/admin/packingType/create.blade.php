@extends('backend.layout.master')

	@section('content')
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Subheader-->
						<div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
							<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
								<!--begin::Info-->
								<div class="d-flex align-items-center flex-wrap mr-1">
									<!--begin::Page Heading-->
									<div class="d-flex align-items-baseline flex-wrap mr-5">
										<!--begin::Page Title-->
										<h5 class="text-dark font-weight-bold my-1 mr-5">Add New Packing Type</h5>
										<!--end::Page Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
											<li class="breadcrumb-item">
												<a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
											</li>

											@can('all_packing_types')
												<li class="breadcrumb-item">
													<a href="{{route('admin.packing_type.index')}}" class="text-muted">Manage Packing Types</a>
												</li>
											@endcan
											
											<li class="breadcrumb-item active">
												<a class="text-muted">Add New Packing Type</a>
											</li>
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page Heading-->
								</div>
								<!--end::Info-->
							</div>
						</div>
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
												<h3 class="card-title">Add New Packing Type</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.packing_type.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf

												<div class="card-body">

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Packing Type Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="name" placeholder="Enter Packing Type Name" value="{{old('name')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Category: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<select name="category_id[]" id="category_id" class="form-control select-multiple" multiple> 
																<option value="">--Select Category--</option>
																
																@foreach ($categories as $category)
																	<option value="{{ $category->id }}">{{ $category->name }}</option>
																@endforeach
															</select>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Packing Charge (In Percentage): <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="number" step="0.01" class="form-control" name="charge" placeholder="Enter Packing Charge (In Percentage)" value="{{old('charge')}}" required/>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Packing Weight (Gram): <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="number" step="0.01" class="form-control" name="weight" placeholder="Enter Packing Weight (Gram)" value="{{old('weight')}}" required/>
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
					