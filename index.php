<?php
  session_start();
	if(isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
	session_destroy();

	// externe Dateien Laden test
	// data.php beinhaltet alle DB-Anweisungen wie SELECT, INSERT, UPDATE, etc.
	// Funktionen in data.php liefern das Ergebnis der Anweisungen zurück
	// security.php enthält sicherheitsrelevante Funktionen
	require_once("system/data.php");
	require_once("system/security.php");

  // für Spätere Verwendung initialisieren wir die Variablen $error, $error_msg
  $error = false;
  $error_msg = "";

  // Kontrolle, ob die Seite direkt aufgerufen wurde oder vom Login-Formular
  if(isset($_POST['login-submit'])){
    // Kontrolle mit isset, ob email und password ausgefüllt wurde
    if(!empty($_POST['email']) && !empty($_POST['password'])){

      // Werte aus POST-Array auf SQL-Injections prüfen und in Variablen schreiben
      $email = filter_data($_POST['email']);
      $password = filter_data($_POST['password']);

      // Liefert alle Infos zu User mit diesen Logindaten
      $result = login($email,$password);

      // Anzahl der gefundenen Ergebnisse in $row_count
  		$row_count = mysqli_num_rows($result);
      if( $row_count == 1){
        session_start();
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['user_id'];
        header("Location:my_publications.php");
      }else{
        // Fehlermeldungen werden erst später angezeigt
        $error = true;
        $error_msg .= "E-Mailadresse oder Passwort ungültig. Bitte überprüfen Sie Ihre Angaben.</br>";
      }
    }else{
      // Fehlermeldungen werden erst später angezeigt
      $error = true;
      $error_msg .= "Bitte füllen Sie beide Felder aus.</br>";
    }
  }

?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wissentransfer - Login</title>

    <!-- Bootstrap CSS file-->
  <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">

    <!-- individuelles CCS file für den Login -->
  <link rel="stylesheet" href="css/login.css">
  </head>

  <body>
    <!-- http://bootsnipp.com/snippets/featured/login-and-register-tabbed-form -->
    <div class="container">
    	<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<div class="panel panel-login">
  					<div class="panel-heading">
  						<div class="row">
  							<div class="col-xs-12">
  								<a href="#" class="active" id="login-form-link">Login</a>
  							</div>
  						</div>
  						<hr>
  					</div> <!-- /panel-heading -->

  					<div class="panel-body">
  						<div class="row">
  							<div class="col-lg-12">

  								<!-- Login-Formular -->
  								<form id="login-form" action="index.php" method="post" role="form" style="display: block;">
  									<div class="form-group">
  										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="E-Mail-Adresse" value="">
  									</div>
  									<div class="form-group">
  										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Passwort">
  									</div>
  									<div class="form-group">
  										<div class="row">
  											<div class="col-sm-6 col-sm-offset-3">
  												<input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="einloggen">
  											</div>
  									  </div>
  								  </div>
  							</form> <!-- Login-Formular -->

  							</div>
  						</div>
  					</div> <!-- /panel-body -->

  			  </div> <!-- /panel-login -->
  			</div>
  		</div> <!-- /row -->


      <?php
        // Ausgabe von Fehlermeldungen
        if($error == true){   //gibt es einen Fehler?
      ?>
          <div class="alert alert-danger" role="alert"><?php echo $error_msg; ?></div>
      <?php
        }
      ?>

    </div><!-- /container Hauptinhalt -->


    <!-- jQuery (nötig für Bootstrap und JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Alle kompillierten Plugins (unten), oder andere benötigte Files -->
    <script src="../Webseite/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script>
      $(function() {
        $('#login-form-link').click(function(e) {
      		$("#login-form").delay(100).fadeIn(100);
      		$(this).addClass('active');
      		e.preventDefault();
      	});
      });
    </script>

  </body>
</html>
