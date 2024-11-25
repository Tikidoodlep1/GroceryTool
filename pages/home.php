<?php include($_SERVER['DOCUMENT_ROOT']."/programs/ShopMate/pages/header.php"); ?>
<main>
	<div class="body-wrapper">
		<section id="purpose-statement">
			<img id="shop_mate_logo" src="/programs/ShopMate/images/ShopMateLogo.png" alt="Shop Mate Logo">
			<div>
				<h2>Split Your Spendings, All in One Place</h2>
				<h1>Shop Mate</h1>
			</div>
		</section>
		<section id="engagement">
			<a class="button" id="get-started" href="./index.php?endpoint=/programs/ShopMate/pages/login_signup.php">Get&nbsp;Started</a>
		</section>

		<a class="button" id="navigateGet">get</a>
		<a class="button" id="navigateTrackerGet">tracker get</a>
		<a class="button" id="navigatePost">post</a>
		<a class="button" id="navigatePut">put</a>
		<a class="button" id="navigateDelete">delete</a>
	</div>
</main>

<script>
	document.querySelector("#navigateGet").addEventListener('click', ()=>{getContent("/programs/ShopMate/api/routing/routing_global.php?request=users/view/24", false, "/programs/ShopMate/pages/dashboard.php");});
	document.querySelector("#navigateTrackerGet").addEventListener('click', ()=>{getContent("/programs/ShopMate/api/routing/routing_global.php?request=trackers/list/24", false, "/programs/ShopMate/pages/dashboard.php");});
	document.querySelector("#navigatePost").addEventListener('click', ()=>{postContent("/programs/ShopMate/api/routing/routing_global.php", {request: "users/register/25", username: "melina", email: "melina@yahoo.com", password: "melinalovescats#28"}, "/programs/ShopMate/pages/dashboard.php");});
	document.querySelector("#navigatePut").addEventListener('click', ()=>{putContent("/programs/ShopMate/api/routing/routing_global.php", {request: "users/update/24", username: "Lansseax", email: "lansseax@msn.yahoo.com"}, "/programs/ShopMate/pages/home.php");});
	document.querySelector("#navigateDelete").addEventListener('click', ()=>{deleteContent("/programs/ShopMate/api/routing/routing_global.php?request=users/delete/24&endpoint=/programs/ShopMate/pages/home.php");});
</script>

<style>
	/* PURPOSE STATEMENT */
	#purpose-statement {
		padding-top: 10vh;
		display: flex;
		flex-wrap: nowrap;
		justify-content: center;
		flex-direction: row;
	}

	@media(max-aspect-ratio: 3/5) {
		#purpose-statement {
			padding-top: 3vh;
			flex-wrap: wrap-reverse;
		}
	}

	#shop_mate_logo {
		height: 25vh;
	}

	/* ENGAGEMENT */
	#engagement {
		display: flex;
		justify-content: center;
		margin: 5% auto;
	}

	#engagement a {
		font-size: 2rem;
		padding: 0.8rem 1.2rem;
		transition: color 0.5s, background-color 1s;
		box-shadow: 1px 1px 3px var(--text);
	}

	#engagement a:hover {
		color: var(--link);
		background-color: var(--heading)
	}

	@media(max-aspect-ratio: 3/5) {
		#engagement a {
			font-size: 4rem;
		}
	}
</style>