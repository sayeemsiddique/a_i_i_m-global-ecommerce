<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Variant Type Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($varienttypes->count() > 0)
        @php
            $i = (($varienttypes->currentPage() - 1) * $varienttypes->perPage() + 1);
        @endphp
            @foreach ($varienttypes as $varienttype)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td align="left">
                        {{$varienttype->name}}
                    </td>

                    <td>
                        @if ($varienttype->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @else
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_varient_type')
                            <a href="{{route('admin.varienttype.show', $varienttype->id)}}" class="btn btn-sm btn-clean btn-icon" title="View">
                                <i class="la la-eye"></i>
                            </a>
                        @endcan
                        
                        @can('edit_varient_type')
                            <a href="{{route('admin.varienttype.edit', $varienttype->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                        @endcan

                        @can('delete_varient_type')
                            
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Inactive" data-id="{{ $varienttype->id }}">
                                    <i class="la la-trash"></i>
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

<div class="ajax-pagination-area">
    {{ $varienttypes->appends(['varienttypes' =>$varienttypes, 'q' => isset($q) ? $q : null, ])->links() }}
</div>

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.varienttype.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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