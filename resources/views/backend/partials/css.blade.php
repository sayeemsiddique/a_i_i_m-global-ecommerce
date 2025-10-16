<!--begin::W3css -->
<link rel="stylesheet" href="{{ asset('assets/css/w3.css') }}">
<!--begin::Page Vendors Styles(used by this page)-->
{{-- <link href="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" /> --}}
<!--end::Page Vendors Styles-->
<!--begin::Global Theme Styles(used by all pages)-->
<link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
{{-- <link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" /> --}}
<link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
<!--end::Global Theme Styles-->
<!--begin::Layout Themes(used by all pages)-->
{{-- <link href="{{asset('assets/css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{asset('assets/css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{asset('assets/css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{asset('assets/css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" /> --}}

{{-- <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" /> --}}

<style>
    /* custom css */
    .table thead th{
        color: #000 !important;
        white-space: nowrap;
    }
    body, html {
        font-family: 'Open Sans', Kalpurush, sans-serif;
        font-size: 14px!important;
    }
    .form-group label {
        font-size: 1.1rem;
    }
    li.breadcrumb-item a {
        color: #333 !important;
    }

    .table {
        text-align: center;
    }

    table.dataTable>thead>tr>td:not(.sorting_disabled), table.dataTable>thead>tr>th:not(.sorting_disabled) {
        padding-right: 18px;
    }

    .application-card .alert.alert-custom.alert-default {
        background-color: #0bb7af6b;
    }

    .service_item_list {
        margin: 0 auto 1rem auto;
    }
    .service_additional_item_list {
        margin: 0 auto 1rem auto;
    }

    .invalid-feedback {
        color: red !important;
    }

    .dash-count-card{
        height: 160px;
    }

    .form_header {
        font-size: 15px;
    }
    .weight_500 {
        font-weight: 500;
    }
    .dash-count-card .card-spacer {
        padding: 35px 10px !important;
    }
    .form-control {
        border: 1px solid #063852 !important;
    }
    .radio>span {
        border: 1px solid #063852;
    }
    .checkbox>span {
        border: 1px solid #063852;
    }
    .select2-container--default .select2-selection--multiple, .select2-container--default .select2-selection--single{
        border: 1px solid #063852 !important;
    }
    .card-header {
        border-bottom: 1px solid #063852;
    }
    .card-footer {
        border-top: 1px solid #063852;
    }
    .symbol.symbol-100 .symbol-label {
        width: 130px;
        height: 130px;
    }

    .aside {
        background-color: #fff;
    }
    .brand {
        background-color: #0A50A0;
    }
    .aside-menu {
        background-color: #EBF9CF;
        border-right: 1px solid #E9EAF4;
    }
    .aside-menu .menu-nav {
        background-color: #fff;
        padding-top: 0;
    }
    .aside-menu .menu-nav>.menu-item>.menu-heading .menu-text, .aside-menu .menu-nav>.menu-item>.menu-link .menu-text {
        color: #000;
        font-weight: 800;
        font-size: 16px;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item>.menu-heading .menu-text, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item>.menu-link .menu-text {
        color: #000;
        font-weight: 800;
        font-size: 15px
    }
    .aside-menu .menu-nav>.menu-item.menu-item-open>.menu-heading, .aside-menu .menu-nav>.menu-item.menu-item-open>.menu-link {
        background-color: #EBF9CF;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-active>.menu-heading, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-active>.menu-link {
        background-color: #EBF9CF;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-active>.menu-heading .menu-text, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-active>.menu-link .menu-text {
        color: #000;
        font-weight: 800;
    }
    .aside-menu .menu-nav>.menu-item.menu-item-open>.menu-heading .menu-text, .aside-menu .menu-nav>.menu-item.menu-item-open>.menu-link .menu-text {
        color: #000;
    }
    .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading, .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link {
        background-color: #EBF9CF;
    }
    .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-text, .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-text {
        color: #000;
        font-weight: 800;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link {
        background-color: #EBF9CF;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-text, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-text {
        color: #000;
    }
    .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-arrow, .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-arrow {
        color: #000;
    }
    .aside-menu .menu-nav>.menu-item.menu-item-open>.menu-heading .menu-arrow, .aside-menu .menu-nav>.menu-item.menu-item-open>.menu-link .menu-arrow {
        color: #000;
    }
    .aside-menu .menu-nav>.menu-item.menu-item-open>.menu-heading .menu-icon.svg-icon svg g [fill], .aside-menu .menu-nav>.menu-item.menu-item-open>.menu-link .menu-icon.svg-icon svg g [fill] {
        fill: #6E3CBC;
    }
    .brand .btn .svg-icon svg g [fill] {
        fill: #fff;
    }
    .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-icon, .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-icon {
        color: #6E3CBC;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-active>.menu-heading .menu-bullet.menu-bullet-dot>span, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-active>.menu-link .menu-bullet.menu-bullet-dot>span {
        background-color: #6E3CBC;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-bullet.menu-bullet-dot>span, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-bullet.menu-bullet-dot>span {
        background-color: #6E3CBC;
    }
    .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-icon.svg-icon svg g [fill], .aside-menu .menu-nav>.menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-icon.svg-icon svg g [fill] {
        fill: #6E3CBC;
    }
    .aside-menu .menu-nav>.menu-item.menu-item-active>.menu-heading, .aside-menu .menu-nav>.menu-item.menu-item-active>.menu-link {
        background-color: #EBF9CF;
    }
    .aside-menu .menu-nav>.menu-item.menu-item-active>.menu-heading .menu-text, .aside-menu .menu-nav>.menu-item.menu-item-active>.menu-link .menu-text {
        color: #000;
        font-weight: 800;
        font-size: 16px;
    }
    .aside-menu .menu-nav>.menu-item.menu-item-active>.menu-heading .menu-icon.svg-icon svg g [fill], .aside-menu .menu-nav>.menu-item.menu-item-active>.menu-link .menu-icon.svg-icon svg g [fill] {
        fill: #6E3CBC;
    }

    .header {
        background-color: #0A50A0;
    }
    li.menu-item.menu-item-open.menu-item-here.menu-item-submenu.menu-item-rel.menu-item-open.menu-item-here.menu-item-active a {
        color: #fff;
    }
    span.text-dark-50.font-weight-bolder.font-size-base.d-none.d-md-inline.mr-3 {
        color: #fff !important;
    }
    .header-fixed.subheader-fixed .subheader {
        height: 45px;
        background-color: #EBF9CF;
    }
    .btn.btn-clean.focus:not(.btn-text), .btn.btn-clean:focus:not(.btn-text), .btn.btn-clean:hover:not(.btn-text):not(:disabled):not(.disabled) {
        background-color: #6E3CBC;
    }
    .aside-menu .menu-nav>.menu-item>.menu-submenu .menu-subnav>.menu-item>.menu-link {
        padding-left: 60px;
    }

    label.checkbox, .service_item_list, .service_additional_item_list {
        margin: 0px 0 6px 0 !important;
    }

    .card.card-custom>.card-header .card-title, .card.card-custom>.card-header .card-title .card-label {
        font-weight: 700;
    }
    form#kt_form_1 label {
        font-weight: 700;
    }
    .alert-text.form_header span {
        font-weight: 800 !important;
    }
    #kt_aside_menu {
        background: #FFF !important;
    }
    #kt_aside_menu_wrapper {
        width: 265px;
    }
    #kt_content{
        margin-left: 15px;
    }
    .alert-text.service_item_price {
        font-weight: 700;
    }
    .alert-text.select_service_list {
        font-weight: 700;
    }
    .alert-text.select_service_item_list{
        font-weight: 700;
    }
    .alert-text.select_service_price_list{
        font-weight: 700;
    }
    .alert-text.service_additional_item_price {
        font-weight: 700;
    }
    .alert-text span.font-weight-bold.text-center {
        font-weight: 700 !important;
    }

    a.dash-click-card span {
        color: #fff;
    }
    input:focus-visible {
        border: none;
    }

    .breadcrumb li:first-child a {
        color: green !important;
    }
    .breadcrumb li:nth-child(2) a {
        color: red !important;
    }

    .hidden {
        display: none !important;
    }

    .checkbox-list .service_item_list .checkbox {
        margin-bottom: 12px !important;
    }
    .checkbox-list .service_additional_item_list .checkbox {
        margin-bottom: 12px !important;
    }

    .application-card table tr td {
        font-size: 1.1rem !important;
    }

    .form-group {
        margin-bottom: 15px;
    }

    a.swal2-confirm.swal2-styled {
        padding: 0;
    }

    .bbs-loader-wrapper{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 1000;
        background: #000;
        opacity: 0.9;
    }


    /*Loader 1- Spinning */
    #loader-1 #loader{
        position: relative;
        left: 50%;
        top: 50%;
        height: 20vw;
        width: 20vw;
        margin: -10vw 0 0 -10vw;
        border: 3px solid transparent;
        border-top-color: #3498db;
        border-bottom-color: #3498db;
        border-radius: 50%;
        z-index: 2;
        -webkit-animation: spin 2s linear infinite;
        -moz-animation: spin 2s linear infinite;
        -o-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    #loader-1 #loader:before{
        content: "";
        position: absolute;
        top:2%;
        bottom: 2%;
        left: 2%;
        right: 2%;
        border: 3px solid transparent;
        z-index: 2;
        border-top-color: #db213a;
        border-radius: 50%;
        -webkit-animation: spin 3s linear infinite;
        -moz-animation: spin 3s linear infinite;
        -o-animation: spin 3s linear infinite;
        animation: spin 3s linear infinite;

    }

    #loader-1 #loader:after{
        content: "";
        position: absolute;
        top:5%;
        bottom: 5%;
        left: 5%;
        right: 5%;
        border: 3px solid transparent;
        border-top-color: #dec52d;
        z-index: 2;
        border-radius: 50%;
        -webkit-animation: spin 1.5s linear infinite;
        -moz-animation: spin 1.5s linear infinite;
        -o-animation: spin 1.5s linear infinite;
        animation: spin 1.5s linear infinite;

    }

    /*Keyframes for spin animation */

    @-webkit-keyframes spin {
        0%   {
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }

        50% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(180deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }


    @-moz-keyframes spin {
        0%   {
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }

        50% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(180deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }

    @-o-keyframes spin {
        0%   {
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }

        50% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(180deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }

    @keyframes spin {
        0%   {
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }

        50% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(180deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }

    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-heading, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-link {
        background-color: #EBF9CF !important;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-heading .menu-text, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-link .menu-text {
        color: #000 !important;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-icon, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-icon {
        color: #494b74 !important;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-arrow, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-arrow {
        color: #494b74 !important;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-heading .menu-icon.svg-icon svg g [fill], .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item:not(.menu-item-parent):not(.menu-item-open):not(.menu-item-here):not(.menu-item-active):hover>.menu-link .menu-icon.svg-icon svg g [fill] {
        fill: #494b74 !important;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-heading .menu-icon, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-link .menu-icon {
        color: #494b74 !important;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-heading .menu-icon.svg-icon svg g [fill], .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-link .menu-icon.svg-icon svg g [fill] {
        fill: #494b74 !important;
    }
    .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-heading .menu-arrow, .aside-menu .menu-nav>.menu-item .menu-submenu .menu-item.menu-item-open>.menu-link .menu-arrow {
        color: #494b74 !important;
    }
    .aside-menu .menu-nav>.menu-item>.menu-submenu .menu-subnav>.menu-item>.menu-submenu .menu-subnav>.menu-item>.menu-link {
        padding-left: 80px;
    }

</style>

@stack('css')
