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
										<h5 class="text-dark font-weight-bold my-1 mr-5">Add New Bank</h5>
										<!--end::Page Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
											<li class="breadcrumb-item">
												<a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
											</li>

											@can('all_banks')
												<li class="breadcrumb-item">
													<a href="{{route('admin.bank.index')}}" class="text-muted">Manage Banks</a>
												</li>
											@endcan
											
											<li class="breadcrumb-item active">
												<a class="text-muted">Add New Bank</a>
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
												<h3 class="card-title">Add New Bank</h3>
											</div>
											
											
											<!--begin::Form-->
											<form class="form" action="{{route('admin.bank.store')}}" method="post" id="kt_form_1" enctype="multipart/form-data">
												@csrf

												<div class="card-body">

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Bank Name: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<select name="name" id="name" class="form-control"> 
																<option value="">--Select Bank--</option>
																<option value="Agrani Bank Limited">Agrani Bank Limited</option>
																<option value="Bangladesh Development Bank">Bangladesh Development Bank</option>
																<option value="BASIC Bank Limited">BASIC Bank Limited</option>
																<option value="Janata Bank Limited">Janata Bank Limited</option>
																<option value="Rupali Bank Limited">Rupali Bank Limited</option>
																<option value="Sonali Bank Limited">Sonali Bank Limited</option>
															</select>
														</div>
													</div>

													<div class="form-group row">
														<label class="col-form-label text-right col-lg-4 col-sm-12">Account No: <span class="text-danger">*</span></label>
														<div class="col-lg-5 col-sm-12">
															<input type="text" class="form-control" name="account_no" placeholder="Enter Account No." value="{{old('account_no')}}" required/>
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
					