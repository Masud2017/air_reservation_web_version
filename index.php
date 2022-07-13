<?php


include("pages/layout/header.php");
include ("pages/body.php");
include("pages/layout/footer.php");


include("database/Driver.php");
use Database\Driver;

$driver = new Driver("root","","localhost","airsystem");
$driver->connect();
// $driver->init();
// $driver->seedForRole();
// $driver->dropTable("users");
// $driver->dropTable("address");
// $driver->dropTable("images");

$driver->close();
