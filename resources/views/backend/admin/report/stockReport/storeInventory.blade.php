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

    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Store Inventory</h3>
                            <div class="d-flex align-items-center">
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0">

                            <form class="form-inline" action="{{ route('admin.stockReport.filter') }}" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" name="fromDate" value="{{old('fromDate')}}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" value="{{old('toDate')}}">
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

                            <div class="table-responsive ajax-data-container pt-3 visible-print">
                                <table class="table table-bordered table-striped" id="TableData">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">Product</th>
                                            <th>Product Code</th>
                                            <th>Quantity (Pcs)</th>
                                            <th>Weight (KG)</th>
                                            <th>Total Weight (KG)</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Last Update</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($products->count() > 0)
                                            @php
                                                $i = 1;
                                                $quantity = 0;
                                                $weight = 0;
                                                $totalQuantity = 0;
                                                $subWeight = 0;
                                                $totalWeight = 0;
                                                $price = 0;
                                                $subPrice = 0;
                                                $totalPrice = 0;
                                            @endphp
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{$i}}</td>

                                                    <td class="text-left">
                                                        <img width="80px" src="{{asset('storage/product/'.$product->image ?? '')}}" alt="{{$product->name ?? ''}}">
                                                        <span>{{$product ? $product->name : 'N/A'}}</span>
                                                    </td>

                                                    <td>{{$product->code ?? 'N/A'}}</td>

                                                    <td>{{ $quantity = number_format($product->quantity) ?? 0 }}</td>

                                                    <td>{{ $weight = $product->weight ?? 0 }}</td>

                                                    <td>
                                                        @if ($product->unit == 1)
                                                            {{ $subWeight = $quantity * $weight }}
                                                        @elseif($product->unit == 2)
                                                            {{ $subWeight = $quantity * ($weight * 1000) }}
                                                        @else
                                                            {{ $subWeight = $quantity * $weight }}
                                                        @endif
                                                    </td>

                                                    <td>{{$price = $product->discount_price ?? 0}}</td>

                                                    <td>{{$subPrice = $quantity * $price}}</td>

                                                    <td>
                                                        @if (isset($product->stock->updated_at))
                                                            {{ $product->stock->updated_at->format('d-M-Y') }}
                                                        @elseif(isset($product->stock->created_at))
                                                            {{ $product->stock->created_at->format('d-M-Y') }}
                                                        @else
                                                            'N/A'
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                    $totalQuantity += $quantity;
                                                    $totalWeight += $subWeight;
                                                    $totalPrice += $subPrice;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr class="odd">
                                                <td valign="top" colspan="9" class="dataTables_empty">No matching records found</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot class="bg-light-success">
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th>{{ number_format($totalQuantity) ?? 0 }} (PCS)</th>
                                        <th></th>
                                        <th>{{($totalWeight ?? 0) / 1000}} (M.T)</th>
                                        <th></th>
                                        <th>{{$totalPrice ?? 0}} (TK)</th>
                                        <th></th>
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
