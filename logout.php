<?php 

    // connessione al db
    require("core/common.php"); 
     
    unset($_SESSION['user']);
    
    header("Location: login.php"); 
    exit;