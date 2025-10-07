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
                                <h3 class="card-title">Edit Template</h3>

                                <div class="card-toolbar">
                                    <a href="{{url()->previous()}}" class="btn btn-primary btn-xsm mr-2">Back</a>
                                    
                                </div>
                                
                            </div>
                            <form action="{{ route('admin.setting.updateTemplate',$template)}}" method="post" >
                                <div class="card-body">
                                    @csrf
                                    

                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Header <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <textarea name="header" class="form-control summernote"  rows="10">{!! $template->header !!}</textarea>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Footer <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <textarea name="footer" class="form-control summernote"  rows="10">{!! $template->footer !!}</textarea>
                                            
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row">
                                        <label class="col-form-label col-lg-3 col-sm-12 text-right">Body <span style="color: red;">*</span></label>
                                        <div class="col-lg-8 col-md-8 col-sm-12">
                                            <textarea name="body" class="form-control summernote"  rows="10">{{$template->body}}</textarea>
                                            
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-9 ml-lg-auto">
                                            <button type="submit" class="btn btn-primary mr-2">Update</button>
                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
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
@push('stackScript')
<script src="assets/js/pages/crud/forms/editors/summernote.js"></script>
    <script>
        $(document).ready(function() {
			$('.summernote').summernote({
				height: 200,
			});
		});


        // $(document).ready(function() {
        //     $("#service").change(function() {
        //         var type = this.value;
        //         // $(".single-trip").show();
        //         // $(".round-trip-form").show();
                
        //         if(type == 'certificate')
        //         {
        //             $("#service_type_other").hide();
        //             $("#service_type_certificate").show();
        //             $("#service_item_type_certificate").show();
                    

        //         }
        //         else if(type == 'other')
        //         {
        //             $("#service_type_certificate").hide();
        //             $("#service_item_type_certificate").hide();

        //             $("#service_type_other").show();
        //         }
                

        //     });
        // });
        
    </script>
@endpush