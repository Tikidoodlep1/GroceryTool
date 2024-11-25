class SpendingTracker {

	constructor(id, name) {
		this.id = id;
		this.name = name;
		this.entries = [];
		this.users = [];
	}

	//Add associated users & change constructor, parsing to match

	addEntry(entry) {
		this.entries.push(entry);
	}

	removeEntry(entryId) {
		for(var i = 0; i < this.entries.length; i++) {
			if(this.entries[i].getId === entryId) {
				this.entries[i].setDeleted(true);
				break;
			}
		}
	}

	addUser(user) {
		this.users.push(user);
	}

	get getUsers() {
		return this.users;
	}

	get getEntries() {
		return this.entries;
	}

	get getId() {
		return this.id;
	}

	get getName() {
		return this.name;
	}

	get ToJson() {
		var jsonEntries = "[";
		for(var i = 0; i < this.entries.length; i++) {
			if(i == this.entries.length - 1) {
				jsonEntries += this.entries[i].ToJson;
			}else {
				jsonEntries += this.entries[i].ToJson + ",";
			}
		}
		jsonEntries += "]";
		var parsedEntries = JSON.parse(jsonEntries);

		var jsonUsers = "[";
		for(var i = 0; i < this.users.length; i++) {
			if(i == this.users.length - 1) {
				jsonUsers += this.users[i].ToJson;
			}else {
				jsonUsers += this.users[i].ToJson + ",";
			}
		}
		jsonUsers += "]";
		var parsedUsers = JSON.parse(jsonUsers);
		
		return JSON.stringify({"tracker_id": this.id, "tracker_name": this.name, "entries": parsedEntries, "users": parsedUsers});
	}
}

function SpendingTrackerFromJson(json) {
	if(json === null || json.tracker_id == null || json.tracker_name == null) {
		return null;
	}

	var tracker = new SpendingTracker(json.tracker_id, json.tracker_name);

	if(json.entries != null) {
		for(var entry of json.entries) {
			tracker.addEntry(new SpendingEntry(entry.entry_id, entry.user_id, entry.amount, entry.date, entry.desc, entry.soft_delete));
		}
	}

	if(json.users != null) {
		for(var user of json.users) {
			tracker.addUser(new User(user.user_id, user.username, user.email));
		}
	}

	return tracker;
}