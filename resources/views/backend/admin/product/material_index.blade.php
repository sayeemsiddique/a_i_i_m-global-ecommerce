@extends('backend.layout.master')

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            @include('alerts.alerts')
            <!--begin::Card-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-custom example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Store Product List</h3>
                            <div class="d-flex align-items-center">
                                <form class="form-inline mr-2">
                                    <div class="input-group">
                                        <input type="text" name="name" class="form-control" @if(isset($_GET['name']) and $_GET['name'] != '') value="{{$_GET['name']}}" @endif placeholder="Enter name or code">
                                        <div class="input-group-append">
                                          <button class="btn btn-success" type="submit">Search</button>
                                        </div>
                                      </div>
                                    
                                </form> 
                                @can('add_material_product')
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                        Add New Store Product
                                    </button>
                                    {{-- form --}}
                                    <div class="modal" id="myModal">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                    
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                            <h4 class="modal-title">Add New Store Product</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                    
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <form action="{{route('admin.product.material_store')}}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                      <label for="email">Name: <span class="text-danger">*</span> </label>
                                                      <input type="text" class="form-control" placeholder="Enter name" id="name" required value="{{old('name')}}" name="name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="">Product Code: <span class="text-danger">*</span> </label>
                                                        
                                                        <input required type="text" class="form-control" name="code" placeholder="Code">
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="pwd">Initial Quantity: <span class="text-danger">*</span> </label>
                                                      <input required type="number" class="form-control" placeholder="Enter quantity" id="pwd" name="quantity" value="{{ old('quantity') }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="">Unit:</label>
                                                        <select class="form-control" name="unit">
                                                            <option value="">Select</option>
                                                            <option value="1">KG</option>
                                                            <option value="2">MT</option>
                                                            <option value="3">Nos</option>
                                                            <option value="4">Pcs</option>
                                                            <option value="5">W</option>
                                                            <option value="6">M</option>
                                                            <option value="7">Sch</option>
                                                            <option value="8">Set</option>
                                                            <option value="9">PKT</option>
                                                            <option value="10">Sheet</option>
                                                            <option value="11">Pec</option>
                                                            <option value="12">Book</option>
                                                            <option value="13">Box</option>
                                                            <option value="14">Packet</option>
                                                            <option value="15">CFT</option>
                                                            <option value="16">Piss</option>
                                                            <option value="17">Fit</option>
                                                            <option value="18">SQ. mtr</option>
                                                            <option value="19">LBS</option>
                                                            <option value="20">MTR</option>
                                                            <option value="21">Feet</option>
                                                            <option value="22">LTR</option>
                                                            <option value="23">Gallon</option>
                                                            <option value="24">GRW</option>
                                                            <option value="25">FT</option>
                                                            <option value="26">Roll</option>
                                                            <option value="27">POT</option>
                                                            <option value="28">Bottle</option>
                                                            <option value="29">Cor</option>
                                                            <option value="30">Coil</option>
                                                            <option value="31">Yds</option>
                                                            <option value="32">Pair</option>
                                                            <option value="33">MTS</option>
                                                            <option value="34">RFT</option>
                                                            <option value="35">Pound</option>
                                                            <option value="36">Gram</option>
                                                            <option value="37">Cey</option>

                                                        </select>
                                                    </div>

                                                    
                                                    
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </form>
                                            </div>
                                    
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                    
                                        </div>
                                        </div>
                                    </div>
                                    {{-- form --}}

                                @endcan
                                                               
                                
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="table-responsive ajax-data-container pt-3">
                                @include('backend.admin.product.ajax.material_tableBody')                                    
                            </div>
                            {{$products->appends($_GET)->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection