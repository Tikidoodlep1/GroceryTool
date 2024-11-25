class User {

	constructor(id, username, email) {
		this.id = id;
		this.username = username;
		this.email = email;
	}

	get getId() {
		return this.id;
	}

	get getUsername() {
		return this.username;
	}

	get getEmail() {
		return this.email;
	}

	get ToJson() {
		return JSON.stringify({"user_id": this.id, "username": this.username, "email": this.email});
	}
}

function UserFromJson(json) {
	if(json === null || json.user_id == null || json.username == null || json.email == null) {
		return null;
	}

	return new User(json.user_id, json.username, json.email);
}