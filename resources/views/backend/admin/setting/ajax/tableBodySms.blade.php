<table class="table table-separate table-head-custom table-checkable table-striped" >
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Type</th>
            <th class="text-left">Title</th>
            <th class="text-left">Subject</th>
            <th class="text-left">Details</th>
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($templates->count() > 0)
        @php                
            $i = (($templates->currentPage() - 1) * $templates->perPage() + 1); 
        @endphp
            @foreach ($templates as $template)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td align="left">
                        {{$template->type == 1 ? "Email": 'SMS'}}
                    </td>
                    <td align="left">
                        {!!$template->title!!} 
                        
                    </td>

                    <td align="left">
                        {!!$template->subject!!} 
                        
                    </td>
                    <td align="left">
                        {!!$template->details!!} 
                        
                    </td>
                    
                    
                    <td>
                        {{-- @can('edit_sms_template') --}}
                            
                            <a href="{{route('admin.setting.editSmsTemplate',$template)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit text-warning"></i>
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('delete_sms_template') --}}
                            @if ($template->status == false)
                                
                            <button  class="btn btn-sm btn-clean btn-icon" data-toggle="modal" data-target="#deleteApplicationPurpost{{$template->id}}">                                                         
                                <i class="la la-trash text-danger"></i>
                            </button>
                            
                            @endif
                        {{-- @endcan --}}
                        
                        {{-- delete modal --}}
                        <div id="deleteApplicationPurpost{{$template->id}}" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header py-5">
                                        <h5 class="modal-title">{{$template->status == true ? 'Disable' : 'Enable'}} Template
                                        <span class="d-block text-muted font-size-sm"></span></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <form class="form" action="{{route('admin.setting.smsDestroy',$template)}}" method="post">
                                        <div class="modal-body">
                                                @csrf
                                                <div class="container">
                                                    Do you want to Delete Template ?
                                                </div>                    
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-sm {{$template->status == true ? 'btn-danger' : 'btn-primary'}} " type="submit">Delete</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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