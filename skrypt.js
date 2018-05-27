 $(function() {

	$("#wyszukiwarka").keyup(function() {
		var tytul = $("#wyszukiwarka").val();
		$.post("wyszukiwarka.php", {
			wyszukiwarka: tytul
		}, function(data, status) {
			$("#wyswietlanie_wyszukiwania").html(data);
		});
	});

	$("#rejestracja_przycisk").click(function() {
		var uzytkownik_js = $("#uzytkownik").val();
		var email_js = $("#email").val();
		var haslo1_js = $("#haslo1").val();
		var haslo2_js = $("#haslo2").val();

		$.post("rejestracja_skrypt.php", {
			uzytkownik: uzytkownik_js,
			email: email_js,
			haslo1: haslo1_js,
			haslo2: haslo2_js
		}, function(data, status) {
			$("#dziala").html(data);
		});
	});

	$("#lean_modal").leanModal({
			top: 100,
			overlay: 0.6,
			closeButton: ".modal_close"
	});

	var i_s = 2;
	$("#dodaj_skladnik_p").click(function() {
		var pole_skladnik = document.getElementById("nowe_skladniki_p");
		var nowe_pole = document.createElement("input");
		nowe_pole.type = 'text';
		nowe_pole.setAttribute("class", "input_p_s");
		nowe_pole.name = 'skladnik_p'+i_s;
		i_s++;

		pole_skladnik.appendChild(nowe_pole);
	});

	$("#wyszukiwarka").keyup(function() {
			var str = $("#wyszukiwarka").val();
			if(str.length > 0)
				$("#wyswietlanie_wyszukiwania").show();
			else
				$("#wyswietlanie_wyszukiwania").hide();

		$("#wyszukiwarka").focusout(function() {	
			$("#wyswietlanie_wyszukiwania").fadeOut(200);
		});
	});

});

function wyswietl_miniature(files) {
	var mdp = document.getElementById("miniatura_dodanej_potrawy");
	if(files.length){
		var img = document.createElement("img");
		img.src = window.URL.createObjectURL(files[0]);
		img.height = 60;
		img.onload = function() {
			window.URL.revokeObjectURL(this.src);
		}
		mdp.appendChild(img);
	}
}


