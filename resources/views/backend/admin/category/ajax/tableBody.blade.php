<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Category Name</th>
            <th class="text-left">Parent Category Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($categories->count() > 0)
        @php
            $i = (($categories->currentPage() - 1) * $categories->perPage() + 1);
        @endphp
            @foreach ($categories as $category)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td align="left">
                        {{$category->name}}
                    </td>
                    
                    <td align="left">
                        {{$category->parentInfo->name ?? ''}}
                    </td>

                    <td>
                        @if ($category->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @else
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_category')
                            <a href="{{route('admin.category.show', $category->id)}}" class="btn btn-outline btn-success btn-sm btn-rounded p-1" title="View">
                                <i class="la la-eye p-0 text-white"></i>
                            </a>
                        @endcan
                        
                        @can('edit_category')
                            <a href="{{route('admin.category.edit', $category->id)}}" class="btn btn-outline btn-info btn-sm btn-rounded p-1" title="Edit">
                                <i class="la la-edit p-0 text-white"></i>
                            </a>
                        @endcan

                        @can('delete_category')
                            
                            <button class="btn btn-outline btn-danger btn-sm btn-rounded p-1 delete" title="Inactive" data-id="{{ $category->id }}">
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

<div class="ajax-pagination-area">
    {{ $categories->appends(['categories' =>$categories, 'q' => isset($q) ? $q : null, ])->links() }}
</div>

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.category.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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