<table class="table table-separate table-head-custom table-checkable table-striped" >
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Title Name</th>
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($levels->count() > 0)
        @php                
            $i = (($levels->currentPage() - 1) * $levels->perPage() + 1); 
        @endphp
            @foreach ($levels as $level)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td align="left">
                        {{$level->name}}
                    </td>
                    
                    
                    <td>
                        {{-- @can('edit_level') --}}
                            
                            <a href="{{ route('admin.setting.editLevelSetting',$level) }}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit text-warning"></i>
                            </a>                        
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