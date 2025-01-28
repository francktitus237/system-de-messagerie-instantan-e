<?php
require "connection.php";
session_start();

echo fetch_user_chat_historique($_SESSION['id_user'],$_POST['to_user_id'],$connection);


?>