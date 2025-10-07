<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
    <!--begin::Header-->
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">User Profile
            {{-- <small class="text-muted font-size-sm ml-2">12 messages</small> --}}
        </h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="offcanvas-content pr-5 mr-n5">
    <!--begin::Header-->
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                @if (Auth::user()->image)
                    <div class="symbol-label" style="background-image:url('{{asset('storage/users/'.Auth::user()->image)}}')"></div>

                @else
                    <div class="symbol-label" style="background-image:url('{{asset('assets/media/users/blank.png')}}')"></div>
                @endif
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{Auth::user()->first_name}} {{Auth::user()->middle_name}} {{Auth::user()->last_name}}</a>
                <div class="text-muted mt-1">{{Auth::user()->role ? Auth::user()->role->display_name : ''}}</div>
                <div class="navi mt-2">
                    <a href="{{ route('admin.user.editProfile', ['username'=>Auth::user()->username,'user'=>Auth::user()]) }}" class="btn btn-block btn-sm btn-light-primary font-weight-bolder py-2 px-5">Update Profile</a>
                </div>
                <div class="navi mt-2">
                    <a href="{{ route('logout') }}" class="btn btn-block btn-sm btn-light-danger font-weight-bolder py-2 px-5" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    <!--end::Header-->
    
    </div>
<!--end::Content-->
</div>