<form id="signup" action="dashboard.php" method="post" autocomplete="on" target="_self">
	<h3 class="center">Signup</h3>

	<label for="signup-email">Email</label>
	<input class="textinput" type="email" name="signup-email" id="signup-email" required autocomplete="email">

	<label for="signup-username">Username</label>
	<input class="textinput" type="text" name="signup-username" id="signup-username" required>

	<label for="signup-password">Password</label>
	<input class="textinput" type="password" name="signup-password" id="signup-password" required>

	<button type="button" id="signup-confirm">Signup</button>
</form>

<script>
	var eel = document.querySelector("#signup-email");
	var uel = document.querySelector("#signup-username");
	var pel = document.querySelector("#signup-password");
	var signupButton = document.querySelector("#signup-confirm");

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
	uel.addEventListener("blur", function(e) {checkFields(e);});
	pel.addEventListener("blur", function(e) {checkFields(e);});

	signupButton.addEventListener("click", function(e) {
		if(window.isSecureContext) {
			var eel = document.querySelector("#signup-email");
			var uel = document.querySelector("#signup-username");
			var pel = document.querySelector("#signup-password");
			postContent("/programs/ShopMate/api/routing/routing_global.php", {request: "users/register/" + crypto.randomUUID(), username: uel.value, email: eel.value, password: pel.value}, "/programs/ShopMate/pages/dashboard.php").then(
				(users) => {
					if(users.length > 0) {
						console.log(users[0].ToJson);
						sessionStorage.setItem("user", users[0].ToJson);
					}else {
						console.error("Users returned from signup request was length 0. Unable to load user into memory.");
					}
				});
		}else {
			alert("Connection is not secured, please ensure you're running a secure connection and try again.");
		}
	});
</script>

<style>
	#signup {
		background-color: var(--banner-bg);

		display: flex;
		flex-direction: column;
		flex-wrap: nowrap;
		justify-content: flex-start;

		padding: 5%;
		border-radius: 16px;
		margin: 5% 10%;
	}

	#signup input {
		background-color: white;
		border: 2px solid var(--text);
		border-radius: 8px;
		transition: border 0.2s;
		font-size: 1.1rem;
		text-indent: 2%;
		margin-bottom: 5%;
		line-height: 3rem;
		transition: border 0.2s ease;
	}

	#signup input:focus {
		border: 4px solid var(--button);
	}

	#signup label {
		font-size: 1rem;
		color: var(--heading-sub);
		pointer-events: none;
		transform: translateY(1.6rem);
		text-align: left;
		padding: 0% 2%;
		transition: transform 0.2s ease, font-size 0.2s ease;
		line-height: 0px;
	}

	#signup .contains-text {
		font-size: 0.8rem;
		transform: translateY(0.8rem);
	}

	#signup label:has(+input:focus) {
		font-size: 0.8rem;
		transform: translateY(0.8rem);
	}

	#signup button {
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

	#signup button:hover {
		background-color: var(--button-hover);
	}

	#signup .field-error {
		border: 2px solid var(--input-error);
	}
</style>