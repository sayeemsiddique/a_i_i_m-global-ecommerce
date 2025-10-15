@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

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
                                <h3 class="card-title">All Page List</h3>
                                <div class="d-flex align-items-center">
                                    <form class="form-inline" action="">
                                    <input type="text" class="form-control form-control-sm form-control-solid ajax-data-search" name="name" value="@if(isset($_GET['name']) and $_GET['name']!='') {{$_GET['name']}} @endif" placeholder="Enter Page, Description, Level">
                                    <button type="submit" class="ml-2 btn btn-primary btn-sm" title="Filter">
                                        <i class="fas fa-search"></i>
                                    </button>

                                    <a href="{{route('admin.page.index')}}" class="ml-2 btn btn-danger btn-sm" title="Remove Filter">
                                        <i class="fas fa-history"></i>
                                    </a>

                                    </form>
                                    @can('add_page')
                                    <a href="{{route('admin.page.create')}}" class="ml-2 btn btn-success btn-sm" title="Add new page">
                                        Add Page
                                    </a>
                                    @endcan
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.page.ajax.tableBody')
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
