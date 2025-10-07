{{-- Initialize Plugins --}}
<script>
    $(document).on('click', '.ajax-pagination-area .pagination li a', function(e) {
        e.preventDefault();

        var url = $(this).attr('href');
        
        $.ajax({
            url: url,
            type: 'GET',
            cache: false,
            dataType: 'json',
            success: function(response)
            {
                $(".ajax-data-container").empty().append(response.page);
            },
            error: function(){}
        });

    });
    
    $(document).ready(function() {

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
            };
        });


        $(document).on("keyup", ".ajax-data-search", function(e){
            
            e.preventDefault();
            
            var that = $( this );
            var q = e.target.value;
            var url = that.attr("data-url");
            var urls = url+'?q='+q;
            
            $.ajax({
                url: urls,
                type: 'GET',
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    $(".ajax-data-container").empty().append(response.page);
                },
                error: function(){}
            });
        });

        $(document).on("change", ".ajax-data-search", function(e){
            
            e.preventDefault();
            
            var that = $( this );
            var q = $(this).val();
            var url = that.attr("data-select");
            var urls = url+'?q='+q;
            
            $.ajax({
                url: urls,
                type: 'GET',
                cache: false,
                dataType: 'json',
                success: function(response)
                {
                    $(".ajax-data-container").empty().append(response.page);
                },
                error: function(){}
            });
        });
    });
</script>
