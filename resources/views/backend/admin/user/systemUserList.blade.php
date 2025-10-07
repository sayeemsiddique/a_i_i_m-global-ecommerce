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
												<h3 class="card-title">All System Users List</h3>
											</div>
											
											<div class="card-body">

												<!--begin::Search Form-->
												<div class="mb-7">
													<div class="row align-items-center">
														<div class="col-lg-10 col-xl-10">
															<div class="row align-items-center">
																<div class="col-md-3 my-2 my-md-0">
																	<div class="input-icon">
																		<input type="text" name="q" data-url="{{ route('admin.searchAjax', ['type' => 'systemUser']) }}" class="form-control ajax-data-search" placeholder="Enter Name, mobile, email" id="kt_datatable_search_query" />
																		<span>
																			<i class="flaticon2-search-1 text-muted"></i>
																		</span>
																	</div>
																</div>
																
																<div class="col-md-3 my-2 my-md-0">
																	<div class="d-flex align-items-center">
																		<label class="mr-3 mb-0 d-none d-md-block">Designation:</label>
																		<select class="form-control ajax-data-search select2" data-select="{{ route('admin.searchAjax', ['type' => 'userDesignation']) }}" id="designation_id" name="designation_id">
																			<option label="label">--Search By Designation--</option>
																			@foreach ($designations as $designation)
																				<option value="{{ $designation->id }}">{{ $designation->name }}</option>
																			@endforeach
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--end::Search Form-->

												<!--begin::table-->
												<div class="table-responsive ajax-data-container pt-3">
													@include('backend.admin.user.ajax.tableBody')
												</div>
												<!--end::table-->
												
												{{ $users->links() }}
											</div>
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
					
