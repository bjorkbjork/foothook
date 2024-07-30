<!doctype html>
<html>
<head>
<link rel="apple-touch-icon" sizes="57x57" href="apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
<link rel="manifest" href="manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<meta charset="utf-8">
<title>Login - FootHook</title>
</head>
<?php
// Initialize the session
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
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
	
	$search = $_GET["search"];
	
	$search = htmlspecialchars($search); 
     
         
    $search = mysqli_real_escape_string($search);
	
	$sql = "SELECT id FROM accounts WHERE username LIKE '%$search%'";
		
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
				
		$id = $row["id"];
		
		$sql1 = "SELECT * FROM accounts
				WHERE username LIKE '%$search%'  
				UNION  
				SELECT * FROM posts 
				WHERE post_content LIKE '%$search% or account_id LIKE '%$search%'  
				UNION
				SELECT * FROM comments
				WHERE comments_contents LIKE '%$search%'";
		
		$result1 = $conn->query($sql);
		
		if ($result1->num_rows > 0) {
			
		}
	}

	
?>
<body>
</body>
</html>