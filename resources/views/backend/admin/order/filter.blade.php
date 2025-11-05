@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Order Management</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">Filter Order</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
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
                            <h3 class="card-title">Filter Order</h3>
                            <div class="d-flex align-items-center">
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">

                            <form class="form-inline" action="{{route('admin.order.filter')}}" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" name="fromDate" @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                                                    value="{{$_GET['fromDate']}}"
                                                @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" @if (isset($_GET['toDate']) and $_GET['toDate'] !='')
                                                value="{{$_GET['toDate']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">User Type :</label>
                                                <select class="form-control" name="type" id="type">
                                                    <option value="">--Select User Type--</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type'] ==1) selected @endif value="1">Customer</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type'] ==2) selected @endif value="2">Corporate Consumer</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type'] ==3) selected @endif value="3">Dealer</option>
                                                </select>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" name="order_id" @if (isset($_GET['order_id']) and $_GET['order_id'] !='') value="{{$_GET['order_id']}}" @endif placeholder="Search by Order ID">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success mt-2 ml-2">Search</button>
                                        </td>

                                    </tr>
                                </table>

                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">

                            <div class="table-responsive ajax-data-container pt-3">
                                <table class="table table-separate table-head-custom table-checkable table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th class="text-left">User Type</th>
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
                                            $i = 1;
                                        @endphp
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        {{ $i }}
                                                    </td>

                                                    <td>{{ $order->tracking_code }}</td>

                                                    <td align="left">
                                                        @if ($order->user)
                                                            @if ($order->user->role_id == 7)
                                                                @if ($order->user->type == 2)
                                                                    Corporate Consumer
                                                                @elseif ($order->user->type == 3)
                                                                    Dealer
                                                                @else
                                                                    Customer
                                                                @endif
                                                            @else
                                                                Office User
                                                            @endif
                                                        @else
                                                            Invalid Type
                                                        @endif
                                                    </td>

                                                    <td align="left">{{ $order->user ? ($order->user->first_name.' '.$order->user->last_name) : '' }}</td>

                                                    <td>{{ $order->created_at->format('d-M-Y') }}</td>

                                                    <td>৳ {{ $order->grand_total_price ?? '0.00' }}</td>

                                                    <td>
                                                        @if ($order->stage == 1)
                                                            <span class="label label-lg font-weight-bold label-primary label-inline">Accepted</span>
                                                        @elseif ($order->stage == 0)
                                                            <span class="label label-lg font-weight-bold label-warning label-inline">Pending</span>
                                                        @elseif ($order->stage == 2)
                                                            <span class="label label-lg font-weight-bold label-danger label-inline">Declined</span>
                                                        @elseif ($order->stage == 3)
                                                            <span class="label label-lg font-weight-bold label-primary label-inline">On Delivery</span>
                                                        @elseif ($order->stage == 4)
                                                            <span class="label label-lg font-weight-bold label-success label-inline">Completed</span>
                                                        @elseif ($order->stage == 5)
                                                            <span class="label label-lg font-weight-bold label-danger label-inline">Canceled</span>
                                                        @else
                                                            <span class="label label-lg font-weight-bold label-danger label-inline">Unknown Status</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @can('view_order')
                                                            <a href="{{route('admin.order.show', Crypt::encryptString($order->id))}}" class="btn btn-sm btn-clean btn-icon" title="view">
                                                                <i class="la la-eye"></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete_order')
                                                            <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $order->id }}">
                                                                <i class="la la-trash"></i>
                                                            </button>
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
                            </div>
                            {{$orders->appends($_GET)->links()}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
