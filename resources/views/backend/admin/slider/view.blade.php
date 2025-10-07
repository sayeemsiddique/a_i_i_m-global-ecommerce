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
									<h3 class="card-title">View Slider</h3>
									<div class="card-toolbar">
										<a href="{{url()->previous()}}" class="btn btn-primary btn-xsm mr-2">Back</a>
										
									</div>
								</div>
								
								
								<!--begin::Form-->
								
									
									<div class="card-body">

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Slider Image:</label>
											<div class="col-lg-5 col-sm-12">
												<img src="{{url('/')}}/storage/slider/{{ $slider->image }}" alt="{{ $slider->title }}" style="max-height: 120px">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Title: </label>
											<div class="col-lg-5 col-sm-12">
												<input type="text" class="form-control" placeholder="Enter Name" value="{{ $slider->title }}" required/>
											</div>
										</div>
										
										@if ($slider->link)
											<div class="form-group row">
												<label class="col-form-label text-right col-lg-4 col-sm-12">Link:</label>
												<div class="col-lg-5 col-sm-12">
													<input type="text" class="form-control" value="{{ $slider->link }}"/>
												</div>
											</div>
										@endif

										<div class="form-group row">
											<label class="col-form-label text-right col-lg-4 col-sm-12">Status: </label>
											<div class="col-lg-5 col-sm-12">
												
												<input class="form-control" value="{{ $slider->status == 1 ? 'Active' : 'Deactive' }}" disabled="">
											</div>
										</div>

										<div class="form-group row">
											
											<label class="col-form-label text-right col-lg-4 col-sm-12">Created By : </label>
											<div class="col-lg-5 col-sm-12">
												<input class="form-control" value="{{ $slider->createdBy->first_name ?? '' }} {{ $slider->createdBy->last_name ?? '' }}" disabled="">
											</div>
										</div>
										
										@if ($slider->updatedBy)
											<div class="form-group row">
												
												<label class="col-form-label text-right col-lg-4 col-sm-12">Updated By : </label>
												<div class="col-lg-5 col-sm-12">
													<input class="form-control" value="{{ $slider->updatedBy->first_name ?? '' }} {{ $slider->updatedBy->last_name ?? '' }}" disabled="">
												</div>
											</div>
										@endif
										
										
										<div class="form-group row">
											
											<label class="col-form-label text-right col-lg-4 col-sm-12">Created at : </label>
											<div class="col-lg-5 col-sm-12">
												<input class="form-control" value="{{date('d M, Y',strtotime($slider->created_at))}}" disabled="">
											</div>
										</div>
										
										<div class="form-group row">
											
											<label class="col-form-label text-right col-lg-4 col-sm-12">Updated at :</label>
											<div class="col-lg-5 col-sm-12">
												<input class="form-control" value="{{date('d M, Y',strtotime($slider->updated_at))}}" disabled="">
											</div>
										</div>

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
		<script> 
			$('input').prop('disabled',true);
			$('textarea').prop('disabled',true);
		</script>
	@endpush
