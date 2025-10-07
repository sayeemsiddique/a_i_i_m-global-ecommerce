<script>
    $('.step2-select').select2({

        ajax: {
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                // alert(data[0].s);
                var data = $.map(data, function (obj) {
                    obj.id = obj.id || obj.id;
                    return obj;
                });
                var data = $.map(data, function (obj) {
                    
                    obj.text = obj.first_name+' '+obj.last_name+' ('+obj.mobile+')';
                    return obj;
                });
                return {
                    results: data,
                    pagination: {
                    more: (params.page * 30) < data.total_count
                    }
                };
            }
        },
    });
    
</script>