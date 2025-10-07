@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    {{-- <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Product</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a class="text-muted">All Product</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div> --}}
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
                            <h3 class="card-title">Product List</h3>
                            <div class="d-flex align-items-center">                                    
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="mt-0 mb-5">
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" placeholder="Enter Product Name or Code" name="name" value="{{ request()->name }}">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control form-control-sm select2" name="category_id">
                                            <option value="">Select category</option>
                                            @foreach ($categories as $category)
                                                <option @if(request()->category_id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex">
                                            <div class="">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            <div class="">
                                                <a href="{{ route('admin.product.index') }}" class="btn btn-danger ml-2">Reset</a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </form>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">Product Name</th>
                                            <th>Product Code</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if ($products->count() > 0)

                                            @php
                                                $i = (($products->currentPage() - 1) * $products->perPage() + 1);
                                            @endphp

                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>
                                                        {{ $i }}
                                                    </td>

                                                    <td class="text-left">
                                                        {{ $product->name }}
                                                    </td>

                                                    <td>
                                                        {{ $product->code }}
                                                    </td>

                                                    <td>
                                                        @if ($product->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-info">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @can('view_product')
                                                            <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-sm bg-primary p-1"  title="View">
                                                                <i class="la la-eye p-0 text-white"></i>
                                                            </a>
                                                        @endcan
                                                        
                                                        @can('edit_product')
                                                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-sm bg-info p-1" title="Edit">
                                                                <i class="la la-edit p-0 text-white"></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete_product')
                                                            <button class="btn btn-sm bg-danger p-1 delete" onclick="deleteProduct({{ $product->id }})" title="Inactive" data-id="{{ $product->id }}">
                                                                <i class="la la-trash p-0 text-white"></i>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr class="odd"><td valign="top" colspan="11" class="dataTables_empty">No matching records found</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                                {{-- @include('backend.admin.product.ajax.tableBody')                                     --}}
                            </div>

                            {{ $products->appends($_GET)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection
@push('stackScript')
    <script> 
        function deleteProduct(id) {
            var data_id = id;
            var url =  '<a href="{{route("admin.product.delete", ":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
            url = url.replace(':id', data_id );
            
            Swal.fire({
                title: 'Are you sure want to delete?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Product Deleted Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        }
    </script>
@endpush