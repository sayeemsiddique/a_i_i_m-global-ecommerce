@extends('backend.layout.master')

@push('css')
    <style> 
        @media print {
            #inventoryPrint{
                width: 100%;
                height: 100%;
                }
            .visible-print{
                display: block;
                width: auto;
                height: auto;
                overflow: visible;  
            }
        }
        table{ 
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')

    @php
        $filter_product_name = '';
        $filter_category_name = '';

        $productId = $_GET['product_id'] ?? 0;
        $stockType = $_GET['stockType'] ?? 0;

        $stock_types = array(
            [
                'id' => 1,
                'name' => 'Stock In',
                'class' => 'label label-lg font-weight-bold label-success label-inline'
            ],
            [
                'id' => 2,
                'name' => 'Stock Out',
                'class' => 'label label-lg font-weight-bold label-danger label-inline'
            ],
            [
                'id' => 3,
                'name' => 'Stock In',
                'class' => 'label label-lg font-weight-bold label-success label-inline'
                
            ],
            [
                'id' => 4,
                'name' => 'Stock Out',
                'class' => 'label label-lg font-weight-bold label-danger label-inline'
            ],
            [
                'id' => 5,
                'name' => 'Stock Out',
                'class' => 'label label-lg font-weight-bold label-danger label-inline'
            ],
        );
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
                                <h3 class="card-title">Stock Report</h3>
                                <div class="d-flex align-items-center"> 

                                                                
                                    {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                                </div>
                            </div>

                            {{-- Advance filter --}}
                            <div class="form-group card-body mb-0 pb-0 row">
                        
                                <form class="form-inline" method="GET">
                                    <table>
                                        <tr>
                                            <td style="width: 12%;">
                                                <div class="form-group">
                                                    <label class="pr-2 pl-2">From :</label>
                                                    <input class="form-control" type="date" name="fromDate" @if(isset($_GET['fromDate']) and $_GET['fromDate'] != '') value="{{ $_GET['fromDate'] }}" @endif>
                                                </div>
                                            </td>

                                            <td style="width: 12%;">
                                                <div class="form-group">
                                                    <label class="pr-2 pl-2">To :</label>
                                                    <input class="form-control" type="date" name="toDate" @if(isset($_GET['toDate']) and $_GET['toDate'] != '') value="{{ $_GET['toDate'] }}" @endif>
                                                </div>
                                            </td>

                                            <td style="width: 13.5%;">
                                                <div class="form-group">
                                                    <label class="pr-2 pl-2">Product Category : </label>
                                                    <select class="form-control select2" name="category_id" id="category_id">
                                                        <option value="">--Select a Category--</option>

                                                        @foreach ($product_category as $category)
                                                            <option @if(isset($_GET['category_id']) and $_GET['category_id'] == $category->id) selected 
                                                            @php
                                                                $filter_category_name = $category->name;
                                                            @endphp
                                                            @endif value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>

                                            <td style="width: 31%;">
                                                <div class="form-group">
                                                    <label class="pr-2 pl-2">Product : </label>
                                                    <select class="form-control select2" name="product_id" id="product_id">
                                                        <option value="">--Select a Product--</option>

                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}" {{ $productId == $product->id ? 'selected' : '' }}
                                                                @php
                                                                    if ($productId == $product->id) {
                                                                        $filter_product_name = $product->name;
                                                                    }
                                                                @endphp
                                                            >{{ ucfirst($product->name) }} [{{ $product->code }}]</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>

                                            <td style="width: 12%;">
                                                <div class="form-group">
                                                    <label class="pr-2 pl-2">Stock In/Out : </label>
                                                    <select class="form-control" name="stockType">
                                                        <option value="">--Select a value--</option>
                                                        <option value="1" {{ $stockType ==1 ? 'selected' : '' }}>Stock In</option>
                                                        <option value="2" {{ $stockType ==2 ? 'selected' : '' }}>Stock Out</option>
                                                    </select>
                                                </div>
                                            </td>

                                            {{-- <td>
                                                <div class="form-group mt-2">
                                                    <label class="pr-2 pl-2">Order ID :</label>
                                                    <input class="form-control" type="text" name="order_id" value="{{old('order_id')}}" placeholder="Search by Order ID">
                                                </div>
                                            </td> --}}

                                            <td>
                                                <button type="submit" class="btn btn-success ml-2" style="margin-top: 20px;">Show</button>
                                                <a class="btn btn-danger ml-2"style="margin-top: 20px;" href="{{ route('admin.stockReport.stock_in_report_by_product') }}">Reset Search</a>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                </form>
                            </div>
                            {{-- End Filter --}}

                            <div class="card-body" id="inventoryPrint">
                                
                                <div class="table-responsive ajax-data-container pt-3 visible-print">

                                    <div class="title_area">
                                        <h3 class="text-center">{{ $global_setting->sub_title ?? "" }}</h3>
                                        <h4 class="text-center">
                                            {{ $global_setting->address ?? "" }}
                                        </h4>
        
                                        <p class="text-center">
                                            <strong>Stock Report</strong>
                                        </p>
                                        
                                        <p class="text-center">
                                            @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                                                <strong>Date from:</strong> {{ date_format(date_create($_GET['fromDate']), 'd-m-Y') }}
                                            @endif

                                            @if (isset($_GET['toDate']) and $_GET['toDate'] !='')
                                                @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                                                    , 
                                                @endif

                                                <strong>Date to:</strong> {{ date_format(date_create($_GET['toDate']), 'd-m-Y') }}
                                            @endif
                                        </p>

                                        @if (isset($_GET['category_id']) and $_GET['category_id'] !='')
                                            <p class="text-center"> <strong>Product Category:</strong> {{ $filter_category_name }}</p>
                                        @endif
                                        
                                        @if (isset($_GET['product_id']) and $_GET['product_id'] !='')
                                            <p class="text-center"> <strong>Product:</strong> {{ $filter_product_name }}</p>
                                        @endif

                                        @if (isset($_GET['stockType']) and $_GET['stockType'] !='')
                                            <p class="text-center"> 
                                                <strong>Stock type:</strong> 
                                                @if($_GET['stockType'] == 1)
                                                    Stock In
                                                @elseif($_GET['stockType'] == 2)
                                                    Stock Out
                                                @endif
                                            </p>
                                        @endif
                                    </div>

                                    <table class="table table-separate table-head-custom table-checkable table-striped" id="TableData">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-left">Product</th>
                                                <th>Product Code</th>
                                                <th>Quantity</th>
                                                <th>Stock In/Out</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if ($order_details->count() > 0)
                                                @php
                                                    $i = 1;
                                                @endphp

                                                @foreach ($order_details as $inventory)
                                                    <tr>
                                                        <td>{{ $i }}</td>

                                                        <td class="text-left">
                                                            {{ $inventory->productInfo->name ?? '' }}
                                                        </td>
                                                        
                                                        <td>{{ $inventory->productInfo->code ?? '' }}</td>
                                    
                                                        <td>{{ number_format($inventory->quantity ?? 0) }}</td>

                                                        <td>
                                                            @foreach ($stock_types as $stock_type)
                                                                @if ($stock_type['id'] == ($inventory->orderInfo->type ?? 0))
                                                                    <strong class="{{$stock_type['class']}}">{{ $stock_type['name'] }}</strong>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                    
                                                        <td>
                                                            @if (isset($inventory->updated_at))
                                                                {{ $inventory->updated_at->format('d-M-Y') }}
                                                            @elseif(isset($inventory->created_at))
                                                                {{ $inventory->created_at->format('d-M-Y') }}
                                                            @else
                                                                'N/A'
                                                            @endif
                                                        </td>
                                    
                                                    {{--<td>
                                                            @if ($order->stage == 1)
                                                                <span class="label label-lg font-weight-bold label-success label-inline">Accepted</span>
                                                            @elseif ($order->stage == 0)
                                                                <span class="label label-lg font-weight-bold label-primary label-inline">Pending</span>
                                                            @elseif ($order->stage == 2)
                                                                <span class="label label-lg font-weight-bold label-danger label-inline">Declined</span>
                                                            @elseif ($order->stage == 3)
                                                                <span class="label label-lg font-weight-bold label-primary label-inline">On Delivery</span>
                                                            @elseif ($order->stage == 4)
                                                                <span class="label label-lg font-weight-bold label-success label-inline">Completed</span>
                                                            @elseif ($order->stage == 5)
                                                                <span class="label label-lg font-weight-bold label-danger label-inline">Canceled</span>
                                                            @else
                                                                <span class="label label-lg font-weight-bold label-warning label-inline">Unknown Status</span>
                                                            @endif
                                    
                                                        </td>
                                    
                                                        <td>৳ {{ $order->grand_total_price ?? 0 }}</td>
                                    
                                                        <td>
                                                            @can('view_order')
                                                                <a href="{{route('admin.order.show', Crypt::encryptString($order->id))}}" class="btn btn-sm btn-clean btn-icon" title="view">
                                                                    <i class="la la-eye"></i>
                                                                </a>
                                                            @endcan
                                    
                                                            @can('delete_order')
                                                                <button class="btn btn-sm btn-clean btn-icon delete" title="Delete" data-id="{{ $order->id }}">
                                                                    <i class="la la-trash"></i>
                                                                </button>
                                                                @if ($order->status == 1)
                                                                    
                                                                    @elseif ($order->status == 0)
                                                                        <button class="btn btn-sm btn-clean btn-icon delete" title="Active" data-id="{{ $order->id }}">
                                                                            <i class="la la-check"></i>
                                                                        </button>
                                                                    @endif
                                                            @endcan
                                                        </td> --}}
                                                    </tr>

                                                    @php
                                                        $i++;
                                                    @endphp
                                                @endforeach
                                            @else
                                                <tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No matching records found</td></tr>
                                            @endif
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th style="text-align: left" colspan="100%">Printed by: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer"> 
                                <button class="btn btn-primary print_media" onclick="exportData()">Export</button>
                                <button class="btn btn-primary print_media" onclick="printDiv('inventoryPrint')">Print</button>
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