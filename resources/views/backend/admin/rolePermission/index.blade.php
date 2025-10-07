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
                                <h3 class="card-title">Assigned Permission</h3>
                                <div class="d-flex align-items-center">    
                                    <div class="row">
                                        {{-- <div class="col-md-6">
                                            <input type="text" data-url="{{ route('admin.searchAjax',['type'=> 'rolePerms']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Search Permissions"> 
                                        </div> --}}
                                        <div class="col-md-12">
                                            @can('assign_permission')
                                                <a href="{{route('admin.rolePermission.create')}}" class="btn btn-light-primary pb-4"> <i class="fa fa-plus"></i> Assign Permission</a>
                                                
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.rolePermission.ajax.tableBody')                                    
                                </div>
                                {{-- {{$rolePerms->links()}} --}}
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
    <!--end::Content-->
    


@endsection