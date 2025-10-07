<div class="mb-6">
    <div
        class=" d-flex justify-content-between border-bottom border-color-1 flex-lg-nowrap flex-wrap border-md-down-top-0 border-md-down-bottom-0">
        <h3 class="section-title section-title__full mb-0 pb-2 font-size-22">{{$category->name}}</h3>
        <a class="d-block text-gray-16" href="{{route('store.grid')}}?c[]={{$category->id}}">Go to {{$category->name}}<i
                class="ec ec-arrow-right-categproes"></i></a>
    </div>
    <div class="js-slick-carousel u-slick overflow-hidden u-slick-overflow-visble pt-3 pb-6 px-1"
        data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-4"
        data-slides-show="7" data-slides-scroll="1" data-responsive='[{
            "breakpoint": 1400,
            "settings": {
                "slidesToShow": 5
            }
            }, {
                "breakpoint": 1200,
                "settings": {
                "slidesToShow": 3
                }
            }, {
            "breakpoint": 992,
            "settings": {
                "slidesToShow": 3
            }
            }, {
            "breakpoint": 768,
            "settings": {
                "slidesToShow": 2
            }
            }, {
            "breakpoint": 554,
            "settings": {
                "slidesToShow": 2
            }
            }]'>

            @foreach ($products as $product)
                <div class="js-slide products-group">
                    <div class="product-item">
                        <div class="product-item__outer h-100">
                            <div class="product-item__inner px-wd-4 p-2 p-md-3">
                                <div class="product-item__body pb-xl-2">
                                    <div class="mb-2"><a href="#"
                                            class="font-size-12 text-gray-5">{{$product->productBrand->name ?? ''}}</a></div>
                                    <h5 class="mb-1 product-item__title"><a href="{{route('product-detail', Crypt::encryptString($product->id))}}?slug={{$product->slug}}"
                                            class="text-blue font-weight-bold">{{$product->name}}</a></h5>
                                    <div class="mb-2">
                                        <a href="{{route('product-detail', Crypt::encryptString($product->id))}}?slug={{$product->slug}}" class="d-block text-center"><img
                                                class="img-fluid" src="{{asset('storage/product')}}/{{$product->image}}"
                                                alt="{{$product->name}}"></a>
                                    </div>
                                    <div class="flex-center-between mb-1">
                                        <div class="prodcut-price">
                                            <div class="text-gray-100">৳
                                                @if ($product->has_varient == 1)
                                                        {{$product->productVarient->min('discount_price')}}
                                                    @else
                                                        {{$product->discount_price}}
                                                    @endif
                                            </div>
                                        </div>
                                        {{-- <div class="d-none d-xl-block prodcut-add-cart">
                                            <a href="{{route('product-detail',Crypt::encryptString($product->id))}}?slug={{$product->slug}}"
                                                class="btn-add-cart btn-primary transition-3d-hover"><i
                                                    class="ec ec-add-to-cart"></i></a>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="product-item__footer">
                                    <div class="border-top pt-2 flex-center-between flex-wrap">
                                        <a href="#" class="text-gray-6 font-size-13"><i
                                                class="ec ec-compare mr-1 font-size-15"></i> Compare</a>
                                        <a href="#" class="text-gray-6 font-size-13"><i
                                                class="ec ec-favorites mr-1 font-size-15"></i> Wishlist</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
</div>