@extends('backend.layout.master')

	@section('content')
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						
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
													<h3 class="card-label font-weight-bolder text-dark">Vehicle Details</h3>
												</div>

                                                @can('edit_vehicle')
                                                <div class="card-toolbar">
													<a href="{{route('admin.vehicle.edit', $vehicle->id)}}" class="btn btn-success mr-2">Edit Vehicle Information</a>
												</div>
                                                @endcan
											</div>
											<!--end::Header-->
                                            <div class="card-body">
												<div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Vehicle Type : </label>
                                                    <div class="col-lg-9 col-xl-6">
														@if ($vehicle->type == 1)
															<input class="form-control form-control-lg form-control-solid" value="Van" disabled/>
														@elseif ($vehicle->type == 2)
															<input class="form-control form-control-lg form-control-solid" value="Truck" disabled/>
														@else
															<input class="form-control form-control-lg form-control-solid" value="Pickup" disabled/>
														@endif
                                                    </div>
                                                </div>

												<div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Plate No : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ $vehicle->plate_no }}" disabled/>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Vehicle No : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ $vehicle->vehicle_no }}" disabled/>
                                                    </div>
                                                </div>
												<div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Vehicle Name : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{$vehicle->name}}" disabled/>
                                                    </div>
                                                </div>
												<div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Vehicle Weight : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{$vehicle->weight}}" disabled/>
                                                    </div>
                                                </div>
												<div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">License No : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{$vehicle->license_no}}" disabled/>
                                                    </div>
                                                </div>
												<div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">License Image : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <img src="{{ asset('storage/license/' . $vehicle->license) }}" alt="License" style="max-width: 80px;">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Status : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        @if ($vehicle->status == 1)
                                                            <input class="form-control form-control-lg form-control-solid text-success" value="Active" disabled/>
                                                        @else
                                                            <input class="form-control form-control-lg form-control-solid text-danger" value="Deactivated" disabled/>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Created By : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ ($vehicle->user) ? $vehicle->user->username : '' }}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($vehicle->updated_by)
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Updated By : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ ($vehicle->user_update) ? $vehicle->user_update->username : '' }}" disabled/>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Created Datetime : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ date('d M, Y', strtotime($vehicle->created_at))}}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($vehicle->updated_at)
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Updated Datetime : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ date('d M, Y', strtotime($vehicle->updated_at))}}" disabled/>
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
					