class Invite {

	constructor(id, senderId, recipientId, friendRequest, listId, trackerId, createTime, expireTime) {
		this.id = id;
		this.senderId = senderId;
		this.recipientId = recipientId;
		this.friendRequest = friendRequest;
		this.listId = listId;
		this.trackerId = trackerId;
		this.createTime = createTime;
		this.expireTime = expireTime;

		//Extra storage for other needed info
		this.senderUsername = "Unknown Sender Username";
		this.resourceName = "Unknown Resource Name";
	}

	getResourceDescription() {
		if(this.friendRequest) {
			return "Friend Request";
		}else if(this.listId != "null" && this.listId != null) {
			return "Shopping List";
		}else if(this.trackerId != "null" && this.trackerId != null) {
			return "Spending Tracker";
		}
		return "Invalid Invite, please deny this.";
	}

	getResourceNameOrId() {
		if(this.resourceName === "Unknown Resource Name") {
			if(this.friendRequest) {
				return this.senderId;
			}else if(this.listId != "null" && this.listId != null) {
				return this.listId;
			}else if(this.trackerId != "null" && this.trackerId != null) {
				return this.trackerId;
			}
		}

		return this.resourceName;
	}

	get getId() {
		return this.id;
	}

	get getSenderId() {
		return this.senderId;
	}

	get getRecipientId() {
		return this.recipientId;
	}

	get getIsFriendRequest() {
		return this.friendRequest;
	}

	get getListId() {
		return this.listId;
	}

	get getTrackerId() {
		return this.trackerId;
	}

	get getCreateTime() {
		return this.createTime;
	}

	get getExpireTime() {
		return this.expireTime;
	}

	get getSenderUsername() {
		return this.senderUsername;
	}

	set setSenderUsername(newVal) {
		this.senderUsername = newVal;
	}

	get getResourceName() {
		return this.resourceName;
	}

	set setResourceName(newVal) {
		this.resourceName = newVal;
	}

	get ToJson() {
		return JSON.stringify({"invite_id": this.id, "sender_id": this.senderId, "recipient_id": this.recipientId, "list_id": this.listId, "tracker_id": this.trackerId, "create_time": this.createTime, "expire_time": this.expireTime, "sender_username": this.senderUsername, "resource_name": this.resourceName});
	}
}

function InviteFromJson(json) {
	if(json === null || json.invite_id == null || json.sender_id == null || json.recipient_id == null || (json.list_id == null && 
		json.tracker_id == null) || json.create_time == null || json.expire_time == null) {
		return null;
	}
	var invite = new Invite(json.invite_id, json.sender_id, json.recipient_id, json.list_id, json.tracker_id, json.create_time, json.expire_time);
	if(json.sender_username != null) {
		invite.setSenderUsername = json.sender_username;
	}
	if(json.resource_name != null) {
		invite.setResourceName = json.resource_name;
	}
	return invite;
}