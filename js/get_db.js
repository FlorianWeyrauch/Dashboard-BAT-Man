// get name and vorname values
    var name = $("#name").val();
    var vorname = $("#vorname").val();

    // send ajax request to get_token.php
    $.ajax({
        url: "./ajax/get_db_data_courses.php",
        type: "POST",
        dataType: "json", // erwartetes JSON vom Server
        data: {
            prod: false
        },
        success: function (response) {
            //let courses = response.courses;
            console.log('AJAX success:', JSON.parse(response));
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
        },
        complete: function () {
            console.log('AJAX complete');
        }
    });