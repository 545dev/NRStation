<?php

$currentdir = getcwd();
$dir_musica = "/music/";
chdir("$dir_musica");
$filelist = glob("*.mp3");

if (empty($filelist))
    {
    echo "La directory è vuota..";
    }
  else
    {
    echo "<form action=\"$mestesso\" method=\"post\" enctype=\"multipart/form-data\">";
    echo " <h4>Scegli un nome per la tua playlist</h4>";
    echo "Nome: <input type=\"text\" name=\"nomeplay\" />";
    echo " <h4>Scegli i brani da aggiungere alla playlist</h4>";
    foreach($filelist AS $file)
        {
        if (is_file($file))
            {
            echo "<input type=\"checkbox\" name=\"checkfiles[]\" value=\"$file\">$file<br /><br />\n";
            }
        }

    echo "<input type=\"submit\" value=\"Crea Playlist\" name=\"createfile\">\n</form><br />";
    }

chdir("$currentdir");

?>
