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
                        <!--begin::Card-->
                        <div class="card card-custom example example-compact">
                            <div class="card-header">
                                <h3 class="card-title">Order Setting</h3>
                                
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.setting.setting_update', $setting->id ?? 1)}}" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        @csrf
                                            
                                        {{-- <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Dealer Discount (Flat): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="dealer_discount_flat" class="form-control" value="{{ $setting->dealer_discount_flat ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Dealer Discount (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" step="0.01" name="dealer_discount_percent" class="form-control" value="{{ $setting->dealer_discount_percent ?? '0' }}" required>
                                            </div>
                                        </div> --}}

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Dealer Commission Range One: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="dealer_15_discount_amount" class="form-control" value="{{ $setting->dealer_15_discount_amount ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Dealer Commission Range Two: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="dealer_15plus_discount_amount" class="form-control" value="{{ $setting->dealer_15plus_discount_amount ?? '0' }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Dealer Commission Percentage(0-1500000): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="dealer_discount_percent" class="form-control" value="{{ $setting->dealer_discount_percent ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Dealer Commission Percentage(1500000+): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="dealer_15plus_discount" class="form-control" value="{{ $setting->dealer_15plus_discount ?? '0' }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Order Discount Amount (In Lakh): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="discount_amount" class="form-control" value="{{ $setting->discount_amount ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Order Discount (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="discount_percentage" class="form-control" value="{{ $setting->discount_percentage ?? '0' }}" required>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">VAT (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="vat" class="form-control" disabled value="{{ $setting->vat ? $setting->vat : '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">SD (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="sd" class="form-control" disabled value="{{ $setting->sd ? $setting->sd : '0' }}" required>
                                            </div>
                                        </div> --}}

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">TDS (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="tds" class="form-control" value="{{ $setting->tds ? $setting->tds : '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">VDS (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="vds" class="form-control" value="{{ $setting->vds ? $setting->vds : '0' }}" required>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Normal Packing Charge (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.02" name="packing_normal" class="form-control" value="{{ $setting->packing_normal ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Standard Packing Charge (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.02" name="packing_standard" class="form-control" value="{{ $setting->packing_standard ?? '0' }}" required>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Error (Flat in gram): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="error_flat" class="form-control" value="{{ $setting->error_flat ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Error (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="error_percent" class="form-control" value="{{ $setting->error_percent ?? '0' }}" required>
                                            </div>
                                        </div> --}}

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Delivery Charge (Inside Dhaka): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="courier_inside_dhaka" class="form-control" value="{{ $setting->courier_inside_dhaka ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Delivery Charge (Outside Dhaka): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="courier_outside_dhaka" class="form-control" value="{{ $setting->courier_outside_dhaka ?? '0' }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Other Charge Category: <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <select name="other_category[]" id="other_category" class="form-control select-multiple" multiple> 
                                                    <option value="">--Select Category--</option>
                                                    
                                                    @if ($categorySelected)
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}" {{ (in_array($category->id, $categorySelected)) ? 'selected' : '' }}>{{ $category->name}}</option>
                                                        @endforeach
                                                    @else
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    @endif
                                                    
                                                </select>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Other Charge (In Taka): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="other_charge" class="form-control" value="{{ $setting->other_charge ?? '0' }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {{-- <label class="col-form-label col-lg-2 col-sm-12 text-right">Corporate Consumer Discount (Flat): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="consumer_discount_flat" class="form-control" value="{{ $setting->consumer_discount_flat ?? '0' }}" required>
                                            </div> --}}

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Retail Consumer Commission (Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="consumer_discount_percent" class="form-control" value="{{ $setting->consumer_discount_percent ?? '0' }}" required>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab One (Starting Range): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="ait_slab1_range_start" class="form-control" value="{{ $setting->ait_slab1_range_start ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab One (End Range): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="ait_slab1_range_end" class="form-control" value="{{ $setting->ait_slab1_range_end ?? '0' }}" required>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab Two (Starting Range): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="ait_slab2_range_start" class="form-control" value="{{ $setting->ait_slab2_range_start ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab Two (End Range): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="ait_slab2_range_end" class="form-control" value="{{ $setting->ait_slab2_range_end ?? '0' }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab Three (Starting Range): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="ait_slab3_range_start" class="form-control" value="{{ $setting->ait_slab3_range_start ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab Three (End Range): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="text" name="ait_slab3_range_end" class="form-control" value="{{ $setting->ait_slab3_range_end ?? '0' }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab One Rate (In Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="ait_slab1_percentage" class="form-control" value="{{ $setting->ait_slab1_percentage ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab Two Rate (In Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="ait_slab2_percentage" class="form-control" value="{{ $setting->ait_slab2_percentage ?? '0' }}" required>
                                            </div>
                                        </div> --}}

                                        {{-- <div class="form-group row">
                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">AIT Slab Three Rate (In Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="ait_slab3_percentage" class="form-control" value="{{ $setting->ait_slab3_percentage ?? '0' }}" required>
                                            </div>

                                            <label class="col-form-label col-lg-2 col-sm-12 text-right">Order Tax (In Percentage): <span style="color: red;">*</span></label>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="number" step="0.01" name="tax" class="form-control" value="{{ $setting->tax ?? '0' }}" required>
                                            </div>
                                        </div> --}}
                                    </div>

                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-12 float-right">
                                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
</div>



@endsection

