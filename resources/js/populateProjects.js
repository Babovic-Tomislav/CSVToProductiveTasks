$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('#authToken').on('change', function (e) {
        var authToken = e.target.value;
        $.ajax({
            url: route('getProjectList'),
            type: "POST",
            data: {
                'authToken': authToken
            }
            ,
            success: function (data) {
                $('#project').empty();
                $('#project').append('<option value="">Choose project</option>');
                $.each(data.projects, function (index, project) {
                    $('#project').append('<option value="' + project['id'] + '">' + project['attributes']['name'] + '</option>');
                })
            },
            error: function (err) {
                if (err.status == 400) { // when status code is 422, it's a validation issue
                    alert(err.responseText);
                }
            }
        })
    });
});
