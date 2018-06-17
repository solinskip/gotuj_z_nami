<?php
session_start();
include ('polaczenie.php');
$id_uzytkownika = $_SESSION['id_uzytkownika'];
$id_przepisu = $_POST['id_przepisu'];
if(isset($_POST['poprawny']) AND $_POST['poprawny'] == 1){
	$czas_przygotowania = 1;
}
if(isset($_POST['niepoprawny']) AND $_POST['niepoprawny'] == 1){
	$czas_przygotowania = 0;
}

try {
	$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
	if($polaczenie->connect_errno!=0){
		throw new Exception(mysgli_connect_errno());
	}
	else{
		$rezultat_glos = $polaczenie->query("SELECT COUNT(id) as id FROM czas_przygotowania WHERE id_uzytkownika='$id_uzytkownika' AND id_przepisu='$id_przepisu'");
		$wiersz_glos = $rezultat_glos->fetch_assoc();
		if($wiersz_glos['id'] == 0){
			$polaczenie->query("INSERT INTO czas_przygotowania VALUES(NULL,'$id_uzytkownika','$id_przepisu','$czas_przygotowania')");

			$rezultat = $polaczenie->query("SELECT SUM(czas_przygotowania_p)/COUNT(id) as cp FROM czas_przygotowania WHERE id_przepisu='$id_przepisu'");
			$wiersz_czas_przygotowania = $rezultat->fetch_assoc();

			if($wiersz_czas_przygotowania['cp'] < 0.60 AND $wiersz_czas_przygotowania['cp'] >= 0.00){
				echo '<span style="color: #EA2027;">Nie poprawny</span>';
			}
			else{
				echo '<span style="color: #009432;">Poprawny</span>';
			}
		}
		elseif($wiersz_glos['id'] > 0){
			echo "Już głosowałeś !";
		}

		$polaczenie->close();
	} 
}
catch (Exception $e) {
	echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
	echo "Informacja developera: ".$e;
}