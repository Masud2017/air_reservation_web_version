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
        $quantity = $_GET["qty"];

        $this->driver->insertData("INSERT INTO tickets(destination,price,quantity) VALUES ('${dest}','${price}',${quantity})");
        header("Location: /air_reservation/getticketlist");
		exit();
    }

    public function deleteTicket() {
        $ticket_id = $_GET["id"];

        $this->driver->deleteTicketById($ticket_id);
        header("Location: /air_reservation/getticketlist");
		exit();
    }

    /**
     * Task : First we need to deduct the quantity buy one
     * Second we have to deduct the money that the ticket cost from the wallet
     */
    public function buyTicket() {
        $ticket_id = $_GET["id"];

        // this portion deduct the quantity of ticket
        $ticket = $this->driver->getTicketById($ticket_id);
        if ($ticket["quantity"] < 1) {
            die ("No more tickets are available wait for the admin to add new stock");
        }
        $ticket["quantity"] = $ticket["quantity"] - 1;

        $dest = $ticket["destination"];
        $price = $ticket["price"];
        $wallet = $this->driver->getWallet($_SESSION["user_id"]);
        if ($wallet > $price) {
            $wallet = $wallet - $price;
        } else {
            die("Your don't have sufficient balance to make this request");
        }
        $qty = $ticket["quantity"];
        $id = $ticket["id"];

        $this->driver->insertData("UPDATE tickets SET destination='${dest}', price='${price}',quantity='${qty}' where id='${id}'");

        // now need to deduct money from user
        
        $balance = $wallet;

        $this->driver->insertData("UPDATE wallet SET balance='${balance}'");

        
        

        header("Location: /air_reservation/orderticket?ticket_id=".$ticket["id"]);
		exit();
    }
}

?>