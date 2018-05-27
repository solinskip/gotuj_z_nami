<?php 	
	session_start(); 
	require_once "polaczenie.php";
	$_SESSION['aktualna_strona'] = $_SERVER['REQUEST_URI']; 

	if(isset($_POST['tytul_p'])){
		$wszystkoOK = true;
		try {
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			else{
				$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
				$polaczenie->query("SET CHARSET utf8");
				$rezultat = @$polaczenie->query("SELECT id_przepisu FROM przepisy	ORDER BY id_przepisu DESC LIMIT 1");
				$wiersz = $rezultat->fetch_assoc();
				$polaczenie->close();
			}
		
		} 
		catch (Exception $e) {
				echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
				echo "Informacja developera: ".$e;
		}

		//dodawanie zdjęcia

		$target_dir = "obrazy_potraw/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$target_file_save = $target_dir.($wiersz['id_przepisu'] + 1).'.'.$imageFileType;
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        $upload_image_error = "Plik o nazwie - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        $upload_image_error = "Plik nie jest obrazem.";
		        $uploadOk = 0;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    $upload_image_error = "Wybrany przez ciebie plik już istnieje.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    $upload_image_error = "Wybrany plik jest za duży.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg") {
		    $upload_image_error = "Dozwolone rozszerzenia obrazu to - JPG.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    $upload_image_error = "Obraz nie został poprawnie wgrany na serwer.";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_save)) {
		        $wszystkoOK = true;
		    } else {
		        $upload_image_error = "Przepraszamy podczas wgrywania wystąpił błąd.";
		        $wszystkoOK =false;
		    }
		}
		//walidacja pól

		//sprawdzanie poprawności tytułu
		$tytul_p = $_POST['tytul_p'];
		if(strlen($tytul_p) <= 3){
			$tytul_p_error = "Tytuł powinien zawierać od 3 do 30 znaków";
			$wszystkoOK = false;
		}

		//sprawdzanie wstępu 
		$wstep_p = $_POST['wstep_p'];
		if((strlen($wstep_p) <10) || (strlen($_POST['wstep_p']) > 60)){
			$wstep_p_error = "Wstep powinien zawierać od 10 do 60 znaków";
			$wszystkoOK = false;
		}

		//sprawdzanie skladników
		$skladnik_p_1 = $_POST['skladnik_p_1'];
		if(strlen($skladnik_p_1) == 0){
			$skladnik_p_1_error = "Musisz podać przynajmniej jeden składnik";
			$wszystkoOK = false;
		}

		//sprawdanie kategori i sposobu przygotowania
		$kategoria_d_p = $_POST['kategoria_d_p'];
		if($kategoria_d_p == 1){
			$kategoria_d_p_error = "Wybierz kategorie potrawy";
			$wszystkoOK = false;
		}

		$sposob_przygotowania_d_p = $_POST['sposob_przygotowania_d_p'];
		if($sposob_przygotowania_d_p == 0){
			$sposob_przygotowania_d_p_error = "Wybierz sposób przygotowania potrawy";
			$wszystkoOK = false;
		}

		$czas_przygotowania_d_p = $_POST['czas_przygotowania_d_p'];
		if((strlen($czas_przygotowania_d_p)) == 0){
			$czas_przygotowania_d_p_error = "Podaj czas przygotowania potrawy";
			$wszystkoOK = false;
		}

		$skladniki_na_d_p = $_POST['skladniki_na_d_p'];
		if((strlen($skladniki_na_d_p)) == 0){
			$skladniki_na_d_p_error = "Podaj ilość porcji";
			$wszystkoOK = false;
		}

		$przygotowanie_d_p = $_POST['przygotowanie_d_p'];
		if((strlen($przygotowanie_d_p)) < 3){
			$przygotowanie_d_p_error = "Opis przygotowania dania powinien zawierać przynajmniej 30 znaków";
			$wszystkoOK = false;
		}

		//wgrywanie danych do bazy
		if($wszystkoOK == true){
			try {
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			}
			else{
				$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
				$polaczenie->query("SET CHARSET utf8");
				$uzytkownik = $_SESSION['uzytkownik'];
				if($polaczenie->query("INSERT INTO przepisy VALUES(NULL,'$tytul_p','','$przygotowanie_d_p','$wstep_p','$uzytkownik','$kategoria_d_p','$czas_przygotowania_d_p','','$skladniki_na_d_p','$sposob_przygotowania_d_p')")){ echo "wszystkoOK";}
				$polaczenie->close();
				echo "wszystkoOK";
			}
			} 
			catch (Exception $e) {
				echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
				echo "Informacja developera: ".$e;
			}
		}
	}

	//pobieranie kategori i sposobów przygotowania 
	try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			$polaczenie->query("SET CHARSET utf8");
			$rezultat_kategorie = @$polaczenie->query("SELECT * FROM kategorie");
			$rezultat_sposob_przygotowania = @$polaczenie->query("SELECT * FROM sposob_przygotowania");
			$polaczenie->close();
		}
	} 
	catch (Exception $e) {
		echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
		echo "Informacja developera: ".$e;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dodaj nowy przepis</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.leanModal.min.js"></script>
	<script type="text/javascript" src="skrypt.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet">
</head>
<body>
<div id="kontener_nowy_przepis">
	<?php require_once 'naglowek.php'; ?>
	<div id="nowy_przepis">
		<?php if(!isset($_SESSION['zalogowany'])){ ?>
			<div id="nie_zalogowany_n_p">
				<h2>Aby dodać nowy przepis musisz być zalogowany.</h2>
				<img height="400" width="400" src="obrazy_potraw/strzalka_prawo_zielona.png">
			</div>
		<?php } else{ ?>
			<div>
				<h2>Dodaj przepis</h2>
			</div>
			<div id="tresc_przepisu">
				<form method="POST" enctype="multipart/form-data">
					<div class="wiersz_p">
						<label class="tytul_d_p">Tytuł</label>
						<input type="text" name="tytul_p" class="input_p" maxlength="100" <?php echo (isset($_POST['tytul_p'])) ? 'value="'.$_POST['tytul_p'].'"' : ''; ?>>
						<?php if(isset($tytul_p_error)){
							echo '<div class="error_d_p">'.$tytul_p_error.'</div>';
							unset($tytul_p_error);
						} ?>
					</div>
					<div class="wiersz_p">
						<label class="tytul_d_p">Wstęp</label>
						<input type="text" class="input_p" name="wstep_p" <?php echo (isset($_POST['wstep_p'])) ? 'value="'.$_POST['wstep_p'].'"' : ''; ?>>
						<?php if(isset($wstep_p_error)){
							echo '<div class="error_d_p">'.$wstep_p_error.'</div>';
							unset($wstep_p_error);
						} ?>
					</div>
					<div class="wiersz_pfl">
						<div id="miniatura_dodanej_potrawy"></div>
		  				<label class="tytul_d_p">Wybierz zdjęcie potrawy</label>
		   				<input type="file" name="fileToUpload" id="fileToUpload" class="input_p" multiple accept="image/*" onchange="wyswietl_miniature(this.files)">
		   				<?php if(isset($upload_image_error)){
		   					echo '<div class="error_d_p">'.$upload_image_error.'</div>';
							unset($upload_image_error);
						} ?>
					</div>
					<div class="wiersz_pfl">
						<label class="tytul_d_p">Kategoria</label>
						<select name="kategoria_d_p" class="input_p">
							<option value="1">--wybierz--</option>
							<?php while($kategoria = $rezultat_kategorie->fetch_assoc()) { ?>
								<option value="<?php echo $kategoria['id_kategori']; ?>"><?php echo $kategoria['nazwa_kategori']; ?></option>
							<?php } ?>
						</select>
						<?php if(isset($kategoria_d_p_error)){
							echo '<div class="error_d_p">'.$kategoria_d_p_error.'</div>';
							unset($kategoria_d_p_error);
						} ?>
						<label class="tytul_d_p">Sposób przygotowania</label>
						<select name="sposob_przygotowania_d_p" class="input_p" >
							<option value="0">--wybierz--</option>
							<?php while($sposob_przygotowania = $rezultat_sposob_przygotowania->fetch_assoc()){ ?>
							<option value="<?php echo $sposob_przygotowania['id_spos_przygotowania']; ?>"><?php echo $sposob_przygotowania['nazwa_spos_przygotowania']; ?></option>
							<?php } ?>
						</select>
						<?php if(isset($sposob_przygotowania_d_p_error)){
							echo '<div class="error_d_p">'.$sposob_przygotowania_d_p_error.'</div>';
							unset($sposob_przygotowania_d_p_error);
						} ?>
						<label class="tytul_d_p">Czas przygotowania</label><br>
						<input  type="text" name="czas_przygotowania_d_p" <?php echo (isset($_POST['czas_przygotowania_d_p'])) ? 'value="'.$_POST['czas_przygotowania_d_p'].'"' : ''; ?>> min.
						<?php if(isset($czas_przygotowania_d_p_error)){
							echo '<div class="error_d_p">'.$czas_przygotowania_d_p_error.'</div>';
							unset($czas_przygotowania_d_p_error);
						}
						else{ echo '<br>'; } ?>
						<label class="tytul_d_p">Skadni na</label><br>
						<input type="text" name="skladniki_na_d_p" <?php echo (isset($_POST['skladniki_na_d_p'])) ? 'value="'.$_POST['skladniki_na_d_p'].'"' : ''; ?>> porcji
						<?php if(isset($skladniki_na_d_p_error)){
							echo '<div class="error_d_p">'.$skladniki_na_d_p_error.'</div>';
							unset($skladniki_na_d_p_error);
						}
						else{ echo '<br>'; } ?>
						<label><input type="checkbox" name="danie_bezglutenowe" value="1">Danie bezglutenowe</label>
						<label><input type="checkbox" name="danie_wegetarianskie" value="1">Danie wegetariańskie</label>
						<label><input type="checkbox" name="danie_dietetyczne" value="1">Danie dietetyczne</label>
						<label class="input_p"><input type="checkbox" name="danie_dla_dzieci" value="1">Danie dla dzieci</label>
						<label><input type="checkbox" name="szybka_kuchnia" value="1">Szybka kuchnia</label>
					</div>
					<div style="clear: both;"></div>
					<div id="skladniki_p" class="wiersz_pfl">
						<label class="tytul_d_p">Składniki</label>
						<input class="input_p" type="text" name="skladnik_p_1">
						<?php if(isset($skladnik_p_1_error)){
							echo '<div class="error_d_p">'.$skladnik_p_1_error.'</div>';
							unset($skladnik_p_1_error);
						} ?>
						<div id="nowe_skladniki_p"></div>
						<a id="dodaj_skladnik_p">Dodaj nowy skladnik</a>
					</div>
					<div class="wiersz_pfl">
						<label class="tytul_d_p">Przygotowanie</label><br>
						<textarea name="przygotowanie_d_p" rows=10 cols= 60><?php echo (isset($_POST['przygotowanie_d_p'])) ? $_POST['przygotowanie_d_p'] : ''; ?></textarea>
						<?php if(isset($przygotowanie_d_p_error)){
							echo '<div class="error_d_p">'.$przygotowanie_d_p_error.'</div>';
							unset($przygotowanie_d_p_error);
						} ?>
					</div>
					<div style="clear: both;"></div>
					<div class="wiersz_p">
						<input type="submit" name="Zapisz przepis">
					</div>
				</form>
			</div>
		<?php } ?>
	</div>
</div>
</body>
</html>