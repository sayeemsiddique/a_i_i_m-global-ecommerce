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
									<h3 class="card-title">Add New Upazila</h3>
								</div>

								<!--begin::Form-->
								<div class="card-body">
                                    <form action="{{route('admin.upazila.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf


                                <div style="max-width: 400px">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{__('Upazila Name')}} <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" name="name" placeholder=" Upazila Name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="district_id" class="form-label">{{__('Select District')}} <span style="color:red;">*</span></label>
                                        <select id="my-select" class="form-control select2" name="district_id" required>
                                            <option value="">--{{__('Select District')}}--</option>
                                            @foreach ($districts as $district)
                                                <option value="{{$district->id}}">{{$district->name}} ({{$district->divisionInfo->name ?? '-'}})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <span class="switch">
                                            <label>
                                                <input type="checkbox" name="status" checked value="1" />
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
