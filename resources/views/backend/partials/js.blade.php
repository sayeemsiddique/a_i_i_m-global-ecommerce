
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.js')}}"></script> --}}
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Theme Bundle-->

<!--begin::Page Vendors-->
{{-- <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script> --}}
<script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
{{-- <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}
<script src="{{ asset('assets/js/pages/crud/datatables/advanced/column-rendering.js') }}"></script>
<script src="{{ asset('assets/js/pages/crud/file-upload/dropzonejs.js') }}"></script>
<script src="{{ asset('assets/js/pages/features/charts/apexcharts.js') }}"></script>

{{-- <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/barcodes/JsBarcode.code128.min.js"></script> --}}

<script src="{{ asset('assets/plugins/custom/table2excel/table2excel.js') }}"></script>
<!--end::Page Vendors-->

{{-- custom js --}}
<script>
    //after window is loaded completely 
    window.onload = function(){
        //hide the preloader
        document.querySelector(".bbs-loader-wrapper").style.display = "none";
    }
</script>

<script> 
    // Select2
    $('.select2').select2();
</script>

<script> 
    // Initialize Plugins

    // Select2
    $('#division_id').select2();
    $('#district_id').select2();
    $('#upazila_id').select2();

    $('.select-multiple').select2({
        dropdownAutoWidth: false,
        multiple: true,
        width: '100%',
        height: '30px',
        placeholder: "Select One or More",
        allowClear: true
    });

</script>

<script> 
    let token = $('input[name = _token]').val();

    function backup() {
       let url= window.location.origin+`/admin/setting/db-backup`;
       
        $.ajax({
            type: "POST",
            url: url,
            data: {
                _token: token,
            },
            success: function (result) {
              alert("Data Backup Successfully!")

            },
            // error: function (errors) {

            //    alert("Data Backup Failed");
            // }
        });
        
    }
</script>

{{-- <script> 
    $('form')
        .each(function(){
            $(this).data('serialized', $(this).serialize())
        })
        .on('change input', function(){
            $(this)             
                .find('input:submit, button:submit')
                    .prop('disabled', $(this).serialize() == $(this).data('serialized'))
            ;
        })
        .find('input:submit, button:submit')
            .prop('disabled', true)
    ;
 </script> --}}


<!-- Ajax Files -->
@include('backend.ajax.addressDynamic')
@include('backend.ajax.designationDynamic')
{{-- @include('backend.ajax.searchFilter') --}}
{{-- @include('backend.ajax.searchUser') --}}
@include('backend.ajax.notification')
{{-- <script>
    var s = window.location.href;
    
    if(s.indexOf('?') != -1){
        s = s.substring(0, s.indexOf('?'));
    }

    $('[href*="'+s+'"]').closest('.menu-item-submenu').addClass('menu-item-open');
    
</script> --}}

<!-- Stack Scripts -->
@stack('stackScript')
