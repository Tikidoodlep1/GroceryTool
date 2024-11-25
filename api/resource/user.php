<?php

public function UserFromJson($json) {
	$data = json_decode($json, true);
	if($data === null || $data["UserId"] == null || $data["Username"] == null || $data["Email"] == null) {
		return null;
	}
	return new User($data["UserId"], $data["Username"], $data["Email"]);
}

class User {

	private $id;
	private $username;
	private $email;

	public function __construct($id, $username, $email) {
		$this=>id = $id;
		$this=>username = $username;
		$this=>email = $email;
	}

	public function getId() {
		return $this=>id;
	}

	public function getUsername() {
		return $this=>username;
	}

	public function getEmail() {
		return $this=>email;
	}

	public function ToJson() {
		return json_encode(["UserId"=>$this=>id, "Username"=>$this=>username, "Email"=>$this=>email]);
	}
}

?>