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
                            <h3 class="card-title">Add New Shipping Address</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('shipping_address.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient_name">Recipient Name</label>
                                            <input type="text" class="form-control" name="recipient_name" 
                                                value="{{ old('recipient_name') }}" 
                                                placeholder="Recipient Name" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_no">Phone Number</label>
                                            <input type="text" class="form-control" name="phone_no" 
                                                value="{{ old('phone_no') }}" 
                                                placeholder="Phone Number" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="division_id">Region</label>
                                            <select name="division_id" id="divisionid" class="form-control" required>
                                                <option value="">-- Select Region --</option>
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                        {{ $division->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="district_id">District</label>
                                            <select name="district_id" id="districtid" class="form-control" required>
                                                <option value="">-- Select District --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="upazila_id">Upazila / Thana</label>
                                            <select name="upazila_id" id="upazilaid" class="form-control" required>
                                                <option value="">-- Select Upazila / Thana --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Full Address</label>
                                            <textarea name="address" class="form-control" rows="1" required placeholder="Full Address">{{ old('address') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_catagory">Address Category</label>
                                            <select name="address_catagory" class="form-control" required>
                                                <option value="1" {{ old('address_catagory') == 1 ? 'selected' : '' }}>Home</option>
                                                <option value="2" {{ old('address_catagory') == 2 ? 'selected' : '' }}>Office</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" name="default_shipping" value="1" class="form-check-input" {{ old('default_shipping') ? 'checked' : '' }}>
                                            <label class="form-check-label">Set as Default Shipping</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="default_billing" value="1" class="form-check-input" {{ old('default_billing') ? 'checked' : '' }}>
                                            <label class="form-check-label">Set as Default Billing</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">Save Address</button>
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

@push('stackScript')
    <script>
        $(document).ready(function () {
            // When division changes → load districts
            $("#divisionid").on('change',function(e){
            e.preventDefault();
                let divisionId = $(this).val();
                if (divisionId) {
                    $.ajax({
                        url: "{{ route('districts') }}/?division_id=" + divisionId,
                        type: "GET",
                        success: function (data) {
                            $('#districtid').empty().append('<option value="">-- Select District --</option>');
                            $('#upazilaid').empty().append('<option value="">-- Select Upazila / Thana --</option>'); // reset
                            $.each(data.districts, function (key, district) {
                                $('#districtid').append('<option value="' + district.id + '">' + district.name + '</option>');
                            });
                        }
                    });
                }
            });

            // When district changes → load upazilas
            $("#districtid").on('change',function(e){
            e.preventDefault();
                let districtId = $(this).val();
                if (districtId) {
                    $.ajax({
                        url: "{{ route('upazilas') }}/?district_id=" + districtId,
                        type: "GET",
                        success: function (data) {
                            $('#upazilaid').empty().append('<option value="">-- Select Upazila / Thana --</option>');
                            $.each(data.upazilas, function (key, upazila) {
                                $('#upazilaid').append('<option value="' + upazila.id + '">' + upazila.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
	
@endpush