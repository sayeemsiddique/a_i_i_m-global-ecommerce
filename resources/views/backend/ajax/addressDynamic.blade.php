<script>
    $("#division_id").on('change',function(e){
        e.preventDefault();
        var district_list = $("#district_id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            {{-- url: "{{route('districts')}}", --}}
            url: "#",
            data: {_token:$('input[name=_token]').val(),
            division_id: $(this).val()},

            success:function(response){
                $('option', district_list).remove();
                $('#district_id').append('<option label="Label" value="">--Select District--</option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.name
                    }).appendTo('#district_id');
                });
            }

        });
    });

    $("#district_id").on('change',function(e){
        e.preventDefault();
        var area_list = $("#upazila_id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url: "{{route('upazilas')}}",
            data: {_token:$('input[name=_token]').val(),
            district_id: $(this).val()},

            success:function(response){
                $('option', area_list).remove();
                $('#upazila_id').append('<option label="Label" value="">--Select Upazila--</option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.name
                    }).appendTo('#upazila_id');
                });
            }
        });
    });

    $("#upazila_id").on('change',function(e){
        e.preventDefault();
        var area_list = $("#office_id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url: "{{route('offices')}}",
            data: {_token:$('input[name=_token]').val(),
            upazila_id: $(this).val()},

            success:function(response){
                $('option', area_list).remove();
                $('#office_id').append('<option label="Label">--Select Office--</option>');
                $.each(response, function(){
                    $('<option/>', {
                        'value': this.id,
                        'text': this.title
                    }).appendTo('#office_id');
                });
            }
        });
    });

    // $("#level_id").on('change', function(e){
    //     e.preventDefault();

    //     var designation_list = $("#designation_id");
        
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });

    //     $.ajax({
    //         type:'POST',
    //         url: "{{route('designations')}}",
    //         data: {_token:$('input[name=_token]').val(),
    //         level_id: $(this).val()},

    //         success:function(response){
    //             $('option', designation_list).remove();
    //             $('#designation_id').append('<option value="">--Select Designation--</option>');

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