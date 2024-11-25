<?php

require_once("../controller/controller_invite.php");

class InviteRoutes {

	private $requestMethod = null;

	public function __construct($requestMethod) {
		$this->requestMethod = $requestMethod;
	}
 
	public function route($data = null) {
		$controller = new InviteController();

		switch($this->requestMethod) {
			case 'GET':
				$request = $_GET['request'];
				$request = explode('/', $request);

				switch($request[1]) {
					case "view":
						return $controller->retrieve($request); //invites/view/{user_id}
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
						return $controller->create($data); //invites/register/{sender_id}
						break;
					case "accept":
						return $controller->accept($data); //invites/accept/{invite_id}
						break;
					case "ignore":
						return $controller->ignore($data); //invites/ignore/{invite_id}
						break;
					default:
						http_response_code(405); //Method Not Allowed
						return json_encode([
							"message"=>"Resource-Method Not Allowed"
						]);
				}
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