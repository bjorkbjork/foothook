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
<script src="https://kit.fontawesome.com/e427ee6de6.js"></script>
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
if(isset($_SESSION["last_post"])){
	$lastpost = $_SESSION["last_post"];
	echo 
	"<script>
		
		$(document).ready(function() {
			postModalOpen_$lastpost();
		});
		
	</script>";
	unset ($_SESSION["last_post"]);
}
	
$bool = false;
?>

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
			<a id = "home" class = "button" href = "index.php"><i class="fas fa-home" style = "font-size:22px;margin-right:5px;"></i>Home</a>
			<a id = "notifications" class = "button" href = "index.php"><i class="far fa-bell" style = "font-size:22px;margin-right:5px;"></i>Notifications</a>
			<a id = "messages" class = "button" href = "index.php"><i class="far fa-envelope" style = "font-size:22px;margin-right:5px;"></i>Messages</a>
			<script>
				$(document).ready(function(){
					if($(location).attr("href") == "http://localhost/foothook/index.php"){
						$("#home").addClass("button_main");
					}
				});
			</script>
		</span>
		<span class = "right_buttons">
			<form action = "search.php" method = "GET">
				<div style = "display: flex; align-items: center; justify-content: space-around;">
					<input style = "border-top-right-radius: 0px; border-bottom-right-radius: 0px; height: 20px;" type = "text" pleaceholder = "Search..." name = "search">
					<button class = "search" type = "submit"><i style = "margin-top:3px;" class="fas fa-search"></i></button>
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
								<img id = \"navPFP\" style = \"margin-top: 2px;margin-left:20px; margin-right: 20px;\" class = \"pfp\" width = \"30\" height = \"30\" src=\"$pfpNAV\" alt=\"$userNAV's pfp\" onClick = \"dropDown()\">
								<div id = \"dropdown\" class = \"dropdown-content\">	
									<div id = \"names\" style = \"border-bottom: thin solid #BDBDBD;\">
										<h2 class = \"dropdown-contenth2\">$fnNAV&nbsp;$lnNAV</h2>
										<p style = \"color:grey;margin-top:-20px; margin-left: 16px;\">@$userNAV</p>
									</div>
									<div id = \"settings\" style = \"border-bottom: thin solid #BDBDBD;\">
										<a id = \"a1\" class = \"dropdown-contenta\" href = \"settings.php\">Accout Settings</a>
										<form id = \"dark_mode_form\" action = \"nightmode.php\" method = \"POST\" style = \"padding: 10px; display:flex;justify-content:flex-start;align-content:center\">
											<label style = \"\" class = \"switch\">
												<input onChange=\"this.form.submit()\" type = \"checkbox\" name = \"darkmode\" value = \"checked\">
												<span class = \"slider round\"></span>
											</label>
											<p class = \"dropdown-contentp\" style = \"margin:0;padding:0; margin-left:5px;margin-top:5px;\">Night mode</p>
										</form>
									</div>
									
									<a id = \"a2\" class = \"dropdown-contenta\" href = \"logout.php\">Log out @$userNAV</a>
									<a id = \"a3\" class = \"dropdown-contenta\" href = \"reset-password.php\">Reset password @$userNAV</a>
									
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
				
				$dark_mode = $row["dark_mode"];
				
				if ($dark_mode == 1){
					
					echo "
					<script>
						$(document).ready(function(){
							$('html, body').css({\"background-color\":\"#000\"});
							$(\".navbar\").css({\"background-color\":\"#1A1A1B\"});
							$(\".post\").css({\"background-color\":\"#1A1A1B\", \"border-color\":\"#1d1d1e\", \"border-top-color\":\"#1d1d1e\", \"border-bottom-color\":\"#1d1d1e\"});
							$(\".logo\").attr(\"src\",\"logo(DARK).png\");
							$(\".modal-content\").css({\"background-color\":\"#1A1A1B\", \"border-color\":\"#1d1d1e\", \"border-top-color\":\"#1d1d1e\", \"border-bottom-color\":\"#1d1d1e\"});
							$(\".lower_half\").css({\"background-color\":\"#333333\"});
							$(\".contents\").css({\"color\":\"#d7dadc\"});
							$(\".first_last_name\").css({\"color\":\"#d7dadc\"});
							$(\".username\").css({\"color\":\"#777\"});
							$(\".date_time\").css({\"color\":\"#777\"});
							$(\".score\").css({\"color\":\"#d7dadc\"});
							$(\".username_modal\").css({\"color\":\"#777\"});
							$(\"#dropdown\").css({\"background-color\":\"#1A1A1B\"});
							$('input[type=text]').css({\"background-color\":\"#444\", \"border-color\":\"#4e4e4e\"});
							$(\".content-comment\").css({\"border-color\":\"#1d1d1e\"});
							$(\".cmt_head\").css({\"border-color\":\"#222\", \"color\":\"#d7dadc\"});
							$('body').css({\"color\":\"#d7dadc\"});
							$(\"#dropdown\").css({\"color\":\"#d7dadc\"});
							\".dropdown-contenta\"
							$(\".dropdown-contenta\").css({\"color\":\"#d7dadc\"});
							$(\".dropdown-contenth2\").css({\"color\":\"#d7dadc\"});
							$(\".dropdown-contentp\").css({\"color\":\"#d7dadc\"});
							$(\".close\").css({\"color\":\"#d7dadc\"});
							$(\"#names\").css({\"border-color\":\"#1d1d1e\", \"border-width\":\"medium\"});
							$(\"#settings\").css({\"border-color\":\"#1d1d1e\", \"border-width\":\"medium\"});
							
							$(\"#dark_mode_form\").html(`
								<form id = \"dark_mode_form\" action = \"nightmode.php\" method = \"POST\" style = \"padding: 10px; display:flex;justify-content:flex-start;align-content:center\">
									<label style = \"\" class = \"switch\">
										<input onChange=\"this.form.submit()\" type = \"checkbox\" name = \"darkmode\" value = \"checked\" checked>
										<span class = \"slid round\"></span>
									</label>
									<p style = \"margin:0;padding:0; margin-left:5px;margin-top:5px;\">Night mode</p>
								</form>
							`);
						});	
						$(\"#close\").mouseover(function(){
							$(\"#close\").css({\"color\":\"red\"});
						});
						$(\"#close\").mouseout(function(){
							$(\"#close\").css({\"color\":\"#d7dadc\"});
						});
						$(\"#a1\").mouseover(function(){
							$(\"#a1\").css({\"background-color\":\"#222\"});
						});
						$(\"#a1\").mouseout(function(){
							$(\"#a1\").css({\"background-color\":\"#1a1a1b\"});
						});
						$(\"#a2\").mouseover(function(){
							$(\"#a2\").css({\"background-color\":\"#222\"});
						});
						$(\"#a2\").mouseout(function(){
							$(\"#a2\").css({\"background-color\":\"#1a1a1b\"});
						});
						$(\"#a3\").mouseover(function(){
							$(\"#a3\").css({\"background-color\":\"#222\"});
						});
						$(\"#a3\").mouseout(function(){
							$(\"#a3\").css({\"background-color\":\"#1a1a1b\"});
						});
					</script>
					";
				}

				echo"
					<div id = \"createPost\" class = \"modal\">
						<!-- Modal Content -->
						<form class = \"modal-content animate\" action = \"post.php\" method = \"post\">
							<span class = \"cmt_head\">
								<h2 class = \"cmt_header\">Compose new Post</h2>
								<span id = \"close\" onclick=\"document.getElementById('createPost').classList.remove('show')\" 
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
					$noc = $row["number_of_comments"];
					
					$sessUSER = $_SESSION["username"];
					$sessID = $_SESSION["id"];
					
					if ($sessID == $account_id){
						echo"
						<script type = \"\" id = \"gay\">
							$(document).ready(function(){
								$(\"#post_settings_$id\").click(function(){
									alert('worked');
									
									var dropdown = `
										<div class = \"dropdown\">

											<i id = \"elipses_$id\" onClick = \"dropDown_$id()\" style = \"color:#777\" class=\"fas fa-ellipsis-v\"></i>
											<div id = \"dropdown_$id\" class = \"dropdown-content\">	
												<div id = \"names\" style = \"border-bottom: thin solid #BDBDBD;\">
													<h2 class = \"dropdown-contenth2\">$fnNAV&nbsp;$lnNAV</h2>
													<p style = \"color:grey;margin-top:-20px; margin-left: 16px;\">@$userNAV</p>
												</div>
												<div id = \"settings\" style = \"border-bottom: thin solid #BDBDBD;\">
													<a id = \"a1\" class = \"dropdown-contenta\" href = \"settings.php\">Accout Settings</a>
													<form id = \"dark_mode_form\" action = \"nightmode.php\" method = \"POST\" style = \"padding: 10px; display:flex;justify-content:flex-start;align-content:center\">
														<label style = \"\" class = \"switch\">
															<input onChange=\"this.form.submit()\" type = \"checkbox\" name = \"darkmode\" value = \"checked\">
															<span class = \"slider round\"></span>
														</label>
														<p class = \"dropdown-contentp\" style = \"margin:0;padding:0; margin-left:5px;margin-top:5px;\">Night mode</p>
													</form>
												</div>

												<a id = \"a2\" class = \"dropdown-contenta\" href = \"logout.php\">Log out @$userNAV</a>
												<a id = \"a3\" class = \"dropdown-contenta\" href = \"reset-password.php\">Reset password @$userNAV</a>

											</div>
										</div>
									`;
									$(\"#post_settings_$id\").html(dropdown);
									
								});
							});						
						</script>
						";
						
					}
					
					if($noc > 0){
						echo "
						<script>
							$(document).ready(function(){
								var commentBTN = $(\"#commentBTN_$id\").html();
								var noc = '$noc';
								$(\"#commentBTN_$id\").html(commentBTN + noc);
							});
						</script>";	
					}
					
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
								
								$upvote = "upvote_id$id";
								$upvote_modal = "upvote_modal_id$id";
								
								$downvote = "downvote_id$id";
								$downvote_modal = "downvote_modal_id$id";
								
								$score_reg = "score_$id";
								$score_modal = "score_modal_$id";
								echo"
									<script>
									$( document ).ready(function() {
										if (\"$score\" == \"Vote\") {
											$(\"#$score_reg\").css({\"margin-left\":\"-8px\"});
										}
									});
									$( document ).ready(function() {
										if (\"$score\" == \"Vote\") {
											$(\"#$score_modal\").css({\"margin-left\":\"-8px\"});
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
								<script id = \"dropdown-settings\" type = \"text/javascript\">
	
									function dropDown() {
										document.getElementById(\"dropdown\").classList.toggle(\"show\");
									}
									
									function dropDown_$id() {
										document.getElementById(\"dropdown_$id\").classList.toggle(\"show\");
									}

								//	 Close the dropdown menu if the user clicks outside of it
									window.onclick = function(event) {
										console.log(event.target);
										if (!event.target.closest('#dropdown') && !event.target.closest('#navPFP')) {
											var dropdowns = document.getElementsByClassName(\"dropdown-content\");
											var i;
											for (i = 0; i < dropdowns.length; i++) {
												var openDropdown = dropdowns[i];
												if (openDropdown.classList.contains('show')) {
													openDropdown.classList.remove('show');
												}
											}
										}
										if (!event.target.matches('#dropdown_$id') && !event.target.matches('#elipses_$id')) {
											var dropdown = document.getElementById(\"#dropdowm_$id\");
											var c;
											if(dropdown != null){
												for (c = 0; c < dropdown.length; c++) {
													var openDropdowns = dropdown[c];
													if (openDropdowns.classList.contains('show')) {
														openDropdowns.classList.remove('show');
													}
												}
											}
										}
									}
								</script>
								<div id = \"post_modal_$id\" class = \"modal1\">
								
								<span onClick = \"postModalClose_$id()\" class=\"close1\" title=\"Close\">&times;</span>

											<!-- Modal Content -->
											<form class = \"modal-content animate\" action = \"comment.php\" method = \"post\">
											
												
												<div class = \"content\" style = \"margin-top: -10px;\">
													<div class = \"container\">
													<div class = \"upvote_downvote\" style=\"margin-left: -20px; margin-right: 20px; margin-top: -10px;\">
														<div id=\"upvote_modal_id$id\" class = \"upvote\">
														</div>
													<div id = \"score_modal_$id\" class = \"score\">
														<p>$score</p>
													</div>
													<div id = \"downvote_modal_id$id\" class = \"downvote\">
													</div>
												</div>
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
												<div id = \"lower_half_$id\" class = \"lower_half\">
													<div style = \"padding:16px\">
														<label style = \"text-align:left;\" for = \"reply\"><span style = \"display: inline-block\"> Replying to </span><span class = \"username_modal\">&nbsp;@$user</span></label>
														<input id = \"input_$id\" style = \"\" type = \"text\" placeholder = \"Type your reply\" name = \"reply\" required>
														<div id = \"div_lower_$id\">
															<input type=\"hidden\" name=\"post_id\" value=\"$id\">
															<button id = \"submit_modal_$id\" class = \"submit\" type = \"submit\"><b>Reply</b></button>
														</div>
													</div>
												</div>
												
												<div id = \"comments_$id\" class = \"comment\";>
												
												</div>
												
										  </div>
										</form>
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
									<div id = \"content_$id\" class = \"content\" style = \"margin-top: -10px;/* display: inline-block*/\">
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
										
										<div id = \"id$id\" class = \"modal\">

											<!-- Modal Content -->
											<form class = \"modal-content animate\" action = \"comment.php\" method = \"post\">
											<span class = \"cmt_head\">
												<h2 class = \"cmt_header\">Reply to $user</h2>
												<span id = \"#close\" onClick = \"endComment_$id()\" class=\"close\" title=\"Close Modal\">&times;</span>
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
														<label style = \"text-align:left;\" for = \"reply\"><span style = \"display: inline-block\"> Replying to </span><span class = \"username_modal\">&nbsp;@$user</span></label>
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
									<div id = \"post_settings_$id\" style=\"float:right; margin-right:-35px;margin-top:-67px;\">
										<i style = \"color:#777\" class=\"fas fa-ellipsis-v\"></i>
									</div>
									<div class = \"share_and_comment\">
											<span style = \"margin-left:26px;\" onClick = \"\" class = \"share\" id = \"shareBTN_$id\">
												<i class=\"fas fa-share\"></i>
											</span>
											<span onClick = \"startComment_$id()\" class = \"commentBTN\" id = \"commentBTN_$id\">
												<i class = \"far fa-comment-alt\"></i>
											</span>
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
									$(\"#$upvote\").click(function(){
									
										var upvote = true;
										
										if ($(\"#$upvote\").css(\"background-color\") == \"rgb(255, 165, 0)\" || $(\"#$upvote_modal\").css(\"background-color\") == \"rgb(255, 165, 0)\"){

											// If it has already been upvoted -- un-upvoting

											$(\"#$upvote\").css({\"background-color\":\"grey\"});
											$(\"#$upvote_modal\").css({\"background-color\":\"grey\"});

											var id = $id
											var account_id = $sessID;
											var cur_score = $( \"#$score_reg\" ).html().replace(/(<([^>]+)>)/ig,\"\");
											
											if ($.isNumeric(cur_score) == false)
											{
												var i = 0;
												var is_vote = true;
											}
											else {
												var i = parseInt(cur_score);
											}
											
											var score = i-1;
											
											$( \"#$score_reg\" ).html(score);
											$( \"#$score_modal\" ).html(score);
											
											var unupvote = true;
											
											if (is_vote == true){
												$(\"#$score_reg\").css({\"margin-left\":\"0px\"});
												$(\"#$score_modal\").css({\"margin-left\":\"0px\"});
											}
											
											var undownvote = false;
											
											$.ajax({
												type: 'GET',
												url: 'upvote.php',
												data: { upvote: upvote, undownvote: undownvote, unupvote: unupvote, post_id: id, post_score: score, account_id: account_id },
												success: function(response) {
													console.log('');
												}
											});
											return;
											alert('DIDNT WORK');
										}
										else{
											if ($(\"#$downvote\").css(\"background-color\") == \"rgb(0, 0, 255)\" || $(\"#$downvote_modal\").css(\"background-color\") == \"rgb(0, 0, 255)\"){

												// If it has been downvoted, un-downvote and then upvote

												$(\"#$downvote\").css({\"background-color\":\"grey\"});

												$(\"#$upvote\").css({\"background-color\":\"orange\"});
												
												$(\"#$downvote_modal\").css({\"background-color\":\"grey\"});

												$(\"#$upvote_modal\").css({\"background-color\":\"orange\"});
												
												var x = 1;
											}
											else {

												$(\"#$upvote\").css({\"background-color\":\"orange\"});
												$(\"#$upvote_modal\").css({\"background-color\":\"orange\"});

											}
											var id = $id;
											var account_id = $sessID;
											var cur_score = $( \"#$score_reg\" ).html().replace(/(<([^>]+)>)/ig,\"\");
											if ($.isNumeric(cur_score) == false)
											{
												var i = 0;
												var is_vote = true;
											}
											else {
												var i = parseInt(cur_score);
											}
											
											if (x != null){
												i = i+x;
											}
											
											var score = i+1;
											
											$( \"#$score_reg\" ).html(score);
											$( \"#$score_modal\" ).html(score);
											
											if (is_vote == true){
												$(\"#$score_reg\").css({\"margin-left\":\"0px\"});
												$(\"#$score_modal\").css({\"margin-left\":\"0px\"});
											}
											
											$(\"#$score_reg\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											$(\"#$score_modal\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											
											var unupvote = false;
											var undownvote = false;
											
											$.ajax({
												type: 'GET',
												url: 'upvote.php',
												data: { upvote: upvote, undownvote: undownvote, unupvote: unupvote, post_id: id, post_score: score, account_id: account_id },
												success: function(response) {
													console.log('');
												}
											});
										};
									});
									$(\"#$downvote\").click(function(){
									
										var upvote = false;
									
										if ($(\"#$downvote\").css(\"background-color\") == \"rgb(0, 0, 255)\" || $(\"#$downvote_modal\").css(\"background-color\") == \"rgb(0, 0, 255)\"){

											// If it has been downvoted -- un-downvote it

											$(\"#$downvote\").css({\"background-color\":\"grey\"});
											$(\"#$downvote_modal\").css({\"background-color\":\"grey\"});
											
											var cur_score = $( \"#$score_reg\" ).html().replace(/(<([^>]+)>)/ig,\"\");
											if ($.isNumeric(cur_score) == false)
											{
												var i = 0;
												var is_vote = true;
											}
											else {
												var i = parseInt(cur_score);
											}
											
											var score = i+1;
											
											$( \"#$score_reg\" ).html(score);
											$( \"#$score_modal\" ).html(score);
											
											if (is_vote == true){
												$(\"#$score_reg\").css({\"margin-left\":\"0px\"});
												$(\"#$score_modal\").css({\"margin-left\":\"0px\"});
											}
											
											$(\"#$score_reg\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											$(\"#$score_modal\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											
											var unupvote = false;
											var undownvote = true;
											
											$.ajax({
												type: 'GET',
												url: 'upvote.php',
												data: { unupvote: unupvote, post_id: id, post_score: score, account_id: account_id },
												success: function(response) {
													console.log('');
												}
											});
											return;
											alert('DIDNT WORK');
										}
										else{
											if ($(\"#$upvote\").css(\"background-color\") == \"rgb(255, 165, 0)\" || $(\"#upvote_modal_id$id\").css(\"background-color\") == \"rgb(255, 165, 0)\"){

												$(\"#$upvote\").css({\"background-color\":\"grey\"});

												$(\"#$downvote\").css({\"background-color\":\"blue\"});
												
												$(\"#$upvote_modal\").css({\"background-color\":\"grey\"});

												$(\"#$downvote_modal\").css({\"background-color\":\"blue\"});
												
												var x = 1
												
											}
											else {

												$(\"#$downvote\").css({\"background-color\":\"blue\"});
												$(\"#$downvote_modal\").css({\"background-color\":\"blue\"});

											}
											
											var id = $id
											var account_id = $sessID;
											var cur_score = $( \"#$score_reg\" ).html().replace(/(<([^>]+)>)/ig,\"\");
											
											if ($.isNumeric(cur_score) == false)
											{
												var i = 0;
												var is_vote = true;
											}
											else {
												var i = parseInt(cur_score);
											}
											
											if (is_vote == true){
												$(\"#$score_reg\").css({\"margin-left\":\"0px\"});
												$(\"#$score_modal\").css({\"margin-left\":\"0px\"});
											}
											
											if (x != null){
												i = i-x;
											}
											
											var score = i-1;
											
											$( \"#$score_reg\" ).html(score);
											$( \"#$score_modal\" ).html(score);

											$(\"#$score_reg\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											$(\"#$score_modal\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											
											var unupvote = false;
											var undownvote = false;
											
											$.ajax({
												type: 'GET',
												url: 'upvote.php',
												data: { upvote: upvote, undownvote: undownvote, unupvote: unupvote, post_id: id, post_score: score, account_id: account_id },
												success: function(response) {
													console.log('');
												}
											});
										};
									});
									$(\"#$upvote_modal\").click(function(){
										if ($(\"#$upvote\").css(\"background-color\") == \"rgb(255, 165, 0)\" || $(\"#$upvote_modal\").css(\"background-color\") == \"rgb(255, 165, 0)\"){

											// If it has already been upvoted -- un-upvoting

											$(\"#$upvote\").css({\"background-color\":\"grey\"});
											$(\"#$upvote_modal\").css({\"background-color\":\"grey\"});

											var id = $id
											if (\"$score\" == \"Vote\")
											{
												$( \"#$score_reg\" ).html(\"$score\");
												$( \"#$score_modal\" ).html(\"$score\");
												var i = 0;
											}

											else {
												var i = $score;
												$( \"#$score_reg\" ).html(i);
												$( \"#$score_modal\" ).html(i);
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
											if ($(\"#$downvote\").css(\"background-color\") == \"rgb(0, 0, 255)\" || $(\"#$downvote_modal\").css(\"background-color\") == \"rgb(0, 0, 255)\"){

												// If it has been downvoted, un-downvote and then upvote

												$(\"#$downvote\").css({\"background-color\":\"grey\"});

												$(\"#$upvote\").css({\"background-color\":\"orange\"});
												
												$(\"#$downvote_modal\").css({\"background-color\":\"grey\"});

												$(\"#$upvote_modal\").css({\"background-color\":\"orange\"});
											}
											else {

												$(\"#$upvote\").css({\"background-color\":\"orange\"});
												$(\"#$upvote_modal\").css({\"background-color\":\"orange\"});

											}
											var id = $id;
											if (\"$score\" == \"Vote\")
											{
												var i = 0;
												$( \"#$score_reg\" ).html(i+1);
												$( \"#$score_modal\" ).html(i+1);
											}

											else {
												var i = $score;
												$( \"#$score_reg\" ).html(i+1);
												$( \"#$score_modal\" ).html(i+1);
											}
											var score = i+1;
											$(\"#$score_reg\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											$(\"#$score_modal\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
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
									$(\"#$downvote_modal\").click(function(){
										if ($(\"#$downvote\").css(\"background-color\") == \"rgb(0, 0, 255)\" || $(\"#$downvote_modal\").css(\"background-color\") == \"rgb(0, 0, 255)\"){

											// If it has been downvoted -- un-downvote it

											$(\"#$downvote\").css({\"background-color\":\"grey\"});
											$(\"#$downvote_modal\").css({\"background-color\":\"grey\"});

											var id = $id
											if (\"$score\" == \"Vote\")
											{
												$( \"#$score_reg\" ).html(\"$score\");
												$( \"#$score_modal\" ).html(\"$score\");
												var i = 0;
											}

											else {
												var i = $score;
												$( \"#$score_reg\" ).html(i);
												$( \"#$score_modal\" ).html(i);
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
											if ($(\"#$upvote\").css(\"background-color\") == \"rgb(255, 165, 0)\" || $(\"#$upvote_modal\").css(\"background-color\") == \"rgb(255, 165, 0)\"){

												$(\"#$upvote\").css({\"background-color\":\"grey\"});

												$(\"#$downvote\").css({\"background-color\":\"blue\"});
												
												$(\"#$upvote_modal\").css({\"background-color\":\"grey\"});

												$(\"#$downvote_modal\").css({\"background-color\":\"blue\"});
											}
											else {

												$(\"#$downvote\").css({\"background-color\":\"blue\"});
												$(\"#$downvote_modal\").css({\"background-color\":\"blue\"});

											}
											var id = $id
											if (\"$score\" == \"Vote\")
											{
												var i = 0;
												$( \"#$score_reg\" ).html(i-1);
												$( \"#$score_modal\" ).html(i-1);
											}

											else {
												var i = $score;
												$( \"#$score_reg\" ).html(i-1);
												$( \"#$score_modal\" ).html(i-1);
											}
											var score = i-1;

											$(\"#$score_reg\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
											$(\"#$score_modal\").css({\"padding-top\":\"16px\", \"padding-bottom\":\"16px\"});
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
											var comment = `<div class = \"content-comment\">
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
											$(\"#lower_half_$post_idCOM\").css({\"border-bottom-right-radius\": \"0px\", \"border-bottom-left-radius\": \"0px\"});
											$(\"#input_$post_idCOM\").css({\"width\":\"89%\", \"display\":\"inline-block\"});
											$(\"#submit_modal_$post_idCOM\").css({\"margin-top\":\"10spx\"});
											$(\"#div_lower_$post_idCOM\").css({\"display\":\"inline\"});
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