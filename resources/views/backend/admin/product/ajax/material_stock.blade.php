<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Product Name</th>
            <th>Product Code</th>
            
            <th>Stock</th>
            {{-- <th>Action</th> --}}
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
                        <span type="button" style="cursor: pointer;color:blue;" data-toggle="modal" data-target="#stock_details{{$product->id}}">
                            {{$product->name}}
                        </span>
                        
                    </td>

                    <td>{{ $product->code }}</td>

                    <td>
                        @if ($product->has_varient == 1)
                        {{ number_format($product->productStock->sum('quantity'),0)}}

                        <!-- The Modal -->
                        <div class="modal" id="stock_details{{$product->id}}">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h1 class="modal-title">{{$product->name}} Stock Details</h1>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                
                                <table class="table table-bordered table-sm">
                                    
                                    <tbody class="text-left">
                                        @foreach ($product->productStock as $item)
                                        <tr>
                                            <td>
                                                @foreach ($item->varientDataInfo as $varient)
                                                    {{$varient->data_value}} <br>
                                                @endforeach
                                            </td>
                                            <td>Total in stock</td>
                                            <td>{{number_format($item->quantity)}}</td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>

                                  </table>
                                
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                
                            </div>
                            </div>
                        </div>

                        @else
                        {{number_format($product->productSingleStock->quantity ?? 0,0)}}

                        <!-- The Modal -->
                        <div class="modal" id="stock_details{{$product->id}}">
                            <div class="modal-dialog">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h1 class="modal-title">{{$product->name}} Stock Details</h1>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                    <table class="table table-bordered table-sm">
                                        
                                        <tbody class="text-left">
                                          <tr>
                                            <td>Total in stock</td>
                                            <td>{{number_format($product->productSingleStock->quantity ?? 0,2)}}</td>
                                            
                                          </tr>
                                          
                                        </tbody>
                                      </table>
                                    
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                
                            </div>
                            </div>
                        </div>
                        @endif
                    </td>

                    {{-- <td>
                        <a title="Add Stock" class="btn btn-success btn-sm" href="{{route('admin.product.add_stock', $product->id)}}">+</a>
                    </td> --}}

                    
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

<div class="ajax-pagination-area">

    {{$products->appends(['products' =>$products, 'q' => isset($q) ? $q : null,
    ])->links()}}
</div>

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