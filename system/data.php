<?php
	/* *******************************************************************************************************
	/* data.php regelt die DB-Verbindung und fast den gesammten Datenverkehr der Site.
	/* So ist die gesammte Datenorganisation an einem Ort, was den Verwaltungsaufwand erheblich verringert.
	/*
	/* *******************************************************************************************************/

	/* *******************************************************************************************************
	/* get_db_connection()
	/*
	/* liefert als Rückgabewert die Datenbankverbindung
	/* hier werden für die gesammte Site die DB-Verbindungsparameter angegeben.
	/* 	"SET NAMES 'utf8'"  :	Sorgt dafür, dass alle Zeichen als UTF8 übertragen und gespeichert werden.
	/*							http://www.lightseeker.de/wunderwaffe-set-names-set-character-set/
	/* *******************************************************************************************************/
	function get_db_connection()
	{
    $db = mysqli_connect('localhost', '278306_3_1', '8I0kd@1LDbTM', '278306_3_1')
      or die('Fehler beim Verbinden mit dem Datenbank-Server.');
  		mysqli_query($db, "SET NAMES 'utf8'");
		return $db;
	}

	/* *******************************************************************************************************
	/* get_result($sql)
	/*
	/* Führt die SQL-Anweisung $sql aus, liefert das Ergebnis zurück und schliesst die DB-Verbindung
	/* Alle Weiteren Funktionen rufen get_result() direkt oder indirekt auf.
	/* *******************************************************************************************************/
	function get_result($sql)
	{
		$db = get_db_connection();
    // echo $sql ."<br>";
		$result = mysqli_query($db, $sql);
		mysqli_close($db);
		return $result;
	}


	/* *********************************************************
	/* Login
	/* ****************************************************** */

	function login($email , $password){
		$sql = "SELECT * FROM user WHERE email = '".$email."' AND password = '".$password."';";
		return get_result($sql);
	}


	/* *********************************************************
	/* my_publications / all_publications
	/* ****************************************************** */

	function get_my_publications($user_id){
    $sql = "SELECT * FROM publications WHERE publication_id IN (SELECT publication FROM publishes p WHERE p.user = $user_id);";
		return get_result($sql);
	}

	function delete_publication($publication_id){
    $sql = "DELETE FROM publications WHERE publication_id = $publication_id;";
		return get_result($sql);
	}

	function delete_publishes($publication_id){
		$sql = "DELETE FROM publishes WHERE publication = $publication_id;";
		return get_result($sql);
	}

	function get_all_publications(){
    $sql = "SELECT * FROM publications;";
		return get_result($sql);
	}

	function get_media($media_id){
		$sql = "SELECT media FROM media WHERE media_id = $media_id;";
		return get_result($sql);
	}

	function get_location($location_id){
		$sql = "SELECT location FROM location WHERE location_id = $location_id;";
		return get_result($sql);
	}

	function get_authors($publication_id){
		$sql = "SELECT user_id, firstname, lastname, user, publication, ranking FROM user, publishes WHERE user_id = user AND publication = $publication_id ORDER BY ranking ASC;";
		return get_result($sql);
	}

	function get_all_users(){
		$sql = "SELECT user_id, firstname, lastname FROM user;";
		return get_result($sql);
	}

	function get_types(){
		$sql = "SELECT * FROM type;";
		return get_result($sql);
	}

	function get_type_name($type_id){
		$sql = "SELECT type FROM type WHERE type_id = $type_id;";
		return get_result($sql);
	}

	function check_media($media){
		$sql = "SELECT * FROM media WHERE media = $media;";
		return get_result($sql);
	}

	function new_media($media){
		$sql = "INSERT INTO media (media) VALUES ('$media');";
		return get_result($sql);
	}

	function get_last_media(){
		$sql = "SELECT media_id FROM media ORDER BY media_id DESC LIMIT 1;";
		return get_result($sql);
	}

	function check_location($location){
		$sql = "SELECT * FROM location WHERE location = $location;";
		return get_result($sql);
	}

	function new_location($location){
		$sql = "INSERT INTO location (location) VALUES ('$location');";
		return get_result($sql);
	}

	function get_last_location(){
		$sql = "SELECT location_id FROM location ORDER BY location_id DESC LIMIT 1;";
		return get_result($sql);
	}

	function add_publication($user_id, $new_publication, $type_column, $type_id){
		$sql = "INSERT INTO publications (last_edited, type, ";

		for ($i=0; $i < count($type_column); $i++) {
			$sql .= "$type_column[$i], ";
		}

		$sql = substr_replace($sql, ' ', -2, 1);
		$sql .= ") VALUES ($user_id, $type_id, ";

		for ($i=0; $i < count($new_publication); $i++) {
			if ($type_column[$i] == 'media'){
				$media_check = check_media($new_publication[$i]);
				if($media_check){
					$sql .= mysqli_fetch_assoc($media_check['media_id']) . ", ";
				} else {
					new_media($new_publication[$i]);
					$new_media_id = mysqli_fetch_assoc(get_last_media())['media_id'];
					$sql .= $new_media_id . ", ";
				}
			} elseif ($type_column[$i] == 'location') {
				if ($type_column[$i] == 'location'){
					$location_check = check_location($new_publication[$i]);
					if($location_check){
						$sql .= mysqli_fetch_assoc($location_check['location_id']) . ", ";
					} else {
						new_location($new_publication[$i]);
						$new_location_id = mysqli_fetch_assoc(get_last_location())['location_id'];
						$sql .= $new_location_id . ", ";
					}
				}
				} else {
					$sql .= "'$new_publication[$i]', ";
				}
		}

		$sql = substr_replace($sql, ' ', -2, 1);
		$sql .= ") ;";

		return get_result($sql);
	}

	function get_last_publication(){
		$sql = "SELECT publication_id FROM publications ORDER BY publication_id DESC LIMIT 1;";
		return get_result($sql);
	}

	function add_author($author){
		$ranking = 1;
		$publication = mysqli_fetch_assoc(get_last_publication())['publication_id'];
		$sql = "INSERT INTO publishes (user, publication, ranking) VALUES ($author, $publication, $ranking);";
		return get_result($sql);
	}

	function edit_publication($user_id, $updated_publication, $type_column, $publication_id){
		$sql = "UPDATE publications SET ";

		for ($i=0; $i < count($updated_publication); $i++) {
			if ($type_column[$i] == 'media'){
				$media_check = check_media($updated_publication[$i]);
				if($media_check){
					$sql .= "media = " . mysqli_fetch_assoc($media_check['media_id']) . ", ";
				} else {
					new_media($updated_publication[$i]);
					$new_media_id = mysqli_fetch_assoc(get_last_media())['media_id'];
					$sql .= "media = " . $new_media_id . ", ";
				}
			} elseif ($type_column[$i] == 'location') {
				if ($type_column[$i] == 'location'){
					$location_check = check_location($updated_publication[$i]);
					if($location_check){
						$sql .= "location = " . mysqli_fetch_assoc($location_check['location_id']) . ", ";
					} else {
						new_location($updated_publication[$i]);
						$new_location_id = mysqli_fetch_assoc(get_last_location())['location_id'];
						$sql .= "location = " . $new_location_id . ", ";
					}
				}
			} else {
				$sql .= $type_column[$i]. " = '" . $updated_publication[$i] . "', ";
			}
	}

		$sql = substr_replace($sql, ' ', -2, 1);
		$sql .= " WHERE publication_id = ". $publication_id . ";";

		return get_result($sql);
	}

	function edit_author($author, $publication_id){
		$sql = "UPDATE publishes SET user = $author WHERE publication = $publication_id;";
		return get_result($sql);
	}


	/* *********************************************************
	/* Profil
	/* ****************************************************** */

	function get_user($user_id){
    $sql = "SELECT * FROM user WHERE user_id = $user_id;";
		return get_result($sql);
	}

	function get_user_image($user_id){
    $sql = "SELECT img_src FROM user WHERE user_id = $user_id;";
		return get_result($sql);
	}

	function update_password($user_id, $new_password, $confirm_password){
  	$sql_ok = false;
    if($new_password != "" && $new_password == $confirm_password) {
      $sql = "UPDATE user SET password = $new_password WHERE user_id = $user_id;";
  		$sql_ok = true;
    }

  	  return get_result($sql);
  }


	/* *********************************************************
	/* new_publication
	/* ****************************************************** */


	function get_type_label($type_id){
		$type_label = array();
		switch ($type_id) {
			case '1':
				$type_label[0] = "Titel";
				$type_label[1] = "Untertitel";
				$type_label[2] = "Datum";
				$type_label[3] = "Verlag";
				$type_label[4] = "URL";
				$type_label[5] = "Ort";
				return $type_label;
				break;
			case '2':
				$type_label[0] = "Titel";
				$type_label[1] = "Untertitel";
				$type_label[2] = "Datum";
				$type_label[3] = "Zeitung";
				$type_label[4] = "URL";
				$type_label[5] = "Ort";
				$type_label[6] = "Ausgabe";
				$type_label[7] = "Seitenzahl";
				return $type_label;
				break;
			case '3':
				$type_label[0] = "Titel";
				$type_label[1] = "Untertitel";
				$type_label[2] = "Datum";
				$type_label[3] = "Departement";
				$type_label[4] = "URL";
				$type_label[5] = "Ort";
				$type_label[6] = "Ausgabe";
				$type_label[7] = "Seitenzahl";
				return $type_label;
				break;
			case '4':
				$type_label[0] = "Titel";
				$type_label[1] = "Untertitel";
				$type_label[2] = "Datum";
				$type_label[3] = "Blog";
				$type_label[4] = "URL";
				$type_label[5] = "Ort";
				return $type_label;
				break;
			case '5':
				$type_label[0] = "Titel";
				$type_label[1] = "Untertitel";
				$type_label[2] = "Datum";
				$type_label[3] = "Veranstaltung";
				$type_label[4] = "URL";
				$type_label[5] = "Ort";
				return $type_label;
				break;
			case '6':
				$type_label[0] = "Titel";
				$type_label[1] = "Untertitel";
				$type_label[2] = "Datum";
				$type_label[3] = "Medium";
				$type_label[4] = "URL";
				$type_label[5] = "Ort";
				$type_label[6] = "Ausgabe";
				$type_label[7] = "Seitenzahl";
				return $type_label;
				break;
			default:
				break;
		}
	}

	function get_type_column($type_id){
		$type_column = array();
		switch ($type_id) {
			case '1':
				$type_column[0] = "title";
				$type_column[1] = "subtitle";
				$type_column[2] = "date";
				$type_column[3] = "media";
				$type_column[4] = "url";
				$type_column[5] = "location";
				return $type_column;
				break;
			case '2':
				$type_column[0] = "title";
				$type_column[1] = "subtitle";
				$type_column[2] = "date";
				$type_column[3] = "media";
				$type_column[4] = "url";
				$type_column[5] = "location";
				$type_column[6] = "series";
				$type_column[7] = "page_nr";
				return $type_column;
				break;
			case '3':
				$type_column[0] = "title";
				$type_column[1] = "subtitle";
				$type_column[2] = "date";
				$type_column[3] = "media";
				$type_column[4] = "url";
				$type_column[5] = "location";
				$type_column[6] = "series";
				$type_column[7] = "page_nr";
				return $type_column;
				break;
			case '4':
				$type_column[0] = "title";
				$type_column[1] = "subtitle";
				$type_column[2] = "date";
				$type_column[3] = "media";
				$type_column[4] = "url";
				$type_column[5] = "location";
				return $type_column;
				break;
			case '5':
				$type_column[0] = "title";
				$type_column[1] = "subtitle";
				$type_column[2] = "date";
				$type_column[3] = "media";
				$type_column[4] = "url";
				$type_column[5] = "location";
				return $type_column;
				break;
			case '6':
				$type_column[0] = "title";
				$type_column[1] = "subtitle";
				$type_column[2] = "date";
				$type_column[3] = "media";
				$type_column[4] = "url";
				$type_column[5] = "location";
				$type_column[6] = "series";
				$type_column[7] = "page_nr";
				return $type_column;
				break;
			default:
				break;
		}
	}

	/* *********************************************************
	/* edit_publication
	/* ****************************************************** */

	function get_publication($publication_id){
		$sql = "SELECT * FROM publications WHERE publication_id = $publication_id;";
		return get_result($sql);
	}

	function get_media_value($media_id){
		$sql = "SELECT * FROM media WHERE media_id = $media_id;";
		return get_result($sql);
	}

	function get_location_value($location_id){
		$sql = "SELECT * FROM location WHERE location_id = $location_id;";
		return get_result($sql);
	}

?>
