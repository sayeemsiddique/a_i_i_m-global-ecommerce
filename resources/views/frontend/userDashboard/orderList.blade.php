@extends('frontend.layout.master_alt')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="cart-page">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Order List</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="container account-page">
            <div class="mb-8">
                @if ($user->type == 3)
                    <h1 class="text-center">Dealer Account</h1>
                @elseif ($user->type == 2)
                    <h1 class="text-center">Corporate Consumer Account</h1>
                @else
                    <h1 class="text-center">Customer Account</h1>
                @endif
            </div>

            <div class="tab tab-vertical row gutter-lg">

                @include('frontend.layout.accountMenu')

                <div class="tab-content mb-6" style="padding: 1rem;">
                    
                    <div class="tab-pane mb-4 active in" id="account-orders">
                        <div class="icon-box icon-box-side icon-box-light">
                            <span class="icon-box-icon icon-orders">
                                <i class="w-icon-orders"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title text-capitalize ls-normal mb-0" style="font-weight: 600;">Orders</h4>
                            </div>
                        </div>

                        @include('alerts.alerts')

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

                            <a href="{{route('store.grid')}}" class="btn btn-dark btn-rounded btn-icon-right">Go to Shop<i class="w-icon-long-arrow-right"></i></a>
                    </div>

                </div>

            </div>
        </div>

    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

@push('script')
    <script>
        function previewFiles() {
            var preview = document.querySelector('img#imagePreview1');
            var file = document.querySelector('input#imageUpload1').files[0];
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush