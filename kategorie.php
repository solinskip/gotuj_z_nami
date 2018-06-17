<?php 
session_start();
require_once "polaczenie.php";

try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysgli_connect_errno());
		}
		else{
			$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			$polaczenie->query("SET CHARSET utf8");
			
			$rezultat_kategorie = @$polaczenie->query("SELECT * FROM kategorie");
			$rezultat_przepisy = @$polaczenie->query('SELECT przepisy.id_przepisu, przepisy.tytul, przepisy.skrot_opis, przepisy.czas_przygotowania, przepisy.stopien_trudnosci, SUM(oceny.ocena) / COUNT(przepisy.id_przepisu) AS ocena_p FROM przepisy LEFT JOIN oceny ON przepisy.id_przepisu=oceny.id_przepisu GROUP BY przepisy.id_przepisu ORDER BY przepisy.id_przepisu DESC');
			$rezultat_czas_przygotowania = @$polaczenie->query("SELECT czas_przygotowania FROM przepisy GROUP BY czas_przygotowania");

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
	<div class="k_kategorie">
		<div class="k_k_filtry">
			<h2 class="kolor_niebieski">Filtry</h2>
			<div class="k_k_f_sekcja">
				<form id="formularz_filtry_kategorie">
					<h4 class="k_k_f_s_tytul">Kategorie</h4>
					<?php while($kategorie = $rezultat_kategorie->fetch_assoc()){ ?>
						<div class="k_k_f_s_t_opcje">
							<input type="checkbox" name="kategorie" value="<?php echo $kategorie['id_kategori']; ?>">
							<?php echo $kategorie['nazwa_kategori']; ?>
						</div>
					<?php } ?>
				</form>
			</div>
			<div class="k_k_f_sekcja">
				<form id="formularz_filtry_czas_przygotowania">
					<h4 class="k_k_f_s_tytul">Czas przygotowania</h4>
					<?php while($czas_przygotowania = $rezultat_czas_przygotowania->fetch_assoc()){ ?>
						<div class="k_k_f_s_t_opcje_floatleft">
							<input type="checkbox" name="czas_przygotowania" value="<?php echo $czas_przygotowania['czas_przygotowania']; ?>">
							<?php echo $czas_przygotowania['czas_przygotowania']; ?> min.
						</div>
					<?php } ?>
					<div style="clear: both;"></div>
				</form>
			</div>
			<div class="k_k_f_sekcja">
				<form id="formularz_filtry_stopien_trudnosci">
					<h4 class="k_k_f_s_tytul">Stopień trudności</h4>
					<div class="k_k_f_s_t_opcje">
						<input type="checkbox" name="stopien_trudnosci" value="1"> Łatwy
					</div>
					<div class="k_k_f_s_t_opcje">
						<input type="checkbox" name="stopien_trudnosci" value="2"> Średni
					</div>
					<div class="k_k_f_s_t_opcje">
						<input type="checkbox" name="stopien_trudnosci" value="3"> Trudny
					</div>
				</form>
			</div>
		</div>
		<div class="k_k_wyswietlanie_przepisow">
			<?php include "wyswietlanie_przepisow.php"; ?>
		</div>
	</div> 
</div>
</body>
</html>