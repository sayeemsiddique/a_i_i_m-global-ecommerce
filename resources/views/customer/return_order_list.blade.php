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
                            {{-- <form class="mt-0 mb-5">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" placeholder="Enter Product Name or Code" name="name" value="{{ request()->name }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control form-control-sm select2" name="category_id">
                                            <option value="">Select category</option>
                                            @foreach ($categories as $category)
                                                <option @if(request()->category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex">
                                            <div class="">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            <div class="">
                                                <a href="{{ route('admin.product.index') }}" class="btn btn-danger ml-2">Reset</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form> --}}


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

