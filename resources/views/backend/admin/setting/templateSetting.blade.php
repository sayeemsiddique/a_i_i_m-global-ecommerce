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
                                <h3 class="card-title">Templates List</h3>
                                <div class="d-flex align-items-center">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" data-url="{{ route('admin.searchAjax',['type'=> 'tempSetting']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Template">

                                        </div>
                                        @can('add_template')

                                            <div class="col-md-6">
                                                <a href="{{ route('admin.setting.createTemplate') }}" class="btn btn-light-primary pb-4"> <i class="fa fa-plus"></i> Add New Template</a>

                                            </div>
                                        @endcan
                                    </div>                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.setting.ajax.tableBody')                                    
                                </div>
                                {{$templates->links()}}
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

