<?php
session_start();
echo '
<head>
<title>Ympäriajomanageri: Ohjeet</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';

echo '

<b>Valinnat ja vaihdot</b>
<p>
Joukkueeseen valitaan 10 ajajaa, jotka maksavat yhteensä enintään 10 000. Kisan aikana saa tehdä 8 vaihtoa 
(pitäen joukkueen arvon maksimissaan 10 000:ssa. Samaan aikaan saa tehdä useamman vaihdon. Ennen etapin alkua 
tehdyt vaihdot tulevat voimaan sille etapille. Etapin aikana ei saa tehdä vaihtoja.
Tässä verkkosovelluksessa vaihdot kirjataan siinä kohtaa, kun poistat ajajan joukkueestasi. Lisätessäsi uuden ajajan 
poistetun tilalle ei vaihtoja kulu.
<p>
<b>Pisteytys</b>
<p>
Tavalliset etapit ja aika-ajo:<br>
Tulokset: 100-70-50-35-30-25-20-16-13-10-7-5-3-2-1 pistettä<br>
Paidat: 25-20-20-15 pistettä sille jolla on punainen-vihreä-pilkku-valkoinen paita yllä etapin aikana<br>
Paras joukkue: 5 pistettä kaikille kisassa mukana oleville<br>
Pisimpään irtiotossa: 10 pistettä
<p>
Joukkueaika-ajo:<br>
40-28-20-14-12-10-8-6-5-4-3-2-1 joukkueen mukana maaliin tuleville, puolitetut pisteet muille.
<p>
Alkuperäisen ajajan bonus:<br>
Ajajat, jotka ovat olleet alusta loppuun joukkueessa, saavat etapeilta ansaitsemiinsa pisteisiin 20% bonuksen kisan lopussa.
<p>
Lopputulokset:<br>
Ajajat saavat pisteitä heidän sijoituksiensa mukaisesti. Nämä pisteet kerrotaan ajettuen etappien määrällä siitä hetkestä 
lähtien kun viimeksi otit ajajan joukkueeseesi. Pisteet ovat
<p>
Yleiskilpailu: 25-20-18-16-15-14-13-12-11-10-7-7-6-6-5-3-2-2-1-1<br>
Piste ja mäkikisat: 10-7-5-3-3-2-2-1-1-1<br>
Yhdistelmäkisa: 5-4-3-2-1<br>
Joukkuekisa: 2-1-1 (kaikille joukkueesta maaliin ajaville)
<p>
Eli jos otit ajajan joukkueeseesi etapin 8 jälkeen ja hän oli 2. kokonaiskisassa ja 3. mäkikisassa, saat (20+5)*13=325 pistettä.
<p>
';

echo '
		<a href=logout.php>Kirjaudu ulos</a><br>
		<a href=poistaKuski.php>Poista kuskeja</a><br>
		<a href=lisaaKuskeja.php>Lisää kuskeja</a><br>
		<a href=kaikki.php>Katso kaikki tiimit</a>
		';

?>
