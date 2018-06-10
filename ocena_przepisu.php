<?php
session_start();
include ('polaczenie.php');

$id_przepisu = $_POST['id_przepisu'];
$ocena = $_POST['vote'];
if(isset($_SESSION['zalogowany'])){
	$id_uzytkownika = $_SESSION['id_uzytkownika'];
}

try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			if(isset($_SESSION['zalogowany'])){
				$rezultat = $polaczenie->query("SELECT COUNT(id_oceny) AS l_ocena FROM oceny WHERE id_uzytkownika='$id_uzytkownika' AND id_przepisu='$id_przepisu'");
				$wiersz = $rezultat->fetch_assoc();

				if($wiersz['l_ocena'] == 0 AND isset($_SESSION['zalogowany'])){
					$polaczenie->query("INSERT INTO oceny VALUES(NULL,'$id_przepisu','$id_uzytkownika','$ocena')");
					echo "Twoja ocena: ".$ocena;
				} elseif($wiersz['l_ocena'] > 0 AND isset($_SESSION['zalogowany'])) {
					echo "Już głosowałeś !";
				}
			}
			else {
				echo "Aby głosować musisz być zalogowany";
			}
		} 
	}
		catch (Exception $e) {
			echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
			echo "Informacja developera: ".$e;
	}

$polaczenie->close();
