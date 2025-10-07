<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Order ID</th>
            {{-- <th class="text-left">User Type</th> --}}
            {{-- <th class="text-left">Name</th> --}}
            <th>Date</th>
            {{-- <th>Amount</th> --}}
            {{-- <th>Status</th>  --}}
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($orders->count() > 0)
        @php
            $i = (($orders->currentPage() - 1) * $orders->perPage() + 1);
        @endphp
            @foreach ($orders as $order)
                <tr>
                    <td>
                        {{ $i }}
                    </td>
                    
                    <td>{{ $order->tracking_code }}</td>

                    <td>{{ $order->created_at->format('d-M-Y') }}</td>

                    <td>
                        @can('view_order')
                            <a href="{{route('admin.order.stock_in_show', $order->id)}}" class="btn btn-sm btn-clean btn-icon" title="view">
                                <i class="la la-eye"></i>
                            </a>
                        @endcan

                        @can('delete_order')
                            {{-- <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $order->id }}">
                                <i class="la la-trash"></i>
                            </button> --}}
                            {{-- @if ($order->status == 1)
                                
                                @elseif ($order->status == 0)
                                    <button class="btn btn-sm btn-clean btn-icon delete" title="Active" data-id="{{ $order->id }}">
                                        <i class="la la-check"></i>
                                    </button>
                                @endif --}}
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

    
    {{ $orders->appends([
        'q' => isset($q) ? $q : null,
        'orders' => isset($orders) ? $orders : null
        ])->render() }}
        
</div> --}}

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.order.delete", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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