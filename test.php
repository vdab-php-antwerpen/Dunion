<?php
use vdab\dunion\Service\EventService;

require 'preload.php';
session_start();

$user = unserialize($_SESSION['user']);
$locationobj = $user->getLocation();

$event = EventService::getEvent($locationobj);


echo json_encode($event);
