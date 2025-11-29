$("#GetToken").on("click", function () {
    // get name and vorname values
    var name = $("#name").val();
    var vorname = $("#vorname").val();

    // send ajax request to get_token.php
    $.ajax({
        url: "./ajax/token.php",
        type: "POST",
        dataType: "json", // erwartetes JSON vom Server
        data: {
            name: name,
            vorname: vorname
        },
        success: function (response) {
            //
            
            console.log('AJAX success:', response);
            if (!response) {
                $("#tokenResult").text('Ihre Antwort konnte vom Server nicht verarbeitet werden.');
                return;
            }
            // Response-Fehler true ist 
            if (response.error) {
                //message übergeben wenn nicht Standardnachricht
                var message = response.message || 'Ein Fehler ist aufgetreten';
                $("#tokenResult").text(message+''+response.code);
                console.log(response.code);
                return;
            }else{

                // Normaler Erfolgsfall
               
                $("#tokenResult").text(message+''+response.code);
                return;
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);

            // Versuche JSON-Fehlerkörper zu parsen
            var body = xhr.responseJSON;
            if (!body) {
                try {
                    body = JSON.parse(xhr.responseText || '{}');
                } catch (e) {
                    body = null;
                }
            }

            if (body && body.code) {
                var userMsg = body.message || 'Serverfehler';
                switch (body.code) {
                    case 'MISSING_PARAMS':
                        userMsg = 'Bitte Name oder Vorname angeben.';
                        break;
                    case 'TOKEN_GENERATION_FAILED':
                        userMsg = 'Token-Generierung fehlgeschlagen. Versuchen Sie es später.';
                        break;
                }
                $("#tokenResult").text(userMsg);
            } else {
                // Fallback: generische Fehlermeldung
                console.log('Server response:', xhr.responseText);
                $("#tokenResult").text('Fehler beim Abrufen des Tokens: ' + status + ' ' + error);
            }
        },
        complete: function () {
            console.log('AJAX complete');
        }
    });
});
function get_token() {
    $.ajax({
        url: "./ajax/verify_user.php",
        type: "POST",
        headers: {
            'X-CSRF-Token': 'sfdfg55ss5s45dcdsdsfgdg',  // AUTH-Token aus api_token.tok
            'X-Request-Source': 'AUTH'
        },
        success: function (response) {
            console.log("Auth token received:", response);
        },
        error: function (xhr, status, error) {
            console.error("Error getting auth token:", error);
            console.error("Response:", xhr.responseText);
        }
    });
}
