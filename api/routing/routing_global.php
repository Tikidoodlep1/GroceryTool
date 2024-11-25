<?php

header("Content-Type: application/json; charset=UTF-8");

$resource = null;


switch($_SERVER['REQUEST_METHOD']) {
	case 'DELETE':
	case 'GET':
		if(isset($_GET["request"])) {
			$route = new RequestReciever();
			$resource = $route->executeRequest($_GET["request"]);
			echo $resource;
			exit();
		}
		break;
	case 'PUT':
	case 'POST':
		$data = json_decode(file_get_contents('php://input'), true);
		if(isset($data["request"])) {
			$route = new RequestReciever();
			$resource = $route->executeRequest($data["request"], $data);
			echo $resource;
			exit();
		}
		break;
}

class RequestReciever {

	public function __construct() {
	}

	public function executeRequest($request, $data = null) {
		$request = explode('/', $request);

		switch($request[0]) {
			case 'users':
				require($_SERVER['DOCUMENT_ROOT'] . '/programs/ShopMate/api/routing/route_user.php');
				$route = new UserRoutes($_SERVER['REQUEST_METHOD']);
				return $route->route($data);
				break;
			case 'auth':
				require('./route_auth.php'); //Doesn't exist yet
				break;
			case 'trackers':
				require($_SERVER['DOCUMENT_ROOT'] . '/programs/ShopMate/api/routing/route_spending_tracker.php');
				$route = new SpendingTrackerRoutes($_SERVER['REQUEST_METHOD']);
				return $route->route($data);
				break;
			case 'invites':
				require($_SERVER['DOCUMENT_ROOT'] . '/programs/ShopMate/api/routing/route_invite.php');
				$route = new InviteRoutes($_SERVER['REQUEST_METHOD']);
				return $route->route($data);
				break;
			case 'friends':
				require($_SERVER['DOCUMENT_ROOT'] . '/programs/ShopMate/api/routing/route_friend.php');
				$route = new FriendRoutes($_SERVER['REQUEST_METHOD']);
				return $route->route($data);
				break;
			case 'pages':
				return json_encode(["path"=>"pages"]);
				break;
			default:
				http_response_code(404);
				return json_encode(["error"=>"Page Not Found", "uri"=>$request[0]]);
				break;
		}
	}
}

?>