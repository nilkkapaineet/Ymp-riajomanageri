<?php
session_start();
echo '
<head>
<title>Ympäriajomanageri: Kuskit poistettu</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';

	require('dbConn.php');

	if (isset($_POST['poista'])) {
		$poista = $_POST['poista'];
		echo 'Poistettiin kuskit näillä numeroilla: <p></p>';
		foreach ($poista as $poistettava) {
			echo "$poistettava <br>";
		}
	} else {
		echo "Yhtään kuskia ei poistettu<p></p>";
	}
	echo "<p></p>";
	
	# tarkista, saako poistaa i.e. onko poistettavia sallittu määrä
	$sql = "SELECT vaihtojaJaljella FROM Pelaajat where id=$_SESSION[userID]";
	$result = $conn->query($sql);
	$saaVaihtaa = true;
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if ($row['vaihtojaJaljella'] < count($poista) ) {
				echo "Vaihtoja ei riittävästi jäljellä</p>";
				$saaVaihtaa = false;
			}
			$vaihtoja = $row['vaihtojaJaljella'];
		}
	}

	if ($saaVaihtaa) {
		###### aseta poistetun kuskin numero nollaksi
		# tarkista userID
		# on tarkastettava, mikä on poistettavan kuskin indeksi tietokannassa
		foreach ($poista as $poistettava) {
			$sql = "delete from omatKuskit$_SESSION[userID] where numero=$poistettava";
			if ($conn->query($sql) === FALSE) {
				echo "Virhe poistettaessa: " . $conn->error;
			}
		}
	}
	
	# muuta jäljellä olevien vaihtojen määrää
	$jaljella = $vaihtoja-count($poista);
	$sql = "update Pelaajat set vaihtojaJaljella=$jaljella where id=$_SESSION[userID]";

	if ($conn->query($sql) === FALSE) {
		echo "Virhe päivitettäessä tietokantaa: " . $conn->error;
	}

?>


<html>
<body>

<?php require('omaJoukkue.php'); ?>
