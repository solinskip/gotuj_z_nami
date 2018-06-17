-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Cze 2018, 12:06
-- Wersja serwera: 10.1.30-MariaDB
-- Wersja PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `gotuj_z_nami`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `czas_przygotowania`
--

CREATE TABLE `czas_przygotowania` (
  `id` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `id_przepisu` int(11) NOT NULL,
  `czas_przygotowania_p` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `czas_przygotowania`
--

INSERT INTO `czas_przygotowania` (`id`, `id_uzytkownika`, `id_przepisu`, `czas_przygotowania_p`) VALUES
(1, 1, 4, 1),
(2, 2, 4, 1),
(3, 4, 4, 1),
(4, 1, 4, 0),
(5, 1, 4, 1),
(6, 1, 4, 1),
(7, 1, 4, 0),
(8, 1, 4, 0),
(9, 1, 4, 0),
(10, 1, 4, 1),
(11, 1, 3, 1),
(12, 1, 1, 0),
(13, 1, 2, 1),
(14, 1, 6, 1),
(15, 9, 7, 1),
(16, 9, 9, 1),
(17, 1, 11, 0),
(18, 1, 10, 0),
(19, 1, 9, 1),
(20, 1, 8, 1),
(21, 1, 7, 0),
(22, 9, 12, 1),
(23, 1, 12, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id_kategori` int(11) NOT NULL,
  `nazwa_kategori` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`id_kategori`, `nazwa_kategori`) VALUES
(2, 'Dania główne'),
(3, 'Ciasta i desery'),
(4, 'Śniadania'),
(5, 'Przekąski i przystawki'),
(6, 'Zupy'),
(7, 'Sałatki'),
(8, 'Kolacje'),
(9, 'Napoje'),
(10, 'Przetwory'),
(11, 'Wege przepisy');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE `komentarze` (
  `id_komentarza` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `id_przepisu` int(11) NOT NULL,
  `komentarz` text COLLATE utf8_polish_ci NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `komentarze`
--

INSERT INTO `komentarze` (`id_komentarza`, `id_uzytkownika`, `id_przepisu`, `komentarz`, `data`) VALUES
(2, 3, 1, 'Super naprawdę smaczne :)', '2018-05-27 23:56:55'),
(5, 1, 2, 'Pyszne !', '2018-05-29 18:32:19'),
(6, 1, 3, 'Pyszne na śniadanie. ', '2018-05-29 18:45:22'),
(7, 1, 3, 'Bardzo dobre', '2018-05-29 18:50:50'),
(9, 1, 2, 'Słodkie ale dobre.', '2018-05-29 18:52:19'),
(13, 9, 1, 'Pyszne', '2018-06-05 16:05:38'),
(53, 1, 5, 'Pyszne danie', '2018-06-05 20:20:42'),
(116, 1, 3, 'sdf', '2018-06-05 20:34:07'),
(117, 1, 4, 'asdfsadf', '2018-06-07 10:40:05'),
(123, 1, 5, 'Dobre', '2018-06-07 12:35:36'),
(125, 1, 5, 'Syper', '2018-06-07 12:48:02'),
(126, 1, 1, 'Dobre', '2018-06-07 12:52:20'),
(133, 1, 1, 'Dobre', '2018-06-07 13:19:49'),
(134, 9, 8, 'Bardzo pyszna babka polecam każdemu :) ', '2018-06-09 17:41:05'),
(138, 9, 9, 'Pyszna zupa', '2018-06-10 12:21:05'),
(140, 9, 12, 'Polecam', '2018-06-11 08:36:47'),
(141, 1, 12, 'dobre ', '2018-06-12 10:47:05');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oceny`
--

CREATE TABLE `oceny` (
  `id_oceny` int(11) NOT NULL,
  `id_przepisu` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `ocena` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `oceny`
--

INSERT INTO `oceny` (`id_oceny`, `id_przepisu`, `id_uzytkownika`, `ocena`) VALUES
(1, 1, 1, 5),
(2, 1, 1, 4),
(3, 1, 1, 3),
(4, 2, 2, 4),
(7, 1, 1, 1),
(8, 3, 1, 3),
(9, 4, 1, 0),
(10, 5, 1, 1),
(11, 4, 1, 5),
(12, 4, 1, 3),
(13, 4, 1, 4),
(14, 1, 1, 4),
(15, 1, 1, 3),
(16, 1, 1, 4),
(17, 1, 1, 3),
(18, 1, 1, 5),
(19, 2, 1, 5),
(20, 3, 9, 5),
(21, 4, 4, 5),
(22, 5, 3, 5),
(27, 6, 1, 5),
(28, 9, 9, 5),
(29, 11, 1, 3),
(30, 12, 9, 3),
(31, 12, 1, 4),
(32, 11, 9, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przepisy`
--

CREATE TABLE `przepisy` (
  `id_przepisu` int(11) NOT NULL,
  `tytul` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `skladniki` text COLLATE utf8_polish_ci NOT NULL,
  `przygotowanie` text COLLATE utf8_polish_ci NOT NULL,
  `skrot_opis` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `id_uzytkownika` int(20) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `czas_przygotowania` int(11) NOT NULL,
  `stopien_trudnosci` int(11) NOT NULL,
  `liczba_porcji` int(11) NOT NULL,
  `id_spos_przygotowania` int(11) NOT NULL,
  `d_bezglutenowe` tinyint(1) NOT NULL,
  `d_wegetarianskie` tinyint(1) NOT NULL,
  `d_dietetyczne` tinyint(1) NOT NULL,
  `d_dla_dzieci` tinyint(1) NOT NULL,
  `szybka_kuchnia` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `przepisy`
--

INSERT INTO `przepisy` (`id_przepisu`, `tytul`, `skladniki`, `przygotowanie`, `skrot_opis`, `id_uzytkownika`, `id_kategori`, `czas_przygotowania`, `stopien_trudnosci`, `liczba_porcji`, `id_spos_przygotowania`, `d_bezglutenowe`, `d_wegetarianskie`, `d_dietetyczne`, `d_dla_dzieci`, `szybka_kuchnia`) VALUES
(1, 'Ravioli śmietankowe z wiśniami', 'FARSZ: 1/2 kg twarogu jak na serniki,\r\n2 żółtka,\r\n3 czubate łyżki proszku budyniowego śmietankowego,\r\ncukier do smaku,\r\nopakowanie mrożonych wiśni,\r\nCIASTO: 1/2 kg mąki,\r\nszklanka wody,\r\n3 łyżki stopionego masła,\r\n2 jajka,\r\nSOS: 400 ml kwaśnej śmietany,\r\n8 łyżek mleka,\r\n3 łyżki cukru,\r\n3 czubate łyżki proszku budyniowego śmietankowego,\r\nłyżka masła', '1. Farsz: dokładnie mieszamy twaróg, żółtka, proszek budyniowy i cukier do smaku, odstawiamy do lodówki. Z podanych składników zagniatamy gładkie, elastyczne ciasto, dzielimy na pół, obie części rozwałkowujemy na cienkie, w miarę równe płaty.\r\n\r\n2. Czubkiem noża zaznaczamy na jednym „siatkę” o oczkach ok. 5 x 5 cm. Na środek każdego „oczka” kładziemy porcję farszu i jedną wiśnię (rozmrożoną). Przykrywamy drugim płatem ciasta, dociskamy palcem pomiędzy kupkami farszu, tniemy na kwadraty.\r\n\r\n3. Dla pewności brzegi dociśnijmy jeszcze widelcem. Wrzucamy partiami na osolony wrzątek, gotujemy 2–3 min od wypłynięcia. W rondelku zagotowujemy śmietanę, osobno roztrzepujemy mleko z cukrem i proszkiem budyniowym, stale mieszając trzepaczką, wlewamy do śmietany i mieszamy na ogniu, aż sos stanie się gęsty i aksamitnie gładki. \r\n\r\n4. Na koniec wmieszujemy masło. Gorące ravioli polewamy sosem, dekorujemy wiśniami.', 'Ravioli możemy nadziewać różnymi farszami. Proponujemy farsz serowo-śmietankowy - pycha!', 3, 2, 60, 3, 4, 1, 0, 1, 1, 1, 0),
(2, 'Babeczki z sosem owocowym', '2 płaskie łyżeczki żelatyny,\r\ncytryna,\r\n4 łyżki płynnego miodu,\r\n300 ml gęstej kwaśnej śmietany,\r\nłyżka białego rumu,\r\n220 ml gęstej kremówki,\r\nopakowanie dowolnych mrożonych owoców,\r\ntorebka cukru waniliowego,\r\ncukier puder,\r\nmelisa do dekoracji', '1. Żelatynę zalewamy łyżką– –dwoma gorącej wody, odstawiamy. Cytrynę sparzamy, ścieramy skórkę, wyciskamy sok, razem mieszamy z miodem, kwaśną śmietaną i rumem. 4 łyżki mieszanki mieszamy aż do rozpuszczenia z namoczoną żelatyną.\r\n\r\n2. Ucieramy z resztą mieszanki, odstawiamy na ok. 30 min, aż zacznie tężeć. Zimną kremówkę ubijamy na sztywno, łączymy z mieszanką. Masę nakładamy do silikonowej foremki na babeczki, wstawiamy do lodówki na min. 3 godz.\r\n\r\n3. Rozmrożone owoce razem z sokiem mieszamy do smaku z cukrem waniliowym i cukrem pudrem (ew. można dolać rumu i soku z cytryny albo limetki). Babeczki wykładamy na talerzyki, polewamy obfi cie sosem owocowym, dekorujemy melisą.\r\n', 'Delikatne babeczki śmietanowe wybierzcie na deser po dużym obiedzie. Są lekkie i kwaskowe, dzięki dodaniu sosu owocowego.', 5, 3, 45, 3, 6, 3, 0, 1, 0, 1, 1),
(3, 'Jajko sadzone w chlebie', 'łyżeczka oleju,\r\n2 łyżki masła,\r\n2 kromki chleba żytniego,\r\n2 jajka,\r\nsól i świeżo zmielony czarny pieprz,\r\ngarść rzeżuchy', '1. Patelnię rozgrzewamy, wlewamy olej, dodajemy masło. W kromkach chleba za pomocą foremki do ciastek wycinamy okrągłe dziury. Kromki rumienimy najpierw z jednej, a potem z drugiej strony.\r\n\r\n2. Wbijamy po jednym jajku do każdej kromki, oprószamy solą i pieprzem, czekamy aż jajka się zetną. Zjadamy z rzeżuchą.', 'Jajko sadzone nie tylko doskonale pasuje do ziemniaków w wersji obiadowej, ale i na śniadanie.', 9, 4, 15, 1, 3, 2, 0, 1, 1, 0, 1),
(4, 'Schab pieczony z białą kiełbasą i sosem żurkowym', '3 łyżki oleju,\r\nłyżeczka mielonego czosnku,\r\n1/2 łyżeczki soli,\r\n1/2 łyżeczki pieprzu,\r\n1/2 kg schabu,\r\n2 białe kiełbasy,\r\n10 małych cebulek,\r\ngłówka czosnku,\r\n4 łyżki masła,\r\n3 łyżki mąki,\r\n200 ml zakwasu na żur,\r\n100 ml mleka,\r\nsól, pieprz,\r\n2 łyżki świeżej rzeżuchy', '1. Mieszamy olej, sproszkowany czosnek, sól i pieprz. Schab czyścimy, robimy nacięcie przez środek i smarujemy marynatą od środka i na zewnątrz. \r\nWstawiamy do lodówki na min. 2 godz., a najlepiej na noc. W nacięcie w schabie wkładamy – jedna za drugą – białe kiełbasy.\r\n\r\n2. Nafaszerowane mięso razem z marynatą, obranymi cebulami i lekko nadgniecioną główką czosnku wkładamy do rękawa do pieczenia. Pieczemy w piekarniku nagrzanym do temp. 180°C przez 60 min. Na 10 min przed końcem pieczenia rozcinamy rękaw.\r\n\r\n3. Robimy sos żurkowy: rozgrzewamy masło, oprószamy mąką i zasmażamy na złoto. Dolewamy zakwas na żur, mleko, podgrzewamy razem do zgęstnienia, doprawiamy do smaku solą i pieprzem.\r\n\r\n4.Pokrojony w plastry schab podajemy na gorąco, polany sosem żurkowym, z upieczonymi cebulkami, posypany świeżą rzeżuchą.', 'Schab pieczony musi znaleźć się na naszym stole na Wielkanoc - będzie pysznym elementem świątecznego obiadu.', 3, 2, 50, 2, 6, 3, 0, 0, 1, 0, 0),
(5, 'Sernik nowalijkowy', '4-5 ugotowanych podłużnych buraków,\r\n2 łyżki oliwy,\r\nsól, biały pieprz,\r\n70 dag białego sera trzykrotnie mielonego tłustego,\r\n6 łyżek koncentratu buraczanego,\r\nłyżeczka drobno otartej skórki cytryny,\r\n200 ml słodkiej śmietanki 36%,\r\npęczek rzodkiewek,\r\nnieduży świeży ogórek ze skórką,\r\npęczek drobnego szczypiorku,\r\npęczek koperku,\r\n6 łyżeczek płaskich żelatyny,\r\n2 czubate łyżki ściętych listków rzeżuchy', '1. Buraki kroimy na mandolinie w najcieńsze możliwe wstążki. Okrągłą formę z kominem smarujemy oliwą, wykładamy folią spożywczą. Na dno, równo, aby trochę na siebie nachodziły, układamy buraki, oprószamy solą i pieprzem. Do miski wrzucamy ser i za pomocą klasycznego miksera ukręcamy go z dolewanym powoli koncentratem z buraków.\r\n\r\n2. Dodajemy skórkę z cytryny i dolewamy śmietanę. Doprawiamy solą, pieprzem. Na tarce na dużych oczkach ścieramy rzodkiewki, ogórka, drobno siekamy szczypiorek i koperek. Żelatynę rozpuszczamy w niedużej ilości gorącej wody, letnią dodajemy do masy serowej i dokładnie w niej rozprowadzamy, miksując.\r\n\r\n3. Dodajemy rzodkiewki, ogórek i zieleninę z rzeżuchą, mieszamy. Przekładamy do blaszki, starając się nie popsuć układanki z buraków. Wierzch przykrywamy folią spożywczą i mocno obstukujemy formę o stół, aby pozbyć się nadmiaru powietrza. Wstawiamy na noc do lodówki i podajemy na poranne śniadanie.', 'Wytrawny sernik nowalijkowy zapowiada wiosnę, pachnie burakami, rzodkiewką i szczypiorkiem.', 5, 3, 50, 1, 8, 3, 1, 1, 0, 1, 0),
(6, 'Torcik kokosowy', 'Na ciasto:5 jajek,30 g skrobi ziemniaczanej,70 g mąki kokosowej,30 g mąki ryżowej,Na masę:1 puszka schłodzonego mleczka kokosowego (część stała),2 łyżki jogurtu greckiego,2 łyżki serka mascarpone,6 łyżek ksylitolu,50 g wiórków kokosowych', '1. Piekarnik rozgrzej do temperatury 180°C.\r\n\r\n2. Białka oddziel od żółtek i ubij na sztywną pianę. Następnie dodaj cukier, cały czas ubijając. Gdy białka z cukrem będą ubite na sztywną pianę, powoli dodawaj żółtka, nie przestając ubijać.\r\n\r\n3. Powoli dodawaj pozostałe składniki na ciasto, miksując do całkowitego połączenia.\r\n\r\n4. Masę na ciasto przelej do wyłożonej papierem do pieczenia tortownicy i piecz około 20 minut. Po zapieczeniu wyjmij formę i wystudź.\r\n\r\n5. Składniki na masę dokładnie zmiksuj, wysmaruj nią wystudzone ciasto i wstaw na całą noc do lodówki.\r\n\r\n6. Udekoruj świeżymi owocami, płatkami czekolady lub wiórkami.														', 'Lekki i pyszny torcik kokosowy to wspaniała opcja na deser. Do kawy jak znalazł!', 1, 3, 40, 2, 10, 3, 0, 1, 0, 1, 1),
(7, 'Chleb z kawałkami truskawek ', '150 ml letniego mleka,\r\nkostka drożdży (42 g),\r\nszczypta soli,\r\n2 torebki cukru waniliowego,\r\n20 dag cukru,\r\n3 żółtka,\r\n10 dag miękkiego masła + do formy,\r\n52 dag mąki,\r\n30 dag truskawek,\r\n2 łyżki miodu,\r\n15 dag siekanych migdałów,\r\n60 dag kremówki,\r\nłyżeczka skórki otartej z cytryny,\r\nłyżeczka cynamonu', '1. Mleko, drożdże, sól, cukier waniliowy, 10 dag cukru, żółtka i masło ucieramy, następnie mieszamy z 50 dag mąki i wyrabiamy gładkie, elastyczne ciasto. Zostawiamy pod przykryciem w ciepłym miejscu na 40 min.\r\n\r\n2. Oczyszczone truskawki kroimy. Resztę cukru, miód i migdały mieszamy w rondelku, podgrzewamy do lekkiego skarmelizowania. Dodajemy łyżkę mąki, 5 dag śmietany i truskawki, zagotowujemy. Przyprawiamy skórką z cytryny i cynamonem, studzimy.\r\n\r\n3. Wyrośnięte ciasto dzielimy na połówki, obie rozwałkowujemy na placki o wym. 40x30 cm, smarujemy masą z truskawkami, zostawiając wolne brzegi. Zwijamy wzdłuż dłuższych boków. Powstałe roladki zlepiamy krótszym końcem, przeplatamy.\r\n\r\n4. Przekładamy do blachy posmarowanej masłem i oprószonej mąką, zostawiamy na 20 min.\r\n\r\n5. Wstawiamy do piekarnika o temp. 180°C, smarujemy resztą śmietany i pieczemy około 35 min, do suchego patyczka. Przed podaniem można oprószyć cukrem pudrem.', 'Jeśli lubicie drożdżowe ciasto z truskawkami, ten chleb też pokochacie. Jest idealny na śniadanie, najlepszy na ciepło, w towarzystwie kubka mleka.', 9, 3, 240, 2, 10, 3, 0, 1, 0, 1, 0),
(8, 'Babka cytrynowa z kokosową polewą', 'Na ciasto: 130 g zmielonych migdałów lub orzechów,100 g kaszki kukurydzianej,3 jajka,1 duża cytryna (wyciśnięty sok + starta skórka),50 g oleju kokosowego,70 g ksylitolu,Na polewę: 4 łyżki mleczka kokosowego,2 łyżki jogurtu greckiego,3 łyżki ksylitolu,1 łyżka serka mascarpone,starta skórka z cytryny do dekoracji', '1. Piekarnik nagrzej do temperatury 180°C.\r\n\r\n2. Wszystkie składniki na polewę zmiksuj i wstaw do lodówki.\r\n\r\n3. Wszystkie składniki na ciasto zmiksuj na kremową masę.\r\n\r\n4. Powstałą masę na ciasto przelej do formy.\r\n\r\n5. Piecz około 30–40 minut (aż włożony w ciasto patyczek po wyjęciu będzie suchy). Upieczone ciasto wyjmij z piekarnika i wystudź.\r\n\r\n6. Polewę wyjmij z lodówki i wyłóż na schłodzone ciasto, ozdób startą skórką z cytryny.', 'Cytrynowe ciasto wspaniale smakuje z polewą, ale możemy też potraktować je jako bazę do innych deserów.', 9, 3, 50, 1, 6, 3, 0, 1, 0, 1, 0),
(9, 'Zupa pieczarkowa z serem', 'kilka plasterków wędzonego boczku,\r\nmasło,\r\n30 dag jak najmniejszych pieczarek,\r\nszalotka,\r\n2 łyżki mąki,\r\n1,5 l bulionu albo rosołu,\r\nziarenko ziela angielskiego,\r\nliść laurowy,\r\n10 dag śmietankowego kremowego serka,\r\n1/2 szklanki płynnej kremówki,\r\n20 dag krótkiego, grubego makaronu (świderki, muszelki),\r\n4 łyżki startego sera typu parmezan,\r\ntymianek,\r\nsól, pieprz', '1. Boczek kroimy w paski, wytapiamy w garnku z grubym dnem. Dodajemy 1–2 łyżki masła, wkładamy pokrojone w grubsze plasterki pieczarki, chwilę smażymy. Przesmażone składniki odławiamy i odkładamy. Na pozostały w garnku tłuszcz dajemy posiekaną szalotkę, szklimy, oprószamy mąką i zasmażamy, po czym zalewamy gorącym bulionem lub rosołem, wkładamy ziele angielskie i liść laurowy oraz serek, mieszamy aż się rozpuści.\r\n\r\n2. Wlewamy śmietanę, przyprawiamy do smaku solą, pieprzem (zupę można zmiksować, aby była bardziej aksamitna). Podajemy z ugotowanym al dente makaronem, na wierzchu każdej porcji kładziemy pieczarki z boczkiem, posypujemy serem i tymiankiem.', 'Aksamitna zupa pieczarkowa to coś, co lubimy!', 9, 6, 45, 1, 6, 1, 1, 0, 1, 0, 0),
(10, 'Pudding ryżowy z truskawkami', '4 jajka (osobno żółtka i białka),2 dag cukru,20 dag gęstej śmietany,4 łyżki mąki kukurydzianej,1/2 łyżeczki proszku do pieczenia,30 dag truskawek,łyżka cukru pudru,łyżeczka soku z cytryny,1/4 tabliczki białej czekolady,masa ryżowa: 600 ml tłustego mleka,strąk wanilii,10 dag cukru,20 dag okrągłego ryżu', '1. Na masę ryżową: zagotowujemy mleko z wanilią (rozciętym strąkiem i wydłubanymi ziarenkami), cukrem i ryżem, aż ryż będzie miękki i powstanie gęsta, pachnąca masa. Strąk wanilii usuwamy.\r\n\r\n2. Białka ubijamy na sztywną pianę. Żółtka roztrzepujemy z cukrem na pianę, ucieramy ze śmietaną, mąką i proszkiem do pieczenia oraz masą ryżową, a na koniec łączymy z pianą.\r\n\r\n3. Masę przekładamy do wyłożonej papierem do pieczenia tortownicy o średnicy 24 cm. Wstawiamy do piekarnika rozgrzanego do temp. 160°C na ok. 50 min.\r\n\r\n4. Oczyszczone truskawki kroimy na ćwiartki, połowę miksujemy z cukrem pudrem i sokiem z cytryny, a następnie mieszamy z pozostałymi ćwiartkami owoców.\r\n\r\n5. Ostudzony pudding wykładamy na talerz, na wierzch nakładamy truskawki z musem, posypujemy wiórkami czekolady.				', 'Sycący i pyszny deser - wypróbujcie ten przepis na pudding ryżowy z truskawkami.', 1, 3, 60, 2, 6, 3, 0, 1, 0, 1, 0),
(11, 'Czekolada chałwowa', '2 łyżki pasty tahini,50 g mleka w proszku,½ łyżki miodu (lub więcej),5 łyżek płynnego oleju kokosowego,3 łyżki płynnego masła klarowanego,ulubione orzechy lub płatki migdałowe', '1. Zblenduj na kremową masę wszystkie składniki na czekoladę. Jeśli uznasz, że masa jest za mało słodka, możesz dodać więcej miodu.\r\n\r\n2. Masę wylej do plastikowego pudełeczka, wyłożonego folią aluminiową.\r\n\r\n3. Posyp ulubionymi orzechami.\r\n\r\n4. Wstaw do zamrażarki na pół godziny.\r\n\r\n5.Przechowuj w lodówce.', 'W tym przepisie łączymy dwa nasze ulubione słodycze: czekoladę i chałwę. Jest pysznie!', 1, 3, 45, 2, 6, 3, 0, 1, 0, 1, 0),
(12, 'Bezy z musem awokado', 'Na bezy: ½ szklanki wody odlanej z puszki z ciecierzycą,¾ szklanki ksylitolu,1 łyżka dowolnego budyniu bez cukru,Na krem: 1 dojrzałe awokado,3 łyżki ksylitolu,2 łyżki soku z cytryny,2 łyżki jogurtu greckiego', '1. Wodę z ciecierzycy (aquafabę) przelej do miski i zacznij ubijać mikserem na wysokich obrotach.\r\n\r\n2. Ustaw prędkość miksera na średnią i następnie w sporych odstępach czasu zacznij dodawać ksylitol wymieszany z budyniem, cały czas ubijając.\r\n\r\n3. Po wsypaniu całego ksylitolu i budyniu znów zwiększ prędkość miksera na maksymalną i ubijaj jeszcze chwilę.\r\nPiekarnik rozgrzej do temperatury 130°C, wyłóż blachę papierem do pieczenia i rozprowadzaj bezy w równych odstępach.\r\n\r\n4. Bezy piecz około 120 minut, następnie pozostaw drzwiczki piekarnika uchylone i poczekaj do całkowitego wyschnięcia.\r\n\r\n5. Awokado obierz i wypestkuj, a następnie wszystkie składniki na krem zblenduj.\r\n\r\n6. Podawaj bezy posmarowane kremem.', 'Awokado zaskakująco dobrze sprawdza się w deserach. Spróbujcie tego musu!', 1, 3, 160, 3, 6, 3, 1, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sposob_przygotowania`
--

CREATE TABLE `sposob_przygotowania` (
  `id_spos_przygotowania` int(11) NOT NULL,
  `nazwa_spos_przygotowania` varchar(25) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `sposob_przygotowania`
--

INSERT INTO `sposob_przygotowania` (`id_spos_przygotowania`, `nazwa_spos_przygotowania`) VALUES
(1, 'Gotowanie'),
(2, 'Smażenie'),
(3, 'Pieczenie'),
(4, 'Duszenie'),
(5, 'Marynowanie'),
(6, 'Na parze'),
(7, 'Na zimno'),
(8, 'Grillowane');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_uzytkownika` int(11) NOT NULL,
  `uzytkownik` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_uzytkownika`, `uzytkownik`, `haslo`, `email`) VALUES
(1, 'admin', '$2y$10$9ABW9bKt9mP2qLnORSP.KenD9yDwtVfELulFydLQWfDD7J6b4VzyC', 'admin@admin.pl'),
(3, 'piotrek', '$2y$10$D48mndAXP.E7G3ejK7Wthu5zS4ZcPQ5CzG2ciyCUp6Whmua.6gOKK', 'piotrek@gmail.com'),
(4, 'pawel', '$2y$10$8Q3vlaczOV8qnuadBfwiFuzgKlbr/F2h9rzXMoqjV9uuZEQrTOu62', 'pawel@gmail.com'),
(5, 'dominika', '$2y$10$GAQuzS90cOzZbg3YtfoKdeMGgdIrf7uPLXcBji84Efx2CuBHfAAOe', 'dominika123@gmail.com'),
(6, 'bartek', '$2y$10$bho6PN97Ki7Cqo3s47NfBuVcC7SN4uhozieooaH33SjUQARp2YdI6', 'bartek@gmail.com'),
(7, 'wiktoria', '$2y$10$uwmLkH2GnLzvAN6LR8LAB.4RwTCLvrTfzFNJn1l.9mSi5dU9/1bJi', 'wiktoria@gmail.com'),
(8, 'janusz', '$2y$10$OyHouCmVk2OTagw/mhqYweANc1ap1z3T94.xuNczH10HWc95ZOzPC', 'janusz@gmail.com'),
(9, 'waldemar', '$2y$10$jG4EQuIbVVRaR9flnI4I0OtbFkbrMTTwgXUlz3q3BOBlOOE3WU.Eq', 'waldemar@gmail.com'),
(13, 'barbaraw', '$2y$10$vJxoz6F2.5MbPJPIRbAVY.CoPmd99CPIvCfusHJwirRzWZGqdTliS', 'baska@wp.pl'),
(14, 'Alicja', '$2y$10$Ci4MLjeiiXm9AxRG1sQYQObSxKwaEZpx43TvuvLahgVx7UoK3gL/m', 'alicja@gmail.com'),
(15, 'Jola', '$2y$10$/ZRRFpm5pb76.wRaOLi7tumrs95RDfg169Mv99c0Dan/w3JrU7wIm', 'jola@gmail.com'),
(16, 'Lucyna', '$2y$10$cQdk7kNrWcokHwfmG/v0HuZSYjNfDiis5pPYCfECJ8/dIEU748x4i', 'Lucyna@gmail.com'),
(17, 'Wojtek', '$2y$10$YS6FKUuLSaE9Ftf7ISdQpubBZGKGm9k3lmEP5FDbg64N1aJfYKzZq', 'wojtek@gmail.com'),
(18, 'Hubert', '$2y$10$MMfqssHG6tZ3O9pexIKgC.xbxJeqgEWbPEWbCljc7hVVk0Vox58P6', 'hubert@gmail.com'),
(19, 'Jolka', '$2y$10$gxy5VbhAHUAtUbJZZ.Gkw.R.b8WwFxzlq6VPxS1HTVsuG91VK4jRe', 'jolka@gmail.com'),
(20, 'Róża', '$2y$10$W/nnRz.zbPMzZWZ.3/ux9OqBtLJApw8qwOlmvOyE9JnD03ruAbfsO', 'roza@gmail.com'),
(21, 'asassn1', '$2y$10$0c74O5/rOCrFaOxtSblhy.c9wVYbwWXdFXlO8F.44lhKhMcV/p7d6', 'adassm1@gmail.com'),
(22, 'piotrek1', '$2y$10$Fdvq.hTz9SOuBeAepa7CK.qgb0N/yD4bVE1zsmS2Z7W2fWf52djDG', 'piotrek1@o2.pl'),
(23, 'Piotr12', '$2y$10$RPo1QUNLJ24Cv97teTaUqeSVFJJHwVr0eiLwkuxajpbxQHUf0vhgC', 'piotr12@o2.pl'),
(24, 'zolo', '$2y$10$JKtKgOgcMKQh37.e9ZATgu3FMJPeePFqH2D4GsvLAWyQZ8v8WjhcS', 'zolo@gmail.com'),
(25, 'JacekW', '$2y$10$ZVZR2l00ZomnMg4NaC9FI.mAsUJvup5znQucVFytc9wxjHXWchinK', 'JacekW@gmail.com'),
(26, 'Wiesiek', '$2y$10$JT3eLLP.BsxmvKbQ8fCVEeFjBGZ28v9.LfETpMq7K4KMM2gaQ/U0m', 'wiesiek@gmail.com');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `czas_przygotowania`
--
ALTER TABLE `czas_przygotowania`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`id_komentarza`);

--
-- Indexes for table `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`id_oceny`);

--
-- Indexes for table `przepisy`
--
ALTER TABLE `przepisy`
  ADD PRIMARY KEY (`id_przepisu`);

--
-- Indexes for table `sposob_przygotowania`
--
ALTER TABLE `sposob_przygotowania`
  ADD PRIMARY KEY (`id_spos_przygotowania`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_uzytkownika`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `czas_przygotowania`
--
ALTER TABLE `czas_przygotowania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  MODIFY `id_komentarza` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT dla tabeli `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id_oceny` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT dla tabeli `przepisy`
--
ALTER TABLE `przepisy`
  MODIFY `id_przepisu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `sposob_przygotowania`
--
ALTER TABLE `sposob_przygotowania`
  MODIFY `id_spos_przygotowania` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_uzytkownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
