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
			
			$rezultat_przepisy = $polaczenie->query('SELECT przepisy.id_przepisu, przepisy.tytul, przepisy.skrot_opis, przepisy.czas_przygotowania, przepisy.stopien_trudnosci, SUM(oceny.ocena) / COUNT(przepisy.id_przepisu) AS ocena_p FROM przepisy LEFT JOIN oceny ON przepisy.id_przepisu=oceny.id_przepisu GROUP BY przepisy.id_przepisu ORDER BY przepisy.id_przepisu DESC');

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
	<?php
		require "naglowek.php"; 
		require "wyswietlanie_przepisow.php";
	?>
</div>
</body>
</html>