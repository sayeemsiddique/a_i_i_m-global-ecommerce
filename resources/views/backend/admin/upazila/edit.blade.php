{{-- @extends('backend.layout.master')
@section('title', ''.($global_setting->title ?? "").' | '.__('pages.Add New Upazila'))
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{__('pages.Add New Upazila')}}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('menu.Dashboard')}}</a></li>
                            <li class="breadcrumb-item active">{{__('pages.Add New Upazila')}}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

            <div class="col-xxl-12">



                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{__('pages.Add New Upazila')}}</h4>
                        <div class="flex-shrink-0">
                            <a href="{{URL::previous()}}" class="btn btn-primary">{{__('pages.Back')}}</a>
                        </div>
                    </div>


                    <div class="card-body">
                        <form action="{{route('admin.upazila.update', $upazila->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">

                                <div class="col-md-4 col-sm-6 col-xsm-12">
                                    <div>
                                        <label for="name" class="form-label">{{__('pages.Upazila Name')}} <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder="{{__('pages.Upazila Name')}}" value="{{$upazila->name}}" required>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6 col-xsm-12">
                                    <div>
                                        <label for="region" class="form-label">{{__('pages.Select District')}} <span style="color:red;">*</span></label>
                                        <select id="my-select" class="form-control select2" name="district_id" required>
                                            <option value="">--{{__('pages.Select District')}}--</option>
                                            @foreach ($districts as $district)
                                                <option @if($district->id == $upazila->district_id) selected @endif value="{{$district->id}}">{{$district->name}} ({{$district->divisionInfo->name ?? '-'}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6 col-xsm-12" style="margin-top: 3%">
                                    <div class="form-check form-switch form-switch-custom form-switch-success mb-3">
                                        <input @if($upazila->status == 1) checked @endif class="form-check-input" type="checkbox" role="switch" name="status" id="SwitchCheck11" value="1">
                                        <label class="form-check-label" for="SwitchCheck11">{{__('pages.Status')}}</label>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">{{__('pages.Update')}}</button>
                                    </div>
                                </div><!--end col-->

                            </div><!--end row-->
                        </form>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->

    </div>
    <!-- container-fluid -->
</div>

@endsection

@push('script')
    <script>
        $('[href*="{{$menu_expand}}"]').addClass('active');
        $('[href*="{{$menu_expand}}"]').closest('.menu-dropdown').addClass('show');
        $('[href*="{{$menu_expand}}"]').closest('.menu-dropdown').parent().find('.nav-link').attr('aria-expanded','true');
        $('[href*="{{$menu_expand}}"]').closest('.first-dropdown').find('.menu-link').attr('aria-expanded','true');
        $('[href*="{{$menu_expand}}"]').closest('.first-dropdown').find('.menu-dropdown:first').addClass('show');
    </script>
@endpush --}}
@extends('backend.layout.master')

	@section('content')
		<!--begin::Content-->
		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

			<div class="d-flex flex-column-fluid">
				<!--begin::Container-->
				<div class="container-fluid">
					<!--session msg-->
					@include('alerts.alerts')

					<!--begin::Card-->
					<div class="row">
						<div class="col-lg-12">
							<!--begin::Card-->
							<div class="card card-custom example example-compact">
								<div class="card-header">
									<h3 class="card-title">Edit Upazila</h3>
								</div>

								<!--begin::Form-->
								<div class="card-body">
                                    <form action="{{route('admin.upazila.update', $upazila->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf


                                <div style="max-width: 400px">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{__('Upazila Name')}} <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder=" Upazila Name" value="{{$upazila->name}}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="district_id" class="form-label">{{__('Select District')}} <span style="color:red;">*</span></label>
                                        <select id="my-select" class="form-control select2" name="district_id" required>
                                            <option value="">--{{__('Select District')}}--</option>
                                            @foreach ($districts as $district)
                                                <option @if($upazila->district_id == $district->id) selected @endif value="{{$district->id}}">{{$district->name}} ({{$district->divisionInfo->name ?? '-'}})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <span class="switch">
                                            <label>
                                                <input type="checkbox" @if($upazila->status == 1) checked @endif name="status" checked value="1" />
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>

                                    <div class="gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                    </div>
                                </div>



                                <div class="col-lg-12">

                                </div><!--end col-->


                        </form>
                                </div>
								<!--end::Form-->
							</div>
							<!--end::Card-->
						</div>
					</div>
				</div>
				<!--end::Container-->
			</div>
			<!--end::Entry-->
		</div>
		<!--end::Content-->
	@endsection



	@push('stackScript')

	@endpush
