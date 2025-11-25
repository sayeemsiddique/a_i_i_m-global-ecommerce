<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($regions->count() > 0)
            @php
                $i = (($regions->currentPage() - 1) * $regions->perPage() + 1);
            @endphp
            @foreach ($regions as $region)
                <tr>
                    <td>{{$i++}}</td>
                    <td class="text-left">{{$region->name}}</td>
                    <td>
                        @if ($region->status == 1)
                                <span class="badge bg-success">Active</span>

                        @elseif ($region->status == 0)
                                <span class="badge bg-danger">Deactivated</span>

                        @endif
                    </td>
                    <td>
                        {{-- @can('view_region')

                            <a href="{{route('admin.region.show', $region->id)}}" class="btn btn-sm bg-primary p-1" title="view">
                                <i class="la la-eye p-0 text-white"></i>
                            </a>
                        @endcan --}}
                        @can('edit_region')
                            <a href="#" class="btn btn-outline btn-info btn-sm btn-rounded p-1" title="Edit" data-toggle="modal" data-target="#exampleModalgrid_{{$region->id}}">
                                <i class="la la-edit p-0 text-white"></i>
                            </a>

                            <div id="exampleModalgrid_{{$region->id}}" class="modal fade" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalgridLabel">{{__('Edit region')}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.region.update', $region->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row g-3">

                                                    <div class="col-12">
                                                        <div class="text-left">
                                                            <label for="Name" class="form-label">{{__('Region Name')}} <span style="color:red;">*</span></label>
                                                            <input type="text" class="form-control" name="name" value="{{$region->name}}" placeholder=" Region Name" required>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-12 mt-2">
                                                        <div class="text-left">
                                                            <label for="Name" class="form-label">{{__('Shipping Cost')}} <span style="color:red;">*</span></label>
                                                            <input type="number" class="form-control" name="shipping_cost" value="{{$region->shipping_cost}}" placeholder="Shipping Cost" required>
                                                        </div>
                                                    </div><!--end col-->
                                                    <div class="col-lg-12 mt-2">
                                                        <div class="form-check form-switch form-switch-custom form-switch-success mb-3 text-left">
                                                            <input class="form-check-input" type="checkbox" role="switch" name="status" id="SwitchCheck11{{$region->id}}" value="1" @if($region->status == 1) checked @endif>
                                                            <label class="form-check-label" for="SwitchCheck11{{$region->id}}">{{__('Status')}} </label>
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


                        @can('delete_region')
                            <a onclick="return confirm('Are you sure to delete this permanently')" href="{{route('admin.region.delete',$region->id)}}" class="btn btn-outline btn-danger btn-sm btn-rounded p-1" title="Delete Permanently" data-id="{{ $region->id }}">
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

@push('stackScript')


    <script>
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            // alert(data_id);
            var url =  '<a href="{{route("admin.region.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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
