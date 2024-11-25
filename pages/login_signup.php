<?php include("./header.php"); ?>
<main>
	<div class="body-wrapper">
		<section id="login-signup">
			<?php include("./login_form.php") ?>
			<h3>or</h3>
			<?php include("./signup_form.php") ?>
		</section>
	</div>
</main>

<style>
	#login-signup {
		display: flex;
		flex-direction: row;
		justify-content: center;
	}

	@media(max-aspect-ratio: 1/1) {
		#login-signup {
			display: flex;
			flex-direction: column;
			justify-content: center;
		}
	}
</style>