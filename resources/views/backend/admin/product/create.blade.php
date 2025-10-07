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
								<h3 class="card-title">Add New Product</h3>
							</div>

							<!--begin::Form-->
							<form class="form" method="post" id="save_product" enctype="multipart/form-data">
								@csrf

								<div class="card-body">
									<div class="row">
										<div class="col-md-6">

											<div class="form-group">
												<label class="">Product Name: <span class="text-danger">*</span></label>

												<input type="text" class="form-control" name="name" placeholder="Enter Product Name" value="{{ old('name') }}" required />
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="">Product Category: <span class="text-danger">*</span></label>
														
														<select class="form-control parent_category" name="category_id" required>
															<option value="">--Select Category--</option>

															@foreach ($categories as $categor)
																<option value="{{ $categor->id }}">{{ $categor->name }}</option>
															@endforeach
														</select>
													</div>

													{{-- <div class="form-group">
														<label class="">Sub Product Category:</label>
														
														<select class="form-control sub_parent_category" name="sub_category_id">
															<option value="">Select</option>

														</select>
													</div> --}}

													<div class="form-group conditional_area">
														<label class="">Product Weight: </label>
														
														<input type="number" class="form-control" name="weight" placeholder="Weight" step="0.01">
													</div>

													<div class="form-group conditional_area">
														<label class="">Initial Quantity: <span class="text-danger">*</span></label>

														<input type="number" class="form-control" name="quantity" value="0" placeholder="0" required>
													</div>

													<div class="form-group d-none">
														<label class="">SD:</label>

														<input onchange="calculate_val()" type="number" accept="0.01" class="form-control" name="sd" value="0">
													</div>

													{{-- <input type="hidden" class="form-control" name="discount_type" placeholder="0" value="0"> --}}
													<div class="form-group conditional_area">
														<label class="">Discount type: </label>
														<select onchange="calculate_val()" class="form-control select_discount_type" name="discount_type">
															<option value="">Select</option>
															<option value="1">Flat Rate</option>
															<option value="2">Percentage</option>
														</select>
													</div>

													<div class="form-group">
														<label class="">Status:</label>

														<div class="">
															<span class="switch">
																<label>
																	<input type="checkbox" name="status" checked value="1" />
																	<span></span>
																</label>
															</span>
														</div>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label class="">Product Brand: </label>
														
														<select class="form-control parent_category" name="brand_id">
															<option value="">--Select Brand--</option>

															@foreach ($brands as $brand)
																<option value="{{$brand->id}}">{{$brand->name}}</option>
															@endforeach
														</select>
													</div>

													<div class="form-group">
														<label class="">Product Code: <span class="text-danger">*</span> </label>
														
														<input type="text" class="form-control" name="code" placeholder="Code">
													</div>

													<div class="form-group">
														<label class="">Unit:</label>

														<select class="form-control" name="unit">
															<option value="">Select</option>
															<option value="1">KG</option>
															<option value="2">MT</option>
															<option value="3">Pcs</option>
														</select>
													</div>

													<div class="form-group d-none">
														<label class="">VAT:</label>

														<input onchange="calculate_val()" type="number" accept="0.01" class="form-control" name="vat" value="0">
													</div>

													<div class="form-group conditional_area">
														<label class="">Sale Price: <span class="text-danger">*</span></label>

														<input onchange="calculate_val()" type="number" class="form-control" step="0.01" name="price">
													</div>
													
													<div class="form-group conditional_area">
														<label class="">Discount:</label>
														<input onchange="calculate_val()" type="number" class="form-control" name="discount">
													</div>

													<div class="form-group conditional_area">
														<label class="">Total Sale Price:</label>

														<input onchange="calculate_val()" type="number" class="form-control" step="0.01" name="total_price">
													</div>

													<div class="form-group">
														<label class="">Featured:</label>

														<div class="">
															<span class="switch">
																<label>
																	<input type="checkbox" name="featured" value="1" />
																	<span></span>
																</label>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label class="">Product Image: </label>

												<div class="image-input image-input-empty image-input-outline" id="kt_image_5" style="">
													<div class="image-input-wrapper"></div>
													
													<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Photo">
														<i class="fa fa-pen icon-sm text-muted"></i>
														<input type="file" name="image" accept=".png, .jpg, .jpeg"/>
													</label>
													
													<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Photo">
														<i class="ki ki-bold-close icon-xs text-muted"></i>
													</span>
													
													<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove Photo">
														<i class="ki ki-bold-close icon-xs text-muted"></i>
													</span>
												</div>
											</div>

											<hr>

											<div class="form-group">
												<label class="">Multiple Product Image Upload</label>

												<div class="">
													<input type="file" name="gallery[]" class="form-control" multiple>
												</div>
											</div>

											<div class="form-group">
												<label class="">Description</label>

												<div class="">
													<textarea class="summernote form-control" name="description" id="" cols="30" rows="10"></textarea>
												</div>
											</div>
										</div>

										<div class="col-md-12">
											<br>
											<hr>

											<div class="form-group">
												<label class="">Add Variant:</label>

												<div class="">
													<span class="switch">
														<label>
															<input type="checkbox" class="add_varient" name="has_varient" value="1"  />
															<span></span>
														</label>
													</span>
												</div>
											</div>

											<div class="table-respnsive table-area">

												@if(count($varienttypes) > 0)
													Select Variant

													<ul class="list-group list-group-horizontal mb-4">
														@foreach ($varienttypes as $varienttype)
															<li class="list-group-item">
																<label class="form-check-label">
																	<input value="{{$varienttype->id}}" class="form-check-input conditional_varient" type="checkbox" name="varient_type_ids[]" autocomplete="off"> {{$varienttype->name}}
																</label>
															</li>
														@endforeach
													</ul> 
															
													<table class="table table-bordered table-sm text-left">
														<thead>
															<tr>
																<th>Image</th>

																@foreach ($varienttypes as $varienttype)
																	<th style="display: none" class="conditional_varient_td_{{$varienttype->id}}">{{$varienttype->name}}</th>
																@endforeach
																
																<th>Weight</th>
																<th>Initial Quantity</th>
																<th>Sale Price</th>
																<th>Discount</th>
																<th>Discount Type</th>
																<th>Total Sale Price</th>
																<th><span style="cursor: pointer;" class="btn btn-info font-weight-bolder font-size-sm mr-3 add_more">Add new variant</span></th>
															</tr>
														</thead>

														<tbody>
															<tr>
																<td>
																	<input type="file" name="varient_image[]" class="form-control">
																</td>

																@foreach ($varienttypes as $varienttype)
																	<td style="display: none" class="conditional_varient_td_{{ $varienttype->id }}">
																		
																		<input class="form-control" list="browsers{{ $varienttype->id }}" name="varient_name[{{ $varienttype->id }}][]" id="browser{{ $varienttype->id }}" autocomplete="off">

																		<datalist id="browsers{{ $varienttype->id }}">
																			@foreach ($varienttype->varientValues as $varient_value)
																				<option value="{{$varient_value->value}}">
																			@endforeach
																		</datalist>
																	</td>
																@endforeach

																<td>
																	<input type="number" class="form-control" name="weights[]">
																</td>

																<td>
																	<input type="number" class="form-control" name="sale_quantity[]">
																</td>
																
																<td>
																	<input onchange="calculate_values(this)" type="number" step="0.01" class="form-control varient_sale_price" name="sale_price[]" >
																</td>

																<td>
																	<input onchange="calculate_values(this)" type="number" step="0.01" class="form-control varient_discount" name="varient_discount[]" >
																</td>
																<td>
																	<div class="form-group">
																		<select onchange="calculate_values(this)" class="form-control varient_discount_type" name="varient_discount_type[]">
																			<option value="">Select</option>
																			<option value="1">Flat Rate</option>
																			<option value="2">Percentage</option>
																		</select>
																	</div>
																</td>

																<td>
																	<input onchange="calculate_values(this)" type="number" step=".01" class="form-control varient_discounted_price">
																</td>

																<td>
																	<span onclick="remove_tr(this)" style="cursor: pointer;" class="btn btn-danger font-weight-bolder font-size-sm mr-3 remove_more">Remove</span>
																</td>
															</tr>
														</tbody>
													</table>
												@else

													<p class="text-danger">No Variant Type Found</p>

												@endif
											</div>
										</div>
									</div>
								</div>

								<div class="card-footer">
									<div class="row">
										<div class="col-lg-9 text-right">
											<button type="submit" class="btn btn-primary font-weight-bold save_button">Save</button>
										</div>
									</div>
								</div>
							</form>
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
	<script src="assets/js/pages/crud/forms/editors/summernote.js"></script>

	<script>
		$(document).ready(function () {
			$('.summernote').summernote({
				height: 200,
			});
		});

		$("form#save_product").submit(function(e) {

			$('.save_button').text('');
			$('.save_button').text('Saving...');

			e.preventDefault();

			var can_submit = 1;
			var can_sale_submit = 1;
			var has_varient_value = 0;

			if (!$("input[name=name]").val()) {
				Swal.fire(
					'Error!',
					'Product name is required',
					'success'
				);
				$('.save_button').text('');
				$('.save_button').text('Save');
				return false;
			}

			var parent_category = $(".parent_category option:selected").val();
			
			if (!parent_category) {
				Swal.fire(
					'Error!',
					'Category is required',
					'success'
				);
				$('.save_button').text('');
				$('.save_button').text('Save');
				return false;
			}
			
			if (!$("input[name=code]").val()) {
				Swal.fire(
					'Error!',
					'Code is required',
					'success'
				);
				$('.save_button').text('');
				$('.save_button').text('Save');
				return false;
			}

			// var has_varient = $('input[name=has_varient]:checked');
			
			if ($(".add_varient").is(':checked')) {
				var type_length = $("input[name='varient_type_ids[]']:checked").length;

				
				if (type_length == 0) {
					Swal.fire(
					'Error!',
					'Please select at least 1 variant',
					'error'
					);
					$('.save_button').text('');
					$('.save_button').text('Save');
					return false;
				}
				
				$("input[name='sale_quantity[]']").map(function(){
					
					if (!$(this).val()) {
						can_submit = 0;
					}
				}).get();
				
				$("input[name='sale_price[]']").map(function(){
					if (!$(this).val()) {
						can_sale_submit = 0;
					}
				}).get();

				$('.table-area table > tbody  > tr').each(function(index, tr) {
					has_varient_value = 0;
					$("input[name='varient_type_ids[]']:checked").map(function(key, data){

						
						$(tr).find("td input[name='varient_name["+data.value+"][]']").map(function(){
							
							if ($(this).val()) {
								has_varient_value = 1;
							}
						}).get();

					}).get();
				});

				if (has_varient_value == 0) {
				Swal.fire(
					'Error!',
					'Variant combination is empty',
					'success'
				);
				$('.save_button').text('');
				$('.save_button').text('Save');
				return false;
			}	
				
			} else {
				
				if (!$("input[name=price]").val()) {
					Swal.fire(
						'Error!',
						'Sale price is required',
						'success'
					);
					$('.save_button').text('');
					$('.save_button').text('Save');
					return false;
				}
				
				if (!$("input[name=quantity]").val()) {
					Swal.fire(
						'Error!',
						'Quantity is required',
						'success'
					);
					$('.save_button').text('');
					$('.save_button').text('Save');
					return false;
				}
			}

			if (can_submit == 0) {
				Swal.fire(
					'Error!',
					'Quantity is empty',
					'success'
				);
				$('.save_button').text('');
				$('.save_button').text('Save');
				return false;
			}
			
			if (can_sale_submit == 0) {
				Swal.fire(
					'Error!',
					'Sale Price is empty',
					'success'
				);
				$('.save_button').text('');
				$('.save_button').text('Save');
				return false;
			}

			var formData = new FormData(this);

			$.ajax({
				url: "{{route('admin.product.store')}}",
				type: "post",
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					$('.save_button').text('');
					$('.save_button').text('Save');
					window.location.href = "{{route('admin.product.index')}}/?complete=1";					
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
					$('.save_button').text('');
					$('.save_button').text('Save');
				
				}
			});
		});
		
		// $(".parent_category").change(function(){

		// 	if(this.value){
		// 		var value= this.value;
		// 		$.ajax({
		// 			url: "{{route('get_child_category')}}?id="+value,
		// 			type: "get",
		// 			success: function (response) {

		// 				$('.sub_parent_category').empty();
		// 				$('.sub_parent_category').append(response);
		// 			},
		// 			error: function(jqXHR, textStatus, errorThrown) {
					
		// 			}
		// 		});
		// 	}

		// });
		
		function calculate_values(that){

			var varient_sale_price = $(that).closest('tr').find('.varient_sale_price').val();
			var varient_discount = $(that).closest('tr').find('.varient_discount').val();
			var varient_discount_type = $(that).closest('tr').find('td option:selected').val();
			var vat = $("input[name=vat]").val();
			var sd = $("input[name=sd]").val();

			if (!varient_discount) {
				varient_discount = 0;
			}

			if (!vat) {
				vat = 0;
			}
			
			if (!sd) {
				sd = 0;
			}

			if (varient_sale_price) {
				if (varient_discount_type && varient_discount_type == 2) {
					var discount_price = Number(varient_sale_price) - ((Number(varient_sale_price) * Number(varient_discount)) / 100);
				} else if(varient_discount_type && varient_discount_type == 1) {
					var discount_price = Number(varient_sale_price) - Number(varient_discount);
				} else {
					var discount_price = Number(varient_sale_price);
				}

				if (sd > 0) {
					discount_price = Number(discount_price) + ((Number(discount_price) * Number(sd)) / 100);
				}

				if (vat > 0) {
					discount_price = Number(discount_price) + ((Number(discount_price) * Number(vat)) / 100);
				}
			}

			$(that).closest('tr').find('.varient_discounted_price').val(discount_price.toFixed(2));
		}
		
		function calculate_val(){

			var varient_sale_price = $("input[name=price]").val();
			var varient_discount = $("input[name=discount]").val();
			var varient_discount_type = $(".select_discount_type option:selected").val();
			var vat = $("input[name=vat]").val();
			var sd = $("input[name=sd]").val();

			if (!varient_discount) {
				varient_discount = 0;
			}

			if (!vat) {
				vat = 0;
			}
			
			if (!sd) {
				sd = 0;
			}

			if (varient_sale_price) {
				if (varient_discount_type && varient_discount_type == 2) {
					var discount_price = Number(varient_sale_price) - ((Number(varient_sale_price) * Number(varient_discount)) / 100);
				} else if(varient_discount_type && varient_discount_type == 1) {
					var discount_price = Number(varient_sale_price) - Number(varient_discount);
				} else {
					var discount_price = Number(varient_sale_price);
				}

				if (sd > 0) {
					discount_price = Number(discount_price) + ((Number(discount_price) * Number(sd)) / 100);
				}

				if (vat > 0) {
					discount_price = Number(discount_price) + ((Number(discount_price) * Number(vat)) / 100);
				}
			}
			
			$("input[name=total_price]").val(discount_price.toFixed(2));
		}
		
		// $(".table-area").hide();

		$(document).ready(function(){
			if($(".add_varient").is(':checked')) {
				$(".table-area").show();
				$(".conditional_area").hide();

			} else {
				$(".table-area").hide();
				$(".conditional_area").show();
			}
		});

		$('.add_varient').click(function() {
			if(this.checked) {
				$(".table-area").show();
				$(".conditional_area").hide();
			} else {
				$(".table-area").hide();
				$(".conditional_area").show();
			}
		});
		
		$('.conditional_varient').click(function() {
			if(this.checked && this.value) {
				$(".conditional_varient_td_"+this.value).show();
			} else {
				$(".conditional_varient_td_"+this.value).hide();
			}
		});
		
		$('.add_more').click(function() {
			
			var clone = $(".table-area tbody tr:first-child").clone();

			$(".table-area tbody").append(clone);
			$(".table-area tbody tr:last-child td").find('input').val('');
		});
		
		function remove_tr(that) {
			$(that).closest('tr').remove();
		}
	</script>

	<script> 
		var avatar5 = new KTImageInput('kt_image_5');
		var avatar6 = new KTImageInput('kt_image_6');

		avatar5.on('cancel', function(imageInput) {
			// swal.fire({
			//     title: 'Image successfully changed !',
			//     type: 'success',
			//     buttonsStyling: false,
			//     confirmButtonText: 'Awesome!',
			//     confirmButtonClass: 'btn btn-primary font-weight-bold'
			// });
		});

		avatar5.on('change', function(imageInput) {});

		avatar5.on('remove', function(imageInput) {});

		avatar6.on('cancel', function(imageInput) {});

		avatar6.on('change', function(imageInput) {});

		avatar6.on('remove', function(imageInput) {});
	</script>
@endpush

@push('css')
	<style>
		.table-area tbody tr:first-child .remove_more {
			display: none;
		}

		/* .table-area tbody tr:last-child td {
			background-color: green;
		} */

		.list-group-item {
			padding-left: 35px;
		}
	</style>
@endpush