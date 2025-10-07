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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Page</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">All Page</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
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
                                <h3 class="card-title">Page List</h3>
                                <div class="d-flex align-items-center">  
                                    <form class="form-inline" action="{{route('admin.page.index')}}">                                
                                    <input type="text" class="form-control form-control-sm form-control-solid ajax-data-search" name="name" value="@if(isset($_GET['name']) and $_GET['name']!='') {{$_GET['name']}} @endif" placeholder="Enter Page, Description, Level">
                                    <button type="submit" class="ml-2 btn btn-primary btn-sm" title="Filter">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if(isset($_GET['name']) and $_GET['name']!='')
                                    <a href="{{route('admin.page.index')}}" class="ml-2 btn btn-danger btn-sm" title="Remove Filter">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    @endif
                                    </form>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.page.ajax.archiveTableBody')                                    
                                </div>
                                {{ $pages->appends($_GET)->links() }}
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