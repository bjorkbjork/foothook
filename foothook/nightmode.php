<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<body>
<?php
	$servername = "127.0.0.1";
	$username = "root";
	$password = "";
	$dbname = "foothookdatabase";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sessUSER = $_SESSION["username"];
	$sessID = $_SESSION["id"];
	
		
	$sql = "UPDATE accounts SET dark_mode = NOT dark_mode WHERE id = $sessID";

	if ($conn->query($sql) === TRUE) {

	} else {
	   $conn->error;
	}

	header("location: index.php");

?>
<body>
</body>
</html>