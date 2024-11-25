<?php

require_once("../controller/controller_user.php");

class UserRoutes {

	private $requestMethod = null;

	public function __construct($requestMethod) {
		$this->requestMethod = $requestMethod;
	}
 
	public function route($data = null) {
		$controller = new UserController();

		switch($this->requestMethod) {
			case 'GET':
				$request = $_GET['request'];
				$request = explode('/', $request);

				switch($request[1]) {
					case "view":
						if(count($request) == 4) { //Maybe add more resource specific requests here later
							switch($request[2]) {
								case "trackers":
									return $controller->retrieveUsersForTracker($request); //users/view/trackers/{tracker_id}
								case "invites":
									return $controller->retrieveUsersFromInvites($request); //users/view/invites/{user_id}
							}
						}else {
							return $controller->retrieve($request); //users/view/{user_id}
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
						return $controller->create($data);
						break;
					case "login":
						return $controller->login($data);
						break;
					case "logout":
						return $controller->logout($data);
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
						return $controller->update($data);
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
				if(isset($request[1])) {
					return $controller->delete($request[1]);
				}

				http_response_code(400);
				return json_encode([
					"message"=>"Not enough data provided, cannot complete the request."
				]);
				break;
			default:
				http_response_code(405); //Method Not Allowed
				return json_encode([
					"message"=>"Method Not Allowed"
				]);
				break;
		}
		
	}
}

?>