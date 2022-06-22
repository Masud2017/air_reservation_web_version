<?php
namespace Controller;

include ("util/VariableBucket.php");
use Util\VariableBucket;

class UserController {
	private $driver = null;
	private $variableBucket;

	function __construct ($driver) {
		$this->driver = $driver;
		$this->variableBucket = VariableBucket::getInstance();
		session_start();
	}

	public function addUserInfo() {
		// add user and then redirect to the home page
		if (isset($_SESSION["username"])) {
			
		} else {
			header("Location: /air_reservation/");
			exit();
		}

	}

	public function editUserInfo() {
		// edit user and redirect to the home page
	}
	public function getUserInfo() {
		// get user and redirect to the homepage

		
		if ($_SESSION["username"]) {
			$userNmae = $_SESSION["username"];

			$result = $this->driver->searchUserAddressByUserName($userNmae);

			if (mysqli_num_rows($result) > 0) {
				// data is available

			} else {
				
			}

			// $this->variableBucket->addVariable("dd","dddd");
			// $_SESSION["variableObj"] = $this->variableBucket->getVariableMap();


			header("Location: /air_reservation/");
			exit();


		}

		header("Location: /air_reservation/");
		exit();

		
	}
}

?>