<?php
include ("controller/AuthController.php");
include ("controller/UserController.php");
include ("controller/TicketController.php");


include ("database/Driver.php");

use Controller\AuthController;
use Controller\UserController;
use Controller\TicketController;
use Database\Driver;




// this function will register controller based on the router url
function forwardToController($controllerName,$method) {
	$dbDriver = new Driver("root","","localhost","airsystem");

	switch ($controllerName) {
		case "AuthController":
				$authController = new AuthController($dbDriver);
				switch ($method) {
					case "authenticate":
						$authController->authenticate();
						break;
					case "registration":
						$authController->registration();
						break;

					case "logout":
						$authController->logout();
						break;
					
					default:
						# code...
						break;
				}
			break;

			case "UserController":
				$userController = new UserController($dbDriver);
				switch ($method) {
					case 'addUserInfo':
						$userController->addUserInfo();
						break;

					case "editUserInfo":
						$userController->editUserInfo();
						break;
					case "getUserInfo":
						$userController->getUserInfo();
						break;
					
					default:
						# code...
						break;
				}
				break;

			case "TicketController":
				$ticketController = new TicketController($dbDriver);
				switch ($method) {
					case 'addNewTicket':
						$ticketController->addNewTicket();
						break;
					case 'getAvailAbleTicketInfo':
						$ticketController->getAvailAbleTicketInfo();
					default:
						# code...
						break;
				}
				break;
		
		default:
			# code...
			break;
	}
}


// Router
$requestToDispatch = $_SERVER["REQUEST_URI"];
// echo $requestToDispatch;
$requestDispatchList = explode("?", $requestToDispatch);
switch ($requestDispatchList[0]) {
	case '/air_reservation/':
		forwardToController("UserController","getUserInfo");
		require ('index.php');
		break;
	case '/air_reservation/login':
		require __DIR__ . '/pages/login.php';
		break;
	case '/air_reservation/signup':
		require __DIR__ . '/pages/signup.php';
		break;

	case '/air_reservation/addaddress':
		require __DIR__ . '/pages/add-user-address.php';
		break;

	case '/air_reservation/edituser':
		require __DIR__ . '/pages/edituser.php';
		break;
	case '/air_reservation/mywallet':
		require __DIR__ . '/pages/walletpage.php';
		break;
	case '/air_reservation/navigateticket':
		require __DIR__ . '/pages/navigate-tickets.php';
		break;
	case '/air_reservation/orderedticket':
		require __DIR__ . '/pages/ordered-ticket.php';
		break;
	case '/air_reservation/addticket':
		require __DIR__ . '/pages/add-new-ticket.php';
		break;


	case '/air_reservation/authenticate':
		echo $_SERVER["QUERY_STRING"];
		forwardToController($controllerName = "AuthController",$method = "authenticate");
		break;
	case '/air_reservation/registration':
		// echo $_SERVER["QUERY_STRING"];
		forwardToController($controllerName = "AuthController",$method = "registration");
		break;

	case '/air_reservation/logout':
		// echo $_SERVER["QUERY_STRING"];
		forwardToController($controllerName = "AuthController",$method = "logout");
		break;

	case '/air_reservation/getuser':
		// echo $_SERVER["QUERY_STRING"];
		forwardToController($controllerName = "UserController",$method = "getUserInfo");
		break;

	case '/air_reservation/adduseraddress':
		// echo $_SERVER["QUERY_STRING"];
		forwardToController($controllerName = "UserController",$method = "addUserInfo");
		break;
		
	case '/air_reservation/edituserinfo':
		// echo $_SERVER["QUERY_STRING"];
		forwardToController($controllerName = "UserController",$method = "editUserInfo");
		break;

	case '/air_reservation/addnewticket':
		// echo $_SERVER["QUERY_STRING"];
		forwardToController($controllerName = "TicketController",$method = "addNewTicket");
		break;

	case '/air_reservation/getticketlist':
		// echo $_SERVER["QUERY_STRING"];
		forwardToController($controllerName = "TicketController",$method = "getAvailAbleTicketInfo");
		break;

	default :
		http_response_code(404);

		require __DIR__ . '/pages/error.php';
}

