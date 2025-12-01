$("#auth_user").on("click", function () {
    //id loading sichtbar machen
    $("#loading").show();
    // get ausbilder_id value
    let aus_id = $("#ausbilder_id").val();
    let error=false;
    let errorMessage='';
    // check if aus_id is empty
    if (!aus_id) {
        errorMessage='Bitte Ausbilder ID angeben.';
        error=true;
    }
    //check if aus_id is numeric
    if (isNaN(aus_id)) {
        errorMessage='Ausbilder ID muss eine Zahl sein.';
        error=true;
    }
    //check if aus_id is <= 5 and > 3 digits
    if (aus_id.length < 3 || aus_id.length > 5) {
        errorMessage='Ausbilder ID muss zwischen 3 und 5 Ziffern lang sein.';
        error=true;
    }
    if(error){
        $("#loading").hide();
        $("#authResult").text(errorMessage);
    }else{
        // send ajax request to get_token.php
        $.ajax({
            url: "ajax/verify_user.php",
            type: "POST",
            dataType: "json", // erwartetes JSON vom Server
            headers: {
                'X-CSRF-Token': 'sfdfg55ss5s45dcdsdsfgdg',  // AUTH-Token aus api_token.tok
                'X-Request-Source': 'AUTH'
            },
            data: {
                ausbilder_id: aus_id
            },
            success: function (response) {
                       
                console.log('AJAX success:', response);
                if (!response) {
                    $("#authResult").text('Ihre Antwort konnte vom Server nicht verarbeitet werden.');
                    return;
                }
                // Response-Fehler true ist 
                if (response.error) {
                    //message übergeben wenn nicht Standardnachricht
                    var message = response.message || 'Ein Fehler ist aufgetreten';
                    $("#authResult").text(message + '' + response.code);
                    console.log(response.code);
                    return;
                }else{
                    // Normaler Erfolgsfall 
                    var message = 'Erfolgreich email mit Token versendet. ';
                    $("#authResult").text(message + '' + response.code);
                    return;
                }
            },
            error: function (xhr, status, error) {
                console.error("Response:", xhr.responseText);
            },
            complete: function () {
                $("#loading").hide();
                console.log('AJAX complete');
            }
        });
    };
});