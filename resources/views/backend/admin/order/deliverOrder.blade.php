@extends('backend.layout.master')

	@section('content')
        <!--begin::Content-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Subheader-->
            <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline flex-wrap mr-5">
                            <!--begin::Page Title-->
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Deliver Process</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin.index')}}" class="text-muted">Dashboard</a>
                                </li>
                                
                                <li class="breadcrumb-item active">
                                    <a class="text-muted">Deliver Process</a>
                                </li>
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page Heading-->
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Subheader-->
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--session msg-->
                    @include('alerts.alerts')

                    <!--begin::Card-->
                    <div class="row">
                        <div class="col-lg-12">
                            <!--begin::Card-->
                            <div class="card card-custom example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">Deliver Process</h3>
                                </div>
                                
                                
                                <!--begin::Form-->
                                <form class="form" action="{{ route('admin.order.weight_cal', $order->id) }}" method="post" id="kt_form_1">
                                    @csrf

                                    <div class="card-body">

                                        @if ($order->personal_vehicle == 1)
                                            <input type="hidden" name="delivery_type" value="2">
                                            
                                            <div class="card-body">
                                                
                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle Type: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <select name="vehicle_type" id="vehicle_type" class="form-control" required> 
                                                            <option value="">--Select Vehicle Type--</option>
                                                            <option value="Truck">Truck</option>
                                                            <option value="Pickup">Pickup</option>
                                                            <option value="Van">Van</option>
                                                            <option value="Rickshaw">Rickshaw</option>
                                                            <option value="Bike">Bike</option>
                                                            <option value="Other Private Vehicle">Other Private Vehicle</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                    
                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Plate No: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <input type="text" class="form-control plate_no" id="plate_no" name="plate_no" placeholder="Enter Plate No." value="{{ old('plate_no') }}" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">License No: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <input type="text" class="form-control license_no" id="license_no" name="license_no" placeholder="Enter License No." value="{{ old('license_no') }}" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Entry Weight: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <input type="text" class="form-control entry_weight" id="entry_weight" name="entry_weight" placeholder="Enter Entry Weight" value="{{ old('entry_weight') }}" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Outgoing Weight: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <input type="text" class="form-control outgoing_weight" id="outgoing_weight" name="outgoing_weight" placeholder="Enter Outgoing Weight" value="{{ old('outgoing_weight') }}" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Weight Difference: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <input type="text" class="form-control differ_weight" id="differ_weight" name="differ_weight" value="" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" name="delivery_type" value="1">
                                                
                                            <div class="card-body">
                                                
                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Vehicle: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <select name="vehicle_type" id="vehicle_type" class="form-control" required> 
                                                            <option value="">--Select Vehicle--</option>

                                                            @foreach ($vehicles as $vehicle)
                                                                <option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
                                                            @endforeach
                                                            
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Entry Weight: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <input type="text" class="form-control entry_weight" id="entry_weight" name="entry_weight" placeholder="Enter Entry Weight" value="{{ old('entry_weight') }}" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Outgoing Weight: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <input type="text" class="form-control outgoing_weight" id="outgoing_weight" name="outgoing_weight" placeholder="Enter Outgoing Weight" value="{{ old('outgoing_weight') }}" required/>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-form-label text-right col-lg-4 col-sm-12">Weight Difference: <span class="text-danger">*</span></label>
                                                    <div class="col-lg-5 col-sm-12">
                                                        <input type="text" class="form-control differ_weight" id="differ_weight" name="differ_weight" value="" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-9 text-right">
                                                <button type="submit" class="btn btn-primary font-weight-bold">Generate Gatepass</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Card-->
                        </div>
                    </div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
        <!--end::Content-->
	@endsection

	@push('stackScript')
        <script> 
            $('#entry_weight').on('keyup', function () {
                let entry_weight = $('#entry_weight').val();
                let outgoing_weight = $('#outgoing_weight').val();

                let differ_weight = Number(outgoing_weight) - Number(entry_weight);

                $('#differ_weight').val(differ_weight);
            });
        </script>

        <script> 
            $('#outgoing_weight').on('keyup', function () {
                let entry_weight = $('#entry_weight').val();
                let outgoing_weight = $('#outgoing_weight').val();

                let differ_weight = Number(outgoing_weight) - Number(entry_weight);

                $('#differ_weight').val(differ_weight);
            });
        </script>
	@endpush
					