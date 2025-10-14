<!--begin::Footer-->
<div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
    <!--begin::Container-->
    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-1">{{date('Y')}} © {{ $global_setting->copyright ?? ''}}</span>
            {{-- <a class="text-dark-75 text-hover-primary"></a> --}}
            <a href="#" target="_blank" class="text-dark-75 text-hover-primary">| {{ $global_setting->title ?? ''}}</a>
        </div>

        <div class="text-dark order-2 order-md-1">
            <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Design & Developed by SEBPO</a>
        </div>
        <!--end::Copyright-->
    </div>
    <!--end::Container-->
</div>
<!--end::Footer-->
</div>
<!--end::Wrapper-->
</div>
<!--end::Page-->
</div>
<!--end::Main-->

<!-- begin::User Panel-->
@include('backend.partials.rightSidebar')
<!-- end::User Panel-->

<!--end::Header-->

<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
<span class="svg-icon">
<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->

<!--end::Svg Icon-->
</span>
</div>
<!--end::Scrolltop-->
</div>
<!--end::Content-->
</div>
<!--end::Demo Panel-->

<!--begin::Global Config(global config for global JS scripts)-->
@include('backend.partials.js')
<!--end::Page Scripts-->

</body>
<!--end::Body-->
</html>
