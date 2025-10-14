<!DOCTYPE html>
<html lang="en">

<head>
        <!-- Title -->
        <title>Home | {{$global_setting->title ?? ""}}</title>

        <!-- Required Meta Tags Always Come First -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('storage/setting') }}/{{ $global_setting->logo ?? '' }}">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;display=swap" rel="stylesheet">

        <!-- bootstrap -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">

        <!-- CSS Implementing Plugins -->
        <link rel="stylesheet" href="{{asset('frontend/assets/vendor/font-awesome/css/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/css/font-electro.css')}}">
        {{-- <link rel="stylesheet" href="{{asset('frontend/assets/css/jquery.jqZoom.css')}}"> --}}

        <link rel="stylesheet" href="{{asset('frontend/assets/vendor/animate.css/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/vendor/hs-megamenu/src/hs.megamenu.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/vendor/fancybox/jquery.fancybox.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/vendor/slick-carousel/slick/slick.css')}}">
        <link rel="stylesheet" href="{{asset('frontend/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}">

        <!-- CSS Template -->
        <link rel="stylesheet" href="{{asset('frontend/assets/css/theme.css')}}">

        <style>
         .avatar-upload {
            position: relative;
            max-width: 130px;
            margin: 0px auto;
            }
            .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
            }
            .avatar-upload .avatar-edit input {
            display: none;
            }
            .avatar-upload .avatar-edit input + label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
            }
            .avatar-upload .avatar-edit input + label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
            }

            .avatar-upload .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
            }
            .avatar-upload .avatar-preview > img {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            }

            .slick-slide img, .product-item__outer img {
                height: 150px;
                width: 100%;
                object-fit: cover;
            }
            .category-home img {
                height: 75px;
            }

            div#basicDropdownHoverInvoker i.font-size-22.ec.ec-shopping-bag {
                color: #fff;
                transition: 0.5s ease all;
                -webkit-transition: 0.5s ease all;
                -moz-transition: 0.5s ease all;
                -o-transition: 0.5s ease all;
            }
            div#basicDropdownHoverInvoker span.d-none.d-xl-block.font-weight-bold.font-size-16.text-gray-90.ml-3 {
                color: #fff;
                transition: 0.5s ease all;
                -webkit-transition: 0.5s ease all;
                -moz-transition: 0.5s ease all;
                -o-transition: 0.5s ease all;
            }
            div#basicDropdownHoverInvoker span.bg-lg-down-black.width-22.height-22.bg-primary.position-absolute.d-flex.align-items-center.justify-content-center.rounded-circle.left-12.top-8.font-weight-bold.font-size-12 {
                border-color: #fff !important;
                transition: 0.5s ease all;
                -webkit-transition: 0.5s ease all;
                -moz-transition: 0.5s ease all;
                -o-transition: 0.5s ease all;
            }
            div#basicDropdownHover .flex-center-between.px-4.pt-2 a.btn.btn-primary-dark-w.ml-md-2.px-5.px-md-4.px-lg-5 {
                color: #fff;
                transition: 0.5s ease all;
                -webkit-transition: 0.5s ease all;
                -moz-transition: 0.5s ease all;
                -o-transition: 0.5s ease all;
            }
            div#basicDropdownHoverInvoker:hover i.font-size-22.ec.ec-shopping-bag, div#basicDropdownHoverInvoker:hover span.d-none.d-xl-block.font-weight-bold.font-size-16.text-gray-90.ml-3, div#basicDropdownHover:hover .flex-center-between.px-4.pt-2 a.btn.btn-primary-dark-w.ml-md-2.px-5.px-md-4.px-lg-5 {
                color: #ff0000;
            }
            div#basicDropdownHoverInvoker:hover span.bg-lg-down-black.width-22.height-22.bg-primary.position-absolute.d-flex.align-items-center.justify-content-center.rounded-circle.left-12.top-8.font-weight-bold.font-size-12 {
                border-color: #ff0000 !important;
                color: #ff0000;
            }

            .u-header-topbar{
                background: #0A50A0;
            }
            .topbar-left a {
                color: #fff;
            }
            .u-header-topbar__nav-link {
                color: #fff !important;
            }

            .pass-eye-icon {
                display: inline-block;
                position: absolute;
                right: 10px;
                top: 10px;
            }

            @media (min-width: 1200px){
                .product-item:hover .product-item__inner:not(.remove-prodcut-hover) {
                    position: relative;
                }
            }

            @media only screen and (max-width: 768px) {
                .gov-logo{
                    display: none;
                }
		    }
        </style>

        @stack('css')

    </head>

    <body>


   @include('frontend.partials.navbar_alt')
