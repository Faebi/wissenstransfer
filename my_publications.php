<?php
/*  session_start();
	if(!isset($_SESSION['userid'])){
		header("Location:index.php");
	}else{
  	$user_id = $_SESSION['userid'];
	}*/

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
  <title>Wissenstransfer - Publikationen</title>

  <!-- Bootstrap -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

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
          <li class="active"><a href="#">Meine Publikationen</a></li>
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
				  <h4 class="panel-title">Alle Publikationen
					<button type="button" class="btn btn-default btn-sm float_right" aria-label="Left Align">
					  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</button>
				  </h4>
				</div>
				<div class="panel-body">



          	 <div class="panel-group" id="accordion">
			  <div class="panel panel-default">
				<div class="panel-heading">
				  <h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
					Publikation 1</a>
					<div class="btn-group float_right">
					  	<button type="button" class="btn btn-default btn-sm" aria-label="Left Align">
						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-danger btn-sm" aria-label="Left Align">
						  <span class="glyphicon glyphicon-trash" ></span>
						</button>
					</div>
				  </h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse">
				  <div class="panel-body">
					  <table class="table-hover publi_table">
					  	<tr>
							<th>Vorname:</th>
							<td>Peter</td>
						</tr>
				  		<tr>
							<th>Nachname:</th>
							<td>Müller</td>
						</tr>
					  </table>

				  </div><!--/table-body-->
				</div>
			  </div><!--/panel-->

			  <div class="panel panel-default">
				<div class="panel-heading">
				  <h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
					Publikation 2</a>
					<div class="btn-group float_right">
					  	<button type="button" class="btn btn-default btn-sm" aria-label="Left Align">
						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-danger btn-sm" aria-label="Left Align">
						  <span class="glyphicon glyphicon-trash" ></span>
						</button>
					</div>
				  </h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse">
				  <div class="panel-body">
					  <table class="table-hover publi_table">
					  	<tr>
							<th>Vorname:</th>
							<td>Peter</td>
						</tr>
				  		<tr>
							<th>Nachname:</th>
							<td>Müller</td>
						</tr>
					  </table>

				  </div><!--/table-body-->
				</div>
			  </div><!--/panel-->

			  <div class="panel panel-default">
				<div class="panel-heading">
				  <h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
					Publikation 3</a>
					<div class="btn-group float_right">
					  	<button type="button" class="btn btn-default btn-sm" aria-label="Left Align">
						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-danger btn-sm" aria-label="Left Align">
						  <span class="glyphicon glyphicon-trash" ></span>
						</button>
					</div>
				  </h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse">
				  <div class="panel-body">
					  <table class="table-hover publi_table">
					  	<tr>
							<th>Vorname:</th>
							<td>Peter</td>
						</tr>
				  		<tr>
							<th>Nachname:</th>
							<td>Müller</td>
						</tr>
					  </table>

				  </div><!--/table-body-->
				</div>
			  </div><!--/panel-->



  			</div>
		  </div>


          </div>
        </div> <!-- /Publikationen -->
		</div>


<?php   while($post = mysqli_fetch_assoc($post_list)) { ?>
        <!-- Beitrag -->
          <div class="row">
            <div class="col-xs-2">
              <div class="thumbnail p42thumbnail">
                <img src="user_img/<?php echo $post['img_src']; ?>" alt="profilbildBock" class="img-responsive">
              </div><!-- /thumbnail p42thumbnail -->
            </div><!-- /col-sm-2 -->

            <form enctype="multipart/form-data" class="form-inline" method="post" action="<?PHP echo $_SERVER['PHP_SELF'] ?>">
              <div class="col-xs-10">
                <div class="panel panel-default p42panel">
                  <div class="panel-heading">
<?php if($post['owner'] == $user_id){  ?>
                    <button type="submit" class="close" name="post_delete" value="<?php echo $post['post_id']; ?>">
                      <span aria-hidden="true">&times;</span>
                    </button>
<?php } ?>
                    <h3 class="panel-title"><?php echo $post['firstname'] . " " . $post['lastname']; ?></h3>
                  </div>
                  <div class="panel-body">
                    <p><?php echo $post['text']; ?></p>

<?php if($post['post_img'] != NULL){  ?>
                    <img src="post_img/<?php echo $post['post_img']; ?>" alt="postimage" class="img-responsive">
<?php } ?>
                  </div>
                  <div class="panel-footer text-right">
                    <small><a class="text-muted" href="#"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span></a></small>
                  </div>
                </div>
              </div><!-- /col-sm-10 -->
            </form>
          </div> <!-- /Beitrag -->
<?php   } ?>

      </div> <!-- /Hauptinhalt -->
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>
</html>
