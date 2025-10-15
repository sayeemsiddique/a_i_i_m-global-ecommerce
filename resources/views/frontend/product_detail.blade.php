@extends('frontend.layout.master_alt')

@push('css')
    <style>
        .product-item__inner {
            transition: 0.5s ease all;
            -webkit-transition: 0.5s ease all;
            -moz-transition: 0.5s ease all;
            -o-transition: 0.5s ease all;
        }

        .product-item:hover .product-item__inner {
            transform: scale(1.05);
        }
        .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
        }
        .rate:not(:checked) > input {
        position:absolute;
        display: none;
        }
        .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
        }
        .rate:not(:checked) > label:before {
        content: '★ ';
        }
        .rate > input:checked ~ label {
        color: #ffc700;
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
        color: #deb217;
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
        }
        .rating-container .form-control:hover, .rating-container .form-control:focus{
        background: #fff;
        border: 1px solid #ced4da;
        }
        .rating-container textarea:focus, .rating-container input:focus {
        color: #000;
        }
        /* End */
    </style>
@endpush

@section('content')
@php
    $has_discount = 0;
    $sale_price_without_discount = 0;
    // $cart_category = $latest_cart_item->productInfo->category_id ?? 0;
    // $product_category = $product->category_id ?? 0;
    if ($product->has_varient == 1) {
        $in_stock = $product->productAllStock()->where('varient_id', '!=', 0)->sum('quantity');
        $sale_price = $product->cheapVarient->discount_price ?? 0;

        if ($product->cheapVarient) {
            if (in_array(($product->cheapVarient->discount_type ?? 0), [1,2])) {
                $has_discount = 1;

                $sale_price_without_discount = $product->cheapVarient->price;
            }

            if ($product->cheapVarient->discount_type == 1) {
                $sale_price = $product->cheapVarient->price - $product->cheapVarient->discount;
            } else if($product->cheapVarient->discount_type == 2) {
                $sale_price = $product->cheapVarient->price - (($product->cheapVarient->price * $product->cheapVarient->discount)/ 100);
            } else {
                $sale_price = $product->cheapVarient->price;
            }
        }


    } else {
        $in_stock = $product->productAllStock()->where('varient_id', 0)->sum('quantity');
        $sale_price = $product->discount_price;
        if (in_array(($product->discount_type ?? 0),[1,2])) {
            $has_discount = 1;
            $sale_price_without_discount = $product->price;
        }
        if ($product->discount_type == 1) {
            $sale_price = $product->price - $product->discount;
        } else if($product->discount_type == 2) {
            $sale_price = $product->price - (($product->price * $product->discount)/ 100);
        } else {
            $sale_price = $product->price;
        }
    }

@endphp
<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main">
    <!-- breadcrumb -->
    <div class="bg-gray-13 bg-md-transparent">
        <div class="container">
            <!-- breadcrumb -->
            <div class="my-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{route('index')}}">Home</a></li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1">
                            <a href="{{route('store.grid')}}?c[]={{$product->category_id}}">
                                {{$product->productCategory->name ?? ''}}
                            </a>
                        </li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{$product->name}}</li>
                    </ol>
                </nav>
            </div>
            <!-- End breadcrumb -->
        </div>
    </div>
    <!-- End breadcrumb -->
    <div class="container">
        <!-- Single Product Body -->
        <div class="mb-xl-14 mb-6">
            <div class="row">
                <div class="col-md-5 mb-4 mb-md-0">
                    <div id="sliderSyncingNav" class="js-slick-carousel u-slick mb-2"
                        data-infinite="true"
                        data-arrows-classes="d-none d-lg-inline-block u-slick__arrow-classic u-slick__arrow-centered--y rounded-circle"
                        data-arrow-left-classes="fas fa-arrow-left u-slick__arrow-classic-inner u-slick__arrow-classic-inner--left ml-lg-2 ml-xl-4"
                        data-arrow-right-classes="fas fa-arrow-right u-slick__arrow-classic-inner u-slick__arrow-classic-inner--right mr-lg-2 mr-xl-4"
                        data-nav-for="#sliderSyncingThumb">
                        <div class="js-slide">
                            <div class="zoom-box" style="display: inline-block;width: 200px;height: 300px;">
                                <img loading="lazy" class="img-fluid imgZoom" src="{{asset('storage/product')}}/{{$product->image}}" alt="Image Description">
                            </div>
                        </div>

                        @foreach ($product->productGallery as $Gallery)

                        <div class="js-slide">
                            <div class="zoom-box" style="display: inline-block;width: 200px;height: 300px;">

                                <img loading="lazy" class="img-fluid imgZoom" src="{{asset('storage/gallery')}}/{{$Gallery->name}}" alt="Image Description">
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <div id="sliderSyncingThumb" class="js-slick-carousel u-slick u-slick--slider-syncing u-slick--slider-syncing-size u-slick--gutters-1 u-slick--transform-off"
                        data-infinite="true"
                        data-slides-show="5"
                        data-is-thumbs="true"
                        data-nav-for="#sliderSyncingNav">

                        <div class="js-slide" style="cursor: pointer;">
                            <img loading="lazy" style="height: auto" class="img-fluid" src="{{asset('storage/product')}}/{{$product->image}}" alt="Image Description">

                        </div>
                        @foreach ($product->productGallery as $Gallery)
                        <div class="js-slide" style="cursor: pointer;">
                            <img loading="lazy" style="height: auto" class="img-fluid" src="{{asset('storage/gallery')}}/{{$Gallery->name}}" alt="Image Description">
                        </div>
                        @endforeach

                    </div>
                </div>
                <div class="col-md-7 mb-md-6 mb-lg-0">
                    <div class="mb-2">
                        <div class="mb-1 pb-md-1">
                            <a href="{{route('store.grid')}}?c[]={{$product->category_id}}" class="font-size-12 text-gray-5 mb-2 d-inline-block">{{$product->productCategory->name ?? ''}}</a>
                            <h2 class="font-size-25 text-lh-1dot2">
                                {{$product->name}}
                            </h2>
                            <div class="mb-2">
                                <a class="d-inline-flex align-items-center small font-size-15 text-lh-1" href="#">

                                    <div class="text-warning mr-2">
                                        @if ($review_avg == 1)
                                            <small class="fas fa-star"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                        @elseif ($review_avg == 2)
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                        @elseif ($review_avg == 3)
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                        @elseif ($review_avg == 4)
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="far fa-star text-muted"></small>
                                        @elseif ($review_avg == 5)
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                            <small class="fas fa-star"></small>
                                        @else
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                            <small class="far fa-star text-muted"></small>
                                        @endif
                                    </div>

                                    <span class="text-secondary font-size-13">({{ $review_count }} reviews)</span>
                                </a>
                            </div>
                            <div class="d-md-flex align-items-center">
                                <i class="fas fa-shopping-cart @if ($in_stock > 0) text-green @else text-danger @endif" style="font-size: 13px; margin: 10px 0;"></i>

                                <div class="ml-md-3 text-gray-9 font-size-14">Availability:

                                    @if ($in_stock > 0)
                                            <input type="hidden" class="stock_quantity" value="{{$in_stock}}">
                                        <span class="text-green font-weight-bold">In stock</span>
                                    @else
                                        <span class="text-danger font-weight-bold">Out of stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- <div class="flex-horizontal-center flex-wrap mb-4"> --}}
                            {{-- <a href="#" class="text-gray-6 font-size-13 mr-2"><i class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a> --}}

                        {{-- </div> --}}
                        <p style="margin-bottom: 12px;"><strong>Code:</strong> {{$product->code}}</p>
                        <div class="mb-4">
                            <div class="d-flex align-items-baseline">
                                <ins class="font-size-36 text-decoration-none">

                                    ৳ <span class="price_append_area">{{$sale_price}}</span>
                                    @if ($has_discount == 1)
                                        <del class="font-size-20 ml-2 text-danger">৳ {{$sale_price_without_discount}}</del>
                                    @endif

                                </ins>

                                {{-- <del class="font-size-20 ml-2 text-gray-6">৳ 2,299.00</del> --}}
                            </div>
                        </div>
                        @if ($product->has_varient == 1)
                        <div class="py-3 mb-4">
                            <div class="d-flex align-items-center">
                                <h6 class="font-size-14 mb-0"><strong>Variant: </strong></h6>

                                <!-- Select -->
                                <select style="max-width:280px;" class="form-control ml-3 varient_id"
                                    data-style="btn-sm bg-white font-weight-normal py-2 border" required autocomplete="off">
                                    <option value="">Select</option>
                                    @foreach ($product->productVarient as $productVarient)

                                        <option @if (($productVarient->productStock->quantity ?? 0) <= 0) style='color: #963e3eff' @endif data-price="{{$productVarient->discount_price}}" data-quantity="{{$productVarient->productStock->quantity ?? 0}}" value="{{$productVarient->id}}">
                                            @foreach ($productVarient->productVarientData as $VarientData)
                                                {{-- {{$VarientData}} --}}
                                                {{$VarientData->varientTypeInfo->name ?? ''}}: {{$VarientData->data_value}} @if(!($loop->last)) , @endif
                                            @endforeach
                                             @if (($productVarient->productStock->quantity ?? 0) <= 0)- Out of stock @endif
                                        </option>
                                    @endforeach

                                </select>
                                <!-- End Select -->
                            </div>
                        </div>
                        @else
                            <input type="hidden" class="productSingleStock" value="{{$product->productSingleStock->quantity ?? 0}}">
                        @endif

                        <div class="d-md-flex align-items-end mb-3">
                            <div class="max-width-150 mb-4 mb-md-0">
                                <h6 class="font-size-14"><strong>Quantity</strong></h6>
                                <!-- Quantity -->
                                <div class="border rounded-pill py-2 px-3 border-color-1">
                                    <div class="js-quantity row align-items-center">
                                        <div class="col">
                                            <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none" type="text" value="1" autocomplete="off">
                                        </div>
                                        <div class="col-auto pr-1">
                                            <a class="js-minus-action btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
                                                <small class="fas fa-minus btn-icon__inner"></small>
                                            </a>
                                            <a class="js-plus-action btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" href="javascript:;">
                                                <small class="fas fa-plus btn-icon__inner"></small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Quantity -->
                            </div>
                            <div class="ml-md-3">
                                @if ($in_stock > 0)
                                    <div style="cursor:pointer" class="btn px-5 btn-primary-dark transition-3d-hover add-to-cart-button"><i class="ec ec-add-to-cart mr-2 font-size-20"></i> Add to Cart</div>
                                    <div style="cursor:pointer" class="btn px-5 btn-success transition-3d-hover buy-add-to-cart-button"><i class="ec ec-newsletter mr-2 font-size-20"></i> Buy Now</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Product Body -->

        <!-- Single Product Tab -->
        <div class="mb-8">
            <div class="position-relative position-md-static px-md-6">
                <ul class="nav nav-classic nav-tab nav-tab-lg justify-content-xl-center flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble border-0 pb-1 pb-xl-0 mb-n1 mb-xl-0" id="pills-tab-8" role="tablist">
                    {{-- <li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">
                        <a class="nav-link active" id="Jpills-one-example1-tab" data-toggle="pill" href="#Jpills-one-example1" role="tab" aria-controls="Jpills-one-example1" aria-selected="true">Accessories</a>
                    </li> --}}
                    <li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">
                        <a class="nav-link active" id="Jpills-two-example1-tab" data-toggle="pill" href="#Jpills-two-example1" role="tab" aria-controls="Jpills-two-example1" aria-selected="false">Description</a>
                    </li>

                    <li class="nav-item flex-shrink-0 flex-xl-shrink-1 z-index-2">
                        <a class="nav-link" id="Jpills-four-example1-tab" data-toggle="pill" href="#Jpills-four-example1" role="tab" aria-controls="Jpills-four-example1" aria-selected="false">Reviews</a>
                    </li>
                </ul>
            </div>
            <!-- Tab Content -->
            <div class="borders-radius-17 border p-4 mt-4 mt-md-0 px-lg-10 py-lg-9">
                <div class="tab-content" id="Jpills-tabContent">

                    <div class="tab-pane fade active show" id="Jpills-two-example1" role="tabpanel" aria-labelledby="Jpills-two-example1-tab">
                        <h3 class="font-size-24 mb-3">Description</h3>
                        <div class="w-100">
                            {!!$product->productInfo->description ?? ''!!}
                        </div>
                    </div>

                    <div class="tab-pane fade" id="Jpills-four-example1" role="tabpanel" aria-labelledby="Jpills-four-example1-tab">
                        <div class="row mb-8">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h3 class="font-size-18 mb-6">Based on {{ $review_count }} reviews</h3>
                                    <h2 class="font-size-30 font-weight-bold text-lh-1 mb-0">{{ $review_avg }}</h2>
                                    <div class="text-lh-1">overall</div>
                                </div>

                                <!-- Ratings -->
                                <ul class="list-unstyled">
                                    <li class="py-1">
                                        <a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
                                            <div class="col-auto mb-2 mb-md-0">
                                                <div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                </div>
                                            </div>
                                            {{-- <div class="col-auto mb-2 mb-md-0">
                                                <div class="progress ml-xl-5" style="height: 10px; width: 200px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div> --}}
                                            <div class="col-auto text-right">
                                                <span class="text-gray-90">({{ $review_count5 }} review)</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="py-1">
                                        <a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
                                            <div class="col-auto mb-2 mb-md-0">
                                                <div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                </div>
                                            </div>
                                            {{-- <div class="col-auto mb-2 mb-md-0">
                                                <div class="progress ml-xl-5" style="height: 10px; width: 200px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 53%;" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div> --}}
                                            <div class="col-auto text-right">
                                                <span class="text-gray-90">({{ $review_count4 }} review)</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="py-1">
                                        <a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
                                            <div class="col-auto mb-2 mb-md-0">
                                                <div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                </div>
                                            </div>
                                            {{-- <div class="col-auto mb-2 mb-md-0">
                                                <div class="progress ml-xl-5" style="height: 10px; width: 200px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div> --}}
                                            <div class="col-auto text-right">
                                                <span class="text-gray-90">({{ $review_count3 }} review)</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="py-1">
                                        <a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
                                            <div class="col-auto mb-2 mb-md-0">
                                                <div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
                                                    <small class="fas fa-star"></small>
                                                    <small class="fas fa-star"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                </div>
                                            </div>
                                            {{-- <div class="col-auto mb-2 mb-md-0">
                                                <div class="progress ml-xl-5" style="height: 10px; width: 200px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div> --}}
                                            <div class="col-auto text-right">
                                                <span class="text-gray-90">({{ $review_count2 }} review)</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="py-1">
                                        <a class="row align-items-center mx-gutters-2 font-size-1" href="javascript:;">
                                            <div class="col-auto mb-2 mb-md-0">
                                                <div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
                                                    <small class="fas fa-star"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                    <small class="far fa-star text-muted"></small>
                                                </div>
                                            </div>
                                            {{-- <div class="col-auto mb-2 mb-md-0">
                                                <div class="progress ml-xl-5" style="height: 10px; width: 200px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 1%;" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div> --}}
                                            <div class="col-auto text-right">
                                                <span class="text-gray-90">({{ $review_count1 }} review)</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End Ratings -->
                            </div>
                            <div class="col-md-6">
                                <h3 class="font-size-18 mb-5">Add a review</h3>

                                @if (auth()->check())
                                    @if ($user_already_purchased)
                                    <!-- Form -->
                                    <form class="js-validate" method="post" action="{{ route('admin.review.store', [$product->id, Auth::id()]) }}">
                                        @csrf

                                        <div class="row align-items-center mb-4">
                                            <div class="col-md-4 col-lg-3">
                                                <label for="rating" class="form-label mb-0">Your Rating</label>
                                            </div>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="text-warning text-ls-n2 font-size-16">
                                                    <div class="rate">
                                                        <input type="radio" id="star5" class="rate" name="rating" value="5" @if($user_review and ($user_review->rating ?? 0) == 5) checked @endif/>
                                                        <label for="star5" title="text">5 stars</label>
                                                        <input type="radio" id="star4" class="rate" name="rating" value="4" @if($user_review and ($user_review->rating ?? 0) == 4) checked @endif/>
                                                        <label for="star4" title="text">4 stars</label>
                                                        <input type="radio" id="star3" class="rate" name="rating" value="3" @if($user_review and ($user_review->rating ?? 0) == 3) checked @endif/>
                                                        <label for="star3" title="text">3 stars</label>
                                                        <input type="radio" id="star2" class="rate" name="rating" value="2" @if($user_review and ($user_review->rating ?? 0) == 2) checked @endif>
                                                        <label for="star2" title="text">2 stars</label>
                                                        <input type="radio" id="star1" class="rate" name="rating" value="1" @if($user_review and ($user_review->rating ?? 0) == 1) checked @endif/>
                                                        <label for="star1" title="text">1 star</label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="js-form-message form-group mb-3 row">
                                            <div class="col-md-4 col-lg-3">
                                                <label for="descriptionTextarea" class="form-label">Your Review</label>
                                            </div>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea class="form-control" rows="3" id="descriptionTextarea"
                                                data-msg="Please enter your message."
                                                data-error-class="u-has-error"
                                                data-success-class="u-has-success" name="comment">{!! $user_review->comment ?? '' !!}</textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-md-4 offset-lg-3 col-auto">
                                                <button type="submit" class="btn btn-primary-dark btn-wide transition-3d-hover">Add Review</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Form -->
                                    @else
                                        <div class="col-md-12">
                                            <h2 class="">Please complete purchase to add a review!</h2>
                                        </div>
                                    @endif

                                @else
                                    <div class="col-md-12">
                                        <h2 class="">Login to add a review!</h2>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <h2 class="font-size-30 font-weight-bold text-lh-1 mb-0">All Reviews</h2>
                        </div>
                        <!-- Review -->
                        @foreach ($reviews as $review)
                            <div class="border-bottom border-color-1 pb-4 mb-4">

                                <!-- Review Rating -->
                                <div class="d-flex justify-content-between align-items-center text-secondary font-size-1 mb-2">
                                    <div class="text-warning text-ls-n2 font-size-16" style="width: 80px;">
                                        @for ($i = 1; $i <= $review->rating; $i++)
                                            <small class="fas fa-star"></small>
                                        @endfor
                                    </div>
                                </div>
                                <!-- End Review Rating -->

                                <p class="text-gray-90">{{ $review->comment }}</p>

                                <!-- Reviewer -->
                                <div class="mb-2">
                                    <strong>{{ $review->user ? ($review->user->first_name. ' ' .$review->user->last_name) : '' }}</strong>
                                    <span class="font-size-13 text-gray-23">- {{ date('M d, Y', strtotime($review->created_at)) }}</span>
                                </div>
                                <!-- End Reviewer -->
                            </div>
                        @endforeach
                        <!-- End Review -->
                    </div>
                </div>
            </div>
            <!-- End Tab Content -->
        </div>
        <!-- End Single Product Tab -->
        <!-- Related products -->
        <div class="mb-6">
            <div class="d-flex justify-content-between align-items-center border-bottom border-color-1 flex-lg-nowrap flex-wrap mb-4">
                <h3 class="section-title mb-0 pb-2 font-size-22">Related products</h3>
            </div>
            <ul class="row list-unstyled products-group no-gutters">
                @foreach ($related_products as $related_product)
                <li
                            class="col-wd-3 col-sm-4 product-item product-item__card pb-2 mb-2 pb-md-0 mb-md-0 border-bottom border-md-bottom-0">
                            <div class="product-item__outer h-100 w-100">
                                <div class="product-item__inner p-md-3 row no-gutters">
                                    <div class="col col-lg-auto product-media-left">
                                        <a href="{{route('product-detail', Crypt::encryptString($related_product->id))}}?slug={{$product->slug}}" class="max-width-150 d-block"><img loading="lazy"
                                                class="img-fluid" src="{{asset('storage/product')}}/{{$related_product->image}}"
                                                alt="Image Description"></a>
                                    </div>
                                    <div class="col product-item__body pl-2 pl-lg-3 mr-xl-2 mr-wd-1">
                                        <div class="mb-4">
                                            <div class="mb-2">
                                                <a href="{{route('store.grid')}}?c[]={{$related_product->productCategory->id ?? 0}}"
                                                    class="font-size-12 text-gray-5">{{$related_product->productCategory->name ?? ''}}
                                                </a>
                                            </div>

                                            <h4 class="product-item__title mb-0"><a style="
                                                min-height: 26px;" href="{{route('product-detail', Crypt::encryptString($related_product->id))}}?slug={{$product->slug}}" class="text-blue font-weight-bold">{{$related_product->name}}</a>
                                            </h4>

                                            <h6 class="product_code text-dark" style="font-size: 0.875rem;">Code: {{ $related_product->code }}</h6>
                                        </div>
                                        <div class="flex-center-between mb-3">
                                            <div class="prodcut-price">
                                                <div class="text-gray-100">৳
                                                    @if ($related_product->has_varient == 1)
                                                        {{$related_product->productVarient->min('discount_price')}}
                                                    @else
                                                        {{ $related_product->discount_price }}
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="product-item__footer">
                                            <div class="border-top pt-2 flex-center-between flex-wrap">
                                                <a href="#" class="text-gray-6 font-size-13"><i
                                                        class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </li>
                @endforeach




            </ul>
        </div>
        <!-- End Related products -->

        <input type="hidden" class="token" value="{{ csrf_token() }}">

        <input type="hidden" class="has_varient" @if($product->has_varient == 1)value="on" @else value="no" @endif>

    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
@endsection

@push('script')
    <script src="{{asset('frontend/assets/js/components/hs.scroll-nav.js')}}"></script>

    <script>


        $(document).on('ready', function () {

            // initialization of HSScrollNav component
            $.HSCore.components.HSScrollNav.init($('.js-scroll-nav'), {
                duration: 700
            });

            // initialization of quantity counter
            $.HSCore.components.HSQantityCounter.init('.js-quantity');

            $('.js-minus-action').click(function() {

                var quantity = $('.js-result').val();
                if (quantity > 1 ) {
                    $('.js-result').val(Number(quantity) - 1);
                } else if (quantity == 1) {
                    alertify.error("Quantity can't be bellow 1");
                }
            });

            $('.js-plus-action').on('click', function () {

                var varient_stock_quantity = $('.varient_id option:selected').attr('data-quantity');
                var quantity = $('.js-result').val();
                var has_varient = $('.has_varient').val();
                var stock_quantity = $('.stock_quantity').val();


                if (has_varient == 'on') {


                    if (varient_stock_quantity) {

                        if (Number(quantity) >= Number(stock_quantity) ) {
                            alertify.error("Stock exit");
                        } else {
                            $('.js-result').val(Number(quantity) + Number(1));
                        }
                    }  else {
                        alertify.error("Please select variant first");
                    }


                } else {
                    if (Number(quantity) >= Number(stock_quantity) ) {
                        alertify.error("Stock exit");
                    } else {
                        $('.js-result').val(Number(quantity) + Number(1));

                    }
                }


            });
        });

        $('.varient_id').change(function() {
            var price = $('.varient_id option:selected').attr('data-price');
            var stock_quantity = $('.varient_id option:selected').attr('data-quantity');

            if (price) {
                $('.price_append_area').text(price);
            }
            if (stock_quantity) {
                $('.stock_quantity').val(Number(stock_quantity));
            }

        });

        function check_auth(callback) {
            $.ajax({
                url: "{{ route('check_auth') }}",
                type: "GET",
                success: function(response){
                    callback(response.code);
                },
                error: function() {
                    callback(401);
                }
            });
        }

        function addToCart(product_id,varient,_token,quantity) {
            $.ajax({
                url: "{{route('add_to_cart')}}",
                type:"GET",
                data:{
                    product_id: product_id,
                    varient: varient,
                    _token: _token,
                    quantity: quantity,
                },
                success:function(response){
                    if(response) {
                        var data = JSON.stringify(response.message);
                        alertify.success(data.replace(/"/g, ''));
                        setTimeout(function(){
                            if (response.cart_id) {
                                window.location.href = "{{ route('checkout') }}?transition=1&buy_now=1&cart_id="+response.cart_id;
                            } else {
                                window.location.reload(1);
                            }

                        }, 2000);

                    }
                },
                error: function(error) {
                    alertify.error(JSON.parse(error.responseText).message);
                }
            });
        }

        function buyAddToCart(product_id,varient,_token,quantity) {
            $.ajax({
                url: "{{route('buy_add_to_cart')}}",
                type:"GET",
                data:{
                    product_id: product_id,
                    varient: varient,
                    _token: _token,
                    quantity: quantity,
                    // buy_now: 1,
                },
                success:function(response){
                    if(response) {
                        var data = JSON.stringify(response.message);
                        alertify.success(data.replace(/"/g, ''));
                        setTimeout(function(){
                            window.location.href = "{{ route('checkout') }}?transition=1&buy_now=1&cart_id="+response.cart_id;
                            // window.location.reload(1);
                        }, 2000);

                    }
                },
                error: function(error) {
                    alertify.error(JSON.parse(error.responseText).message);
                }
            });
        }

        $('.add-to-cart-button').click(function() {

            let varient_id = 0;
            let data_token = $('.token').val();
            let product_id = {{$product->id}};
            let quantity = $('.js-result').val();
            let has_varient = $('.has_varient').val();

            if (has_varient == 'on') {
                varient_id = $('.varient_id option:selected').val();
                let varient_stock_quantity = $('.varient_id option:selected').attr('data-quantity');
                if (!varient_stock_quantity) {
                    alertify.error("Please select variant");
                    return false;
                }
            }

            check_auth(function(check_auth_user) {
                if (check_auth_user === 200) {
                    addToCart(product_id,varient_id,data_token,quantity);
                } else {
                    var html_content = `
                        <input type="hidden" name="product_id" value="${product_id}">
                        <input type="hidden" name="varient" value="${varient_id}">
                        <input type="hidden" name="quantity" value="${quantity}">
                        <input type="hidden" name="buy_now" value="0">
                    `;

                    $('.hidden_form_section').empty();
                    $('.hidden_form_section').append(html_content);

                    $('#myModal').modal('toggle');

                    return false;
                }
            });

        });

        $('.buy-add-to-cart-button').click(function() {

            let varient_id = 0;
            let data_token = $('.token').val();
            let product_id = {{$product->id}};
            let quantity = $('.js-result').val();
            let has_varient = $('.has_varient').val();

            if (has_varient == 'on') {
                varient_id = $('.varient_id option:selected').val();
                let varient_stock_quantity = $('.varient_id option:selected').attr('data-quantity');
                if (!varient_stock_quantity) {
                    alertify.error("Please select variant");
                    return false;
                }
            }

            check_auth(function(check_auth_user) {
                if (check_auth_user === 200) {
                    buyAddToCart(product_id,varient_id,data_token,quantity);
                } else {
                    var html_content = `
                        <input type="hidden" name="product_id" value="${product_id}">
                        <input type="hidden" name="varient" value="${varient_id}">
                        <input type="hidden" name="quantity" value="${quantity}">
                        <input type="hidden" name="buy_now" value="1">
                    `;

                    $('.hidden_form_section').empty();
                    $('.hidden_form_section').append(html_content);

                    $('#myModal').modal('toggle');

                    return false;
                }
            });

        });

        function randomNumericId(length = 16) {
            const array = new Uint8Array(length);
            crypto.getRandomValues(array);
            // Map each byte to a digit (0–9)
            return Array.from(array, byte => (byte % 10).toString()).join('');
        }

        $('.guest-add-to-cart-button').click(function() {
            //  checking auth
            // u-unfold--hidden
            $('#sidebarContent').addClass('fadeInRight');
            $('#sidebarContent').removeClass('u-unfold--hidden');

            // $.ajax({
            //     url: "{{route('check_auth')}}",
            //     type:"GET",
            //     // data:{
            //     //     product_id: {{$product->id}},
            //     //     varient: 0,
            //     //     _token: data_token,
            //     //     quantity: quantity,
            //     // },
            //     success:function(response){
            //         if (response.code == 200) {

            //         } else {
            //             // sidebarContent
            //             // u-sidebar u-sidebar__lg u-unfold--css-animation fadeInRight
            //             // u-sidebar u-sidebar__lg u-unfold--css-animation u-unfold--hidden
            //         }
            //     },
            //     error: function(error) {

            //     //  console.log(error);
            //     //   $('#nameError').text(response.responseJSON.errors.name);
            //     //   $('#emailError').text(response.responseJSON.errors.email);
            //     //   $('#mobileError').text(response.responseJSON.errors.mobile);
            //     //   $('#messageError').text(response.responseJSON.errors.message);
            //     }
            // });

            // var has_varient = $('.has_varient').val();
            // var quantity = $('.js-result').val();
            // var varient_id = 0;
            // if (has_varient == 'on') {
            //     varient_id = $('.varient_id option:selected').val();
            //     var varient_stock_quantity = $('.varient_id option:selected').attr('data-quantity');
            //     if (!varient_stock_quantity) {
            //         alertify.error("Please select variant");
            //         return false;
            //     }

            //     var data_token = $('.token').val();
            //     let guest_id = localStorage.getItem("guest_id");
            //     if(!guest_id) {
            //         guest_id = randomNumericId();
            //         localStorage.setItem("guest_id", guest_id);
            //     }
            //     // alert();
            //     $.ajax({
            //         url: "{{route('guest_add_to_cart')}}",
            //         type:"GET",
            //         data:{
            //             product_id: {{$product->id}},
            //             varient: varient_id,
            //             _token: data_token,
            //             quantity: quantity,
            //             guest_id: guest_id,
            //         },
            //         success:function(response){
            //             if(response) {
            //                 var data = JSON.stringify(response.message);
            //                 alertify.success(data.replace(/"/g, ''));
            //                 setTimeout(function(){
            //                     window.location.reload(1);
            //                 }, 2000);

            //             }
            //         },
            //         error: function(error) {
            //             alertify.error(JSON.parse(error.responseText).message);
            //         }
            //     });

            // } else {

            //     var quantity = $('.js-result').val();
            //     var productSingleStock = $('.productSingleStock').val();


            //     var data_token = $('.token').val();

            //     $.ajax({
            //         url: "{{route('guest_add_to_cart')}}",
            //         type:"GET",
            //         data:{
            //             product_id: {{$product->id}},
            //             varient: 0,
            //             _token: data_token,
            //             quantity: quantity,
            //         },
            //         success:function(response){
            //           if(response) {
            //             var data = JSON.stringify(response.message);
            //             alertify.success(data.replace(/"/g, ''));
            //             setTimeout(function(){
            //                 window.location.reload(1);
            //             }, 2000);

            //           }
            //         },
            //         error: function(error) {
            //             alertify.error(JSON.parse(error.responseText).message);
            //         }
            //     });
            // }

        });

        $(".login_js").click(function(){
            $('.login_js').css("cursor","pointer");
        });



    </script>

    <!-- JavaScript -->
{{-- <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script> --}}

<!-- CSS -->
{{-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/> --}}

<!-- Bootstrap theme -->
{{-- <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/> --}}
<script>
    // alertify.warning('Warning message');
</script>

<script>
    $(function(){
        $(".imgZoom").jqZoom({
            selectorWidth: 30,
            selectorHeight: 30,
            viewerWidth: 400,
            viewerHeight: 300
        });

    })
</script>

@endpush
