<?php
	session_start();
	require_once "polaczenie.php";
	if(!$_SESSION['zalogowany']){
		header('Location: index.php');
		exit();
	}
	$id_edycja = $_GET['id'];
	if(isset($_SESSION['flaga_edycja'])) { $flaga_edycja = $_SESSION['flaga_edycja']; }

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

		// $target_dir = "obrazy_potraw/";
		// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		// $uploadOk = 1;
		// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// $target_file_save = $target_dir.($wiersz['id_przepisu'] + 1).'.'.$imageFileType;
		// // Check if image file is a actual image or fake image
		// if(isset($_POST["submit"])) {
		//     $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		//     if($check !== false) {
		//         $upload_image_error = "Plik o nazwie - " . $check["mime"] . ".";
		//         $uploadOk = 1;
		//     } else {
		//         $upload_image_error = "Plik nie jest obrazem.";
		//         $uploadOk = 0;
		//     }
		// }
		// // Check if file already exists
		// if (file_exists($target_file)) {
		//     $upload_image_error = "Wybrany przez ciebie plik już istnieje.";
		//     $uploadOk = 0;
		// }
		// // Check file size
		// if ($_FILES["fileToUpload"]["size"] > 500000) {
		//     $upload_image_error = "Wybrany plik jest za duży.";
		//     $uploadOk = 0;
		// }
		// // Allow certain file formats
		// if($imageFileType != "jpg") {
		//     $upload_image_error = "Dozwolone rozszerzenia obrazu to - JPG.";
		//     $uploadOk = 0;
		// }
		// // Check if $uploadOk is set to 0 by an error
		// if ($uploadOk == 0) {
		//     $upload_image_error = "Obraz nie został poprawnie wgrany na serwer.";
		// // if everything is ok, try to upload file
		// } else {
		//     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file_save)) {
		//         $wszystkoOK = true;
		//     } else {
		//         $upload_image_error = "Przepraszamy podczas wgrywania wystąpił błąd.";
		//         $wszystkoOK =false;
		//     }
		// }
		//walidacja pól

		//sprawdzanie poprawności tytułu
		$tytul_p = $_POST['tytul_p'];
		if((strlen($tytul_p) <= 3) || (strlen($tytul_p) > 50)){
			$tytul_p_error = "Tytuł powinien zawierać od 3 do 30 znaków";
			$wszystkoOK = false;
		}

		//sprawdzanie wstępu 
		$wstep_p = $_POST['wstep_p'];
		if((strlen($wstep_p) <10) || (strlen($_POST['wstep_p']) > 200)){
			$wstep_p_error = "Wstep powinien zawierać od 10 do 200 znaków";
			$wszystkoOK = false;
		}

		//sprawdzanie skladników
		$skladnik_p_1 = $_POST['skladnik_p1'];
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
		
		$stopien_t=$_POST['stopien_t'];
		if(!isset($_POST['stopien_t'])){
			$stopien_t_error = "Wybierz stopień trudności potrawy";
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

		$skladnik_d_p = $_POST['skladnik_p1'];
		if((strlen($skladnik_d_p)) < 2){
			$skladnik_d_p_error = "Podaj przynajmniej jeden składnik";
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
					$id_uzytkownika = $_SESSION['id_uzytkownika'];
					if(isset($_POST['danie_bezglutenowe'])) { $danie_bezglutenowe = $_POST['danie_bezglutenowe']; }
					if(isset($_POST['danie_wegetarianskie'])) { $danie_wegetarianskie = $_POST['danie_wegetarianskie']; }
					if(isset($_POST['danie_dietetyczne'])) { $danie_dietetyczne = $_POST['danie_dietetyczne']; }
					if(isset($_POST['danie_dla_dzieci'])) { $danie_dla_dzieci = $_POST['danie_dla_dzieci']; }
					if(isset($_POST['szybka_kuchnia'])) { $szybka_kuchnia = $_POST['szybka_kuchnia']; }

					$tmp = "1";
					while(isset($_POST['skladnik_p'.$tmp])){
						if($tmp==1){ $skladniki = $_POST['skladnik_p'.$tmp]; }
						else{ $skladniki = $skladniki.",".$_POST['skladnik_p'.$tmp]; }
						$tmp +=1;
					}

					if($polaczenie->query("UPDATE przepisy SET tytul='$tytul_p', skladniki='$skladniki', przygotowanie='$przygotowanie_d_p', skrot_opis='$wstep_p', id_kategori='$kategoria_d_p', czas_przygotowania='$czas_przygotowania_d_p', stopien_trudnosci='$stopien_t', liczba_porcji='$skladniki_na_d_p', id_spos_przygotowania='$sposob_przygotowania_d_p', d_bezglutenowe='$danie_bezglutenowe', d_wegetarianskie='$danie_wegetarianskie', d_dietetyczne='$danie_dietetyczne', d_dla_dzieci='$danie_dla_dzieci', szybka_kuchnia='$szybka_kuchnia' WHERE id_przepisu='$id_edycja'")){
						unset($danie_bezglutenowe);
						unset($danie_wegetarianskie);
						unset($danie_dietetyczne);
						unset($danie_dla_dzieci);
						unset($szybka_kuchnia);
						header ('Location: przepis.php?id='.$id_edycja);
						exit();
					}
				$polaczenie->close();
				}	
			} 
			catch (Exception $e) {
				echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
				echo "Informacja developera: ".$e;
			}
		}
	}

		//sprawdzanie czy wcześniej były zaznaczone pole select-kategoria i sposób przygotowania
	$i = 2;
	$koniec_f = true;
	function select_ks($tmp){
		global $koniec_f;
		if(!$koniec_f){
			global $i;
			if($tmp == $i) { 
				echo "selected";
				$i=2;
				$koniec_f = true;
			}
			else {
				$i++;
			}
		}
	}

	//pobieranie kategori i sposobów przygotowania oraz wczesniej wprowadzonych danych do bazy
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
			if($flaga_edycja){
				$rezultat_edycja = @$polaczenie->query("SELECT * FROM przepisy WHERE id_przepisu='$id_edycja'");
				$wiersz_edycja = $rezultat_edycja->fetch_assoc();
			}

			$polaczenie->close();
		}
	} 
	catch (Exception $e) {
		echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
		echo "Informacja developera: ".$e;
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="jquery.leanModal.min.js"></script>
<script type="text/javascript" src="skrypt.js"></script>
<meta charset="utf-8"/>

<title>Gotuj z Nami - Profil</title>

<link rel="stylesheet" type="text/css" href="style.css"/>
<link rel="stylesheet" type="text/css" href="css/fontello.css">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700i&amp;subset=latin-ext" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
</head>
<body>
<div id="kontener_nowy_przepis">
<?php require_once 'naglowek.php'; ?>
<div id="nowy_przepis">
	<div>
		<h1 class="np_dp">Edytuj przepis</h1>
	</div>
	<div id="tresc_przepisu">
		<form method="POST" enctype="multipart/form-data">
			<div class="wiersz_p">
				<label class="tytul_d_p">Tytuł</label>
				<input type="text" name="tytul_p" class="input_p1" maxlength="100" 
				<?php if($flaga_edycja){ echo 'value="'.$wiersz_edycja['tytul'].'"'; }
				else{ if(isset($_POST['tytul_p'])){ echo 'value="'.$_POST['tytul_p'].'"'; } } ?>>
				<?php if(isset($tytul_p_error)){
					echo '<div class="error_d_p">'.$tytul_p_error.'</div>';
					unset($tytul_p_error);
				} ?>
			</div>
			<div class="wiersz_p">
				<label class="tytul_d_p">Wstęp</label>
				<input type="text" class="input_p1" name="wstep_p"
				<?php if($flaga_edycja){ echo 'value="'.$wiersz_edycja['skrot_opis'].'"'; }
				else{ if(isset($_POST['wstep_p'])){ echo 'value="'.$_POST['wstep_p'].'"'; } } ?>>
				<?php if(isset($wstep_p_error)){
					echo '<div class="error_d_p">'.$wstep_p_error.'</div>';
					unset($wstep_p_error);
				} ?>
			</div>
			<div class="wiersz_pfl">
				<div id="miniatura_dodanej_potrawy"></div>
  				<label class="tytul_d_p">Wybierz zdjęcie potrawy</label>
   				<input type="file" name="fileToUpload" id="fileToUpload" class="input_p2" multiple accept="image/*" onchange="wyswietl_miniature(this.files)">
   				<?php if(isset($upload_image_error)){
   					echo '<div class="error_d_p">'.$upload_image_error.'</div>';
					unset($upload_image_error);
				} ?>
			</div>
			<div class="wiersz_pfl">
				<div class="wiersz_p">
					<label class="tytul_d_p">Kategoria</label>
					<select name="kategoria_d_p" class="input_p">
						<option value="1">--wybierz--</option>
						<?php $koniec_f = false; while($kategoria = $rezultat_kategorie->fetch_assoc()) { ?>
						<option value="<?php echo $kategoria['id_kategori']; ?>"  
							<?php if($flaga_edycja){ select_ks($wiersz_edycja['id_kategori']); } else { if(isset($_POST['kategoria_d_p'])){ select_ks($kategoria_d_p); } } ?> >
							<?php  echo $kategoria['nazwa_kategori']; ?>
						</option>
						<?php } ?>
					</select>
					<?php if(isset($kategoria_d_p_error)){
					echo '<div class="error_d_p">'.$kategoria_d_p_error.'</div>';
					unset($kategoria_d_p_error);
				} ?>
				</div>
				<div class="wiersz_p">
					<label class="tytul_d_p">Sposób przygotowania</label>
					<select name="sposob_przygotowania_d_p" class="input_p">
						<option value="0">--wybierz--</option>
						<?php $koniec_f = false; $i-=1; while($sposob_przygotowania = $rezultat_sposob_przygotowania->fetch_assoc()){ ?>
						<option value="<?php echo $sposob_przygotowania['id_spos_przygotowania']; ?>" 
							<?php if($flaga_edycja){ select_ks($wiersz_edycja['id_spos_przygotowania']); } else { if(isset($_POST['sposob_przygotowania_d_p'])){ select_ks($sposob_przygotowania_d_p); } } ?> >
							<?php echo $sposob_przygotowania['nazwa_spos_przygotowania']; ?>
							</option>
						<?php } ?>
					</select>
					<?php if(isset($sposob_przygotowania_d_p_error)){
					echo '<div class="error_d_p">'.$sposob_przygotowania_d_p_error.'</div>';
					unset($sposob_przygotowania_d_p_error);
					} ?>
				</div>
				<div class="wiersz_p">
					<label class="tytul_d_p">Stopień trudności</label>
					<div class="stopien_trudnosci_d">	
					<label class="radio_checkbox">Łatwy
						<input type="radio" name="stopien_t" value="1" 
						<?php if($flaga_edycja) { if($wiersz_edycja['stopien_trudnosci'] == 1) echo "checked"; }
						else { if(isset($_POST['stopien_t']) AND $_POST['stopien_t'] == 1) echo "checked"; } ?>>
						<span class="checkmark"></span>
					</label>
					<label class="radio_checkbox">Średni
						<input type="radio" name="stopien_t" value="2" 
						<?php if($flaga_edycja) { if($wiersz_edycja['stopien_trudnosci'] == 2) echo "checked"; }
						else { if(isset($_POST['stopien_t']) AND $_POST['stopien_t'] == 2) echo "checked"; } ?>>
						<span class="checkmark"></span>
					</label>
					<label class="radio_checkbox">Trudny
						<input type="radio" name="stopien_t" value="3" 
						<?php if($flaga_edycja) { if($wiersz_edycja['stopien_trudnosci'] == 3) echo "checked"; }
						else { if(isset($_POST['stopien_t']) AND $_POST['stopien_t'] == 3) echo "checked"; } ?>>
						<span class="checkmark"></span>
					</label>
					<div style="clear: both;"></div>
					<?php if(isset($stopien_t_error)){
						echo '<div class="error_d_p">'.$stopien_t_error.'</div>';
						unset($stopien_t_error);
					} ?>
				</div>
				
				</div>
				<div class="wiersz_p">
					<label class="tytul_d_p">Czas przygotowania</label><br>
					<input class="input_p_bd" type="text" name="czas_przygotowania_d_p" 
					<?php if($flaga_edycja){ echo 'value="'.$wiersz_edycja['czas_przygotowania'].'"'; }
					else{ if(isset($_POST['czas_przygotowania_d_p'])){ echo 'value="'.$_POST['czas_przygotowania_d_p'].'"'; } } ?>> min.
					<?php if(isset($czas_przygotowania_d_p_error)){
					echo '<div class="error_d_p">'.$czas_przygotowania_d_p_error.'</div>';
					unset($czas_przygotowania_d_p_error);
					}
					else{ echo '<br>'; } ?>
				</div>
				<div class="wiersz_p">
					<label class="tytul_d_p">Składni na</label><br>
					<input class="input_p_bd" type="text" name="skladniki_na_d_p" 
					<?php if($flaga_edycja){ echo 'value="'.$wiersz_edycja['liczba_porcji'].'"'; }
					else{ if(isset($_POST['skladniki_na_d_p'])){ echo 'value="'.$_POST['skladniki_na_d_p'].'"'; } } ?>> porcji
					<?php if(isset($skladniki_na_d_p_error)){
						echo '<div class="error_d_p">'.$skladniki_na_d_p_error.'</div>';
						unset($skladniki_na_d_p_error);
					}
				else{ echo '<br>'; } ?>
				</div>
				<label class="radio_checkbox">Danie bezglutenowe
					<input type="checkbox" name="danie_bezglutenowe" value="1" 
					<?php if($flaga_edycja) { if($wiersz_edycja['d_bezglutenowe'] == 1) echo "checked"; }
					else { if(isset($_POST['danie_bezglutenowe']) AND $_POST['danie_bezglutenowe'] == 1) echo "checked"; } ?>>
					<span class="checkmark"></span>
				</label>
				<label class="radio_checkbox">Danie wegetariańskie
					<input type="checkbox" name="danie_wegetarianskie" value="1" 
					<?php if($flaga_edycja) { if($wiersz_edycja['d_wegetarianskie'] == 1) echo "checked"; }
					else { if(isset($_POST['danie_wegetarianskie']) AND $_POST['danie_wegetarianskie'] == 1) echo "checked"; } ?>>
					<span class="checkmark"></span>
				</label>
				<label class="radio_checkbox">Danie dietetyczne
					<input type="checkbox" name="danie_dietetyczne" value="1" 
					<?php if($flaga_edycja) { if($wiersz_edycja['d_dietetyczne'] == 1) echo "checked"; }
					else { if(isset($_POST['danie_dietetyczne']) AND $_POST['danie_dietetyczne'] == 1) echo "checked"; } ?>>
					<span class="checkmark"></span>
				</label>
				<label class="radio_checkbox"></label>
				<label class="radio_checkbox" style="margin-left: -25px !important ;">Danie dla dzieci
					<input type="checkbox" name="danie_dla_dzieci" value="1" 
					<?php if($flaga_edycja) { if($wiersz_edycja['d_dla_dzieci'] == 1) echo "checked"; }
					else { if(isset($_POST['danie_dla_dzieci']) AND $_POST['danie_dla_dzieci'] == 1) echo "checked"; } ?>>
					<span class="checkmark"></span>
				</label>
				<label class="radio_checkbox">Szybka kuchnia
					<input type="checkbox" name="szybka_kuchnia" value="1" 
					<?php if($flaga_edycja) { if($wiersz_edycja['szybka_kuchnia'] == 1) echo "checked"; }
					else { if(isset($_POST['szybka_kuchnia']) AND $_POST['szybka_kuchnia'] == 1) echo "checked"; } ?>>
					<span class="checkmark"></span>	
				</label>
			</div>
			<div style="clear: both;"></div>
			<div id="skladniki_p" class="wiersz_pfl">
				<label class="tytul_d_p">Składniki</label>
				<?php if($flaga_edycja){ $skladniki = explode(",", $wiersz_edycja['skladniki']);
					for ($i=0; $i < count($skladniki); $i++) { 
						echo '<input class="input_p" type="text" name="skladnik_p'.($i+1).'" value="'.$skladniki[$i].'">';
					}
				} ?>
				<?php if(isset($skladnik_d_p_error)){
					echo '<div class="error_d_p">'.$skladnik_d_p_error.'</div>';
					unset($skladnik_d_p_error);
				} ?>
				<div id="nowe_skladniki_p"></div>
				<a id="dodaj_skladnik_p">Dodaj nowy skladnik</a>
			</div>
			<div class="wiersz_pfl">
				<label class="tytul_d_p">Przygotowanie</label><br>
				<textarea class=""input_p" name="przygotowanie_d_p" rows=10 cols= 60><?php if($flaga_edycja){ echo $wiersz_edycja['przygotowanie']; }
					else{ if(isset($_POST['przygotowanie_d_p'])){ echo 'value="'.$_POST['przygotowanie_d_p'].'"'; } } ?>
				</textarea>
				<?php if(isset($przygotowanie_d_p_error)){
					echo '<div class="error_d_p">'.$przygotowanie_d_p_error.'</div>';
					unset($przygotowanie_d_p_error);
				} ?>
			</div>
			<div style="clear: both;"></div>
			<div class="wiersz_p">
				<?php $_SESSION['flaga_edycja'] = false; ?>
				<input class="dp_s" type="submit" name="Zapisz przepis">
			</div>
		</form>
	</div>
	</div>
</div>
</body>
</html>