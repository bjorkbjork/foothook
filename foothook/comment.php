<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<?php
// Initialize the session
session_start();
	
//require_once "index.php";
 
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

	$content = $_POST["reply"];
	$post_id = $_POST["post_id"];
	
	
	$sql = "INSERT INTO comments (post_id, account_id, comment_contents) VALUES (?, ?, ?)";
	
	if($stmt = mysqli_prepare($conn, $sql)){
		// Bind variables to the prepared statement as parameters
		mysqli_stmt_bind_param($stmt, "sss", $param_post_id, $param_sessID, $param_content);

		// Set parameters
		$param_post_id = $post_id;
		$param_sessID = $sessID;
		$param_content = $content;

		// Attempt to execute the prepared statement
		if(mysqli_stmt_execute($stmt)){
			
			$sql1 = "UPDATE posts SET number_of_comments = number_of_comments + 1 WHERE id = $post_id";
		
			if ($conn->query($sql1) === TRUE) {

			} else {
			   $conn->error;
			}
			
			// Redirect to login page
			$_SESSION["last_post"] = $post_id;
			header("location: index.php#post_modal_$post_id");
		} else{
			echo "Something went wrong. Please try again later." . mysqli_error($conn);
		}
		 // Close statemen
		mysqli_stmt_close($stmt);
	}

?>
</body>
</html>