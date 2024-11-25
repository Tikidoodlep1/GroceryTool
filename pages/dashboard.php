<?php
	include($_SERVER['DOCUMENT_ROOT']."/programs/ShopMate/pages/spending_entry_log.php");
	include($_SERVER['DOCUMENT_ROOT']."/programs/ShopMate/pages/create_spending_tracker.html")
?>

<?php include($_SERVER['DOCUMENT_ROOT']."/programs/ShopMate/pages/header.php"); ?>
<main>
	<div class="body-wrapper">
		<section id="invites">
			<h2>Invites</h2>
			<div class="invite-table-wrapper">
				<!-- <?php
					// //If the user has invites:
					// $invites = [];
					// //temp invite data to display *something*
					// $fakeInvite1 = array("username"=>"Jimmothy Buckets", "spending_tracker_name"=>"Hyvee Spendings");
					// $fakeInvite2 = array("username"=>"Jack McGee", "spending_tracker_name"=>"Movie Rentals");
					// $fakeInvite3 = array("username"=>"John McGee", "spending_tracker_name"=>"Movie Theater");
					// $fakeInvite4 = array("username"=>"Robin McCree", "spending_tracker_name"=>"Walmart");
					// $fakeInvite5 = array("username"=>"Sally Buckets", "spending_tracker_name"=>"Kohls");
					// $fakeInvite6 = array("username"=>"George Buckets", "spending_tracker_name"=>"Casey's Gas");
					// $invites[] = $fakeInvite1;
					// $invites[] = $fakeInvite2;
					// $invites[] = $fakeInvite3;
					// $invites[] = $fakeInvite4;
					// $invites[] = $fakeInvite5;
					// $invites[] = $fakeInvite6;
					// $table = "";
					// if(count($invites) > 0) {
					// 	include($_SERVER['DOCUMENT_ROOT']."/programs/ShopMate/pages/dashboard_invites.php");
					// }else {
					// 	$table .= "<p class='user-notification'>All caught up!</p>";
					// }
					// echo $table;
				?> -->
				<?php include($_SERVER['DOCUMENT_ROOT']."/programs/ShopMate/pages/dashboard_invites.html") ?>
			</div>
		</section>
		<section id="resource-cards">
			<?php include($_SERVER['DOCUMENT_ROOT']."/programs/ShopMate/pages/dashboard_resource_cards.html"); ?>
		</section>
	</div>
</main>

<style>
	#invites {
		margin-bottom: 5em;
	}

	#resource-cards button {
		background-color: var(--button);
		color: white;

		border-radius: 8px;
		border: 1px solid var(--heading-sub);
		transition: background-color 0.5s;
		font-size: 18pt;
		font-family: "Poppins", sans-serif;

		margin: 0.5em 0.5em 0.5em 0.5em;
		padding: 0.5em;

		cursor: pointer;
	}

	#resource-cards button:hover, 
	#resource-cards button:focus {
		background-color: var(--button-hover);
	}

	#resource-cards button:active {
		background-color: var(--text);
	}

	@media(max-aspect-ratio: 1/1) {

		#resource-cards button {
			margin: 1em;
			padding: 2% 5%;
			font-size: 1.5em;
		}
	}
</style>