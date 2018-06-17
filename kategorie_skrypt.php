<?php
session_start();
require_once "polaczenie.php";

if(strlen($_POST['filtr_kategorie']) > 0 ){ $filtr_kategorie = $_POST['filtr_kategorie']; }
if(strlen($_POST['filtr_czas_przygotowania']) > 0 ){ $filtr_czas_przygotowania = $_POST['filtr_czas_przygotowania']; }
if(strlen($_POST['filtr_stopien_trudnosci']) > 0 ){ $filtr_stopien_trudnosci = $_POST['filtr_stopien_trudnosci']; }

if(!isset($filtr_sql_caly)){ $filtr_sql_caly = ""; }

try {
		$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0){
			throw new Exception(mysgli_connect_errno());
		}
		else{
			$polaczenie->query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
			$polaczenie->query("SET CHARSET utf8");
			
			if(isset($filtr_kategorie)){
				$filtr_sql_kategorie = explode(",",$filtr_kategorie);
				$filtr_sql_kategorie_caly = "";
				for ($i=0; $i < count($filtr_sql_kategorie) - 1; $i++) { 
					if($i == 0){
						$filtr_sql_kategorie_caly = $filtr_sql_kategorie_caly."przepisy.id_kategori='$filtr_sql_kategorie[$i]'";
					}
					else{
						$filtr_sql_kategorie_caly = $filtr_sql_kategorie_caly." OR przepisy.id_kategori='$filtr_sql_kategorie[$i]'";
					}
				}
				$filtr_sql_caly = "WHERE (".$filtr_sql_kategorie_caly.")";
			}

			if(isset($filtr_czas_przygotowania)){
				$filtr_sql_czas_przygotowania = explode(",",$filtr_czas_przygotowania);
				$filtr_sql_czas_przygotowania_caly = "";
				for ($i=0; $i < count($filtr_sql_czas_przygotowania) - 1; $i++) { 
					if($i == 0){
						$filtr_sql_czas_przygotowania_caly = $filtr_sql_czas_przygotowania_caly."przepisy.czas_przygotowania='$filtr_sql_czas_przygotowania[$i]'";
					}
					else{
						$filtr_sql_czas_przygotowania_caly = $filtr_sql_czas_przygotowania_caly." OR przepisy.czas_przygotowania='$filtr_sql_czas_przygotowania[$i]'";
					}
				}
				if(strlen($filtr_sql_caly) > 0){
					$filtr_sql_caly = $filtr_sql_caly." AND (".$filtr_sql_czas_przygotowania_caly.")";
				}
				else{
					$filtr_sql_caly = "WHERE (".$filtr_sql_czas_przygotowania_caly.")";
				}
			}

			if(isset($filtr_stopien_trudnosci)){
				$filtr_stopien_trudnosci = explode(",",$filtr_stopien_trudnosci);
				$filtr_stopien_trudnosci_caly = "";
				for ($i=0; $i < count($filtr_stopien_trudnosci) - 1; $i++) { 
					if($i == 0){
						$filtr_stopien_trudnosci_caly = $filtr_stopien_trudnosci_caly."przepisy.stopien_trudnosci='$filtr_stopien_trudnosci[$i]'";
					}
					else{
						$filtr_stopien_trudnosci_caly = $filtr_stopien_trudnosci_caly." OR przepisy.stopien_trudnosci='$filtr_stopien_trudnosci[$i]'";
					}
				}
				if(strlen($filtr_sql_caly) > 0){
					$filtr_sql_caly = $filtr_sql_caly." AND (".$filtr_stopien_trudnosci_caly.")";
				}
				else{
					$filtr_sql_caly = "WHERE (".$filtr_stopien_trudnosci_caly.")";
				}
			}

			$sql = "SELECT przepisy.id_przepisu, przepisy.tytul,przepisy.id_przepisu , przepisy.skrot_opis, przepisy.czas_przygotowania, przepisy.stopien_trudnosci, SUM(oceny.ocena) / COUNT(przepisy.id_przepisu) AS ocena_p FROM przepisy LEFT JOIN oceny ON przepisy.id_przepisu=oceny.id_przepisu ".$filtr_sql_caly." GROUP BY przepisy.id_przepisu ORDER BY przepisy.id_przepisu DESC";
			$rezultat_przepisy = @$polaczenie->query($sql);

			$polaczenie->close();
		}
		
	} catch (Exception $e) {
		echo '<span style="color:red;">Błąd serwera przepraszamy na niedogodności</span>';
		echo "Informacja developera: ".$e;
	}
	echo $filtr_sql_caly;
	echo "<br>Liczba znalezionych przepisów: ".$rezultat_przepisy->num_rows;

	require "wyswietlanie_przepisow.php";
