@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">All Packing Type</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">All Packing Type</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Packing Type List</h3>
                            <div class="d-flex align-items-center"> 

                                @can('add_packing_type') 
                                <a class="btn btn-primary font-weight-bold" href="{{route('admin.packing_type.create')}}">
                                    Add Packing Type
                                </a>     
                                @endcan                             
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive ajax-data-container pt-3">
                                @include('backend.admin.packingType.ajax.tableBody')                                    
                            </div>
                            {{-- {{$packing_types->links()}} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection