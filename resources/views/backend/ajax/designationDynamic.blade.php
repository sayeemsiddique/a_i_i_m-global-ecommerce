<script>
    // $("#office_id").on('change',function(e){
    //     e.preventDefault();
    //     var district_list = $("#designation_id");
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     $.ajax({
    //         type: 'POST',
    //         url: "{{route('designations')}}",
    //         data: {_token:$('input[name=_token]').val(),
    //         office_id: $(this).val()},

    //         success:function(response){
    //             $('option', district_list).remove();
    //             $('#designation_id').append('<option label="Label" value="">--Select Designation--</option>');
    //             $.each(response, function(){
    //                 $('<option/>', {
    //                     'value': this.id,
    //                     'text': this.name
    //                 }).appendTo('#designation_id');
    //             });
    //         }

    //     });
    // });

</script>