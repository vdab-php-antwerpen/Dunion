<?php

/**
 * TDB
 * Version 1.01
 */
use vdab\dunion\Service\EventService;

require 'preload.php';
session_start();

if (!isset($_SESSION["user"])) {
    header("location: index.php");
    exit(0);
} else if (isset($_GET["action"]) && $_GET["action"] == "getEvent") {
    $userOjb = unserialize($_SESSION['user']);
    $locationObj = $userOjb->getLocation();
    $jsonResponse = EventService::getEvent($locationObj);

    echo $jsonResponse;
} else {
    header("location: index.php");
}