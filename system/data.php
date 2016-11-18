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

	function add_publication($posttext, $owner, $image){
    $sql = "INSERT INTO posts (text, owner, post_img) VALUES ('$posttext', '$owner', '$image');";
		return get_result($sql);
	}

	function get_my_publications($user_id){
    $sql = "SELECT * FROM publications WHERE publication_id IN (SELECT publication FROM publishes p WHERE p.user = $user_id);";
		return get_result($sql);
	}

	function delete_publication($post_id){
    $sql = "DELETE FROM posts WHERE post_id = $post_id ;";
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
		$sql = "SELECT firstname, lastname FROM user WHERE user_id in (SELECT user FROM publishes WHERE publication = $publication_id);";
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

	function update_password($user_id, $old_password, $new_password, $confirm_password){
  	$sql_ok = false;
		// old password muss noch überprüft werden!!!
    if($new_password != "" && $new_password == $confirm_password) {
      $sql = "UPDATE user SET password = $new_password WHERE user_id = $user_id;";
  		$sql_ok = true;
    }

  	if($sql_ok){
  	  return get_result($sql);
  	}else{
  		return false;
  	}
  }
?>
