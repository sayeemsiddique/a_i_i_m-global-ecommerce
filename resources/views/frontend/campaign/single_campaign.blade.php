<div class="mb-6 pt-6" style="background: linear-gradient(45deg,#f749532b,#0000ff24);">
            @foreach ($campaigns as $campaign)
            <div class="container">
                <div class="row align-items-center justify-content-center">

                        <div class="col-lg-4 col-md-4 mb-5">
                            <img
                                loading="lazy"
                                src="{{ asset('storage/campaign/'.$campaign->image) }}"
                                class="img-fluid w-100 campaign-img campaign-container-image"
                                alt="{{ $campaign->title }}"
                            >

                            <h5 class="fw-bold mb-2 text-center mt-3">
                                {{ $campaign->title }}
                            </h5>
                            <p class="text-dark mb-3 text-center">
                                <i class="ri-calendar-line"></i>
                                {{ \Carbon\Carbon::parse($campaign->start_date)->format('d M Y') }}
                                –
                                {{ \Carbon\Carbon::parse($campaign->end_date)->format('d M Y') }}
                            </p>

                        </div>
                        <div class="col-lg-8 col-md-4 mb-5">
                            <div class="card campaign-card shadow-sm h-100 overflow-hidden" style="background: transparent;border: 0 !important;">
                                <div class="card-body">
                                    <div class="mt-auto text-right mb-4" >
                                @if($campaign->status == 1)
                                    <a href="{{ route('campaign.details', [$campaign->slug,Crypt::encryptString($campaign->id)]) }}"
                                    class="btn btn-primary btn-sm">
                                        View Campaign Products
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        Campaign Ended
                                    </button>
                                @endif
                            </div>
                                    <div class="row">
                                        @foreach ($campaign->campaignProductInfo as $item)
                                            <div class="col-md-3 product-item">
                                                <div class="product-item__outer h-100 w-100" style="background: #12a23d0d;">
                                                    <div class="product-item__inner px-xl-4 p-3">
                                                        <div class="product-item__body pb-xl-2">
                                                            <div class="mb-2">
                                                                <a href="{{ route('store.grid') }}?c[]={{$item->productInfo->product->productCategory->id ?? 0 }}" class="font-size-12 text-gray-5">{{$item->productInfo->productCategory->name ?? ''}}</a>
                                                            </div>
                                                            <h5 class="mb-0 product-item__title">
                                                                <a style="min-height: 40px;" href="{{route('product-detail',Crypt::encryptString($item->product_id))}}?slug={{$item->productInfo->slug ?? ''}}" class="text-blue font-weight-bold">{{$item->productInfo->name ?? ''}}</a>
                                                            </h5>
                                                            <h6 class="product_code text-dark" style="font-size: 0.875rem;">Code: {{ $item->productInfo->code }}</h6>
                                                            <div class="mb-2">
                                                                <a href="{{route('product-detail',Crypt::encryptString($item->product_id))}}?slug={{$item->productInfo->slug ?? ''}}" class="d-block"><img loading="lazy" class="img-fluid" src="{{asset('storage/product')}}/{{$item->productInfo->image ?? ''}}" alt="{{$item->productInfo->name}}"></a>
                                                            </div>
                                                            <div class="flex-center-between mb-1">

                                                                <div class="prodcut-price d-flex align-items-center position-relative">
                                                                    <ins class="font-size-20 text-red text-decoration-none">{{$global_setting->currency ?? ""}}
                                                                        @if ($item->productInfo->has_varient == 1)
                                                                            @if (isset($_GET['range']) and $_GET['range'] !='')
                                                                            @php
                                                                                $range_data = explode('%3B', $_GET['range']);
                                                                                $product_min_price_from = explode(";",$range_data[0])[0];
                                                                            @endphp
                                                                            {{round($item->productInfo->productVarient->where("discount_price",'>=',$product_min_price_from)->min('discount_price'))}}
                                                                            @else
                                                                            {{round($item->productInfo->productVarient->min('discount_price'))}}
                                                                            @endif

                                                                        @else
                                                                            {{round($item->productInfo->discount_price)}}
                                                                        @endif
                                                                    </ins>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>

                </div>
            </div>
            @endforeach
        </div>
