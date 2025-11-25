@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                @include('alerts.alerts')
                <!--begin::Card-->
                <div class="row">
                    <div class="col-lg-12">
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <div class="card-header">
                                <h3 class="card-title">Assessment Template List</h3>
                                <div class="d-flex align-items-center">
                                    <div class="row">
                                        <div>
                                            <a href="{{route('admin.setting.addAssessmentTemplate')}}" class="btn btn-light-primary pb-4"> <i class="fa fa-plus"></i> Add New Template</a>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ajax-data-container pt-3">
                                    <table class="table table-bordered table-striped" >
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Header</th>
                                                <th class="text-left">footer</th>
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
                                                            {{$template->name}}
                                                        </td>
                                                        <td align="left">
                                                            {!!$template->header!!} 
                                                            
                                                        </td>
                                                        <td align="left">
                                                            {!!$template->footer!!} 
                                                        </td>
                                                        
                                                        <td>
                                                            @if ($template->status == 1)
                                                                <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                                                            @else
                                                                <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                                
                                                            <a href="{{route('admin.setting.editAssessmentTemplate',$template->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit">
                                                                <i class="la la-edit text-warning"></i>
                                                            </a>
                                                
                                                            <button  class="btn btn-sm btn-clean btn-icon" data-toggle="modal" data-target="#deleteTemplate{{$template->id}}">                                                         
                                                                <i class="la la-trash text-danger"></i>
                                                            </button>
                                                            
                                                            {{-- delete modal --}}
                                                            <div id="deleteTemplate{{$template->id}}" class="modal fade" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header py-5">
                                                                            <h5 class="modal-title">Confirmation</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                                            </button>
                                                                        </div>
                                                                        <form class="form" action="{{route('admin.setting.deleteAssessmentTemplate',$template->id)}}" method="post">
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <div class="container">
                                                                                    Do you want to delete the assessment template ?
                                                                                </div>          
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
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
                                </div>
                                {{$templates->links()}}
                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
</div>



@endsection