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
                            <h3 class="card-title">Campaign List</h3>
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
                                            <label>Banner</label>
                                            <input type="file" name="image" class="form-control" id="image" value="{{ old('image') }}" required>
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
                                    <div class="col-md-6">
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
                                    {{-- <div class="col-md-12">
                                        <button type="submit" name="create_campaign" value="1" class="btn btn-primary">Save Campaign</button>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <select id="productSelect" multiple required autocomplete="off">
                                            @foreach ($products as $product)
                                                @if ($product->has_varient == 1)
                                                    @foreach ($product->productVarient as $varient)
                                                        <option data-price={{$varient->discount_price}} data-delprice={{$product->price}} value="{{ $product->id }}-{{ $varient->id }}">
                                                            {{ $product->name }} -
                                                            @foreach ($varient->productVarientData as $varient_data)
                                                                {{$varient_data->varientTypeInfo->name ?? ''}}: {{ $varient_data->data_value }}@if(!$loop->last)-@endif
                                                            @endforeach
                                                        </option>
                                                    @endforeach
                                                @else
                                                    <option data-price={{$product->discount_price}} data-delprice={{$product->price}} value="{{ $product->id }}-0">{{ $product->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-5">
                                        <table class="table table-bordered campaign_product_list">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        Product
                                                    </th>
                                                    <th>
                                                        Base Price
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
                                <button type="submit" name="create_campaign" value="2" class="btn btn-primary">Save Campaign</button>
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

        function calculate_values(that) {
            let type = $(that).closest('te').find('.varient_discount_type').val();
            let discount = $(that).closest('te').find('.product_discount').val();

        }

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

                    let check_existence = $('.hidden_product_'+selected_value).val();
                    if (!check_existence) {
                        let appended_html = `<tr>
                                    <td>
                                        <span class="product_name">${product_text}</span>
                                        <input type="hidden" class="hidden_product_${selected_value}" name="product_id[]" value="${selected_value}">
                                    </td>
                                    <td>
                                        <del class="product_price">${del_product_price}</del> <br>
                                        <span class="product_discount_price">${product_price}</span>
                                    </td>
                                    <td>
                                        <select onchange='calculate_values(this)' class='form-control varient_discount_type' name='discount_type[]'>
                                            <option value="1">Flat Rate</option>
                                            <option value="2">Percentage</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control product_discount" onchange='calculate_values(this)' type="number" name="product_discount[]">
                                    </td>
                                    <td>
                                        <span class="discounted_price"></span>
                                    </td>
                                </tr>`;


                        $('.campaign_product_list').find('tbody').append(appended_html);
                    }

                });








            } else {
                $('.campaign_product_list tbody').find('tr').remove()
            }

        });

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
            var type_length = $("input[name='varient_type_ids[]']:checked").length;

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
					window.location.href = "{{route('admin.campaign.index')}}/?complete=1";
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
    </script>
@endpush
