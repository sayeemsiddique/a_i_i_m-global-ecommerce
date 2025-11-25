<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Variant Type</th>
            <th class="text-left">Value</th>
            <th>Status</th> 
            
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @if ($varient_values->count() > 0)
            @php
                $i = (($varient_values->currentPage() - 1) * $varient_values->perPage() + 1);
            @endphp

            @foreach ($varient_values as $varient_value)
                <tr>
                    <td>
                        {{ $i }}
                    </td>
                    
                    <td align="left">{{ $varient_value->varient_type->name ?? '' }}</td>
                    <td align="left">{{ $varient_value->value }}</td>

                    <td>
                        @if ($varient_value->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @elseif ($varient_value->status == 0)
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Deactive</span>
                        @endif
                    </td>

                    <td>
                        @can('edit_varient_value')
                            <a href="{{ route('admin.varient_value.edit', $varient_value->id) }}" class="btn btn-outline btn-info btn-sm btn-rounded p-1" title="Edit">
                                <i class="la la-edit p-0 text-white"></i>
                            </a>
                        @endcan

                        @can('delete_varient_value')
                            @if ($varient_value->status == 1)
                                <button class="btn btn-outline btn-danger btn-sm btn-rounded p-1 delete" title="Delete" data-id="{{ $varient_value->id }}">
                                    <i class="la la-trash p-0 text-white"></i>
                                </button>
                            @elseif ($varient_value->status == 0)
                                <button class="btn btn-outline btn-danger btn-sm btn-rounded p-1 delete" title="Active" data-id="{{ $varient_value->id }}">
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

{{-- <div class="ajax-pagination-area">
    {{ $varient_values->appends(['varient_values' =>$varient_values, 'q' => isset($q) ? $q : null, ])->links() }}
</div> --}}

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{ route("admin.varient_value.delete", ":id") }}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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