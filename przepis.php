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

		$wiersz = $rezultat->fetch_assoc();
		$tytul_slowa = explode(" ", $wiersz['tytul']); //pierwsze słowo tytułu

		$polaczenie->close();
		}
		
	} catch (Exception $e) {
		echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
		echo "Informacja developera: ".$e;
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
			<div class="pipt">
				<?php echo $wiersz['nazwa_spos_przygotowania'] ?>
			</div>
			<dl>
				<dt>Czas przygotowania:</dt>
				<dd><?php echo $wiersz['czas_przygotowania']; ?> min.</dd>
				<dt>Liczba porcji:</dt>
				<dd><?php echo $wiersz['liczba_porcji']; ?> porcje</dd>
				<dt>Ocena przepisu:</dt>
			</dl>
		</div>
		<div style="clear: both;"></div>
		<div class="skladniki">
			<h3>Skladniki:</h3>
			<ul>
			<?php 
				$skladniki = explode(",", $wiersz['skladniki']);
				count($skladniki);
				for ($i=0; $i < 6; $i++) { 
					echo '<li>'.$skladniki[$i].'</li><hr>';
				}
			?>
			</ul>
		</div>
		<div class="przygotowanie">
			<h3>Przygotowanie:</h3>
			<?php 
				echo nl2br($wiersz['przygotowanie']); 
			?> 
		</div>
</div>
</div>
</body>
</html>