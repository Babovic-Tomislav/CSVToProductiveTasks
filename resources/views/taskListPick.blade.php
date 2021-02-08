@foreach($taskList as $list)
    <a href="{{route('uploadCSV')}}" ><li>{{$list['attributes']['name']}}</li></a>
@endforeach
