<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Packing Type</th>
            <th>Charge</th>
            <th>Weight (Gram)</th>
            <th>Status</th> 
            
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @if ($packing_types->count() > 0)
        @php
            $i = (($packing_types->currentPage() - 1) * $packing_types->perPage() + 1);
        @endphp
            @foreach ($packing_types as $packing_type)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    
                    <td align="left">{{ $packing_type->name }}</td>
                    <td>{{ $packing_type->charge }}</td>
                    <td>{{ $packing_type->weight }}</td>

                    <td>
                        @if ($packing_type->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @elseif ($packing_type->status == 0)
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Deactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_packing_type')
                            <a href="{{route('admin.packing_type.show', $packing_type->id)}}" class="btn btn-sm btn-clean btn-icon" title="view">
                                <i class="la la-eye"></i>
                            </a>
                        @endcan
                        
                        @can('edit_packing_type')
                            <a href="{{route('admin.packing_type.edit', $packing_type->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                        @endcan

                        @can('delete_packing_type')
                            @if ($packing_type->status == 1)
                                <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $packing_type->id }}">
                                    <i class="la la-trash"></i>
                                </button>
                            @elseif ($packing_type->status == 0)
                                <button class="btn btn-sm btn-clean btn-icon delete" title="Active" data-id="{{ $packing_type->id }}">
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

<div class="ajax-pagination-area">
    {{ $packing_types->appends(['packing_types' =>$packing_types, 'q' => isset($q) ? $q : null, ])->links() }}
</div>

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.packing_type.delete", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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