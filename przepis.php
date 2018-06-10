<?php
	session_start();
	require_once 'polaczenie.php';
	$_SESSION['aktualna_strona'] = $_SERVER['REQUEST_URI'];
	$id_przepisu = $_GET['id'];

	try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysgli_connect_errno());
		}
		else{
		$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
		$polaczenie->query("SET CHARSET utf8");
		$rezultat = $polaczenie->query("SELECT uzytkownicy.uzytkownik,p.*,sp.nazwa_spos_przygotowania FROM przepisy AS p LEFT JOIN sposob_przygotowania AS sp ON p.id_spos_przygotowania=sp.id_spos_przygotowania LEFT JOIN uzytkownicy ON p.id_uzytkownika=uzytkownicy.id_uzytkownika WHERE p.id_przepisu='$id_przepisu'");
		if(isset($_SESSION['zalogowany'])){
			$rezultat_komentarze = $polaczenie->query("SELECT uzytkownicy.uzytkownik, komentarze.id_komentarza,komentarze.komentarz, komentarze.data, komentarze.id_uzytkownika FROM komentarze LEFT JOIN przepisy ON przepisy.id_przepisu=komentarze.id_przepisu LEFT JOIN uzytkownicy ON komentarze.id_uzytkownika=uzytkownicy.id_uzytkownika WHERE komentarze.id_przepisu='$id_przepisu' ORDER BY komentarze.data DESC");
		}
		$rezultat_ocena_sr = $polaczenie->query("SELECT SUM(ocena)/COUNT(id_przepisu) AS ocena_sr FROM oceny WHERE id_przepisu='$id_przepisu' GROUP BY id_przepisu");
		$rezultat_czas_przygotowania = $polaczenie->query("SELECT SUM(czas_przygotowania_p)/COUNT(id) as cp, COUNT(id) as id FROM czas_przygotowania WHERE id_przepisu='$id_przepisu'");

		$wiersz_czas_przygotowania = $rezultat_czas_przygotowania->fetch_assoc();
		$wiersz = $rezultat->fetch_assoc();
		$ocena_sr = $rezultat_ocena_sr->fetch_assoc();

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
	function czas_przygotowania(){
		global $wiersz_czas_przygotowania;
		if($wiersz_czas_przygotowania['cp'] == 0 AND $wiersz_czas_przygotowania['id'] == 0){
			echo "Brak głosów";
		}
		elseif($wiersz_czas_przygotowania['cp'] < 0.60 AND $wiersz_czas_przygotowania['cp'] >= 0.00){
			echo '<span style="color: #EA2027 !important;">Nie poprawny</span>';
		}
		else{
			echo '<span style="color: #009432 !important;">Poprawny</span>';
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Przepis na <?php echo $wiersz['tytul']; ?></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.leanModal.min.js"></script>
	<script type="text/javascript" src="skrypt.js"></script>
	<script type="text/javascript" src="star/rating.js"></script>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700i&amp;subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/fontello.css">
	<link rel="stylesheet" href="star/rating.css" type="text/css" media="screen" title="Rating CSS">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
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
			Przepis został dodany przez: <span class="przepis_dodany_przez_osoba"><?php echo $wiersz['uzytkownik']; ?></span>
		</div>
		<div class="przepis_zdjecie_przepisu">
			<img src="obrazy_potraw/<?php echo $id_przepisu; ?>.jpg">
		</div>
		<div class="przepis_info_przepisu">
			<dl>
				<dt>Sposób przygotowania:</dt>
				<dd><i class="icon-lightbulb"></i><?php echo $wiersz['nazwa_spos_przygotowania']; ?></dd>
				<dt class="przepis_ip_cp_1">Czas przygotowania:</dt>
				<dt class="przepis_ip_cp_2"><?php czas_przygotowania(); ?></dt>
				<dd class="przepis_ip_cp_3">
					<i class="icon-clock-black"></i><?php echo $wiersz['czas_przygotowania']; ?> min.
					<?php if(isset($_SESSION['zalogowany'])){ ?>
						<i class="far fa-check-circle przepis_ip_p" id="przepis_ip_pot"></i>
						<i class="far fa-times-circle przepis_ip_z" id="przepis_ip_zap"></i>
					<?php } else{ echo '<i class="przepis_ip_p" style="font-size: 15px; color: #e2e2e2;">sss</i><i class="przepis_ip_z" style="font-size: 15px; color: #e2e2e2;">ss</i>'; }?>			
				</dd>
				<dd class="przepis_ip_cp_4"></dd>
				<dt style="clear: both;">Stopień trudności</dt>
				<dd>
					<?php if($wiersz['stopien_trudnosci'] == 1){ ?>
		 		   				<i class="icon-chart-bar1_p"></i>Łatwy
		 		   			<?php } elseif($wiersz['stopien_trudnosci'] == 2){ ?>
		 		   				<i class="icon-chart-bar2_p"></i>Średni
		 		   			<?php } elseif($wiersz['stopien_trudnosci'] == 3){ ?>
		 		   				<i class="icon-chart-bar3_p"></i>Trudny
		 		   			<?php } ?>
				</dd>
				<dt>Liczba porcji:</dt>
				<dd><i class="icon-food"></i><?php echo $wiersz['liczba_porcji']; ?> porcje</dd>
				<dt>Inne informację:</dt>
				<dd><?php informacja(); ?></dd>
				<dt>Ocena przepisu:</dt>
				<dd>
				    <div class="container" style="float: left;">
					    <input type="radio" name="example" class="rating" value="1" />
						<input type="radio" name="example" class="rating" value="2" />
						<input type="radio" name="example" class="rating" value="3" />
						<input type="radio" name="example" class="rating" value="4" />
						<input type="radio" name="example" class="rating" value="5" />
					</div>
					<div class="przepis_op_sr">
						<?php echo round($ocena_sr['ocena_sr'],2)." / 5"; ?>
					</div>
					<div style="clear: both;"></div>
					<div class="przepis_op_i"></div>
				</dd>
			</dl>
		</div>
		<div style="clear: both;"></div>
		<div class="przepis_skladniki">
			<div class="pipt">Skladniki:</div>
			<ul>
				<?php $skladniki = explode(",", $wiersz['skladniki']);
				for ($i=0; $i < count($skladniki); $i++) { 
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
		<?php if(isset($_SESSION['zalogowany'])) { ?> <div class="przepis_k">
			<div class="pipt">Komentarze:</div>
			<div class="przepis_dk">
				<input type="text" id="przepis_dk_t" name="przepis_dk_t" placeholder="Dodaj publiczny komentarz">
				<a class="przepis_dk_p">Skomentuj</a>
			</div>
			<div class="przepis_wk">
				<div id="przepis_nk"></div>
				<?php while ($wiersz_komentarz = $rezultat_komentarze->fetch_assoc()) { ?>
					<div class="przepis_pk" id="przepis_pk_id_<?php echo $wiersz_komentarz['id_komentarza']; ?>">
						<div class="przepis_pk_u">
							<i class="icon-user-circle-o"></i><?php echo $wiersz_komentarz['uzytkownik']; ?>
						</div>
						<div class="przepis_pk_d">
							<?php echo $wiersz_komentarz['data']; ?>
						</div>
						<?php if($wiersz_komentarz['id_uzytkownika'] == $_SESSION['id_uzytkownika']){ ?>
							<div class="przepis_pk_uk">
								<div class="przepis_pk_uk_id" id="<?php echo $wiersz_komentarz['id_komentarza']; ?>">
									<i class="icon-cancel"></i>
								</div>
							</div>
						<?php } ?>
						<div style="clear: both;"></div>
						<div class="przepis_pk_k">
							<?php echo $wiersz_komentarz['komentarz']; ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div> <?php } ?>
</div>
</div>
</body>
</html>