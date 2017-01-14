<?php
session_start();
echo '
<head>
<title>Ympäriajomanageri: Lisää kuskeja</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';

require('dbConn.php');
require('pvm.php');
# tarkista omien kuskien määrä
$sql = "select * from omatKuskit$_SESSION[userID]";
$result = $conn->query($sql);
$num_rows = $result->num_rows;
$num_rows = 10-$num_rows;

# tulosta kuskien lisäys kertaa 10-kuskien määrä

$sql = "SELECT number, name, team, price FROM Kuskit";
$result = $conn->query($sql);

echo "$_SESSION[teamname] valitse uudet kuskit</p>";
echo "<form action=\"lisays.php\" method=\"post\"> ";
echo "<table>";
for ($index = 0;$index<$num_rows;$index++) {
	echo "<tr><td>" . ($index+1). ":</td><td><select name=number" . $index. ">";
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			echo "<option value=\"" . $row["number"]. "\">" . $row["number"]. ": " . $row["name"]. ", " . $row["team"]. ", " . $row["price"]. "€</option> \n";
		}
	}
	echo "</select></td></tr>";
	$result = $conn->query($sql);
}

echo "</table><input type=\"submit\"><p></p>";


?>

<html>
<body>

<?php require('omaJoukkue.php'); ?>
