<?php

	session_start();

	if(isset($_POST['uzytkownik'])){
		//Udana walidacja ? Załóżmy że tak 
		$wszystko_OK = true;

		//Sprawdzanie poprawności nazwy użytkownika
		$uzytkownik = $_POST['uzytkownik'];
		if((strlen($uzytkownik) < 3 || (strlen($uzytkownik) > 20))){
			$wszystko_OK = false;
			$_SESSION['e_uzytkownik'] = "Nazwa użytkownika musi posiadać od 3 do 20 znaków";
		}
		if(ctype_alnum($uzytkownik) == false){
			$wszystko_OK = false;
			$_SESSION['e_uzytkownik'] = "Nazwa użytkownika może zawierać tylko litery i cyfry";
		}

		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($email != $emailB)){
			$wszystko_OK = false;
			$_SESSION['e_email'] = "Podaj poprawny adres email";
		}

		//Sprawdzanie poprawności haseł
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		if((strlen($haslo1) < 3) || (strlen($haslo1) > 20)){
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = "Hasło musi posiadac od 3 do 20 znaków";
		}

		if($haslo1 != $haslo2){
			$wszystko_OK = false;
			$_SESSION['e_haslo'] = "Podane hasła są różne";
		}

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

		$_SESSION['pd_uzytkownik'] = $uzytkownik;
		$_SESSION['pd_email'] = $email;

		require_once "polaczenie.php";

		try {
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			else{

				$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
				$polaczenie->query("SET CHARSET utf8");

				$rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownicy WHERE email='$email'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				$ile_takich_uzytkownikow = $rezultat->num_rows;
				if($ile_takich_uzytkownikow > 0){
					$wszystko_OK = false;
					$_SESSION['e_email'] = "Istnieje już email o podanej nazwie";
				}

				$rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownicy WHERE uzytkownik='$uzytkownik'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				$ile_takich_uzytkownikow_n = $rezultat->num_rows;
				if($ile_takich_uzytkownikow_n > 0){
					$wszystko_OK = false;
					$_SESSION['e_uzytkownik'] = "Istnieje już użytkownik o podanej nazwie";
				}

				if($wszystko_OK == true){
					if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$uzytkownik', '$haslo_hash', '$email')")){
						$_SESSION['udanarejestracja'] = true;

						if(isset($_SESSION['uzytkownik'])) unset($_SESSION['uzytkownik']);
						if(isset($_SESSION['email']))unset($_SESSION['email']);

						if(isset($_SESSION['e_uzytkownik'])) unset($_SESSION['e_uzytkownik']);
						if(isset($_SESSION['e_email']))unset($_SESSION['e_email']);

						if(isset($_SESSION['pd_uzytkownik'])) unset($_SESSION['pd_uzytkownik']);
						if(isset($_SESSION['pd_email']))unset($_SESSION['pd_email']);
					}
				}

				}	
		
			}
		catch (Exception $e) {
			echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
			echo "Informacja developera: ".$e;
		}



	}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title>Rejestracja</title>
	<style> 
		.error{
			color: red;
		}
	</style>
</head>
<body>

	<div id="panel_rejestracji">
		<h2>Rejestracja</h2>
		<form method="POST">
			<label class="rejestracja_input"> Nazwa użytkownika: <br><input type="text" name="uzytkownik" placeholder="Wpisz swoją nazwe użytkownika" value="<?php 
				if(isset($_SESSION['pd_uzytkownik'])){ 
					echo $_SESSION['pd_uzytkownik']; 
					unset($_SESSION['pd_uzytkownik']);
				} 
			?>">
			<?php
				if(isset($_SESSION['e_uzytkownik'])){
					echo '<div class="error">'.$_SESSION['e_uzytkownik'].'</div>';
					unset($_SESSION['e_uzytkownik']);
				}
			?>
			</label>
			<label class="rejestracja_input"><br>Email: <br><input type="text" name="email" placeholder="wpisz adres email" value="<?php 
				if(isset($_SESSION['pd_email'])){ 
					echo $_SESSION['pd_email']; 
					unset($_SESSION['pd_email']);
				} 
			?>">
			<?php
				if(isset($_SESSION['e_email'])){
					echo '<div class="error">'.$_SESSION['e_email'].'</div>';
					unset($_SESSION['e_email']);
				}
			?>
			</label>
			<label class="rejestracja_input"><br>Haslo: <br><input type="password" name="haslo1" placeholder="Wpisz hasło">
			<?php
				if(isset($_SESSION['e_haslo'])){
					echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
					unset($_SESSION['e_haslo']);
				}
			?>
			</label>
			<label class="rejestracja_input"><br>Powtórz hasło: <br><input type="password" name="haslo2" placeholder="Powtórz hasło"></label>
			<label><br><input type="submit" value="Zarejestruj się"></label>
		</form>
	</div>

</body>
</html>