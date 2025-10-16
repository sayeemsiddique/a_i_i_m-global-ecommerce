@extends('customer.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Update Profile</h3>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form" action="{{route('admin.user.updateProfile', $user->id)}}" method="post" id="kt_form_1" enctype="multipart/form-data">
                                @csrf

                                @method('patch')

                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 col-sm-12">Upload Photo</label>

                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="background-image: url({{asset('assets/media/users/blank.png')}})">
                                                <div class="image-input-wrapper" style="background-image: url({{ asset('storage/users/' . $user->image) }})"></div>

                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Photo">
                                                    <i class="fa fa-pen icon-sm text-muted" style="color: red !important;"></i>
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
                                        <label class="col-form-label text-right col-lg-2 col-sm-12">First Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" value="{{$user->first_name}}" required/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 col-sm-12">Last Name <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" value="{{$user->last_name}}" required/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 col-sm-12">Present Address <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <textarea class="form-control" name="present_address" row="2" required> {{$user->present_address}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 col-sm-12">Permanent Address <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <textarea class="form-control" name="permanent_address" row="2" required> {{$user->permanent_address}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 col-sm-12">Mobile <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="text" class="form-control" name="mobile" placeholder="Enter Mobile Number" value="{{$user->mobile}}" required/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-2 col-sm-12">Email <span class="text-danger">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="texy" class="form-control" name="email" placeholder="Enter Email Address" value="{{$user->email}}" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-10 text-right">
                                            <button type="submit" class="btn btn-primary font-weight-bold" name="submitButton">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

