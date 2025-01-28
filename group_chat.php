<?php
require "connection.php";
session_start();



// Assurez-vous que les données POST sont bien présentes
// if (isset($_POST["action"]) && isset($_POST["chat_message"])) {

  if($_POST["action"] == "insert_data"){
     $data = array(
        ':from_user_id' => $_SESSION["id_user"],
        ':chat_message' => $_POST['chat_message'],
        ':statur' => '1'
     );
     $query= "INSERT INTO chat_messages (id_meassage, from_user_id, chat_message, heure, statur) 
              VALUES(NULL,:from_user_id,:chat_message, current_timestamp(), :statur);";
     
     $statement = $connection->prepare($query);
     if($statement ->execute($data)){
         echo fetch_group_chat_historique($connection);
     }
   }

 if($_POST['action'] == "fetch_data"){
    echo fetch_group_chat_historique($connection);
 }
 
// } else {
   //  echo "Données manquantes.";
// }



?>