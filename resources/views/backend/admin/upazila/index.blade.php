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
                                <h3 class="card-title">{{__('Upazila List')}}</h3>

                                <div class="d-flex align-items-center">
                                    <div class="card-toolbar">
                                        @can('add_upazila')
                                            <a href="{{route('admin.upazila.create')}}" class="btn btn-primary">{{__('Add New Upazila')}}</a>
                                        @endcan
                                    </div>


                                </div>

                            </div>
                            <div class="card-body">
                                <form>
                            <div class="row g-3">
                                <div class="col-xxl-2 col-sm-2">
                                    <div>
                                        <select class="form-control" data-choices data-choices-search-false name="division" id="divisionid">
                                            <option value="">{{__('Select Division')}}</option>
                                            @foreach ($regions as $region)
                                                    <option @if(isset($_GET['division']) and $_GET['division']==$region->id) selected @endif value="{{$region->id}}">{{$region->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xxl-2 col-sm-2">
                                    <div>
                                        <select class="form-control" data-choices data-choices-search-false name="district_id" id="districtid">
                                            <option value="">{{__('Select District')}}</option>
                                            @foreach ($districts as $district)
                                                    <option @if(isset($_GET['district_id']) and $_GET['district_id']==$district->id) selected @endif value="{{$district->id}}">{{$district->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-sm-6">
                                    <div class="search-box">
                                        <input type="text" class="form-control search" name="name" placeholder="{{__('Upazila Name')}}" @if(isset($_GET['name']) and $_GET['name']!='') value="{{$_GET['name']}}" @endif>
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <!--end col-->

                                <div class="col-xxl-1 col-sm-4">
                                    <div>
                                        <button style="max-width: 150px;" type="submit" class="btn btn-primary w-100"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                            {{__('Filter')}}
                                        </button>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-sm-4">
                                    <div>
                                        <a style="max-width: 150px;" href="{{route('admin.upazila.index')}}" class="btn btn-danger w-100"> <i class="ri-restart-line me-1 align-bottom"></i>
                                            {{__('Reset')}}
                                        </a>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>

                                <div class="table-responsive ajax-data-container pt-3">
                                    <table class="table table-bordered table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{__('No')}}</th>
                                        <th>{{__('Upazila Name')}}</th>
                                        <th>{{__('Division')}}</th>
                                        <th>{{__('District')}}</th>
                                        <th class="text-center">{{__('Status')}}</th>
                                        <th class="text-center">{{__('Action')}}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if ($upazilas->count() > 0)
                                        @php
                                            $i = ($upazilas->perPage() * ($upazilas->currentPage() - 1) +1);
                                        @endphp
                                        @foreach ($upazilas as $upazila)
                                            <tr>
                                                <td class="text-center">{{$i}}</td>
                                                <td>{{$upazila->name ?? '-'}}</td>
                                                <td>{{$upazila->districtInfo->divisionInfo->name ?? '-'}}</td>
                                                <td>{{$upazila->districtInfo->name ?? '-'}}</td>
                                                <td class="text-center">
                                                    @if ($upazila->status == 1)
                                                        <span class="badge bg-success">{{__('Active')}}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{__('Inactive')}}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">

                                                    @can('view_upazila')
                                                        <a href="{{route('admin.upazila.view',$upazila->id)}}" title="View " type="button" class="btn btn-success btn-sm btn-icon waves-effect waves-light">
                                                            <i class="las la-eye" style="font-size: 1.6em;"></i>
                                                        </a>
                                                    @endcan

                                                    @can('edit_upazila')
                                                        <a href="{{route('admin.upazila.edit',$upazila->id)}}" title="Edit " type="button" class="btn btn-info btn-sm btn-icon waves-effect waves-light">
                                                            <i class="las la-edit" style="font-size: 1.6em;"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete_upazila')
                                                        <a onclick="return confirm('Are you sure ?')" href="{{route('admin.upazila.delete',$upazila->id)}}" title="Delete" type="button" class="btn btn-danger btn-sm btn-icon waves-effect waves-light">
                                                            <i class="las la-trash" style="font-size: 1.6em;"></i>
                                                        </a>
                                                    @endcan

                                                </td>

                                            </tr>
                                            @php
                                                $i++;
                                            @endphp


                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="100%" class="text-center"><b>{{__('No Data Found')}}</b></td>
                                        </tr>
                                    @endif

                                </tbody>
                                <!-- end tbody -->
                            </table>
                                </div>

                                {{ $upazilas->appends($_GET)->links() }}
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
            // $("#districtid").on('change',function(e){
            // e.preventDefault();
            //     let districtId = $(this).val();
            //     if (districtId) {
            //         $.ajax({
            //             url: "{{ route('upazilas') }}/?district_id=" + districtId,
            //             type: "GET",
            //             success: function (data) {
            //                 $('#upazilaid').empty().append('<option value="">-- Select Upazila / Thana --</option>');
            //                 $.each(data.upazilas, function (key, upazila) {
            //                     $('#upazilaid').append('<option value="' + upazila.id + '">' + upazila.name + '</option>');
            //                 });
            //             }
            //         });
            //     }
            // });
        });
    </script>

@endpush
