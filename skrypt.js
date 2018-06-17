 $(function() {
	$("#wyszukiwarka").keyup(function() {
		var tytul = $("#wyszukiwarka").val();
		$.post("wyszukiwarka.php", {
			wyszukiwarka: tytul
		}, function(data, status) {
			$("#wyswietlanie_wyszukiwania").html(data);
		});
	});

	var nazwa = "";
	var filtr_kategorie = "";
	var filtr_czas_przygotowania = "";
	var filtr_stopien_trudnosci = "";
	$('#formularz_filtry_kategorie :checkbox, #formularz_filtry_czas_przygotowania :checkbox,#formularz_filtry_stopien_trudnosci :checkbox').change(function () {	
		var nazwa_filtra = $(this).attr("name");
    	if ($(this).is(':checked')){
    		if(nazwa_filtra == "kategorie"){ filtr_kategorie = filtr_kategorie + $(this).val() +","; }
    		if(nazwa_filtra == "czas_przygotowania"){ filtr_czas_przygotowania = filtr_czas_przygotowania + $(this).val() +","; }
    		if(nazwa_filtra == "stopien_trudnosci"){ filtr_stopien_trudnosci = filtr_stopien_trudnosci + $(this).val() +","; }
    	} 
    	else{ 
    		if(nazwa_filtra == "kategorie"){ filtr_kategorie = filtr_kategorie.replace($(this).val() + ",", ""); }
 			if(nazwa_filtra == "czas_przygotowania"){ filtr_czas_przygotowania = filtr_czas_przygotowania.replace($(this).val() + ",", ""); }
 			if(nazwa_filtra == "stopien_trudnosci"){ filtr_stopien_trudnosci = filtr_stopien_trudnosci.replace($(this).val() + ",", ""); }
    	}  	

    	$.post("kategorie_skrypt.php", {
    		filtr_kategorie: filtr_kategorie,
    		filtr_czas_przygotowania: filtr_czas_przygotowania,
    		filtr_stopien_trudnosci: filtr_stopien_trudnosci
    	}, function(data,status) {
    		$(".k_k_wyswietlanie_przepisow").html(data);
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

		var div = document.createElement("div");
		div.setAttribute("class", "input_ods");

		var divclear = document.createElement("div");
		divclear.setAttribute("style", "clear: both");

		var nowe_pole = document.createElement("input");
		nowe_pole.type = 'text';
		nowe_pole.setAttribute("class", "input_ps");
		nowe_pole.name = 'skladnik_p'+i_s;
		var remove = document.createElement("a");
		
		remove.setAttribute("class", "usun_skladnik_p");
		remove.textContent = "";
		i_s++;

		pole_skladnik.appendChild(div);
		div.appendChild(nowe_pole);
		div.appendChild(remove);
		 pole_skladnik.appendChild(divclear);
	});

	$(".usun_skladnik_p").click(function(e) {
		e.remove();
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

		$(".przepis_dk_p").click(function() {
			dodaj_komentarz();
	});

	$("#przepis_dk_t").keypress(function(e) {
		if(e.keyCode == 13){
			dodaj_komentarz();
		}
	});

	$(".przepis_pk_uk_id").click(function() {
		var id_komentarza_js = this.id;

		$(this).parent().closest(".przepis_pk").remove();

		$.post("usun_komentarz.php", {
			id_komentarza: id_komentarza_js
		}, function(data,status) {

		});
	});

	$(".container").rating(function(vote,event){
		var url_s = document.location;
		var url = new URL(url_s);
		var id_przepisu_js = url.searchParams.get("id");
    	$.ajax({
    		url: 'ocena_przepisu.php',
    		type: 'POST',
    		data: {vote:vote,
    			   id_przepisu:id_przepisu_js}
    	})
    	.done(function(info) {
    		$(".przepis_op_i").html(info)
    	})   	
    });

    $("#przepis_ip_pot").click(function() {
    	var url_s = document.location;
		var url = new URL(url_s);
		var id_przepisu_js = url.searchParams.get("id");
		$.ajax({
			url: 'czas_przygotowania.php',
			type: 'POST',
			data: {poprawny: "1",
				   id_przepisu: id_przepisu_js}
		})
		.done(function(info) {
			$(".przepis_ip_cp_2").html(info)
		})
    });

    $("#przepis_ip_zap").click(function() {
    	var url_s = document.location;
		var url = new URL(url_s);
		var id_przepisu_js = url.searchParams.get("id");
		$.ajax({
			url: 'czas_przygotowania.php',
			type: 'POST',
			data: {niepoprawny: "1",
				   id_przepisu: id_przepisu_js}
		})
		.done(function(info) {
			$(".przepis_ip_cp_2").html(info)
		})
    });

});

function wyswietl_miniature(files) {
	var mdp = document.getElementById("miniatura_dodanej_potrawy");
	if(files.length){
		var img = document.createElement("img");
		img.src = window.URL.createObjectURL(files[0]);
		img.height = 300;
		img.onload = function() {
			window.URL.revokeObjectURL(this.src);
		}
		mdp.appendChild(img);
	}
}

function dodaj_komentarz() {
		var komentarz_js = $("#przepis_dk_t").val();
		var url_s = document.location;
		var url = new URL(url_s);
		var id_przepisu_js = url.searchParams.get("id");

		$.post("dodaj_komentarz.php", {
			komentarz: komentarz_js,
			id_przepisu: id_przepisu_js
		}, function(data, status) {
			$("#przepis_nk").append(data);
		});
		wyczysc_input();
}
function wyczysc_input() {
	$("#przepis_dk_t").each(function() {
		$(this).val('');
	});
}