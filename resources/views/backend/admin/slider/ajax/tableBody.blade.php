<table class="table table-separate table-head-custom table-checkable dataTable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Serial No</th>
            <th class="text-left">Title</th>
            <th class="text-left">Sub Title</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($sliders->count() > 0)
            @php
                $i = (($sliders->currentPage() - 1) * $sliders->perPage() + 1);
            @endphp
            @foreach ($sliders as $slider)
            <tr>
                <td>{{$i}}</td>
                <td align="left">{{$slider->sl}}</td>
                <td align="left">{{$slider->title}}</td>
                <td align="left">{{$slider->sub_title}}</td>
                <td>
                    @if ($slider->status == 1)
                            <i data-url="{{route('admin.slider.update',$slider->id)}}" data-status="{{$slider->status}}" data-id="{{$slider->id}}"  class="fas fa-toggle-on text-success change_status" role="button"></i>
                        
                    @elseif ($slider->status == 0)
                            <i data-url="{{route('admin.slider.update',$slider->id)}}" data-status="{{$slider->status}}" data-id="{{$slider->id}}"  class="fas fa-toggle-off text-default change_status" role="button"></i>
                        
                    @endif
                </td>
                <td>
                    @can('view_slider')
                        
                        <a href="{{route('admin.slider.show', $slider->id)}}" class="btn btn-outline btn-success btn-sm btn-rounded p-1" title="view">
                            <i class="la la-eye p-0 text-white"></i>
                        </a>
                    @endcan
                    @can('edit_slider')

                        <a href="{{route('admin.slider.edit', $slider->id)}}" class="btn btn-outline btn-info btn-sm btn-rounded p-1" title="Edit">
                            <i class="la la-edit p-0 text-white"></i>
                        </a>
                    @endcan
                    

                    @can('delete_slider')
                        @if ($slider->status == 1 || $slider->status == 0)
                            <button class="btn btn-outline btn-danger btn-sm btn-rounded p-1 delete" title="Delete" data-id="{{ $slider->id }}">
                                <i class="la la-trash p-0 text-white"></i>
                            </button>
                        @elseif ($slider->status == 2)
                            <button class="btn btn-outline btn-danger btn-sm btn-rounded p-1 delete" title="Restore" data-id="{{ $slider->id }}">
                                <i class="la la-trash-restore"></i>
                            </button>
                        @endif
                    @endcan
                </td>
            </tr>
            @php
                $i++;
            @endphp
            @endforeach
        @else
            <tr class="odd"><td valign="top" colspan="11" class="dataTables_empty">No matching records found</td></tr>
        @endif

        <input type="hidden" class="token" value="{{ csrf_token() }}">
        
    </tbody>
</table>

@push('stackScript')
    <script> 
        $(".block").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.user.block",":id")}}" class="swal2-confirm swal2-styled" title="Block">Confirm</a>';
            url = url.replace(':id', data_id );
            
            Swal.fire({
                title: 'Are you sure ?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Status Changed Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        });

    </script>

    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.slider.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
            url = url.replace(':id', data_id );
            
            Swal.fire({
                title: 'Are you sure ?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Status Changed Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        });
        
        @can('change_slider_status')
            $(".change_status").click(function(e) {
                
                Swal.fire({
                    title: 'Are you sure to change status?',
                    icon: 'info',
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data_id = $(this).attr("data-id");
                        var data_status = $(this).attr("data-status");
                        if (data_status==1) {
                            data_status = 0;
                        } else {
                            data_status = 1;
                        }
                        var data_url = $(this).attr("data-url");
                        var data_token = $('.token').val();
                        $.ajax({
                            url: data_url,
                            type: "post",
                            data:{
                                id: data_id,
                                status: data_status,
                                _token: data_token,
                                _method: 'POST',
                            },
                            success: function (response) {
                                Swal.fire({
                                    title: 'Status have been changed?',
                                    icon: 'info',
                                });
                                setTimeout(function(){
                                    window.location.reload(1);
                                }, 1000);

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                            // console.log(textStatus, errorThrown);
                            }
                        });
                        
                    } else if (result.dismiss === "cancel") {
                        Swal.fire('Canceled', '', 'error')
                    }
                })
            });
        @endcan

    </script>
@endpush