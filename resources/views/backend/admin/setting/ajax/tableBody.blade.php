<table class="table table-separate table-head-custom table-checkable table-striped" >
    <thead>
        <tr>
            <th>#</th>
            
            <th class="text-left">Type</th>
            {{-- <th class="text-left">Body</th> --}}
            {{-- <th class="text-left">footer</th> --}}
            <th>Status</th>
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
                        {{ $i }}
                    </td>

                    <td align="left">
                        @if ($template->type=='sms')
                            SMS
                        @else 
                        Email
                        @endif
                        
                    </td>
                    
                    {{-- <td align="left">
                        {!!$template->header!!} 
                        
                    </td>

                    <td align="left">
                        {!!$template->body!!} 
                        
                    </td>
                    <td align="left"> 
                        {!!$template->footer!!} 
                        
                    </td> --}}
                    
                    <td>
                        @if ($template->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @else
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('admin.setting.showTemp',$template)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                            <i class="la la-eye text-warning"></i>
                        </a>
                        @can('edit_template')
                            
                            <a href="{{route('admin.setting.editTemplate',$template)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                <i class="la la-edit text-warning"></i>
                            </a>
                        @endcan
                        @can('status_template')
                            
                            @if ($template->status == true)
                                
                            <button  class="btn btn-sm btn-clean btn-icon" data-toggle="modal" data-target="#deleteApplicationPurpost{{$template->id}}">                                                         
                                <i class="la la-trash text-danger"></i>
                            </button>
                            @else
                            <button  class="btn btn-sm btn-clean btn-icon" data-toggle="modal" data-target="#deleteApplicationPurpost{{$template->id}}">                                                         
                                
                                <i class="la la-check-circle text-success la-2x"></i>
                            </button>
                            @endif
                        @endcan
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
                                    <form class="form" action="{{route('admin.setting.destroy',$template)}}" method="post">
                                        <div class="modal-body">
                                                @csrf
                                                <div class="container">
                                                    Do you want to {{$template->status == true ? 'disable' : 'enable'}} Template ?
                                                </div>                    
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-sm {{$template->status == true ? 'btn-danger' : 'btn-primary'}} " type="submit">{{$template->status == true ? 'Disable' : 'Enable'}}</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @php $i++; @endphp

            @endforeach
        @else
            <tr class="odd"><td valign="top" colspan="11" class="dataTables_empty">No matching records found</td></tr>
        @endif
    </tbody>
</table>