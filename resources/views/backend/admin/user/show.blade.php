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
													<h3 class="card-label font-weight-bolder text-dark">{{ $user->first_name }} {{ $user->last_name }} </h3>
                                                    
												</div>

												<div class="card-toolbar">
													<a href="{{route('admin.user.edit', $user->id)}}" class="btn btn-success mr-2">Edit User Information</a>
                                                    {{-- <a href="{{url()->previous()}}" class="btn btn-primary btn-xsm mr-2">Back</a> --}}
												</div>
											</div>
											<!--end::Header-->
                                            <div class="card-body">
                                                <!--begin::Form Group-->
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Profile Photo : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        @if ($user->image)
                                                            <img src="{{ asset('storage/users/' . $user->image) }}" alt="Photo" style="max-width: 80px;">
                                                        @else
                                                            <img src="{{ asset('assets/media/users/blank.png') }}" alt="Photo" style="max-width: 80px;"> 
                                                        @endif
                                                    </div>
                                                </div>

                                                @if ($user->signature)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Signature : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <img src="{{ asset('storage/signatures/' . $user->signature) }}" alt="Photo" style="max-width: 80px;">
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Full Name : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{$user->first_name}} {{$user->last_name}}" disabled/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Role : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ $user->role ? $user->role->name : '' }}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($user->corporation_name)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Corporation Name : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control form-control-lg form-control-solid" value="{{ $user->corporation_name }}" disabled/>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->department)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Department : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control form-control-lg form-control-solid" value="{{ $user->department ? $user->department->name : ''}}" disabled/>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->level)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Level : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            @if ($user->level == 1)
                                                                <input class="form-control form-control-lg form-control-solid" value="Authorized Level" disabled/>
                                                            @else
                                                                <input class="form-control form-control-lg form-control-solid" value="Management Level" disabled/>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->designation)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Designation : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control form-control-lg form-control-solid" value="{{ $user->designation ? $user->designation->name : '' }}" disabled/>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Mobile : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{$user->mobile}}" disabled/>
                                                    </div>
                                                </div>
                                                
                                                @if ($user->email)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Email : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            @if ($user->email)
                                                                <input class="form-control form-control-lg form-control-solid" value="{{ $user->email }}" disabled/>
                                                            @else
                                                                <input class="form-control form-control-lg form-control-solid" value="Not Given" disabled/>
                                                            @endif
                                                            
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Present Address : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ $user->present_address ? $user->present_address : 'Not Given' }}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($user->permanent_address)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Permanent Address : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control form-control-lg form-control-solid" value="{{$user->permanent_address}}" disabled/>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->nid_no)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">NID : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control form-control-lg form-control-solid" value="{{$user->nid_no}}" disabled/>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->nid)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">NID Picture : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            @if ($user->image)
                                                                <img src="{{ asset('storage/nid/' . $user->nid) }}" alt="Photo" style="max-width: 80px;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->tin_no)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">TIN ID : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control form-control-lg form-control-solid" value="{{$user->tin_no}}" disabled/>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->tin)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">TIN Picture : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            @if ($user->image)
                                                                <img src="{{ asset('storage/tin/' . $user->tin) }}" alt="Photo" style="max-width: 80px;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Status : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        @if ($user->status == 1)
                                                            <input class="form-control form-control-lg form-control-solid text-success" value="Approved" disabled/>
                                                        @elseif ($user->status == 0)
                                                            <input class="form-control form-control-lg form-control-solid text-dark" value="Blocked" disabled/>
                                                        @elseif ($user->status == 2)
                                                            <input class="form-control form-control-lg form-control-solid text-danger" value="Deleted" disabled/>
                                                        @elseif ($user->status == 3)
                                                            <input class="form-control form-control-lg form-control-solid text-primary" value="Pending" disabled/>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Created By : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ $user->user_create ? $user->user_create->first_name.' '.$user->user_create->last_name : '' }}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($user->updated_by)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Updated By : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control form-control-lg form-control-solid" value="{{ ($user->user_update) ? $user->user_update->first_name.' '.$user->user_update->last_name : '' }}" disabled/>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Created Datetime : </label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" value="{{ date('d M, Y', strtotime($user->created_at))}}" disabled/>
                                                    </div>
                                                </div>

                                                @if ($user->updated_at)
                                                    <div class="form-group row">
                                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Updated Datetime : </label>
                                                        <div class="col-lg-9 col-xl-6">
                                                            <input class="form-control form-control-lg form-control-solid" value="{{ date('d M, Y', strtotime($user->updated_at))}}" disabled/>
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