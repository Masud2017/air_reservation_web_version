<?php
namespace Controller;


class AuthController {
	private $driver = null;

	function __construct($driver) {
		$this->driver = $driver;
	}

	public function authenticate() {
		// header("Location: /air_reservation/signup");
		// exit();

		$username = $_POST["email"];
		$password = $_POST["password"];

		echo $username;

		$this->driver->connect();

		$result = $this->driver->searchUserByUserName($username);

		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
			$result = mysqli_fetch_assoc($result);

			if (password_verify($password, $result["password"])) {
				session_start();
			 	$_SESSION["username"] = $username;
			 	$_SESSION["name"] = $result["fname"]. " ".$result["lname"];
			 	$_SESSION["user_id"] = $result["id"];

				$image_url = $this->driver->searchImageByUserId($result["id"]);
				
				$path = __DIR__ ."/storage/". $image_url;
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$data = file_get_contents($path);
				if ($data) {
					echo "file is readed";
				} else {
					echo "not readed";
				}

				$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

				$_SESSION["image_url"] = $base64;

			 	
			 	header("Location: /air_reservation/getuser");
		 		exit();
			 } else {
			 	echo "Username or password might be wrong";
			 }
	 	

		} else {
		  echo "0 results"."<br>";
		 
		}




	}

	protected function saveImageToDisk($file,$user_id) {
		echo "Saving data to storage";

		$target_dir = __DIR__ . "/storage/";

		$file_to_save = ${user_id}. "-" .date('d-m-y h-i-s') .  "." . pathinfo($file["name"],PATHINFO_EXTENSION);

		$target_file = $target_dir . basename($file["name"]);

		echo $target_file;

		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
		  $check = getimagesize($file["tmp_name"]);
		  if($check !== false) {
		    echo "File is an image - " . $check["mime"] . ".";
		    $uploadOk = 1;
		  } else {
		    echo "File is not an image.";
		    $uploadOk = 0;
		  }
		}
		if (move_uploaded_file($file["tmp_name"],$target_file)) {
			rename($target_file,$target_dir.$file_to_save);

			// echo htmlspecialchars( basename( $file["name"]));
			echo htmlspecialchars($target_file);

		}


		// query for saving profile image to the data base
		$sql = "INSERT INTO images(image_url,user_id) VALUES('${file_to_save}','${user_id}')";


		$this->driver->insertData($sql);
	}

	
	public function registration() {
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$password = $_POST["password"];
		$email = $_POST["email"];
		$image = $_FILES["image"];
		
		


		$password = password_hash($password, PASSWORD_BCRYPT,['cost' => 10]);
		echo $password."<br>";

		$this->driver->connect();

		$result = $this->driver->searchUserByUserName($email);


		// $sql = sprintf("INSERT INTO users(fname,lname,email,password)
		//   	VALUES('%s','%s','%s','%s'))
		//   	",$fname,$lname,$email,$password);

		if (mysqli_num_rows($result) > 0) {
		  // output data of each row
		 	echo "User already exists";
		} else {
		  echo "0 results"."<br>";
		  $this->driver->insertData("INSERT INTO users(fname,lname,email,password) VALUES ('${fname}','${lname}','${email}','${password}')");

		$result2 = $this->driver->searchUserByUserName($email);
		
		  // output data of each row


		$result2 = mysqli_fetch_assoc($result2);

		$this->saveImageToDisk($image,$result2["id"]);
				
		}


	 	header("Location: /air_reservation/");
 		exit();
	}

	public function logout() {
		echo "yo";
		session_start();
		if (isset ($_SESSION["username"])) {
			session_unset();
			session_destroy();

			header("Location: /air_reservation/");
		 	exit();
		}

		header("Location: /air_reservation/");
		exit();
	}
}
