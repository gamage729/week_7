<?php

$server='localhost';
$user ='gamage';
$password ='Admin@729';
$database = 'loging';

$con = new mysqli($server,$user,$password,$database);

if ($con->connect_error ) {
    die("connection failed: ". $con->connect_errno);

}





?>