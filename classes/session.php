<?php

class MySessionHandler {
    private $session_start;
    private $ip_address;
    private $user_agent;
    private $domain;
    private $check_secure=true;
    private $do_update;
    private $session_cookie_settings = [];
    
    public function __construct() {
       //Werte initialisieren
        $this->session_start = false;
        $this->do_update = false;
        $this->ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        $this->domain = $_SERVER['HTTP_HOST'] ?? 'unknown';

        $this->session_cookie_settings = [
            'name' => 'SESSION_BAT',
            'lifetime' => 60*60*24*30, // 30 Tage
            'use_strict_mode' => true,
            'path' => '/',
            'domain' => $this->domain,
            'secure' => $this->check_secure,
            'httponly' => $this->check_secure,
            'samesite' => 'Lax'
        ];

        // Session-Name und Cookie-Parameter setzen (muss VOR session_start() passieren)
        session_name($this->session_cookie_settings['name']);
        $this->SetCookieNew();
        
        // Session starten (lädt existierende oder erstellt neue)
        session_start();
        
        // Prüfen, ob die Session bereits initialisiert wurde (anhand von 'created')
        $this->session_start = isset($_SESSION['created']);

        //Wenn session bereits initialisiert wurde
        if ($this->session_start) {
            $this->do_update=true;
            if($this->check_secure){
                // Überprüfen, ob die Sitzung sicher ist
                if ($this->IsSecureSession()) {
                    
                    // bestehende sichere Sitzung aktualisieren (last_activity, evtl. Rotation)
                } else {
                    $this->do_update=false;
                    // Unsichere Sitzung erkannt - Sitzung beenden und neu starten
                    $this->SessionKill();
                    $this->StartSecureSession();
                }
            }
            if($this->do_update){
                
                $this->UpdateSecureSession();
            }
        }else{
            // Keine Sitzung vorhanden
            // Sitzung starten
            $this->StartSecureSession();
        }
    }




    /**
     * Prüft, ob eine sichere Sitzung existiert.
     * Eine Sitzung gilt als sicher, wenn das Flag 'secure_session' und 'user_id' gesetzt sind
     * und der Fingerabdruck (User-Agent) übereinstimmt.
     * @return bool
     */
    public function IsSecureSession() {
        $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
        if (!$isSecure) {
            return false;
        }
        
        if (session_status() !== PHP_SESSION_ACTIVE) {
            return false;
        }
        
        // Optional: Browser, IP-Adresse, user_id oder andere Merkmale zur weiteren Absicherung prüfen
        return true;
    }
    
    /**
     * Startet eine Sitzung mit sicheren Cookie-Parametern, falls noch nicht gestartet.
     * Gibt die Session-ID zurück.
     * @return string
     */
    public function StartSecureSession(array $data = []) {
        // Session wurde bereits im Konstruktor gestartet, nur Daten setzen
        // data in $_SESSION schreiben
        if (!empty($data)) {
            $_SESSION['data'] = $data;
        } else {
            $_SESSION['data'] = [];
        }
        // Standardwerte setzen
        $_SESSION['user_id'] = $data['data']['user_id'] ?? 'GUEST';
        $_SESSION['secure_session'] = $this->session_cookie_settings['secure'];
        $_SESSION['created'] = time();
        $_SESSION['last_activity'] = time();
        $_SESSION['fingerprint'] = hash('sha256', $_SERVER['HTTP_USER_AGENT'] ?? '');
        return session_id();
    }

    private function SetCookieNew() {
        if(PHP_VERSION_ID < 70300) {
            session_set_cookie_params($this->session_cookie_settings['lifetime'], '/; samesite='.$this->session_cookie_settings['samesite'], $_SERVER['HTTP_HOST'], $this->session_cookie_settings['secure'], $this->session_cookie_settings['httponly']);
        } else {
            session_set_cookie_params([
                'lifetime' => $this->session_cookie_settings['lifetime'],
                'path' => $this->session_cookie_settings['path'],
                'domain' => $this->session_cookie_settings['domain'],
                'secure' => $this->session_cookie_settings['secure'],
                'httponly' => $this->session_cookie_settings['secure'],
                'samesite' => 'Lax'
            ]);
        }
    }

    /**
    * Aktualisiert eine bestehende sichere Sitzung: aktualisiert 'last_activity', fügt
    * übergebene Daten zusammen und rotiert optional die Session-ID nach einem konfigurierbaren Intervall.
    * @param array $data
    * @param int $rotateAfterSeconds
    * @return bool
     */
    public function UpdateSecureSession(array $data = [], $rotateAfterSeconds = 1800) {
        // 'last_activity' aktualisieren
        $_SESSION['last_activity'] = time();
        // übergebene Daten zusammenfügen
        // optional: Validierung oder Bereinigung der Daten
        if (!empty($data)) {
            if (empty($_SESSION['data']) || !is_array($_SESSION['data'])) {
                $_SESSION['data'] = [];
            }
            $_SESSION['data'] = array_merge($_SESSION['data'], $data);
        }
        // Session-ID periodisch rotieren, um das Risiko zu verringern
        if (!empty($_SESSION['created']) && (time() - $_SESSION['created']) > $rotateAfterSeconds) {
            // Session-ID rotiert 
            session_regenerate_id(true);
            $_SESSION['created'] = time();
           
        } 
        return true;
    }

    /**
     * Sitzung sicher beenden.
     */
    public function SessionKill(){
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Alle Session-Variablen zurücksetzen
            $_SESSION = [];

            // Session-Cookie löschen
            if (ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params['path'] ?? '/', $params['domain'] ?? '',
                    $params['secure'] ?? false, $params['httponly'] ?? true
                );
            }
            session_unset();
            session_destroy();
        }
    }
}
