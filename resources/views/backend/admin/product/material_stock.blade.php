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
                            <h3 class="card-title">Store Product Stock List</h3>
                            <div class="d-flex align-items-center w-50">                                    
                                <input style="width:45% !important" type="text"data-url="{{ route('admin.searchAjax', ['type'=> 'materialProduct']) }}" class="form-control form-control-lg form-control-solid ajax-data-search mr-4" name="q" placeholder="Search By Store Product Name">

                                @can('product_add_stock')
                                    <a title="Add Stock" class="btn btn-success btn-sm mr-2" href="{{route('admin.product.material_add_stock')}}"> Add Stock</a>
                                    <a title="Add Stock" class="btn btn-danger btn-sm" href="{{route('admin.product.material_deduct_stock')}}"> Deduct Stock</a>
                                @endcan

                                <a title="Store product add history" class="btn btn-primary btn-sm ml-3" href="{{route('admin.product.material_add_stock_history')}}">Store product history</a>
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive ajax-data-container pt-3">
                                @include('backend.admin.product.ajax.material_stock')                                    
                            </div>
                            {{-- {{$products->appends($_GET)->links()}} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection