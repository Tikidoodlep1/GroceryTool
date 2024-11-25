<?php
	// include("../api/controller/controller_global.php");
	//include("./spending_entry_log.php"); // Legacy Testing
	//include("./spending_user_log.php"); // Legacy Testing
	include("./create_spending_entry.html");
	include("./add_spending_user.html");

	if(isset($_POST["delete-spending-entry"])) {
		include("./delete_spending_entry.php");
	}
?>

<?php include("./header.php"); ?>
<main>
	<div class="body-wrapper">
		<section id="spending-log">
			<div id="spending-log-wrapper">
				<div>
					<h2 id="spending-tracker-name">Spending Tracker Name</h2>
					<div class="flex spending-container" id="entry-spending-container">
						
					</div>
					<div class="flex hidden spending-container" id="user-spending-container">
						
					</div>
				</div>
				<div id="spending-log-controls">
					<button id="user-view" name="user-view">View Users</button>
					<button id="create-spending-entry">Create Entry</button> <!-- swap this to Add User, swap Delete Entry to Remove User on user view -->
					<button id="delete-spending-entry">Delete Entry</button>
					<button class="hidden" id="add-spending-user">Add User</button>
					<!-- <button class="hidden" id="remove-spending-user">Remove User</button> -->
				</div>
			</div>
		</section>
	</div>
</main>

<script>
	var currentTracker = SpendingTrackerFromJson(JSON.parse(sessionStorage.getItem("currentTracker")));

	document.querySelector("#create-spending-entry").addEventListener("click", function(e) {
		document.querySelector("#create-spending-entry-dialog").showModal();
	});

	document.querySelector("#add-spending-user").addEventListener("click", function(e) {
		document.querySelector("#add-spending-user-dialog").showModal();
	});

	document.querySelector("#user-view").addEventListener("click", function(e) {

		document.querySelector("#user-spending-container").classList.toggle("hidden");
		document.querySelector("#entry-spending-container").classList.toggle("hidden");

		document.querySelector("#create-spending-entry").classList.toggle("hidden");
		document.querySelector("#delete-spending-entry").classList.toggle("hidden");
		document.querySelector("#add-spending-user").classList.toggle("hidden");
		//document.querySelector("#remove-spending-user").classList.toggle("hidden");

		if(document.querySelector("#user-spending-container").classList.contains("hidden")) {
			document.querySelector("#user-view").textContent = "View Users";
		}else {
			document.querySelector("#user-view").textContent = "View Entries";
		}
		
	});

	document.querySelector("#delete-spending-entry").addEventListener('click', async function(e) {
		var activeEntry = document.querySelector(".active-spending-entry");
		if(activeEntry == null) {
			return;
		}

		for(var entry of currentTracker.getEntries) {
			if(entry.getId === activeEntry.dataset.entryId) {
				activeEntry.remove();
				currentTracker.removeEntry(entry.getId);
				sessionStorage.setItem("currentTracker", currentTracker.ToJson);

				var update = await putContent("/programs/ShopMate/api/routing/routing_global.php", {request: "trackers/update/" + currentTracker.getId + "/entries", entry_id: entry.getId, amount: entry.getAmount, desc: entry.getDesc, soft_delete: entry.getDeleted}, "/programs/ShopMate/pages/spending_tracker.php"); //putContent(path, data, endpoint)

				break;
			}
		}
	});

	document.querySelector("#spending-tracker-name").textContent = currentTracker.getName

	getSpendingTrackerEntryView(currentTracker);
	getSpendingTrackerUserView(currentTracker);

	async function getSpendingTrackerUserView(tracker) {
		if(currentTracker.getUsers.length == 0) {
			var trackerUsersPromise = await getContent("/programs/ShopMate/api/routing/routing_global.php?request=users/view/trackers/" + currentTracker.getId, false);
			console.log(trackerUsersPromise)
			for(var user of trackerUsersPromise) {
				tracker.addUser(user);
			}
			sessionStorage.setItem("currentTracker", tracker.ToJson);
			currentTracker = tracker;
		}

		createSpendingTrackerUserView(tracker);
	}

	function createSpendingTrackerUserView(tracker) {

		var tableHeader = document.createElement("ul");
		tableHeader.id = "spending-user-header";

		var usernameHeader = document.createElement("li");
		usernameHeader.textContent = "Username";
		tableHeader.appendChild(usernameHeader);

		var totalSpentHeader = document.createElement("li");
		totalSpentHeader.textContent = "Total Spent";
		tableHeader.appendChild(totalSpentHeader);

		var tableParent = document.querySelector("#user-spending-container");
		tableParent.appendChild(tableHeader);

		var userSpending = getTotalSpentByUser(tracker);

		for(var i = 0; i < tracker.getUsers.length; i++) {
			var user = tracker.getUsers[i];

			var tableRow = document.createElement("ul");
			tableRow.classList.add("spending-user");
			tableRow.dataset.userId = user.getId;

			var usernameBody = document.createElement("li");
			usernameBody.textContent = user.getUsername;
			tableRow.appendChild(usernameBody);

			var totalSpentBody = document.createElement("li");
			totalSpentBody.textContent = userSpending[i];
			tableRow.appendChild(totalSpentBody);

			tableParent.appendChild(tableRow);
		}
	}

	function getTotalSpentByUser(tracker) {
		var totalSpent = [];
		for(var entry of tracker.getEntries) {
			var userIndex = -1;
			for(var i = 0; i < tracker.getUsers.length; i++) {
				var user = tracker.getUsers[i];
				if(entry.getUserId == user.getId) {
					userIndex =i;
					break;
				}
			}

			if(userIndex === -1) {
				continue;
			}

			if(totalSpent[userIndex] == undefined || totalSpent[userIndex] == null) {
				totalSpent[userIndex] = entry.getAmount;
			}else {
				totalSpent[userIndex] += entry.getAmount;
			}
		}
		return totalSpent;
	}

	async function getSpendingTrackerEntryView(tracker) {
		if(currentTracker.getEntries.length == 0) {
			var trackerEntriesPromise = await getContent("/programs/ShopMate/api/routing/routing_global.php?request=trackers/view/" + tracker.getId + "/entries", false);
			for(var entry of trackerEntriesPromise) {
				tracker.addEntry(entry);
			}
			sessionStorage.setItem("currentTracker", tracker.ToJson);
			currentTracker = tracker;
		}

		createSpendingTrackerEntryView(currentTracker);
	}

	function createSpendingTrackerEntryView(tracker) {

		var tableHeader = document.createElement("ul");
		tableHeader.id = "spending-entry-header";

		var dateHeader = document.createElement("li");
		dateHeader.appendChild(document.createTextNode("Date"));
		tableHeader.appendChild(dateHeader);

		var usernameHeader = document.createElement("li");
		usernameHeader.textContent = "Username";
		tableHeader.appendChild(usernameHeader);

		var descHeader = document.createElement("li");
		descHeader.textContent = "Description";
		tableHeader.appendChild(descHeader);

		var amountHeader = document.createElement("li");
		amountHeader.textContent = "Amount";
		tableHeader.appendChild(amountHeader);

		var tableParent = document.querySelector("#entry-spending-container");
		tableParent.appendChild(tableHeader);

		for(var entry of tracker.getEntries) {
			if(entry.getDeleted) {
				continue;
			}

			var tableRow = document.createElement("ul");
			tableRow.classList.add("spending-entry");
			tableRow.dataset.entryId = entry.getId;

			var dateBody = document.createElement("li");
			dateBody.textContent = entry.getDate;
			tableRow.appendChild(dateBody);

			var usernameBody = document.createElement("li");
			usernameBody.textContent = entry.getUserId;
			tableRow.appendChild(usernameBody);

			var descBody = document.createElement("li");
			descBody.textContent = entry.getDesc;
			tableRow.appendChild(descBody);

			var amountBody = document.createElement("li");
			amountBody.textContent = entry.getAmount;
			tableRow.appendChild(amountBody);

			tableParent.appendChild(tableRow);
		}

		tableParent.addEventListener('click', (e) => {
			if(e.target.classList.contains("spending-entry")) {
				for(var toggledEntry of document.querySelectorAll(".active-spending-entry")) {
					toggledEntry.classList.remove("active-spending-entry");
					if(toggledEntry == e.target) {
						return;
					}
				}
				e.target.classList.add("active-spending-entry");
			}
		});
	}
</script>

<style>
	#spending-log-wrapper {
		display: flex;
		flex-direction: column;
	}

	#spending-log-controls {
		display: flex;
		justify-content: center;
	}

	#spending-log-controls * {
		margin: 0.5em;
		padding: 0.5em;
	}

	.spending-container {
		width: 100%;
		margin: auto;
		
		font-size: 18pt;

		background-color: var(--table-head-bg);
		border-radius: 16px;

		flex-direction: column;
		flex-wrap: nowrap;
	}

	#spending-entry-header {
		display: grid;
		grid-template-columns: 17% 20% 45% 18%;

		font-weight: bold;

		color: var(--table-head-text);
		margin: 1em 0em;
	}

	#spending-user-header {
		display: grid;
		grid-template-columns: 60% 40%;

		font-weight: bold;

		color: var(--table-head-text);
		margin: 1em 0em;
	}

	.spending-entry {
		display: grid;
		grid-template-columns: 17% 20% 45% 18%;

		margin: 0%;
		padding: 0.2em 0.1em;

		transition: background-color 0.3s ease, color 0.3s ease;
	}

	.spending-entry li {
		pointer-events: none;
	}

	.spending-user {
		display: grid;
		grid-template-columns: 60% 40%;

		margin: 0%;
		padding: 0.2em 0.1em;
	}

	.spending-container .spending-entry:nth-child(odd), .spending-container .spending-user:nth-child(odd) {
		background-color: var(--table-row-bg);
	}

	.spending-container .spending-entry:nth-child(even), .spending-container .spending-user:nth-child(even) {
		background-color: var(--table-row-alt-bg);
	}

	.spending-container .spending-entry:last-child, .spending-container .spending-user:last-child {
		border-radius: 0px 0px 16px 16px;
	}

	.spending-container .spending-entry:hover {
		background-color: var(--button);
		color: white;
	}

	.spending-container .active-spending-entry {
		background-color: var(--button-hover) !important;
		color: white;
	}

	.spending-container ul {
		list-style-type: none;
		padding-inline-start: 0%;
		text-align: center;
	}

	#spending-log-controls button {
		background-color: var(--button);
		color: white;

		border-radius: 8px;
		border: 1px solid var(--heading-sub);
		transition: background-color 0.5s;
		font-size: 18pt;
		font-family: "Poppins", sans-serif;
	}

	#spending-log-controls button:hover, 
	#spending-log-controls button:focus {
		background-color: var(--button-hover);
	}

	#spending-log-controls button:active {
		background-color: var(--text);
	}

	@media(max-aspect-ratio: 1/1) {
		#spending-log-wrapper {
			overflow-x: scroll;
			overflow-y: clip;
		}

		#spending-log-controls button {
			margin: 1em;
			padding: 2% 5%;
			font-size: 1.5em;
		}

		.spending-container {
			height: 60vh;
			flex-direction: row;
			overflow-x: scroll;
			overflow-y: clip;
		}

		.spending-container #spending-entry-header {
			grid-template-columns: 100%;
			grid-template-rows: 10% 15% 65% 10%;

			padding: 0.1em 0.4em;
		}

		.spending-container #spending-user-header {
			grid-template-columns: 100%;
			grid-template-rows: 30% 40% 30%

			padding: 0.1em 0.4em;
		}

		.spending-container .spending-entry {
			grid-template-columns: 100%;
			grid-template-rows: 10% 15% 65% 10%;

			font-weight: 400;

			padding: 0.1em 0.5em;
		}

		.spending-container .spending-user {
			grid-template-columns: 100%;
			grid-template-rows: 30% 40% 30%

			font-weight: 400;

			padding: 0.1em 0.5em;
		}

		.spending-container .spending-entry:last-child, .spending-container .spending-user:last-child {
			border-radius: 0px 16px 16px 0px;
		}

		.spending-container li {
			overflow: clip;
			width: 20vw;
		}
	}

	@media(max-aspect-ratio: 3/5) {

		.spending-container {
			height: 50vh;
			flex-direction: row;
			overflow-x: scroll;
			overflow-y: clip;
		}

		.spending-container .spending-entry, .spending-container #spending-entry-header {
			font-size: 1.5em;
		}

		.spending-container .spending-user, .spending-container #spending-user-header {
			font-size: 1.5em;
		}

		.spending-container li {
			overflow: clip;
			width: 33vw;
		}
	}
</style>