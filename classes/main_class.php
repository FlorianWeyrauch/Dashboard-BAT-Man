<?php
    require_once 'session_class.php';

    class Main{
        private MySessionHandler  $session;
        public function __construct(MySessionHandler $session) {
            $this->session = $session;
            
        }

        
    }