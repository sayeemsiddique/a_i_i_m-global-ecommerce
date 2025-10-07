<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Customer Name</th>
            <th class="text-left">Product Name</th>
            <th>Rating</th>
            <th class="text-left">Comment</th>
            <th>Status</th> 
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($reviews->count() > 0)
        @php
            $i = (($reviews->currentPage() - 1) * $reviews->perPage() + 1);
        @endphp
            @foreach ($reviews as $review)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    
                    <td align="left">{{ $review->user ? ($review->user->first_name. ' ' .$review->user->last_name) : '' }}</td>
                    <td align="left">{{ $review->product ? $review->product->name : '' }}</td>
                    
                    <td>
                        @for ($i = 1; $i <= $review->rating; $i++)
                            <i class="fas fa-star" style="color: #FFC107"></i>
                        @endfor
                    </td>

                    <td align="left">{{ $review->comment }}</td>

                    <td>
                        @if ($review->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Published</span>
                        @elseif ($review->status == 2)
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Rejected</span>
                        @else
                            <span class="label label-lg font-weight-bold label-light-primary label-inline">Pending</span>
                        @endif
                    </td>

                    <td>
                        @can('publish_review')
                            @if ($review->status == 0 || $review->status == 2)
                                <button class="btn btn-sm btn-clean btn-icon publish" title="Publish" data-id="{{ $review->id }}">
                                    <i class="la la-check"></i>
                                </button>
                            @endif

                            @if ($review->status == 0 || $review->status == 1)
                                <button class="btn btn-sm btn-clean btn-icon publish" title="Reject" data-id="{{ $review->id }}">
                                    <i class="la la-times"></i>
                                </button>
                            @endif
                        @endcan

                        @can('delete_review')
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $review->id }}">
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
    {{$reviews->appends(['reviews' =>$reviews, 'q' => isset($q) ? $q : null,
    ])->links()}}
</div>

@push('stackScript')
    <script> 
        $(".publish").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.review.publish", ":id")}}" class="swal2-confirm swal2-styled" title="Change">Confirm</a>';
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

    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.review.destroy", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
            url = url.replace(':id', data_id );
            
            Swal.fire({
                title: 'Are you sure want to delete?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Review Deleted Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        });

    </script>
@endpush