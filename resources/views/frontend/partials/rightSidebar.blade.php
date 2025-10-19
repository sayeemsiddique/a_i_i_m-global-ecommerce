<div class="modal fade" id="forgotPassword">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 10px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                {{-- <form action="{{ route('forget_password') }}" method="post"> --}}
                    {{-- @csrf --}}

                    <div class="forgot-password-otp-section">
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="recoverMobile">Your Mobile</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="recoverMobileLabel">
                                            <span class="fas fa-mobile"></span>
                                        </span>
                                    </div>

                                    <input type="number" class="form-control" name="mobile" id="recoverMobile" placeholder="Your mobile" aria-label="Your mobile" aria-describedby="recoverMobileLabel" required data-msg="Please enter a valid mobile address." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <div style="cursor: pointer;" class="btn btn-primary d-block text-white send_forgot_otp">{{__('Send OTP')}}</div>
                    </div>

                    <div class="forgot-password-otp-verification-section">
                        <input type="hidden" name="otp_mobile" id="forgot_otp_mobile_number" value="">
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="recoverOtp">Your OTP</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="recoverOtpLabel">
                                            <span class="fas fa-code"></span>
                                        </span>
                                    </div>

                                    <input type="number" class="form-control" name="otp" id="recoverOtp" placeholder="Your otp" aria-label="Your otp" aria-describedby="recoverOtpLabel" required data-msg="Please enter a valid otp address." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="recoverNewPassword">New Password</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="recoverNewPasswordLabel">
                                            <span class="fas fa-unlock"></span>
                                        </span>
                                    </div>

                                    <input type="password" class="form-control" name="new_password" id="recoverNewPassword" placeholder="Your new password" aria-label="Your new password" aria-describedby="recoverNewPasswordLabel" required data-msg="Please enter a valid new password address." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="js-form-message js-focus-state">
                                <label class="sr-only" for="recoverConfirmPassword">Confirm Password</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="recoverConfirmPasswordLabel">
                                            <span class="fas fa-unlock"></span>
                                        </span>
                                    </div>

                                    <input type="password" class="form-control" name="confirm_password" id="recoverConfirmPassword" placeholder="Your confirm password" aria-label="Your confirm password" aria-describedby="recoverConfirmPasswordLabel" required data-msg="Please enter a valid confirm password address." data-error-class="u-has-error" data-success-class="u-has-success">
                                </div>
                            </div>
                        </div>
                        <div style="cursor: pointer;" class="btn btn-primary d-block text-white send_reset_verify_otp">{{__('Reset Password')}}</div>
                    </div>

                {{-- </form> --}}
                <br/>
                <a onclick="forgotPassword(this)" href="javascript:;" role="button" class="btn btn-link">
                    Back to Sign in
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 5px 10px;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <ul class="nav nav-tabs nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab_section_1">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab_section_2">Sign up</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="tab_section_1" class="container tab-pane active"><br>
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
                               <div class="hidden_form_section">

                               </div>
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
                                   <a class="js-animation-link small link-muted" onclick="forgotPassword(this)" href="javascript:;">Forgot Password?</a>
                               </div>

                               <div class="mb-2">
                                   {{-- <button type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover">Login</button> --}}
                                   <span style="cursor: pointer;" id="submit_login_button" type="submit" class="btn btn-block btn-sm btn-primary transition-3d-hover">Login</span>
                               </div>

                               {{-- <div class="text-center mb-4">
                                   <span class="small text-muted">Do not have an account?</span>

                                   <a class="js-animation-link small text-dark" href="javascript:;"
                                       data-target="#signup" data-link-group="idForm"
                                       data-animation-in="slideInUp">Signup
                                   </a>
                               </div> --}}
                           </div>
                        </form>
                    </div>

                    <div id="tab_section_2" class="container tab-pane fade"><br>
                        <form class="js-validate"  action="{{ route('user_.registration') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                           <!-- Signup -->
                           <div id="signup" data-target-group="idForm">
                               <!-- Title -->
                               <header class="text-center mb-7">
                                   <h2 class="h4 mb-0">Welcome!</h2>
                                   <p>Fill out the form to get started.</p>
                               </header>
                               <!-- End Title -->
                               <div class="hidden_form_section">

                               </div>
                               <div class="otp-form-section" style="display: block">
                                    <div class="form-group">
                                        <label for="phone_number">{{__('Mobile Number')}} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="{{__('Mobile Number')}}" required>
                                    </div>
                                    <div style="cursor: pointer;" class="btn btn-primary d-block text-white send_otp">{{__('Send OTP')}}</div>
                               </div>

                               <div class="registration-section" style="display: none">
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
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{{-- <aside id="sidebarContent" class="u-sidebar u-sidebar__lg" aria-labelledby="sidebarNavToggler">
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
</aside> --}}

@push('script')
    <script>

        function forgotPassword(element) {
            $('#myModal').modal('toggle');
            $('#forgotPassword').modal('toggle');
        }


        $(document).ready(function() {
            $('.forgot-password-otp-verification-section').hide();
            $('#openModalBtn').on('click', function() {
                $('#myModal').modal('toggle');
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

        $('.send_forgot_otp').click(function() {
            let phone_number = $('#recoverMobile').val();
            $.ajax({
                url: "{{route('sent_forgot_password_otp_code')}}",
                type:"POST",
                data:{
                    _token: "{{csrf_token()}}",
                    phone_number: phone_number,
                },
                success:function(response){
                    alertify.success(response.message);
                    $('.forgot-password-otp-section').hide();
                    $('.forgot-password-otp-verification-section').show();
                    $('#forgot_otp_mobile_number').val(phone_number);
                },
                error: function(error) {
                    alertify.error(error.responseJSON.message);
                }, finally: function() {
                    // caluculateGuestCartPrice();
                }
            });
        });
        $('.send_reset_verify_otp').click(function() {
            let phone_number = $('#forgot_otp_mobile_number').val();
            let recover_otp = $('#recoverOtp').val();
            let new_password = $('#recoverNewPassword').val();
            let confirm_password = $('#recoverConfirmPassword').val();

            $.ajax({
                url: "{{route('forgot_password_otp_verify')}}",
                type:"POST",
                data:{
                    _token: "{{csrf_token()}}",
                    phone_number: phone_number,
                    recover_otp: recover_otp,
                    new_password: new_password,
                    confirm_password: confirm_password,
                },
                success:function(response){
                    alertify.success(response.message);
                    $('.forgot-password-otp-verification-section').hide();
                    $('#myModal').modal('toggle');
                },
                error: function(error) {
                    alertify.error(error.responseJSON.message);
                }, finally: function() {
                    // caluculateGuestCartPrice();
                }
            });
        });

        $('#customer_registration').click(function() {
        // $('#customer_registration').on('submit',function(event){
            // event.preventDefault();
            const phoneNumber = $('#otp_mobile_number').val();
            const otp = $('#mobile_otp_code').val();
            const first_name = $('#first_name').val();
            const last_name = $('#last_name').val();
            const password = $('#signupPassword').val();
            const product_id = $('.hidden_form_section').find('[name="product_id"]').val() || 0;
            const varient = $('.hidden_form_section').find('[name="varient"]').val() || 0;
            const quantity = $('.hidden_form_section').find('[name="quantity"]').val() || 0;
            const buy_now = $('.hidden_form_section').find('[name="buy_now"]').val() || 0;

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
                    product_id: product_id,
                    varient: varient,
                    quantity: quantity,
                    buy_now: buy_now,
                },
                success: function(response) {
                    alertify.success(response.message);
                    setTimeout(function(){
                        if (response.cart_id) {
                                window.location.href = "{{ route('checkout') }}?transition=1&buy_now=1&cart_id="+response.cart_id;
                        } else {
                                location.reload();
                        }
                    }, 1500);

                },
                error: function(error) {
                    alertify.error(error.responseJSON.message);
                }
            });
        });

        $('#submit_login_button').click(function() {
            const email_mobile = $('#signinEmail').val();
            const password = $('#signinPassword').val();
            const product_id = $('.hidden_form_section').find('[name="product_id"]').val() || 0;
            const varient = $('.hidden_form_section').find('[name="varient"]').val() || 0;
            const quantity = $('.hidden_form_section').find('[name="quantity"]').val() || 0;
            const buy_now = $('.hidden_form_section').find('[name="buy_now"]').val() || 0;

            $.ajax({
                url: "{{ route('login') }}",
                method: 'POST',
                data: {
                    _token: "{{csrf_token()}}",
                    username: email_mobile,
                    password: password,
                    product_id: product_id,
                    varient: varient,
                    quantity: quantity,
                    buy_now: buy_now,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alertify.success(response.message);
                    if (response.cart_id) {
                        window.location.href = "{{ route('checkout') }}?transition=1&buy_now=1&cart_id="+response.cart_id;
                    } else {
                        location.reload();
                    }


                },
                error: function(error) {
                    alertify.error(error.responseJSON.message);
                }
            });
        });
    </script>
    {{-- <script>
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
    </script> --}}
@endpush
