<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Vat Name</th>
            <th class="text-left">Value</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($vats->count() > 0)
        @php
            $i = (($vats->currentPage() - 1) * $vats->perPage() + 1);
        @endphp
            @foreach ($vats as $vat)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td align="left">
                        {{$vat->name}}
                    </td>
                    
                    <td align="left">
                        {{$vat->value}} @if ($vat->type == 1) % @else Flat rate @endif
                    </td>

                    <td>
                        @if ($vat->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @else
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_vat_type')
                            <a href="{{route('admin.vat.show', $vat->id)}}" class="btn btn-sm btn-clean btn-icon" title="View">
                                <i class="la la-eye"></i>
                            </a>
                        @endcan
                        
                        @can('edit_vat_type')
                            {{-- <a href="{{route('admin.vat.edit', $vat->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit"></i>
                            </a> --}}
                            <button title="Edit" type="button" class="btn btn-sm btn-clean btn-icon" data-toggle="modal" data-target="#vat_edit{{$vat->id}}">
                                <i class="la la-edit"></i>
                            </button>

                            <!-- The Modal -->
                            <div class="modal" id="vat_edit{{$vat->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                        <h4 class="modal-title">Edit Vat Type</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                
                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form class="text-left" action="{{route('admin.vat.update', $vat->id)}}" method="post">
                                                @csrf
                                                <input type="hidden" name="status" value="1">
                                                <div class="form-group">
                                                    <label for="name">Name: <small class="text-danger">*</small></label>
                                                    <input name="name" type="text" class="form-control" placeholder="Enter name" id="name" required value="{{$vat->name}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="name">Type: <small class="text-danger">*</small></label>
                                                    <select class="form-control" id="sel1" name="type" required>
                                                        <option value="">Select</option>
                                                        <option @if($vat->id == 1) selected @endif value="1">Percent</option>
                                                        <option @if($vat->id == 2) selected @endif value="2">Flat Rate</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name">Rate Value: <small class="text-danger">*</small></label>
                                                    <input name="value" type="number" class="form-control" placeholder="Enter rate value" id="value" required value="{{$vat->value}}">
                                                </div>

                                                <div class="form-group">
                                                    <label for="name">Status:</label>
                                                    <select class="form-control" id="sel1" name="status" required>
                                                        <option @if($vat->status == 1) selected @endif value="1">Active</option>
                                                        <option @if($vat->status != 1) selected @endif value="0">Inactive</option>
                                                    </select>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        </div>
                                
                                    </div>
                                </div>
                            </div>
                              
                        @endcan

                        @can('delete_vat_type')
                            
                            <button class="btn btn-sm btn-clean btn-icon delete" title="Inactive" data-id="{{ $vat->id }}">
                                    <i class="la la-trash"></i>
                            </button>
                            
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
    </tbody>
</table>

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.vat.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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