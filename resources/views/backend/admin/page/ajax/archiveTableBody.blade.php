<table class="table table-separate table-head-custom table-checkable dataTable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Name</th>
            
            <th>Is Archive</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($pages->count() > 0)
            @php
                $i = (($pages->currentPage() - 1) * $pages->perPage() + 1);
            @endphp
            @foreach ($pages as $page)
            <tr>
                <td>{{$i}}</td>
                <td align="left">
                    
                        {
                        {{$page->title}}
                    
                </td>
                
                
                <td>
                    @if ($page->status == 2)
                            <i title="Archived" data-url="{{route('admin.page.update',$page->id)}}" data-status="{{$page->status}}" data-id="{{$page->id}}"  class="fas fa-check text-success change_status_2" role="button"></i>
                    @else
                            <i title="Make Archive" data-url="{{route('admin.page.update',$page->id)}}" data-status="{{$page->status}}" data-id="{{$page->id}}"  class="fas fa-file-archive text-danger change_status_2" role="button"></i>
                    @endif
                </td>
                <td>
                    @can('view_page')
                        <a href="{{route('admin.page.show', $page->id)}}" class="btn btn-sm btn-clean btn-icon" title="view">
                            <i class="la la-eye"></i>
                        </a>
                    @endcan
                    @can('edit_page')

                        <a href="{{route('admin.page.edit', $page->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                            <i class="la la-edit"></i>
                        </a>
                    @endcan
                    

                    @can('delete_page')
                        @if ($page->status == 1 || $page->status == 0)
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $page->id }}">
                                <i class="la la-trash"></i>
                            </button>
                        @elseif ($page->status == 2)
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Restore" data-id="{{ $page->id }}">
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
            var url =  '<a href="{{route("admin.page.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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
        
        // @can('change_page_status')
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
                            _method: 'PATCH',
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
        
        $(".change_status_2").click(function(e) {
            
            Swal.fire({
                title: 'Are you sure to change status?',
                icon: 'info',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    var data_id = $(this).attr("data-id");
                    var data_status = $(this).attr("data-status");
                    if (data_status==2) {
                        data_status = 0;
                    } else {
                        data_status = 2;
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
                            _method: 'PATCH',
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
        
        {{-- @endcan --}}

    </script>
@endpush