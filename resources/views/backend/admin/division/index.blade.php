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
                                <h3 class="card-title">All Region List</h3>
                                <div class="d-flex align-items-center">
                                    @can('add_region')
                                        <button type="button" class="btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalgrid">
                                            {{__('Add new region')}}
                                        </button>

                                        <div id="exampleModalgrid" class="modal fade" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalgridLabel">{{__('Add new region')}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.region.store')}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row g-3">

                                                                <div class="col-12">
                                                                    <div>
                                                                        <label for="Name" class="form-label">{{__('Region Name')}} <span style="color:red;">*</span></label>
                                                                        <input type="text" class="form-control" name="name" placeholder=" Region Name" required>
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-12 mt-2">
                                                                    <div>
                                                                        <label for="Name" class="form-label">{{__('Shipping Cost')}} <span style="color:red;">*</span></label>
                                                                        <input type="number" class="form-control" name="shipping_cost" placeholder="Shipping Cost" required>
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-lg-12 mt-2">
                                                                    <div class="form-check form-switch form-switch-custom form-switch-success mb-3">
                                                                        <input class="form-check-input" type="checkbox" role="switch" name="status" id="SwitchCheck11" value="1" checked>
                                                                        <label class="form-check-label" for="SwitchCheck11">{{__('Status')}} </label>
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-lg-12">
                                                                    <div class="hstack gap-2 justify-content-end">
                                                                        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.division.ajax.tableBody')
                                </div>
                                {{$regions->links()}}
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
