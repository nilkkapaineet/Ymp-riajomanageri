<?php
session_start();
echo '
<head>
<title>Ympäriajomanageri: Kaikkien tiimien tiedot</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';

	require('dbConn.php');

	$query = 'select * from Pelaajat ';

	$result = $conn->query($query);

	$iideet = array();
	$nimet = array();
	$jnimet = array();
	if ($result->num_rows > 0) {
		$index = 0;
		while($row = $result->fetch_assoc()) {
			$iideet[$index] = $row["id"];
			$nimet[$index] = $row["tunnus"];
			$jnimet[$index] = $row["tiiminNimi"];
			$index++;
		}
	}
	
	$nimiIndex = 0;
	foreach ($iideet as $cid) {
		$sql = "SELECT * FROM omatKuskit$cid";
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
		}
		
		# tähän tulostetaan nykyinen joukkue
		echo '
			<p>
			<table frame="box" rules="none"><tr><td></td><td><b>' .$nimet[$nimiIndex] .'</b></td>
			<td><b>' . $jnimet[$nimiIndex] .'</b></td>
			<td><b>' .$joukkueenHinta .' €</b></td>
			<td></td>
			<td><b>' .$pisteet .' pistettä</b></td></tr>
			<tr><td>numero</td><td>nimi</td><td>tiimi</td><td>hinta</td><td>LiittymisEtappi</td><td>Pisteet liittymisen jälkeen</td></tr>';
			for ($index=0;$index<10;$index++) {
				echo "<tr><td>$numerot[$index]</td><td>$nimi[$index]</td><td>$tiimi[$index]</td><td>$hinta[$index]</td><td>$etappi[$index]</td><td>$piste[$index]</td></tr>";
			}
			echo '
			</table>
			</p>';
			$nimiIndex++;
		}
					
		$conn->close();

			echo'
			<a href=logout.php>Kirjaudu ulos</a><br>
		<a href=poistaKuski.php>Poista kuskeja</a><br>
		<a href=lisaaKuskeja.php>Lisää kuskeja</a><br>
		<a href=kaikki.php>Katso kaikki tiimit</a>
		';
		
