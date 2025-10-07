<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container">

        <div class="row">

            <div class="col-md-6" style="display: block;margin: auto;padding-top: 100px;">
                <div style="background: #0080002e;padding: 50px 70px;border-radius: 15px;">
                    <h2 style="text-align: center;margin-bottom: 30px;">Login</h2>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group form-box">
                            <input type="username" name="username" class="form-control"
                                placeholder="Email or Mobile No." aria-label="Email Address">
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group form-box">
                            <input type="password" name="password" class="form-control" autocomplete="off"
                                placeholder="Password" aria-label="Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="checkbox form-group form-box clearfix ">
                            <div class="form-check checkbox-theme">
                                <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" data-toggle="modal" data-target="#myModal">Forgot Password ?</a>
                        </div>
                        <div class="form-group mb-0">
                            <button style="padding: 5px;border: 0;background: #fed700 !important;color: #0b0b0b;"
                                type="submit" class="btn-md btn-theme w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Forgot Password</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="{{route('forget_password')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email address:</label>
                                    <input name="email" type="email" class="form-control" placeholder="Enter email"
                                        id="email">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
