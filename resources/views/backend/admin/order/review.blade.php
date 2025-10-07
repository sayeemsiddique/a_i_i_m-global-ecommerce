@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">All Reviews</h3>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive ajax-data-container pt-3">
                                @include('backend.admin.order.ajax.review')                                    
                            </div>

                            {{-- {{ $reviews->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection