<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>

            <th class="text-left">Role</th>
            {{-- <th>Permissions</th> --}}
            {{-- @can('edit_assign_permission') --}}
            <th >Actions</th>
            {{-- @endcan --}}
        </tr>
    </thead>
    <tbody>
        @php
            $i = (($rolePerms->currentPage() - 1) * $rolePerms->perPage() + 1);
        @endphp
        @foreach ($rolePerms as $rolePerm)
            <tr>
                <td>{{$i}}</td>

                <td class="text-left">{{$rolePerm->name}}</td>

                {{-- <td> --}}

                    {{-- @foreach ($rolePerm->permissions($rolePerm->role_id) as $perm)

                        <span class="badge badge-success mb-2">{{$perm->permission ? $perm->permission->name_en : ''}}</span>
                    @endforeach --}}


                {{-- </td> --}}
                <td>
                    @can('edit_assign_permission')

                        <a href="{{route('admin.rolePermission.edit',$rolePerm->id)}}" class="btn btn-sm bg-primary p-1" title="Edit">
                            <i class="la la-edit p-0 text-white"></i>
                        </a>
                    @endcan

                </td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
    </tbody>
</table>
