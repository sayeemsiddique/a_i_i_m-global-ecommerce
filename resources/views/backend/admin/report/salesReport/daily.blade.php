@extends('backend.layout.master')

@push('css')
    <style> 
        @media print {
            @page {
                size: A4 landscape;
                margin:0;
            }
            ::-webkit-scrollbar {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
@php
    $filter_category_name = '';
@endphp
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">

                        <div class="card-header">
                            <h3 class="card-title">Daily Sales Report</h3>
                            <div class="d-flex align-items-center">             
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">
                    
                            <form class="form-inline" method="GET">
                                <style>
                                    table{ 
                                        white-space: nowrap;
                                    }
                                </style>
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Select Date :</label>
                                                <input class="form-control" type="date" name="fromDate" @if (isset($_GET['fromDate']) and $_GET['fromDate']!='')
                                                value="{{$_GET['fromDate']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" @if (isset($_GET['toDate']) and $_GET['toDate']!='')
                                                value="{{$_GET['toDate']}}"
                                            @endif>
                                            </div>
                                        </td> --}}
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Category :</label>
                                                
                                                <select name="category" class="form-control" id="category">
                                                    <option value="">--Select Category--</option>
                                                    @foreach ($categories as $category)
                                                    <option @if (isset($_GET['category']) and $_GET['category']== $category->id)
                                                    selected
                                                    @php
                                                        $filter_category_name = $category->name;
                                                    @endphp
                                                @endif value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                                        
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td> --}}
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Product</label>
                                                <select class="form-control select2" name="product_id" id="product_id">
                                                    <option value="">--Select a Product--</option>
                                                    @foreach ($product_datas as $product)
                                                        <option @if(isset($_GET['product_id']) and $_GET['product_id'] == $product->id) selected @endif value="{{ $product->id }}">{{ ucfirst($product->name) }} [{{ $product->code }}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td> --}}
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" name="orderId"  id="orderId" placeholder="Search by Order Id" @if (isset($_GET['orderId']) and $_GET['orderId']!='')
                                                value="{{$_GET['orderId']}}"
                                            @endif>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <button type="submit" class="btn btn-success ml-2">Search</button>
                                            {{-- <a class="btn btn-danger ml-2" href="{{route('admin.salesReport.index')}}">Reset Search</a> --}}
                                        </td>
                                        
                                    </tr>
                                </table>
                                
                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">
                            @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                            <div class="table-responsive ajax-data-container pt-3" id="stockPrint">
                                {{-- <p>Total Completed Orders: {{count($orders)}}</p> --}}
                                
                                <div class="title_area">
                                    <h3 class="text-center">{{$global_setting->sub_title ?? ""}}</h3>
                                    <h4 class="text-center">
                                        {{$global_setting->address ?? ""}}
                                    </h4>
    
                                    <p class="text-center">
                                        <strong>Daily Sales Report</strong>
                                    </p>
                                    
                                    <p class="text-center">
                                        @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                                            <strong>Sales Report of -</strong> {{date_format(date_create($_GET['fromDate']), 'd-m-Y')}}
                                        @endif
                                        
                                    </p>
                                </div>
                                
                                    <table class="table table-separate table-head-custom table-bordered" id="TableData">
                                        <thead> 
                                                                                                
                                            <tr>
                                                <th>SL No.</th>
                                                <th>Category Name</th>
                                                <th>Today's Actual Sales (M.T)</th>
                                                <th>Comulative sales of the month (M.T)</th>
                                                <th>Comulative sales of the Year (M.T)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @if ($categories->count() > 0)
                                                
                                                @foreach ($categories as $key => $category)
                                                    <tr>
                                                        <td>{{++$key}}</td>
                                                        <td>{{$category->name}}</td>
                                                        <td>{{number_format(($category->today_sale/1000),4,'.','')}}</td>
                                                        <td>{{number_format(($category->monthly_sale/1000),4,'.','')}}</td>
                                                        <td>{{number_format(($category->yearly_sale/1000),4,'.','')}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="odd"><td valign="top" colspan="100%" class="dataTables_empty">No matching records found</td></tr>
                                            @endif
                                            <tr class="bg-light-success">
                                                <th colspan="2">Total</th>
                                                <th>{{number_format(($categories->sum('today_sale')/1000),4,'.','')}}</th>
                                                <th>{{number_format(($categories->sum('monthly_sale')/1000),4,'.','')}}</th>
                                                <th>{{number_format(($categories->sum('yearly_sale')/1000),4,'.','')}}</th>
                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <th style="text-align: left" colspan="100%">Printed by: {{auth()->user()->first_name}} {{auth()->user()->last_name}}</th>
                                        </tfoot>
                                        
                                    </table>
                                    
                                
                                
                                
                            </div>
                            <button class="btn btn-primary print_media" onclick="exportData()">Export</button>
                            <button class="btn btn-primary print_media" onclick="printDiv('stockPrint')">Print</button>
                            @endif
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