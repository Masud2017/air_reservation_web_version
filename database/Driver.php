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

	public function seedForRole() {
		// this method will populate the role table with intial data
		$seed = "INSERT INTO role (role) VALUES ('user')";
		$seed2 = "INSERT INTO role (role) VALUES ('admin')";

		if (mysqli_query($this->conn, $seed)) {
			echo "<br>Seeding first seed to the role table";
		} else {
			echo "<br>Seeding first seed to the role table failed";
		}


		if (mysqli_query($this->conn, $seed2)) {
			echo "<br>Seeding second seed to the role table";
		} else {
			echo "<br>Seeding second seed to the role table failed";
		}
		
	}


	public function getRoleIdByRoleName($role_name) {
		$searchQuery = "SELECT id from role where role='${role_name}'";
		$result = mysqli_query($this->conn, $searchQuery);
		if (result) {
			echo "<br?>Role Searching query performed successfully";
		} else {
			echo "<br?>Role Searching query performing failure";
		}
		if (mysqli_num_rows($result) > 0) {
			$result = mysqli_fetch_assoc($result);
		}
		return $result["id"];
	}

	protected function createRootUser() {
		$this->seedForRole();

		$password = password_hash("root", PASSWORD_BCRYPT,['cost' => 10]);

		$addRootUser = "INSERT INTO users (fname,lname,email,password) VALUES ('Super','User','root@gmail.com','${password}')";
		if (mysqli_query($this->conn,$addRootUser)) {
			echo "Root user creation successfull";
		} else {
			echo "Root user creation is failed";
		}

		$result = mysqli_query($this->conn,"SELECT * from users where email='root@gmail.com'");
		if ($result) {
			echo "<br>Root user is exists";
			$result = mysqli_fetch_assoc($result);

		} else {
			echo "<br>Root user is not exists";
		}
		$user_id = $result["id"];
		$role_id = $this->getRoleIdByRoleName("admin");
		# add the role to the root user
		$adminRole = "INSERT INTO user_role(user_id,role_id) VALUES('${user_id}','${role_id}')";

		if (mysqli_query($this->conn, $adminRole)) {
			echo "<br>Attaching role with admin user is successfull";
		} else {
			echo "<br>Attaching role with admin user is failed";
		}
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
			CONSTRAINT PK_history PRIMARY KEY CLUSTERED (id),
			ordered_ticket_id INT,
			qty INT,
			done BOOLEAN,
			cancelled BOOLEAN
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
			id INT AUTO_INCREMENT PRIMARY KEY,
			destination varchar(244),
			price INT,
			quantity INT,
			created_at TIMESTAMP
		)";

		if (mysqli_query($this->conn, $ticketsTable)) {
			echo "<br>Creating tickets table is successfull";
		} else {
			echo "<br>Creating tickets table is failed ".mysqli_error($this->conn);
		}

		$orderedTicketsTable = "CREATE TABLE IF NOT EXISTS ordered_tickets(
			id INT AUTO_INCREMENT,
			CONSTRAINT PK_ordered_tickets PRIMARY KEY CLUSTERED (id),
			user_id INT,
			ticket_id INT,
			qty INT
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

		// username : root and password : root
		$this->createRootUser();
	}


	
	public function insertData($query) {
		if (mysqli_query($this->conn, $query)) {
			echo "<br>Query executed successfully";
		} else {
			echo "<br>Query execution error: " . mysqli_error($this->conn);
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


	public function getRoleByUserId($user_id) {
		$getRoleId = "SELECT role_id from user_role where user_id = '${user_id}'";
		$result = mysqli_query($this->conn,$getRoleId);
		if ($result) {
			echo "<br>Role id is found for the corrosponding user id ";
			$result = mysqli_fetch_assoc($result);
		} else {
			echo "<br>Role id is not found for the corrosponding user id ";

		}

		$role_id = $result["role_id"];
		$role = "SELECT role from role where id = '${role_id}'";
		$result2 = mysqli_query($this->conn,$role);

		if ($result2) {
			echo "<br>Role is found for the provided user_id";
			$result2 = mysqli_fetch_assoc($result2);
		} else {
			echo "<br>Role is not found for the provided user_id";
		}

		return $result2["role"];
	}

	public function getUserInfo($user_id) {
		$sql = "SELECT * from users where id='${user_id}'";
		$user = mysqli_query($this->conn,$sql);

		if ($user) {
			echo "<br>Currently logged in user is found";
			$user = mysqli_fetch_assoc($user);
		} else {
			echo "<br>Currently logged in user is not found ".mysqli_error($this->conn);
		}
		return $user;
	}

	public function getTicketList() {
		$sql = "SELECT id,destination, price,quantity from tickets";
		$result = mysqli_query($this->conn,$sql);
		$arr = array();

		if ($result) {
			echo "<br>ticket list is found";
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					array_push($arr,$row);
				}
			}
		} else {
			echo "<br>ticket list is not found";
		}

		return $arr;
	}

	public function deleteTicketById($ticket_id) {
		$sql = "DELETE FROM tickets where id='${ticket_id}'";

		if (mysqli_query($this->conn,$sql)) {
			echo "<br>A record from tickets table is deleted successfully";
		} else {
			echo "<br>A record from tickets table is deleted failed :".mysqli_error($this->conn);
		}
	}

	public function getWallet($user_id) {
		$sql = "SELECT * from wallet where user_id='${user_id}'";
		$result = mysqli_query($this->conn,$sql);
		if ($result) {
			echo "<br>Wallet info found";
			$result = mysqli_fetch_assoc($result);
		} else {
			echo "<br>Wallet info is not found ".mysqli_error($this->conn);
		}

		return $result["balance"];
	}

	public function getTicketById($ticket_id) {
		// $sql = "SELECT * FROM tickets where id='${$ticket_id}'";
		$sql = "SELECT id,destination, price,quantity from tickets where id='${ticket_id}'";

		$result = mysqli_query($this->conn,$sql);

		if ($result) {
			echo "<br>The ticket record is found for the given ticket id";
			$result = mysqli_fetch_assoc($result);
		} else {
			echo "<br>The ticket record is not found for the given ticket id ".mysqli_error($this->conn);
		}

		return $result;
	}

	public function getOrderedTicketById($ticket_id) {
		// $sql = "SELECT * FROM tickets where id='${$ticket_id}'";
		$sql = "SELECT * from ordered_tickets where ticket_id='${ticket_id}'";

		$result = mysqli_query($this->conn,$sql);

		if ($result) {
			echo "<br>The ordered ticket record is found for the given ticket id";
			$result = mysqli_fetch_assoc($result);
		} else {
			echo "<br>The ordered ticket record is not found for the given ticket id ".mysqli_error($this->conn);
		}

		return $result;
	}

	public function addTicketInfoToOrderTable($ticket_id,$user_id) {
		echo " This is ticket id  : ".$ticket_id;
		$searchForExistingTicket = "SELECT  * FROM ordered_tickets where user_id='${user_id}'";
		$result = mysqli_query($this->conn, $searchForExistingTicket);

		if ($result) {
			if(mysqli_num_rows($result) > 0) {
				$result = mysqli_fetch_assoc($result);
				$prevQty = $result["qty"];
				$qty = $prevQty + 1;
				$updateTicket = "UPDATE ordered_tickets SET qty='${qty}' where user_id = '${user_id}'";
				echo "gg";

				$res = mysqli_query($this->conn,$updateTicket);

				if ($res) {
					echo "<br>Ordered Ticket table is updated successfully";
				} else {
					echo "<br>Updating ordered ticket table is failed ".mysqli_error($this->conn);
				}
			} else {
					echo "<br>Ordered Ticket is not available in the orderd ticket table";
					echo "<br>Creating new ordered_tickets ".mysqli_error($this->conn);
					$this->insertData("INSERT INTO ordered_tickets (user_id,ticket_id,qty) VALUES('${user_id}','${ticket_id}','1')");
			}


		} else {
			echo "Something went wrong ".mysqli_error($this->conn);
		}

		// if ($result) {
		// 	echo "<br>Ordered Ticket is already available in the orderd ticket table";

		// 		$result = mysqli_fetch_assoc($result);
		// 		$prevQty = $result["qty"];
		// 		$qty = $prevQty + 1;
		// 		$updateTicket = "UPDATE ordered_tickets SET qty='${qty}' where ticket_id = '${ticket_id}'";
		// 		echo "gg";

		// 		$res = mysqli_query($this->conn,$updateTicket);

		// 		if ($res) {
		// 			echo "<br>Ordered Ticket table is updated successfully";
		// 		} else {
		// 			echo "<br>Updating ordered ticket table is failed ".mysqli_error($this->conn);
		// 		}
				

			
		// } else {
		// 	echo "<br>Ordered Ticket is not available in the orderd ticket table";
		// 	echo "<br>Creating new ordered_tickets ".mysqli_error($this->conn);
		// 	$this->insertData("INSERT INTO ordered_tickets (user_id,ticket_id,qty) VALUES('${user_id}','${ticket_id}','1')");

		// }

	}

	public function getOrderedTicketList($user_id) {
		$sql = "SELECT * FROM ordered_tickets where user_id='${user_id}'";
		$result = mysqli_query($this->conn,$sql);
		$arr = array();

		if ($result) {
			echo "Fetching order ticket list sql command executed successfully";
			if (mysqli_num_rows($result) > 0) {
				while($row = mysqli_fetch_assoc($result)) {

					$ticket_id = $row["ticket_id"];

					$fetchTicketData = "SELECT * from tickets where id='${ticket_id}'";

					$tickRes = mysqli_query($this->conn,$fetchTicketData);

					if ($tickRes) {
						echo "<br>Ticket data is fetched ";
						$tickRes = mysqli_fetch_assoc($tickRes);
						$tickRes["quantity"] =  $row["qty"];
						array_push($arr,$tickRes);
					} else {
						echo "<br>Ticket data is not fetched ".mysqli_error($this->conn);

					}
				}
			}
		} else {
			echo "Fetching order ticket list sql command execution failure ".mysqli_error($this->conn);
		}

		return $arr;
	}

	public function fetchOrderHistoryList($user_id) {
		$sql = "SELECT * FROM history where user_id='${user_id}'";
		$result = mysqli_query($this->conn,$sql);
		$arr = array();

		if ($result) {
			echo "<br>history info for this user is available";
			if (mysqli_num_rows($result) > 0) {
				echo "<br>Fething data";
				while($row = mysqli_fetch_assoc($result)) {
					$ticket_id = $row["ordered_ticket_id"];
					$getTicketInfo = "SELECT * FROM tickets where id='${ticket_id}'";
					$ticketInfores = mysqli_query($this->conn,$getTicketInfo);
					if ($ticketInfores) {
						$ticketInfores = mysqli_fetch_assoc($ticketInfores);
						$arr_temp = array("destination"=>$ticketInfores["destination"],
							"price"=>$ticketInfores["price"],
							"qty"=>$row["qty"],
							"cancelled"=>$row["cancelled"],
							"total"=>$row["qty"] * $ticketInfores["price"]
						);
						
						print_r ($arr_temp);



						array_push($arr,$arr_temp);
					} else {
						echo "<br> Error fetching ticket info ".mysqli_error($this->conn);
					}
				}
			}
		} else {
			echo "<br>history info for this user is not available ".mysqli_error($this->conn);
		}

		return $arr;
	}

	public function dropTable($tableName) {
		mysqli_query($this->conn,"drop table ".$tableName);
	}


	public function close() {
		mysqli_close($this->conn);
	}
}

?>