@extends('backend.layout.master')

@push('css')
    <style>
        @media print {
            #stockPrint{
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
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Sales Report</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">Sales Report</a>
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
                            <h3 class="card-title">Sales Report</h3>
                            <div class="d-flex align-items-center">
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0">

                            <form class="form-inline" action="{{ route('admin.salesReport.filter') }}" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" name="fromDate" value="{{old('fromDate') ? old('fromDate') : $fromDate}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" value="{{old('toDate') ? old('toDate') : $toDate}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Category :</label>

                                                <select name="category" class="form-control" id="category">
                                                    <option value="">--Select Category--</option>
                                                    @foreach ($categories as $category)
                                                    <option
                                                     value="{{ $category->id }}" @isset($cate)
                                                         @if ($cate == $category->id)
                                                             selected
                                                         @endif
                                                     @endisset>{{ ucfirst($category->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
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
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" value="{{old('orderId') ? old('orderId') : $orderId}}" name="orderId"  id="orderId" placeholder="Search by Order Id">
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

                        <div class="card-body">

                            <div class="card">
                                {{-- <div class="card-header p-3">
                                    <h5 class="text-center">@isset($cate)
                                        @php
                                           $ca= App\Models\Category::where('id',$cate)->first();
                                        @endphp
                                        {{ ucfirst($ca->name) }}
                                    @endisset Sales {{ date('Y') }}</h5>
                                </div> --}}
                                <div class="card-body" id="stockPrint">
                                    <div class="table-responsive ajax-data-container pt-3 visible-print" >
                                        <table class="table table-separate table-head-custom table-bordered" id="TableData">
                                            <thead>
                                                <th colspan="7"></th>
                                                <th>
                                                    @isset($cate)

                                                        @if (!empty($cate))
                                                        @php
                                                            $ca= App\Models\Category::where('id',$cate)->first();
                                                        @endphp
                                                     {{ ucfirst($ca->name) }} Sales Report {{ date('Y') }}
                                                        @else
                                                        Sales Report {{ date('Y') }}
                                                        @endif


                                                     @endisset
                                                </th>
                                                <th colspan="7"></th>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Customer Name</th>
                                                    <th>Order Id</th>
                                                    {{-- <th>Invoice Id</th> --}}
                                                    <th>Date</th>
                                                    <th>Product Price</th>
                                                    <th>VAT</th>
                                                    <th>Other</th>
                                                    <th>Packing</th>
                                                    <th>Gross Sales</th>
                                                    <th>Commission</th>
                                                    <th>Carrying Cost</th>
                                                    <th>TDS on Commission</th>
                                                    <th>VDS on Commission</th>
                                                    <th>Net Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $packing = 0;
                                                        $TotalsalesGross = 0;
                                                        $salePrice = 0;
                                                        $totalSalePrice = 0;
                                                        $carringcost = 0;
                                                        $tds = 0;
                                                        $vds = 0;

                                                        $factoryPrice = 0;
                                                        $vat = 0;
                                                        $fitting =0;
                                                        $discount =0;
                                                @endphp
                                                @if ($orders->count() > 0)
                                                    @php
                                                        $i = 1;

                                                    @endphp
                                                    @foreach ($orders as $order)
                                                        <tr>
                                                            <td>{{$i}}</td>
                                                            <td>{{$order->user ? $order->user->first_name.' '.$order->user->last_name : ''}}</td>
                                                            <td>{{$order->tracking_code ?? 'N/A'}}</td>
                                                            {{-- <td>{{$order->invoice_no ?? 'N/A'}}</td> --}}
                                                            <td>{{$order->created_at->format('d-M-Y')}}</td>

                                                            <td>{{ $order->orderDetail ? $order->orderDetail->f_price : '0.00' }}</td>

                                                            <td>{{ $order->orderDetail ? $order->orderDetail->vat_total : '0.00' }}</td>
                                                            <td>{{  $order->other_charge ? number_format($order->other_charge,2) : '0.00' }}</td>
                                                            <td>{{  $order->packing_amount ? number_format($order->packing_amount,2) : '0.00' }}</td>
                                                            <td>
                                                                @if ($order->orderDetail )
                                                                @php
                                                                    $salesGross = ($order->orderDetail->f_price ?? 0) + ($order->orderDetail->vat_total ?? 0) + ($order->packing_amount ?? 0);
                                                                @endphp

                                                                {{ number_format($salesGross, 2) }}

                                                                @endif
                                                            </td>
                                                            <td>{{  number_format($order->discount_amount,2)}}</td>
                                                            <td>{{ number_format($order->courier_cost,2) }}</td>
                                                            <td>{{ number_format($order->tds_amount,2) }}</td>
                                                            <td>{{ number_format($order->vds_amount,2) }}</td>

                                                            <td>{{$salePrice = $order->grand_total_price ?? 0}}</td>
                                                        </tr>

                                                        @php
                                                            $i++;
                                                            if($order->orderDetail)
                                                            {
                                                                $factoryPrice += $order->orderDetail->f_price;
                                                                $vat += $order->orderDetail->vat_total;
                                                            }
                                                            $fitting += $order->other_charge;
                                                            $discount += $order->discount_amount;
                                                            $packing += $order->packing_amount;
                                                            $totalSalePrice += $salePrice;
                                                            $TotalsalesGross += $salesGross;
                                                            $carringcost += number_format($order->courier_cost,2);
                                                            $tds += number_format($order->tds_amount,2);
                                                            $vds +=number_format($order->vds_amount,2);
                                                        @endphp
                                                    @endforeach
                                                @else
                                                    <tr class="odd"><td valign="top" colspan="12" class="dataTables_empty text-red">No matching records found</td></tr>
                                                @endif
                                            </tbody>

                                            <tfoot>
                                                <tr class="bg-light-success">
                                                    <td></td>
                                                    {{-- <td></td> --}}
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>Total</b></td>

                                                    <td><b>{{ number_format($factoryPrice ?? '0.00',2,'.','') }}</b> </td>
                                                    <td><b>{{ number_format($vat ?? '0.00',2,'.','') }}</b> </td>
                                                    <td><b>{{ number_format($fitting,2) }}</b></td>
                                                    <td><b>{{ number_format($packing,2) }}</b> </td>
                                                    <td><b>{{ number_format($TotalsalesGross ?? '0.00',2,'.','') }}</b> </td>
                                                    <td><b>{{ number_format($discount,2) }}</b></td>
                                                    <td><b>{{ number_format($carringcost,2) }}</b> </td>
                                                    <td><b>{{ number_format($tds,2) }}</b> </td>
                                                    <td><b>{{ number_format($vds,2) }}</b> </td>
                                                    <td><b>{{ number_format($totalSalePrice ?? '0.00',2,'.','') }}</b></td>
                                                </tr>
                                            </tfoot>

                                        </table>


                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-primary print_media" onclick="exportData()">Export</button>
                                    <button class="btn btn-primary print_media" onclick="printDiv('stockPrint')">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



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

{{-- <tbody>
    @if ($orders->count() > 0)
        @php
            $i = 1;
            $quantity = 0;
            $totalQuantity = 0;
            $price = 0;
            $subPrice = 0;
            $totalPrice = 0;
        @endphp
        @foreach ($orders as $order)
            @php
                foreach ($order->orderDetails as $uff) {
                    $products = App\Models\Product::where('id', $uff->product_id)->get();
                }
            @endphp
            @foreach ($products as $product)
                <tr>
                    <td>{{$i}}</td>
                    <td class="text-left">
                        <img width="80px" src="{{asset('storage/product/'.$product->image ?? '')}}" alt="{{$product->name ?? ''}}">
                        <span>{{$product->name ?? 'N/A'}}</span>
                    </td>
                    <td>{{$product->code ?? 'N/A'}}</td>
                    <td>{{$order->tracking_code ?? 'N/A'}}</td>
                    <td>{{$quantity = $order->quantity ?? 0}}</td>
                    <td>{{$price = $order->price ?? 0}}</td>
                    <td>{{$subPrice = $quantity * $price }}</td>
                    <td>{{$order->created_at->format('d-M-Y')}}</td>
                </tr>
                @php
                    $totalPrice += $subPrice;
                    $totalQuantity += $quantity;
                @endphp
            @endforeach
            @php
                $i++;
            @endphp
        @endforeach
    @else
        <tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">No matching records found</td></tr>
    @endif
</tbody> --}}
