@extends('frontend.layout.master_alt')
@section('content')

<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main" class="checkout-page">
    <!-- breadcrumb -->
    <div class="bg-gray-13 bg-md-transparent">
        <div class="container">
            <!-- breadcrumb -->
            <div class="my-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('index')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Password
                            Recovery</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="mb-5">
            {{-- <h1 class="text-center">Password Recovery</h1> --}}
            <div class="row">

                <div class="col-md-6" style="display: block;margin: auto;padding-top: 25px;">
                    <div style="background: #0080002e;padding: 50px 70px;border-radius: 15px;">
                        <h1 class="text-center mb-4">Password Recovery</h1>
                        <form action="{{route('reset_password')}}" method="post">
                            @csrf
                            <input type="hidden" name="token_data" @if(isset($_GET['token'])) value="{{$_GET['token']}}" @endif>
                            <div class="form-group form-box">
                                <input type="username" name="email" class="form-control"
                                    placeholder="Email or Mobile No." aria-label="Email Address">
                            </div>
                            <div class="form-group form-box">
                                <input type="password" name="password" class="form-control" autocomplete="off"
                                    placeholder="New Password" aria-label="Password">
                            </div>

                            
                            <div class="form-group mb-0">
                                <button style="padding: 10px;border: 0;background: #16c572 !important;color: #0b0b0b;border-radius: 25px;"
                                    type="submit" class="btn-md btn-theme w-100">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
@endsection

{{-- @push('script')


@endpush --}}

{{-- @push('css')
   
@endpush --}}
