<?php
session_start();
	if(!isset($_SESSION['user_id'])){
		header("Location:index.php");
	}else{
  	$user_id = $_SESSION['user_id'];
	}

	// externe Dateien Laden test
	// data.php beinhaltet alle DB-Anweisungen wie SELECT, INSERT, UPDATE, etc.
	// Funktionen in data.php liefern das Ergebnis der Anweisungen zurück
	// security.php enthält sicherheitsrelevante Funktionen
	require_once("system/data.php");
	require_once("system/security.php");

	if(isset($_POST['delete-submit'])){
		delete_publication($_POST['delete-submit']);
		delete_publishes($_POST['delete-submit']);
	}

	// Liefert alle Infos zur Publikationsliste und Erfassungstypen
	$publication_list = get_all_publications();
	$type_list = get_types();

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

	<!-- Container -->
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
									<?php while($publication = mysqli_fetch_assoc($publication_list)){
										$type_label = get_type_label($publication['type']);
										$type_column = get_type_column($publication['type']);
										?>

		 							<div class="panel panel-default">
		 								<div class="panel-heading">
			 								<h4 class="panel-title">
												<form id="form<?php echo $publication['publication_id']?>" action="edit_publication.php" method="post"></form> <!-- Wird benötigt, um mit dem Edit-Button auf edit_publication.php zu verweisen -->
				 								<a class="publication_title" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $publication['publication_id']?>"><?php echo $publication['title'] ?></a>
													<div class="btn-group float_right">
														<button form="form<?php echo $publication['publication_id']?>" type="button submit" class="btn btn-default btn-sm" name="publication_id" value="<?php echo $publication['publication_id'] ?>" aria-label="Left Align">
						 									<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
					 									</button>
					 									<button type="button" class="btn btn-danger btn-sm pub-delete" data-toggle="modal" data-target="#modal-delete" value="<?php echo $publication['publication_id'] ?>" aria-label="Left Align">
						 									<span class="glyphicon glyphicon-trash" ></span>
					 									</button>
				 									</div>
			 								</h4>
		 								</div>

										<!-- Collapse-Angaben für Titel und Untertiel -->
										<div id="collapse<?php echo $publication['publication_id'];?>" class="panel-collapse collapse">
				  						<div class="panel-body">
												<!-- Formulartabelle -->
												<table class="table-hover publi_table">
													<?php	for ($i = 0; $i < 2; $i++) {?>
													<tr>
														<th><?php echo $type_label[$i]; ?></th>
														<td><?php echo $publication[$type_column[$i]]; ?></td>
													</tr>
													<?php } ?> <!-- /Collapse-Angaben für Titel und Untertiel -->

													<!-- Collapse-Angaben für Autor -->
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
													</tr> <!-- /Collapse-Angaben für Autor -->

													<!-- Collapse-Angaben für restliche Formularfelder -->
													<?php	for ($i = 2; $i < count($type_label); $i++) {?>
													<tr>
														<th><?php echo $type_label[$i]; ?></th>
														<td><?php switch ($type_column[$i]) {
															case 'media':
																	if (get_media($publication[$type_column[$i]])) {
																		echo mysqli_fetch_assoc(get_media($publication[$type_column[$i]]))['media'];
																	} else {
																		echo "";
																	}

																break;
															case 'location':
															if (get_location($publication[$type_column[$i]])) {
																echo mysqli_fetch_assoc(get_location($publication[$type_column[$i]]))['location'];
															} else {
																echo "";
															}
																break;
															default:
																echo $publication[$type_column[$i]];
																break;
															}?></td>
													</tr> <!-- /Collapse-Angaben für restliche Formularfelder -->
													<?php } ?>


												</table> <!-- /Formulartabelle -->
				  						</div><!--/table-body-->
										</div>
		 							</div><!--/panel-->
		 							<?php } ?>
		 						</div> <!-- / Liste mit allen Publikationen -->
		  				</div>
          	</div>
        	</div>
				</div> <!-- /Publikationen -->
			</div>
		</div>
	</div> <!-- /Container -->

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form enctype="multipart/form-data" action="new_publication.php" method="post">

					<!-- modal-header -->
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Publikation erfassen</h4>
					</div><!-- /modal-header -->

					<!-- modal-body -->
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

	<!-- Modal delete publication -->
	<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-label">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

					<!-- modal-header -->
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Test</h4>
					</div><!-- /modal-header  -->

					<!-- modal-body -->
					<div class="modal-body">
						<p>
							Sind Sie sicher, dass Sie die Publikation "<span class="modal-pubtitle"></span>" löschen möchten?
						</p>
					</div><!-- /modal-body -->

					<!-- modal-footer-->
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Abbrechen</button>
						<button type="submit" class="btn btn-success btn-sm delete-submit" name="delete-submit" value="">Löschen</button>
					</div><!-- /modal-footer-->

				</form>
			</div>
		</div>
	</div><!-- /modal delete publication -->


  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$('.pub-delete').click(function() {
			var pubId = $(this).attr('value');
			$('.delete-submit').val(pubId);

			var pubTitle = $(this).closest('.panel-heading').find('.publication_title').text();
			$('.modal-pubtitle').text(pubTitle);
		});
	</script>
</body>
</html>
