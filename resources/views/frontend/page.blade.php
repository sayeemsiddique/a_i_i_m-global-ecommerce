@extends('frontend.layout.master_alt')

@section('content')
    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">
        <!-- breadcrumb -->
        <div class="bg-gray-13 bg-md-transparent">
            <div class="container">
                <!-- breadcrumb -->
                <div class="my-md-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">{{ $page->title ?? '' }}</li>
                        </ol>
                    </nav>
                </div>
                <!-- End breadcrumb -->
            </div>
        </div>
        <!-- End breadcrumb -->

        <div class="mb-6 text-center">
            <h1 class="mb-6">{{ $page->title ?? '' }}</h1>
            
        </div>
        
        <div class="container mb-8">
            {!! $page->meta_description ?? '' !!}
        </div>
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection
