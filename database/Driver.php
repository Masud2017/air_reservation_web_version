<?php
namespace Database;

class Driver {
	private $username;
	private $password;
	private $serverName;
	private $dbName;
	private $conn;

	function __construct ($dbUserName,$dbPassword, $dbServerName,$dbName) {
		$this->username = $dbUserName;
		$this->password = $dbPassword;
		$this->serverName = $dbServerName;
		$this->dbName = $dbName;
	}

	public function connect() {
	
		$this->conn = mysqli_connect($this->serverName, $this->username, $this->password,$this->dbName);

	}

	public function init() {
	$queryUser = "CREATE TABLE if not exists users(
		id int AUTO_INCREMENT unique,
		fname varchar(10),
		lname varchar(20),
		email varchar(30),
		password varchar(100)
	)";
	$queryAddress = "CREATE TABLE if not exists address(
		id int AUTO_INCREMENT unique,
		address varchar(120),
		phone varchar(12),
		city varchar(12),
		disctrict varchar(20),
		postal_code varchar(10),
		user_id int unique
	)";

	$queryImage = "CREATE TABLE if not exists images(
		id int AUTO_INCREMENT unique,
		image_url varchar(400),
		user_id int unique
	)";



	$relationOnetoOne = "ALTER TABLE address
		ADD CONSTRAINT FK_User_Address FOREIGN KEY(user_id) 
	    REFERENCES users(id) ON DELETE CASCADE";

	$relationOnetoOneImage = "ALTER TABLE images
		ADD CONSTRAINT FK_User_Image FOREIGN KEY(user_id) 
	    REFERENCES users(id) ON DELETE CASCADE";

	if (mysqli_query($this->conn, $queryUser)) {
	  echo "Table MyGuests created successfully";
	} else {
	  echo "Error creating table: " . mysqli_error($this->conn);
	}


	if (mysqli_query($this->conn, $queryAddress)) {
	  echo "Table MyGuests created successfully";
	} else {
	  echo "Error creating table: " . mysqli_error($this->conn);
	}


	if (mysqli_query($this->conn, $relationOnetoOne)) {
	  echo "Table MyGuests created successfully";
	} else {
	  echo "Error creating table: " . mysqli_error($this->conn);
	}

	if (mysqli_query($this->conn, $queryImage)) {
	  echo "Table MyGuests created successfully";
	} else {
	  echo "Error creating table: " . mysqli_error($this->conn);
	}

	if (mysqli_query($this->conn, $relationOnetoOneImage)) {
	  echo "Table MyGuests created successfully";
	} else {
	  echo "Error creating table: " . mysqli_error($this->conn);
	}



}

	public function insertData($query) {
		
		if (mysqli_query($this->conn, $query)) {
			echo "Data inserted successfully";
		} else {
			echo "Data insertion error: " . mysqli_error($this->conn);
		}

	}

	public function searchUserByUserName($userName) {
		$user = sprintf("SELECT * from users where email='%s'",$userName);
		// $userDb = mysqli_query($this->conn,$user) ? true : false;
		// echo $userDb;
		// mysqli_query($this->conn,$user)

		$result = mysqli_query($this->conn, $user);

		
		return $result;
		
	}

	public function searchImageByUserId($user_id) {
		$sql = "SELECT * from images where user_id=${user_id}";

		$result = mysqli_query($this->conn,$sql);

		if ($result) {
			echo "Image data found";
		} else {
			echo "For some unknown reason image data is not found";
		}

		$result = mysqli_fetch_assoc($result);

		return $result["image_url"];
	}

	public function searchUserAddressByUserName($user_name) {
		$sql = "SELECT * FROM address where user_id= ${user_name}";
		$result = mysqli_query($this->conn,$sql);

		if ($result) {
			echo "User address is found";
			return $result;
		} else {
			echo "User addrsss is not found";
		}
		
	}

	public function insertOneToOne($owningTableName,$owningTableKey,$ownedTable) {
		
	}

	public function testInsert() {
		$query = "INSERT INTO users(fname,lname,email,password)
		VALUES('masud','karim','msmasud578','jpmasudxp')
		";
		if (mysqli_query($this->conn, $query)) {
			echo "Table MyGuests created successfully";
		} else {
			echo "Error creating table: " . mysqli_error($this->conn);
		}

		$query2 = "INSERT INTO address(address,phone,city,disctrict,postal_code,user_id)
		VALUES('afdsafasdf','01721600967','dhaka','city','1216',2)
		";
		if (mysqli_query($this->conn, $query2)) {
			echo "Data inserted successfully";
		} else {
			echo "Data insertion error: " . mysqli_error($this->conn);
		}
	}

	public function dropTable($tableName) {
		mysqli_query($this->conn,"drop table ".$tableName);
	}

	public function close() {
		mysqli_close($this->conn);
	}
}

?>