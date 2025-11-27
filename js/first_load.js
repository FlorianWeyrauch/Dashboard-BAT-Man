async function first_load() {
    get_token();
}

function get_token() {
    //schauen ob schon ein Token im lokal Storage ist
    let token = localStorage.getItem('LogToken');
    if (token) {
        // Token ist vorhanden
        // Ajax request um zu validieren
        $.ajax({
            url: "./ajax/validate_token.php",
            type: "POST",
            data: { token: token },
            success: function (response) {
                console.log("Token validation response:", response);
            },
            error: function (xhr, status, error) {
                console.error("Token validation error:", error);
            }
        });

    } else {
        // load view to get a new token
        // Field Vorname und Name anzeigen
        // Get Token button anzeigen
        $("#GetToken").on("click", function () {
            // get name and vorname values
            var name = $("#name").val();
            var vorname = $("#vorname").val();

            // send ajax request to get_token.php
            $.ajax({
                url: "./ajax/get_token.php",
                type: "POST",
                headers: {
                    'X-CSRF-Token': window.CSRF_TOKEN || '',
                    'X-Request-Source': 'dashboard-client'
                },
                data: {
                    name: name,
                    vorname: vorname
                },
                success: function (response) {
                    console.log("Token received:", response);
                    if (response.token) {
                        localStorage.setItem('LogToken', response.token);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error getting token:", error);
                    if (xhr.status === 403) {
                        console.error("CSRF validation failed");
                    }
                }
            });
        });
    }
}