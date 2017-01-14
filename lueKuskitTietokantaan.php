<?php
/*
 * index.php
 * 
 * Copyright 2016 pekka <pekka@pekka-Aspire-5732Z>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>nimetön</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
</head>

<body>
<p>
	Luetaan kuskit tietokantaan</p>
<p>

<?php
$servername = "localhost";
$username = "root";
$password = "omaSalasanaTähän";

$dbname = "myDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$lines = file('ajajat.txt.csv');
$indeksi = 0;
foreach ($lines as $rivi) {
	$hr = explode("#\"#\"#", $rivi);
	$hr[0] = trim($hr[0]);
	$hr[0] = rtrim($hr[0], "#");
	$hr[0] = trim($hr[0]);
		$hr[1] = trim($hr[1]);
	$hr[1] = rtrim($hr[1], "#");
	$hr[1] = trim($hr[1]);

	$hr[2] = trim($hr[2]);
	$hr[2] = rtrim($hr[2], "#");
	$hr[2] = trim($hr[2]);

	$hr[3] = trim($hr[3]);
	$hr[3] = rtrim($hr[3], "#");
	$hr[3] = trim($hr[3]);
	if ($indeksi == 3) {
		$joku1 = $hr[0];
		$joku2 = $hr[1];
		$joku3 = $hr[2];
		$joku4 = $hr[3];
	}

	$isql = "insert into Kuskit (number, name, team, price)
	values ($hr[0], '$hr[1]', '$hr[3]', $hr[2])";
if ($conn->query($isql) === TRUE) {

} else {
    echo "Error: " . $isql . "<br>" . $conn->error;
}
	
	$indeksi += 1;
}


$sql = "SELECT number, name, team, price FROM Kuskit";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "numero: " . $row["number"]. " - Nimi: " . $row["name"]. " Tiimi: " . $row["team"]. " Hinta: " . $row["price"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>
</p>
</body>

</html>
