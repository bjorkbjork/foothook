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

$id = $_GET['post_id'];
$score = $_GET['post_score'];
$acc_id = $_GET['account_id'];
	
$upvote = $_GET['upvote'];	
$unupvote = $_GET['unupvote'];
	
if ($upvote == "true"){
	
	$sql = "SELECT id, account_id, post_id FROM upvotes WHERE account_id = $acc_id AND post_id = $id";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		if ($unupvote == "true"){
			$sql3 = "DELETE FROM upvotes WHERE (account_id, post_id) = (?, ?)";
			if($stmt = mysqli_prepare($conn, $sql3)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "ss", $param_accID, $param_postID);

				// Set parameters

				$param_accID = $acc_id;
				$param_postID = $id;

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){

				} else{
					echo "Something went wrong. Please try again later." . mysqli_error($conn);
				}
				 // Close statemen
				mysqli_stmt_close($stmt);
			}
		}
	}
	else{

		$sql1 = "UPDATE posts SET score = $score WHERE id = $id";

		if ($conn->query($sql1) === TRUE) {

		} else {
		   $conn->error;
		}


		if ($unupvote == "false"){

			$sql2 = "INSERT INTO upvotes (account_id, post_id) VALUES (?, ?)";

			if($stmt = mysqli_prepare($conn, $sql2)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "ss", $param_accID, $param_postID);

				// Set parameters
				$param_accID = $acc_id;
				$param_postID = $id;

				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){

				} else{
					echo "Something went wrong. Please try again later." . mysqli_error($conn);
				}
				 // Close statemen
				mysqli_stmt_close($stmt);
			}
		}

	}
}
elseif ($downvote == "true") {
	
}
	
$conn->close();
?>
<body>
</body>
</html>