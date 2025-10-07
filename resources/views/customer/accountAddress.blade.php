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
                            <h3 class="card-title">Product List</h3>
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
                            <table class="shop-table account-orders-table mb-6 table" style="width: 100%;">
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
                                                @if ($order->status == 1)
                                                    <span class="badge badge-success">Accepted</span>
                                                @elseif ($order->status == 2)
                                                    <span class="badge badge-danger">Declined</span>
                                                @elseif ($order->status == 3)
                                                    <span class="badge badge-success">Completed</span>
                                                @elseif ($order->status == 4)
                                                    <span class="badge badge-danger">Canceled</span>
                                                @else
                                                    <span class="badge" style="background:#144ceb; color:white;">Pending</span>
                                                @endif
                                            </td>
                                            <td class="order-total">
                                                <span class="order-price">৳ {{$order->grand_total_price}}</span>
                                            </td>
                                            <td class="order-action">
                                                <a href="{{route('orderDetails', $order->id)}}" class="btn btn-outline btn-default btn-sm btn-rounded">View</a>
    
                                                {{-- <a title="Exchange Order" href="{{route('orderExchange', $order->id)}}" class="btn btn-outline btn-default btn-sm btn-rounded">Exchange Order</a> --}}
    
                                                @if ($order->payment_status == 0 && $order->status != 4)
                                                    <button class="mt-2 btn btn-danger btn-default text-white btn-outline btn-sm btn-rounded" style="cursor: pointer;" data-target="#exampleModalCenter{{$order->id}}" data-toggle="modal">Cancel</button>
                                                @endif
                                            </td>
                                        </tr>  
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalCenter{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Remark</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
    
                                                    <form action="{{ route('cancel_order', $order->id) }}" method="post">
                                                        @csrf
    
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                <div class="col-md-2 col-form-label text-right"> 
                                                                    <label for="cancel_order">Remark: </label>
                                                                </div>
    
                                                                <div class="col-md-10"> 
                                                                    <input type="text" class="form-control" id="cancel_order" name="remark" placeholder="Why you want to cancel the order ?" required>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary text-white">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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

