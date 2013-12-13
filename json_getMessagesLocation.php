<?php

/**
 * TDB
 * Version 1.01
 */
use vdab\dunion\Service\MessageService;

require 'preload.php';
session_start();

 if (isset($_GET["action"]) && $_GET["action"] == "getMessages" && isset($_SESSION['user'])) {
    $userOjb = unserialize($_SESSION['user']);
    $locationObj = $userOjb->getLocation();
    $jsonResponse = MessageService::getMessagesByLocation($locationObj);

    echo $jsonResponse;
}