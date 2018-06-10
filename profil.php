<?php
	session_start();
	$_SESSION['aktualna_strona'] = $_SERVER['REQUEST_URI'];
	require_once "polaczenie.php";
	if(!$_SESSION['zalogowany']){
		header('Location: index.php');
		exit();
	}
	if(isset($_SESSION['id_uzytkownika'])) { $id_uzytkownika = $_SESSION['id_uzytkownika']; }

	try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysgli_connect_errno());
		}
		else{
			$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			$polaczenie->query("SET CHARSET utf8");
			
			$rezultat_statystyki = @$polaczenie->query("
				SELECT COUNT(przepisy.id_uzytkownika) AS ldp, 
				(SELECT COUNT(oceny.id_uzytkownika) FROM oceny WHERE oceny.id_uzytkownika='$id_uzytkownika') AS lop, 
				(SELECT COUNT(komentarze.id_uzytkownika) FROM komentarze WHERE komentarze.id_uzytkownika='$id_uzytkownika') AS lnk,
                (SELECT uzytkownicy.uzytkownik FROM uzytkownicy WHERE uzytkownicy.id_uzytkownika='$id_uzytkownika') AS uzytkownik
				FROM przepisy 
				WHERE przepisy.id_uzytkownika='$id_uzytkownika'
				");

			$rezultat_dodane_przepisy = @$polaczenie->query("SELECT id_przepisu,tytul FROM przepisy WHERE id_uzytkownika='$id_uzytkownika'");

			$wiersz_s = $rezultat_statystyki->fetch_assoc();
			$polaczenie->close();
		}
		
	} catch (Exception $e) {
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
<div id="profil_kontener">
	<?php require_once "naglowek.php"; ?>

	<div class="profil_pojemnik">
		<h2>Statystyki dla profilu: <?php echo $wiersz_s['uzytkownik'] ?></h2>
		<div class="pp_info">
			Liczba dodanych przepisów:
			<span class="pp_info_w"><?php echo $wiersz_s['ldp'] ?></span>
		</div>
		<div class="pp_info">
			Liczba ocenionych przepisów:
			<span class="pp_info_w"><?php echo $wiersz_s['lop'] ?></span>
		</div>
		<div class="pp_info">
			Liczba napisanych komentarzy:
			<span class="pp_info_w"><?php echo $wiersz_s['lnk'] ?></span>
		</div>
		<table>
			<tr>
				<th>Dodane przepisy</th>
			</tr>
			<?php while($wiersz_dp = $rezultat_dodane_przepisy->fetch_assoc()){ 
				if($rezultat_dodane_przepisy->num_rows > 0){ ?>
					<tr>
						<td><?php echo $wiersz_dp['tytul']; ?></td>
						<td><a href="edytuj_przepis.php?id=<?php echo $wiersz_dp['id_przepisu']; $_SESSION['flaga_edycja'] = true; ?>"> Edytuj</a></td>
					</tr>
				<?php } 
				else {
					echo "Brak dodanych przepisów";
				}
			 } ?>
		</table>
	</div>
</div>
</body>
</html>