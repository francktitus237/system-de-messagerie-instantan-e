<?php
session_start();

if ( !isset($_SESSION["id_user"]) || !isset($_SESSION["nom"])){
    header("location:login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="ajax.js"></script>
        <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link href="dist/js/bootstrap.min.js" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
        <!-- <link href="dist/css/booststrap.min.css" rel="stylesheet"> -->
        <script src="assets/js/ie-emulation-modes-warning.js"></script>
        <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
        <script src="dist/js/bootstrap.min.js"></script>
        <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
      <!-- Chargement de jQuery et jQuery UI (uniquement une version) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src ="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>



       <!-- jQuery UI (essentiel pour utiliser dialog)
         <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
         <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
         -->
        
        <style>
            .profil {
            border-radius: 1000px;
            height: 20px;
            width: 20px;
            background-size: cover;
        }

        .center {
            justify-content: center;
            display: flex;
            align-items: center;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-contenu {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: red;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .user_dialog {
            background-color: white;
            border: 2px solid #ccc;
            padding: 20px;
            resize: none;
            
        }

        .chat {
            height: 300px;
            border: 1px solid #ccc;
            padding: 10px;
            overflow-y: scroll;
        }

        .form-group {
            margin-top: 10px;
        }

        .arrondi{
            border-radius :20px;
        }
        .non-redimantionnable {
            resize: none;
        }


        /* Styles généraux pour la boîte de discussion */
    .user_dialog {
       background-color: white;
       border: 2px solid #ccc;
       padding: 20px;
       border-radius: 10px;
       position: relative;
       resize: none;
    }

.chat {
    height: 300px;
    border: 1px solid #ccc;
    padding: 10px;
    overflow-y: auto;
    margin-bottom: 10px;
}

.form-group {
    margin-top: 10px;
}

textarea {
    width: 100%;
    padding: 10px;
    resize: none;
    border-radius: 5px;
}

button.envoyer {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button.envoyer:hover {
    background-color: #0056b3;
}
.chat_message_area {
    position: relative;
    width: 100%;
    height: auto;
    background-color: #FFF;
    border: 1px solid #CCC;
    border-radius: 3px;
}

.image_upload {
    position: absolute;
    bottom: 8px;
    right: 8px;
}

.image_upload img {
    width: 24px;
    cursor: pointer;
}

/* .image_upload > from > input{
    display: none;
}
.image_upload img{
    width: 24px;
    cursor: pointer;
} */

#group_chat_message{
    width: 100%;
    height: auto;
    min-height: 80px;
    overflow:  auto;
    padding: 6px 24px 6px 12px;
}

/* Pour les écrans plus petits (appareils mobiles) */
@media only screen and (max-width: 768px) {
    /* Rendre la boîte de dialogue de discussion plus large et adaptée aux écrans mobiles */
    .user_dialog {
        width: 100%;
        height: 100vh; /* Prend toute la hauteur de l'écran */
        padding: 10px;
        border-radius: 0;
        
    }

    /* La zone de chat occupe toute la largeur disponible */
    .chat {
        height: 80%; /* Laisse de la place pour le champ de saisie */
    }

    /* Le bouton "Envoyer" occupe toute la largeur */
    button.envoyer {
        width: 100%;
        margin-top: 10px;
    }

    /* Le textarea pour le message prend toute la largeur */
    textarea {
        width: 100%;
    }

    /* Masquer les autres éléments inutiles pour l'affichage mobile */
    .modal {
        display: none; /* Masquer la fenêtre modale */
    }
}


         
        
  </style>

    </head>
    <body>
       <div class="containe">
            <br>
            <h3 style="text-align: center"> MESSAGERIE</h3><hr>
            
            <div  style="padding-right: 50px;text-align:right;" >
            <div  ><img src="img/anonyme.png" alt="image"  id="imagegrand" style="cursor:pointer; height:38px;width:38px;border-radius:1000px;"></div>
                

            <div id="modal" class="modal">
                <span class="close">&times;</span>
                <img  class="modal-contenu" src="img/anonyme.png" alt="" id= "img">
                <div id ="caption"> </div>


            </div>
            <h5  >UTILISATEUR : <i><strong><?php echo $_SESSION["nom"];?></strong></i></h5><a href="deconnection.php"><span style="text-decoration:none;color:red;" >Deconnection</span></a></div>
            <div style="padding-left: 50px;text-align:left;" >
                     <p><strong> Groups de discussions :</strong></p>
                    <input type="hidden" id="is_active_group_chat_window" value="NO"/>
                    <button type="button" name="group_chat" id ="group_chat" class="btn btn-warning btn-xs">Group</button>
                </div>
            <div class="panel panel-default" style="padding:20px; margin:20px; box-shadow:5px 4px #cccc;">
                <div class="panel-heading" style="color:black;text-align:center; background-color:#F7F7F7;">DISCUSSION</div>
                <div class="panel-body">
                    <div class="table-resposive">
                        <div class="row">
                            <!-- <div class="col-md-6"> -->
                            <div id = "user" ></div><br>
                            <div id = "user_contenu" ></div>


                            <!-- </div> -->
                        </div>
                        

                    </div>

                     
                </div>
            </div>
        </div>




        <div id="group_chat_dialog" title="Group de discussion ">
            <div id="group_chat_history" style ="background-color:#F7F7F7;height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;">

            </div> 
            <div class="from-group arrondi">
                <!-- <textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea> -->
         <div class="chat_message_area arrondi">
             <div id="group_chat_message" contenteditable class="from-control" placeholder="Message "></div>
          <div class="image_upload">
            <form  id="uploadImage" method="post" action="upload.php" enctype="multipart/form-data">
              <label for="uploadFile">
                <img src="upload.png" alt="Image" style="margin-top:0px;">
              </label>
              <input type="file" name="uploadFile" id="uploadFile" accept=".jpg,.png" style="display:none;">
            </form>
          </div>
        </div><br>

            <div class="from-group"  style="align-self: flex-end; ">
                <button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info send_group_chat">envoyer</button>

            </div>
            
        </div>
<script>
       document.addEventListener("DOMContentLoaded", function() {
    afficher(); // Appel initial pour afficher les utilisateurs
    
    setInterval(function() {
        changer_activiter();
        afficher();
        opdate_chat_historique_data();
        fetch_group_chat_historique();
    }, 5000);

    // Fonction pour afficher les utilisateurs
    function afficher() {
        fetch("afficher_user.php", {
            method: "POST",
        })
        .then(response => response.text())
        .then(data => {
            console.log(data); // Vérifiez ce que vous obtenez dans la console
            document.getElementById("user").innerHTML = data;
        })
        .catch(error => {
            console.error("Erreur fetch:", error);
            document.getElementById("user").innerHTML = "Désolé, il y a une erreur.";
        });
    }

    // Fonction pour mettre à jour l'activité de l'utilisateur
    function changer_activiter() {
        fetch("changer_activiter.php", {
            method: "POST",
        })
        .then(response => response.text())
        .then(data => {
            // Vous pouvez traiter la réponse ici si nécessaire
        });
    }

    // Fonction de discussion
    function discussion(to_user_id, to_user_name) {
        var contenu = '<div id="user_dialog_' + to_user_id + '" style=" resize:none; overflow: hidden;height:500px; "  class="user_dialog" title="Vous discutez avec ' +to_user_name+ '">';
        contenu += '<div style="resize:none; height:500px;background-color:#F7F7F7; border:1px solid #ccc; overflow-y: auto; margin-bottom:24px; padding:16px; scroll-behavior:auto;scroll-position:bottom; overflow-wrap:break-word; word-wrap:break-word;" class="chat scroll" data-touserid="' + to_user_id + '" id="chat_' + to_user_id + '">';
     
        contenu += fetch_user_chat_historique(to_user_id);
        contenu += '</div>';
        contenu += '<div class="form-group">';
        contenu += '<textarea name="chat_message_' +to_user_id+ '" class="form-control arrondi non-redimantionnable chat_message " id="chat_message_' +to_user_id+ '" placeholder="Entrez votre message"></textarea>';
        contenu += '</div><div class="form-group" align="right">';
        contenu += '<button type="button" name="envoyer" id="' +to_user_id+ '" class="btn btn-info envoyer">Envoyer</button></div></div>';

        
        document.getElementById('user_contenu').innerHTML = contenu;
        document.addEventListener('DOMContentLoaded',function(){
            const div = document.getElementById("chat_' + to_user_id + '");
            div.scrollTo=div.scrollHeight;
        });
       
    }

    

    // Fonction pour afficher l'historique des chats
    function fetch_user_chat_historique(to_user_id){
        $.ajax({
            url: "fetch_user_chat_historique.php",
            method: "POST",
            data: {to_user_id: to_user_id},
            success: function(data){
                $('#chat_' + to_user_id).html(data);
                 // Faire défiler la barre de défilement en bas après l'ajout du message
                 scrollToBottom('group_chat');
            }
        });
    }

    // Fonction pour mettre à jour l'historique de chat
    function opdate_chat_historique_data(){
        $('.chat').each(function() {
            var to_user_id = $(this).data('touserid');
            fetch_user_chat_historique(to_user_id);
        });
    }

    // Événement pour ouvrir la boîte de discussion
    $(document).on('click', '.discussion', function() {
        var id_user = $(this).data('touserid');
        var nom_user = $(this).data('tousername');
        discussion(id_user, nom_user);
        $("#user_dialog_" + id_user).dialog({
            autoOpen: false,
            width: 500,
        });
        $('#user_dialog_' + id_user).dialog('open');
        $('#user_dialog_' + id_user).dialog('open');

    // Utilisez un délai avant d'initialiser emojionearea pour vous assurer que l'élément existe
     setTimeout(function() {
      $('#chat_message_' + id_user).emojioneArea({
        pickerPosition: "top",
        toneStyle: "bullet"
      });
     }, 100);  // Délai de 100ms, vous pouvez ajuster si nécessaire
      });
      

    // Correction du code AJAX de l'envoi du message
    $(document).on('click', '.envoyer', function() {
        var to_user_id = $(this).attr('id');
        var chat_message = $('#chat_message_' + to_user_id).val();
        
        if (chat_message.trim() !== "") {  // Vérification que le message n'est pas vide
            $.ajax({
                url: 'insert_chat.php',
                method: 'POST',  // Utilisation de POST au lieu de GET pour plus de sécurité
                data: {
                    to_user_id: to_user_id,
                    chat_message: chat_message
                },
                success: function(data) {
                    console.log(data);
                    // $('#chat_message_' + to_user_id).val('');
                    var element = $('#chat_message_'+to_user_id).emojioneArea();
                    element[0].emojioneArea.setText('');
                    $("#chat_" + to_user_id).html(data);
                     // Faire défiler la barre de défilement en bas après l'ajout du message
                    scrollToBottom('group_chat');
                }
            });
        } else {
            alert("Veuillez entrer un message avant d'envoyer.");
        }
    });

 $(document).on('focus','.chat_message', function(){

    var is_type = 'YES';
    $.ajax({
        url: 'opdate_is_type-stature.php',
        method:'POST',
        data: {is_type:is_type},
        success: function(){

        }
    })
 });

 $(document).on('blur','.chat_message', function(){

  var is_type = 'NO';
  $.ajax({
    url: 'opdate_is_type-stature.php',
    method:'POST',
    data: {is_type:is_type},
    success: function(){

    }
})
})

$('#group_chat_dialog').dialog({
    autoOpen: false,
    width:400
});

 $('#group_chat').click(function(){ 
    $("#group_chat_dialog").dialog('open');
    $("#is_active_group_chat_window").val("YES");
    fetch_group_chat_historique();

    // Utilisez un délai avant d'initialiser emojionearea pour vous assurer que l'élément existe
    setTimeout(function() {
      $('#group_chat_message').emojioneArea({
        pickerPosition: "top",
        toneStyle: "bullet"
      });
     }, 100);  // Délai de 100ms, vous pouvez ajuster si nécessaire
 });

 $('#send_group_chat').click(function(){
  // $(document).on('click', '.send_group_chat', function(){
    // var chat_message = $('#group_chat_message').val();
    var chat_message = $('#group_chat_message').html();
    var action ='insert_data';
    if (chat_message.trim() !== '') {
     $.ajax({
         url: "group_chat.php",
         method: "POST",
        data: { chat_message: chat_message, action: action },
        success: function (data) {
            // $('#group_chat_message').val('');
            $('#group_chat_message').html('');
            $('#group_chat_history').html(data);
        }
      });
    }
});

function fetch_group_chat_historique() {
    var group_chat_dialog_active = $('#is_active_group_chat_window').val();
    var action = 'fetch_data';
    if (group_chat_dialog_active == "YES") {
        $.ajax({
            url: "group_chat.php",
            method: "POST",
            data: { action: action },
            success: function (data) {
                $('#group_chat_history').html(data);
            }
        })
    }
}

$('#uploadFile').on('change', function() {
    $('#uploadImage').ajaxSubmit({
        target: "#group_chat_message", // Cette zone sera mise à jour avec le message ou image envoyée.
        resetForm: true
    });
});



});
function scrollToBottom(to_user_id) {
    var chatBox = document.getElementById("chat_" + to_user_id);
    chatBox.scrollTop = chatBox.scrollHeight;
}


</script>


        
        

       
    </body>
</html>

