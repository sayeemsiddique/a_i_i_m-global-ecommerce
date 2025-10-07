<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Vehicle Type</th>
            <th>Vehicle No.</th>
            <th class="text-left">Vehicle Name</th>
            <th>Status</th> 
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($vehicles->count() > 0)
        @php
            $i = (($vehicles->currentPage() - 1) * $vehicles->perPage() + 1);
        @endphp
            @foreach ($vehicles as $vehicle)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    
                    <td align="left">
                        @if ($vehicle->type == 1)
                            Van
                        @elseif ($vehicle->type == 2)
                            Truck
                        @else
                            Pickup
                        @endif
                    </td>
                    <td>{{ $vehicle->vehicle_no }}</td>
                    <td align="left">{{ $vehicle->name }}</td>

                    <td>
                        @if ($vehicle->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @elseif ($vehicle->status == 0)
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Deactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_vehicle')
                            <a href="{{route('admin.vehicle.show', $vehicle->id)}}" class="btn btn-sm btn-clean btn-icon" title="view">
                                <i class="la la-eye"></i>
                            </a>
                        @endcan
                        
                        @can('edit_vehicle')
                            <a href="{{route('admin.vehicle.edit', $vehicle->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                        @endcan

                        @can('delete_vehicle')
                            @if ($vehicle->status == 1)
                                <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $vehicle->id }}">
                                    <i class="la la-trash"></i>
                                </button>
                            @elseif ($vehicle->status == 0)
                                <button class="btn btn-sm btn-clean btn-icon delete" title="Active" data-id="{{ $vehicle->id }}">
                                    <i class="la la-check"></i>
                                </button>
                            @endif
                        @endcan
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
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
            var url =  '<a href="{{route("admin.vehicle.delete", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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