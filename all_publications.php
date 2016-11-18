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
	$type_list = get_types();


	if (isset($_POST['add-submit'])) {
		$type = filter_data($_POST['type']);
	}

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
          <li class="active"><a href="#">Alle Publikationen</a></li>
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
									<button type="button" class="btn btn-default btn-sm float_right" data-toggle="modal" data-target="#myModal" aria-label="Left Align">
									  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
									</button>
				  			</h4>
							</div>
							<div class="panel-body">
								<div class="panel-group" id="accordion"> <!-- Liste mit allen Publikationen -->
									<?php while($publication = mysqli_fetch_assoc($publication_list)){ ?>
		 							<div class="panel panel-default">
		 								<div class="panel-heading">
			 								<h4 class="panel-title">
				 								<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
					 								<?php echo $publication['title'] ?>
				 								</a>
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
				 								<?php switch ($publication['type']){
					 											case 4: ?>
						 							<table class="table-hover publi_table">
							 							<tr>
								 							<th>Titel:</th>
								 							<td><?php echo $publication['title']; ?></td>
							 							</tr>
							 							<tr>
								 							<th>Autor(en):</th>
								 							<td>
															 	<?php
																 	$authors = get_authors($publication['publication_id']);
																 	$author_result = "";
																 	while($author = mysqli_fetch_assoc($authors)){
																	 	$author_result .= $author['firstname']." ".$author['lastname'].", ";
																 	}
																 	$author_result = substr_replace($author_result, ' ', -2, 1);
																 	echo $author_result;
															 	?>
								 							</td>
							 							</tr>
							 							<tr>
								 							<th>Datum:</th>
								 							<td><?php echo $publication['date']; ?></td>
							 							</tr>
							 							<tr>
								 							<th>Publikationsort:</th>
								 							<td><?php echo mysqli_fetch_array(get_media($publication['media']))['media']; ?></td>
							 							</tr>
							 							<tr>
								 							<th>URL:</th>
								 							<td><?php echo $publication['url'];?></td>
							 							</tr>
						 							</table>
				 								<?php break; } ?>

			 								</div><!--/table-body-->
		 								</div>
		 							</div><!--/panel-->
		 							<?php } ?>
		 						</div> <!-- / Liste mit allen Publikationen -->
		  				</div>
          	</div>
        	</div> <!-- /Publikationen -->
				</div>
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<form enctype="multipart/form-data" action="new_publication.php" method="post">

								<div class="modal-header">
									<h4 class="modal-title" id="myModalLabel">Publikation erfassen</h4>
								</div><!-- modal-header -->

								<div class="modal-body">
									<div class="form-group row">
										<label for="Type" class="col-sm-4 form-control-label">Publikationstyp</label>
											<div class="col-sm-5">
												<select class="form-control form-control-sm float_right" id="Type" name="type">
						      <?php while($type = mysqli_fetch_assoc($type_list)) { ?>
               						<option value="<?php echo $type['type_id']; ?>"><?php echo $type['type']; ?></option>
									<?php } ?>
												</select>



										</div>

									</div>

								</div><!-- /modal-body -->

								<div class="modal-footer">
									<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Abbrechen</button>
									<button type="submit" class="btn btn-success btn-sm" name="add-submit">Erfassen</button>
								</div><!-- /modal-footer -->
							</form>

						</div>
					</div>
				</div><!-- /modal -->
      </div> <!-- /Hauptinhalt -->
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
