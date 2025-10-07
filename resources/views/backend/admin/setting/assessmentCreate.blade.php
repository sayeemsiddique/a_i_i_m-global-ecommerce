@extends('backend.layout.master')

@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    
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
                                <h3 class="card-title">Add New Assessment Template</h3>
                                
                            </div>
                            <form action="{{route('admin.setting.storeAssessmentTemplate')}}" method="post" >
                                @csrf
                                <div class="card-body">
                                    
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Name <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Header <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <textarea name="header" class="form-control" data-provide="markdown" rows="10" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Footer <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <textarea name="footer" class="form-control" data-provide="markdown" rows="10" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Make Active </label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="checkbox" name="status" class="mt-4">
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <button type="submit" class="btn btn-primary mr-2">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
