<option value="" selected>Select..</option>
@foreach($options as $o)
    <option value="{{$o->id}}">{{$o->{'name_ar'} }}</option>
@endforeach
