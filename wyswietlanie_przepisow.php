	<div id="miniatura_potrawy_pojemnik">
		<?php if($rezultat_przepisy->num_rows > 0){
			while($wiersz = $rezultat_przepisy->fetch_assoc()){ ?>
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