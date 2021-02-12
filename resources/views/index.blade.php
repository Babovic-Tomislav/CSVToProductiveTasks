@routes
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script  type="text/javascript" src="{{ mix('js/app.js')}}"></script>


<form action="{{route('uploadTasks')}}" method="post" enctype="multipart/form-data" id ="form">
    @csrf
    <input type="text" name="authToken" id="authToken">

    <h4>Project</h4>
    <select name="project" id="project" >
    </select>

    <h4>Task list</h4>
    <select name="taskLists" id="taskLists">
    </select>

    <br><br>

    <h4 for="csv_file">Pick csv file</h4>
    <input type="file" name="csvFile" id="csv">
    <br><br>

    <input type="submit">
</form>