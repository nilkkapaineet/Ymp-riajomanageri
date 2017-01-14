<?php
session_start();
echo '
<head>
<title>Ympäriajomanageri: Kirjautuminen</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="fillariStyle.css">
</head>';

# asetetaan session muuttujat:
# $_SESSION['username'] = $user;
# $_SESSION['userID'] = $row["id"];

if (isset($_POST['user']) && isset($_POST['pass'])) {
	$user = $_POST['user'];
	$pass = $_POST['pass'];

	require('dbConn.php');

	$query = 'select * from Pelaajat '
		."where tunnus='$user' "
		." and salasana=('$pass') ";

	$result = $conn->query($query);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$userID = $row["id"];
			$joukkueenNimi = $row["tiiminNimi"];
			$_SESSION['teamname'] = $row["tiiminNimi"];
			$pisteet = $row["pisteet"];
			$_SESSION['userID'] = $row["id"];
			$_SESSION['username'] = $row['tunnus'];
		}
	}	
}
?>

<html>
<body>
<?php
	require('omaJoukkue.php');
?>

</body>
</html>
