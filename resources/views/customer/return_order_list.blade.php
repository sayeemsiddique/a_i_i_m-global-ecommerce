@extends('customer.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Order Return List</h3>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">
                            <form class="form-inline mb-3" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" name="fromDate" @if (isset($_GET['fromDate']) and $_GET['fromDate']!='')
                                                    value="{{$_GET['fromDate']}}"
                                                @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" @if (isset($_GET['toDate']) and $_GET['toDate']!='')
                                                value="{{$_GET['toDate']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        {{-- <td>

                                            <div class="form-group">
                                                <label class="pr-2 pl-2">User Type :</label>
                                                <select class="form-control" name="type" id="type">
                                                    <option value="">--Select User Type--</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type']==1) selected @endif value="1">Customer</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type']==2) selected @endif value="2">Corporate Consumer</option>
                                                    <option @if (isset($_GET['type']) and $_GET['type']==3) selected @endif value="3">Dealer</option>
                                                </select>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Return Order ID :</label>
                                                <input class="form-control" type="text" name="order_id"  placeholder="Search by Order ID" @if (isset($_GET['order_id']) and $_GET['order_id']!='')
                                                value="{{$_GET['order_id']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Main Order ID :</label>
                                                <input class="form-control" type="text" name="main_order_id"  placeholder="Search by Order ID" @if (isset($_GET['main_order_id']) and $_GET['main_order_id']!='')
                                                value="{{$_GET['main_order_id']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success mt-2 ml-2">Search</button>
                                            <a href="{{route('return_order_list')}}" class="btn btn-danger mt-2 ml-2">Reset Search</button>
                                        </td>

                                    </tr>
                                </table>

                            </form>


                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th class="order-id">Order No</th>
                                        <th class="order-date">Date</th>
                                        <th class="order-status">Status</th>
                                        <th class="order-total">Total</th>
                                        <th class="order-actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="order-id">{{$order->tracking_code}}</td>
                                            <td class="order-date">{{ date('d M Y', strtotime($order->created_at)) }}</td>
                                            <td class="order-status">
                                                @foreach (returnOrderStatus() as $key => $order_status)
														@if($order->status == $key) <span class="badge badge-info">{{$order_status}}</span> @endif
													@endforeach
                                            </td>
                                            <td class="order-total">
                                                <span class="order-price">{{$global_setting->currency ?? ""}} {{$order->grand_total_price}}</span>
                                            </td>
                                            <td class="order-action">
                                                <a href="{{route('returnOrderDetails', Crypt::encryptString($order->id))}}" class="mt-2 btn btn-outline btn-success btn-sm btn-rounded">View</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>


                        {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

