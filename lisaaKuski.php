<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Ympäriajomanageri: Kuskit valittu</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">

	<meta name="generator" content="Geany 1.23.1" />
</head>

<body>

<?php
	
	require('dbConn.php'); 

	# get post data
	for ($index = 1;$index<11;$index++) {
		if (in_array((int)$_POST['number' . $index], $chosenNumber, true)) {
			# kuski on jo valittu
			echo '
				Sama kuski useampaan kertaan. <br>
				Palaa <a href=valitsekuski.php>takaisin</a>
			';
			exit;
		}
		$chosenNumber[$index] = (int)$_POST['number' . $index];	
	}

	# hae kuskien hinnat ja katso, ettei mene yli maksimirajan
	$kokonaishinta = 0;
	$nimet = array();
	$hinnat = array();
	$tiimit = array();
	
	for ($index = 1;$index<11;$index++) {
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
	
	for ($index=1;$index<11;$index++) {
		$isql = "insert into omatKuskit$_SESSION[userID] (numero, nimi, tiimi, liittymisEtappi, omatPisteet, hinta) values ($chosenNumber[$index], '$nimet[$index]', '$tiimit[$index]', 1, 0, $hinnat[$index])";

		if ($conn->query($isql) === FALSE) {
			echo "Error: " . $isql . "<br>" . $conn->error;
		}
	}	

	$conn->close();
	
	echo "Käyttäjä: $_SESSION[username]<p></p>";
	echo "Lisättiin kuskit: <p></p><table>";
	for ($index = 1;$index<11;$index++) {
		echo "<tr><td>$chosenNumber[$index]</td><td>$nimet[$index]</td><td>$tiimit[$index]</td><td>$hinnat[$index]</td></tr>";
	}
	echo "</table>";
	
	echo'
		<a href=logout.php>Kirjaudu ulos</a><br>
		<a href=poistaKuski.php>Poista kuskeja</a><br>
		<a href=kaikki.php>Katso kaikki tiimit</a>
	';

?>
