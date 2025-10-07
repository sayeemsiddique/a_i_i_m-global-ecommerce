<table class="table table-separate table-head-custom table-checkable dataTable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Full Name</th>
            <th class="text-left">User Type</th>
            <th class="text-left">Corporation Name</th>
            <th>Mobile</th>
            <th class="text-left">Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($users->count() > 0)
            @php
                $i = (($users->currentPage() - 1) * $users->perPage() + 1);
            @endphp
            @foreach ($users as $user)
            <tr>
                <td>{{ $i }}</td>
                <td align="left">{{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}</td>

                @if ($user->type == 2)
                    <td align="left">Corporate Consumer</td>
                @else
                    <td align="left">Dealer</td>
                @endif

                <td align="left">{{ $user->corporation_name }}</td>
                <td>{{ $user->mobile }}</td>
                <td align="left">{{ $user->email ? $user->email : 'Not Given' }}</td>
                <td>
                    @if ($user->status == 1)
                        <span class="label label-lg font-weight-bold label-light-success label-inline">Approved</span>
                    @elseif ($user->status == 3)
                        <span class="label label-lg font-weight-bold label-light-primary label-inline">Pending</span>
                    @elseif ($user->status == 0)
                        <span class="label label-lg font-weight-bold label-light-dark label-inline">Blocked</span>
                    @elseif ($user->status == 2)
                        <span class="label label-lg font-weight-bold label-light-danger label-inline">Deleted</span>
                    @endif
                </td>
                <td>
                    @can('view_user')
                        <a href="{{route('admin.user.show', $user->id)}}" class="btn btn-sm btn-clean btn-icon" title="view">
                            <i class="la la-eye"></i>
                        </a>
                    @endcan

                    @can('edit_user')
                        <a href="{{route('admin.user.edit', $user->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                            <i class="la la-edit"></i>
                        </a>
                    @endcan

                    @can('approve_user')
                        @if ($user->status == 3)
                            <button class="btn btn-sm btn-clean btn-icon approve" title="Approve" data-id="{{ $user->id }}">
                                <i class="la la-check"></i>
                            </button>
                        @endif
                    @endcan

                    @can('block_user')
                        @if ($user->status == 1)
                            <button class="btn btn-sm btn-clean btn-icon block" title="Block" data-id="{{ $user->id }}">
                                <i class="la la-ban"></i>
                            </button>
                        @elseif ($user->status == 0)
                            <button class="btn btn-sm btn-clean btn-icon block" title="Unblock" data-id="{{ $user->id }}">
                                <i class="la la-check"></i>
                            </button>
                        @endif
                    @endcan

                    @can('delete_user')
                        @if ($user->status != 2)
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $user->id }}">
                                <i class="la la-trash"></i>
                            </button>
                        @elseif ($user->status == 2)
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Restore" data-id="{{ $user->id }}">
                                <i class="la la-trash-restore"></i>
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
            var url =  '<a href="{{route("admin.user.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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


        $(".approve").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{ route("admin.user.approve", ":id") }}" class="swal2-confirm swal2-styled" title="Approve">Approve</a>';
            url = url.replace(':id', data_id );

            Swal.fire({
                title: 'Are you sure want to approve this user?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('User Approved Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        });

    </script>
@endpush