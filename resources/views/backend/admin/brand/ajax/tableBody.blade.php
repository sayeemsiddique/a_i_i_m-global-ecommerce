<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Brand Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($brands->count() > 0)
        @php
            $i = (($brands->currentPage() - 1) * $brands->perPage() + 1);
        @endphp
            @foreach ($brands as $brand)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td align="left">
                        {{$brand->name}}
                    </td>

                    <td>
                        @if ($brand->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @else
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_brand')
                            <a href="{{route('admin.brand.show', $brand->id)}}" class="btn btn-sm btn-clean btn-icon" title="View">
                                <i class="la la-eye"></i>
                            </a>
                        @endcan
                        
                        @can('edit_brand')
                            <a href="{{route('admin.brand.edit', $brand->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                        @endcan

                        @can('delete_brand')
                            
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Inactive" data-id="{{ $brand->id }}">
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
    {{ $brands->appends(['brands' =>$brands, 'q' => isset($q) ? $q : null, ])->links() }}
</div>

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.brand.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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