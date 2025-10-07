@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    

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
                            <h3 class="card-title">Adjust Damage Product</h3>
                            <div class="d-flex align-items-center">                                    
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.productDamage.store') }}" class="form-group" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-md-2">
                                        <label for="product_type"><b>Product Type</b></label>
                                        <select name="product_type" class="form-control" id="product_type">
                                            <option>--Select One--</option>
                                            <option value="1">Product</option>
                                            <option value="2">Store Product</option>
                                        </select>                                        
                                    </div> --}}
                                    <input type="hidden" name="product_type" value="1">

                                    <div class="col-md-2">
                                        <label for="product"><b>Product</b></label>
                                        <select name="product" class="form-control select2" id="product">
                                            <option>--Select One--</option>
                                            
                                        </select>                                        
                                    </div>
                                    <div class="col-md-2" id="product_varient_level">
                                        <label for="product_varient"><b>Product Variant</b></label>
                                        <select name="product_varient" class="form-control select2" id="product_varient">
                                            <option>--Select One--</option>
                                            
                                        </select>                                        
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity"><b>Quantity (pcs)</b></label>
                                        <input type="text" name="quantity" class="form-control" id="quantity" readonly>                                      
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity"><b>Damage Quantity</b></label>
                                        <input type="text" value="{{ old('damange_quantity') }}" name="damange_quantity" class="form-control" placeholder="Enter Amount" id="damange_quantity">                                      
                                    </div>
                                    <div class="col-md-2">
                                        <label for="quantity"><b>Requisition Document <span class="text-danger">*</span></b></label>
                                        <input type="file" name="document" class="form-control">                                      
                                    </div>
                                    <div class="col-md-1 mt-5">
                                        <button class="btn btn-primary mt-3" type="submit">Submit</button>                                    
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('stackScript')
<script>
    $(document).ready(function(){
        // $("#product_type").change(function() {
            // $('#quantity').val("");
            // $('#product_varient').empty();
            // $('#product_varient').append("<option value=''>Select Variant</option>");
            // var productType= $(this).val(); 
            var productType= 1; 
            
            var url = window.location.origin+`/admin/product/damage/${productType}/get-products`;
            
            $.getJSON(url, function(data){               
                
                $('#product').html('<option value="">Select Product</option>');
                data.forEach(element => {
                    $('#product').append(`<option value="${element.id}">${element.name}</option>`);
                });
            });
  
        // });

        
        $( "#product" ).on('change', function() {
            // alert();
            $('#quantity').val("");
            var productVarientId= $("#product").val();
            if (productVarientId) {
                var url= window.location.origin+`/admin/product/damage/${productVarientId}/get-product-varient`;
                $.ajax({
                url: url,
                type: "get",
                success: function (response) {
                
                    $('#product_varient').empty();
                    $('#product_varient').append(response);

                    var length = $('#product_varient > option').length;

                    if (length > 1) {
                        $('#product_varient_level').show();
                    } else {
                        $('#product_varient_level').hide();
                        var url= window.location.origin+`/admin/product/damage/${productVarientId}/get-stock`;
                        $.getJSON(url, function(data){
                            $('#quantity').empty();
                            var total = parseInt(data.quantity);
                            $('#quantity').val(total);
                                            
                            $('#quantity').attr('readonly',"true");
                        });
                        
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                // console.log(textStatus, errorThrown);
                }
            
            });
        } else {
            $('#quantity').val('');
            $('#quantity').attr('readonly',"true");
        }
            // $.getJSON(url, function(data){
                  
                // console.log(data);
                // $('#product_varient').append(data);
                // if(data.length > 0){
                //     $('#product_varient_level').show();
                //     $('#quantity').val('select product varient');

                //     $('#product_varient').html('<option value="">Select Product Variant</option>');
                //     data.forEach(element => {
                //         $('#product_varient').append(`<option value="${element.id}">${element.data_value}</option>`);
                //     });
                // }
                // else if(data.length == 0){
                //     $('#product_varient').empty();
                //     $('#product_varient_level').hide();
                //     var url= window.location.origin+`/admin/product/damage/${productVarientId}/get-stock`;
            
                //     $.getJSON(url, function(data){
                //         $('#quantity').empty();
                //         var total = parseInt(data.quantity);
                //         $('#quantity').val(total);
                                        
                //         $('#quantity').attr('readonly',"true");
                //     });

                // }
            // });
        });

        $( "#product_varient" ).on('change', function() {


            var product_varient = $("#product_varient").val();  

            var url= window.location.origin+`/admin/product/damage/${product_varient}/get-varient-stock`;

            if (!$("#product_varient").val()) {
                $('#quantity').val("");
            }
            
            $.getJSON(url, function(data){
                $('#quantity').empty();
                var total = parseInt(data.quantity);
                $('#quantity').val(total);
                                
                $('#quantity').attr('readonly',"true");
            });
  
        });
    });
</script>
@endpush
@endsection