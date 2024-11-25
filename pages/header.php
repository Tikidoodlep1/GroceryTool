<header>
	<nav>
		<div class="banner">
			<h4><p class="header-plink" href="/programs/ShopMate/pages/index.php?endpoint=/programs/ShopMate/pages/home.php">Shop Mate</p></h4>
			<ul>
				<li><p class="header-plink" href="/programs/ShopMate/pages/index.php?endpoint=/programs/ShopMate/pages/spending_tracker.php">Spending&nbsp;Tracker</p></li>
				<li><span class="spacearound"> | </span></li>
				<li><p class="header-plink" href="/programs/ShopMate/pages/index.php?endpoint=/programs/ShopMate/pages/home.php">Shopping&nbsp;List</p></li>
				<li><span class="spacearound"> | </span></li>
				<li><p class="header-plink" href="/programs/ShopMate/pages/index.php?endpoint=/programs/ShopMate/pages/login_signup.php">Login or Signup</p></li>
				<li><span class="spacearound"> | </span></li>
				<li><p class="header-plink" id="welcome-header-plink" href="/programs/ShopMate/pages/index.php?endpoint=/programs/ShopMate/pages/dashboard.php">Welcome</p></li>
			</ul>
		</div>
	</nav>
</header>

<script>
	const UserSessionObj = UserFromJson(JSON.parse(sessionStorage.getItem("user")));

	//events
	document.querySelectorAll(".header-plink").forEach((p) => {
		p.addEventListener('click', (e)=>{getContent(e.target.getAttribute("href"), true);})
	});

	//general
	console.log(sessionStorage);
	if(sessionStorage.getItem("user")) {
		document.querySelector("#welcome-header-plink").textContent = "Welcome, " + toTitleCase(UserSessionObj.getUsername);
	}
</script>

<style>
	.banner {
		height: auto;
		background: linear-gradient(var(--banner-bg) 85%, transparent);
		display: flex;
		justify-content: space-between;
		font-size: 1.6rem;
		padding: 0vw 2vw;
	}

	.banner ul {
		display: flex;
		justify-content: right;
		flex-wrap: wrap-reverse;
		list-style: none;
	}

	.banner p {
		margin: auto;
		padding: 0px;
		color: var(--link);
		transition: color 0.5s;
		cursor: pointer;
	}

	.banner p:hover {
		color: var(--link-hover);
	}

	.banner li {
		font-size: 1.6rem;
	}

	#title p {
		text-decoration: none;
		font-weight: 500;
	}

	@media(max-aspect-ratio: 3/5) {
		.banner {
			flex-direction: column;
			justify-content: center;
			padding-bottom: 2vh;
		}

		.banner ul {
			display: flex;
			justify-content: center;
			flex-wrap: wrap;
			list-style: none;
		}

		.banner li {
			text-align: center;
			font-size: 3rem;
		}
	}
</style>