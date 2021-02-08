@foreach($projects as $project)
    <a href="{{route('taskList')}}" ><li>{{$project['attributes']['name']}}</li></a>
@endforeach
