<?php

/**
 * TDB
 * Version 1.00
 */
require 'preload.php';
session_start();

use vdab\dunion\Service\UserService;

if (!isset($_SESSION["user"])) {
    header("location: index.php");
    exit(0);
} else if (isset($_SESSION["user"]) && isset($_GET["action"]) && $_GET["action"] == "logout") {
    $userobject = unserialize($_SESSION["user"]);
   
    $userid = $userobject->getId();
    $userid = intval($userid);
    UserService::updateUserLoggedOut($userid);
    unset($_SESSION["user"]);
    session_destroy();
    header("location: index.php");
} else {
    header("location: index.php");
}