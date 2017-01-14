<?php
session_start();
echo '
<head>
<title>Ympäriajomanageri: Kuskit lisätty</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';

require('dbConn.php');
require('pvm.php');

# hae omat kuskit
$sql = "select * from omatKuskit$_SESSION[userID]";
$result = $conn->query($sql);
$onJoKuskiID = array();
for ($index = 0;$index<$num_rows;$index++) {
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$onJoKuskiID[$index] = $row['numero'];
		}
	}
}
$num_rows = $result->num_rows;

	# get post data
	for ($index = 0;$index<(10-$num_rows);$index++) {
		if (in_array((int)$_POST['number' . $index], $chosenNumber, true)) {
			# kuski on jo valittu
			echo '
				Sama kuski useampaan kertaan. <br>
				Palaa <a href=lisaaKuskeja.php>takaisin</a>
			';
			exit;
		}
		# yllä tarkisti sen, ettei samaa kuskia ole uusien joukossa
		# tarkista myös, ettei samaa kuskia ole ennestään joukkueessa
		if (in_array((int)$_POST['number' . $index], $onJoKuskiID, true)) {
			# kuski on jo valittu
			echo '
				Sama kuski useampaan kertaan. <br>
				Palaa <a href=lisaaKuskeja.php>takaisin</a>
			';
			exit;
		}
	
		# tässä kelvollinen uusi kuski lisätään chosenNumber listaan
		$chosenNumber[$index] = (int)$_POST['number' . $index];	
	}

	# hae kuskien hinnat ja katso, ettei mene yli maksimirajan
	$kokonaishinta = 0;
	$nimet = array();
	$hinnat = array();
	$tiimit = array();
	
	for ($index = 0;$index<(10-$num_rows);$index++) {
		$sql = "SELECT * FROM Kuskit where number=$chosenNumber[$index]";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$kokonaishinta += $row["price"];
				$nimet[$index] = $row["name"];
				$tiimit[$index] = $row["team"];
				$hinnat[$index] = $row["price"];
			}
		}
	}
	if ($kokonaishinta > 10000) {
		echo "Joukkueen kokonaishinta $kokonaishinta on liian suuri.<br><a href=valitsekuski.php>Palaa takaisin</a> ja valitse uudelleen.";
		exit;
	}
	######
	
	for ($index=0;$index<(10-$num_rows);$index++) {
		$isql = "insert into omatKuskit$_SESSION[userID] (numero, nimi, tiimi, liittymisEtappi, omatPisteet, hinta) values ($chosenNumber[$index], '$nimet[$index]', '$tiimit[$index]', $d, 0, $hinnat[$index])";

		if ($conn->query($isql) === FALSE) {
			echo "Error: " . $isql . "<br>" . $conn->error;
		}
	}	


?>

<html>
<body>

<?php require('omaJoukkue.php'); ?>
