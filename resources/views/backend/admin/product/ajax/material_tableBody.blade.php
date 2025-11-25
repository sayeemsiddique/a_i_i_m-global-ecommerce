@php
    $unit_types = array(
        [
            'id' => 1,
            'name' => 'KG'
        ],
        [
            'id' => 2,
            'name' => 'M.T'
        ],
        [
            'id' => 3,
            'name' => 'Nos'
        ],
        [
            'id' => 4,
            'name' => 'Pcs'
        ],
        [
            'id' => 5,
            'name' => 'W'
        ],
        [
            'id' => 6,
            'name' => 'M'
        ],
        [
            'id' => 7,
            'name' => 'Sch'
        ],
        [
            'id' => 8,
            'name' => 'Set'
        ],
        [
            'id' => 9,
            'name' => 'PKT'
        ],
        [
            'id' => 10,
            'name' => 'Sheet'
        ],
        [
            'id' => 11,
            'name' => 'Pec'
        ],
        [
            'id' => 12,
            'name' => 'Book'
        ],
        [
            'id' => 13,
            'name' => 'Box'
        ],
        [
            'id' => 14,
            'name' => 'Packet'
        ],
        [
            'id' => 15,
            'name' => 'CFT'
        ],
        [
            'id' => 16,
            'name' => 'Piss'
        ],
        [
            'id' => 17,
            'name' => 'Fit'
        ],
        [
            'id' => 18,
            'name' => 'SQ. mtr'
        ],
        [
            'id' => 19,
            'name' => 'LBS'
        ],
        [
            'id' => 20,
            'name' => 'MTR'
        ],
        [
            'id' => 21,
            'name' => 'Feet'
        ],
        [
            'id' => 22,
            'name' => 'LTR'
        ],
        [
            'id' => 23,
            'name' => 'Gallon'
        ],
        [
            'id' => 24,
            'name' => 'GRW'
        ],
        [
            'id' => 25,
            'name' => 'FT'
        ],
        [
            'id' => 26,
            'name' => 'Roll'
        ],
        [
            'id' => 27,
            'name' => 'POT'
        ],
        [
            'id' => 28,
            'name' => 'Bottle'
        ],
        [
            'id' => 29,
            'name' => 'Cor'
        ],
        [
            'id' => 30,
            'name' => 'Coil'
        ],
        [
            'id' => 31,
            'name' => 'Yds'
        ],
        [
            'id' => 32,
            'name' => 'Pair'
        ],
        [
            'id' => 33,
            'name' => 'MTS'
        ],
        [
            'id' => 34,
            'name' => 'RFT'
        ],
        [
            'id' => 35,
            'name' => 'Pound'
        ],
        [
            'id' => 36,
            'name' => 'Gram'
        ],
        [
            'id' => 37,
            'name' => 'Cey'
        ],
    );
@endphp
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Product Name</th>
            <th>Code</th>
            <th>Unit</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($products->count() > 0)
        @php
            $i = (($products->currentPage() - 1) * $products->perPage() + 1);
        @endphp
            @foreach ($products as $product)
                <tr>
                    <td>
                        {{$i}}
                    </td>
                    <td align="left">
                        {{$product->name}}
                    </td>
                    <td align="center">
                        {{$product->code}}
                    </td>
                    <td align="center">
                        @foreach ($unit_types as $unit_type)
                            @if ($unit_type['id'] == $product->unit)
                                {{$unit_type['name']}}
                            @endif
                        @endforeach
                    </td>

                    <td>
                        @if ($product->status == 1)
                            <span class="label label-lg font-weight-bold label-light-success label-inline">Active</span>
                        @else
                            <span class="label label-lg font-weight-bold label-light-danger label-inline">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @can('view_material_product')
                            <a href="{{route('admin.product.show', $product->id)}}" class="btn btn-outline btn-success btn-sm btn-rounded p-1" title="View">
                                <i class="la la-eye p-0 text-white"></i>
                            </a>
                        @endcan
                        
                        @can('edit_material_product')
                            <button type="button" class="btn btn-outline btn-info btn-sm btn-rounded p-1" data-toggle="modal" data-target="#edit_product{{$product->id}}">
                                <i class="la la-edit p-0 text-white"></i>
                            </button>

                            <div class="modal" id="edit_product{{$product->id}}">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                              
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">Edit {{$product->name}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                              
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <form class="text-left" action="{{route('admin.product.material_update', $product->id)}}" method="post">
                                            @csrf
                                            <div class="form-group">
                                              <label for="email">Name: <span class="text-danger">*</span> </label>
                                              <input type="text" class="form-control" placeholder="Enter name" id="name" required value="{{$product->name}}" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label class="">Product Code: <span class="text-danger">*</span> </label>
                                                
                                                <input required type="text" class="form-control" name="code" placeholder="Code" value="{{$product->code}}">
                                            </div>
                                            <div class="form-group">
                                              <label for="pwd">Initial Quantity: <span class="text-danger">*</span> </label>
                                              <input type="number" class="form-control" placeholder="Enter quantity" id="pwd" name="quantity" value="{{ number_format($product->quantity) }}">
                                            </div>

                                            <div class="form-group">
                                                <label class="">Unit:</label>
                                                <select class="form-control" name="unit">
                                                    <option value="">Select</option>
                                                    <option @if($product->unit == 1) selected @endif value="1">KG</option>
                                                    <option @if($product->unit == 2) selected @endif value="2">MT</option>
                                                    <option @if($product->unit == 3) selected @endif value="3">Nos</option>
                                                    <option @if($product->unit == 4) selected @endif value="4">Pcs</option>
                                                    <option @if($product->unit == 5) selected @endif value="5">W</option>
                                                    <option @if($product->unit == 6) selected @endif value="6">M</option>
                                                    <option @if($product->unit == 7) selected @endif value="7">Sch</option>
                                                    <option @if($product->unit == 8) selected @endif value="8">Set</option>
                                                    <option @if($product->unit == 9) selected @endif value="9">PKT</option>
                                                    <option @if($product->unit == 10) selected @endif value="10">Sheet</option>
                                                    <option @if($product->unit == 11) selected @endif value="11">Pec</option>
                                                    <option @if($product->unit == 12) selected @endif value="12">Book</option>
                                                    <option @if($product->unit == 13) selected @endif value="13">Box</option>
                                                    <option @if($product->unit == 14) selected @endif value="14">Packet</option>
                                                    <option @if($product->unit == 15) selected @endif value="15">CFT</option>
                                                    <option @if($product->unit == 16) selected @endif value="16">Piss</option>
                                                    <option @if($product->unit == 17) selected @endif value="17">Fit</option>
                                                    <option @if($product->unit == 18) selected @endif value="18">SQ. mtr</option>
                                                    <option @if($product->unit == 19) selected @endif value="19">LBS</option>
                                                    <option @if($product->unit == 20) selected @endif value="20">MTR</option>
                                                    <option @if($product->unit == 21) selected @endif value="21">Feet</option>
                                                    <option @if($product->unit == 22) selected @endif value="22">LTR</option>
                                                    <option @if($product->unit == 23) selected @endif value="23">Gallon</option>
                                                    <option @if($product->unit == 24) selected @endif value="24">GRW</option>
                                                    <option @if($product->unit == 25) selected @endif value="25">FT</option>
                                                    <option @if($product->unit == 26) selected @endif value="26">Roll</option>
                                                    <option @if($product->unit == 27) selected @endif value="27">POT</option>
                                                    <option @if($product->unit == 28) selected @endif value="28">Bottle</option>
                                                    <option @if($product->unit == 29) selected @endif value="29">Cor</option>
                                                    <option @if($product->unit == 30) selected @endif value="30">Coil</option>
                                                    <option @if($product->unit == 31) selected @endif value="31">Yds</option>
                                                    <option @if($product->unit == 32) selected @endif value="32">Pair</option>
                                                    <option @if($product->unit == 33) selected @endif value="33">MTS</option>
                                                    <option @if($product->unit == 34) selected @endif value="34">RFT</option>
                                                    <option @if($product->unit == 35) selected @endif value="35">Pound</option>
                                                    <option @if($product->unit == 36) selected @endif value="36">Gram</option>
                                                    <option @if($product->unit == 37) selected @endif value="37">Cey</option>
                                                    
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

                            {{-- <a href="{{route('admin.product.edit', $product->id)}}" class="btn btn-outline btn-info btn-sm btn-rounded p-1" title="Edit">
                                <i class="la la-edit p-0 text-white"></i>
                            </a> --}}
                        @endcan

                        @can('delete_material_product')
                            
                            <button class="btn btn-outline btn-danger btn-sm btn-rounded p-1 delete" title="Inactive" data-id="{{ $product->id }}">
                                    <i class="la la-trash p-0 text-white"></i>
                            </button>
                            
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

@push('stackScript')
    <script> 
        $(".delete").click(function(e) {

            var data_id = $(this).attr("data-id");
            var url =  '<a href="{{route("admin.product.delete",":id")}}" class="swal2-confirm swal2-styled" title="Delete">Confirm</a>';
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
@endpush