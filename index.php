<?php
require ("core/common.php");

if (empty($_SESSION['user']))
    {
    header("Location: login.php");
    die("Redirecting to login.php");
    }

    $utente = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
?> 
<!DOCTYPE html>
<html lang="it" class="app">
<head>  
  <meta charset="utf-8" />
  <title>NR STATION</title>
  <meta name="description" content="nr station, webradio, iisreggio" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <link rel="stylesheet" href="js/jPlayer/jplayer.flat.css" type="text/css" />
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <link rel="stylesheet" href="css/app.css" type="text/css" />  
    <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body class="">
<!-- carica -->
  <div class="modal fade" id="carica" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Carica</h4>
            </div>
            <div class="modal-body">
            <?php include ("core/upload.php"); 
            $mestesso = htmlspecialchars($_SERVER["PHP_SELF"]);
              echo "<form action=\"$mestesso\" method=\"post\" enctype=\"multipart/form-data\" data-validate=\"parsley\"> "; ?>
                  <div class="form-group">
                    <label>Titolo</label>
                    <input type="text" name ="titolo" id="titolo" class="form-control" data-required="true">                        
                  </div>
                  <div class="form-group">
                    <label>Artista</label>
                    <input type="text" name="artista" id="artista" class="form-control" data-required="true">                        
                  </div>
                  <br/>
                  Scegli il file da caricare: &nbsp; &nbsp;
                  <label class="btn btn-primary" for="fileToUpload">
                  <i class="fa fa-cloud-upload text"></i>
                  <input name="fileToUpload" id="fileToUpload" type="file" style="display:none;">
                  Carica
                  </label>
                  <div class="modal-footer">
                    <button type="submit" name="upload" class="btn btn-success btn-s-xs" onClick="return controllaNome()">Invia</button>
                  </div>
              </form>
            </div>
        </div>
      </div>
  </div>
 <!-- / carica --> 
  <section class="vbox">
    <header class="bg-white-only header header-md navbar navbar-fixed-top-xs">
      <div class="navbar-header aside bg-info nav-xs">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="icon-list"></i>
        </a>
        <a href="index.php" class="navbar-brand text-lt">
          <i class="icon-earphones"></i>
          <img src="images/logo.png" alt="." class="hide">
          <span class="hidden-nav-xs m-l-sm">NR STATION</span>
        </a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
          <i class="icon-settings"></i>
        </a>
      </div>      
      <ul class="nav navbar-nav hidden-xs">
        <li>
          <a href="#nav,.navbar-header" data-toggle="class:nav-xs,nav-xs" class="text-muted">
            <i class="fa fa-indent text"></i>
            <i class="fa fa-dedent text-active"></i>
          </a>
        </li>
      </ul>
      <div class="navbar-right ">
        <ul class="nav navbar-nav m-n hidden-xs nav-user user">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle bg clear" data-toggle="dropdown">
              <?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu animated fadeInRight">            
              <li>
                <a href="profile.php">Profilo</a>
              </li>
              <li>
                <a href="docs.html">Guida</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="logout.php">Esci</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>    
    </header>
    <section>
      <section class="hbox stretch">
        <!-- .aside -->
        <aside class="bg-black dk nav-xs aside hidden-print" id="nav">          
          <section class="vbox">
            <section class="w-f-md scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">                
                <!-- nav -->                 
                <nav class="nav-primary hidden-xs">
                  <ul class="nav bg clearfix" data-ride="collapse">
                    <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                      Menu
                    </li>
                    <li>
                      <a href="index.php">
                        <i class="icon-disc icon text-success"></i>
                        <span class="font-bold">Home</span>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="auto">
                        <span class="pull-right text-muted">
                          <i class="fa fa-angle-left text"></i>
                          <i class="fa fa-angle-down text-active"></i>
                        </span>
                        <i class="icon-music-tone-alt icon text-info">
                        </i>
                        <span class="font-bold">Playlist</span>
                      </a>
                      <ul class="nav dk text-sm">
                        <li>
                          <a href="listen.php" class="auto">                                                        
                            <i class="fa fa-angle-right text-xs"></i>
                            <span>Le mie playlist</span>
                          </a>
                        </li>
                        <li>
                          <a href="new.php" class="auto">                                                        
                            <i class="fa fa-angle-right text-xs"></i>
                            <span>Nuove</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                    </li>
                    <li>
                      <a href="#" data-toggle="modal" data-target="#carica">
                        <i class=" icon-cloud-upload icon text-success"></i>
                        <span class="font-bold">Carica</span>
                      </a>
                    </li>
                    <li>
                      <a href="create_playlist.php">
                        <i class=" icon-plus icon text-xs"></i>
                        <span class="font-bold">Crea Playlist</span>
                      </a>
                    </li>
                    <li class="m-b hidden-nav-xs"></li>
                  </ul>
                </nav>
                <!-- / nav -->
              </div>
            </section>       
          </section>
        </aside>
        <!-- /.aside -->
        <section id="content">
          <section class="hbox stretch">
            <section>
              <section class="vbox">
                <section class="scrollable padder-lg w-f-md" id="bjax-target">
                  <a href="#" class="pull-right text-muted m-t-lg" data-toggle="class:fa-spin" ><i class="icon-refresh i-lg  inline" id="refresh"></i></a>
                  <h2 class="font-thin m-b">Ultime playlist create dagli utenti<span class="musicbar animate inline m-l-sm" style="width:20px;height:20px">
                    <span class="bar1 a1 bg-primary lter"></span>
                    <span class="bar2 a2 bg-info lt"></span>
                    <span class="bar3 a3 bg-success"></span>
                    <span class="bar4 a4 bg-warning dk"></span>
                    <span class="bar5 a5 bg-danger dker"></span>
                  </span></h2>
                  <div class="row row-sm">
                   <?php
                      $utente = htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
                      $user_id = htmlentities($_SESSION['user']['id'], ENT_QUOTES, 'UTF-8');
                      $query_canzone = "SELECT titolo, percorso, username FROM playlist ORDER BY id DESC LIMIT 10";
                      $query_params = array(':userid' => $user_id);

                      try
                      {
                        $stmt = $db->prepare($query_canzone);
                        $result = $stmt->execute($query_params);
                      }

                      catch(PDOException $ex)
                      {
                        die("Failed to run query: " . $ex->getMessage());
                      }
                          while($row = $stmt->fetch())
                          { 

                            $titolo_play = $row["titolo"];
                            $username = $row["username"];
  
                            echo "<div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2\"><div class=\"item\">
                                  <div class=\"pos-rlt\"><div class=\"item-overlay opacity r r-2x bg-black\">
                                  <div class=\"text-info padder m-t-sm text-sm\">
                                  </div><div class=\"center text-center m-t-n\">
                                  <a href=\"#\"><i class=\"icon-control-play i-2x\"></i></a></div>
                                  <div class=\"bottom padder m-b-sm\"><a href=\"#\" class=\"pull-right\"></a>
                                  <a href=\"#\"><i class=\"fa fa-plus-circle\"></i></a></div></div>
                                  <a href=\"#\"><img src=\"images/qualcosa.png\" alt=\"\" class=\"r r-2x img-full\"></a>
                                  </div><div class=\"padder-v\">
                                  <a href=\"#\" class=\"text-ellipsis\">$titolo_play</a>
                                  <a href=\"#\" class=\"text-ellipsis text-xs text-muted\">$username</a>
                                  </div></div></div>";

                          }
                      
                      chdir("$currentdir");
                      ?>
                  </div>
                 </div>
                </section>
                <footer class="footer bg-dark">
                  <div id="jp_container_N">
                    <div class="jp-type-playlist">
                      <div id="jplayer_N" class="jp-jplayer hide"></div>
                      <div class="jp-gui">
                        <div class="jp-video-play hide">
                          <a class="jp-video-play-icon">play</a>
                        </div>
                        <div class="jp-interface">
                          <div class="jp-controls">
                            <div><a class="jp-previous"><i class="icon-control-rewind i-lg"></i></a></div>
                            <div>
                              <a class="jp-play"><i class="icon-control-play i-2x"></i></a>
                              <a class="jp-pause hid"><i class="icon-control-pause i-2x"></i></a>
                            </div>
                            <div><a class="jp-next"><i class="icon-control-forward i-lg"></i></a></div>
                            <div class="hide"><a class="jp-stop"><i class="fa fa-stop"></i></a></div>
                            <div><a class="" data-toggle="dropdown" data-target="#playlist"><i class="icon-list"></i></a></div>
                            <div class="jp-progress hidden-xs">
                              <div class="jp-seek-bar dk">
                                <div class="jp-play-bar bg-info">
                                </div>
                                <div class="jp-title text-lt">
                                  <ul>
                                    <li></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <div class="hidden-xs hidden-sm jp-current-time text-xs text-muted"></div>
                            <div class="hidden-xs hidden-sm jp-duration text-xs text-muted"></div>
                            <div class="hidden-xs hidden-sm">
                              <a class="jp-mute" title="mute"><i class="icon-volume-2"></i></a>
                              <a class="jp-unmute hid" title="unmute"><i class="icon-volume-off"></i></a>
                            </div>
                            <div class="hidden-xs hidden-sm jp-volume">
                              <div class="jp-volume-bar dk">
                                <div class="jp-volume-bar-value lter"></div>
                              </div>
                            </div>
                            <div>
                              <a class="jp-shuffle" title="shuffle"><i class="icon-shuffle text-muted"></i></a>
                              <a class="jp-shuffle-off hid" title="shuffle off"><i class="icon-shuffle text-lt"></i></a>
                            </div>
                            <div>
                              <a class="jp-repeat" title="repeat"><i class="icon-loop text-muted"></i></a>
                              <a class="jp-repeat-off hid" title="repeat off"><i class="icon-loop text-lt"></i></a>
                            </div>
                            <div class="hide">
                              <a class="jp-full-screen" title="full screen"><i class="fa fa-expand"></i></a>
                              <a class="jp-restore-screen" title="restore screen"><i class="fa fa-compress text-lt"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="jp-playlist dropup" id="playlist">
                        <ul class="dropdown-menu aside-xl dker">
                          <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                          <li class="list-group-item"></li>
                        </ul>
                      </div>
                      <div class="jp-no-solution hide">
                        <span>Update Required</span>
                        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                      </div>
                    </div>
                  </div>
                </footer>
              </section>
            </section>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
      </section>
    </section>    
  </section>
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  <!-- parsley -->
  <script src="js/parsley/parsley.min.js"></script>
  <script src="js/parsley/parsley.extend.js"></script>
  <!-- namecheck -->
  <script type="text/javascript" src="js/namecheck.js"></script>
  <!-- App -->
  <script src="js/app.js"></script>  
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="js/app.plugin.js"></script>
  <script type="text/javascript" src="js/jPlayer/jquery.jplayer.min.js"></script>
  <script type="text/javascript" src="js/jPlayer/add-on/jplayer.playlist.min.js"></script>
  <script type="text/javascript" src="js/jPlayer/demo.js"></script>

  <?php

  $server_address="http://104.167.104.14/";
  $player = file_get_contents('player.tmpl', FILE_USE_INCLUDE_PATH);

  $utente = htmlentities($_SESSION['user']['id'], ENT_QUOTES, 'UTF-8');
  $query_canzone = "SELECT titolo, artista, percorso FROM canzoni WHERE idUtente = :userid";
  $query_params = array(':userid' => $utente);

  try
  {
    $stmt = $db->prepare($query_canzone);
    $result = $stmt->execute($query_params);
  }
  catch(PDOException $ex)
  {
    die("Failed to run query: " . $ex->getMessage());
  }
  while($row = $stmt->fetch())
  {
    $percorso = $row["percorso"];
    $percorso = str_replace('/var/www/html/', '', $percorso);
    //$lista .= $row["titolo"];

    $lista .= "{title:\"".$row["titolo"]."\",";
    $lista .= "artist:\"".$row["artista"]."\",";
    $lista .= "mp3:\"" . $server_address . $percorso . "\",";
    $lista .= "poster: \"images/m0.jpg\"},";
  }

  //rtrim($lista, ",");
  $lista = substr($lista, 0, -1);

  $player = str_replace("%%LISTACANZONI%%", $lista, $player);

  //echo $lista;
  echo $player;

  ?>

</body>
</html>