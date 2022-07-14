<?php
namespace Controller;

class WalletController  {
    private $driver;

    function __construct($driver) {
		session_start();
        $this->driver = $driver;
		$this->driver->connect();
    }


	public function getTransactionHistoryList() {

	}

	public function fetchWalletInfo() {
		session_start();
		$user_id = $_SESSION["user_id"];

		$balance = $this->driver->getWallet($user_id);

		$_SESSION["balance"] = $balance;

		header("Location: /air_reservation/mywallet");
		exit();
	}

	public function addMoneyToWallet() {
		$money = $_GET["money"] + $this->driver->getWallet($_SESSION["user_id"]);

		$this->driver->insertData("UPDATE wallet SET balance='${money}'");

		header("Location: /air_reservation/fetchwalletinfo");
		exit();
	}
}
?>