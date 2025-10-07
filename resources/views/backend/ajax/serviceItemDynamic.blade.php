<script>
    

    $(".service_id").on('change',function(e){

        var service_item_list = $(".service_item_id");

        if (this.checked) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "{{route('serviceItems')}}",
                data: {_token:$('input[name=_token]').val(),
                service_id: $(this).val()},

                success:function(response){
                    $('.service_item_list').append(response);
                    $.each(response, function(){
                        $('.service_item_list').html(response);
                    });
                }

            });

            $.ajax({
                type: 'POST',
                url: "{{route('serviceAdditionalItems')}}",
                data: {_token:$('input[name=_token]').val(),
                service_id: $(this).val()},

                success:function(response){
                    $('.service_additional_item_list').append(response);
                    $.each(response, function(){
                        $('.service_additional_item_list').html(response);
                    });
                }

            });

            $.ajax({
                type: 'POST',
                url: "{{route('serviceAdditionalItemPrice')}}",
                data: {_token:$('input[name=_token]').val(),
                service_id: $(this).val()},

                success:function(response){
                    $('.service_additional_item_price').append(response);
                    $.each(response, function(){
                        $('.service_additional_item_price').html(response);
                    });
                }

            });
            servicePrice($(this).val());
        } else if(!(this.checked)) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".items"+$(this).val()).remove();
            $(".price"+$(this).val()).remove();
            $(".additems"+$(this).val()).remove();
            $(".addprice"+$(this).val()).remove();
            $(".selectservice"+$(this).val()).remove();
            total();

            $.ajax({
                type: 'POST',
                url: "{{route('serviceValueRemoved')}}",
                data: {_token:$('input[name=_token]').val(),
                service_id: $(this).val()},

                success:function(){
                    
                }

            });
        }
    });

    $('.usage_type').on('change',function(){
        $(".service_id:checkbox:checked").each(function(){
            $(".price"+$(this).val()).remove();
            servicePrice($(this).val());
        });

        $(".service_item_id:checkbox:checked").each(function(){
            $(".selectitems"+$(this).val()).remove();
            item($(this).val());
        });

    });

    function servicePrice(id) {
            
        let usage_type = $("input[name='usage_type']:checked").val();

        $.ajax({
            type: 'POST',
            url: "{{route('serviceItemPrice')}}",
            data: {_token:$('input[name=_token]').val(),
            service_id: id,
            usage_type: usage_type},

            success:function(response){
                // $('.service_item_price').empty();
                
                $('.service_item_price').append(response);
                $.each(response, function(){
                    $('.service_item_price').html(response);
                });
            }

        });
    }

    function item(id){
        if ($('.itemdata'+id).is(':checked')) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let usage_type_val = $("input[name='usage_type']:checked").val();

            $.ajax({
                type: 'POST',
                url: "{{route('serviceItemsvalue')}}",
                data: {_token:$('input[name=_token]').val(),
                service_id: id,
                usage_type: usage_type_val},

                success:function(response){
                    $('.select_service_list').append(response[0]);
                    $('.select_service_item_list').append(response[1]);
                    $('.select_service_price_list').append(response[2]);
                    total();
                }

            });
        } else {
            $(".selectitems"+id).remove();
            total();

            $.ajax({
                type: 'POST',
                url: "{{route('itemValueRemoved')}}",
                data: {service_item_id: id},

                success:function(){
                    
                }

            });
        }
    }

    function receive(){
        if ($('.service_item_id').is(':checked')) {

			let data = $('.appForm').serialize();

            $.ajax({
                type: 'POST',
                url: "{{route('serviceItemReceiving')}}",
                data: data+'&_token={{csrf_token()}}',

                success:function(response){
                    $('#receiving_mode1').html(response[0]);
                    $('#receiving_mode2').html(response[1]);
                }

            });
        } else {
            $('#receiving_mode1').html('');
            $('#receiving_mode2').html('');
            $('.courier_address').hide();
			$(".courier_address input").removeAttr("required");
        }
    }
    
    function total(){
        var total=0;
        $('.total').each(function(){
            var totalAmount = $(this).val();
            total +=parseInt(totalAmount);
        });
        $('.totalPrice').text(total.toFixed(2));
        $('.totalPrice').val(total.toFixed(2));
    }

    $(".clear").click(function(){
        $('.select_service_list').html('');
        $('.select_service_item_list').html('');
        $('.select_service_price_list').html('');

        $('.service_item_list').html('');
        $('.service_item_price').html('');
        $('.service_additional_item_list').html('');
        $('.service_additional_item_price').html('');
        total();
    })

    $(document).ready(function () {
        $(".service_item_id:checkbox:checked").each(function(){
            $(".selectitems"+$(this).val()).remove();
            item($(this).val());
        });
    })
 

</script>