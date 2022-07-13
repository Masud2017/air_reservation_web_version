<?php
namespace Controller;

// include ("util/VariableBucket.php");
use Util\VariableBucket;

class TicketController {
    private $driver = null;
    private $user = null;
    private $variableBucket = null;

    function __construct($driver) {
        session_start();
        $this->driver = $driver;
        $this->driver->connect();
        $user_id = $_SESSION["user_id"]; 
        $this->user = $this->driver->getUserInfo($user_id);
        $this->variableBucket = VariableBucket::getInstance();

    }


    // crud from ticket inventory
    public function getAvailableTicketInfo() {
        $ticketList = $this->driver->getTicketList();
        

        $_SESSION["ticketList"] = $ticketList;

        header("Location: /air_reservation/");
		exit();
    }

    public function addNewTicket() {
        $dest = $_GET["destination"];
        $price = $_GET["price"];

        $this->driver->insertData("INSERT INTO tickets(destination,price) VALUES ('${dest}','${price}')");
        header("Location: /air_reservation/getticketlist");
		exit();
    }

    public function deleteTicket() {

    }
}

?>