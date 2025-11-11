@extends('backend.layout.master')

@section('content')
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
                            <h3 class="card-title">Edit Assigned Permissions &nbsp; <span class="badge badge-info">Role: {{$role_info->name ?? ''}}</span></h3>

                        </div>
                        <div class="card-body">
                            <form class="form" action="{{route('admin.rolePermission.update',$role_info->id)}}" method="post" id="kt_form_1">
                                @csrf

                                <div class="card-body">
                                    <div class="alert alert-custom alert-light-danger d-none" role="alert" id="kt_form_1_msg">

                                    </div>
                                    <input type="hidden" name="role" value="{{$role_info->id}}">

                                    <div class="form-group row">

                                       <div class="col-md-4">
                                            <div class="row d-none">
                                                <label class="col-form-label text-right col-lg-2 col-sm-12">Role <span style="color: red;">*</span> </label>
                                                <div class="col-lg-8 col-md-8 col-sm-12">
                                                    <select class="form-control" name="role" disabled>

                                                        @foreach ($roles as $role)
                                                            <option value="{{$role->id}}" @if($role_info->id == $role->id) selected @endif>{{$role->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                       </div>
                                       <div class="col-md-12">
                                            <div class="radio-inline ml-5">
                                                <label class="radio radio-square">
                                                    <input type="checkbox" id="all-checked"  name="all-checked"/>
                                                    <span></span>
                                                    Permissions <p style="color: red;" class="pt-2">*</p>
                                                </label>
                                            </div>

                                            <div class="row">

                                                @foreach ($permissions as $permission)
                                                    <div class="col-md-4">

                                                        <div class="radio-inline ml-5">
                                                            <label class="radio radio-square">
                                                                <input type="checkbox" value="{{$permission->id}}" @if(in_array($permission->id,$perms)) checked @endif name="permission[]"/>
                                                                <span></span>

                                                                {{$permission->name_en}}
                                                            </label>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            </div>
                                       </div>
                                    </div>



                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-10 text-right">
                                            <button type="submit" class="btn btn-primary font-weight-bold" name="submitButton">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('stackScript')
    <script>
        $( document ).ready(function() {
            $('#all-checked').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            }
            else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
            });
        });
    </script>
@endpush

