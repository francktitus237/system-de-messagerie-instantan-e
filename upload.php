<?php

// Vérifier si un fichier a été téléchargé
if (!empty($_FILES)) {
    // Vérifier si le fichier a bien été téléchargé
    if (is_uploaded_file($_FILES['uploadFile']['tmp_name'])) {

        // Récupérer le chemin source du fichier temporaire
        $source_path = $_FILES['uploadFile']['tmp_name'];

        // Spécifier le répertoire de destination et le nom du fichier
        $target_path = 'upload/' . basename($_FILES['uploadFile']['name']);

        // Vérifier si le fichier téléchargé est bien une image
        $imageFileType = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'png', 'jpeg', 'gif']; // Formats autorisés
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Erreur : Le fichier doit être une image (jpg, png, jpeg, gif).";
            exit();
        }

        // Vérifier si la taille du fichier est inférieure à une limite (par exemple 5 Mo)
        if ($_FILES['uploadFile']['size'] > 5000000) { // Limite de 5 Mo
            echo "Erreur : Le fichier est trop grand. La taille maximale est de 5 Mo.";
            exit();
        }

        // Tenter de déplacer le fichier vers le répertoire de destination
        if (move_uploaded_file($source_path, $target_path)) {
            // Afficher l'image après un téléchargement réussi
            echo '<p><img src="' . $target_path . '" class="img-thumbnail" width="200" height="160"/></p><br/>';
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        }
    } else {
        echo "Aucun fichier téléchargé ou erreur lors du téléchargement.";
    }
} else {
    echo "Aucun fichier téléchargé.";
}
?>
