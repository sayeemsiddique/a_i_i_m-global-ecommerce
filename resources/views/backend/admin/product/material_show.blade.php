@extends('backend.layout.master')

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
										<h5 class="text-dark font-weight-bold my-1 mr-5">Product Details</h5>
										<!--end::Page Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
											<li class="breadcrumb-item">
												<a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
											</li>
											@can('all_product')
												<li class="breadcrumb-item">
													<a href="{{route('admin.product.index')}}" class="text-muted">Manage Product</a>
												</li>
											@endcan
											<li class="breadcrumb-item active">
												<a class="text-muted">{{ $product->name }} Product Details</a>
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
						<div class="d-flex flex-column-fluid">
							<!--begin::Container-->
							<div class="container-fluid">
								<!--session msg-->
								@include('alerts.alerts')

								<!--begin::row-->
								<div class="row">
									<div class="col-lg-12">
										<!--begin::Card-->
										<div class="card card-custom">
											<!--begin::Header-->
											<div class="card-header py-3">
												<div class="card-title align-items-start flex-column">
													<h3 class="card-label font-weight-bolder text-dark">{{ $product->name }} Product Details</h3>
													<hr>
												</div>
												

												<div class="example-preview" style="width: 100%">
													<div class="row">
														<div class="col-sm-3">
															<ul class="nav flex-column nav-pills">
																<li class="nav-item mb-2">
																	<a class="nav-link active" id="home-tab-5" data-toggle="tab" href="#home-5">
																		<span class="nav-icon">
																			<i class="flaticon2-chat-1"></i>
																		</span>
																		<span class="nav-text">Product Details</span>
																	</a>
																</li>
															</ul>
														</div>
														<div class="col-sm-9">
															<div class="tab-content" id="myTabContent5" style="width: 100%">
																<div class="tab-pane fade show active" id="home-5" role="tabpanel" aria-labelledby="home-tab-5">
																	<table class="table table-bordered table-sm text-left">
																		<tbody>
																		  <tr>
																			<td class="w-25">Product Name:</td>
																			<td class="w-75">{{$product->name}}</td>
																		  </tr>
																		  
																		  <tr>
																			<td class="w-25">Code:</td>
																			<td class="w-75">
																				{{$product->code}}
																			</td>
																		  </tr>
																		  <tr>
																			<td class="w-25">Unit:</td>
																			<td class="w-75">
																				@if ($product->unit == 1)
																					KG
																				@elseif ($product->unit == 2)
																					MT
																					
																				@endif
																			</td>
																		  </tr>
																		  <tr>
																			<td class="w-25">Status:</td>
																			<td class="w-75">
																				@if ($product->status == 1)
																					<p class="text-success">Active</p>
																				@elseif ($product->status == 2)
																				<p class="text-danger">Deleted</p>
																				@elseif ($product->status == 0)
																				<p class="text-warning">Inactive</p>
																				@endif
																			</td>
																		  </tr>

                                                                          <tr>
                                                                              <td class="w-25"> Initial Quantity</td>
                                                                              <td>
                                                                                @if ($product->has_varient == 1)

                                                                                @foreach ($product->productVarient as $varient)
                                                                                    {{ number_format($varient->quantity) }}
                                                                                @endforeach

                                                                                @else
                                                                                    {{ number_format($product->quantity) }}
                                                                                @endif
                                                                              </td>
																			  <td>
																				  
																			  </td>
                                                                          </tr>
																		  
																		</tbody>
																	  </table>
																</div>
															</div>
														</div>
													</div>
												</div>

                                                {{-- @can('product')
                                                <div class="card-toolbar">
													<a href="{{route('admin.product.edit', $product->id)}}" class="btn btn-success mr-2">Edit Product Information</a>
												</div>
                                                @endcan --}}
											</div>
											<!--end::Header-->
                                            
										</div>
										<!--end::Card-->
									</div>
								</div>
                                <!--end::row-->
							</div>
							<!--end::Container-->
						</div>
						<!--end::Entry-->
					</div>
					<!--end::Content-->
	@endsection
					