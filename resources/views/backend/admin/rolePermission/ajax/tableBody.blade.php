<table class="table table-separate table-head-custom table-checkable">
    <thead>
        <tr>
            <th>#</th>
            
            <th>Role</th> 
            <th>Permissions</th>  
            @can('edit_assign_permission')     
            <th>Actions</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @php
            $i = (($rolePerms->currentPage() - 1) * $rolePerms->perPage() + 1);
        @endphp
        @foreach ($rolePerms as $rolePerm)
            <tr>
                <td>{{$i}}</td>

                <td>{{$rolePerm->role ? ucfirst($rolePerm->role->name) : ''}}</td>

                <td>
                    
                    @foreach ($rolePerm->permissions($rolePerm->role_id) as $perm)
                    
                        <span class="badge badge-success mb-2">{{$perm->permission ? $perm->permission->name_en : ''}}</span>
                    @endforeach
                        
                    
                </td>
                <td>
                    @can('edit_assign_permission')
                    
                    <a href="{{route('admin.rolePermission.edit',$rolePerm)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">                                                         
                        <i class="la la-edit text-warning"></i>
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