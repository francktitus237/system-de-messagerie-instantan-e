<?php
require "connection.php";
session_start();

$requet='UPDATE stature SET deniere_activiter = now() WHERE id_stature = "'.$_SESSION["id_stature"].'" ';
$com = $connection->prepare($requet);
$com ->execute();

?>