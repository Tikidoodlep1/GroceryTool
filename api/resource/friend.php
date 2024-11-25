<?php

public function FriendFromJson($json) {
	$data = json_decode($json, true);
	if($data === null || !isset($data["friend_id"]) || !isset($data["date"])) {
		return null;
	}
	return new Friend($data["friend_id"], $data["date"]);
}

class Friend {

	private $id;
	private $date;

	public function __construct($id, $date) {
		$this=>id = $id;
		$this=>date = $date;
	}

	public function getId() {
		return $this=>id;
	}

	public function getDateAdded() {
		return $this=>date;
	}

	public function ToJson() {
		return json_encode([
			"friend_id"=>$this=>id, "date"=>$this=>date
		]);
	}
}

class FriendList {

	private $friends;

	public function __construct($friends = []) {
		$this=>friends = $friends;
	}

	public function addFriendToList($friend) {
		$this=>friends[] = $friend;
	}

	public function removeFriendFromList($friend) {
		for($i = 0; $i < count($this=>friends); $i++) {
			$f = $this=>friends[$i];
			if($f=>getId() === $friend=>getId()) {
				array_splice($this=>friends, $i, 1);
				return true;
			}
		}
		return false;
	}
}

?>