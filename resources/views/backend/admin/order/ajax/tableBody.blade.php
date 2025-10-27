<table class="table table-striped table-bordered table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Order ID</th>
            {{-- <th class="text-left">User Type</th> --}}
            <th class="text-left">Name</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Status</th>
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

                    <td align="left">{{ $order->orderUserInfo ? ($order->orderUserInfo->first_name.' '.$order->orderUserInfo->last_name) : '' }}</td>

                    <td>{{ $order->created_at ? $order->created_at->format('d-M-Y'):'' }}</td>

                    <td>৳ {{ $order->grand_total_price ?? '0.00' }}</td>

                    <td>
                        @if ($order->stage == 1)
                            <span class="label label-lg font-weight-bold label-success label-inline">Accepted</span>
                        @elseif ($order->stage == 0)
                            <span class="label label-lg font-weight-bold label-inline" style="color: white; background:blue;">Pending</span>
                        @elseif ($order->stage == 2)
                            <span class="label label-lg font-weight-bold label-danger label-inline">Declined</span>
                        @elseif ($order->stage == 3)
                            <span class="label label-lg font-weight-bold label-primary label-inline">On Delivery</span>
                        @elseif ($order->stage == 4)
                            <span class="label label-lg font-weight-bold label-success label-inline">Completed</span>
                        @elseif ($order->stage == 5)
                            <span class="label label-lg font-weight-bold label-danger label-inline">Canceled</span>
                        @else
                            <span class="label label-lg font-weight-bold label-warning label-inline">Unknown Status</span>
                        @endif

                    </td>

                    <td>
                        @can('view_order')
                            <a href="{{route('admin.order.show', Crypt::encryptString($order->id))}}" class="btn btn-sm btn-clean btn-icon" title="view">
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
