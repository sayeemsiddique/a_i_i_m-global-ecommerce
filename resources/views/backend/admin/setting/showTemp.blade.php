
@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    {{-- <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Email Template Details</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">Email Template Details</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div> --}}
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
                                <h3 class="card-title">Email Template Details</h3>

                                <div class="card-toolbar">
                                    <a href="{{url()->previous()}}" class="btn btn-primary btn-xsm mr-2">Back</a>
                                    
                                </div>
                                
                            </div>
                            <div class="card-body">
                                
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-4 col-sm-12">Header: <span class="text-danger">*</span></label>
                                        <div class="col-lg-5 col-sm-12">
                                            {!!$template->header!!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-4 col-sm-12">Footer: <span class="text-danger">*</span></label>
                                        <div class="col-lg-5 col-sm-12">
                                            {!!$template->footer!!}
                                        </div>
                                    </div>

                                </div>
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

