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
                                <h3 class="card-title">{{__('View Upazila')}}</h3>

                                <div class="d-flex align-items-center">
                                    <div class="card-toolbar">

                                    </div>


                                </div>

                            </div>
                            <div class="card-body">

                                <div class="table-responsive ajax-data-container pt-3">

<table class="table table-bordered table-sm table-striped m-auto" style="max-width: 600px">
                        <tbody>
                            <tr>
                                <td>{{__('Name')}}:</td>
                                <td>{{$upazila->name}}</td>
                            </tr>

                            <tr>
                                <td>{{__('Division')}}:</td>
                                <td>{{$upazila->districtInfo->divisionInfo->name ?? '-'}}</td>
                            </tr>
                            <tr>
                                <td>{{__('District')}}:</td>
                                <td>{{$upazila->districtInfo->name ?? '-'}}</td>
                            </tr>
                            <tr>
                                <td>{{__('Status')}}:</td>
                                <td>
                                    @if ($upazila->status == 1)
                                        <span class="badge bg-success">{{__('Active')}}</span>
                                    @else
                                        <span class="badge bg-danger">{{__('Inactive')}}</span>
                                    @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                                </div>

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
