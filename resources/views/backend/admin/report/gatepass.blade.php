@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Issue vs Delivered Gatepass</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">Issue vs Delivered Gatepass</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
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
                            <h3 class="card-title">Issue vs Delivered Gatepass</h3>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">
                    
                            <form class="form-inline" action="{{ route('admin.gatepass.report_filter') }}" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From: </label>
                                                <input class="form-control" type="date" name="fromDate" @if(isset($_GET['fromDate']) and $_GET['fromDate'] !='') value="{{$_GET['fromDate']}}" @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To: </label>
                                                <input class="form-control" type="date" name="toDate" @if(isset($_GET['toDate']) and $_GET['toDate'] !='') value="{{$_GET['toDate']}}" @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Order ID: </label>
                                                <input class="form-control" type="text" name="order_id" @if(isset($_GET['order_id']) and $_GET['order_id'] !='') value="{{$_GET['order_id']}}" @endif placeholder="Search by Order ID">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Status: </label>
                                                <select class="form-control" name="status" id="status">
                                                    <option value="">--Select a Status--</option>
                                                    <option @if(isset($_GET['status']) and $_GET['status'] ==1) selected @endif value="1">Issued</option>
                                                    <option @if(isset($_GET['status']) and $_GET['status'] ==3) selected @endif value="3">Delivered</option>
                                                </select>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <button type="submit" class="btn btn-success ml-2">Search</button>
                                        </td>
                                    </tr>
                                </table>
                                
                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body" id="stockPrint">
                            
                            <div class="table-responsive ajax-data-container pt-3">
                                <div class="title_area">
                                    <h3 class="text-center">{{$global_setting->sub_title ?? ""}}</h3>
                                    <h4 class="text-center">
                                        {{$global_setting->address ?? ""}}
                                    </h4>
    
                                    <p class="text-center">
                                        <strong>Issue vs Delivered Gatepass Report</strong>
                                    </p>
                                    
                                    <p class="text-center">
                                        @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                                            <strong>Date from:</strong> {{date_format(date_create($_GET['fromDate']), 'd-m-Y')}}
                                        @endif
                                        @if (isset($_GET['toDate']) and $_GET['toDate'] !='')
                                            @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                                                , 
                                            @endif
                                            <strong>Date to:</strong> {{date_format(date_create($_GET['toDate']), 'd-m-Y')}}
                                        @endif
                                    </p>

                                    @if(isset($_GET['order_id']) and $_GET['order_id'] !='')
                                        <p class="text-center">
                                            <strong>Order ID:</strong> {{$_GET['order_id']}}
                                        </p>
                                    @endif
                                    
                                    @if(isset($_GET['status']) and $_GET['status'] !='')
                                        <p class="text-center">
                                            <strong>Status:</strong> 
                                            @if ($_GET['status'] == 1)
                                                Issued
                                            @elseif($_GET['status'] == 3)
                                                Delivered
                                            @endif
                                        </p>
                                    @endif
                                    
                                    
                                    
                                </div>
                                @include('backend.admin.report.ajax.gatepass')                                    
                            </div>
                        </div>
                        <div class="card-footer"> 
                            {{-- <button class="btn btn-primary print_media" onclick="exportData()">Export</button> --}}
                            <button class="btn btn-primary print_media" onclick="printDiv('stockPrint')">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
    tfoot { display: table-footer-group; }
}
@media screen {
    tfoot { display: none; }
}
</style>
    
@endsection

@push('stackScript')
    {{-- <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.order.delete", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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
    </script> --}}

    <script>
        function exportData(){
            var table2excel = new Table2Excel();
            table2excel.export(document.querySelectorAll("#TableData"));
        }
    </script>

    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

@endpush