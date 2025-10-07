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
                            <h3 class="card-title">All Orders</h3>
                            <div class="d-flex align-items-center"> 

                                                            
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                            </div>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0 row">
                    
                            <form class="form-inline" method="GET">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">From :</label>
                                                <input class="form-control form-control-sm" type="date" name="fromDate" @if(isset($_GET['fromDate']) and $_GET['fromDate'] != '') value="{{$_GET['fromDate']}}" @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">To :</label>
                                                <input class="form-control form-control-sm" type="date" name="toDate" @if(isset($_GET['toDate']) and $_GET['toDate'] != '') value="{{$_GET['toDate']}}" @endif>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <div class="form-group">
                                                <label class="pr-2 pl-2">User Type :</label>
                                                <select class="form-control" name="type" id="type">
                                                    <option value="">--Select User Type--</option>
                                                    <option @if(isset($_GET['type']) and $_GET['type'] == 1) selected @endif value="1">Customer</option>
                                                    <option @if(isset($_GET['type']) and $_GET['type'] == 2) selected @endif value="2">Corporate Consumer</option>
                                                    <option @if(isset($_GET['type']) and $_GET['type'] == 3) selected @endif value="3">Dealer</option>
                                                </select>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="form-group mt-2">
                                                <label class="pr-2 pl-2">Order ID :</label>
                                                <input class="form-control form-control-sm" type="text" name="order_id" @if(isset($_GET['order_id']) and $_GET['order_id'] != '') value="{{$_GET['order_id']}}" @endif placeholder="Search by Order ID">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-success mt-2 ml-2 btn-sm">Search</button>
                                            <a href="{{route('admin.order.index')}}" class="btn btn-danger mt-2 ml-2 btn-sm">Reset Search</a>
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

                            {{ $orders->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection