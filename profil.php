<?php
session_start();
	if(!isset($_SESSION['user_id'])){
		header("Location:index.php");
	}else{
  	$user_id = $_SESSION['user_id'];
	}

	require_once("system/data.php");
	require_once("system/security.php");

?>


<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Wissenstransfer - Profil</title>

  <!-- Bootstrap -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css"  crossorigin="anonymous">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand">Wissenstransfer</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="my_publications.php">Meine Publikationen</a></li>
          <li><a href="all_publications.php">Alle Publikationen</a></li>
		  <li><a href="output.php">Ausgabe</a></li>
          <li class="active"><a href="#">Profil</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">Logout</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav><!-- /Navigation -->

  <div class="container">

    <!-- Button trigger modal -->


    <div class="panel panel-default container-fluid"> <!-- fluid -->
      <div class="panel-heading row">
        <div class="col-sm-6">
            <h4>Persönliche Einstellungen</h4>
        </div>
          <div class="col-xs-6 text-right">
            <button type="button" class="btn btn-default btn-sm float_right" data-toggle="modal" data-target="#myModal">Passwort ändern</button>
          </div>
      </div>
      <div class="panel-body">
        <div class="col-sm-3">
          <!-- Profilbild -->
          <img src="user_img/<?php echo $user['img_src'];?>" alt="Profilbild" class="img-responsive">
          <!-- /Profilbild -->
        </div>
        <div class="col-sm-9">
          <!-- Profildaten des Users -->
          <dl class="dl-horizontal lead">
            <dt>Name</dt>
            <dd><?php echo $user['firstname'] . " " . $user['lastname'];?></dd>

            <!--<dt>Nutzername</dt>
            <dd>wobo</dd>-->

            <dt>E-Mail</dt>
            <dd><?php echo $user['email'];?></dd>

            <dt>letzte Änderung</dt>
            <dd>Ihr Profil wurde zuletzt am <?php echo $last_update?> aktualisiert.</dd>
          </dl>
          <!-- / Profildaten des Users -->
        </div>
      </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form enctype="multipart/form-data" action="<?PHP echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Passwort ändern</h4>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label for="Passwort" class="col-sm-4 form-control-label">Altes Passwort</label>
            <div class="col-sm-8">
              <input type="password" class="form-control form-control-sm" id="Passwort" name="old_password">
            </div>
          </div>
          <div class="form-group row">
            <label for="Passwort" class="col-sm-4 form-control-label">Neues Password</label>
            <div class="col-sm-8">
              <input type="password" class="form-control form-control-sm" id="Passwort" name="password">
            </div>
          </div>
          <div class="form-group row">
            <label for="Passwort_Conf" class="col-sm-4 form-control-label">Passwort bestätigen</label>
            <div class="col-sm-8">
              <input type="password" class="form-control form-control-sm" id="Passwort_Conf" name="confirm-password">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Abbrechen</button>
          <button type="submit" class="btn btn-success btn-sm" name="update-submit">Änderungen speichern</button>
        </div>
      </form>

    </div>
  </div>
</div>



  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"  crossorigin="anonymous"></script>
</body>
</html>
