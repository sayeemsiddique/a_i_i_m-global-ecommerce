@extends('customer.layout.master')

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
                            <h3 class="card-title">My Shipping Addresses</h3>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('shipping_address.create') }}" class="btn btn-primary btn-sm ml-3">
                                    <i class="fa fa-plus"></i> Add New Address
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Recipient</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Category</th>
                                            <th>Default Shipping</th>
                                            {{-- <th>Default Billing</th> --}}
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($shippingAddresses as $address)
                                            <tr>
                                                <td class="text-left">{{ $address->recipient_name }}</td>
                                                <td>{{ $address->phone_no }}</td>
                                                <td>
                                                    {{ $address->address }},
                                                    @if($address->upazila) {{ $address->upazila->name }}, @endif
                                                    @if($address->district) {{ $address->district->name }}, @endif
                                                    @if($address->division) {{ $address->division->name }} @endif
                                                </td>
                                                <td>
                                                    @if ($address->address_catagory == 1)
                                                        <span class="badge badge-success">Home</span>
                                                    @elseif ($address->address_catagory == 2)
                                                        <span class="badge badge-info">Office</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($address->default_shipping == 1)
                                                        <span class="badge badge-primary">Yes</span>
                                                    @else
                                                        <span class="badge badge-secondary">No</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    @if ($address->default_billing == 1)
                                                        <span class="badge badge-primary">Yes</span>
                                                    @else
                                                        <span class="badge badge-secondary">No</span>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    <a href="{{ route('shipping_address.show', Crypt::encryptString($address->id)) }}"
                                                       class="btn btn-outline btn-success btn-sm btn-rounded p-1">
                                                       <i class="la la-eye p-0 text-white"></i>
                                                    </a>

                                                    <a href="{{ route('shipping_address.edit', Crypt::encryptString($address->id)) }}"
                                                       class="btn btn-outline btn-info btn-sm btn-rounded p-1">
                                                        <i class="la la-edit p-0 text-white"></i>
                                                    </a>

                                                    <form action="{{ route('shipping_address.destroy', Crypt::encryptString($address->id)) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline btn-danger btn-sm btn-rounded p-1"
                                                            onclick="return confirm('Are you sure you want to delete this address?')">
                                                            <i class="la la-trash p-0 text-white"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No shipping addresses found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{ $shippingAddresses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
