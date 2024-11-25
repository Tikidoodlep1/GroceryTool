<?php

class UserController {

	private $dbConn = null;

	public function  __construct($dbConn = null) {
		$this->dbConn = $dbConn;
	}

	// POST

	public function create($data) {
		if(!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}
		$id = explode('/', $data['request'])[2];
		http_response_code(201);
		return json_encode([
			"message"=>"Creating User", 
			"type"=>"create", 
			"resource"=>"users", 
			"user_id"=>array($id), 
			"username"=>array($data['username']), 
			"email"=>array($data['email'])
		]);
	}

	public function login($data) {
		if(!isset($data['email']) || !isset($data['password'])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}

		if(isset($data['email']) && isset($data['password'])) {
			if(false) { // Check DB for email and password validation
				http_response_code(400);
				return json_encode([
					"message"=>"Cannot verify email or password"
				]);
			}

			http_response_code(200);
			//do session stuff
			return json_encode([
				"message"=>"Logging into account", 
				"type"=>"login", 
				"resource"=>"users", 
				"user_id"=>array("insert-user-uuid-here"), 
				"username"=>array("Odrick"), 
				"email"=>array($data['email'])
			]);
		}
	}

	public function logout($data) {
		if(!isset($data['email']) || !isset($data['password'])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}

		if(isset($data['email']) && isset($data['password'])) {
			if(false) { // Check DB for email and password validation
				http_response_code(400);
				return json_encode([
					"message"=>"Cannot verify email or password"
				]);
			}

			http_response_code(200);
			//do session stuff
			return json_encode([
				"message"=>"Logging out of account", 
				"type"=>"logout", 
				"resource"=>"users", 
				"user_id"=>array("insert-user-uuid-here"), 
				"username"=>array("Odrick"), 
				"email"=>array($data['email'])
			]);
		}
	}

	public function update($data) {
		if(!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}else {
			$id = explode('/', $data['request'])[2];
			http_response_code(200);
			return json_encode([
				"message"=>"Updating User", 
				"type"=>"update", 
				"resource"=>"users", 
				"user_id"=>$id, 
				"username"=>$data['username'], 
				"email"=>$data['email']
			]);
		}
	}

	// GET

	public function retrieve($request) {
		if($request === null) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}else {
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving User", 
				"type"=>"retrieve", 
				"resource"=>"users", 
				"user_id"=>array($request[2]), 
				"username"=>array("Godrick"), 
				"email"=>array("godrick2401@yahoo.com")
			]);
		}
	}

	public function retrieveUsersForTracker($request) {
		if($request === null) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}else {
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving Users for Spending Tracker", 
				"type"=>"retrieve", 
				"resource"=>"users", 
				"user_id"=>array("insert-uuid-here", "insert-uuid-here", "sueh13-37ndg1-19f18q-198dw8"), 
				"username"=>array("Godrick", "Melina", "Morgott"), 
				//"email"=>array("godrick2401@yahoo.com", "melinalovescats24@gmail.com", "morgottthefellomen1946@yahoo.com")
			]);
		}
	}

	public function retrieveUsersFromInvites($request) {
		if($request === null) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}else {
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving Users from Invites", 
				"type"=>"retrieve", 
				"resource"=>"users", 
				"user_id"=>array("insert-uuid-here", "insert-uuid-here", "sueh13-37ndg1-19f18q-198dw8"), 
				"username"=>array("Godrick", "Melina", "Morgott"), 
				//"email"=>array("godrick2401@yahoo.com", "melinalovescats24@gmail.com", "morgottthefellomen1946@yahoo.com")
			]);
		}
	}
	
	public function delete($id = null) {
		if($id === null) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}else {
			http_response_code(200);
			return json_encode([
				"message"=>"Deleting User", 
				"type"=>"delete", 
				"resource"=>"users", 
				"user_id"=>$id, 
				"username"=>"Godrick", 
				"email"=>"godrick2401@yahoo.com"
			]);
		}
	}
	
}

?>