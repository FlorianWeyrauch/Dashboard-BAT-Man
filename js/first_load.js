async function first_load() {
    check_token()
}
function check_token() {
    const token = localStorage.getItem("auth_token");
    if (token) {
        //TODO: Token ist vorhanden, Token check aufrufen
        // schauen ob es 5 minuten token ist
        // Wenn ja, dann anzeige Checkbox (ob Longtime Token 4 Wochen gewünscht ist) an und Vorname und Nachname weg dafür Name und Vorname einblenden
        // Wenn es Longterm Token ist, dann
        // Direkt weiter leiten zu dashboard
        // TODO: Authentifiziere den Benutzer mit dem Token
        console.log("Using stored token:", token);
        $.ajax({
            url: "./ajax/verifyUser.php",
            type: "POST",
            headers: {
                'X-CSRF-Token': 'sfdfg55ss5s45dcdsdsfgdg',  // AUTH-Token aus api_token.tok
                'X-Request-Source': 'AUTH'
            },
            success: function (response) {
                console.log("Auth token received:", response);
            }
        });
    } else {
        // Token ist nicht vorhanden, zeige Login-Formular an
        console.log("No token found, showing login form.");
    }
}




//TODO: hier die Weiche einbauem ob token schon in Stroage ist
// Wenn ja, dann benutze den Token aus dem Storage
// Wenn nein, dann Zeige Login Formular an Name Vorname an
//weiterleitung zum self_tok.php um die Userdaten zur Verifizierungsseite (AUTH) zu schicken
//Wenn erfolg erhalte ich den Token und speichere ihn im Storage
//AUTH muss userdaten Prüfen / validieren bei Erfolg E-Mail mit Token (5min gültig) 
//an den Benutzer zurückgeben und mir den Token zurückgeben um Ihn im Storage zu speichern

