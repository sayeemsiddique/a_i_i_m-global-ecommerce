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
													<h3 class="card-label font-weight-bolder text-dark">{{ $varienttype->name }} Variant Type Details</h3>
												</div>

                                                
											</div>
											<!--end::Header-->
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Variant Type Name : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{$varienttype->name}}" disabled/>
                                                    </div>
                                                </div>

                                                
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Status : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        @if ($varienttype->status == 1)
                                                            <input class="form-control form-control-lg form-control-solid text-success" value="Active" disabled/>
                                                        @else
                                                            <input class="form-control form-control-lg form-control-solid text-danger" value="Inactive" disabled/>
                                                        @endif
                                                    </div>
                                                </div>


												<div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Created By : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ $varienttype->createdBy->first_name ?? '' }}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($varienttype->updatedBy)
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Updated By : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ $varienttype->updatedBy->first_name ?? '' }}" disabled/>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Created Datetime : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ date('d M, Y', strtotime($varienttype->created_at))}}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($varienttype->updated_at)
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Updated Datetime : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ date('d M, Y', strtotime($varienttype->updated_at))}}" disabled/>
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
					