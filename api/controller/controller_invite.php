<?php

class InviteController {

	private $dbConn = null;

	public function  __construct($dbConn = null) {
		$this->dbConn = $dbConn;
	}

	// POST

	public function create($data) {
		if(!isset($data['request']) || !isset($data["recipient_email"]) || !( isset($data["is_friend_request"]) || isset($data["list_id"]) || isset($data["tracker_id"]) )) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}
		$request = explode('/', $data['request']);
		http_response_code(201);
		return json_encode([
			"message"=>"Creating Invite", 
			"type"=>"create", 
			"resource"=>"invites", 
			"invite_id"=>"insert-uuid-here", 
			"sender_id"=>$request[2], 
			"recipient_id"=>"insert-uuid-here", 
			"is_friend_request"=>isset($data["is_friend_request"]) ? $data["is_friend_request"] : false,
			"list_id"=>isset($data['list_id']) ? $data['list_id'] : 'null', 
			"tracker_id"=>isset($data['tracker_id']) ? $data['tracker_id'] : null, 
			"create_time"=>$_SERVER['REQUEST_TIME'],
			"expire_time"=>($_SERVER['REQUEST_TIME'] + 500)
		]);
	}

	public function accept($data) {
		if(!isset($data['request']) || !isset($data["recipient_id"])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}

		$invite_id = explode('/', $data['request'])[2];

		http_response_code(200);
		return json_encode([
			"message"=>"Accepting Invite", 
			"type"=>"accept", 
			"resource"=>"invites", 
			"invite_id"=>$invite_id, 
			"sender_id"=>"insert-uuid-here", 
			"recipient_id"=>$data["recipient_id"],
			"is_friend_request"=>false, 
			"list_id"=>'null', 
			"tracker_id"=>'insert-tracker-id', 
			"create_time"=>$_SERVER['REQUEST_TIME'],
			"expire_time"=>date("Y-m-d h:i:s")
		]);
	}

	public function ignore($data) {
		if(!isset($data['request']) || !isset($data["recipient_id"])) {
			http_response_code(400);
			return json_encode([
				"message"=>"Not enough data provided, cannot complete the request."
			]);
		}

		$invite_id = explode('/', $data['request'])[2];

		http_response_code(200);
		return json_encode([
			"message"=>"Ignoring Invite", 
			"type"=>"accept", 
			"resource"=>"invites", 
			"invite_id"=>$invite_id, 
			"sender_id"=>"insert-uuid-here", 
			"recipient_id"=>$data["recipient_id"],
			"is_friend_request"=>false, 
			"list_id"=>'null', 
			"tracker_id"=>'insert-tracker-id', 
			"create_time"=>$_SERVER['REQUEST_TIME'],
			"expire_time"=>date("Y-m-d h:i:s")
		]);
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
				"message"=>"Retrieving invites for recipient user", 
				"type"=>"retrieve", 
				"resource"=>"invites", 
				"invite_id"=>array("insert-uuid-here", "insert-uuid-here"), 
				"sender_id"=>array("insert-user-id", "insert-user-id"), 
				"is_friend_request"=>array(false, false), 
				"recipient_id"=>$request[2],
				"list_id"=>array('null', 'insert-list-id'), 
				"tracker_id"=>array('insert-tracker-id', 'null'), 
				"create_time"=>array($_SERVER['REQUEST_TIME'], date("Y-m-d h:i:s")),
				"expire_time"=>array(date("Y-m-d h:i:s"), "insert-expire-time-here")
			]);
		}
	}
	
}

?>