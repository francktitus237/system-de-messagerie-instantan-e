<?php
require "connection.php";
session_start();

$requete="SELECT * FROM utilisateur WHERE nom_user !='".$_SESSION["nom"]."'   
";
$reponse=$connection->prepare($requete);
$reponse->execute();
$resulta=$reponse->fetchAll();
$affiche ='
    <table class="  table border="0" table-bordered table-striped" >
     <tr>
       <td width="40 "><strong>PROFIL</strong></td>
       <td><strong>UTILISATEUR</strong></td>
       <td><strong>STATUS</strong></td>
       <td><strong>ACTION</strong></td>
     </tr>';
    foreach($resulta as $row){
        $stature="";
       
        
        $heures_courente = strtotime(date('Y-m-d H:i:s') . '-1 hour ,-10 second');
       
        $heures_courente= date('Y-m-d H:i:s' , $heures_courente); 
        $user_last_activity  = afficher_dernier_connection($row["id_user"], $connection);
        if( $user_last_activity > $heures_courente ){
        
          $stature = "<span class= 'label label-success'> ONLINE</span>";
        }else{
  
          $stature =  "<span class= 'label label-danger'> OFFLINE</span>";

        }
        
        $affiche .='
           <tr>
              
              <td><img src="" style="height:35px;width:35px;border-radius:1000px;background-color:black;"></td>
              <td><strong>'.$row["nom_user"].' '.count_unseen_message($row['id_user'], $_SESSION['id_user'],$connection).' </strong>   '.fetch_is_type_stature($row['id_user'],$connection).'</td>
              <td>'.$stature.'</td>
              <td><button type="button" class="btn btn-info btn-xs discussion" data-touserid="'.$row["id_user"].'" data-tousername="'.$row["nom_user"].'">Discuter</button>
               </td>
           </tr>
             ';
    }

$affiche .='</table>';     

echo $affiche;
?>