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
                                <h3 class="card-title">All Designation List</h3>
                                <div class="d-flex align-items-center">
                                    @can('add_designation')
                                        <a class="btn btn-primary font-weight-bold" href="{{route('admin.designation.create')}}">
                                            Add Designation
                                        </a>
                                    @endcan

                                    {{-- <input type="text" data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.designation.ajax.tableBody')
                                </div>

                                {{ $designations->links() }}
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
