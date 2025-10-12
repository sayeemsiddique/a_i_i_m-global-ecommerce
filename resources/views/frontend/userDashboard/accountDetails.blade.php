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
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Account Details</li>
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
                    
                    <div class="tab-pane active in" id="account-details">
                        <div class="icon-box icon-box-side icon-box-light">
                            <div class="icon-box-content">
                                <h4 class="icon-box-title mb-0 ls-normal" style="font-weight: 600">Account Details</h4>
                            </div>
                        </div>

                        <form class="form account-details-form" action="{{ route('edit_info', $user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                @if ($user->image)
                                    <div class="col-md-6"> 
                                        <label for="imageUpload1">Profile Image/Corporation Logo: <span class="text-danger">*</span></label>

                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' id="imageUpload1" name="image" accept=".png, .jpg, .jpeg" onchange="previewFiles()"/>
                                                <label for="imageUpload1"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <img loading="lazy" id="imagePreview1" src="{{ asset('storage/users/' . $user->image) }}">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name: <span class="text-danger">*</span></label>
                                        <input type="text" id="first_name" name="first_name" value="{{ $user->first_name }}" placeholder="John" class="form-control form-control-md" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name: <span class="text-danger">*</span></label>
                                        <input type="text" id="last_name" name="last_name" value="{{ $user->last_name }}" placeholder="Doe" class="form-control form-control-md" required>
                                    </div>
                                </div>
                            </div>
                       

                            @if ($user->email)
                                <div class="form-group mb-6">
                                    <label for="email_1">Email Address (Optional):</label>
                                    <input type="email" id="email_1" name="email" class="form-control form-control-md" value="{{ $user->email }}" required>
                                </div>
                            @endif

                            <div class="form-group mb-6">
                                <label for="mobile">Cell No: <span class="text-danger">*</span></label>
                                <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile No." class="form-control form-control-md mb-0" value="{{ $user->mobile }}" required>
                            </div>

                            @if ($user->nid_no)
                                @php
                                    $expNID = explode('.', $user->nid);
                                    $extNID = end($expNID);
                                @endphp

                                <div class="row"> 
                                    <div class="col-md-6"> 
                                        <div class="form-group mb-6">
                                            <label for="nid_no">NID: <span class="text-danger">*</span></label>
                                            <input type="text" id="nid_no" name="nid_no" placeholder="Enter NID" class="form-control form-control-md mb-0" value="{{ $user->nid_no }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-2">
                                                    <label for="nid">NID (PDF/Image): <span class="text-danger">*</span></label>
                                                    <input type="hidden" name="nid" value="{{ $user->nid }}">
        
                                                    <br>
                                                    @if ($extNID == 'pdf' || $extNID == 'PDF')
                                                        <a href="{{ asset('storage/nid/' . $user->nid) }}" class="btn btn-primary">View NID</a>
                                                    @else
                                                        <img loading="lazy" src="{{ asset('storage/nid/' . $user->nid) }}" alt="NID" class="img-responsive" style="max-height: 80px;">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group mb-6">
                                                    <label for="nid">Upload New NID (PDF/Image): <span class="text-danger">*</span></label>

                                                    <input type="file" name="nid_new" id="nid" class="form-control" accept=".png, .jpg, .jpeg, .pdf">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($user->bin_no)
                                @php
                                    $expBIN = explode('.', $user->bin);
                                    $extBIN = end($expBIN);
                                @endphp

                                <div class="row"> 
                                    <div class="col-md-6"> 
                                        <div class="form-group mb-6">
                                            <label for="bin_no">BIN: <span class="text-danger">*</span></label>
                                            <input type="text" id="bin_no" name="bin_no" placeholder="Enter BIN" class="form-control form-control-md mb-0" value="{{ $user->bin_no }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-2">
                                                    <label for="bin">BIN (PDF/Image): <span class="text-danger">*</span></label>
                                                    <input type="hidden" name="bin" value="{{ $user->bin }}">

                                                    <br>
                                                    @if ($extBIN == 'pdf' || $extBIN == 'PDF')
                                                        <a href="{{ asset('storage/bin/' . $user->bin) }}" class="btn btn-primary">View BIN</a>
                                                    @else
                                                        <img loading="lazy" src="{{ asset('storage/bin/' . $user->bin) }}" alt="bin" class="img-responsive" style="max-height: 80px;">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group mb-6">
                                                    <label for="bin">Upload New BIN (PDF/Image): <span class="text-danger">*</span></label>

                                                    <input type="file" name="bin_new" id="bin" class="form-control mt-2" accept=".png, .jpg, .jpeg, .pdf">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($user->tin_no)
                                @php
                                    $expTIN = explode('.', $user->tin);
                                    $extTIN = end($expTIN);
                                @endphp

                                <div class="row"> 
                                    <div class="col-md-6"> 
                                        <div class="form-group mb-6">
                                            <label for="tin_no">TIN: <span class="text-danger">*</span></label>
                                            <input type="text" id="tin_no" name="tin_no" placeholder="Enter TIN" class="form-control form-control-md mb-0" value="{{ $user->tin_no }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6"> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group mb-2">
                                                    <label for="tin">TIN (PDF/Image): <span class="text-danger">*</span></label>

                                                    <input type="hidden" name="tin" value="{{ $user->tin }}">

                                                    <br>
                                                    @if ($extTIN == 'pdf' || $extTIN == 'PDF')
                                                        <a href="{{ asset('storage/tin/' . $user->tin) }}" class="btn btn-primary">View TIN</a>
                                                    @else
                                                        <img loading="lazy" src="{{ asset('storage/tin/' . $user->tin) }}" alt="tin" class="img-responsive" style="max-height: 80px;">
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group mb-6">
                                                    <label for="tin">Upload New TIN (PDF/Image): <span class="text-danger">*</span></label>

                                                    <input type="file" name="tin_new" id="tin" class="form-control mt-2" accept=".png, .jpg, .jpeg, .pdf">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

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