<?php
require "connection.php";
session_start();

// Assurez-vous que les données POST sont bien présentes
if (isset($_POST["to_user_id"]) && isset($_POST["chat_message"])) {
    $data = array(
        ':to_user_id'    => $_POST["to_user_id"],
        ':from_user_id'  => $_SESSION["id_user"],
        ':chat_message'  => $_POST["chat_message"], // Correction de la faute de frappe ici
        ':statur'        => "1" // Assurez-vous que 'statur' est bien un champ valide
    );

    // Requête SQL pour insérer un message
    $query = "INSERT INTO `chat_messages` (`id_meassage`, `to_user_id`, `from_user_id`, `chat_message`, `heure`, `statur`) 
              VALUES(NULL, :to_user_id, :from_user_id, :chat_message, current_timestamp(), :statur);";
    
    $statement = $connection->prepare($query);

    // Exécution de la requête avec les données
    if ($statement->execute($data)) {
        // Si l'exécution réussit, récupère l'historique du chat
        echo fetch_user_chat_historique($_SESSION['id_user'], $_POST['to_user_id'], $connection);
    } else {
        echo "Erreur lors de l'insertion du message.";
    }
} else {
    echo "Données manquantes.";
}
?>
