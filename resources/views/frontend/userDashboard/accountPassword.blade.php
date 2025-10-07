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
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Password</li>
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
                    
                    <div class="tab-pane active in" id="account-password">
                        <div class="icon-box icon-box-side icon-box-light" style="margin-bottom: 1.4rem;">
                            <div class="icon-box-content">
                                <h4 class="icon-box-title mb-0 ls-normal" style="font-weight: 600">Password Change</h4>
                            </div>
                        </div>

                        <form class="form account-details-form" action="{{ route('edit_password', $user->id) }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label class="text-dark" for="cur-password">Current Password (leave blank to leave unchanged)</label>
                                <input type="password" class="form-control form-control-md" id="cur-password" name="current_password" placeholder="Enter Current Password">
                            </div>

                            <div class="form-group">
                                <label class="text-dark" for="new-password">New Password (leave blank to leave unchanged)</label>
                                <input type="password" class="form-control form-control-md" id="new-password" name="password" placeholder="Enter New Password">
                            </div>
                            <div class="form-group mb-10">
                                <label class="text-dark" for="conf-password">Confirm Password</label>
                                <input type="password" class="form-control form-control-md" id="conf-password" name="password_confirmation" placeholder="Confirm New Password">
                            </div>

                            <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4">Save Changes</button>
                        </form>
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