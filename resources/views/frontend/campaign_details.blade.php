@extends('frontend.layout.master_alt')
@section('content')
<!-- ========== MAIN CONTENT ========== -->


<main id="content" role="main">

    <div class="container mt-5">
        {{-- <div class="row g-4 mb-5"> --}}
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
                                                                {{round($product->productVarient->where("discount_price",'>=',$product_min_price_from)->min('discount_price'))}}
                                                                @else
                                                                {{round($product->productVarient->min('discount_price'))}}
                                                                @endif

                                                            @else
                                                                {{round($product->discount_price)}}
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


        {{-- </div> --}}

    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
@endsection
@push('css')

    {{-- <link rel="stylesheet" href="{{asset('frontend/assets/vendor/ion-rangeslider/css/ion.rangeSlider.css')}}"> --}}
@endpush

@push('script')
    {{-- <script src="{{asset('frontend/assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/components/hs.range-slider.js')}}"></script>
    <script src="{{asset('frontend/assets/js/components/hs.scroll-nav.js')}}"></script> --}}

@endpush

