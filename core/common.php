<?php 

    // variabili per la connessione al db
    $username = "root"; 
    $password = "marelli2010"; 
    $host = "localhost"; 
    $dbname = "login"; 


    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
      
    // per prima cosa viene eseguito il codice nel blocco try. in caso di errori
    // durante l'esecuzione del codice, si passa al blocco catch 
    // http://us2.php.net/manual/en/language.exceptions.php 
    try 
    { 
        // apre la connessione al database utilizzando la libreria PDO
        // http://us2.php.net/manual/en/class.pdo.php 
        $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options); 
    } 
    catch(PDOException $ex) 
    { 
        // se si verifica un errore durante la connessione al db, rimarrà in questo blocco di codice.
        // lo script si fermerà e restituirà un messaggio di errore.
        die("Failed to connect to the database: " . $ex->getMessage()); 
    } 
     
    // cronfigurazioni di PDO per "catturare" errori durante l'esecuzione (db)

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
     
    // http://php.net/manual/en/security.magicquotes.php 
    if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) 
    { 
        function undo_magic_quotes_gpc(&$array) 
        { 
            foreach($array as &$value) 
            { 
                if(is_array($value)) 
                { 
                    undo_magic_quotes_gpc($value); 
                } 
                else 
                { 
                    $value = stripslashes($value); 
                } 
            } 
        } 
     
        undo_magic_quotes_gpc($_POST); 
        undo_magic_quotes_gpc($_GET); 
        undo_magic_quotes_gpc($_COOKIE); 
    } 
     
    // dice al browser che il contenuto è in UTF-8
    header('Content-Type: text/html; charset=utf-8'); 
     
    // Inizializza la sessione. le sessioni sono utilizzate per memorizzare informazioni dei visitatori
    // http://us.php.net/manual/en/book.session.php 
    session_start(); 
