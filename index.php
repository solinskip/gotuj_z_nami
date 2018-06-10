<?php
	session_start();
	$_SESSION['aktualna_strona'] = $_SERVER['REQUEST_URI'];
	require_once "polaczenie.php";

	try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysgli_connect_errno());
		}
		else{
			$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			$polaczenie->query("SET CHARSET utf8");
			
			$ocena_przepisu = $polaczenie->query('SELECT przepisy.id_przepisu, przepisy.tytul, przepisy.skrot_opis, przepisy.czas_przygotowania, przepisy.stopien_trudnosci, SUM(oceny.ocena) / COUNT(przepisy.id_przepisu) AS ocena_p FROM przepisy LEFT JOIN oceny ON przepisy.id_przepisu=oceny.id_przepisu GROUP BY przepisy.id_przepisu ORDER BY przepisy.id_przepisu DESC');

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
	<title>Gotuj z Nami</title>

	<link rel="stylesheet" type="text/css" href="style.css"/>
	<link rel="stylesheet" type="text/css" href="css/fontello.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700i&amp;subset=latin-ext" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
</head>
<body>
<div id="kontener">
	<?php require_once "naglowek.php"; ?>

	<div id="miniatura_potrawy_pojemnik">
		<?php if($ocena_przepisu->num_rows > 0){
			while($wiersz = $ocena_przepisu->fetch_assoc()){ ?>
		 		<div class="miniatura_potrawy_przepis">
		 			<a href="przepis.php?id=<?php echo $wiersz['id_przepisu'] ?>">
			 			<div class="miniatura_potrawy_zdjecie_skrot_opis">
			 				<img class="miniatura_potrawy_zdjecie" src="obrazy_potraw/<?php echo $wiersz["id_przepisu"] ?>.jpg"/>
			 				<div class="miniatura_potrawy_skrot_opis">
			 					<?php echo $wiersz['skrot_opis']; ?>
			 				</div>
			 		   	</div>
		 		   	</a>
		 		   	<div class="miniatura_potrawy_mpcpl_mpstp">
		 		   		<div class="mpcpl"><i class="icon-clock"></i><?php echo $wiersz['czas_przygotowania'] ?>"
		 		   		</div>
		 		   		<div class="mpstp">
		 		   			<?php if($wiersz['stopien_trudnosci'] == 1){ ?>
		 		   				<i class="icon-chart-bar1"></i>Łatwy
		 		   			<?php } elseif($wiersz['stopien_trudnosci'] == 2){ ?>
		 		   				<i class="icon-chart-bar2"></i>Średni
		 		   			<?php } elseif($wiersz['stopien_trudnosci'] == 3){ ?>
		 		   				<i class="icon-chart-bar3"></i>Trudny
		 		   			<?php } ?>
		 		   		</div>
		 		   	</div>
		 		   	<div style="clear: both;"></div>
		 			<div class="miniatura_potrawy_ocena">
		 				<?php for ($i=0; $i < 5; $i++) { 
		 					if($wiersz['ocena_p'] > $i + 0.5){
		 						echo '<i class="icon-star"></i>';
		 					}
		 					elseif ($wiersz['ocena_p'] > $i + 0.01  && $wiersz['ocena_p'] <= $i + 0.5) {
		 						echo '<i class="icon-star-half-alt"></i>';
		 					}
		 					elseif($wiersz['ocena_p'] <= $i){
		 						echo '<i class="icon-star-empty"></i>';
		 					}
		 					elseif($wiersz['ocena_p'] == 0.0) {
		 						echo '<i class="icon-star-empty"></i>';
		 					}
		 				} ?>
		 				</div>
			 		<div class="miniatura_potrawy_tytul">
						<a href="przepis.php?id=<?php echo $wiersz['id_przepisu'] ?>"><?php echo $wiersz["tytul"]; ?></a>
	 				</div>
	 			</div>
		 	<?php }
		}
		else{ echo "Zero wyników"; }
		?>
	</div>
	<div style="clear: both;"></div><br><br>
</div>
</body>
</html>