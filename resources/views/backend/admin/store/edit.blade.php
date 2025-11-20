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
                            <h3 class="card-title">Edit Store</h3>
                            <div class="d-flex align-items-center">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form class="form" action="{{ route('admin.store.update', Crypt::encryptString($store->id)) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        {{-- store name --}}
                                        <div class="mb-3">
                                            <label class="form-label">Store name *</label>
                                            <input type="text" name="name" class="form-control" value="{{ $store->name }}" placeholder="Store name" required>
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- phone --}}
                                        <div class="mb-3">
                                            <label class="form-label">Phone *</label>
                                            <input type="text" name="phone" class="form-control" value="{{ $store->phone }}" placeholder="Phone" required>
                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>

                                        {{-- address --}}
                                        <div class="mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" name="address" class="form-control" value="{{ $store->address }}" placeholder="Address">
                                        </div>

                                        {{-- upazila --}}
                                        <div class="mb-3">
                                            <label class="form-label d-block">Upazila / Thana</label>
                                            <select name="upazila_id" class="form-control select2 d-block w-100">
                                                <option value="">Select Upazila / Thana</option>
                                                @foreach ($upazilas as $upazila)
                                                    <option @if($store->upazila_id == $upazila->id) selected @endif value="{{ $upazila->id }}">{{ $upazila->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- description  --}}
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <small class="w-100 text-info">Add working days,opening time,closing time,holiday info</small>
                                            <textarea name="description" class="form-control summernote" rows="4" placeholder="Description">{!! $store->description !!}</textarea>
                                        </div>



                                        {{-- Is Active --}}
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-control">
                                                <option @if($store->status == 1) selected @endif selected value="1">Active</option>
                                                <option @if($store->status == 0) selected @endif value="0">Inactive</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2">Update Store</button>
                                    </form>
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
	<script src="assets/js/pages/crud/forms/editors/summernote.js"></script>
	<script>
		$(document).ready(function() {
			$('.summernote').summernote({
				height: 200,
			});
		});
    </script>
@endpush
