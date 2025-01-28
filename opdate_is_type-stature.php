<?php
require "connection.php";
session_start();

$query =" UPDATE stature SET is_type ='".$_POST['is_type']."'  WHERE id_stature='".$_SESSION['id_stature']."'  ";
$statement = $connection->prepare($query);
$statement->execute();


?>