<?php
    require_once __DIR__ . '/../classes/session_class.php'; 
    $session = new MySessionHandler();
    if (empty($_SESSION['user_id']) || $_SESSION['user_id'] === 'GUEST') {
        header("Location: ../index.php");
        exit;
    }else{
        //Zugriff
    }
    //print_r($_SESSION);
?>