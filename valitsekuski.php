<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<link rel="stylesheet" type="text/css" href="fillariStyle.css">

	<title>Ympäriajomanageri: Ensimmäisten kuskien valinta</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
</head>

<body>

<?php
	
	require('dbConn.php'); 

	$sql = "SELECT number, name, team, price FROM Kuskit";
	$result = $conn->query($sql);

	echo "Joukkueen kokonaishinnan maksimi on 10 000 € <br>";
	echo "$_SESSION[username] valitse avaustiimisi joukkueet (10 kpl)</p>";
	echo "<form action=\"lisaaKuski.php\" method=\"post\"> ";

	echo "<table>";
	for ($index = 1;$index<11;$index++) {
		echo "<tr><td>" . $index. ":</td><td><select name=number" . $index. ">";
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "<option value=\"" . $row["number"]. "\">" . $row["number"]. ": " . $row["name"]. ", " . $row["team"]. ", " . $row["price"]. "€</option> \n";
			}
		}
		echo "</select></td></tr>";
#		echo "<br>";
		$result = $conn->query($sql);
	}

	echo "</table><input type=\"submit\">";
	$conn->close();
		echo '</p>tai <a href=logout.php>kirjaudu ulos</a>';

?>

</body>
</html>
