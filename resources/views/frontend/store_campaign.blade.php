@extends('frontend.layout.master_alt')
@section('content')
<!-- ========== MAIN CONTENT ========== -->


<main id="content" role="main">

    <div class="container mt-5">
        <div class="row g-4 mb-5">
            @foreach ($campaigns as $campaign)
                <div class="col-lg-4 col-md-4 mb-5">
                    <div class="card campaign-card border shadow-sm h-100 overflow-hidden">

                        <!-- Image -->
                        <div class="position-relative">
                            <img
                            loading="lazy"
                                src="{{ asset('storage/campaign/'.$campaign->image) }}"
                                class="img-fluid w-100 campaign-img"
                                alt="{{ $campaign->title }}"
                            >

                            <!-- Discount Badge -->
                            @if($campaign->discount)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-3">
                                    {{ $campaign->discount }}
                                    {{ $campaign->discount_type == 'percent' ? '%' : '৳' }} OFF
                                </span>
                            @endif

                            <!-- Featured Badge -->
                            @if($campaign->featured)
                                <span class="badge bg-warning text-dark position-absolute top-0 right-0 m-3">
                                    ★ Featured
                                </span>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold mb-2">
                                {{ $campaign->title }}
                            </h5>

                            <p class="text-muted small mb-3">
                                <i class="ri-calendar-line"></i>
                                {{ \Carbon\Carbon::parse($campaign->start_date)->format('d M Y') }}
                                –
                                {{ \Carbon\Carbon::parse($campaign->end_date)->format('d M Y') }}
                            </p>

                            <div class="mt-auto">
                                @if($campaign->status == 1)
                                    <a href="{{ route('campaign.details', [$campaign->slug,Crypt::encryptString($campaign->id)]) }}"
                                    class="btn btn-primary btn-sm w-100">
                                        View Campaign
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                        Campaign Ended
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="col-12">
                <div class="d-flex justify-content-center mt-4">
                    {{ $campaigns->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->
@endsection
@push('css')
<style>
    .campaign-card {
    transition: transform .3s ease, box-shadow .3s ease;
}

.campaign-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,.12);
}

.campaign-img {
    height: 260px;
    object-fit: cover;
}

</style>
    {{-- <link rel="stylesheet" href="{{asset('frontend/assets/vendor/ion-rangeslider/css/ion.rangeSlider.css')}}"> --}}
@endpush

@push('script')
    {{-- <script src="{{asset('frontend/assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/components/hs.range-slider.js')}}"></script>
    <script src="{{asset('frontend/assets/js/components/hs.scroll-nav.js')}}"></script> --}}

@endpush

