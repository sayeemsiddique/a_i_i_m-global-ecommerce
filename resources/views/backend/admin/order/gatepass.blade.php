@extends('backend.layout.master')

    @push('css')
        <style> 
            th, td {
                font-size: 16px !important;
            }
            h6 {
                font-size: 14px !important;
            }
        </style>
    @endpush

	@section('content')
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Subheader-->
            <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline flex-wrap mr-5">
                            <!--begin::Page Title-->
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Gatepass</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                                </li>
                                
                                <li class="breadcrumb-item active">
                                    <a class="text-muted">Gatepass</a>
                                </li>
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page Heading-->
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Subheader-->

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid" id="printArea" style="font-size: 1.25rem !important; ">
            <!--begin::Container-->
            <div class="container-fluid">

                <!-- begin::Card-->
                <div class="card card-custom overflow-hidden">
                    <div class="card-body p-0">
                        <!-- begin: Gatepass-->
                        <!-- begin: Gatepass header-->
                        <div class="row justify-content-center py-8 px-8 py-md-12 px-md-0">
                            <div class="col-md-9">
                                <div class="justify-content-between flex-column flex-md-row text-center">
                                    <h2 style="font-weight: 800; display: inline-block; font-size: 18px">বাংলাদেশ ইনসুলেটর ও স্যানিটারিওয়্যার কারখানা লিমিটেড <h6 class="float-right" style="display: inline-block;">{{ $type == 1 ? 'অফিস  কপি' : 'ক্রেতা কপি' }}</h6></h2>
                                    <h5 style="font-size: 15px;">বক্স নগর, মিরপুর, ঢাকা</h5>
                                    <h3 style="font-weight: 800; display: inline-block; font-size: 16px; padding-left: 80px;">গেট পাশ / ডেলিভারি চালান <h6 class="float-right" style="display: inline-block;">নং- {{ $gatepass_id ? sprintf('%08d', $gatepass_id) : '' }}</h6></h3>
                                </div>

                                <div class="row mt-5">
                                    <div class="col-md-9 text-left"> 
                                        <h6 class="text-left">তারিখ- {{ date('d-m-Y') }}</h6>

                                        @if ($type == 2)
                                            <h6 class="text-left">ক্রেতার নাম- {{ $order->user ? ($order->user->first_name.' '.$order->user->last_name) : '' }}</h6>
                                        @else
                                            <h6 class="text-left">মেসার্স- {{ $order->user ? $order->user->corporation_name : '' }}</h6>
                                        @endif
                                    </div>

                                    <div class="col-md-3 text-right"> 
                                        <h6>নির্দেশ নামা নং- {{ $order->tracking_code }} </h6>
                                        <h6>তারিখ- {{ date('d-m-Y', strtotime($order->created_at)) }}</h6>
                                        {{-- <h6 class="text-left">টাকা প্রাপ্তি রশিদ নং- </h6> --}}
                                        {{-- <h6 class="text-left">বিপণন বিভাগের নির্দেশ নামা নং- </h6> --}}
                                        {{-- <h6 class="text-left">তারিখ-</h6> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- end: Gatepass header-->

                        <!-- begin: Gatepass body-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0" style="font-size: 1.25rem;">

                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-header-size">
                                                <th class="text-center font-weight-bold text-muted text-uppercase">পণ্য দ্রব্যের নাম ও বিবরণ</th>
                                                <th class="text-center font-weight-bold text-muted text-uppercase">পরিমাণ (পিস)
                                                </th>
                                                <th class="text-center font-weight-bold text-muted text-uppercase">মন্তব্য</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($order_details as $item)
                                                <tr class="font-weight-boldest">
                                                    <td>{{ $item->product ? $item->product->name : '' }} - {{ $item->product ? $item->product->code : '' }}</td>
                                                    <td>{{ number_format($item->quantity, 0)  }}</td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <h6 class="text-justify" style="line-height: 24px"> বিঃ দ্রঃ- ব্যবসায়ী/ক্রেতাগণ তাদের নিজেদের স্বার্থে সরবরাহ গ্রহণের পূর্বে মালামাল পরীক্ষা করে নেবেন। সরবরাহ করার পর মালামালের ত্রুটি/ক্ষতি/ঘাটতি/সংক্রান্ত কোন আপত্তি বা দাবীদাওয়া গ্রহণ করা হবে না। সরবরাহকালে মালামালের যদি কোন ক্ষতি/বিচ্যুতি পরিলক্ষিত হয় তা হলে তাৎক্ষণাৎ উহা কর্তৃপক্ষের গোচরীভূত করতে হবে যাহাতে ফ্যাক্টরি, গুদাম হতে যথার্থ মাল সরবরাহ করা সম্ভব হয়।</h6>

                                <div class="row mt-15">
                                    <div class="col-md-4"> 
                                        <h6 style="font-weight: 800;">প্রস্তুতকারীর স্বাক্ষর</h6>

                                        <img src="{{ asset('storage/signatures/'. ($gatepass_get->preparer->signature ?? '')) }}" alt="" style="max-height: 50px;">

                                        <h6 class="mt-4">নাম ও পদবী- {{ $gatepass_get->preparer ? ($gatepass_get->preparer->first_name.' '.$gatepass_get->preparer->last_name) : '' }}</h6>
                                        <h6>{{ $gatepass_get->preparer->designation->name ?? '' }} ({{ $gatepass_get->preparer->department->name ?? '' }})</h6>
                                        {{-- <h6 class="mt-4">তারিখ- {{ date('d-m-Y', strtotime($gatepass_get->created_at)) }}</h6> --}}
                                        @php
                                            $created_at = strtotime($gatepass_get->created_at);
                                            $generate_datetime = strtotime($gatepass_get->generate_datetime);
                                        @endphp
                                        
                                        @if ($created_at > $generate_datetime)
                                            <h6 class="mt-4">তারিখ- {{ date('d-m-Y', strtotime($gatepass_get->generate_datetime)) }}</h6>
                                        @else
                                            <h6 class="mt-4">তারিখ- {{ date('d-m-Y', strtotime($gatepass_get->created_at)) }}</h6>
                                        @endif

                                        <br>
                                        
                                        <h6 style="font-weight: 800;">ব্যবসায়ী/ক্রেতার/প্রতিনিধির স্বাক্ষর- </h6>

                                        <img src="" alt="" style="max-height: 50px;">

                                        <h6>নাম ও পদবী- </h6>
                                        <br>
                                        <h6 class="mt-4">তারিখ- </h6>
                                    </div>

                                    <div class="col-md-4"> 
                                        <h6 style="font-weight: 800;">পরীক্ষাকারীর স্বাক্ষর</h6>

                                        <img src="{{ asset('storage/signatures/'. ($gatepass_get->examiner->signature ?? '')) }}" alt="" style="max-height: 50px;">

                                        <h6 class="mt-4">নাম ও পদবী- {{ $gatepass_get->examiner ? ($gatepass_get->examiner->first_name.' '.$gatepass_get->examiner->last_name) : '' }}</h6>
                                        <h6>{{ $gatepass_get->examiner->designation->name ?? '' }} ({{ $gatepass_get->examiner->department->name ?? '' }})</h6>
                                        <h6 class="mt-4">তারিখ- {{ date('d-m-Y', strtotime($gatepass_get->generate_datetime)) }}</h6>
                                    </div>

                                    <div class="col-md-4"> 
                                        <h6 style="font-weight: 800;">ভারপ্রাপ্ত কর্মকর্তার স্বাক্ষর</h6>

                                        <img src="{{ asset('storage/signatures/'. ($gatepass_get->incharge->signature ?? '')) }}" alt="" style="max-height: 50px;">

                                        <h6 class="mt-4">নাম ও পদবী- {{ $gatepass_get->incharge ? ($gatepass_get->incharge->first_name.' '.$gatepass_get->incharge->last_name) : '' }}</h6>
                                        <h6>{{ $gatepass_get->incharge->designation->name ?? '' }} ({{ $gatepass_get->incharge->department->name ?? '' }})</h6>
                                        <h6 class="mt-4">তারিখ- {{ date('d-m-Y', strtotime($gatepass_get->generate_datetime)) }}</h6>

                                        <br>

                                        <h6 style="font-weight: 800;">গেট পাশ অনুমোদনকারীর স্বাক্ষর</h6>

                                        <img src="{{ asset('storage/signatures/'. ($gatepass_get->approver->signature ?? '')) }}" alt="" style="max-height: 50px;">
                                        
                                        <h6 class="mt-4">নাম ও পদবী- {{ $gatepass_get->approver ? ($gatepass_get->approver->first_name.' '.$gatepass_get->approver->last_name) : '' }}</h6>
                                        <h6>{{ $gatepass_get->approver->designation->name ?? '' }} ({{ $gatepass_get->approver->department->name ?? '' }})</h6>
                                        <h6 class="mt-4">তারিখ- {{ date('d-m-Y', strtotime($gatepass_get->generate_datetime)) }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: Gatepass body-->

                        <!-- end: Gatepass-->
                    </div>
                </div>
                <!-- end::Card-->
            </div>
            <!--end::Container-->
        </div>
            <!--end::Entry-->
        </div>
        <!--end::Content-->

        <!-- begin: Gatepass action-->
        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
            <div class="col-md-9">
                <div class="d-flex justify-content-between">

                    <button type="button" id="noprintbtn" class="btn btn-primary font-weight-bold mr-2" onclick="return printDiv('printArea','gatepass_{{$order->tracking_code}}');">Print</button>

                    @can('edit_gatepass_assign')
                        <a href="{{ route('admin.order.edit_gatepass_assign', [$order->id, $type]) }}" class="btn btn-success">Edit Gatepass Assigness</a>
                    @endcan

                    <a href="{{ route('admin.order.show', Crypt::encryptString($order->id)) }}" class="btn btn-info">Back</a>
                </div>
            </div>
        </div>
        <!-- end: Gatepass action-->
	@endsection

	@push('stackScript')
        <script type="text/javascript">
            function printDiv(divName,title_name) {
                document.title = title_name;
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
            }
        </script>
	@endpush
					