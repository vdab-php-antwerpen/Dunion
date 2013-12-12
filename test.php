<?php

use vdab\dunion\Service\ControlService;

require 'preload.php';
session_start();

$user = unserialize($_SESSION['user']);

$alles = ControlService::getAllData($user);


echo json_encode($alles);

//print_r('<pre>');
//print_r($users);
//print_r('</pre>');


