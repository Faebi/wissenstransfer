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

  // für Spätere Verwendung initialisieren wir die Variablen $error, $error_msg, $success, $success_msg
  $error = false;
  $error_msg = "";
  $success = false;
  $success_msg = "";

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

    <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
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
  					</div>
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
  							</form>
  							</div>
  						</div>
  					</div>
  			  </div>
  			</div>
  		</div>

  <?php
    // Gibt es einen Erfolg zu vermelden?
    if($success == true){
  ?>
      <div class="alert alert-success" role="alert"><?php echo $success_msg; ?></div>
  <?php
    }   // schliessen von if($success == true)
    // Gibt es einen Fehler?
    if($error == true){
  ?>
      <div class="alert alert-danger" role="alert"><?php echo $error_msg; ?></div>
  <?php
    }   // schliessen von if($success == true)
  ?>
  	</div><!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Webseite/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script>
      $(function() {

        $('#login-form-link').click(function(e) {
      		$("#login-form").delay(100).fadeIn(100);
       		$("#register-form").fadeOut(100);
      		$('#register-form-link').removeClass('active');
      		$(this).addClass('active');
      		e.preventDefault();
      	});
      });
    </script>

  </body>
</html>
