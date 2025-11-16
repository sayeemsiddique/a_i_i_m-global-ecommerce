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
                            <h3 class="card-title">Voucher List</h3>
                            <div class="d-flex align-items-center">
                                {{-- <input type="text"data-url="{{ route('admin.searchAjax',['type'=> 'designation']) }}" class="form-control form-control-lg form-control-solid ajax-data-search" name="q" placeholder="Enter Designation, Description, Level"> --}}
                                @can('add_voucher')
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        Add voucher
                                    </button>

                                    <!-- The Modal -->
                                    <div class="modal" id="myModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                <h4 class="modal-title">Add voucher</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form action="{{ route('admin.voucher.store') }}" method="POST">
                                                        @csrf

                                                        {{-- Voucher Code --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Voucher Code *</label>
                                                            <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="Voucher Code" required>
                                                            @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>

                                                        {{-- Discount Type --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Discount Type *</label>
                                                            <select name="type" class="form-control" required>
                                                                <option value="fixed">Fixed Amount</option>
                                                                <option value="percent">Percentage (%)</option>
                                                            </select>
                                                            @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>

                                                        {{-- Discount Value --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Discount Value *</label>
                                                            <input type="number" step="0.01" name="value" class="form-control" value="{{ old('value') }}" placeholder="Discount Value" required>
                                                            @error('value') <span class="text-danger">{{ $message }}</span> @enderror
                                                        </div>

                                                        {{-- Minimum Order --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Minimum Order Amount (0 = any amount) *</label>
                                                            <input type="number" step="0.01" name="min_order_amount" class="form-control" placeholder="Minimum Order Amount" value="{{ old('min_order_amount') }}" required>
                                                        </div>

                                                        {{-- Max Uses --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Max Uses (0 = unlimited)</label>
                                                            <input type="number" name="max_uses" class="form-control" placeholder="Max Uses" value="{{ old('max_uses', 0) }}">
                                                        </div>

                                                        {{-- Validity --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Start Date</label>
                                                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">End Date</label>
                                                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                                        </div>

                                                        {{-- Is Active --}}
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select name="status" class="form-control">
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary w-100">Create Voucher</button>

                                                    </form>
                                                    {{-- <form action="{{route('admin.voucher.store')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="1">
                                                        <div class="form-group">
                                                            <label for="name">Name: <small class="text-danger">*</small></label>
                                                            <input name="name" type="text" class="form-control" placeholder="Enter name" id="name" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name">Type: <small class="text-danger">*</small></label>
                                                            <select class="form-control" id="sel1" name="type" required>
                                                                <option value="">Select</option>
                                                                <option value="1">Percent</option>
                                                                <option value="2">Flat Rate</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name">Rate Value: <small class="text-danger">*</small></label>
                                                            <input name="value" type="number" class="form-control" placeholder="Enter rate value" id="value" required>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </form> --}}
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
                                            <th class="text-left">Voucher</th>
                                            <th class="text-left">Start date</th>
                                            <th class="text-left">End date</th>
                                            <th class="text-left">Value</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($vouchers->count() > 0)
                                        @php
                                            $i = (($vouchers->currentPage() - 1) * $vouchers->perPage() + 1);
                                        @endphp
                                            @foreach ($vouchers as $voucher)
                                                <tr>
                                                    <td>
                                                        {{$i}}
                                                    </td>
                                                    <td align="left">
                                                        {{$voucher->code}}
                                                    </td>
                                                    <td align="left">
                                                        {{$voucher->start_date}}
                                                    </td>
                                                    <td align="left">
                                                        {{$voucher->end_date}}
                                                    </td>

                                                    <td align="left">
                                                        {{$voucher->value}} @if ($voucher->type == 'percent') % @else Flat rate @endif
                                                    </td>

                                                    <td>
                                                        @if ($voucher->status == 1)
                                                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                                                        @else
                                                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @can('view_voucher')
                                                            <a href="{{route('admin.voucher.show', $voucher->id)}}" class="btn btn-sm btn-clean btn-icon" title="View">
                                                                <i class="la la-eye"></i>
                                                            </a>
                                                        @endcan

                                                        @can('edit_voucher')
                                                            <button title="Edit" type="button" class="btn btn-sm bg-info p-1" data-toggle="modal" data-target="#voucher_edit{{$voucher->id}}">
                                                                <i class="la la-edit p-0 text-white"></i>
                                                            </button>

                                                            <!-- The Modal -->
                                                            <div class="modal" id="voucher_edit{{$voucher->id}}">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">

                                                                        <!-- Modal Header -->
                                                                        <div class="modal-header">
                                                                        <h4 class="modal-title">Edit Voucher</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        </div>

                                                                        <!-- Modal body -->
                                                                        <div class="modal-body">
                                                                            <form class="text-left" action="{{route('admin.voucher.update', $voucher)}}" method="POST">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                {{-- Voucher Code --}}
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Voucher Code *</label>
                                                                                    <input type="text" name="code" class="form-control" value="{{ $voucher->code }}" placeholder="Voucher Code" required>
                                                                                    @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                                                                                </div>

                                                                                {{-- Discount Type --}}
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Discount Type *</label>
                                                                                    <select name="type" class="form-control" required>
                                                                                        <option @if($voucher->type == 'fixed') selected @endif value="fixed">Fixed Amount</option>
                                                                                        <option @if($voucher->type == 'percent') selected @endif value="percent">Percentage (%)</option>
                                                                                    </select>
                                                                                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                                                                                </div>

                                                                                {{-- Discount Value --}}
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Discount Value *</label>
                                                                                    <input type="number" step="0.01" name="value" class="form-control" value="{{ $voucher->value }}" placeholder="Discount Value" required>
                                                                                    @error('value') <span class="text-danger">{{ $message }}</span> @enderror
                                                                                </div>

                                                                                {{-- Minimum Order --}}
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Minimum Order Amount (0 = any amount) *</label>
                                                                                    <input type="number" step="0.01" name="min_order_amount" class="form-control" placeholder="Minimum Order Amount" value="{{ $voucher->min_order_amount }}" required>
                                                                                </div>

                                                                                {{-- Max Uses --}}
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Max Uses (0 = unlimited)</label>
                                                                                    <input type="number" name="max_uses" class="form-control" placeholder="Max Uses" value="{{ $voucher->max_uses }}">
                                                                                </div>

                                                                                {{-- Validity --}}
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Start Date</label>
                                                                                    <input type="date" name="start_date" class="form-control" value="{{ $voucher->start_date }}">
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label class="form-label">End Date</label>
                                                                                    <input type="date" name="end_date" class="form-control" value="{{ $voucher->end_date }}">
                                                                                </div>

                                                                                {{-- Is Active --}}
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Status</label>
                                                                                    <select name="status" class="form-control">
                                                                                        <option @if($voucher->status == 1) selected @endif value="1">Active</option>
                                                                                        <option @if($voucher->status == 0) selected @endif value="0">Inactive</option>
                                                                                    </select>
                                                                                </div>

                                                                                <button type="submit" class="btn btn-primary">Save</button>
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

                                                        @can('delete_voucher')
                                                        <form action="{{ route('admin.voucher.delete', $voucher) }}" method="POST" style="display: contents;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm bg-danger p-1" title="Delete" onclick="return confirm('Are you sure you want to delete this voucher?');">
                                                                <i class="la la-trash p-0 text-white"></i>
                                                            </button>
                                                        </form>

                                                            {{-- <button class="btn btn-sm btn-clean btn-icon delete" title="Inactive" data-id="{{ $voucher->id }}">
                                                                    <i class="la la-trash"></i>
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
                            {{$vouchers->appends($_GET)->links()}}
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
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.voucher.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
            url = url.replace(':id', data_id );

            Swal.fire({
                title: 'Are you sure ?',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: url,
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Status Changed Successfully!', '', 'success')
                } else if (result.dismiss === "cancel") {
                    Swal.fire('Canceled', '', 'error')
                }
            })
        });

    </script>
@endpush --}}
