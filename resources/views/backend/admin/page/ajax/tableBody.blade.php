<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Name</th>
            <th>Status</th>
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


                        {{$page->title}}

                </td>
                <td>
                    @if ($page->status == 1)
                            <i class="fas fa-toggle-on text-success change_status" role="button"></i>
                    @else
                            <i class="fas fa-toggle-off text-default change_status" role="button"></i>

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
                        <a href="{{route('admin.page.delete', $page->id)}}" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-sm btn-clean btn-icon" title="Delete">
                            <i class="la la-trash"></i>
                        </a>
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

<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Api Set Pages</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form action="#" method="post">
                <input type="hidden" class="page_id" name="page_id" value="">
                @csrf
                <div class="form-group">
                    <label for="sel1">Select Page Type:</label>
                    <select name="api_page" class="form-control" id="sel1" required>
                      <option value="">Select</option>
                      <option value="about_us">About Us</option>
                      <option value="contact_us">Contact</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

@push('stackScript')


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
    </script>
@endpush
