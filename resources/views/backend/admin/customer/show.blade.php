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
                                        <h3 class="card-label font-weight-bolder text-dark">{{ $user->first_name }} {{ $user->last_name }}'s Details </h3>
                                    </div>

                                    <div class="card-toolbar">
                                        <a href="{{route('admin.customer.edit', $user->id)}}" class="btn btn-success mr-2">Edit Customer Information</a>

                                        <a href="{{url()->previous()}}" class="btn btn-primary mr-2">Back</a>
                                    </div>
                                </div>
                                <!--end::Header-->

                                <div class="card-body">
                                    <!--begin::Form Group-->
                                    @if ($user->image)
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
                                    @endif

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Full Name : </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input class="form-control form-control-lg form-control-solid" value="{{$user->first_name}} {{$user->last_name}}" disabled/>
                                        </div>
                                    </div>

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

                                    @if ($user->present_address)
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">Present Address : </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" value="{{ $user->present_address ? $user->present_address : 'Not Given' }}" disabled/>
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
                                                @if ($user->nid)
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
                                                @if ($user->tin)
                                                    <img src="{{ asset('storage/tin/' . $user->tin) }}" alt="Photo" style="max-width: 80px;">
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->bin_no)
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">BIN ID : </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control form-control-lg form-control-solid" value="{{$user->bin_no}}" disabled/>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->bin)
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-right font-weight-bold">BIN Picture : </label>
                                            <div class="col-lg-9 col-xl-6">
                                                @if ($user->bin)
                                                    <img src="{{ asset('storage/bin/' . $user->bin) }}" alt="Photo" style="max-width: 80px;">
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