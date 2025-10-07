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
                                <h3 class="card-title">Levels List</h3>
                                <div class="d-flex align-items-center">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" data-url="{{ route('admin.searchAjax',['type'=> 'level']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Level">

                                        </div>
                                        @can('add_level')
                                            
                                            <div class="col-md-6">
                                                <button data-toggle="modal" data-target="#add_level" class="btn btn-light-primary pb-4"> <i class="fa fa-plus"></i> New Level</button>

                                            </div>
                                        @endcan
                                    </div>                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.setting.ajax.tableBodyLevel')                                    
                                </div>
                                {{$levels->links()}}
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

<!--begin::Role Modal-->
<div id="add_level" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="min-height: 350px;">
            <div class="modal-header py-5">
                <h5 class="modal-title">Add New Level
                <span class="d-block text-muted font-size-sm"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="form" action="{{route('admin.setting.createLevel')}}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label text-right col-lg-3 col-sm-12">Title (Bangla)  <span style="color: red;">*</span></label>
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <input type="text" required class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{old('name')}}" name="name" placeholder="Enter Role Name (Bangla)" />
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-form-label text-right col-lg-3 offset-lg-4">
                                <button class="btn btn-bg-success btn-block" style="color: aliceblue">Save</button>
                            </label>
                        </div>                           
                    </form>
                </div>                    
            </div>
        </div>
    </div>
</div>
<!--end::Role Modal-->

@endsection

