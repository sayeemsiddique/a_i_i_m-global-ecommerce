<table class="table table-separate table-head-custom table-checkable dataTable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($divisions->count() > 0)
            @php
                $i = (($divisions->currentPage() - 1) * $divisions->perPage() + 1);
            @endphp
            @foreach ($divisions as $division)
            <tr>
                <td>{{$i}}</td>
                <td align="left">{{$division->name}}</td>
                <td>
                    @if ($division->status == 1)
                            <p class="text-success">Active</p>
                                
                    @elseif ($division->status == 0)
                            <p class="text-danger">Deactivated</p>
                            
                    @endif
                </td>
                <td>
                    @can('view_division')
                        
                        <a href="{{route('admin.divisions.show', $division->id)}}" class="btn btn-sm btn-clean btn-icon" title="view">
                            <i class="la la-eye"></i>
                        </a>
                    @endcan
                    @can('edit_division')

                        <a href="{{route('admin.divisions.edit', $division->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                            <i class="la la-edit"></i>
                        </a>
                    @endcan
                    

                    @can('delete_division')
                        @if ($division->status == 1 )
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $division->id }}">
                                <i class="la la-trash"></i>
                            </button>
                        @elseif ($division->status == 0)
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Restore" data-id="{{ $division->id }}">
                                <i class="la la-trash-restore"></i>
                            </button>
                            
                            <a onclick="return confirm('Are you sure to delete this permanently')" href="{{route('admin.divisions.delete_division_permanently',$division->id)}}" class="btn btn-sm btn-clean btn-icon" title="Delete Permanently" data-id="{{ $division->id }}">
                                <i class="la la-trash"></i>
                            </a>
                        @endif
                    {{-- @endcan --}}
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
        $(".block").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.user.block",":id")}}" class="swal2-confirm swal2-styled" title="Block">Confirm</a>';
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

    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            // alert(data_id);
            var url =  '<a href="{{route("admin.divisions.deleteDivision",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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