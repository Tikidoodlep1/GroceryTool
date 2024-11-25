class SpendingEntry {

	constructor(id, userId, amount, date, desc, softDelete) {
		this.id = id;
		this.userId = userId;
		this.amount = amount;
		this.date = date;
		this.desc = desc;
		this.softDelete = softDelete;
	}

	setDeleted(deleted) {
		this.softDelete = deleted;
	}

	get getId() {
		return this.id;
	}

	get getUserId() {
		return this.userId;
	}

	get getAmount() {
		return this.amount;
	}

	get getDate() {
		return this.date;
	}

	get getDesc() {
		return this.desc;
	}

	get getDeleted() {
		return this.softDelete;
	}

	get ToJson() {
		return JSON.stringify({"entry_id": this.id, "user_id": this.userId, "amount": this.amount, "date": this.date, "desc": this.desc, "soft_delete": this.softDelete});
	}
}

function SpendingEntryFromJson(json) {
	if(json === null || json.entry_id == null || json.user_id == null || json.amount == null || 
		json.date == null || json.desc == null || json.soft_delete == null) {
		return null;
	}

	return new SpendingEntry(json.entry_id, json.user_id, json.amount, json.date, json.desc, json.soft_delete);
}