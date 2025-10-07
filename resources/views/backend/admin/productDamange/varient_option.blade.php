<option value="">Select Product Variant</option>
@foreach ($varients as $varient)
<option value="{{$varient->id}}">
    @foreach ($varient->productVarientData as $VarientData)
    {{$VarientData->data_value}} 
    @endforeach
</option>
    
@endforeach
