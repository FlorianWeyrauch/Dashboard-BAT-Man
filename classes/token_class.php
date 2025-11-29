<?php 
    class Token {
        private $all_api_tokens= [];
        private $self_token = [];
        private $auth_token = [];

        public function __construct($token, $expiry) {
            $this->all_api_tokens = $this->AlleApiTokens();
            $this->self_token = $this->getApiTokenToSite('get_one_time_token', 'SELF');
            $this->auth_token = $this->getApiTokenToSite('get_one_time_token', 'AUTH');
        }

        private function AlleApiTokens() {
            // Code to retrieve all API tokens
            //api_token.tok einlesen und in array speichern
            $file_path = __DIR__ . '/../assets/api/api_token.tok';
            if (file_exists($file_path)) {
                $tokens = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $this->all_api_tokens = array_map('trim', $tokens);
            }
            return $this->all_api_tokens;
        }

        public function getApiTokenToSite($site, $wer) {
            // Suche nach dem API-Token für die angegebene Site und den angegebenen Wer
            // Token-Format: api || token || use wer || status
            // erste Zeile überspringen (Überschriften)

            $first_line = true;
            foreach ($this->all_api_tokens as $line) {
                if ($first_line) {
                    $first_line = false;
                    continue;
                }
                $parts = explode('||', $line);
                if (count($parts) === 4) {
                    $token['api'] = trim($parts[0]);
                    $token['token'] = trim($parts[1]);
                    $token['use_wer'] = trim($parts[2]);
                    $token['status'] = trim($parts[3]);
                    if ($token['api'] === $site && $token['use_wer'] === $wer && $token['status'] === 'active') {
                        return $token;
                    }
                }
            }
            return null;
        }
        public function verifiToken($site, $wer) {
            // Alle ApiToken prüfen
            $token_valid= false;
            $this->all_api_tokens = $this->AlleApiTokens();
            foreach ($this->all_api_tokens as $token) {
                if ($token['api'] === $site && $token['use_wer'] === $wer && $token['status'] === 'active') {
                    $token_valid= true;
                }
            }
            return $token_valid;
        }
    }
?>