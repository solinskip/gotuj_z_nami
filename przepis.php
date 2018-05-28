<?php
	session_start();
	require_once 'polaczenie.php';
	$id_przepisu = $_GET['id'];

	try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysgli_connect_errno());
		}
		else{
		$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$polaczenie->query("SET CHARSET utf8");
		$rezultat = $polaczenie->query("SELECT p.*,sp.nazwa_spos_przygotowania FROM przepisy AS p LEFT JOIN sposob_przygotowania AS sp ON p.id_spos_przygotowania=sp.id_spos_przygotowania WHERE p.id_przepisu='$id_przepisu'");
		$rezultat_komentarze = $polaczenie->query("SELECT uzytkownicy.uzytkownik, komentarze.komentarz, komentarze.data FROM komentarze LEFT JOIN przepisy ON przepisy.id_przepisu=komentarze.id_przepisu LEFT JOIN uzytkownicy ON komentarze.id_uzytkownika=uzytkownicy.id_uzytkownika WHERE komentarze.id_przepisu='1' ORDER BY komentarze.data DESC");
		
		$wiersz = $rezultat->fetch_assoc();
		$tytul_slowa = explode(" ", $wiersz['tytul']); //pierwsze słowo tytułu

		$polaczenie->close();
		}
		
	} catch (Exception $e) {
		echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
		echo "Informacja developera: ".$e;
	}

	function informacja() {
		global $wiersz;
		if($wiersz['d_bezglutenowe'] == 1)
			echo '<i class="icon-check"></i>Danie bezglutenowe<br>';
		if($wiersz['d_wegetarianskie'] == 1)
			echo '<i class="icon-check"></i>Danie wegetariańskie<br>';
		if($wiersz['d_dietetyczne'] == 1)
			echo '<i class="icon-check"></i>Danie dietetyczne<br>';
		if($wiersz['d_dla_dzieci'] == 1)
			echo '<i class="icon-check"></i>Danie dla dzieci<br>';
		if($wiersz['szybka_kuchnia'] == 1)
			echo '<i class="icon-check"></i>Szybka kuchnia<br>';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Przepis na <?php echo $wiersz['tytul']; ?></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.leanModal.min.js"></script>
	<script type="text/javascript" src="skrypt.js"></script>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700i&amp;subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/fontello.css">
</head>
<body>

<div id="przepis_kontener">
	<?php require_once 'naglowek.php'; ?>
	<div id="przepis_zawartosc_przepisu">
		<h1 class="przepis_tytul_przepisu"><?php echo $wiersz['tytul']; ?></h1>
		<div class="przepis_skrot_opis">
			<?php echo $wiersz['skrot_opis']; ?>
		</div>
		<div class="przepis_dodany_przez">
			Przepis został dodany przez: <span class="przepis_dodany_przez_osoba"><?php echo $wiersz['autor']; ?></span>
		</div>
		<div class="przepis_zdjecie_przepisu">
			<img src="obrazy_potraw/<?php echo $id_przepisu; ?>.jpg">
		</div>
		<div class="przepis_info_przepisu">
			<dl>
				<dt>Sposób przygotowania:</dt>
				<dd><i class="icon-lightbulb"></i><?php echo $wiersz['nazwa_spos_przygotowania']; ?></dd>
				<dt>Czas przygotowania:</dt>
				<dd><i class="icon-clock-black"></i><?php echo $wiersz['czas_przygotowania']; ?> min.</dd>
				<dt>Liczba porcji:</dt>
				<dd><i class="icon-food"></i><?php echo $wiersz['liczba_porcji']; ?> porcje</dd>
				<dt>Inne informację:</dt>
				<dd><?php informacja(); ?></dd>
				<dt>Ocena przepisu:</dt>
				<dd>
					<i class="icon-star-empty" name="1"></i>
					<i class="icon-star-empty" name="2"></i>
					<i class="icon-star-empty" name="3"></i>
					<i class="icon-star-empty" name="4"></i>
					<i class="icon-star-empty" name="5"></i>
				</dd>
			</dl>
		</div>
		<div style="clear: both;"></div>
		<div class="przepis_skladniki">
			<div class="pipt">Skladniki:</div>
			<ul>
				<?php $skladniki = explode(",", $wiersz['skladniki']);
				count($skladniki);
				for ($i=0; $i < 6; $i++) { 
					echo '<li>'.$skladniki[$i].'</li>';
				} ?>
			</ul>
		</div>
		<div class="przepis_przygotowanie">
			<div class="pipt">Przygotowanie:</div>
			<?php 
				echo nl2br($wiersz['przygotowanie']); 
			?> 
		</div>
		<div style="clear: both;"></div>
		<hr>
		<div class="przepis_k">
			<div class="pipt">Komentarze:</div>
			<div class="przepis_dk">
				<input type="text" name="przepis_dk" placeholder="Dodaj publiczny komentarz">
				<button class="przepis_dk_p">Skomentuj</button>
			</div>
			<div class="przepis_wk">
				<?php while ($wiersz_komentarz = $rezultat_komentarze->fetch_assoc()) { ?>
					<div class="przepis_pk">
						<div class="przepis_pk_u">
							<i class="icon-user-circle-o"></i><?php echo $wiersz_komentarz['uzytkownik']; ?>
						</div>
						<div class="przepis_pk_d">
							<?php echo $wiersz_komentarz['data']; ?>
						</div>
						<div style="clear: both;"></div>
						<div class="przepis_pk_k">
							<?php echo $wiersz_komentarz['komentarz']; ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
</div>
</div>
</body>
</html>