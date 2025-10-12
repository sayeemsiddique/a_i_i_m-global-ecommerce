<table class="table table-separate table-head-custom table-checkable dataTable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="d-none">Photo</th>
            <th class="text-left">Full Name</th>
            <th class="text-left">Role</th>
            <th class="text-left">Department</th>
            {{-- <th class="text-left">Level</th> --}}
            <th class="text-left">Designation</th>
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
                <td>{{$i}}</td>
                <td class="d-none"> 
                    @if ($user->photo)
                        <img src="{{ asset('storage/users/' . $user->photo) }}" alt="Photo" style="max-width: 80px;">
                    @else
                        <img src="{{ asset('assets/media/users/blank.png') }}" alt="Photo" style="max-width: 80px;"> 
                    @endif
                    
                </td>
                <td align="left">{{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}</td>
                <td align="left">{{ $user->role ? $user->role->name : 'N/A' }}</td>
                <td align="left">{{ $user->department ? $user->department->name : 'N/A' }}</td>
                

                <td align="left">{{ $user->designation ? $user->designation->name : 'N/A' }}</td>

                <td>{{ $user->mobile }}</td>

                <td align="left">{{ $user->email }}</td>
                
                <td>
                    @if ($user->status == 1)
                        <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                    @elseif ($user->status == 0)
                        <span class="label label-lg font-weight-bold label-light-dark label-inline">Blocked</span>
                    @elseif ($user->status == 2)
                        <span class="label label-lg font-weight-bold label-light-danger label-inline">Deleted</span>
                    @else
                        <span class="label label-lg font-weight-bold label-light-primary label-inline">Pending</span>
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
                        @if ($user->status == 1 || $user->status == 0)
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

<div class="ajax-pagination-area">
    {{ $users->appends(['users' =>$users, 'q' => isset($q) ? $q : null, ])->links() }}
</div>

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

    </script>
@endpush