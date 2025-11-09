@extends('backend.layout.master')

@section('content')
@php
    $filter_category_name= '';
@endphp
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
                            <h3 class="card-title">Damage Product List</h3>
                        </div>

                        {{-- Advance filter --}}
                        <div class="form-group card-body mb-0 pb-0">

                            <form class="" method="GET">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="pr-2 pl-2">From :</label>

                                            <input class="form-control" type="date" name="fromDate" @if(isset($_GET['fromDate']) and $_GET['fromDate'] != '') value="{{$_GET['fromDate']}}" @endif>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="pr-2 pl-2">To :</label>

                                            <input class="form-control" type="date" name="toDate" @if(isset($_GET['toDate']) and $_GET['toDate'] != '') value="{{$_GET['toDate']}}" @endif>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="pr-2 pl-2">Product Category</label>
                                            <select class="form-control select2" name="category_id" id="category_id">
                                                <option value="">--Select a Category--</option>
                                                @foreach ($categories as $category)
                                                    <option @if(isset($_GET['category_id']) and $_GET['category_id'] == $category->id) selected
                                                    @php
                                                        $filter_category_name = $category->name;
                                                    @endphp
                                                    @endif value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="pr-2 pl-2">Product Type:</label>

                                            <select class="form-control" name="type" id="type">
                                                <option value="">--Select Product Type--</option>
                                                <option @if(isset($_GET['type']) and $_GET['type'] == 1) selected @endif value="1">Finished Product</option>
                                                <option @if(isset($_GET['type']) and $_GET['type'] == 2) selected @endif value="2">Store Product</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="pr-2 pl-2">Product Name :</label>

                                            <input class="form-control" type="text" name="name" @if(isset($_GET['name']) and $_GET['name'] != '') value="{{$_GET['name']}}" @endif placeholder="Search by Product Name">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="pr-2 pl-2">Product Code :</label>

                                            <input class="form-control" type="text" name="code" @if(isset($_GET['code']) and $_GET['code'] != '') value="{{$_GET['code']}}" @endif placeholder="Search by Product Code">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-success mt-4 ml-2">Search</button>
                                            <a href="{{ route('admin.productDamage.index') }}" class="btn btn-danger mt-4 ml-2">Reset Search</a>
                                    </div>

                                </div>

                            </form>
                        </div>
                        {{-- End Filter --}}

                        <div class="card-body">

                            <div class="table-responsive ajax-data-container pt-3">
                                @include('backend.admin.productDamange.ajax.index')
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
