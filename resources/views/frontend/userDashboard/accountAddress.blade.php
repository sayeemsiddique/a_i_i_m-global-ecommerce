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
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Address</li>
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
                    
                    <div class="tab-pane active in" id="account-addresses">
                        <div class="icon-box icon-box-side icon-box-light">
                            <span class="icon-box-icon icon-map-marker">
                                <i class="w-icon-map-marker"></i>
                            </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title mb-0 ls-normal" style="font-weight: 600;">Addresses</h4>
                            </div>
                        </div>

                        <p>The following addresses will be used on the checkout page
                            by default.</p>
                        <div class="row">
                            <div class="col-sm-6 mb-6">
                                <div class="ecommerce-address billing-address pr-lg-8">
                                    <h4 class="title title-underline ls-25 font-weight-bold">Billing Address</h4>
                                    <address class="mb-4">
                                        <table class="address-table">
                                            <tbody>
                                                <tr>
                                                    <th>Name:</th>
                                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                </tr>

                                                @if ($user->corporation_name)
                                                    <tr>
                                                        <th>Company:</th>
                                                        <td>{{ $user->corporation_name }}</td>
                                                    </tr> 
                                                @endif

                                                <tr>
                                                    <th>Address:</th>
                                                    <td>{{ $user->present_address }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Cell No. :</th>
                                                    <td>{{ $user->mobile }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </address>
                                    <button type="button" class="btn btn-link btn-underline btn-icon-right" style="color: #00c9a7 !important" data-toggle="modal" data-target="#exampleModal">Edit your billing address <i class="w-icon-long-arrow-right"></i></button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Billing Address</h5>
                                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>

                                                <form action="{{ route('edit_address', $user->id) }}" method="post">
                                                    @csrf

                                                    <div class="modal-body">
                                                        <input type="text" id="present_address" value="{{ $user->present_address }}" class="form-control" placeholder="Enter Your Billing Address" name="present_address" required>
                                                    </div>
                                                    <div class="modal-footer edit_billing_address">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($user->permanent_address)
                                <div class="col-sm-6 mb-6">
                                    <div class="ecommerce-address shipping-address pr-lg-8">
                                        <h4 class="title title-underline ls-25 font-weight-bold">Delivery Address</h4>
                                        <address class="mb-4">
                                            <table class="address-table">
                                                <tbody>
                                                    <tr>
                                                        <th>Name:</th>
                                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                    </tr>

                                                    @if ($user->corporation_name)
                                                        <tr>
                                                            <th>Company:</th>
                                                            <td>{{ $user->corporation_name }}</td>
                                                        </tr> 
                                                    @endif

                                                    <tr>
                                                        <th>Address:</th>
                                                        <td>{{ $user->permanent_address }}</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Mobile:</th>
                                                        <td>{{ $user->mobile }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </address>
                                        <button type="button" class="btn btn-link btn-underline btn-icon-right" style="color: #00c9a7 !important" data-toggle="modal" data-target="#exampleModal2">Edit your delivery address <i class="w-icon-long-arrow-right"></i></button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Delivery Address</h5>
                                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
    
                                                    <form action="{{ route('edit_address', $user->id) }}" method="post">
                                                        @csrf
                                                        
                                                        <div class="modal-body">
                                                            <input type="text" id="permanent_address" value="{{ $user->permanent_address }}" placeholder="Enter Your Delivery Address" name="permanent_address" class="form-control" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                        </div>
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