<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "foothookdatabase";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	$sql = "SELECT * FROM posts";

	$result = $conn->query($sql);
	
	$score = $row["score"];
	$id = $row["score"];
	
	echo $score;
	echo $id;
	//echo $result;
?>
<body>
</body>
</html>