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
							{{-- <form class="form-inline"  style="float: right;">
								<label class="mr-2" for="email">Product Category:</label>
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
							  </form>  --}}
                            
                            <form id="save_product" enctype="multipart/form-data">
								@csrf
								<div class="table-responsive ajax-data-container pt-3">
									<table class="table table-area">
										<thead>
											<tr>
												<th style="width: 40%;" class="text-left">Product Name</th>
												<th style="width: 25%;" class="text-left">In Stock</th>
												<th style="width: 25%;" class="text-left">New Stock</th>
												<th class="text-left">
                                                    <span style="cursor: pointer;" class="btn btn-info font-weight-bolder font-size-sm mr-3 add_more">Add More</span>
                                                </th>
											</tr>
										</thead>
										<tbody>
											
													<tr>
														<td>
															<select onchange="get_product(this)" name="product_id[]" class="form-control product_id" required>
                                                                <option value="">Select</option>
                                                                @foreach ($products as $product)
                                                                    <option data-quantity="{{$product->productSingleStock->quantity ?? 0}}" value="{{$product->id}}">{{$product->name}}</option>
                                                                @endforeach
                                                            </select>
														</td>
														<td align="left">
															<span class="append_quantity">

                                                            </span>
															
														</td>
									
														<td>
															<input class="form-control" type="number" name="quantity[]" required>
														</td>

                                                        <td>
                                                            <span onclick="remove_tr(this)" style="cursor: pointer;" class="btn btn-danger font-weight-bolder font-size-sm mr-3 remove_more">Remove</span>
                                                        </td>
									
													</tr>
													
											
										</tbody>
									</table>                          
								</div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="">Requisition document: <span class="text-danger">*</span></label>
                                        <input style="max-width: 250px" class="form-control" type="file" name="document" id="" required>
                                    </div>
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

@push('css')
<style>
    .table-responsive tbody tr:first-child td:last-child {
        display: none;
    }
</style>
@endpush
@push('stackScript')
	<script> 
		$("form#save_product").submit(function(e) {

		e.preventDefault();
        var myarray = [];
        var found = 0;
        $('.product_id option:selected').each(function () {
            
            if( $.inArray($(this).val(), myarray) !== -1 ) {
                found = 1;
            } else {
                myarray.push($(this).val());
            }
            
        });
        if (found == 1) {
            Swal.fire(
                'Error!',
                'Dublicate Product selected',
                'success'
            );
            return false;
        }

		var formData = new FormData(this);
		$.ajax({
			url: "{{route('admin.product.store_material_inventory')}}",
			type: "post",
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {

				window.location.href = "{{route('admin.product.material_index')}}/?complete=1";					
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

    $('.add_more').click(function() {
		var clone = $(".table-area tbody tr:first-child").clone();
		$(".table-area tbody").append(clone);
		$(".table-area tbody tr:last-child td").find('input').val('');
	});

    function get_product(that) {
        var totalQuantits = $(that).find(':selected').data('quantity');
		var quantity = parseInt(totalQuantits);
        
        if (quantity != '') {
            $(that).closest('tr').find('span.append_quantity').text(quantity);
        } else {
            $(that).closest('tr').find('span.append_quantity').text('');
        }
	}
    
    function remove_tr(that) {
		$(that).closest('tr').remove();
	}

	</script>
@endpush