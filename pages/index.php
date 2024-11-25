<?php
	header("Content-Type: text/html; charset=UTF-8");
	include($_SERVER['DOCUMENT_ROOT'] . "/programs/ShopMate/globals.php");
?>

<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Shop Mate</title>
    <link rel="stylesheet" href="/programs/ShopMate/style.css">

    <!-- SCRITPS -->
    <script src="/programs/ShopMate/request.js"></script>
    <script src="/programs/ShopMate/util.js"></script>
    <script src="/programs/ShopMate/resources/spending_entry.js"></script>
    <script src="/programs/ShopMate/resources/spending_tracker.js"></script>
    <script src="/programs/ShopMate/resources/user.js"></script>
    <script src="/programs/ShopMate/resources/invite.js"></script>

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
	<?php
		if(isset($_GET["endpoint"])) {
			echo "<script>console.log('{$_GET['endpoint']}');</script>";
			$endpointFile = substr($_GET["endpoint"], strrpos($_GET["endpoint"], "/")+1);
			echo "<script>console.log('{$endpointFile}');</script>";
			if($REQUIRES_AUTH[$endpointFile]) {
				if(isset($_SESSION['AUTH'])) {
					// echo "Needs Auth, we have Auth!";
					include($_SERVER['DOCUMENT_ROOT'] . $_GET["endpoint"]);
				}else {
					// echo "Needs Auth!";
					include($_SERVER['DOCUMENT_ROOT'] . $_GET["endpoint"]);
				}
			}else {
				// echo "No Auth Needed!";
				include($_SERVER['DOCUMENT_ROOT'] . $_GET["endpoint"]);
			}
			
		}else {
			include($_SERVER['DOCUMENT_ROOT'] . "/programs/ShopMate/pages/home.php");
		}
	?>
	<div class="request-content"></div>
</body>
</html>