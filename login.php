<?php

// Connessione al database e inizializzazione della sessione

require ("core/common.php");

// Questa variabile sarà usata per visualizzare il nome utente nella schermata di
// login se la password inserita non è corretta

$submitted_username = '';

if (!empty($_POST))
    {

    // Questa query riporta le informazioni dell'utente

    $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt, 
                email
            FROM users 
            WHERE 
                username = :username 
        ";
    $query_params = array(
        ':username' => $_POST['username']
    );
    try
        {

        // Esegue la query

        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
        }

    catch(PDOException $ex)
        {
        die("Failed to run query: " . $ex->getMessage());
        }

    // Questa variabile ci dice se l'utente è loggato
    // We initialize it to false, assuming they have not.
    // If we determine that they have entered the right details, then we switch it to true.

    $login_ok = false;

    // Riporta i dati utente dal database Se $row è falso, l'username non è registrato

    $row = $stmt->fetch();
    if ($row)
        {

 		// controllo sulle password

        $check_password = hash('sha256', $_POST['password'] . $row['salt']);
        for ($round = 0; $round < 65536; $round++)
            {
            $check_password = hash('sha256', $check_password . $row['salt']);
            }

        if ($check_password === $row['password'])
            {

            // inizializziamo la variabile a true se corrispondono

            $login_ok = true;
            }
        }

    if ($login_ok)
        {
           unset($row['salt']);
           unset($row['password']);
           $_SESSION['user'] = $row;
           header("Location: index.php");
           die("Redirecting to: index.php");   
        }
      else
        {
           echo '<div class="text-center alert alert-danger">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <i class="fa fa-ban-circle"></i><strong>Attenzione!</strong> <a href="#" class="alert-link">Lo username e/o la password </a> che hai inserito non sono corretti.
                 </div>';
                 
           $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        }
    }

?>
<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title>NR STATION</title>
  <meta name="description" content="iis" />
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
<body class="bg-info dker">
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xl">
      <a class="navbar-brand block" href="index.html"><span class="h1 font-bold">NR STATION</span></a>
      <section class="m-b-lg">
        <header class="wrapper text-center">
        </header>
        <form action="login.php" method="post" data-validate="parsley">
          <div class="form-group">
            <input type="username" placeholder="Username" class="form-control rounded input-lg text-center no-border" data-required="true" name="username" value="<?php echo $submitted_username; ?>">
          </div>
          <div class="form-group">
             <input type="password" placeholder="Password" class="form-control rounded input-lg text-center no-border" name="password" data-required="true">
          </div>
          <button type="submit" class="btn btn-lg btn-warning lt b-white b-2x btn-block btn-rounded"><i class="icon-arrow-right pull-right"></i><span class="m-r-n-lg">Accedi</span></button>
          <div class="text-center m-t m-b"><a href="#"><small>Password dimenticata?</small></a></div>
          <div class="line line-dashed"></div>
          <p class="text-muted text-center"><small>Non hai ancora un account?</small></p>
          <a href="register.php" class="btn btn-lg btn-info btn-block rounded">Crea un account</a>
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>NR STATION<br>&copy; 2015</small>
      </p>
    </div>
  </footer>
  <!-- / footer -->
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  <!-- Parsley -->
  <script src="js/parsley/parsley.min.js"></script>
  <script src="js/parsley/parsley.extend.js"></script>
  <!-- App -->
  <script src="js/app.js"></script>  
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="js/app.plugin.js"></script>
  <script type="text/javascript" src="js/jPlayer/jquery.jplayer.min.js"></script>
  <script type="text/javascript" src="js/jPlayer/add-on/jplayer.playlist.min.js"></script>
  <script type="text/javascript" src="js/jPlayer/demo.js"></script>
</body>
</html>