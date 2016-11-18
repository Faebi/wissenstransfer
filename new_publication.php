<?php
session_start();
	if(!isset($_SESSION['user_id'])){
		header("Location:index.php");
	}else{
  	$user_id = $_SESSION['user_id'];
	}

	require_once("system/data.php");
	require_once("system/security.php");

$publication_list = get_all_publications();
$type = filter_data($_POST['type']);

?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Wissenstransfer - Publikationen</title>

  <!-- Bootstrap -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <link rel="stylesheet" href="css/css_style.css">

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
          <li><a href="#">Alle Publikationen</a></li>
          <li><a href="output.php">Ausgabe</a></li>
          <li><a href="profil.php">Profil</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php">Logout</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav><!-- /Navigation -->

  <div class="container">
    <div class="row">
      <div class="col-md-12"> <!-- Hauptinhalt -->

        <!-- Publikationen -->
        <div class="row">
          <div class="col-xs-12">
          	<div class="panel panel-default">
							<div class="panel-heading">
				  			<h4 class="panel-title"><?php echo $type ?> erfassen</h4>
							</div>
							<div class="panel-body">
								<form enctype="multipart/form-data" action="my_publications.php" method="post">
									<?php switch ($type){ 																													// 1 ist mit $_POST['type'] zu ersetzen!!!
										case 1: ?> <!-- Typ: Buch -->
											<div class="form-group row col-sm-offset-2">
												<label for="Titel" class="col-sm-1 form-control-label">Titel</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Titel" name="title">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="Untertitel" class="col-sm-1 form-control-label">Untertitel</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Untertitel" name="subtitle">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="Datum" class="col-sm-1 form-control-label">Datum</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Datum" name="date">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="Verlag" class="col-sm-1 form-control-label">Verlag</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Verlag" name="media">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="URL" class="col-sm-1 form-control-label">URL</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="URL" name="url">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="Ort" class="col-sm-1 form-control-label">Ort</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Ort" name="location">
												</div>
											</div>
									<?php break;
									 	case 2:?>
											<div class="form-group row col-sm-offset-2">
												<label for="Titel" class="col-sm-1 form-control-label">Titel</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Titel" name="title">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="Untertitel" class="col-sm-1 form-control-label">Untertitel</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Untertitel" name="subtitle">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="Datum" class="col-sm-1 form-control-label">Datum</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Datum" name="date">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="Verlag" class="col-sm-1 form-control-label">Verlag</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Verlag" name="media">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="URL" class="col-sm-1 form-control-label">URL</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="URL" name="url">
												</div>
											</div>
											<div class="form-group row col-sm-offset-2">
												<label for="Ort" class="col-sm-1 form-control-label">Ort</label>
												<div class="col-sm-7">
													<input type="text" class="form-control form-control-sm" id="Ort" name="location">
												</div>
											</div>
									<?php } ?>
									<button type="submit" class="btn float_right" name="new_submit">Speichern</button>
								</form>
		  				</div>
          	</div>
        	</div> <!-- /Publikationen -->
				</div>
      </div> <!-- /Hauptinhalt -->
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
