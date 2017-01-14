<?php
session_start();

# asetetaan session muuttujat:
# $_SESSION['username'] = $user;
# $_SESSION['userID'] = $row["id"];
# $_SESSION['teamname'] = $row["tiiminNimi"];

echo '
<head>
<title>Ympäriajomanageri: Rekisteröityminen</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';

if (isset($_POST['user']) && isset($_POST['pass1']) && isset($_POST['pass2']) && isset($_POST['joukkueenNimi'])) {
	$user = $_POST['user'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$joukkueenNimi = $_POST['joukkueenNimi'];
	
	if (strcmp($pass1, $pass2) != 0) {
		echo "salasanat eivät täsmää, koita uudelleen";
		exit;
	}
	
	require('dbConn.php');
	
	# tarkista, onko joukkueen nimi jo olemassa
	$sql = "SELECT teamname FROM Pelaajat";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tempname = $row["tiiminNimi"];
			if (strcmp($tempname, $joukkueenNimi) == 0) {
				echo "Joukkueen nimi $joukkueenNimi jo käytössä, valitse uusi. <br><a href=register.html>Rekisteröidy uudelleen</a>"; 
				exit;
			}
		}
	}
	# tarkista, onko käyttäjänimi jo olemassa
	$sql = "SELECT tunnus FROM Pelaajat";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tempname = $row["username"];
			if (strcmp($tempname, $user) == 0) {
				echo "Käyttäjänimi $user jo käytössä, valitse uusi. <br><a href=register.html>Rekisteröidy uudelleen</a>"; 
				exit;
			}
		}
	}

	$_SESSION['username'] = $user;
	$_SESSION['teamname'] = $joukkueenNimi;

	$tsql = "insert into Pelaajat (tunnus, tiiminNimi, pisteet, salasana, vaihtojaJaljella)
		values ('$user', '$joukkueenNimi', 0, '$pass1', 8)";

	if ($conn->query($tsql) === TRUE) {
		echo "$user, sinut on kirjattu järjestelmään<p></p>";
	} else {
		echo "Error: " . $tsql . "<br>" . $conn->error;
	}
	
	# asetetaan pelaajan sessio id
	$sql = "SELECT id FROM Pelaajat where tunnus='$user'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$_SESSION['userID'] = $row["id"];
		}
	}
	
	# tehdään oman joukkueen taulu
	$sql = 'create table omatKuskit' .$_SESSION['userID'] .' (
		kuskiID int(6) auto_increment primary key,
		numero int(6) not null,
		nimi varchar(255) not null,
		tiimi varchar(255) not null,
		liittymisEtappi int(6) not null,
		omatPisteet int(6) not null default 0,
		hinta int(6) not null
	)';
	
	if ($conn->query($sql) === FALSE) {
		echo "Virhe luodessa tietokantaa: " . $conn->error;
	}
	
	$conn->close();
	
	echo 'Ole hyvä ja jatka valitsemaan <a href=valitsekuski.php>ensimmäiset kuskit</a>';
	echo '<br>tai <a href=logout.php>kirjaudu ulos</a>';
} else {
	echo "Jätit joitain kenttiä tyhjiksi" ;
}

?>
