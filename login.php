<?php

require "connection.php";
 session_start();
if(isset($_SESSION["id_user"])){
    header("location:index.php");
    exit();
}



$message=NULL;
if(isset($_POST["name_user"]) && isset($_POST["password_user"])){
    if(!empty($_POST["name_user"]) && !empty($_POST["password_user"])){
      $name= $_POST["name_user"];
      $pwd= $_POST["password_user"];
      $requet= "SELECT * FROM utilisateur WHERE nom_user=? ";
      $reponse= $connection->prepare($requet);
      $reponse->execute(array($name));
      
    

       if($reponse->rowCount()>0){
         //$res= $reponse->fetch()["pwd_user"];
         //foreach($res as $row){
          
            $res = $reponse->fetch();
            $_SESSION["id_user"] =$res["id_user"];
            $_SESSION["autorisation"]=$res["pwd_user"];
            $_SESSION["pass"]=$_POST["password_user"];
          
            $_SESSION["nom"]=$res["nom_user"];
           

           if( $_SESSION["pass"]==password_verify( $_SESSION["pass"],$_SESSION["autorisation"])){
               //$message= "utilisateur trouver !";
            //    echo  $_SESSION["nom"];
            //    die();
               
                  $rep = "INSERT INTO `stature` (`id_stature`, `id_user`, `deniere_activiter`) VALUES (NULL, '".$_SESSION["id_user"]."', current_timestamp());";
                  $state = $connection->prepare($rep);
                  $state->execute();
                  $_SESSION["id_stature"] = $connection->lastInsertId();
                  header("location:index.php");
                  exit();
              //  echo "ok";

            }else
            {
                $message= "mot de passe incorrect !"; 
            }
        }else{
           $message= " veillez creer votre compte ! ";
        }
    }else
       $message= " Veillez entrer notre nom et votre mot de passe !";
}






?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link href="dist/js/booststrap.min.js" rel="stylesheet">
        <!-- <link href="dist/css/booststrap.min.css" rel="stylesheet"> -->
        <script src="assets/js/ie-emulation-modes-warning.js"></script>
    </head>
    <body>
       <div class="containe">
            <br>
            <h3 style="text-align: center"> MESSAGERIE</h3>
            <div class="panel panel-default" style="padding:20px; margin:20px; box-shadow:5px 4px #cccc;">
                <div class="panel-heading" style="color:black;text-align:center;">LOGIN</div>
                <div class="panel-body">
                    <form method="POST" action="#">
                        <div class="form-group">
                            <label for="name_user">NOM DE L'UTILISATEUR:</label>
                            <input type="text" name="name_user" id ="name_user" placeholder="Entrez votre nom" class="form-control" required style="outlink:none;" autocomplete="off" >
                        </div>
                        <div class="form-group ">
                            <label for="password_user">MOT DE PASSE:</label>
                           <div class="input-group"> <input type="password" name="password_user" id ="password_user" placeholder="Entrez votre mot de passe" class="form-control input" required   ><span class="input-group-addon marsque" style="cursor:pointer;">voir</span></div>     
                        </div>
                        <div class="form-group">
                            <input type="submit" value ="envoyer" class="btn btn-default"> 
                            <span style="margin:70px;"><i> <a href="inscription.php" style="text-decoration:none">creer un compte</a></i></span> 
                        </div>
                        
                    </form>

                    
                    <div class="alert alert-warning">
                        <p style="text-align:center;"><?php echo $message; ?></p>

                    </div>

                    
                </div>
            </div>
        </div>
        <script>
            var mq= document.querySelector(".marsque");
            var ip= document.querySelector(".input")
            var a=-1;
            mq.addEventListener("click", function(){
            
            if(a==-1){
                mq.textContent="cachez";
                ip.type="text";
                a=1;
            }else{
                mq.textContent="voir";
                ip.type="password";
                a=-1
            }

            })
          
        </script>

        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="dist/js/bootstrap.min.js"></script>
        <script src="assets/js/vendor/holder.min.js"></script>
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    
    </body>
</html>