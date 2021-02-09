@foreach($projects as $project)
    <a href="{{route('taskLists', ['project_id' => $project['id']])}}" ><li>{{$project['attributes']['name']}}</li></a>
@endforeach
