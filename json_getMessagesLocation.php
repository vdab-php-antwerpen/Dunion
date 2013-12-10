<?php

/**
 * TDB
 * Version 1.01
 */
use vdab\dunion\Service\MessageService;

require 'preload.php';
session_start();

if (!isset($_SESSION["user"])) {
    header("location: index.php");
    exit(0);
} else if (isset($_GET["action"]) && $_GET["action"] == "getMessages") {
    $userOjb = unserialize($_SESSION['user']);
    $locationObj = $userOjb->getLocation();
    $jsonResponse = MessageService::getMessagesByLocation($locationObj);

    echo $jsonResponse;
} else {
    header("location: index.php");
}