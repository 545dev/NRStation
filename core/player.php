<?php

//echo $query_canzone;

echo '$(document).ready(function(){
	    var myPlaylist = new jPlayerPlaylist({
      jPlayer: "#jplayer_N",
      cssSelectorAncestor: "#jp_container_N"}, [ 
      ';

$currentdir = getcwd();
$dir_musica = "/music/utenti/".$utente;
chdir("$dir_musica");
$filelist = glob("*.mp3");

//echo $query_canzone;
$query_canzone = "SELECT titolo, artista, percorso FROM canzoni WHERE id = :userid";
$query_params = array(
    ':userid' => $_SESSION['user']['id']
);

try
  {
    // Esegue la query

    $stmt = $db->prepare($query_canzone);
    $result = $stmt->execute($query_params);
  }
catch(PDOException $ex)
  {
//    die("Failed to run query: " . $ex->getMessage());
  }

$row = $stmt->fetch();

foreach($row = $stmt->fetch())
{
    echo "{ title:\"$row['titolo']\",
          artist:\"ADG3\",
          mp3:\"http://104.167.104.14/swag.mp3\",
          poster: \"images/m0.jpg\" }"; 
}

/*
foreach($filelist AS $file)
{
  if (is_file($file))
  {
      echo "{ title:\"$file\",
            artist:\"ADG3\",
            mp3:\"http://104.167.104.14/swag.mp3\",
            poster: \"images/m0.jpg\" }, "; 
  }
}
*/

chdir("$currentdir");

echo ' ], { playlistOptions: {
      enableRemoveControls: true,
      autoPlay: true },
      swfPath: "js/jPlayer",
      supplied: "webmv, ogv, m4v, oga, mp3",
      smoothPlayBar: true,
      keyEnabled: true,
      audioFullScreen: false }); 
      ';

echo '  
  	  $(document).on($.jPlayer.event.pause, myPlaylist.cssSelector.jPlayer,  function(){
      $(\'.musicbar\').removeClass(\'animate\');
      $(\'.jp-play-me\').removeClass(\'active\');
      $(\'.jp-play-me\').parent(\'li\').removeClass(\'active\'); });

      $(document).on($.jPlayer.event.play, myPlaylist.cssSelector.jPlayer,  function(){
      $(\'.musicbar\').addClass(\'animate\'); });

      $(document).on(\'click\', \'.jp-play-me\', function(e){
      e && e.preventDefault();
      var $this = $(e.target);
      if (!$this.is(\'a\')) $this = $this.closest(\'a\');

      $(\'.jp-play-me\').not($this).removeClass(\'active\');
      $(\'.jp-play-me\').parent(\'li\').not($this.parent(\'li\')).removeClass(\'active\');

      $this.toggleClass(\'active\');
      $this.parent(\'li\').toggleClass(\'active\');
      if( !$this.hasClass(\'active\') ){
      myPlaylist.pause(); }else{
      var i = Math.floor(Math.random() * (1 + 7 - 1));
      myPlaylist.play(i); } }); });
      ';
?>