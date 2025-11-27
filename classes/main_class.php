<?php
    require_once 'session.php';
    class Main{
        private $all_api_tokens= [];
        
        public function __construct() {
            // Initialization code here
            $this->session = new MySessionHandler();
            $this->all_api_tokens = $this->AlleApiTokens();
        }

        public function AlleApiTokens() {
            // Code to retrieve all API tokens


        }

    }