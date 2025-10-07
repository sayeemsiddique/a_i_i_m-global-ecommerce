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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Product Stock</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">Product Stock</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Product Stock List</h3>
                            <div class="d-flex align-items-center">                                    
                                
                            </div>
                        </div>
                        <div class="card-body">
							<form class="form-inline"  style="float: right;">
								<label class="mr-2" for="email">Product Category: <span class="text-danger">*</span> </label>
								<select name="category_id" id="" class="form-control">
									<option value="">Select</option>
									@foreach ($categories as $category)
										<option @if(isset($_GET['category_id']) and $_GET['category_id'] == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
									@endforeach
								</select>
								
								
								<label class="mr-2 ml-5" for="pwd">Product Name:</label>
								<input type="text" class="form-control" @if(isset($_GET['name']) and $_GET['name'] != '') value="{{$_GET['name']}}" @endif placeholder="Enter name" name="name">
								
								<button type="submit" class="ml-4 btn btn-primary">Filter</button>
								<a href="{{route('admin.product.add_stock')}}" class="ml-4 btn btn-danger">
									<i class="fas fa-redo"></i>
								</a>
							  </form> 
                            
                            <form id="save_product" enctype="multipart/form-data">
								@csrf

								<div class="table-responsive ajax-data-container pt-3">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th colspan="2" class="text-left">Product Name</th>
											</tr>
										</thead>
										<tbody>
											@if ($products->count() > 0)
											@php
												$i = 1
											@endphp
												@foreach ($products as $product)
													<tr>
														<td>
															{{$i}}
														</td>
														<td align="left" style="max-width: 200px;">
															<span type="button" style="cursor: pointer;color:blue;" data-toggle="modal" data-target="#stock_details{{$product->id}}">
																{{$product->name}}
															</span>
															
														</td>
									
														<td>
															@if ($product->has_varient == 1)
															{{-- {{ number_format($product->product_stock_sum_quantity,2)}} --}}
									
															<table class="table table-bordered table-sm">
																<thead>
																	<tr>
																		<td> Variant </td>
																		<td>Total in stock</td>
																		<td>New Stock</td>
																		
																	</tr>
																</thead>
																<tbody>
																	@foreach ($product->productStock as $item)
																	<tr>
																		<td>
																			@foreach ($item->varientDataInfo as $varient)
																				{{$varient->data_value}} <br>
																			@endforeach
																		</td>
																		
																		<td>{{number_format($item->quantity,2)}}</td>
																		<td>
																			<input class="form-control" type="hidden" name="product_id[]" value="{{$product->id}}">
																			<input class="form-control" type="hidden" name="varient_id[]" value="{{$item->varient_id}}">
																			<input class="form-control" type="number" name="stock[]" min="0" max="{{number_format($item->quantity,2)}}" accept="any">
																		</td>
																		
																	</tr>
																	@endforeach
																</tbody>
							
															</table>
									
															@else
									
															<table class="table table-bordered table-sm">
																			
																<tbody class="text-left">
																	<tr>
																		<td>
																			No Variant Added
																		</td>
																		
																		<td>{{ number_format($product->productSingleStock->quantity ?? 0) }}</td>

																		<td>
																			<input class="form-control" type="hidden" name="product_id[]" value="{{$product->id}}">
																			<input class="form-control" type="hidden" name="varient_id[]" value="0">
																			<input class="form-control" type="number" name="stock[]" min="1" max="{{ number_format($product->productSingleStock->quantity ?? 0) }}" accept="any">
																		</td>
																		
																	</tr>
																  
																  
																</tbody>
															  </table>
															@endif
														</td>
									
													</tr>
													@php
														$i++;
													@endphp
												@endforeach

												<tr>
													<td colspan='100%' class="text-left"> 
														<label for="">Requisition document: <span class="text-danger">*</span></label>
														<input style="max-width: 250px" class="form-control" type="file" name="document" id="" required>
													</td>
												</tr>
											@else
												@if (isset($_GET['category_id']) and $_GET['category_id'] == '')
												<tr class="odd"><td valign="top" colspan="11" class="dataTables_empty text-danger">Please select category first!!!</td></tr>
												@else
												<tr class="odd"><td valign="top" colspan="11" class="dataTables_empty">No matching records found</td></tr>
												@endif
											@endif
										</tbody>
									</table>                          
								</div>
								<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
							</form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection

@push('stackScript')
	<script> 
		$("form#save_product").submit(function(e) {

		e.preventDefault();

		var formData = new FormData(this);
		$.ajax({
			url: "{{route('admin.product.deduct_inventory')}}",
			type: "post",
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {

				window.location.href = "{{route('admin.order.deduct_stock_list')}}/?deduct=1";					
			},
			error: function(jqXHR, textStatus, errorThrown) {
				

				var errors = $.parseJSON(jqXHR.responseText);
				$.each(errors, function (key, val) {
					if (key == 'errors') {
						var res = Object.entries(val).map(([name, obj]) => ({ name, ...obj }));
						$.each(res, function (key1, val1) {
							Swal.fire(
								'Error!',
								val1[0],
								'success'
							)
						})
					}
				});
			
			
			}
		});
	});

	</script>
@endpush  