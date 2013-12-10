<?php
use vdab\dunion\DAO\xxxxDAO;

require 'preload.php';
session_start();


$movies = CopyDAO::getById(4000);
print("<pre>");
var_dump($movies);
exit(0);


//testbestand test.php