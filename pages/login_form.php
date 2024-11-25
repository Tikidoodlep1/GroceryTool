<form id="login" action="dashboard.php" method="get" autocomplete="on" target="_self">
	<h3 class="center">Login</h3>

	<label for="login-email">Email</label>
	<input class="textinput" type="email" name="login-email" id="login-email" required autocomplete="email">

	<label for="login-password">Password</label>
	<input class="textinput" type="password" name="login-password" id="login-password" required>

	<button type="button" id="login-confirm">Login</button>
</form>

<script>
	var eel = document.querySelector("#login-email");
	var pel = document.querySelector("#login-password");
	var loginButton = document.querySelector("#login-confirm");

	var checkFields = function(e) {
		if(e.target.value) {
			document.querySelector("label[for=" + e.target.id + "]").classList.add("contains-text");
			if(!e.target.checkValidity()) {
				e.target.classList.add("field-error");
			}
		}else {
			document.querySelector("label[for=" + e.target.id + "]").classList.remove("contains-text");
			if(e.target.classList.contains("field-error")) {
				e.target.classList.remove("field-error");
			}
		}
	}

	eel.addEventListener("blur", function(e) {checkFields(e);});

	loginButton.addEventListener("click", function(e) {
		if(window.isSecureContext) {
			var eel = document.querySelector("#login-email");
			var pel = document.querySelector("#login-password");
			var loginButton = document.querySelector("#login-confirm");
			postContent("/programs/ShopMate/api/routing/routing_global.php", {request: "users/login", email: eel.value, password: pel.value}, "/programs/ShopMate/pages/dashboard.php").then(
				(users) => {
					if(users.length > 0) {
						console.log(users[0].ToJson);
						sessionStorage.setItem("user", users[0].ToJson);
					}else {
						console.error("Users returned from login request was length 0. Unable to load user into memory.");
					}
				});
		}else {
			alert("Connection is not secured, please ensure you're running a secure connection and try again.");
		}
	});
</script>

<style>
	#login {
		background-color: var(--banner-bg);

		display: flex;
		flex-direction: column;
		flex-wrap: nowrap;
		justify-content: flex-start;

		padding: 5%;
		border-radius: 16px;
		margin: 5% 10%;
	}

	#login input {
		background-color: white;
		border: 2px solid var(--text);
		border-radius: 8px;
		transition: border 0.2s;
		font-size: 1.1rem;
		text-indent: 2%;
		margin-bottom: 5%;
		line-height: 3rem;
	}

	#login input:focus {
		border: 4px solid var(--button);
	}

	#login label {
		font-size: 1rem;
		color: var(--heading-sub);
		pointer-events: none;
		transform: translateY(1.6rem);
		text-align: left;
		padding: 0% 2%;
		transition: transform 0.2s ease, font-size 0.2s ease;
		line-height: 0px;
	}

	#login .contains-text {
		font-size: 0.8rem;
		transform: translateY(0.8rem);
	}

	#login label:has(+input:focus),
	#login label:has(+input:valid) {
		font-size: 0.8rem;
		transform: translateY(0.8rem);
	}

	#login button {
		background-color: var(--button);
		color: white;
		margin: 0% 20%;
		padding: 2% 0%;
		border-radius: 8px;
		border: 2px solid var(--heading-sub);
		transition: background-color 0.5s;
		font-size: 1rem;
		font-weight: 200;
		font-family: "Poppins", sans-serif;
	}

	#login button:hover {
		background-color: var(--button-hover);
	}

	#login .field-error {
		border: 2px solid var(--input-error);
	}
</style>