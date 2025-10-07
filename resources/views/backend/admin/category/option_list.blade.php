<option value="">Select</option>
@foreach ($categories as $category)
    {{-- @if (count($category->childTreeInfo) > 0) --}}

        <option value="{{$category->id}}">{{$category->name}}</option>

        @foreach ($category->childTreeInfo as $child_category)

            {{-- @if (count($child_category->childTreeInfo) > 0) --}}

                <option value="{{$child_category->id}}"> - {{$child_category->name}}</option>

                @foreach ($child_category->childTreeInfo as $sub_child_category)
                    <option value="{{$sub_child_category->id}}"> -- {{$sub_child_category->name}}</option>
                @endforeach

            {{-- @else
                <option value="{{$child_category->id}}"> - {{$child_category->name}}</option>
            @endif --}}
        @endforeach

    {{-- @else
        <option value="{{$category->id}}">{{$category->name}}</option>
    @endif --}}
@endforeach