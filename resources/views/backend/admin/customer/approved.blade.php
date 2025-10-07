@extends('backend.layout.master')

	@section('content')
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						
						<!--end::Subheader-->
						<!--begin::Entry-->
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
												<h3 class="card-title">All Approved Account List</h3>
											</div>
											
											<div class="card-body">

												<!--begin::Search Form-->
												{{-- <div class="mb-7">
													<div class="row align-items-center">
														<div class="col-lg-10 col-xl-10">
															<div class="row align-items-center">
																<div class="col-md-3 my-2 my-md-0">
																	<div class="input-icon">
																		<input type="text" name="q" data-url="{{ route('admin.searchAjax', ['type' => 'user']) }}" class="form-control ajax-data-search" placeholder="Enter name, mobile, email" id="kt_datatable_search_query" />
																		<span>
																			<i class="flaticon2-search-1 text-muted"></i>
																		</span>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div> --}}
												<!--end::Search Form-->

												<!--begin::table-->
												<div class="table-responsive ajax-data-container pt-3">
													@include('backend.admin.customer.ajax.index')
												</div>
												<!--end::table-->
												
												{{-- {{ $users->links() }} --}}
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
					
