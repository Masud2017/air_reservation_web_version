<?php
namespace Controller;

class OrderController {
    private $driver;

    function __construct($driver) {
        session_start();
        $this->driver = $driver;
        $this->driver->connect();
    }
    
    public function getOrderedTickets() {
        $user_id = $_SESSION["user_id"];
        $orderedTicketList = $this->driver->getOrderedTicketList($user_id);

        $_SESSION["orderedTicketList"] = $orderedTicketList;

        header("Location: /air_reservation/orderedticketlist");
		exit();
    }

    public function orderTicket() {
        $ticket_id = $_GET["ticket_id"];
        $user_id =  $_SESSION["user_id"];

        $this->driver->addTicketInfoToOrderTable($ticket_id,$user_id);

        header("Location: /air_reservation/getticketlist");
		exit();
    }

    public function cancelOrder() {
        $ticket_id = $_GET["ticket_id"];
        $user_id = $_SESSION["user_id"];

        $ticket = $this->driver->getTicketById($ticket_id);
        $ordered_ticket = $this->driver->getOrderedTicketById($ticket_id);

        $qty = $ticket["quantity"] + $ordered_ticket["qty"];

        $this->driver->insertData("UPDATE tickets SET quantity='${qty}' where id='${ticket_id}'");

        $qt = $ordered_ticket["qty"];
        $this->driver->insertData("INSERT INTO history(user_id,ordered_ticket_id,done,cancelled,qty) VALUES ('${user_id}','${ticket_id}',False,True,'${qt}')");
        $this->driver->insertData("DELETE from ordered_tickets where ticket_id='${ticket_id}'");

        // restoring money to wallet
        $moneyToReturn = $ticket["price"] * $ordered_ticket["qty"];
        $walletMoney = $this->driver->getWallet($user_id);
        $moneyToReturn += $walletMoney;

        $this->driver->insertData("UPDATE wallet SET balance='${moneyToReturn}' where user_id='${user_id}'");

        // after that this controller with redirect to the fetch history controller
        header("Location: /air_reservation/orderhistory");
		exit();

    }

    public function confirmOrder() {
        $ticket_id = $_GET["ticket_id"];
        $user_id = $_SESSION["user_id"];
        
        $orderedTicket = $this->driver->getOrderedTicketById($ticket_id);
        $qty = $orderedTicket["qty"];

        $this->driver->insertData("INSERT INTO history(user_id,ordered_ticket_id,done,cancelled,qty) VALUES ('${user_id}','${ticket_id}',True,False,'${qty}')");
        $this->driver->insertData("DELETE from ordered_tickets where ticket_id='${ticket_id}'");

        // after that this controller with redirect to the fetch history controller
        header("Location: /air_reservation/orderhistory");
		exit();
    }

    public function getOrderHistory() {
        $user_id = $_SESSION["user_id"];
        $orderHistoryList = $this->driver->fetchOrderHistoryList($user_id);

        $_SESSION["history"] = $orderHistoryList;
        echo "<br>Done";
        
        header("Location: /air_reservation/getticketlist");
		exit();
    }
}
?>