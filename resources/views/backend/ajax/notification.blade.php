<script>

function notificationMarkAsRead(id)
{
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // }); 

    $.ajax({
        type: 'POST',
        url: "{{ route('notification_read') }}",
        data: {_token:$('input[name=_token]').val(),
                id: id},

        success: function (response) {
            Swal.fire({
                title: 'Notification have been marked read!',
                icon: 'success',
            });

            setTimeout(function(){
                window.location.reload(1);
            }, 1000);
        }
    });
}

</script>