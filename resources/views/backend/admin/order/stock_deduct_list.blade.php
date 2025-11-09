@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Stock Deduct list</h3>
                            <div class="d-flex align-items-center">
                                @can('product_deduct_stock')
                                <a title="Deduct Stock" class="btn btn-success btn-sm ml-2" href="{{ route('admin.product.deduct_stock') }}">Deduct Stock</a>
                            @endcan

                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0">

                            <form class="form-inline" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" name="fromDate" @if(isset($_GET['fromDate']) and $_GET['fromDate'] != '') value="{{$_GET['fromDate']}}" @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" @if(isset($_GET['toDate']) and $_GET['toDate'] != '') value="{{$_GET['toDate']}}" @endif>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" name="order_id" @if(isset($_GET['order_id']) and $_GET['order_id'] != '') value="{{$_GET['order_id']}}" @endif placeholder="Search by Order ID">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success mt-2 ml-2">Search</button>
                                            <a href="{{route('admin.order.deduct_stock_list')}}" class="btn btn-danger mt-2 ml-2">Reset Search</a>
                                        </td>

                                    </tr>
                                </table>

                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">

                            <div class="table-responsive ajax-data-container pt-3">
                                {{-- @include('backend.admin.order.ajax.stock_in_list')                                     --}}
                                <table class="table table-separate table-head-custom table-checkable table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            {{-- <th class="text-left">User Type</th> --}}
                                            {{-- <th class="text-left">Name</th> --}}
                                            <th>Date</th>
                                            {{-- <th>Amount</th> --}}
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

                                                    <td>{{ $order->created_at->format('d-M-Y') }}</td>
                                                    <td>
                                                        @if ($order->status == 1)
                                                            <span class="badge badge-success " title="Approved" >
                                                                Approved
                                                            </span>
                                                            @elseif ($order->status == 0)
                                                                <span class="badge badge-warning " title="Pending">
                                                                    Pending
                                                                </span>
                                                            @elseif ($order->status == 2)
                                                            <span class="badge badge-danger " title="Declined">
                                                                Declined
                                                            </span>
                                                            @endif
                                                    </td>

                                                    <td>
                                                        @if ($order->status == 0)
                                                            <span class="btn btn-sm btn-clean approved btn-icon" title="Approve" data-id="{{ $order->id }}">
                                                                <i class="la la-check"></i>
                                                            </span>

                                                            <span class="btn btn-sm btn-clean declined btn-icon" title="Declined" data-id="{{ $order->id }}">
                                                                <i class="la la-times"></i>
                                                            </span>
                                                        @endif
                                                        @can('view_order')
                                                            <a href="{{route('admin.order.stock_in_show', $order->id)}}" class="btn btn-sm btn-clean btn-icon" title="view">
                                                                <i class="la la-eye"></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete_order')
                                                            {{-- <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $order->id }}">
                                                                <i class="la la-trash"></i>
                                                            </button> --}}

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


                            </div>

                            {{ $orders->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('stackScript')
    <script>
        $(".approved").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.order.approved", ":id")}}?status=1" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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

        $(".declined").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.order.approved", ":id")}}?status=2" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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
