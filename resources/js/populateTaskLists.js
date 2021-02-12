$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $('#project').on('change', function (e) {
        var authToken = document.getElementById("authToken").value;
        var projectId = e.target.value;
        $.ajax({
            url: route('getTaskLists', {projectId: projectId}),
            type: "POST",
            data: {
                'authToken': authToken
            }
            ,
            success: function (data) {
                $('#taskLists').empty();
                $('#taskLists').append('<option value="Dummy">Choose task list</option>');
                $.each(data.taskLists, function (index, taskList) {

                    $('#taskLists').append('<option value="' + taskList['id'] + '">' + taskList['attributes']['name'] + '</option>');
                })
            }
        })
    });
});
