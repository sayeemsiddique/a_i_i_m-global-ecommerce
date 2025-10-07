@extends('customer.layout.master')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('alerts.alerts')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Edit Shipping Address</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('shipping_address.update', Crypt::encryptString($shippingAddress->id)) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient_name">Recipient Name</label>
                                            <input type="text" class="form-control" name="recipient_name" value="{{ old('recipient_name', $shippingAddress->recipient_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_no">Phone Number</label>
                                            <input type="text" class="form-control" name="phone_no" value="{{ old('phone_no', $shippingAddress->phone_no) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="division_id">Division</label>
                                            <select name="division_id" class="form-control" required>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->id }}" {{ $shippingAddress->division_id == $division->id ? 'selected' : '' }}>
                                                        {{ $division->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="district_id">District</label>
                                            <select name="district_id" class="form-control" required>
                                                @foreach($districts as $district)
                                                    <option value="{{ $district->id }}" {{ $shippingAddress->district_id == $district->id ? 'selected' : '' }}>
                                                        {{ $district->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="upazila_id">Upazila</label>
                                            <select name="upazila_id" class="form-control" required>
                                                @foreach($upazilas as $upazila)
                                                    <option value="{{ $upazila->id }}" {{ $shippingAddress->upazila_id == $upazila->id ? 'selected' : '' }}>
                                                        {{ $upazila->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Full Address</label>
                                            <textarea name="address" class="form-control" rows="1" required>{{ old('address', $shippingAddress->address) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_catagory">Address Category</label>
                                            <select name="address_catagory" class="form-control" required>
                                                <option value="1" {{ $shippingAddress->address_catagory == 1 ? 'selected' : '' }}>Home</option>
                                                <option value="2" {{ $shippingAddress->address_catagory == 2 ? 'selected' : '' }}>Office</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" name="default_shipping" value="1" class="form-check-input" 
                                                {{ $shippingAddress->default_shipping == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label">Set as Default Shipping</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" name="default_billing" value="1" class="form-check-input" 
                                                {{ $shippingAddress->default_billing == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label">Set as Default Billing</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">Update Address</button>
                                            <a href="{{ route('shipping_address.index') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
