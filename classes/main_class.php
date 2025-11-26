<?php
    require_once 'session.php';
    class Main{
        
        public function __construct() {
            // Initialization code here
            $this->session = new MySessionHandler();
            
        }

    }