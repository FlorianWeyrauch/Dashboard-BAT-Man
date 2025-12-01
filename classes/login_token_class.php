<?php
class LoginToken {
    private $token;
    private $user_id;
    private $created_at;
    private $ip_address;
    private $user_agent;

    public function __construct() {
        $this->user_id = $_SESSION['user_id'] ?? 'GUEST';
        $this->created_at = time();
        $this->ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    }
    private function GenerateLoginToken() {
        //TODO: Anforderungen Für login token.
        //es soll ein Token generiert werden der verschlüsselt und auch wieder entschlüsselt werden kann.
        // Der Token enthält folgende Informationen:
        // User ID
        // Erstellungszeitpunkt
        // ip Adresse des Users
        // User Agent des Users
        // Der 1. Token soll eine Gültigkeit von 5 Minuten haben.
        // Der 1. Token soll an die hinterlegte E-mail Adresse des Users gesendet werden.
        // Der 1. Token soll nach erfolgreicher Verifizierung auf den im Adminbereich festgelegten Zeitraum verlängert werden können. (Standard 4 Wochen)
        // Der verlängerte Token soll im localStorage des Browsers gespeichert werden.
        
        // Tokendaten in ein Array packen
        $token_data = [
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent
        ];
        // Token-Daten in JSON kodieren
        $token_json = json_encode($token_data);
        // Token verschlüsseln (Beispiel mit base64, in der Praxis sollte eine stärkere Verschlüsselung verwendet werden)
        // Verschlüsseln
        $key = sodium_crypto_secretbox_keygen(); // 256-bit
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $encrypted = sodium_crypto_secretbox($token_json, $nonce, $key);
        $result = base64_encode($nonce . $encrypted);
        
        // Entschlüsseln
        $decoded = base64_decode($result);
        $nonce = substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $encrypted = substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $decrypted = sodium_crypto_secretbox_open($encrypted, $nonce, $key);
        $token_array = json_decode($decrypted, true);
    }

    private function VerifyLoginToken($token) {
        //TODO: Anforderungen Für login token verifizierung.
        // Der Token muss entschlüsselt werden können.
        // Die folgenden Informationen müssen überprüft werden:
        // User ID
        // Erstellungszeitpunkt
        // ip Adresse des Users
        // User Agent des Users
        // Der Token muss innerhalb der Gültigkeitsdauer liegen.
        // Wenn der Token gültig ist, kann er verwendet werden.
    }

}
?>