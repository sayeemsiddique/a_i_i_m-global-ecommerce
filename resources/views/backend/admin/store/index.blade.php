@extends('backend.layout.master')

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
                            <h3 class="card-title">Store List</h3>
                            <div class="d-flex align-items-center">
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                                @can('add_store')
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        Add store
                                    </button>

                                    <!-- The Modal -->
                                    <div class="modal" id="myModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Add store</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.store.store') }}" method="POST">
                                                        @csrf

                                                        {{-- store name --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Store name *</label>
                                                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Store name" required>
                                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>

                                                        {{-- phone --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Phone *</label>
                                                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Phone" required>
                                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>

                                                        {{-- address --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Address</label>
                                                            <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Address">
                                                        </div>

                                                        {{-- upazila --}}
                                                        <div class="mb-3">
                                                            <label class="form-label d-block">Upazila / Thana</label>
                                                            <select name="upazila_id" class="form-control select2 d-block w-100">
                                                                <option value="">Select Upazila / Thana</option>
                                                                @foreach ($upazilas as $upazila)
                                                                    <option value="{{ $upazila->id }}">{{ $upazila->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- description  --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Description</label>
                                                            <small class="w-100 text-info">Add working days,opening time,closing time,holiday info</small>
                                                            <textarea name="description" class="form-control summernote" rows="4" placeholder="Description">{{ old('description') }}</textarea>
                                                        </div>



                                                        {{-- Is Active --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option selected value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary w-100">Create store</button>

                                                    </form>

                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endcan

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive ajax-data-container pt-3">
                                <table class="table table-striped table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">Store Name</th>
                                            <th class="text-left">Phone</th>
                                            <th class="text-left">Division</th>
                                            <th class="text-left">District</th>
                                            <th class="text-left">Upazila / Thana</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($stores->count() > 0)
                                        @php
                                            $i = (($stores->currentPage() - 1) * $stores->perPage() + 1);
                                        @endphp
                                            @foreach ($stores as $store)
                                                <tr>
                                                    <td>
                                                        {{$i}}
                                                    </td>
                                                    <td align="left">
                                                        {{$store->name}}
                                                    </td>
                                                    <td align="left">
                                                        {{$store->phone}}
                                                    </td>
                                                    <td align="left">
                                                        {{$store->divisionInfo->name ?? ''}}
                                                    </td>

                                                    <td align="left">
                                                        {{$store->districtInfo->name ?? ''}}
                                                    </td>
                                                    <td align="left">
                                                        {{$store->upazilaInfo->name ?? ''}}
                                                    </td>

                                                    <td>
                                                        @if ($store->status == 1)
                                                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                                                        @else
                                                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @can('view_store')
                                                            <a href="{{route('admin.store.show', $store->id)}}" class="btn btn-outline btn-success btn-sm btn-rounded p-1" title="View">
                                                                <i class="la la-eye p-0 text-white"></i>
                                                            </a>
                                                        @endcan

                                                        @can('edit_store')
                                                            <a title="Edit" type="button" class="btn btn-outline btn-info btn-sm btn-rounded p-1" href="{{ route('admin.store.edit', Crypt::encryptString($store->id)) }}">
                                                                <i class="la la-edit p-0 text-white"></i>
                                                            </a>

                                                        @endcan

                                                        @can('delete_store')
                                                        <form action="{{ route('admin.store.delete', $store) }}" method="POST" style="display: contents;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline btn-danger btn-sm btn-rounded p-1" title="Delete" onclick="return confirm('Are you sure you want to delete this store?');">
                                                                <i class="la la-trash p-0 text-white"></i>
                                                            </button>
                                                        </form>

                                                            {{-- <button class="btn btn-sm btn-clean btn-icon delete" title="Inactive" data-id="{{ $store->id }}">
                                                                    <i class="la la-trash p-0 text-white"></i>
                                                            </button> --}}

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


                            </div>
                            {{$stores->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('stackScript')
	<script src="assets/js/pages/crud/forms/editors/summernote.js"></script>
	<script>
		$(document).ready(function() {
			$('.summernote').summernote({
				height: 200,
			});
		});
    </script>
@endpush
