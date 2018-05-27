<?php

	require_once "polaczenie.php";

	if(strlen($_POST['wyszukiwarka']) != ""){
		$tytul = $_POST['wyszukiwarka'];

		try {
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if($polaczenie->connect_errno!=0){
				throw new Exception(mysgli_connect_errno());
			}
			else{
				$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
				$polaczenie->query("SET CHARSET utf8");
				$rezultat = $polaczenie->query("SELECT * FROM przepisy WHERE tytul LIKE '%$tytul%' LIMIT 5");

				$polaczenie->close();
			}
		
			} 
		catch (Exception $e) {
			echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
			echo "Informacja developera: ".$e;
		}

		if($rezultat->num_rows > 0){
			echo '<ul id="wyswietlanie_wyszukiwania_zawartosc">';
			while($wiersz = $rezultat->fetch_assoc()){
				echo '<li class="wyniki_wyszukiwania"><a href="przepis.php?id='.$wiersz['id_przepisu'].'">'.$wiersz['tytul'].'</a></li>';
			}
			echo '</ul>';
		}
		else{
			echo '<ul id="wyswietlanie_wyszukiwania_zawartosc">';
				echo '<li class="wyniki_wyszukiwania">Brak wyników wyszukiwania</li>';
			echo '</ul>';
		}
	}

?>