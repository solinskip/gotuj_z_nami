<?php
session_start();

include ('polaczenie.php');
$id_komentarza = $_POST['id_komentarza'];

try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			$polaczenie->query("DELETE FROM komentarze WHERE id_komentarza='$id_komentarza'");
		}
	} catch (Exception $e) {
		echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
		echo "Informacja developera: ".$e;
	}
