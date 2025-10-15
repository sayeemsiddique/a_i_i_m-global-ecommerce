@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                @include('alerts.alerts')
                <!--begin::Card-->
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <div class="card-header">
                                <h3 class="card-title">Website Settings</h3>

                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.setting.update', $setting->id ?? 1)}}" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        @csrf

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Title: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="title" class="form-control" value="{{ $setting->title ?? '' }}" placeholder="Enter Title (English)" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Sub-Title: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="sub_title" class="form-control" value="{{ $setting->sub_title ?? '' }}" placeholder="Enter Sub-Title (English)" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Logo: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <img alt="Logo" class="mt-2" src="{{ asset('storage/setting') }}/{{$setting->logo ?? ''}}" style="max-height: 45px;"/>

                                                <input type="file" name="logo" class="form-control mt-2">
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Address: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <textarea name="address" class="form-control" rows="4" required>{{$setting->address ?? ''}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Phone: </label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="phone" class="form-control" value="{{$setting->phone ?? ''}}" placeholder="Enter Phone Number">
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Alternative Phone:</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="alt_phone" class="form-control" value="{{$setting->alt_phone ?? ''}}" placeholder="Enter Alternative Phone Number">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Mobile: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="mobile" class="form-control" value="{{$setting->mobile ?? ''}}" placeholder="Enter Mobile Number" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Alternative Mobile:</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="alt_mobile" class="form-control" value="{{$setting->alt_mobile ??''}}" placeholder="Enter Alternative Mobile Number">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Email: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="email" name="email" class="form-control" value="{{$setting->email ?? ''}}" placeholder="Enter Email" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Alternative Email:</label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="email" name="alt_email" class="form-control" value="{{$setting->alt_email ?? ''}}" placeholder="Enter Alternative Email">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Facebook Link: </label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="fb_link" name="fb_link" class="form-control" value="{{$setting->fb_link ?? ''}}" placeholder="Enter Facebook Link">
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Youtube Link: </label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="youtube_link" name="youtube_link" class="form-control" value="{{$setting->youtube_link ?? ''}}" placeholder="Enter Youtube Link">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Twitter Link: </label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="twitter_link" name="twitter_link" class="form-control" value="{{$setting->twitter_link ?? ''}}" placeholder="Enter Twitter Link">
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Instagram Link: </label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="instagram_link" name="instagram_link" class="form-control" value="{{$setting->instagram_link ?? ''}}" placeholder="Enter Instagram Link">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Developed By: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="copyright" class="form-control" value="{{$setting->copyright ?? ''}}" placeholder="Developed By" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-12 float-right">
                                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
</div>



@endsection

