<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Product Name</th>
            <th>Product Code</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @if ($products->count() > 0)

            @php
                $i = (($products->currentPage() - 1) * $products->perPage() + 1);
            @endphp

            @foreach ($products as $product)
                <tr>
                    <td>
                        {{ $i }}
                    </td>

                    <td>
                        {{ $product->name }}
                    </td>

                    <td>
                        {{ $product->code }}
                    </td>

                    <td>
                        @if ($product->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @else
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_product')
                            <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-sm btn-clean btn-icon"  title="View">
                                <i class="la la-eye"></i>
                            </a>
                        @endcan
                        
                        @can('edit_product')
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                        @endcan

                        @can('delete_product')
                            <button class="btn btn-sm btn-clean btn-icon delete" onclick="deleteProduct({{ $product->id }})" title="Inactive" data-id="{{ $product->id }}">
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

{{-- <div class="ajax-pagination-area">
    {{ $products->appends(['products' =>$products, 'q' => isset($q) ? $q : null, ])->links() }}
</div> --}}

@push('stackScript')
    <script> 
        function deleteProduct(id) {
            var data_id = id;
            var url =  '<a href="{{route("admin.product.delete", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
            url = url.replace(':id', data_id );
            
            Swal.fire({
                title: 'Are you sure want to delete?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Product Deleted Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        }
    </script>
@endpush