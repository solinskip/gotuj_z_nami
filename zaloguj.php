<?php
	session_start();

	if((!isset($_POST['uzytkownik']) || (!isset($_POST['haslo'])))){
		header('Location: '.$_SESSION['aktualna_strona']);
		exit();
	}

	require_once "polaczenie.php";

	try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			$uzytkownik = $_POST['uzytkownik'];
			$haslo = $_POST['haslo'];

			$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			$polaczenie->query("SET CHARSET utf8");

			$uzytkownik = htmlentities($uzytkownik, ENT_QUOTES, "UTF-8");

			if($rezultat = @$polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE uzytkownik='%s'", mysqli_real_escape_string($polaczenie,$uzytkownik)))){
				$ile_wynikow = $rezultat->num_rows;
				if($ile_wynikow > 0){
					$wiersz = $rezultat->fetch_assoc();
					if(password_verify($haslo,$wiersz['haslo'])){
						$_SESSION['zalogowany'] = true;
						$_SESSION['uzytkownik'] = $wiersz['uzytkownik'];
						header('Location: '.$_SESSION['aktualna_strona']);
					}
					else{
						$_SESSION['blad_logowania'] = true;
						header('Location: '.$_SESSION['aktualna_strona']);
					}
				}
				else{
					$_SESSION['blad_logowania'] = true;
					header('Location: '.$_SESSION['aktualna_strona']);
				}
			}
			$polaczenie->close();
		}
	} catch (Exception $e) {
			echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
			echo "Informacja developera: ".$e;
	}
