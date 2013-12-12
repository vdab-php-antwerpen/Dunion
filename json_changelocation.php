<?php
/**
 * 
 * Version
 * 1.01 change location userservice KS
 * 1.00 created MV
 * 
 */
//use vdab\dunion\Service\LocationService;
use vdab\dunion\Service\UserService;

require 'preload.php';
session_start();

if (!isset($_SESSION["user"])) {
    header("location: index.php");
    exit(0);
}

if (isset($_GET["action"]) && $_GET["action"] == "changelocation" && (isset($_GET["location_id"]))) {
  
    $userobject = unserialize($_SESSION["user"]);
    $location_id =($_GET["location_id"]);

    $user = UserService::updateUserLocation($userobject, $location_id);
    $_SESSION["user"] = serialize($user);
//    print("<pre>");
//    var_dump($user);
//    exit(0);
   // echo json_encode($done);
   
   
}
