<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Name</th>
            <th class="text-left">User Type</th>
            <th class="text-left">Log Status</th>
            <th>Date and Time</th>
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($loginfos->count() > 0)
        @php
            $i = (($loginfos->currentPage() - 1) * $loginfos->perPage() + 1);
        @endphp
            @foreach ($loginfos as $loginfo)
                <tr>
                    <td>
                        {{ $i }}
                    </td>
                    
                    <td align="left">{{ $loginfo->name }}</td>
                    
                    @if ($loginfo->role_id != 7)
                        <td align="left">{{ $loginfo->role ? $loginfo->role->name : '' }}</td>
                    @else
                        @if ($loginfo->user->type == 1)
                            <td align="left">Customer</td>
                        @elseif ($loginfo->user->type == 2)
                            <td align="left">Corporate Consumer</td>
                        @elseif ($loginfo->user->type == 3)
                            <td align="left">Dealer</td>
                        @else
                            <td align="left">Invalid User</td>
                        @endif
                    @endif

                    @if ($loginfo->type == 1)
                        <td align="left">Login</td>
                    @elseif ($loginfo->type == 2)
                        <td align="left">Logout</td>
                    @else
                        <td align="left">Failed Attempt</td>
                    @endif

                    <td>{{ date('M d, Y h:ia', strtotime($loginfo->time)) }}</td>

                    <td>
                        @can('delete_loginfo')
                            <button class="btn btn-outline btn-danger btn-sm btn-rounded p-1 delete" title="Delete" data-id="{{ $loginfo->id }}">
                                <i class="la la-trash p-0 text-white"></i>
                            </button>
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
            var url =  '<a href="{{route("admin.loginfo.destroy", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
            url = url.replace(':id', data_id );
            
            Swal.fire({
                title: 'Are you sure want to delete?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Log Record Deleted Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        });

    </script>
@endpush