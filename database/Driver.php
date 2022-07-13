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
			id INT AUTO_INCREMENT UNIQUE PRIMARY KEY,
			fname varchar(10),
			lname varchar(20),
			email varchar(30),
			password varchar(100)
			-- CONSTRAINT PK_user PRIMARY KEY CLUSTERED (id)

			
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
		echo "Table user created successfully";
		} else {
		echo "Error creating user table: " . mysqli_error($this->conn);
		}


		if (mysqli_query($this->conn, $queryAddress)) {
		echo "Table address is created successfully";
		} else {
		echo "Error creating address table: " . mysqli_error($this->conn);
		}


		if (mysqli_query($this->conn, $relationOnetoOne)) {
		echo "Table relation between user and address is successfully";
		} else {
		echo "Error relationship between user and address table: " . mysqli_error($this->conn);
		}

		if (mysqli_query($this->conn, $queryImage)) {
		echo "Image table is created successfully";
		} else {
		echo "Error creating Image table: " . mysqli_error($this->conn);
		}

		if (mysqli_query($this->conn, $relationOnetoOneImage)) {
		echo "Relation between user and image is created successfully";
		} else {
		echo "Error in relation between user and image table: " . mysqli_error($this->conn);
		}


		$roleTable = "CREATE TABLE IF NOT EXISTS role (
			id int AUTO_INCREMENT unique PRIMARY KEY,
			role varchar(24)
		)";

		$roleUserManyToManyTable = "CREATE TABLE IF NOT EXISTS user_role(
			user_id INT,
			role_id INT,
			CONSTRAINT user_role_pk PRIMARY KEY (user_id, role_id),
			CONSTRAINT FK_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
			CONSTRAINT FK_role FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE
		)";

		if (mysqli_query($this->conn,$roleTable)) {
			echo "Creating role table successfully";
		} else {
			echo "Create role table is failed";
		}

		if (mysqli_query($this->conn,$roleUserManyToManyTable)) {
			echo "Creating user_role table successfully<br> ".mysqli_error($this->conn);
		} else {
			echo "<br>Creating user_role table failed ".mysqli_error($this->conn);
		}

		$historyTable = "CREATE TABLE IF NOT EXISTS history(
			id INT AUTO_INCREMENT unique,
			user_id INT NOT NULL,
			CONSTRAINT PK_history PRIMARY KEY CLUSTERED (id)
		)";
		/**
		 * this portion and user table portion need to be work on 
		 */
		$oneToManyUserHistory = "ALTER TABLE history ADD CONSTRAINT FK_User_History FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ";
		
		if (mysqli_query($this->conn,$historyTable)) {
			echo "<br>Creating table History is successfull";
		} else {
			echo "<br>Creating table history is failed.";
		}

		if (mysqli_query($this->conn, $oneToManyUserHistory)) {
			echo "<br> One to Many between user and history table is successfull";
		} else {
			echo "<br> ONe to many betwen user and history table is failed ".mysqli_error($this->conn);
		}

		$walletTable = "CREATE TABLE IF NOT EXISTS wallet (
			id INT AUTO_INCREMENT PRIMARY KEY,
			balance INT,
			user_id INT NOT NULL UNIQUE
		) ";
		$walletOneToOneWithUser = "ALTER TABLE wallet ADD CONSTRAINT FK_user_wallet FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE";
		if (mysqli_query($this->conn, $walletTable)) {
			echo "<br>Creating wallet table is successfull";
		} else {
			echo "<br>Creating wallet table is failed";
		}

		if (mysqli_query($this->conn, $walletOneToOneWithUser)) {
			echo "<br>Creating one to one relationship with user and wallet is successfull";
		} else {
			echo "<br>Creating one to one relationship with user and wallet is failed";

		}

		/**
		 * This table is an independant table and has no dpendencies(relationships) on any table
		 * The write,edit and delete access is only preserved to Admin users
		 * Regular users can only be able to read and copy the data to their own profile
		 */
		$ticketsTable = "CREATE TABLE IF NOT EXISTS tickets (
			id INT AUTO_INCREMENT PRIMARY KEY

		)";

		if (mysqli_query($this->conn, $ticketsTable)) {
			echo "<br>Creating tickets table is successfull";
		} else {
			echo "<br>Creating tickets table is failed ".mysqli_error($this->conn);
		}

		$orderedTicketsTable = "CREATE TABLE IF NOT EXISTS ordered_tickets(
			id INT AUTO_INCREMENT,
			CONSTRAINT PK_ordered_tickets PRIMARY KEY CLUSTERED (id),
			user_id INT
		)";

		$orderedTicketsUserOneToMany = "ALTER TABLE ordered_tickets ADD CONSTRAINT FK_User_Ordered_Tickets FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ";

		if (mysqli_query($this->conn,$orderedTicketsTable)) {
			echo "<br>Creating ordered tickets table is successfull ";
		} else {
			echo "<br>Creating ordered tickets table is failed ".mysqli_error($this->conn);
		}

		
		if (mysqli_query($this->conn,$orderedTicketsUserOneToMany)) {
			echo "<br>Creating one to many relationship betwee ordered_tickets and users table is successfull";
		} else {
			echo "<br>Creating one to many relationship betwee ordered_tickets and users table is failed ".mysqli_error($this->conn);

		}
	}


	public function seedForRole() {
		// this method will populate the role table with intial data
	}

	public function insertData($query) {
		if (mysqli_query($this->conn, $query)) {
			echo "Query executed successfully";
		} else {
			echo "Query execution error: " . mysqli_error($this->conn);
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

	public function searchUserAddressByUserId($user_id) {
		echo "From driver user_id ".$user_id;
		$sql = "SELECT * FROM address where user_id= ${user_id}";
		$result = mysqli_query($this->conn,$sql);

		if ($result) {
			echo "User address is found";
			return $result;
		} else {
			echo "User addrsss is not found";
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