<aside id="sidebarContent" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler">
   <div class="u-sidebar__scroller">
       <div class="u-sidebar__container">
           <div class="js-scrollbar u-header-sidebar__footer-offset pb-3">
               <!-- Toggle Button -->
               <div class="d-flex align-items-center pt-4 px-7">
                   <button type="button" class="close ml-auto" aria-controls="sidebarContent" aria-haspopup="true"
                       aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                       data-unfold-target="#sidebarContent" data-unfold-type="css-animation"
                       data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                       data-unfold-duration="500">
                       <i class="ec ec-close-remove"></i>
                   </button>
               </div>
               <!-- End Toggle Button -->

               <!-- Content -->
               <div class="js-scrollbar u-sidebar__body">
                   <div class="u-sidebar__content u-header-sidebar__content">
                        @include('alerts.alerts')

                        <form class="js-validate" action="{{ route('login') }}" method="POST">
                            @csrf

                           <!-- Login -->
                           <div id="login" data-target-group="idForm">
                               <!-- Title -->

                               <header class="text-center mb-7">
                                   <h2 class="h4 mb-0">Greetings!</h2>
                                   <p>Login to your account.</p>
                               </header>
                               <!-- End Title -->

                               <!-- Form Group -->
                               <div class="form-group">
                                   <div class="js-form-message js-focus-state">
                                       <label class="sr-only" for="signinEmail">Email or Mobile No. <small class="text-danger">*</small></label>
                                       <div class="input-group">
                                           <div class="input-group-prepend">
                                               <span class="input-group-text" id="signinEmailLabel">
                                                   <span class="fas fa-user"></span>
                                               </span>
                                           </div>

                                           <input type="text" class="form-control" name="username" id="signinEmail" placeholder="Enter Email or Mobile No." aria-label="Email" aria-describedby="signinEmailLabel" required data-error-class="u-has-error" data-success-class="u-has-success" value="{{ old('username') }}">
                                       </div>
                                   </div>
                               </div>
                               <!-- End Form Group -->

                               <!-- Form Group -->
                               <div class="form-group">
                                   <div class="js-form-message js-focus-state">
                                       <label class="sr-only" for="signinPassword">Password <small class="text-danger">*</small></label>
                                       <div class="input-group">
                                           <div class="input-group-prepend">
                                               <span class="input-group-text" id="signinPasswordLabel">
                                                   <span class="fas fa-lock"></span>
                                               </span>
                                           </div>

                                           <input type="password" class="form-control" name="password" id="signinPassword" placeholder="Password" aria-label="Password" aria-describedby="signinPasswordLabel" required data-msg="Your password is invalid. Please try again." data-error-class="u-has-error" data-success-class="u-has-success">

                                           <div class="pass-eye-icon" id="log-pass-eye" style="cursor: pointer;">
                                                <i class="fa fa-eye"></i>
                                            </div>
                                       </div>
                                   </div>
                               </div>
                               <!-- End Form Group -->

                               <div class="d-flex justify-content-end mb-4">
                                   <a class="js-animation-link small link-muted" href="javascript:;" data-target="#forgotPassword" data-link-group="idForm" ata-animation-in="slideInUp">Forgot Password?</a>
                               </div>

                               <div class="mb-2">
                                   <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover">Login</button>
                               </div>

                               <div class="text-center mb-4">
                                   <span class="small text-muted">Do not have an account?</span>

                                   <a class="js-animation-link small text-dark" href="javascript:;"
                                       data-target="#signup" data-link-group="idForm"
                                       data-animation-in="slideInUp">Signup
                                   </a>
                                   {{-- <a href="{{ route('sign_up') }}">
                                        Signup
                                   </a> --}}
                               </div>
                           </div>
                        </form>

                        <form class="js-validate"  action="{{ route('user_.registration') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                           <!-- Signup -->
                           <div id="signup" style="display: none; opacity: 0;" data-target-group="idForm">
                               <!-- Title -->
                               <header class="text-center mb-7">
                                   <h2 class="h4 mb-0">Welcome!</h2>
                                   <p>Fill out the form to get started.</p>
                               </header>
                               <!-- End Title -->

                               <div class="otp-form-section" style="display: block">
                                    <div class="form-group">
                                        <label for="phone_number">{{__('Mobile Number')}} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="{{__('Mobile Number')}}" required>
                                    </div>
                                    <div style="cursor: pointer;" class="btn btn-primary d-block text-white send_otp">{{__('Send OTP')}}</div>
                               </div>

                               <div class="registration-section" style="display: none">
                                    {{-- <input type="hidden" name="type" value="1" id="user_type"> --}}
                                    <input type="hidden" name="mobile" value="" id="otp_mobile_number">
                                    <div class="form-group">
                                        <div class="js-form-message js-focus-state">
                                            <label class="" style="font-weight: bold;" for="mobile_otp_code">Your OTP Code: <span class="text-danger">*</span></label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="set_otp_level">
                                                        <span class="fas fa-mobile"></span>
                                                    </span>
                                                </div>

                                                <input type="text" class="form-control" name="mobile_otp_code" id="mobile_otp_code" placeholder="Enter Your First Name" aria-label="mobile_otp_code" aria-describedby="set_otp_level" value="{{ old('mobile_otp_code') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="js-form-message js-focus-state">
                                            <label class="" style="font-weight: bold;" for="first_name">First Name: <span class="text-danger">*</span></label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="firstNameLabel">
                                                        <span class="fas fa-user"></span>
                                                    </span>
                                                </div>

                                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter Your First Name" aria-label="first_name" aria-describedby="firstNameLabel" value="{{ old('first_name') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="js-form-message js-focus-state">
                                            <label class="" style="font-weight: bold;" for="last_name">Last Name: <span class="text-danger">*</span></label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="lastNameLabel">
                                                        <span class="fas fa-user"></span>
                                                    </span>
                                                </div>

                                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Your Last Name" aria-label="last_name" aria-describedby="lastNameLabel" value="{{ old('last_name') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="js-form-message js-focus-state">
                                       <label class="" style="font-weight: bold;" for="signupPassword">Password: <span class="text-danger">*</span></label>

                                       <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="signupPasswordLabel">
                                                    <span class="fas fa-lock"></span>
                                                </span>
                                            </div>

                                            <input type="password" class="form-control" name="password" id="signupPassword" minlength="8" placeholder="Minimum 8 Characters" aria-label="Password" aria-describedby="signupPasswordLabel" required data-msg="Your password is invalid. Please try again." data-error-class="u-has-error" data-success-class="u-has-success">

                                            <div class="pass-eye-icon" id="pass-eye" style="cursor: pointer;">
                                                <i class="fa fa-eye"></i>
                                            </div>
                                       </div>
                                   </div>

                                    <div class="mb-2 mt-4">
                                        <button id="customer_registration" type="button" class="btn btn-block btn-sm btn-primary transition-3d-hover">Sign Up</button>
                                    </div>
                                    <div class="mb-2 mt-1">
                                        <button type="button" id="resend-otp" class="btn btn-link">{{__('Resend OTP')}}</button>
                                    </div>
                               </div>

                                <!-- Form Group -->
                                {{-- <div class="form-group">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" for="user_type" style="font-weight: bold;">User Type: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="userTypeLabel">
                                                    <span class="fas fa-address-card"></span>
                                                </span>
                                            </div>

                                            <select name="type" id="user_type" class="form-control"required data-msg="Please Select an User Type" data-error-class="u-has-error" data-success-class="u-has-success">
                                                <option value="">--Select an User Type</option>
                                                <option value="1">Customer</option>
                                                <option value="2">Corporate Consumer</option>
                                                <option value="3">Dealer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->


                                <!-- Form Group -->
                                {{-- <div class="form-group dealer-reg">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="imageUpload">Profile Image: </label>

                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' id="imageUpload" name="image" accept=".png, .jpg, .jpeg" onchange="previewFile()"/>
                                                <label for="imageUpload"></label>
                                            </div>

                                            <div class="avatar-preview">
                                                <img loading="lazy" id="imagePreview" src="{{ asset('assets/media/users/blank.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                                <!-- Form Group -->
                                {{-- <div class="form-group">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="first_name">First Name: <span class="text-danger">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="firstNameLabel">
                                                    <span class="fas fa-user"></span>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter Your First Name" aria-label="first_name" aria-describedby="firstNameLabel" value="{{ old('first_name') }}" required>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                                <!-- Form Group -->
                                {{-- <div class="form-group">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="last_name">Last Name: <span class="text-danger">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="lastNameLabel">
                                                    <span class="fas fa-user"></span>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Your Last Name" aria-label="last_name" aria-describedby="lastNameLabel" value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                                <!-- Form Group -->
                                {{-- <div class="form-group">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="mobile">Mobile No: <span class="text-danger">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="mobileLabel">
                                                    <span class="fas fa-mobile"></span>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Your Mobile No." aria-label="mobile" aria-describedby="mobileLabel" value="{{ old('mobile') }}" required>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                                <!-- Form Group -->
                                {{-- <div class="form-group">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="signupEmail">Email: <span class="text-danger">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="signupEmailLabel">
                                                    <span class="fas fa-envelope"></span>
                                                </span>
                                            </div>

                                            <input type="email" class="form-control" name="email" id="signupEmail" placeholder="Enter Your Email Address" aria-label="Email" aria-describedby="signupEmailLabel" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                               <!-- Form Group -->
                               {{-- <div class="form-group">
                                   <div class="js-form-message js-focus-state">
                                       <label class="" style="font-weight: bold;" for="signupPassword">Password: <span class="text-danger">*</span></label>

                                       <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="signupPasswordLabel">
                                                    <span class="fas fa-lock"></span>
                                                </span>
                                            </div>

                                            <input type="password" class="form-control" name="password" id="signupPassword" minlength="8" placeholder="Minimum 8 Characters" aria-label="Password" aria-describedby="signupPasswordLabel" required data-msg="Your password is invalid. Please try again." data-error-class="u-has-error" data-success-class="u-has-success">

                                            <div class="pass-eye-icon" id="pass-eye" style="cursor: pointer;">
                                                <i class="fa fa-eye"></i>
                                            </div>
                                       </div>
                                   </div>
                               </div> --}}
                               <!-- End Input -->

                               <!-- Form Group -->
                               {{-- <div class="form-group">
                                   <div class="js-form-message js-focus-state">
                                       <label class="" style="font-weight: bold;" for="signupConfirmPassword">Confirm Password: <span class="text-danger">*</span></label>

                                       <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="signupConfirmPasswordLabel">
                                                    <span class="fas fa-key"></span>
                                                </span>
                                            </div>

                                            <input type="password" class="form-control" name="password_confirmation" id="signupConfirmPassword" placeholder="Confirm Password" aria-label="Confirm Password" aria-describedby="signupConfirmPasswordLabel" required data-msg="Password does not match the confirm password." data-error-class="u-has-error" data-success-class="u-has-success">

                                            <div class="pass-eye-icon" id="conf-pass-eye" style="cursor: pointer; z-index: 1000;">
                                                <i class="fa fa-eye"></i>
                                            </div>
                                       </div>
                                   </div>
                               </div> --}}
                               <!-- End Input -->

                                <!-- Form Group -->
                                {{-- <div class="form-group">
                                    <div class="js-form-message js-focus-state">
                                        <label class="present_address_label" style="font-weight: bold;" for="present_address">Address (Optional): </label> <span class="text-danger present_address_star" style="display: none;">*</span>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="present_addressLabel">
                                                    <span class="fas fa-address-card"></span>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control" name="present_address" id="present_address" placeholder="Enter Your Address" aria-label="present_address" aria-describedby="present_addressLabel" value="{{ old('present_address') }}">
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                                <!-- Form Group -->
                                {{-- <div class="form-group dealer-reg" style="display: none;">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="nid_no">NID: <span class="text-danger present_address_star" style="display: none;">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="nid_noLabel">
                                                    <span class="fas fa-id-card"></span>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control" name="nid_no" id="nid_no" placeholder="Enter Your NID" aria-label="nid_no" aria-describedby="nid_noLabel" value="{{ old('nid_no') }}">
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->
                                <!-- Form Group -->
                                {{-- <div class="form-group dealer-reg" style="display: none;">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="nid">NID (PDF/Image): <span class="text-danger present_address_star" style="display: none;">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="nidLabel">
                                                    <span class="fas fa-id-card"></span>
                                                </span>
                                            </div>

                                            <input type="file" class="form-control" name="nid" id="nid">
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                                <!-- Form Group -->
                                {{-- <div class="form-group dealer-reg" style="display: none;">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="bin_no">Company BIN: <span class="text-danger">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="bin_noLabel">
                                                    <span class="fas fa-id-card"></span>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control" name="bin_no" id="bin_no" placeholder="Enter Your Company BIN" aria-label="bin_no" aria-describedby="bin_noLabel" value="{{ old('bin_no') }}" required>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->
                                <!-- Form Group -->
                                {{-- <div class="form-group dealer-reg" style="display: none;">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="bin">Company BIN (PDF/Image): <span class="text-danger present_address_star" style="display: none;">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="binLabel">
                                                    <span class="fas fa-id-card"></span>
                                                </span>
                                            </div>

                                            <input type="file" class="form-control" name="bin" id="bin">
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                                <!-- Form Group -->
                                {{-- <div class="form-group dealer-reg" style="display: none;">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="tin_no">Company TIN: <span class="text-danger">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="tin_noLabel">
                                                    <span class="fas fa-id-card"></span>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control" name="tin_no" id="tin_no" placeholder="Enter Your Company TIN" aria-label="tin_no" aria-describedby="tin_noLabel" value="{{ old('tin_no') }}" required>
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->
                                <!-- Form Group -->
                                {{-- <div class="form-group dealer-reg" style="display: none;">
                                    <div class="js-form-message js-focus-state">
                                        <label class="" style="font-weight: bold;" for="tin">Company TIN (PDF/Image): <span class="text-danger present_address_star" style="display: none;">*</span></label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="tinLabel">
                                                    <span class="fas fa-id-card"></span>
                                                </span>
                                            </div>

                                            <input type="file" class="form-control" name="tin" id="tin">
                                        </div>
                                    </div>
                                </div> --}}
                                <!-- End Input -->

                               <div class="text-center mb-4">
                                   <span class="small text-muted">Already have an account?</span>

                                   <a class="js-animation-link small text-dark" href="javascript:;"
                                       data-target="#login" data-link-group="idForm"
                                       data-animation-in="slideInUp">Login
                                   </a>
                               </div>
                           </div>
                           <!-- End Signup -->
                       </form>

                       <!-- Forgot Password -->
                       <div id="forgotPassword" style="display: none; opacity: 0;" data-target-group="idForm">

                        <!-- Title -->
                        <header class="text-center mb-7">
                            <h2 class="h4 mb-0">Recover Password.</h2>
                            <p>Enter your email address and an email with instructions will be sent to you.</p>
                        </header>
                        <!-- End Title -->

                        <!-- Form Group -->
                        <form action="{{ route('forget_password') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <div class="js-form-message js-focus-state">
                                    <label class="sr-only" for="recoverEmail">Your Email</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="recoverEmailLabel">
                                                <span class="fas fa-user"></span>
                                            </span>
                                        </div>

                                        <input type="email" class="form-control" name="email" id="recoverEmail" placeholder="Your email" aria-label="Your email" aria-describedby="recoverEmailLabel" required data-msg="Please enter a valid email address." data-error-class="u-has-error" data-success-class="u-has-success">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <div class="mb-2">
                                <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover">Recover Password</button>
                            </div>
                        </form>

                        <div class="text-center mb-4">
                            <span class="small text-muted">Remember your password?</span>
                            <a class="js-animation-link small" href="javascript:;" data-target="#login"
                                data-link-group="idForm" data-animation-in="slideInUp">Login
                            </a>
                        </div>
                    </div>
                    <!-- End Forgot Password -->
                   </div>
               </div>
               <!-- End Content -->
           </div>
       </div>
   </div>
</aside>

@push('script')
    <script>
        function previewFile() {
            var preview = document.querySelector('img#imagePreview');
            var file = document.querySelector('input#imageUpload').files[0];
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>

    <script>
        $('#customer_registration').click(function() {
        // $('#customer_registration').on('submit',function(event){
            // event.preventDefault();
            const phoneNumber = $('#otp_mobile_number').val();
            const otp = $('#mobile_otp_code').val();
            const first_name = $('#first_name').val();
            const last_name = $('#last_name').val();
            const password = $('#signupPassword').val();

            $.ajax({
                url: "{{route('verifyOtp')}}",
                method: 'POST',
                data: {
                    _token: "{{csrf_token()}}",
                    phone_number: phoneNumber,
                    otp: otp,
                    first_name: first_name,
                    last_name: last_name,
                    password: password,
                },
                success: function(response) {
                    alertify.success(response.message);
                    location.reload();

                },
                error: function(error) {
                    alertify.error(error.responseJSON.message);
                }
            });
        });
        $('.send_otp').click(function() {
            let phone_number = $('#phone_number').val();
            $.ajax({
                url: "{{route('sent_otp_code')}}",
                type:"POST",
                data:{
                    _token: "{{csrf_token()}}",
                    phone_number: phone_number,
                },
                success:function(response){
                    alertify.success(response.message);
                    $('.otp-form-section').hide();
                    $('.registration-section').show();
                    $('#otp_mobile_number').val(phone_number);
                },
                error: function(error) {
                    alertify.error(error.responseJSON.message);
                }, finally: function() {
                    // caluculateGuestCartPrice();
                }
            });
        });

        $('#resend-otp').on('click', function() {
            let phone_number = $('#phone_number').val();

            $.ajax({
                url: "{{route('resendOtp')}}",
                method: 'POST',
                data: {
                    _token: "{{csrf_token()}}",
                    phone_number: phone_number
                },
                success: function(response) {
                    alertify.success(response.message);
                    $('#otp_mobile_number').val(phone_number);
                },
                error: function(error) {
                    alertify.error(error.responseJSON.message);
                }
            });
        });




        $('#user_type').on('change', function() {
            let user_type = $(this).val();

            if (user_type == 1) {
                $('.dealer-reg').hide();
                $('.present_address_star').hide();

                $('#nid_no').val('');
                $('#nid_no').removeAttr('required');
                $('#bin_no').val('');
                $('#bin_no').removeAttr('required');
                $('#tin_no').val('');
                $('#tin_no').removeAttr('required');
                $('#nid').val('');
                $('#nid').removeAttr('required');
                $('#bin').val('');
                $('#bin').removeAttr('required');
                $('#tin').val('');
                $('#tin').removeAttr('required');
                $('#imageUpload').val('');
                // $('#imageUpload').removeAttr('required');
                $('#present_address').removeAttr('required');
                $('.present_address_label').text('Address (Optional): ');
            } else if (user_type == 2)  {
                $('.dealer-reg').show();
                $('.present_address_star').hide();

                $('#nid_no').val('');
                $('#nid_no').removeAttr('required');
                $('#bin_no').attr('required', 'required');
                $('#tin_no').attr('required', 'required');
                $('#nid').val('');
                $('#nid').removeAttr('required');
                $('#bin').val('');
                $('#bin').removeAttr('required');
                $('#tin').val('');
                $('#tin').removeAttr('required');
                // $('#imageUpload').attr('required', 'required');
                $('#present_address').removeAttr('required');
                $('.present_address_label').text('Address (Optional): ');
            } else if (user_type == 3)  {
                $('.dealer-reg').show();
                $('.present_address_star').show();
                $('.present_address_label').text('Address: ');
                $('#nid_no').attr('required', 'required');
                $('#bin_no').attr('required', 'required');
                $('#tin_no').attr('required', 'required');
                $('#nid').attr('required', 'required');
                $('#bin').attr('required', 'required');
                $('#tin').attr('required', 'required');
                // $('#imageUpload').attr('required', 'required');
                $('#present_address').attr('required', 'required');
            }
        });
    </script>
@endpush
