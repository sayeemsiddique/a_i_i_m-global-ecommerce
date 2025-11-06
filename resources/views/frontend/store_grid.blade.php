@extends('frontend.layout.master_alt')
@section('content')
<!-- ========== MAIN CONTENT ========== -->

@php
    $total_products = $products->total();

    if (isset($_GET['page']) and $_GET['page'] > 1) {
        $showing_from = ($products->perPage() * ($_GET['page'] - 1)) + 1;
    } else {
        $showing_from = 1;
    }



    if ($products->perPage() > count($products)) {
        $per_page = count($products) - 1;
    } else {
        $per_page = $products->perPage() - 1;
    }

    if ($products->total() == 0) {
        $showing_from = 0;
        $per_page = 0;
    }

    $showing_to = $showing_from + $per_page;
@endphp

<main id="content" role="main">
    <!-- breadcrumb -->
    <div class="bg-gray-13 bg-md-transparent">
        <div class="container">
            <!-- breadcrumb -->
            <div class="my-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('index')}}">Home</a></li>
                        {{-- <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Insulator</li> --}}
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->

    <div class="container">
        <div class="row mb-8">
            <div class="d-none d-xl-block col-xl-3 col-wd-2gdot5 mobile-display-option" >

                <x-front-filter/>

            </div>
            <div class="col-xl-9 col-wd-9gdot5">
                <!-- Shop-control-bar Title -->
                <div class="d-block d-md-flex flex-center-between mb-3">

                    <p class="font-size-14 text-gray-90 mb-0">Showing {{$showing_from}}–{{$showing_to}} of {{$total_products}} results</p>
                </div>
                <!-- End shop-control-bar Title -->
                <!-- Shop-control-bar -->
                <div class="bg-gray-1 flex-center-between borders-radius-9 py-1">
                    <div class="d-xl-none">
                        <!-- Account Sidebar Toggle Button -->
                        <a id="sidebarNavToggler1" class="btn btn-sm py-1 font-weight-normal" href="javascript:;" role="button"
                            {{-- aria-controls="sidebarContent1"
                            aria-haspopup="true"
                            aria-expanded="false"
                            data-unfold-event="click"
                            data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarContent1"
                            data-unfold-type="css-animation"
                            data-unfold-animation-in="fadeInLeft"
                            data-unfold-animation-out="fadeOutLeft"
                            data-unfold-duration="500" --}}
                            >
                            <i class="fas fa-sliders-h"></i> <span class="ml-1">Filters</span>
                        </a>
                        <!-- End Account Sidebar Toggle Button -->
                    </div>
                    <!-- <div class="px-3 d-none d-xl-block">
                        <ul class="nav nav-tab-shop" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-one-example1-tab" data-toggle="pill" href="#pills-one-example1" role="tab" aria-controls="pills-one-example1" aria-selected="false">
                                    <div class="d-md-flex justify-content-md-center align-items-md-center">
                                        <i class="fa fa-th"></i>
                                    </div>
                                </a>
                            </li>


                        </ul>
                    </div> -->
                    <div class="d-flex">
                        <div>
                            <!-- Select -->
                            <select class="sort_option form-control max-width-200 max-width-160-sm right-dropdown-0 px-2 px-xl-0"
                                data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0">

                                <option @if(isset($_GET['sort_option']) and $_GET['sort_option'] == 0) selected @endif value="0">Sort by latest</option>
                                <option @if(isset($_GET['sort_option']) and $_GET['sort_option'] == 1) selected @endif value="1">Sort by price: low to high</option>
                                <option @if(isset($_GET['sort_option']) and $_GET['sort_option'] == 2) selected @endif value="2">Sort by price: high to low</option>
                            </select>
                            <!-- End Select -->
                        </div>
                        <div class="ml-2 d-none d-xl-block">
                            <!-- Select -->
                            <select class="paginate_option form-control max-width-120"
                                data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0">
                                <option @if(isset($_GET['per_page']) and $_GET['per_page'] == 20) selected @endif value="20" selected>Show 20</option>
                                <option @if(isset($_GET['per_page']) and $_GET['per_page'] == 40) selected @endif value="40">Show 40</option>
                                <option @if(isset($_GET['per_page']) and $_GET['per_page'] == 100) selected @endif value="100">Show 100</option>
                            </select>
                            <!-- End Select -->
                        </div>
                    </div>
                    {{-- <nav class="px-3 flex-horizontal-center text-gray-20 d-none d-xl-flex">
                        <form method="post" class="min-width-50 mr-1">
                            <input size="2" min="1" max="3" step="1" type="number" class="form-control text-center px-2 height-35" value="1">
                        </form> of 3
                        <a class="text-gray-30 font-size-20 ml-2" href="#">→</a>
                    </nav> --}}
                </div>
                <!-- End Shop-control-bar -->
                <!-- Shop Body -->
                <!-- Tab Content -->
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab" data-target-group="groups">
                        <ul class="row list-unstyled products-group no-gutters">
                            @foreach ($products as $product)
                                <li class="col-6 col-md-3 col-wd-2gdot4 product-item">
                                    <div class="product-item__outer h-100 w-100">
                                        <div class="product-item__inner px-xl-4 p-3">
                                            <div class="product-item__body pb-xl-2">
                                                <div class="mb-2">
                                                    <a href="{{ route('store.grid') }}?c[]={{$product->productCategory->id ?? 0 }}" class="font-size-12 text-gray-5">{{$product->productCategory->name ?? ''}}</a>
                                                </div>
                                                <h5 class="mb-0 product-item__title">
                                                    <a style="min-height: 40px;" href="{{route('product-detail',Crypt::encryptString($product->id))}}?slug={{$product->slug}}" class="text-blue font-weight-bold">{{$product->name}}</a>
                                                </h5>
                                                <h6 class="product_code text-dark" style="font-size: 0.875rem;">Code: {{ $product->code }}</h6>
                                                <div class="mb-2">
                                                    <a href="{{route('product-detail',Crypt::encryptString($product->id))}}?slug={{$product->slug}}" class="d-block"><img loading="lazy" class="img-fluid" src="{{asset('storage/product')}}/{{$product->image}}" alt="{{$product->name}}"></a>
                                                </div>
                                                <div class="flex-center-between mb-1">

                                                    <div class="prodcut-price d-flex align-items-center position-relative">
                                                        <ins class="font-size-20 text-red text-decoration-none">{{$global_setting->currency ?? ""}}
                                                            @if ($product->has_varient == 1)
                                                                @if (isset($_GET['range']) and $_GET['range'] !='')
                                                                @php
                                                                    $range_data = explode('%3B', $_GET['range']);
                                                                    $product_min_price_from = explode(";",$range_data[0])[0];
                                                                @endphp
                                                                {{$product->productVarient->where("discount_price",'>=',$product_min_price_from)->min('discount_price')}}
                                                                @else
                                                                {{$product->productVarient->min('discount_price')}}
                                                                @endif

                                                            @else
                                                                {{$product->discount_price}}
                                                            @endif
                                                        </ins>
                                                        {{-- <del class="font-size-12 tex-gray-6 position-absolute bottom-100">
                                                            @if ($product->has_varient == 1)
                                                                @if ($product->productVarient->min('price') > $product->productVarient->min('discount_price'))
                                                                {{$product->productVarient->min('price')}}
                                                                @endif
                                                            @else
                                                                @if ($product->discount_price < $product->price)
                                                                    {{$product->price}}
                                                                @endif
                                                            @endif
                                                        </del> --}}
                                                    </div>

                                                    {{-- <div class="d-none d-xl-block prodcut-add-cart">
                                                        <a href="{{route('product-detail',Crypt::encryptString($product->id))}}?slug={{$product->slug}}" class="btn-add-cart btn-primary transition-3d-hover"><i class="ec ec-add-to-cart"></i></a>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            {{-- <div class="product-item__footer">
                                                <div class="border-top pt-2 flex-center-between flex-wrap">
                                                    <a href="#" class="text-gray-6 font-size-13"><i class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                                    <a href="#" class="text-gray-6 font-size-13"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </li>
                            @endforeach


                        </ul>
                    </div>



                </div>
                <!-- End Tab Content -->
                <!-- End Shop Body -->
                <!-- Shop Pagination -->
                <nav class="d-md-flex justify-content-between align-items-center border-top pt-3" aria-label="Page navigation example">
                    <div class="text-center text-md-left mb-3 mb-md-0">Showing {{$showing_from}}–{{$showing_to}} of {{$total_products}} results</div>
                    {{$products->appends($_GET)->links()}}
                    {{-- <ul class="pagination mb-0 pagination-shop justify-content-center justify-content-md-start">
                        <li class="page-item"><a class="page-link current" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                    </ul> --}}
                </nav>
                <!-- End Shop Pagination -->
            </div>
        </div>

    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/vendor/ion-rangeslider/css/ion.rangeSlider.css')}}">
@endpush

@push('script')
    <script src="{{asset('frontend/assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/components/hs.range-slider.js')}}"></script>
    <script src="{{asset('frontend/assets/js/components/hs.scroll-nav.js')}}"></script>

    <script>
        $('.sort_option, .paginate_option').change( function() {
            var sort_option = $('.sort_option option:selected').val();
            var paginate_option = $('.paginate_option option:selected').val();

            $("input[name='per_page']").val(paginate_option);
            $("input[name='sort_option']").val(sort_option);
            $("#sidebar_form").submit();

        });

        $('#sidebarNavToggler1').click( function() {
            $('#sidebar_form').css('display','block');
        });

    </script>

@endpush

