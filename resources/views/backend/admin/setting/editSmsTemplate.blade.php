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
                                <h3 class="card-title">Add New SMS-Email Template</h3>
                                
                            </div>
                            <form action="{{ route('admin.setting.updateSmsTemplate',$template)}}" method="post" >
                                <div class="card-body">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-form-label text-right col-lg-3 col-sm-12">Type <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            
                                            <select name="type" id="" class="form-control {{ $errors->has('type') ? ' is-invalid' : '' }}">
                                                
                                                @if ($template->type)
                                                    <option value="{{$template->type}}">{{$template->type == 1 ? 'Email' : 'SMS'}}</option>
                                                @endif
                                                
                                                <option value="1">Email</option>
                                                <option value="2">SMS</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Title <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="text" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$template->title}}" placeholder="Enter Title">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Details <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="text" name="details" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}" value="{{$template->details}}" placeholder="Enter Details">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Subject <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <input type="text" name="subject" class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" value="{{$template->subject}}" placeholder="Enter Subject">

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
