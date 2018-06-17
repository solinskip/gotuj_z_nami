<?php
session_start();

	if(isset($_POST['uzytkownik'])){
		//Udana walidacja ? Załóżmy że tak 
		$wszystko_OK = true;
		$errorUzytkownik = false;
		$errorEmail = false;
		$errorHaslo = false;

		//Sprawdzanie poprawności nazwy użytkownika
		$uzytkownik = $_POST['uzytkownik'];
		if((strlen($uzytkownik) < 3 || (strlen($uzytkownik) > 20))){
			$wszystko_OK = false;
			$errorUzytkownik = true;
			echo '<span class="form_error_span">Nazwa użytkownika musi posiadać od 3 do 20 znaków</span><br>';
		}
		if(ctype_alnum($uzytkownik) == false){
			$wszystko_OK = false;
			$errorUzytkownik = true;
			echo '<span class="form_error_span">Nazwa użytkownika może zawierać tylko litery i cyfry</span><br>';
		}

		$email = $_POST['email'];
		if(empty($email)){
			$wszystko_OK = false;
			$errorEmail = true;
			echo '<span class="form_error_span">Wpisz adres email</span><br>
			';
			if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
				$wszystko_OK = false;
				$errorEmail = true;
				echo '<span class="form_error_span">Podaj poprawny adres email</span><br>';
			}
		}

		//Sprawdzanie poprawności haseł
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		if((strlen($haslo1) < 3) || (strlen($haslo1) > 20)){
			$wszystko_OK = false;
			$errorHaslo = true;
			echo '<span class="form_error_span">Hasło musi posiadac od 3 do 20 znaków</span><br>';
		}

		if($haslo1 != $haslo2){
			$wszystko_OK = false;
			$errorHaslo = true;
			echo '<span class="form_error_span">Podane hasła są różne</span>';
		}

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

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
					$errorEmailIstniejeTekst = "Istnieje już email o podanej nazwie";
				}

				$rezultat = $polaczenie->query("SELECT id_uzytkownika FROM uzytkownicy WHERE uzytkownik='$uzytkownik'");
				if(!$rezultat) throw new Exception($polaczenie->error);
				$ile_takich_uzytkownikow_n = $rezultat->num_rows;
				if($ile_takich_uzytkownikow_n > 0){
					$wszystko_OK = false;
					$errorUzytkownikIstniejeTekst = "Istnieje już użytkownik o podanej nazwie";
				}

				if($wszystko_OK){
					if($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$uzytkownik', '$haslo_hash', '$email')")){
						$_SESSION['udanarejestracja'] = true; 
						?>
						<script type="text/javascript">
							$(".rejestracja_cialo").hide();
							$("#rejestracja_udana").show();
						</script>
					<?php }
				}
			}	
		}
		catch (Exception $e) {
			echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
			echo "Informacja developera: ".$e;
		}
	}
?>

<script type="text/javascript">
	$("#uzytkownik, #email, #haslo1, #haslo2").removeClass("rejestracja_input_error");

	var errorUzytkownik = "<?php echo $errorUzytkownik; ?>";
	var errorEmail = "<?php echo $errorEmail; ?>";
	var errorHaslo = "<?php echo $errorHaslo ?>";
	

	if(errorUzytkownik == true){
		$("#uzytkownik").addClass("rejestracja_input_error");
	}
	if(errorEmail == true){
		$("#email").addClass("rejestracja_input_error");
	}
	if(errorHaslo == true){
		$("#haslo1, #haslo2").addClass("rejestracja_input_error");

	}
</script>