<?php
	if (isset($_SESSION['username'])) {
		
		$sql = "SELECT vaihtojaJaljella FROM Pelaajat where id=$_SESSION[userID]";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$vaihdotJaljella = $row['vaihtojaJaljella'];
			}
		}

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
		
		$conn->close();
		
		# tähän tulostetaan nykyinen joukkue
		echo '
			Nykyinen joukkueesi: <p>
			<table><tr><td></td><td><b>' .$_SESSION['username'] .'</b></td>
			<td><b>' . $_SESSION['teamname'] .'</b></td>
			<td><b>' .$joukkueenHinta .' €</b></td>
			<td></td>
			<td><b>' .$pisteet .' pistettä</b></td></tr>
			<tr><td>numero</td><td>nimi</td><td>tiimi</td><td>hinta</td><td>LiittymisEtappi</td><td>Pisteet liittymisen jälkeen</td></tr>';
			for ($index=0;$index<10;$index++) {
				echo "<tr><td>$numerot[$index]</td><td>$nimi[$index]</td><td>$tiimi[$index]</td><td>$hinta[$index]</td><td>$etappi[$index]</td><td>$piste[$index]</td></tr>";
			}
			echo '
			</table>
			Vaihtoja jäljellä: ' .$vaihdotJaljella .'
			</p>
			<a href=logout.php>Kirjaudu ulos</a><br>
		<a href=poistaKuski.php>Poista kuskeja</a><br>
		<a href=lisaaKuskeja.php>Lisää kuskeja</a><br>
		<a href=kaikki.php>Katso kaikki tiimit</a><br>
		<a href=ohjeet.php>Peliohjeet</a>
		';
		
	} else {
		if (isset($user)) {
			echo 'Kirjautuminen epäonnistui <br>';
		} else {
			echo 'Et ole kirjautunut sisään <br>';
		}
		
		echo 'Sisäänkirjautuminen<p>
			<form action="kirjaudu.php" method="post">
			<table><tr><td>
			Käyttäjätunnus:</td><td><input type=text name=user><br>
			</td></tr>
			<tr><td>
			Salasana:</td><td><input type=text name=pass><br>
			</td></tr>
			</table>
			<input type=submit><p>
			<a href="register.html">Rekisteröityminen</a><p>
			</form>';
	}
?>
