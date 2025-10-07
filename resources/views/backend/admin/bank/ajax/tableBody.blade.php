<table class="table table-separate table-head-custom table-checkable table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Bank Name</th>
            <th class="text-left">Branch Name</th>
            <th>Account No.</th>
            <th>Status</th> 
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($banks->count() > 0)
        @php
            $i = (($banks->currentPage() - 1) * $banks->perPage() + 1);
        @endphp
            @foreach ($banks as $bank)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    
                    <td align="left">{{ $bank->name }}</td>
                    <td align="left">{{ $bank->branch_name }} (Routing: {{ $bank->routing_no }})</td>
                    <td>{{ $bank->account_no }}</td>

                    <td>
                        @if ($bank->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @elseif ($bank->status == 0)
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Deactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_bank')
                            <a href="{{route('admin.bank.show', $bank->id)}}" class="btn btn-sm btn-clean btn-icon" title="view">
                                <i class="la la-eye"></i>
                            </a>
                        @endcan
                        
                        @can('edit_bank')
                            <a href="{{route('admin.bank.edit', $bank->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit"></i>
                            </a>
                        @endcan

                        @can('delete_bank')
                            @if ($bank->status == 1)
                                <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $bank->id }}">
                                    <i class="la la-trash"></i>
                                </button>
                            @elseif ($bank->status == 0)
                                <button class="btn btn-sm btn-clean btn-icon delete" title="Active" data-id="{{ $bank->id }}">
                                    <i class="la la-check"></i>
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
    </tbody>
</table>

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.bank.delete", ":id")}}" class="swal2-confirm swal2-styled" title="Confirm">Confirm</a>';
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