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
                            <h3 class="card-title">Campaign List</h3>
                            <div class="d-flex align-items-center">
                                @can('add_campaign')
                                    <a href="{{ route('admin.campaign.create') }}" class="btn btn-primary btn-sm ml-3">
                                        Add New Campaign
                                    </a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive ajax-data-container pt-3">
                                <table class="table table-striped table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-left">Campaign</th>
                                            <th class="text-left">Start date</th>
                                            <th class="text-left">End date</th>
                                            <th class="text-center">No of Products</th>
                                            <th>Featured</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($campaigns->count() > 0)
                                        @php
                                            $i = (($campaigns->currentPage() - 1) * $campaigns->perPage() + 1);
                                        @endphp
                                            @foreach ($campaigns as $campaign)
                                                <tr>
                                                    <td>
                                                        {{$i}}
                                                    </td>
                                                    <td align="left">
                                                        {{$campaign->title}}
                                                    </td>
                                                    <td align="left">
                                                        {{$campaign->start_date}}
                                                    </td>
                                                    <td align="left">
                                                        {{$campaign->end_date}}
                                                    </td>

                                                    <td class="text-center">
                                                        {{$campaign->campaign_product_info_count}}
                                                    </td>


                                                    <td>
                                                        @if ($campaign->featured == 1)
                                                            <span class="label label-lg font-weight-bold label-light-success label-inline">Featured</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($campaign->status == 1)
                                                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                                                        @else
                                                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @can('view_campaign')
                                                            <a href="{{route('admin.campaign.show', $campaign->id)}}" class="btn btn-outline btn-success btn-sm btn-rounded p-1" title="View">
                                                                <i class="la la-eye p-0 text-white"></i>
                                                            </a>
                                                        @endcan

                                                        @can('edit_campaign')
                                                            <a title="Edit" href="{{route('admin.campaign.edit', $campaign->id)}}" class="btn btn-outline btn-info btn-sm btn-rounded p-1" title="View">
                                                                <i class="la la-edit p-0 text-white"></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete_campaign')
                                                        <form action="{{ route('admin.campaign.delete', $campaign) }}" method="POST" style="display: contents;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline btn-danger btn-sm btn-rounded p-1" title="Delete" onclick="return confirm('Are you sure you want to delete this campaign?');">
                                                                <i class="la la-trash p-0 text-white"></i>
                                                            </button>
                                                        </form>

                                                            {{-- <button class="btn btn-sm btn-clean btn-icon delete" title="Inactive" data-id="{{ $campaign->id }}">
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
                            {{$campaigns->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

{{-- @push('stackScript')
    <script>


    </script>
@endpush --}}
