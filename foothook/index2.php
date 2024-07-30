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
<title>FootHook</title>
<link href="index1.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<!--
<script>
	window.setInterval(function checkForChange() {
		$.ajax({
			url: 'query.php',
			data: {}, 
			success: function(data) {
				
			}
		});
	}, 1000);	
</script>
-->
</head>
<body>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<script type = "text/javascript">
	
	function dropDown() {
  		document.getElementById("dropdown").classList.toggle("show");
	}

	// Close the dropdown menu if the user clicks outside of it
	window.onclick = function(event) {
  		if (!event.target.matches('#navPFP')) {
    		var dropdowns = document.getElementsByClassName("dropdown-content");
    		var i;
			for (i = 0; i < dropdowns.length; i++) {
      			var openDropdown = dropdowns[i];
      			if (openDropdown.classList.contains('show')) {
        			openDropdown.classList.remove('show');
      			}
    		}
  		}
	}
</script>
<script>
$(document).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) { // ESC
		if($("#dropdown").hasClass("show")){
        	$("#dropdown").removeClass("show");
		}
	}
});	
</script>
<div class="main">
	<img class = "logo" src = "logo1.png" alt = "">
	<div class = "navbar">
<!--		<button onClick = "imGay()" href="logout.php">Log out</button>-->
		<span class = "left_buttons">
			<a class = "button" href = "index.php">Home</a>
			<a class = "button" href = "index.php">Notifications</a>
			<a class = "button" href = "index.php">Messages</a>
		</span>
		<span class = "right_buttons">
			<form action = "search.php">
				<div style = "display: flex; align-items: center; justify-content: space-around;">
					<input style = "border-top-right-radius: 0px; border-bottom-right-radius: 0px; height: 20px;" type = "text" pleaceholder = "Search..." name = "search">
					<button style = "max-height: 26px; max-width: 26px; border-radius: 0px; border-top-right-radius: 8px; border-bottom-right-radius: 8px" type = "submit"><i class = "search"></i></button>
				</div>
			</form>
<!--			<a class = "button" href = "index.php">Search</a>-->
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

				$sql = "SELECT * FROM accounts WHERE id = $sessID";

				$result = $conn->query($sql);

				
				if ($result->num_rows > 0) {
					// output data of each row
					while($row = $result->fetch_assoc()) {
						$userNAV = $row["username"];
						$pfpNAV = $row["profile_picture"];
						$fnNAV = $row["first_name"];
						$lnNAV = $row["last_name"];

						echo"
							<div class = \"dropdown\">
								<img id = \"navPFP\" style = \"margin-left:10px; margin-right: 20px;\" class = \"pfp\" width = \"30\" height = \"30\" src=\"$pfpNAV\" alt=\"$userNAV's pfp\" onClick = \"dropDown()\">
								<div id = \"dropdown\" class = \"dropdown-content\">	
									<div style = \"border-bottom: thin solid #BDBDBD;\">
										<h2>$fnNAV&nbsp;$lnNAV</h2>
										<p style = \"color:grey;margin-top:-40px;\">@$userNAV</p>
									</div>
									<div style = \"border-bottom: thin solid #BDBDBD;\">
										<a href = \"settings.php\">Accout Settings</a>
									</div>
									<a href = \"logout.php\">Log out @$userNAV</a>
									<a href = \"reset-password.php\">Reset password @$userNAV</a>
								</div>
							</div>
							
						";
					}	
				} else {
					printf("Query failed: %s\n", $conn->error);
				}
				$conn->close();
			?>
			<button onClick = "document.getElementById('createPost').classList.add('show')" class = "submit" type = "submit"><b>Create Foot</b></button>
		</span>
	</div>
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

		$sql = "SELECT * FROM accounts WHERE id = $sessID";

		$result = $conn->query($sql);


		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {
				$userNAV = $row["username"];
				$pfpNAV = $row["profile_picture"];
				$fnNAV = $row["first_name"];
				$lnNAV = $row["last_name"];

				echo"
					<div id = \"createPost\" class = \"modal\">
						<!-- Modal Content -->
						<form class = \"modal-content animate\" action = \"post.php\" method = \"post\">
							<span class = \"cmt_head\">
								<h2 class = \"cmt_header\">Compose new Post</h2>
								<span onclick=\"document.getElementById('createPost').classList.remove('show')\" 
								class=\"close\" title=\"Close Modal\">&times;</span>
							</span>
							<div class = \"lower_half\" style = \"margin-top: 4px;\">
								<div class = \"content\" style = \"margin-top: -10px;\">
									<img class = \"pfp\" width = \"32\" height = \"32\" src=\"$pfpNAV\" alt=\"$userNAV's pfp\" style = \"float:left;margin-top:32px;\">
								</div>
								<div style = \"padding:16px\">	
									<input style = \"width: 90%;\" type = \"text\" placeholder = \"Whats Happening?\" name = \"reply\" required>
									<div>
										<button id = \"submit\" class = \"submit\" type = \"submit\"><b>Post</b></button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<script>
					$(document).on( 'keydown', function ( e ) {
						if ( e.keyCode === 27 ) { // ESC
							if($(\"#createPost\").hasClass(\"show\")){
								$(\"#createPost\").removeClass(\"show\");
							}
						}
					});	
					</script>";
			}
		}
	?>
	<div class = "posts">
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

			$sql = "SELECT * FROM posts ORDER BY post_time DESC";

			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {

					
					$id = $row["id"];
					$score = $row["score"];
					$post = $row["post_contents"];
					$time = $row["post_time"];
					$account_id = $row["account_id"];
					if ($score == 0) {
						$score = "Vote";
					}
					
						$sql1 = "SELECT * FROM accounts WHERE id = $account_id";

						$result1 = $conn->query($sql1);

						if ($result1->num_rows > 0) {
							// output data of each row
							while($row = $result1->fetch_assoc()) {

								$user = $row["username"];
								$fn = $row["first_name"];
								$ln = $row["last_name"];
								$pfp = $row["profile_picture"];
								echo"
									<script>
									$( document ).ready(function() {
										if (\"$score\" == \"Vote\") {
											$(\"#score_$id\").css({\"margin-left\":\"-8px\"});
										}
									});
									$(document).on( 'keydown', function ( e ) {
										if ( e.keyCode === 27 ) { // ESC
											if($(\"#post_modal_$id\").hasClass(\"show\")){
												$(\"#post_modal_$id\").removeClass(\"show\");
											}
										}
										if ( e.keyCode === 27 ) { // ESC
											if($(\"#id$id\").hasClass(\"show\")){
												$(\"#id$id\").removeClass(\"show\");
											}
										}
									});	
								</script>
								<div id = \"post_modal_$id\" class = \"modal1\">
								
								<span onClick = \"postModalClose_$id()\" class=\"close1\" title=\"Close\">&times;</span>

											<!-- Modal Content -->
											<div class = \"modal-content animate\">
											
											<div class = \"container\">
												
												<div class = \"content\" style = \"margin-top: -10px;\">
													<img class = \"pfp\" width = \"50\" height = \"50\" src=\"$pfp\" alt=\"$user's pfp\" style = \"float:left;margin-top:20px;\">
													<div>
														<a class=\"name_and_date\">

															<spam class=\"name\">

																<h3 class=\"first_last_name\">$fn $ln</h3>
																<p class = \"username\">@$user</p>
															</spam>
														</a>
														<p class = \"contents\">$post</p>
													</div>
												</div>
											</div>
												<div class = \"lower_half\">
													<div style = \"padding:16px\">
														<label style = \"text-align:left;\" for = \"reply\"><span style = \"display: inline-block\"> Replying to </span><span style = \"color: deepskyblue; display:inline-block;\">&nbsp;@$user</span></label>
														<input style = \"\" type = \"text\" placeholder = \"Type your reply\" name = \"reply\" required>
														<div>
															<input type=\"hidden\" name=\"post_id\" value=\"$id\">
															<button id = \"submit_$id\" class = \"submit\" type = \"submit\"><b>Reply</b></button>
														</div>
													</div>
												</div>
												
												<div id = \"comments_$id\" class = \"comment\";>
												
												</div>
												
										  </div>
										</div>
								<div id=\"post$id\" class=\"post\">
									
									<div class = \"upvote_downvote\" style=\"margin-left: -35px;\">
										<div id=\"upvote_id$id\" class = \"upvote\">
										</div>
										<div id = \"score_$id\" class = \"score\">
											<p>$score</p>
										</div>
										<div id = \"downvote_id$id\" class = \"downvote\">
										</div>
									</div>
									<div id = \"content_$id\" class = \"content\" style = \"margin-top: -10px;\">
										<div class = \"pfp_div\">
											<img class = \"pfp\" width = \"50\" height = \"50\" src=\"$pfp\" alt=\"$user's pfp\" >
										</div>
											<div>
												<a class=\"name_and_date\">	
													<spam class=\"name\">
														<h3 class=\"first_last_name\">$fn $ln</h3>
														<p class = \"username\">@$user</p>
													</spam>
													<i class = \"date_time\">$time</i>
												</a>
												<p class = \"contents\">$post</p>
											</div>							
										<div class = \"share_and_comment\">
											<a class = \"share\">Share</a>
											<span onClick = \"startComment_$id()\" class = \"commentBTN\" id = \"commentBTN_$id\">
												<img class = \"commentBTN_img\" src = \"comment.png\" alt = \"\">
												<a class = \"commentBTN\">Comment</a>
											</span>
										</div>
										<div id = \"id$id\" class = \"modal\">

											<!-- Modal Content -->
											<form class = \"modal-content animate\" action = \"comment.php\" method = \"post\">
											<span class = \"cmt_head\">
												<h2 class = \"cmt_header\">Reply to $user</h2>
												<span onClick = \"endComment_$id()\" class=\"close\" title=\"Close Modal\">&times;</span>
											</span>
											
											<div class = \"container\">
												
												<div class = \"content\" style = \"margin-top: -10px;\">
													<img class = \"pfp\" width = \"50\" height = \"50\" src=\"$pfp\" alt=\"$user's pfp\" style = \"float:left;margin-top:20px;\">
													<div>
														<a class=\"name_and_date\">

															<spam class=\"name\">

																<h3 class=\"first_last_name\">$fn $ln</h3>
																<p class = \"username\">@$user</p>
															</spam>
														</a>
														<p class = \"contents\">$post</p>
													</div>
												</div>
											</div>
												<div class = \"lower_half\">
													<div style = \"padding:16px\">
														<label style = \"text-align:left;\" for = \"reply\"><span style = \"display: inline-block\"> Replying to </span><span style = \"color: deepskyblue; display:inline-block;\">&nbsp;@$user</span></label>
														<input style = \"\" type = \"text\" placeholder = \"Type your reply\" name = \"reply\" required>
														<div>
															<input type=\"hidden\" name=\"post_id\" value=\"$id\">
															<button id = \"submit_$id\" class = \"submit\" type = \"submit\"><b>Reply</b></button>
														</div>
													</div>
												</div>
										  </form>
										</div>
									</div>
								</div>
								<script id = \"com_script_$id\" type = \"text/javascript\">
									var commentOpened_$id = false;
									var postOpened_$id = false;
									setInterval(function(){
										if (!document.getElementById('id$id').classList.contains('show')){
											commentOpened_$id = false;
										}
										else{
											commentOpened_$id = true;
										}
										if (!document.getElementById('post_modal_$id').classList.contains('show')){
											postOpened_$id = false;
										}
										else{
											postOpened_$id = true;
										}
									}, 100);
									document.getElementById(\"content_$id\").onmouseover = function() {
										if((commentOpened_$id == false) && (postOpened_$id == false)){
											document.getElementById(\"post$id\").style.opacity = \"0.8\";
										}
									}
									document.getElementById(\"content_$id\").onclick = function() {
										postModalOpen_$id();
									}
									function postModalOpen_$id(){
										if (!commentOpened_$id){
											document.getElementById('post_modal_$id').classList.add('show');
											document.getElementById('post$id').style.opacity = \"1\";
											postOpened_$id = true;
										}
									}
									function postModalClose_$id(){
										document.getElementById('post_modal_$id').classList.remove('show');
									}
									document.getElementById(\"post$id\").onmouseout = function() {
										if(!commentOpened_$id){
											document.getElementById(\"post$id\").style.opacity = \"1\";
										}
										if(!postOpened_$id){
											document.getElementById(\"post$id\").style.opacity = \"1\";
										}
									}
									function startComment_$id(){
										if (!postOpened_$id){
											document.getElementById('id$id').classList.add('show') 
											var post = document.getElementById('post$id');
											post.style.opacity = \"1\";
											commentOpened_$id = true;	
										}
									}
									function endComment_$id(){
										document.getElementById('id$id').classList.remove('show');
									}
								</script>
								<script id=\"script_$id\">
									$(document).on( 'keydown', function ( e ) {
										if ( e.keyCode === 27 ) { // ESC
											if($(\"#id$id\").hasClass(\"show\")){
												endComment();
											}
											if($(\"#post_modal_$id\").hasClass(\"show\")){
												postModalClose();
											}
										}
									});	
									$(\"#upvote_id$id\").click(function(){
										if ($(\"#upvote_id$id\").css(\"background-color\") == \"rgb(255, 165, 0)\"){

											// If it has already been upvoted -- un-upvoting

											$(\"#upvote_id$id\").css({\"background-color\":\"grey\"});

											var id = $id
											if (\"$score\" == \"Vote\")
											{
												$( \"#score_$id\" ).html(\"$score\");
												var i = 0;
											}

											else {
												var i = $score;
												$( \"#score_$id\" ).html(i);
											}
											var score = i;
											$.ajax({
												type: 'GET',
												url: 'upvote.php',
												data: { post_id: id, post_score: score },
												success: function(response) {
													console.log('');
												}
											});
											return;
											alert('DIDNT WORK');
										}
										else{
											if ($(\"#downvote_id$id\").css(\"background-color\") == \"rgb(0, 0, 255)\"){

												// If it has been downvoted, un-downvote and then upvote

												$(\"#downvote_id$id\").css({\"background-color\":\"grey\"});

												$(\"#upvote_id$id\").css({\"background-color\":\"orange\"});
											}
											else {

												$(\"#upvote_id$id\").css({\"background-color\":\"orange\"});

											}
											var id = $id;
											if (\"$score\" == \"Vote\")
											{
												var i = 0;
												$( \"#score_$id\" ).html(i+1);
											}

											else {
												var i = $score;
												$( \"#score_$id\" ).html(i+1);
											}
											var score = i+1;
											$(\"#score_$id\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											$.ajax({
												type: 'GET',
												url: 'upvote.php',
												data: { post_id: id, post_score: score },
												success: function(response) {
													console.log('');
												}
											});
										};
									});
									$(\"#downvote_id$id\").click(function(){
										if ($(\"#downvote_id$id\").css(\"background-color\") == \"rgb(0, 0, 255)\"){

											// If it has been downvoted -- un-downvote it

											$(\"#downvote_id$id\").css({\"background-color\":\"grey\"});

											var id = $id
											if (\"$score\" == \"Vote\")
											{
												$( \"#score_$id\" ).html(\"$score\");
												var i = 0;
											}

											else {
												var i = $score;
												$( \"#score_$id\" ).html(i);
											}
											var score = i;
											$.ajax({
												type: 'GET',
												url: 'upvote.php',
												data: { post_id: id, post_score: score },
												success: function(response) {
													console.log('');
												}
											});
											return;
											alert('DIDNT WORK');
										}
										else{
											if ($(\"#upvote_id$id\").css(\"background-color\") == \"rgb(255, 165, 0)\"){

												$(\"#upvote_id$id\").css({\"background-color\":\"grey\"});

												$(\"#downvote_id$id\").css({\"background-color\":\"blue\"});
											}
											else {

												$(\"#downvote_id$id\").css({\"background-color\":\"blue\"});

											}
											var id = $id
											if (\"$score\" == \"Vote\")
											{
												var i = 0;
												$( \"#score_$id\" ).html(i-1);
											}

											else {
												var i = $score;
												$( \"#score_$id\" ).html(i-1);
											}
											var score = i-1;

											$(\"#score_$id\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											$.ajax({
												type: 'GET',
												url: 'upvote.php',
												data: { post_id: id, post_score: score },
												success: function(response) {
													console.log('');
												}
											});
										};
									});
								</script>	
								";
									
								}
							}
						}
					
					
					}
				
				$conn->close();
				?>
	</div>
</div>
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

					$sql = "SELECT * FROM comments ORDER BY comment_score DESC";

					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						// output data of each row
						while($row = $result->fetch_assoc()) {
					
							$idCOM = $row["id"];
							$scoreCOM = $row["comment_score"];
							$postCOM = $row["comment_contents"];
							$timeCOM = $row["comment_time"];
							$account_idCOM = $row["account_id"];
							$post_idCOM = $row["post_id"];
							if ($scoreCOM == 0) {
								$scoreCOM = "Vote";
							}
							$sqlCOM = "SELECT * FROM accounts WHERE id = $account_idCOM";

							$resultCOM = $conn->query($sqlCOM);

							if ($resultCOM->num_rows > 0) {
								// output data of each row
								while($rowCOM = $resultCOM->fetch_assoc()) {
									
									$userCOM = $rowCOM["username"];
									$pfpCOM = $rowCOM["profile_picture"];
									$fnCOM = $rowCOM["first_name"];
									$lnCOM = $rowCOM["last_name"];
									
									echo"
									<script id = \"display_comments\">
										$(document).ready(function(){
											alert(\"ready\");
											var comment = `<div class = \"content\" style = \"margin-top: -10px;\">
													<img class = \"pfp\" width = \"50\" height = \"50\" src=\"$pfpCOM\" alt=\"$userCOM's pfp\" style = \"float:left;margin-top:20px;\">
													<div>
														<a class=\"name_and_date\">

															<spam class=\"name\">

																<h3 class=\"first_last_name\">$fnCOM $lnCOM</h3>
																<p class = \"username\">@$userCOM</p>
															</spam>
														</a>
														<p class = \"contents\">$postCOM</p>
													</div>
												</div>`;
											var comments = $(\"#comments_$post_idCOM\").html();
											$(\"#comments_$post_idCOM\").html(comments + comment);
										});
									</script>
									";

								}
							} else { echo mysqli_error($conn);}
						}
					} else { echo mysqli_error($conn);}
				$conn->close();
				?>
</body>
</html>