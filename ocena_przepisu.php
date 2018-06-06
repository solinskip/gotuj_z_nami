<?php
session_start();
include ('polaczenie.php');

$id_przepisu = $_POST['id_przepisu'];
$ocena = $_POST['vote'];
$id_uzytkownika = $_SESSION['id_uzytkownika'];

try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			$rezultat = $polaczenie->query("SELECT COUNT(id_oceny) AS l_ocena FROM oceny WHERE id_uzytkownika='$id_uzytkownika' AND id_przepisu='$id_przepisu'");
			$wiersz = $rezultat->fetch_assoc();

			if($wiersz['l_ocena'] == 0){
				$polaczenie->query("INSERT INTO oceny VALUES(NULL,'$id_przepisu','$id_uzytkownika','$ocena')");
				echo "Twoja ocena: ".$ocena;
			} else {
				echo "Już głosowałeś !";
			}
		} 
	}
		catch (Exception $e) {
			echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
			echo "Informacja developera: ".$e;
	}

$polaczenie->close();
