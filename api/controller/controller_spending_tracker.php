<?php

class SpendingTrackerController {

	private $dbConn = null;

	public function  __construct($dbConn = null) {
		$this->dbConn = $dbConn;
	}

	// POST

	public function create($data) {
		if(!isset($data['user_id']) || !isset($data['tracker_name'])) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}
		$id = explode('/', $data['request'])[1];
		http_response_code(201);
		return json_encode([
			"message"=>"Creating Spending Tracker", 
			"type"=>"create", 
			"resource"=>"trackers", 
			"user_id"=>$data['user_id'], 
			"tracker_id"=>"insert-uuid-here", 
			"tracker_name"=>$data['tracker_name']
		]);
	}

	public function createEntry($data) {
		if(!isset($data['user_id']) || !isset($data['tracker_id']) || !isset($data['amount']) || !isset($data['desc'])) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}
		$id = explode('/', $data['request'])[1];
		http_response_code(201);
		return json_encode([
			"message"=>"Creating Spending Entry", 
			"type"=>"create", "resource"=>"entries", 
			"user_id"=>$data['user_id'], 
			"tracker_id"=>"insert-uuid-here", 
			"entry_id"=>"insert-uuid-here", 
			"amount"=>$data['amount'], 
			"date"=>$_SERVER['REQUEST_TIME'], 
			"desc"=>$data['desc']
		]);
	}

	public function update($data) {
		if(!isset($data['user_id']) || !isset($data['tracker_name'])) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}else {
			http_response_code(200);
			return json_encode([
				"message"=>"Updating Spending Tracker", 
				"type"=>"update", 
				"resource"=>"trackers", 
				"user_id"=>array("insert-uuid-here"), 
				"tracker_id"=>$tracker_id, 
				"tracker_name"=>"Target"
			]);
		}
	}

	public function updateEntry($data) {
		if(!isset($data['request']) || !isset($data['entry_id']) || !isset($data['amount']) || !isset($data['desc']) || !isset($data['soft_delete'])) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}else {
			$tracker_id = explode('/', $data['request'])[2];
			http_response_code(200);
			return json_encode([
				"message"=>"Updating Spending Entry", 
				"type"=>"update", 
				"resource"=>"entries", 
				"user_id"=>array("insert-uuid-here"), 
				"tracker_id"=>$tracker_id, 
				"entry_id"=>array($data['entry_id']), 
				"amount"=>array($data['amount']), 
				"date"=>array("mm/dd/yyyy"), 
				"desc"=>array($data['desc'])
			]);
		}
	}

	// GET

	public function retrieveListForUser($request) {
		if(!isset($request) || $request === null) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
			//return json_encode(["message"=>"Retrieving All Users", "type"=>"retrieve", "resource"=>"users"]);
		}else {
			$user_id = $request[2];
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving Spending Trackers for User", 
				"type"=>"retrieve", 
				"resource"=>"trackers", 
				"user_id"=>array(array($user_id, "derek-user-id", "stacy-user-id"), array($user_id), array($user_id), array($user_id)), 
				"tracker_id"=>array("insert-uuid-here", "insert-uuid-here", "insert-uuid-here", "insert-uuid-here"), 
				"tracker_name"=>array("Target", "Walmart", "Sweet Spot", "Aldi")
			]);
		}
	}

	public function retrieveTrackerPreviewList($request) {
		if(!isset($request) || $request === null) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
			//return json_encode(["message"=>"Retrieving All Users", "type"=>"retrieve", "resource"=>"users"]);
		}else {
			$user_id = $request[2];
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving Spending Tracker preview for User", 
				"type"=>"retrieve/preview", 
				"resource"=>"trackers", 
				"user_id"=>array($user_id), 
				"tracker_id"=>array("insert-uuid-here", "insert-uuid-here", "insert-uuid-here", "insert-uuid-here"), 
				"tracker_name"=>array("Target", "Walmart", "Sweet Spot", "Aldi"),
				"entry_id"=>array(array("insert-uuid-here", "shurghejfgsjhf"), array("insert-uuid-here", "ppppppppp"),array("insert-uuid-here"),array("insert-uuid-here")), 
				"entry_user_id"=>array(array("insert-uuid-here", "awoiuh1hi8"), array("insert-uuid-here", "hqhqhqhqqhhqh"), array("insert-uuid-here"), array("insert-uuid-here")), 
				"amount"=>array(array(425.00, 59.61), array(361.80, 761.48), array(73.27), array(761.81)), 
				"date"=>array(array("mm/dd/yyyy", "10/24/2021"), array("mm/dd/yyyy", "09/07/1984"), array("mm/dd/yyyy"), array("mm/dd/yyyy")), 
				"desc"=>array(array("Somethign", "Idk, something else probably I guess"), array("Other Thing", "A really long desc with no purpuse but to test the wrapping power of css"), array("Not somethign"), array("Definitely something else"))
			]);
		}
	}

	public function retrieveSingle($request) {
		if(!isset($request) || $request === null) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}else {
			$tracker_id = $request[2];
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving Single Spending Tracker", 
				"type"=>"retrieve", 
				"resource"=>"trackers", 
				"user_id"=>array(array("insert-uuid-here")), 
				"tracker_id"=>array($tracker_id), 
				"tracker_name"=>array("Target")
			]);
		}
	}

	public function retrieveEntries($request) {
		if(!isset($request) || $request === null) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}else {
			$tracker_id = $request[2];
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving Spending Entries For Tracker", 
				"type"=>"retrieve", 
				"resource"=>"entries", 
				"user_id"=>array("insert-uuid-here", "insert-uuid-here"), 
				"tracker_id"=>$tracker_id, 
				"entry_id"=>array("insert-uuid-here", "insert-uuid-here"), 
				"amount"=>array(425.00, 361.80), 
				"date"=>array("mm/dd/yyyy", "mm/dd/yyyy"), 
				"desc"=>array("Somethign", "Other Thing")
			]);
		}
	}

	public function retrieveSingleEntry($request) {
		if(!isset($request) || $request === null) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}else {
			$tracker_id = $request[2];
			$entry_id = $request[5];
			http_response_code(200);
			return json_encode([
				"message"=>"Retrieving Single Spending Entries", 
				"type"=>"retrieve", 
				"resource"=>"entries", 
				"user_id"=>array("insert-uuid-here"), 
				"tracker_id"=>$tracker_id, 
				"entry_id"=>array($entry_id), 
				"amount"=>array(425), 
				"date"=>array("mm/dd/yyyy"), 
				"desc"=>array("Somethign")
			]);
		}
	}
	
	public function delete($request) {
		if(!isset($request) || $request === null || count($request < 2)) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}else {
			http_response_code(200);
			return json_encode([
				"message"=>"Deleting Spending Tracker", 
				"type"=>"delete", 
				"resource"=>"trackers", 
				"user_id"=>array("insert-uuid-here"), 
				"tracker_id"=>$request[1], 
				"tracker_name"=>"Target DSfhsdfhk sfD"
			]);
		}
	}

	public function deleteEntry($request) {
		if(!isset($request) || $request === null || count($request < 2)) {
			http_response_code(400);
			return json_encode(["message"=>"Not enough data provided, cannot complete the request."]);
		}else {
			http_response_code(200);
			return json_encode([
				"message"=>"Deleting Spending Entry", 
				"type"=>"delete", 
				"resource"=>"entries", 
				"user_id"=>"insert-uuid-here", 
				"tracker_id"=>$tracker_id, 
				"entry_id"=>$entry_id, 
				"amount"=>425, 
				"date"=>"mm/dd/yyyy", 
				"desc"=>"Somethign"
			]);
		}
	}
}

?>