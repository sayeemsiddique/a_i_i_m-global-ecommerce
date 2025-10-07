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
                            <h3 class="card-title">Shipping Address Details</h3>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('shipping_address.index') }}" class="btn btn-secondary btn-sm ml-3">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                                <a href="{{ route('shipping_address.edit', Crypt::encryptString($shippingAddress->id)) }}" class="btn btn-info btn-sm ml-3">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Recipient Name</th>
                                    <td>{{ $shippingAddress->recipient_name }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $shippingAddress->phone_no }}</td>
                                </tr>
                                <tr>
                                    <th>Division</th>
                                    <td>{{ optional($shippingAddress->division)->name }}</td>
                                </tr>
                                <tr>
                                    <th>District</th>
                                    <td>{{ optional($shippingAddress->district)->name }}</td>
                                </tr>
                                <tr>
                                    <th>Upazila</th>
                                    <td>{{ optional($shippingAddress->upazila)->name }}</td>
                                </tr>
                                <tr>
                                    <th>Full Address</th>
                                    <td>{{ $shippingAddress->address }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>
                                        @if ($shippingAddress->address_catagory == 1)
                                            <span class="badge badge-success">Home</span>
                                        @elseif ($shippingAddress->address_catagory == 2)
                                            <span class="badge badge-info">Office</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Default Shipping</th>
                                    <td>
                                        @if ($shippingAddress->default_shipping == 1)
                                            <span class="badge badge-primary">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Default Billing</th>
                                    <td>
                                        @if ($shippingAddress->default_billing == 1)
                                            <span class="badge badge-primary">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $shippingAddress->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $shippingAddress->updated_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('shipping_address.destroy', Crypt::encryptString($shippingAddress->id)) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this address?')">
                                    Delete
                                </button>
                            </form>
                            <a href="{{ route('shipping_address.index') }}" class="btn btn-secondary ml-2">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
