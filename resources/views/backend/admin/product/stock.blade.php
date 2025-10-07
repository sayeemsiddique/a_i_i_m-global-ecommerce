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
                                <h3 class="card-title">Product Stock List</h3>
                                <div class="d-flex align-items-center">      

                                    {{-- <input type="text" data-url="{{ route('admin.searchAjax', ['type'=> 'productStock']) }}" class="form-control form-control-lg form-control-solid ajax-data-search mr-4" name="q" placeholder="Search By Product Name or Code"> --}}
                                    <a title="Stock In List" class="btn btn-primary btn-sm mr-2" href="{{ route('admin.order.stock_in_list') }}">Stock In List</a>
                                    <a title="Deduct Stock" class="btn btn-danger btn-sm ml-2" href="{{ route('admin.order.deduct_stock_list') }}">Deduct Stock List</a>
                                    @can('product_add_stock')
                                        <a title="Add Stock" class="btn btn-success btn-sm ml-2" href="{{ route('admin.product.add_stock') }}">Add Stock</a>
                                    @endcan
                                    @can('product_deduct_stock')
                                        <a title="Deduct Stock" class="btn btn-warning btn-sm ml-2" href="{{ route('admin.product.deduct_stock') }}">Deduct Stock</a>
                                    @endcan
                                </div>
                            </div>

                            <div class="card-body">
                                <form action="">
                                    <div class="row">
                                        {{-- <div class="col-md-3">
                                            <label for="">Category</label>

                                            <select name="category_id" class="form-control">
                                                <option value="">--Select Category--</option>

                                                @foreach ($categories as $category)
                                                    <option @if(isset($_GET['category_id']) and $_GET['category_id'] == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}

                                        <div class="col-md-3">
                                            <label for="">Search by name</label>

                                            <input type="text" placeholder="Enter Product Name" class="form-control" name="name" @if (isset($_GET['name']) and $_GET['name']!='')
                                                value="{{$_GET['name']}}"
                                            @endif>
                                        </div>

                                        <div class="col-md-3" style="margin-top: 30px;">
                                            <button type="submit" class="btn btn-success btn-sm mr-2">Search</button>

                                            <a href="{{ route('admin.product.stock') }}" class="btn btn-danger btn-sm">Reset Search</a>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive ajax-data-container pt-3">
                                    @include('backend.admin.product.ajax.stock')                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection