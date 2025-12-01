<?php
require_once 'token_class.php';
header('Content-Type: application/json; charset=utf-8');
$site = 'verify_user';
$token = new ApiToken();
// CSRF-Token validieren
$headers = getallheaders();
if (!isset($headers['X-CSRF-Token']) || $headers['X-CSRF-Token'] !== $token->getApiTokenToSite($site, 'AUTH')) {
    http_response_code(403);
    echo json_encode([
        'error' => true,
        'code' => 'INVALID_CSRF',
        'message' => 'Ungültige Anfrage - CSRF-Token fehlt oder ist ungültig'
    ]);
    exit;
}

// Request-Source validieren (optional)
if (!isset($headers['X-Request-Source']) || $headers['X-Request-Source'] !== 'SELF') {
    http_response_code(403);
    echo json_encode([
        'error' => true,
        'code' => 'INVALID_SOURCE',
        'message' => 'Ungültige Anfrage-Quelle'
    ]);
    exit;
}

$err_script = 0;

$ausbilder_ID = isset($_POST['ausbilder_id']) ? trim($_POST['ausbilder_id']) : '';

// Input-Check
if ($ausbilder_ID === '') {
    $err_script = 1;
}
// prüfe ob nur zahlen verwendet wurden
if (!preg_match('/^[0-9]+$/', $ausbilder_ID)) {
    $err_script = 2;
}
//prüfen ob zwischen 3 und 5 zeichen lang
$length = strlen($ausbilder_ID);
if ($length < 3 || $length > 5) {
    $err_script = 3;
}
//Token generieren
if($err_script === 0){
    try {
        /*hier token Klasse einbinden diese Klasse checkt auf DB eintrag wenn user vorhanden dann wird einmal token generiert und an hinterlegte E-mail Adresse gesendet
            //Check ob in db vorhanden
            //prepare connection to db wegen sql injection
            $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name AND vorname = :vorname");
            $stmt->execute(['name' => $name, 'vorname' => $vorname]);
            $user = $stmt->fetch();
            if ($user === false) {
                //user nicht gefunden
                //aus sicherheitsgründen wird nur angezeigt das "Wenn Sie als User angelegt sind wird eine E-mail mit dem Einmaltoken an ihre hinterlegte E-mail Adresse gesendet"
            }
        $token = bin2hex(random_bytes(16)); // Generieren eines zufälligen Tokens
        */
        $token = bin2hex(random_bytes(16)); // Generieren eines zufälligen Tokens
        } catch (Exception $e) {
        $err_script = 4;
    }
}
//wenn kein fehler aufgetreten ist geben wir token message zurück
if ($err_script === 0) {
    $response = [
        'error' => false,
        'code' => $err_script,
        'message' => 'Es wurde ein Einmaltoken an Ihre hinterlegte E-mail Adresse gesendet.<br> Bitte prüfen Sie Ihren Posteingang.',
    ];
    
}else{
    // Fehlerbehandlung je nach Fehlercode
    if($err_script===1){    //fehlende parameter
        http_response_code(400);
        $response = [
            'error' => true,
            'code' => $err_script,
            'message' => 'Ausbilder ID darf nicht leer sein.'
        ];
    }else if($err_script===2){  //ungültige zeichen im namen
        http_response_code(400);
        $response = [
            'error' => true,
            'code' => $err_script,
            'message' => 'Ungültige Zeichen in der Ausbilder ID.'
        ];
    }else if ($err_script===3) {    //ungültige länge
        http_response_code(400);
        $response = [
            'error' => true,
            'code' => $err_script,
            'message' => 'Ungültige Länge der Ausbilder ID.'
        ];
    }    else if ($err_script===4) {
        http_response_code(500);
        $response = [
            'error' => true,
            'code' => $err_script,
            'message' => 'Serverfehler: Anfrage konnte nicht verarbeitet werden.'
        ];
    }
    //Error Logging hier einfügen 
    
}

echo json_encode($response);
?>