<?php

class FriendController {

	private $dbConn = null;

	public function  __construct($dbConn = null) {
		$this->dbConn = $dbConn;
	}

	// POST

	public function add($data) {
		if(!isset($data['user_id']) || !isset($data['friend_id'])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}
		$id = explode('/', $data['request'])[2];
		http_response_code(201);
		return json_encode([
			"message"=>"Adding Friend to User", 
			"type"=>"create", 
			"resource"=>"friends", 
			"user_id"=>$id, 
			"friend_id"=>$data['friend_id'], 
			"date"=>$_SERVER['REQUEST_TIME']
		]);
	}

	public function remove($data) {
		if(!isset($data['user_id']) || !isset($data['friend_id'])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}
		$id = explode('/', $data['request'])[1];
		http_response_code(201);
		return json_encode([
			"message"=>"Removing Friend from User", 
			"type"=>"create", 
			"resource"=>"friends", 
			"user_id"=>$id, 
			"friend_id"=>$data['friend_id'], 
			"date"=>$_SERVER['REQUEST_TIME']
		]);
	}

	// GET

	public function retrieve($response) {
		if(!isset($response[1])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}else {
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving User", 
				"type"=>"retrieve", 
				"resource"=>"friends", 
				"user_id"=>$id, 
				"friend_id"=>array("id_1", "id_2"), 
				"date"=>array("date_1", "date_2")
			]);
		}
	}
}

?>