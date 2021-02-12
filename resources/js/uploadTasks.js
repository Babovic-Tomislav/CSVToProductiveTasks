$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    $("#form").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: route('uploadTasks'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            error: function (err) {
                if (err.status == 400) { // when status code is 422, it's a validation issue
                    alert(err.responseText);
                }
            },
            success: function () {
                alert("Successfully uploaded tasks on productive");
            }
        });
    });
});