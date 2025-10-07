@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Card-->
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Edit Designation</h3>
                            <div class="card-toolbar">
                                <a href="{{url()->previous()}}" class="btn btn-primary btn-xsm mr-2">Back</a>
                                
                            </div>
                        </div>
                        <div class="card-body">
							<form class="form" action="{{ route('admin.designation.update',$designation) }}" method="post" id="kt_form_1">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Level: <span class="text-danger">*</span></label>
                                    <div class="col-lg-5 col-sm-12">
                                        <select class="form-control select2" name="level_id" id="level_id" required>
                                            @if ($designation->level_id == 1)
                                                <option value="1" selected>Management Level</option>
                                                <option value="2">Authorized Level</option>
                                            @else
                                                <option value="1">Management Level</option>
                                                <option value="2" selected>Authorized Level</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Designation Title:  <span class="text-danger">*</span></label>
                                        <div class="col-lg-5 col-sm-12">
                                            <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" placeholder="Enter Title" value="{{ $designation->name }}" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer"> 
                                    <div class="form-group row">
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

@endsection