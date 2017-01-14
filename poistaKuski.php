<?php
session_start();
echo '
<head>
<title>Ympäriajomanageri: Poista kuskeja</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';

require('dbConn.php');

$sql = "SELECT * FROM Pelaajat where id=$_SESSION[userID]";
$result = $conn->query($sql);
$vaihtoja = 0;
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$vaihtoja = $row["vaihtojaJaljella"];
	}
}
?>


<html>
<body>
<?php
	if (isset($_SESSION['username'])) {

		$sql = "SELECT * FROM omatKuskit$_SESSION[userID]";
		$result = $conn->query($sql);
		
		$nimi = array();
		$tiimi = array();
		$hinta = array();
		$piste = array();
		$etappi = array();
		$numerot = array();
		$joukkueenHinta = 0;
		if ($result->num_rows > 0) {
			$index = 0;
			while($row = $result->fetch_assoc()) {
				$nimi[$index] = $row["nimi"];
				$tiimi[$index] = $row["tiimi"];
				$hinta[$index] = $row["hinta"];  
				$joukkueenHinta += $row["hinta"];
				$piste[$index] = $row["omatPisteet"];
				$etappi[$index] = $row["liittymisEtappi"];
				$numerot[$index] = $row["numero"];
				$index++;
			}
		} else {
			echo '<p><a href=valitsekuski.php>Valitse ensimmäiset kuskit</a></p>';
		}
		$montako = $result->num_rows;
		
		$conn->close();
		
		# tähän tulostetaan nykyinen joukkue
		echo '
			Nykyinen joukkueesi: 
			<br>Sinulla on ' .$vaihtoja .' vaihtoa jäljellä
			<br>Ruksi poistettavat kuskit<p>
			<form action="poista.php" method="post">
			<table><tr><td></td><td><b>' .$_SESSION['username'] .'</b></td>
			<td><b>' . $_SESSION['teamname'] .'</b></td>
			<td><b>' .$joukkueenHinta .' €</b></td>
			<td></td>
			<td><b>' .$pisteet .' pistettä</b></td></tr>
			<tr><td></td><td>numero</td><td>nimi</td><td>tiimi</td><td>hinta</td><td>LiittymisEtappi</td><td>Pisteet liittymisen jälkeen</td></tr>';
			for ($index=0;$index<$montako;$index++) {
				echo "<tr><td><input type=checkbox name=poista[] value=$numerot[$index]></td><td>$numerot[$index]</td><td>$nimi[$index]</td><td>$tiimi[$index]</td><td>$hinta[$index]</td><td>$etappi[$index]</td><td>$piste[$index]</td></tr>";
			}
			echo '
			</table>
			<br><input type=submit></form>
			</p>
			<a href=logout.php>Kirjaudu ulos</a><br>
		<a href=lisaaKuskeja.php>Lisää kuskeja</a><br>
		<a href=kaikki.php>Katso kaikki tiimit</a>
		';
		
	}

?>

</body>
</html>
