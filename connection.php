<?php
try{

    $connection= new PDO ("mysql:host=localhost;dbname=messagerie;charset=utf8mb4","root","");
    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //echo "connection reussie a la base de donnée";


 function afficher_dernier_connection($id_user, $connection ){
      $requet = " SELECT * FROM stature WHERE id_user = '$id_user' ORDER BY deniere_activiter DESC LIMIT 1";  
      $sta = $connection->prepare($requet);
      $sta ->execute();
      $st = $sta->fetchAll();
      foreach( $st as $s){

          return $s["deniere_activiter"];
       }
       
    }

    function fetch_user_chat_historique($from_user_id,$to_user_id,$connection){
        
        $query=
        " SELECT * FROM chat_messages WHERE (from_user_id = '".$from_user_id."'
        AND to_user_id = '".$to_user_id."')
        OR (from_user_id ='".$to_user_id."' AND to_user_id = '".$from_user_id."')
        ORDER BY heure ASC";
        $statement = $connection->prepare($query);
        $statement->execute();
        $result=$statement->fetchAll();
        $output ='';

        
        $output='<ul class="list-unstyled" style="background-color:#F7F7F7; word-wrap:break-word; overflow-wrap:break-word;display:flex;flex-direction:column;">';
       
        foreach($result as $row){

            
            // Optionnel : On peut formater l'heure ici pour une meilleure lisibilité
            // $formatted_time = date("H:i", strtotime($row['heure']));
            // $output='<ul class="list-unstyled">';
             $user_name = '';
          
            if($row["from_user_id"] == $from_user_id){
                $user_name = '<b class = "text-success">Vous</b>';
                $backgroundcolor='background-color:#87CEEB;';
                $alignelent ='align-self: flex-end;';
                $color = 'color:#FFFFFF;';

            }else{
                $user_name='<b class = "text-danger">'.get_user_name($row['from_user_id'],$connection).'</b>';
                $backgroundcolor='background-color:#ffffff;';
                $alignelent ='align-self:flex-start;';
                $color = 'color:#000000;';
            }  
            $output .='<li style= " margin-bottom:20px; border-radius: 10px; padding:8px; border-bottom:1px dotted #ccc;
                           word-wrap:break-word; overflow-wrap:break-word;'.$color.' '.$backgroundcolor.' '. $alignelent.' width:fit-content; max-width:80%;">
                      <p>'.$row["chat_message"].'</p>
                      </li>';
                 

               }
                    //   .$user_name.'
                     //    <div align ="right">
                    //      . <small><em>'. $row['heure'].'</em></small>
                    //    </div>


         $output .='</ul>';
        $query="UPDATE chat_messages SET statur = '0'
        WHERE from_user_id = '".$to_user_id."'
        AND  to_user_id = '".$from_user_id."'
        AND statur = '1'
        ";
        $statement =$connection->prepare($query);
        $statement->execute();
        return $output;

    }
    
    function get_user_name($user_id, $connection){
        $query = "SELECT nom_user FROM utilisateur  WHERE id_user ='$user_id'";
        $statement= $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        foreach($result as $row){
            return $row['nom_user'];

        }

    }

    function count_unseen_message($from_user_id,$to_user_id,$connection){
        $query =" SELECT * FROM chat_messages WHERE from_user_id = '$from_user_id'
         AND to_user_id = '$to_user_id'
         AND statur ='1'
        ";
        $statement=$connection->prepare($query);
        $statement ->execute();
        $count = $statement->rowCount();
        $output='';
        if($count >0){
            $output = '<span class ="label label-success">'.$count.'</span>';
        }
        return $output ;
    }
    
    function fetch_is_type_stature($user_id,$connection){
       $query = 
       "SELECT is_type FROM stature WHERE id_user = '".$user_id."'
        ORDER BY deniere_activiter DESC 
        LIMIT 1 ";

        $statement = $connection->prepare($query);
        $statement->execute();
        $result=$statement->fetchAll();
        $output='';
         
        foreach($result as $row){
            if( $row['is_type'] =='YES'){
                $output = ' - <small><em><span class= "text-muted"> Ecrire...  </span></em></small>';
            }

        }
        return $output;

    }
    
   function fetch_group_chat_historique($connection){
         $query=" SELECT * FROM chat_messages 
         WHERE  to_user_id ='0'
         ORDER BY heure ASC
          ";

        $statement=$connection->prepare($query);
        $statement->execute();
        $result = $statement-> fetchAll();

        $output='<ul class="list-unstyled" 
        style="background-color:#F7F7F7; 
        word-wrap:break-word; overflow-wrap:break-word;
        display:flex;flex-direction:column;">';

        foreach($result as $row){
            $user_name = '';
            // Optionnel : On peut formater l'heure ici pour une meilleure lisibilité
             $formatted_time = date("H:i", strtotime($row['heure']));
          
            if($row["from_user_id"] == $_SESSION['id_user']){
                $user_name = '<b class = "text-success"></b>';
                $backgroundcolor='background-color:#87CEEB;';
                $alignelent ='align-self: flex-end;';
                $color = 'color:#FFFFFF;';

            }else{
                $user_name='<b class = "text-danger">'.get_user_name($row['from_user_id'],$connection).'</b>';
                $backgroundcolor='background-color:#ffffff;';
                $alignelent ='align-self:flex-start;';
                $color = 'color:#000000;';
            }  

            $output .='<li style= " margin-bottom:20px; border-radius: 10px; padding:8px; border-bottom:1px dotted #ccc;
                           word-wrap:break-word; overflow-wrap:break-word;'.$color.' '.$backgroundcolor.' '. $alignelent.' width:fit-content; max-width:80%;">
                    <p>'.$user_name.' </p>
                     <p> '.$row["chat_message"].'</p>
                      <div align ="right">
                          <small style="color:#808080"><em>'.$formatted_time.'</em></small>
                       </div>
                      </li>';
                 

        }


         $output .='</ul>';

         return $output;


    }
    

}catch(PDOEXCEPTION $e){
    echo "Echec de connection a la base de donnée ".$e->getMessage();
}



?>