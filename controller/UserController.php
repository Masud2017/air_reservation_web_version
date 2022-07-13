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
		$this->driver->connect();
		$address = $_GET["address"];
		$phone = $_GET["phone"];
		$city = $_GET["city"];
		$district = $_GET["district"];
		$postal_code = $_GET["postal_code"];

		// add user and then redirect to the home page
		if (isset($_SESSION["username"])) {
			$user_id = $_SESSION["user_id"];

			echo $user_id;
			$sql = "INSERT INTO address(address,phone,city,disctrict,postal_code,user_id)
			VALUES ('${address}','${phone}','${city}','${district}','${postal_code}','${user_id}')
			";
			$this->driver->insertData($sql);

			header("Location: /air_reservation/getuser");
			exit();
		} else {
			header("Location: /air_reservation/");
			exit();
		}

	}

	public function editUserInfo() {
		$this->driver->connect();
		$address = $_GET["address"];
		$phone = $_GET["phone"];
		$city = $_GET["city"];
		$district = $_GET["district"];
		$postal_code = $_GET["postal_code"];


		if (isset($_SESSION["username"])) {
			$user_id = $_SESSION["user_id"];

			echo $user_id;
			

			if ($address) {
				$sql = "UPDATE address SET address='${address}' where user_id=${user_id}";
				$this->driver->insertData($sql);
			}

			if ($phone) {
				$sql = "UPDATE address SET phone='${phone}' where user_id=${user_id}";
				$this->driver->insertData($sql);
			}
			if ($city) {
				$sql = "UPDATE address SET city='${city}' where user_id=${user_id}";
				$this->driver->insertData($sql);
			}
			if ($district) {
				$sql = "UPDATE address SET disctrict='${district}' where user_id=${user_id}";
				$this->driver->insertData($sql);
			}
			if ($postal_code) {
				$sql = "UPDATE address SET postal_code='${postal_code}' where user_id=${user_id}";
				$this->driver->insertData($sql);
			}


			header("Location: /air_reservation/getuser");
			exit();
		} else {
			header("Location: /air_reservation/");
			exit();
		}
	}
	public function getUserInfo() {
		// get user and redirect to the homepage

		
		if ($_SESSION["username"]) {
			$this->driver->connect();
			$user_id = $_SESSION["user_id"];

			echo $user_id;
			$result = $this->driver->searchUserAddressByUserId($user_id);


			if (mysqli_num_rows($result) > 0) {
				$result = mysqli_fetch_assoc($result);
				$this->variableBucket->addVariable("address",$result["address"]);
				$this->variableBucket->addVariable("phone",$result["phone"]);
				$this->variableBucket->addVariable("city",$result["city"]);
				$this->variableBucket->addVariable("district",$result["disctrict"]);
				$this->variableBucket->addVariable("postal_code",$result["postal_code"]);
				$this->variableBucket->addVariable("email",$_SESSION["username"]);

				$_SESSION["variableObj"] = $this->variableBucket->getVariableMap();
				
			} else {
				
			}

			header("Location: /air_reservation/");
			exit();


		}

		header("Location: /air_reservation/");
		exit();	
	}
}

?>