	<div id="naglowek">
		<div id="lewy_naglowek_logo">
			<a href="index.php">Gotuj z Nami</a>
		</div>
		<div id="srodkowy_naglowek">
			<nav class="menu_zawartosc">
				<li><a href="index.php">Strona główna | </a></li>
				<li><a href="dodaj_przepis.php">Dodaj nowy przepis | </a></li>
				<li id="kategorie">Kategorie</li>
			</nav>
		</div>
		<div id="prawy_naglowek">
		<?php 
			if((isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true))){ ?>
				<div id="zalogowany">
					<div tabindex="0" class="onclick_menu">
						Witaj <?php echo $_SESSION['uzytkownik'] ?> <i class="fas fa-chevron-down"></i>
						<ul class="onclick_menu_content">
							<li>
								<a href="profil.php" ><i class="fas fa-user"></i>Profil</a>
							</li>
							<li><a href="wyloguj.php"><i class="fas fa-sign-out-alt"></i>Wyloguj się</a></li>
						</ul>
					</div>
				</div>
			<?php } else{ ?>
				<div id="logowanie">
					<form id="form_logowanie" action="zaloguj.php" method="POST">
						Login: <input type="text" name="uzytkownik">
						Hasło: <input type="password" name="haslo">
						<input type="submit" value="Zaloguj">
					</form>
					<?php if(isset($_SESSION["blad_logowania"])) {
							echo "Błędy login lub hasło";
							unset($_SESSION['blad_logowania']);
						}
					echo '
					</div>

					<div id="rejestracja">'; 
					?>
						<a id="lean_modal" href="#modal">Nie masz jeszcze konta ? Zarejestruj się</a>

						<div id="modal" class="rejestracja_pojemnik" style="display:none;">
							<header class="rejestracja_naglowek">
								<span class="naglowek_tytul">Rejestracja</span>
								<span class="modal_close">x</span>
							</header>

							<div class="rejestracja_cialo">
							<!-- Pola rejestracji -->
								<form action="">
									
									<div class="rc_w">
										<label class="rc_t">Nazwa użytkownika</label><br>
										<input type="text" id="uzytkownik" name="uzytkownik" placeholder="Wpisz swoją nazwe użytkownika" autocomplete="off">
									</div>

									<div class="rc_w">	
											<label class="rc_t">Email</label><br>
											<input type="text" id="email" name="email" placeholder="Wpisz adres email"><br>
									</div>
									<div class="rc_w">
											<label class="rc_t">Hasło</label><br>
											<input type="password" id="haslo1" name="haslo1" placeholder="Wpisz hasło"><br>
									</div>
									<div class="rc_w">
											<label class="rc_t">Powtórz hasło</label><br>
											<input type="password" id="haslo2" name="haslo2" placeholder="Powtórz hasło">
									</div>
									<div id="dziala"></div>

									<div class="przycisk">
										<a id="rejestracja_przycisk" href="#">Zarejestruj się</a>
									</div>
								</form>
							</div>
							<div id="rejestracja_udana" style="display: none;">
							Rejestracja przebiegła pomyślnie. Teraz możesz się zalogować.
							</div>
						</div>
						<?php	
					echo '</div>';
			}
		?>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div id="c_wyszukiwarka">
		<input type="search" id="wyszukiwarka" placeholder="Wyszukaj przepis">
		<div style="display:none;" id="wyswietlanie_wyszukiwania"></div>
	</div>