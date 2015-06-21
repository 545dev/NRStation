<?php

$username = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
$currentdir = getcwd();
$server_dir = "/var/www/html/playlist";
$dir_musica = $server_dir . "/utenti/" . $username . "/";
chdir("$dir_musica");
$filelist = glob("*.mp3");
$userid = htmlentities($_SESSION['user']['id'], ENT_QUOTES, 'UTF-8');
$query_canzone = "SELECT titolo, artista, percorso FROM canzoni WHERE idUtente = :userid";
$query_params = array(':userid' => $userid);

try
{
  $stmt = $db->prepare($query_canzone);
  $result = $stmt->execute($query_params);
}

catch(PDOException $ex)
{
  die("Failed to run query: " . $ex->getMessage());
}

if (empty($filelist))
{
  echo '<div class="text-center alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4><i class="fa fa-bell-alt"></i>Attenzione!</h4>
        <p>Devi caricare almeno una canzone prima di creare una playlist</p></div>';
}
else
{
  foreach($filelist AS $file)
  {
    while ($row = $stmt->fetch())
    {
      $titolo = $row["titolo"];
      $artista = $row["artista"];
      $percorso = $row["percorso"];
      if (is_file($file))
      {
        echo "<tr><td><label class=\"checkbox m-n i-checks\"><input type=\"checkbox\" name=\"checkfiles[]\" value=\"$percorso\"><i></i></label></td>
              <td>$titolo</td><td>$artista</td><td>
              <a href=\"#\" class=\"active\" data-toggle=\"class\"><i class=\"fa fa-check text-success text-active\"></i>
              <i class=\"fa fa-times text-danger text\"></i></a></td></tr>";
      }
    }
  }
}

chdir("$currentdir");

if (isset($_POST['createfile']))
{
  $uploadOk = 1;
  $nomeplay = $_POST['nomeplay'];
  if (!isset($_POST['checkfiles']))
  {
    echo '<div class="text-center alert alert-warning alert-block">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4><i class="fa fa-bell-alt"></i>Attenzione!</h4>
          <p>Scegli le canzoni da aggiungere alla tua playlist</p></div>';
    $uploadOk = 0;
  }

  if (!isset($_REQUEST['nomeplay']) || strlen(trim($_REQUEST['nomeplay'])) == 0)
  {
    echo '<div class="text-center alert alert-warning alert-block">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <h4><i class="fa fa-bell-alt"></i>Attenzione!</h4>
           <p>Inserisci un nome per la tua playlist</p></div>';
    $uploadOk = 0;
  }

  if ($uploadOk == 0)
  {
    echo '<div class="text-center alert alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <i class="fa fa-ban-circle"></i><strong>Errore! &nbsp </strong> <a href="#" class="alert-link"> Non è stato possibile creare la playlist</a></div>';
  }
  else
  {
    $fh = fopen($dir_musica . $nomeplay . '.m3u', 'w') or die("Errore durante la creazione della playlist, ricarica la pagina e riprova");
    foreach($_POST['checkfiles'] AS $selectedfile)
    {
       echo $selectedfile . "<br /><br />";
       fwrite($fh, $selectedfile . "\n");
    }

    fclose($fh);
    $titolo = $_POST["nomeplay"];
    $idUtente = $_SESSION['user']['id'];
    $percorso = $dir_musica . $nomeplay . '.m3u';
    $query = "INSERT INTO playlist (
                          percorso,
                          titolo,
                          idUtente,
                          username)

              VALUES     ('$percorso',
                         '$titolo',
                         '$idUtente',
                         '$username')";

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
          <i class="fa fa-ban-circle"></i><strong>Ottimo! </strong> <a href="#" class="alert-link">La playlist è stata creata</a></div>';
  }
}

?>
