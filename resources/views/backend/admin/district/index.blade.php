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
                                <h3 class="card-title">All District List</h3>
                                <div class="d-flex align-items-center">
                                    @can('add_district')
                                        <button type="button" class="btn btn-primary" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalgrid">
                                            {{__('Add new district')}}
                                        </button>

                                        <div id="exampleModalgrid" class="modal fade" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalgridLabel">{{__('Add new district')}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('admin.district.store')}}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row g-3">

                                                                <div class="col-12">
                                                                    <div>
                                                                        <label for="Name" class="form-label">{{__('Division Name')}} <span style="color:red;">*</span></label>
                                                                        <input type="text" class="form-control" name="name" placeholder=" Division Name" required>
                                                                    </div>
                                                                </div><!--end col-->
                                                                <div class="col-12 mt-2">
                                                                    <div>
                                                                        <label for="Name" class="form-label">{{__('Select Region')}} <span style="color:red;">*</span></label>
                                                                        <select name="division_id" class="form-control" required>
                                                                            <option value="">{{__('Select Region')}}</option>
                                                                            @foreach ($regions as $division)
                                                                                <option value="{{$division->id}}">{{$division->name}}</option>
                                                                            @endforeach
                                                                        </select>
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
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Region</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($districts->count() > 0)
                                                @php
                                                    $i = (($districts->currentPage() - 1) * $districts->perPage() + 1);
                                                @endphp
                                                @foreach ($districts as $district)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td class="text-left">{{$district->name}}</td>
                                                        <td class="text-left">
                                                            {{$district->divisionInfo->name ?? ''}}
                                                        </td>
                                                        <td>
                                                            @if ($district->status == 1)
                                                                    <span class="badge bg-success">Active</span>

                                                            @elseif ($district->status == 0)
                                                                    <span class="badge bg-danger">Deactivated</span>

                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{-- @can('view_district')

                                                                <a href="{{route('admin.district.show', $district->id)}}" class="btn btn-sm bg-primary p-1" title="view">
                                                                    <i class="la la-eye p-0 text-white"></i>
                                                                </a>
                                                            @endcan --}}
                                                            @can('edit_district')
                                                                <a href="#" class="btn btn-outline btn-info btn-sm btn-rounded p-1" title="Edit" data-toggle="modal" data-target="#exampleModalgrid_{{$district->id}}">
                                                                    <i class="la la-edit p-0 text-white"></i>
                                                                </a>

                                                                <div id="exampleModalgrid_{{$district->id}}" class="modal fade" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalgridLabel">{{__('Edit district')}}</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form action="{{route('admin.district.update', $district->id)}}" method="POST" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="row g-3">

                                                                                        <div class="col-12">
                                                                                            <div class="text-left">
                                                                                                <label for="Name" class="form-label">{{__('Division Name')}} <span style="color:red;">*</span></label>
                                                                                                <input type="text" class="form-control" name="name" value="{{$district->name}}" placeholder=" Division Name" required>
                                                                                            </div>
                                                                                        </div><!--end col-->
                                                                                        <div class="col-12 mt-2">
                                                                                            <div class="text-left">
                                                                                                <label for="Name" class="form-label">{{__('Select Region')}} <span style="color:red;">*</span></label>
                                                                                                <select name="division_id" class="form-control" required>
                                                                                                    <option value="">{{__('Select Region')}}</option>
                                                                                                    @foreach ($regions as $division)
                                                                                                        <option @if($division->id == $district->division_id) selected @endif value="{{$division->id}}">{{$division->name}}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div><!--end col-->
                                                                                        <div class="col-lg-12 mt-2">
                                                                                            <div class="form-check form-switch form-switch-custom form-switch-success mb-3 text-left">
                                                                                                <input class="form-check-input" type="checkbox" role="switch" name="status" id="SwitchCheck11{{$district->id}}" value="1" @if($district->status == 1) checked @endif>
                                                                                                <label class="form-check-label" for="SwitchCheck11{{$district->id}}">{{__('Status')}} </label>
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


                                                            @can('delete_district')
                                                                <a onclick="return confirm('Are you sure to delete this permanently')" href="{{route('admin.district.delete',$district->id)}}" class="btn btn-outline btn-danger btn-sm btn-rounded p-1" title="Delete Permanently" data-id="{{ $district->id }}">
                                                                    <i class="la la-trash p-0 text-white"></i>
                                                                </a>
                                                            @endcan
                                                        </td>
                                                    </tr>

                                                @endforeach
                                            @else
                                                <tr class="odd"><td valign="top" colspan="11" class="dataTables_empty">No matching records found</td></tr>
                                            @endif

                                        </tbody>
                                    </table>



                                </div>
                                {{$districts->links()}}
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
@push('stackScript')


    <script>
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            // alert(data_id);
            var url =  '<a href="{{route("admin.district.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
            url = url.replace(':id', data_id );

            Swal.fire({
                title: 'Are you sure ?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Status Changed Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        });

    </script>
@endpush
