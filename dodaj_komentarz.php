<?php 
session_start();

include ('polaczenie.php');

if (isset($_POST['komentarz'])) {
	try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else{
			$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			$polaczenie->query("SET CHARSET utf8");
			$id_uzytkownika = $_SESSION['id_uzytkownika'];
			date_default_timezone_get();
			$komentarz = $_POST['komentarz'];
			$data = date("Y-m-d H:i:s");
			$id_przepisu = $_POST['id_przepisu'];

			$polaczenie->query("INSERT INTO komentarze VALUES (NULL, '$id_uzytkownika', '$id_przepisu', '$komentarz','$data')");

			$rezultat_komentarze = $polaczenie->query("SELECT uzytkownicy.uzytkownik, komentarze.komentarz, komentarze.data, komentarze.id_komentarza, komentarze.id_uzytkownika FROM komentarze LEFT JOIN przepisy ON przepisy.id_przepisu=komentarze.id_przepisu LEFT JOIN uzytkownicy ON komentarze.id_uzytkownika=uzytkownicy.id_uzytkownika WHERE komentarze.id_przepisu='$id_przepisu' ORDER BY komentarze.data DESC LIMIT 1");

			 $wiersz_komentarz = $rezultat_komentarze->fetch_assoc();
			?>
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
		<?php } 	
	}
	catch (Exception $e) {
		echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
		echo "Informacja developera: ".$e;
	}
}