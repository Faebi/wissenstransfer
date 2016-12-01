<?php
session_start();
	if(!isset($_SESSION['user_id'])){
		header("Location:index.php");
	}else{
  	$user_id = $_SESSION['user_id'];
	}

	require_once("system/data.php");
	require_once("system/security.php");

	$error = false;
	$error_msg = "";
	$success = false;
	$success_msg = "";

	$type_id = filter_data($_POST['type']);
	$type = mysqli_fetch_assoc(get_type_name($type_id))['type'];

	$user_list = get_all_users();

	$type_label = get_type_label($type_id);
	$type_column = get_type_column($type_id);
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
          <li><a href="all_publications.php">Alle Publikationen</a></li>
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
									<!-- Title & Subtitle Formular -->
									<?php for ($i = 0; $i < 2; $i++) {?>
										<div class="form-group row col-sm-offset-2">
											<label for="<?php echo $type_label[$i]; ?>" class="col-sm-1 form-control-label"><?php echo $type_label[$i]; ?></label>
											<div class="col-sm-7">
												<input type="text" class="form-control form-control-sm" id="<?php echo $type_label[$i]; ?>" name="<?php echo $type_column[$i]; ?>">
											</div>
										</div>
								<?php 	} ?>
								<!-- Autorenformular -->
								<div class="form-group row col-sm-offset-2">
									<label for="author" class="col-sm-1 form-control-label">Autor(en)</label>
									<div class="col-sm-7">
										<select class="form-control form-control-sm float_right" id="author" name="author">
										<?php while($user = mysqli_fetch_assoc($user_list)) { ?>
											<option value="<?php echo $user['user_id']; ?>"><?php echo $user['lastname']." ".$user['firstname']; ?></option>
										<?php } ?>
										</select>
									</div>
								</div>
								<!-- Restliche Formularfelder -->
								<?php for ($i = 2; $i < count($type_label); $i++) {?>
									<div class="form-group row col-sm-offset-2">
										<label for="<?php echo $type_label[$i]; ?>" class="col-sm-1 form-control-label"><?php echo $type_label[$i]; ?></label>
										<div class="col-sm-7">
											<input type="<?php if($type_column[$i] === 'date'){echo 'date';}else{echo 'text';} ?>" class="form-control form-control-sm" id="<?php echo $type_label[$i]; ?>" name="<?php echo $type_column[$i]; ?>">
										</div>
									</div>
							<?php 	} ?>

									<button type="submit" class="btn float_right" name="new-submit">Speichern</button>
								</form> <!-- /Form -->
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
