<form action="{{route('uploadTasks')}}" method="post" enctype="multipart/form-data">
    @csrf
    @foreach($taskLists as $list)
        <input type="radio" name="taskList" id="{{$list['id']}}" value="{{$list['id']}}"
               @if(old('taskList')==$list['id']) checked @endif>
        <label for="{{$list['id']}}">{{$list['attributes']['name']}}</label><br>
    @endforeach
<br><br>
    <input type="file" name="csv_file" id="csv">
    <input type="submit">
</form>


@if($errors->any())
    <h4 style="color: red">{{$errors->first()}}</h4>
@endif