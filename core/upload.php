<?php
if (isset($_POST['upload']))
  {
    $utente = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
    $user_id = htmlentities($_SESSION['user']['id'], ENT_QUOTES, 'UTF-8');
    $server_dir ="/var/www/html/playlist";
    $dir_musica = $server_dir . "/utenti/". $utente. "/";
    $percorso = $dir_musica . basename($_FILES["fileToUpload"]["name"]);
    $percorso = preg_replace('/\s+/', '_', $percorso);
    $uploadOk = 1;
    $musicFileType = pathinfo($percorso, PATHINFO_EXTENSION);

    if (strlen(trim($_POST['artista'])) == 0 || strlen(trim($_POST['titolo'])) == 0)
      {
        echo '<div class="text-center alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fa fa-ban-circle"></i><strong>Errore! </strong> <a href="#" class="alert-link">Ricarica la pagina e riprova.</a></div>';
        $uploadOk = 0;
      }
    if (file_exists($percorso))
      {
        echo '<div class="text-center alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fa fa-ban-circle"></i><strong>Errore! </strong> <a href="#" class="alert-link">Il file esiste già.</a></div>';
        $uploadOk = 0;
      }
    if ($_FILES["fileToUpload"]["size"] > 100000000)
      {
        echo '<div class="text-center alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fa fa-ban-circle"></i><strong>Errore! </strong> <a href="#" class="alert-link">La dimensione del file supera i limiti consentiti.</a></div>';
        $uploadOk = 0;
      }
    if (preg_match('/[\'^£$%&*()}{@#~?><>,|=+¬-]/', $percorso))
      {
        echo '<div class="text-center alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fa fa-ban-circle"></i><strong>Errore! </strong> <a href="#" class="alert-link">Il file contiene caratteri speciali.</a></div>';
        $uploadOk = 0;
      }
    if ($musicFileType != "mp3")
      {
        echo '<div class="text-center alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <i class="fa fa-ban-circle"></i><strong>Errore! </strong> <a href="#" class="alert-link">Devi caricare un file MP3.</a></div>';
        $uploadOk = 0;
      }
    if ($uploadOk == 0)
      {
      }
    else
      {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $percorso))
          {
            $titolo = $_POST["titolo"];
            $artista = $_POST["artista"];
            $idUtente = $_SESSION['user']['id'];

            $query = "INSERT INTO canzoni (percorso,
                              titolo,
                              artista,
                              idUtente)
                      VALUES ('$percorso',
                              '$titolo',
                              '$artista',
                              '$idUtente')";
            try
              {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
              }
            
            catch(PDOException $ex)
              {
                die("Failed to run query: " . $ex->getMessage());
              }
            echo '<div class="text-center alert alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <i class="fa fa-ban-circle"></i><strong>Ottimo! </strong> <a href="#" class="alert-link">Il tuo file è stato caricato.</a></div>';
          } 
        else
          {
            echo '<div class="text-center alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <i class="fa fa-ban-circle"></i><strong>Errore! </strong> <a href="#" class="alert-link">Si è verificato un errore del server, ricarica la pagina e riprova.</a></div>';
          }
      }
  }
?>