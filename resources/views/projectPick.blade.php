<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<form action="{{route('uploadTasks')}}" method="post" enctype="multipart/form-data">
    @csrf
    <h4>Project</h4>
    <select name="project" id="project">
        <option selected>Select category</option>
        @foreach($projects as $project)
            <option value="{{ $project['id'] }}">{{ $project['attributes']['name'] }}</option>
        @endforeach
    </select>
    <h4>Task list</h4>
    <select name="taskLists" id="taskLists">
    </select>
    <br><br>
    <h4 for="csv_file">Pick csv file</h4>
    <input type="file" name="csv_file" id="csv">
    <br><br>
    <input type="submit">
</form>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        $('#project').on('change', function (e) {
            var project_id = e.target.value;
            $.ajax({
                url: "{{route('taskLists', ['project_id' => $project['id']])}}",
                type: "POST",
                data: {
                    project_id: project_id
                },
                success: function (data) {
                    $('#taskLists').empty();
                    $.each(data.taskLists, function (index, taskList) {
                        $('#taskLists').append('<option value="' + taskList['id'] + '">' + taskList['attributes']['name'] + '</option>');
                    })
                }
            })
        });
    });
</script>