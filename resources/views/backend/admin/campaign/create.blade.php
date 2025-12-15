@extends('backend.layout.master')

@section('content')
<!--begin::Content-->

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Create Campaign</h3>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">
                            <form id="save_campaign" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Campaign Name <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" id="title" placeholder="Enter campaign title" value="{{ old('title') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                            <input type="datetime-local" name="start_date" class="form-control" id="start_date" value="{{ old('start_date') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="end_date">End Date <span class="text-danger">*</span></label>
                                            <input type="datetime-local" name="end_date" class="form-control" id="end_date" value="{{ old('end_date') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Banner <span class="text-danger">*</span></label>
                                            <input type="file" name="image" class="form-control" id="image" value="{{ old('image') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Discount Type </label>
                                            <select class='form-control campaign_varient_discount_type' name='campaign_discount_type'>
                                                <option value="">Select Type</option>
                                                <option value="1">Flat Rate</option>
                                                <option value="2">Percentage</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Discount Amount</label>
                                            <input class="form-control campaign_product_discount" placeholder="Discount Amount" type="number" name="campaign_product_discount">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <span class="switch">
                                                <label>
                                                    <input type="checkbox" checked name="status" value="1" />
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Featured</label>
                                            <span class="switch">
                                                <label>
                                                    <input type="checkbox" name="featured" value="1" />
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <select id="productSelect" multiple required autocomplete="off">
                                            @foreach ($products as $product)
                                                @if ($product->has_varient == 1)
                                                    @foreach ($product->productVarient as $varient)
                                                        <option data-stockquantity={{number_format($varient->productStock->quantity ?? 0,0)}} data-price={{round($varient->discount_price)}} data-delprice={{round($varient->price)}} value="{{ $product->id }}-{{ $varient->id }}">
                                                            {{ $product->name }} -
                                                            @foreach ($varient->productVarientData as $varient_data)
                                                                {{$varient_data->varientTypeInfo->name ?? ''}}: {{ $varient_data->data_value }}@if(!$loop->last)-@endif
                                                            @endforeach
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option data-stockquantity={{number_format($product->productSingleStock->quantity ?? 0,0)}} data-price={{round($product->discount_price)}} data-delprice={{round($product->price)}} value="{{ $product->id }}-0">{{ $product->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-5">
                                        <h5 class="text-danger text-bold mb-3 text-center">Discount applied on base column red color price</h5>
                                        <table class="table table-bordered campaign_product_list">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        Product
                                                    </th>
                                                    <th>
                                                        Base Price
                                                    </th>
                                                    <th>
                                                        In Stock
                                                    </th>
                                                    <th>
                                                        Discount Type
                                                    </th>
                                                    <th>
                                                        Discount
                                                    </th>
                                                    <th>
                                                        Discount Price
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button type="submit" name="create_campaign" value="2" class="btn btn-primary create_campaign">Save Campaign</button>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


    <script>

        $('#productSelect').change(function() {

            let product_value = $(this).val();
            let product_name = $(this).text();
            let lastClicked = $(this).find(':selected').last();
            // console.log(product_value);
            if (product_value.length > 0) {
                document.querySelectorAll('.campaign_product_list tbody input[name="product_id[]"]').forEach(function(input) {
                    if (!product_value.includes(input.value)) {
                        input.closest('tr').remove();
                    }
                });


                product_value.forEach(function(selected_value) {
                    let product_text = $('#productSelect option[value="'+selected_value+'"]').text();
                    let product_price = $('#productSelect option[value="'+selected_value+'"]').attr('data-price');
                    let del_product_price = $('#productSelect option[value="'+selected_value+'"]').attr('data-delprice');
                    let stockquantity = $('#productSelect option[value="'+selected_value+'"]').attr('data-stockquantity');

                    if (!del_product_price) {
                        del_product_price = 0;

                    }
                    Number(del_product_price).toFixed();
                    if (!product_price) {
                        product_price = 0;
                    }
                    Number(product_price).toFixed();

                    let check_existence = $('.hidden_product_'+selected_value).val();
                    let discounted_price = 0;
                    if (!check_existence) {
                        let campaign_varient_discount_type = $('.campaign_varient_discount_type').val();
                        let campaign_product_discount = $('.campaign_product_discount').val();
                        let selected_type_fixed = '';
                        let selected_type_percentage = '';
                        if ($.inArray(campaign_varient_discount_type, [1,2]) != -1 || campaign_product_discount > 0) {
                            if (campaign_varient_discount_type == 1) {
                                discounted_price = del_product_price - campaign_product_discount;
                                selected_type_fixed = 'selected';
                            } else if(campaign_varient_discount_type == 2) {
                                discounted_price = del_product_price - ((del_product_price * campaign_product_discount) / 100);
                                selected_type_percentage = 'selected';
                            }
                        }

                        if (discounted_price < 0) {
                            discounted_price = 0;
                        }
                        let appended_html = `<tr>
                                    <td class="text-left">
                                        <span class="product_name">${product_text}</span>
                                        <input type="hidden" class="hidden_product_${selected_value}" name="product_id[]" value="${selected_value}">
                                    </td>
                                    <td>
                                        <del class="product_price text-danger">${del_product_price}</del> <br>
                                        <span class="product_discount_price">${product_price}</span>
                                    </td>
                                    <td>
                                        <span class="product_stock_quantity">${stockquantity}</span>
                                    </td>
                                    <td>
                                        <select onchange='calculate_values(this)' class='form-control varient_discount_type' name='discount_type[]'>
                                            <option value="1" ${selected_type_fixed}>Flat Rate</option>
                                            <option value="2" ${selected_type_percentage}>Percentage</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control product_discount" value="${campaign_product_discount}" onchange='calculate_values(this)' type="number" name="product_discount[]" placeholder="Discount Amount">
                                    </td>
                                    <td>
                                        <span class="discounted_price">${discounted_price.toFixed()}</span>
                                    </td>
                                </tr>`;


                        $('.campaign_product_list').find('tbody').append(appended_html);
                    }

                });

            } else {
                $('.campaign_product_list tbody').find('tr').remove()
            }

        });

        function calculate_values(that) {
            let type = $(that).closest('tr').find('.varient_discount_type').val();
            let discount = $(that).closest('tr').find('.product_discount').val();
            let del_product_price = $(that).closest('tr').find('.product_price').text();

            let discount_total = 0;

            if (type == 1) {
                discount_total = Number(del_product_price) - Number(discount);
            } else if(type == 2) {
                discount_total = Number(del_product_price) - ((Number(del_product_price) * Number(discount))/Number(100));
            }

            if (discount_total < 0) {
                discount_total = 0;
            }

            $(that).closest('tr').find('.discounted_price').text(discount_total.toFixed());
        }

        const productSelect = new Choices('#productSelect', {
            removeItemButton: true,
            searchEnabled: true,
            placeholder: true,
            loadingText: 'Loading...',
            noResultsText: 'No results found',
            shouldSort: false,
            placeholderValue: 'Select products',
        });


        $("form#save_campaign").submit(function(e) {
			e.preventDefault();
            $('.create_campaign').text('');
			$('.create_campaign').text('Saving...');
            var product_length = $("input[name='product_id[]']").length;

            if (product_length < 1) {
                Swal.fire(
                    'Error!',
                    'No product selected',
                    'success'
                )

                $('.create_campaign').text('');
				$('.create_campaign').text('Save Campaign');

                return false;
            }

			var formData = new FormData(this);

			$.ajax({
				url: "{{route('admin.campaign.store')}}",
				type: "post",
				data: formData,
				processData: false,
				contentType: false,
				success: function (response) {
					$('.create_campaign').text('');
					$('.create_campaign').text('Save Campaign');
					window.location.href = "{{route('admin.campaign.index')}}";
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
					$('.create_campaign').text('');
					$('.create_campaign').text('Save Campaign');

				}
			});

		});
    </script>
@endpush
