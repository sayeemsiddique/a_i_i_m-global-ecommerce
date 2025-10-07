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

								<!--begin::row-->
								<div class="row">
									<div class="col-lg-12">
										<!--begin::Card-->
										<div class="card card-custom">
											<!--begin::Header-->
											<div class="card-header py-3">
												<div class="card-title align-items-start flex-column">
													<h3 class="card-label font-weight-bolder text-dark">{{ $department->name }} Department Details</h3>
												</div>

                                                @can('edit_Department')
                                                <div class="card-toolbar">
													<a href="{{route('admin.department.edit', $department->id)}}" class="btn btn-success mr-2">Edit Department Information</a>
												</div>
                                                @endcan
											</div>
											<!--end::Header-->
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Department Name : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{$department->name}}" disabled/>
                                                    </div>
                                                </div>
												
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Status : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        @if ($department->status == 1)
                                                            <input class="form-control form-control-lg form-control-solid text-success" value="Active" disabled/>
                                                        @else
                                                            <input class="form-control form-control-lg form-control-solid text-danger" value="Deactivated" disabled/>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Created By : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ ($department->user) ? $department->user->username : '' }}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($department->updated_by)
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Updated By : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ ($department->user_update) ? $department->user_update->username : '' }}" disabled/>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Created Datetime : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ date('d M, Y', strtotime($department->created_at))}}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($department->updated_at)
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Updated Datetime : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ date('d M, Y', strtotime($department->updated_at))}}" disabled/>
                                                    </div>
                                                </div>
                                                @endif
                                                <!--end::Form Group-->
                                            </div>
										</div>
										<!--end::Card-->
									</div>
								</div>
                                <!--end::row-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
	@endsection
					