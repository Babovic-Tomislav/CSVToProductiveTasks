<form action="{{route('uploadTasks')}}" method="post" enctype="multipart/form-data">
    @csrf
    @foreach($taskLists as $list)
        <input type="radio" name="taskList" id="{{$list['id']}}" value="{{$list['attributes']['name']}}">
        <label for="{{$list['id']}}">{{$list['attributes']['name']}}</label><br>
    @endforeach
<br><br>
    <input type="file" name="csv" id="csv">
    <input type="submit">
</form>
