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
							<h5 class="text-dark font-weight-bold my-1 mr-5">Gatepass</h5>
							<!--end::Page Title-->
							<!--begin::Breadcrumb-->
							<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
								<li class="breadcrumb-item">
									<a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
								</li>
								
								<li class="breadcrumb-item active">
									<a class="text-muted">Gatepass</a>
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
									<h3 class="card-title">Gatepass</h3>
									<div class="card-toolbar">
										<a href="{{ route('admin.order.show', Crypt::encryptString($order->id)) }}" class="btn btn-primary btn-xsm mr-2">Back</a>
									</div>
								</div>
								
								<!--begin::Form-->
								<form class="form" action="{{ route('admin.order.gp_assign', [$order->id, $type]) }}" method="post" id="kt_form_1">
									@csrf
									
                                    <div class="card-body">
										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Gatepass Checker: <span class="text-danger">*</span></label>

											<div class="col-lg-5 col-sm-12">
												<select class="form-control select2" name="examine_user_id" id="examine_user_id" required>
													<option value="">--Select Checker--</option> 

													@foreach ($users as $user)
														<option value="{{ $user->id }}" {{ $gatepass_get->examine_user_id == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
													@endforeach
												</select>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Gatepass Person in Charge: <span class="text-danger">*</span></label>

											<div class="col-lg-5 col-sm-12">
												<select class="form-control select2" name="incharge_user_id" id="incharge_user_id" required>
													<option value="">--Select Person in Charge--</option> 

													@foreach ($users as $user)
														<option value="{{ $user->id }}" {{ $gatepass_get->incharge_user_id == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
													@endforeach
												</select>
											</div>
										</div>

                                        <div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Gatepass Approver: <span class="text-danger">*</span></label>

											<div class="col-lg-5 col-sm-12">
												<select class="form-control select2" name="approver_user_id" id="approver_user_id" required>
													<option value="">--Select Approver--</option> 

													@foreach ($users as $user)
														<option value="{{ $user->id }}" {{ $gatepass_get->approver_user_id == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>

									<div class="card-footer">
										<div class="row">
											<div class="col-lg-9 text-right">
												<button type="submit" class="btn btn-primary font-weight-bold" name="submitButton">Generate Gatepass</button>
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