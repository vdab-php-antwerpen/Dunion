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
} else if (isset($_GET["action"]) && $_GET["action"] == "createMessage" && isset($_GET['message'])) {
    $userOjb = unserialize($_SESSION['user']);
    $jsonResponse = MessageService::createMessage($userOjb, $_GET['message']);

    echo $jsonResponse;
} else {
    header("location: index.php");
}