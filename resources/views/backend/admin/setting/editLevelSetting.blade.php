@extends('backend.layout.master')

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
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <div class="card-header">
                                <h3 class="card-title">Edit Level</h3>
                                
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.setting.updateLevel',$level)}}" method="post" >
                                    <div class="card-body">
                                        @csrf
                                            
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12 text-right">Title (Bangla) <span style="color: red;">*</span></label>
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <input type="text" name="name" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$level->name}}" placeholder="Enter Title (Bangla)">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-3 col-sm-12 text-right">Title (English) <span style="color: red;">*</span></label>
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <input type="text" name="name" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" value="{{$level->name}}" placeholder="Enter Title (English)">
                                                
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

