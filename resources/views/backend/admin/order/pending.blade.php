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
                            <h3 class="card-title">Pending Orders</h3>
                            <div class="d-flex align-items-center">


                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">

                            <form class="form-inline"  method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control" type="date" name="fromDate" @if (isset($_GET['fromDate']) and $_GET['fromDate'] !='')
                                                value="{{$_GET['fromDate']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control" type="date" name="toDate" @if (isset($_GET['toDate']) and $_GET['toDate'] !='')
                                                value="{{$_GET['toDate']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control" type="text" name="order_id" placeholder="Search by Order ID" @if (isset($_GET['order_id']) and $_GET['order_id'] !='')
                                                value="{{$_GET['order_id']}}"
                                            @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success mt-2 ml-2">Show</button>
                                            <a class="btn btn-danger mt-2 ml-2" href="{{route('admin.order.pending_list')}}">Reset Search</a>
                                        </td>

                                    </tr>
                                </table>

                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">

                            <div class="table-responsive ajax-data-container pt-3">
                                @include('backend.admin.order.ajax.tableBody')
                            </div>
                            {{$orders->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
