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
                                <h3 class="card-title">All Slider List</h3>

                                <div class="d-flex align-items-center"> 
                                    <div class="card-toolbar">
                                        <a href="{{ route('admin.slider.create') }}" class="btn btn-primary mr-3">Add New Slider</a>
                                    </div>

                                    <form class="form-inline" action="{{ route('admin.slider.index') }}">                                
                                        <input type="text" class="form-control form-control-sm form-control-solid ajax-data-search" name="name" value="@if(isset($_GET['name']) and $_GET['name'] != '') {{ $_GET['name'] }} @endif" placeholder="Enter Slider Title">

                                        <button type="submit" class="ml-2 btn btn-primary btn-sm" title="Filter">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                
                            </div>
                            <div class="card-body">
                                
                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.slider.ajax.tableBody')                                    
                                </div>

                                {{ $sliders->links() }}
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