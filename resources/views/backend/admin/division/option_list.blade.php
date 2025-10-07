<option value="">{{__('messages.Select Division')}}</option>
@foreach ($divisions as $division)
    <option value="{{$division->id}}">{{$division->name}}</option>
@endforeach