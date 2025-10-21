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
                            <h3 class="card-title">Update Password</h3>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <form class="form account-details-form" action="{{ route('edit_password', $user->id) }}" method="post">
                                        @csrf

                                        <div class="form-group">
                                            <label class="text-dark" for="cur-password">Current Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control form-control-md" id="cur-password" name="current_password" required placeholder="Enter Current Password">
                                        </div>

                                        <div class="form-group">
                                            <label class="text-dark" for="new-password">New Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control form-control-md" id="new-password" name="password" required placeholder="Enter New Password">
                                        </div>
                                        <div class="form-group mb-10">
                                            <label class="text-dark" for="conf-password">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control form-control-md" id="conf-password" name="password_confirmation" required placeholder="Confirm New Password">
                                        </div>

                                        <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

