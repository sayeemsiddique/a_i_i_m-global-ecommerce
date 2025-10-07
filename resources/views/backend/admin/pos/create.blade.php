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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">{{$global_setting->title ?? ""}} Point Of Sales</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.index') }}" class="text-muted">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a class="text-muted">Point Of Sales (POS)</a>
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
                <!--begin::Card-->
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header p-3">

                                <input type="text" data-url="{{ route('admin.searchAjax', ['type' => 'posItemSearch']) }}" class="form-control form-control-lg form-control-solid ajax-data-search cartItemOnkeySave" name="q" placeholder="Search Items By Product Name or Code" style="background-color:white;">

                            </div>

                            <div class="card-body">
                                <div class="table-responsive ajax-data-container">
                                    @include('backend.admin.pos.ajax.productTable')
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <!--begin::Card-->
                        <form action="{{ route('admin.pos.submit') }}" class="form-group " method="post">
                            @csrf

                            <div class="card card-custom example example-compact" style="min-height: 512px;">
                                <div class="card-body">
                                    
                                        <div class="row">
                                            
                                            <div class="col-lg-12 col-md-12 col-sm-12 mb-2" >
                                                <select class="form-control step2-select"
                                                    name="customer" id="customer" 
                                                    required
                                                    data-placeholder="Customer"
                                                    data-select2-id="customer"
                                                    tabindex="-1" 
                                                    aria-hidden="true"
                                                    data-ajax-url="{{ route('admin.searchAjax', ['type'=>'searchPOSCustomer']) }}"
                                                    data-ajax-cache="true"
                                                    data-ajax-dataType="json"
                                                    data-ajax-delay="200">
                                                                                                       
                                                </select>
                                            </div>
                                        </div>
                                    <div class="table-responsive ajax-data-container-product">
                                        @include('backend.admin.pos.ajax.cartTable')
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">

                                <div class="col-md-6">
                                    <button class="btn btn-block btn-danger" type="submit" name="cancel"
                                        value="cancel">Cancel</button>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="preview_pos" value="1">
                                    <button class="btn btn-block btn-success" type="submit" name="submit"
                                        value="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
    </div>

@endsection

@push('stackScript')

    {{-- <script>
        $('.cartItemOnkeySave').on('keyup', function(e) {

            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "",
                data: {
                    _token: $('input[name=_token]').val(),
                    item_id: $(this).val()
                },

                success: function(response) {
                    $(".ajax-data-container-product").empty().append(response.page);
                },

            });
        });
    </script> --}}

    <script>
        function addToCart(id)
        {
                var item = id;
                $.ajax({
                    url: window.location.origin + `/admin/pos/add-to-cart/${item.product_id}?varient_id=${item.varient_id}`,
                    type: 'GET',
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        $(".ajax-data-container-product").empty().append(response.page);
                        if(response.message)
                        {
                            Swal.fire(response.message, '', 'warning');
                        }
                    },
                    error: function() {}
                });
            // });
        }
    </script>
    <script>
        function updateCartQuantity(itemId) {
            var id = itemId;
            var quantity = $(".update-cart-quantity" + id).val();
            
            $.ajax({
                url: window.location.origin + `/admin/pos/update-cart/${id}/${quantity}`,
                type: 'GET',
                cache: false,
                dataType: 'json',
                success: function(response) {
                    
                    $(".ajax-data-container-product").empty().append(response.page);                    
                    if(response.message)
                    {
                        Swal.fire(response.message, '', 'warning');
                    }
                },
                error: function(response){
                }
            });
        }
    </script>
    <script>
        function deleteCart(id) {
            var item_id = id;
            $.ajax({

                url: window.location.origin + `/admin/pos/delete-from-cart/${item_id}`,
                type: 'GET',
                cache: false,
                dataType: 'json',
                success: function(response) {
                    $(".ajax-data-container-product").empty().append(response.page);
                },
                error: function() {}
            });

        }
    </script>

    <script> 
        $('form')
            .each(function(){
                $(this).data('serialized', $(this).serialize())
            })
            .on('change input', function(){
                $(this)             
                    .find('input:submit, button:submit')
                        .prop('enable', $(this).serialize() == $(this).data('serialized'))
                ;
            })
            .find('input:submit, button:submit')
                .prop('disabled', false)
        ;
    </script>
    
@endpush
