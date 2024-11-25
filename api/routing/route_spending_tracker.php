<?php

require_once("../controller/controller_spending_tracker.php");

class SpendingTrackerRoutes {

	private $requestMethod = null;

	public function __construct($requestMethod) {
		$this->requestMethod = $requestMethod;
	}
 
	public function route($data = null) {
		$controller = new SpendingTrackerController();

		switch($this->requestMethod) {
			case 'GET':
				$request = $_GET['request'];
				$request = explode('/', $request);

				switch($request[1]) {
					case "list":
						if(count($request) == 4) { //trackers/list/{user_id}/preview
							return $controller->retrieveTrackerPreviewList($request);
						}else { //trackers/list/{user_id}
							return $controller->retrieveListForUser($request); 
						}
						break;
					case "view":
						if(count($request) == 4) { //trackers/view/{tracker_id}/entries
							return $controller->retrieveEntries($request);
						}elseif(count($request) == 5) { //trackers/view/{tracker_id}/entries/{entry_id}
							return $controller->retrieveSingleEntry($request);
						}else {
							return $controller->retrieveSingle($request); //trackers/view/{tracker_id}
						}
						break;
					default:
						http_response_code(405); //Method Not Allowed
						return json_encode([
							"message"=>"Resource-Method Not Allowed"
						]);
				}

				http_response_code(400);
				return json_encode([
					"message"=>"Not enough data provided, cannot complete the request."
				]);
				break;
			case 'POST':
				if($data === null || !isset($data['request'])) {
					http_response_code(400);
					return json_encode([
						"message"=>"Malformed or unusable data, cannot complete the request."
					]);
				}

				$request = explode('/', $data['request']);
				switch($request[1]) {
					case "register":
						if(count($request) == 3) { //trackers/register/entries
							return $controller->createEntry($data);
						}else {
							return $controller->create($data);
						}
						break;
					default:
						http_response_code(405); //Method Not Allowed
						return json_encode([
							"message"=>"Resource-Method Not Allowed"
						]);
				}
				break;
			case 'PUT':
				if($data === null || !isset($data['request'])) {
					http_response_code(400);
					return json_encode([
						"message"=>"Malformed or unusable data, cannot complete the request."
					]);
				}

				$request = explode('/', $data['request']);
				switch($request[1]) {
					case "update":
						if(count($request) == 4) { //trackers/update/{tracker_id}/entries
							return $controller->updateEntry($data);
						}else {
							return $controller->update($data); //trackers/update
						}
						
						break;
					default:
						http_response_code(405); //Method Not Allowed
						return json_encode([
							"message"=>"Resource-Method Not Allowed"
						]);
				}

				http_response_code(400);
				return json_encode([
					"message"=>"Not enough data provided, cannot complete the request."
				]);
				break;
			case 'DELETE':
				$request = $_GET['request'];
				$request = explode('/', $request);
				
				if(isset($request[1])) {
					if(count($request) == 5) { //trackers/delete/{tracker_id}/entries/{entry_id}
						return $controller->deleteEntry($request);
					}else {
						return $controller->delete($request);
					}
				}
				http_response_code(400);
				return json_encode([
					"message"=>"Not enough data provided, cannot complete the request."
				]);
				break;
			default:
				http_response_code(405); //Method Not Allowed
				return json_encode([
					"error"=>"Method Not Allowed"
				]);
				break;
		}
	}
}

?>