<?php

require "connection.php";
session_start();


$message=NULL;
if(isset($_POST["name_user"]) && isset($_POST["email_user"]) && isset($_POST["password_user"])&& isset($_POST["confirm_password_user"])){
    if(!empty($_POST["name_user"]) && !empty($_POST["email_user"]) && !empty($_POST["password_user"]) && !empty($_POST["confirm_password_user"])){
      $name= $_POST["name_user"];
      $pwd= $_POST["password_user"];
      $requet= "SELECT * FROM utilisateur WHERE nom_user=? AND pwd_user = ?";
      $reponse= $connection->prepare($requet);
      $reponse->execute(array($name,$pwd));
      

      if($reponse->rowCount()>0){
          $message= " se compte existe deja !";

          // $_SESSION["nom"]=$_POST["name_user"];
          // header("location:index.php");
        }else{
          $nom =$_POST["name_user"];

          $email = $_POST["email_user"];
          $pwd =$_POST["password_user"];
          $pwds = password_hash($pwd,PASSWORD_DEFAULT);
          $pwd_confirm = $_POST["confirm_password_user"];
          $pwdc = password_hash($pwd_confirm,PASSWORD_DEFAULT);
         
          if( $pwd != $pwd_confirm){
            $message= "confirmer le bon mot de pass ";
     
           }else{
             //require 'connection.php';
             $id="NULL";
            $requet ="INSERT INTO `utilisateur` (`id_user`, `nom_user`, `pwd_user`, `confirm_pwd`, `email`) VALUES (NULL, :N, :P, :PC, :E);";
            $repose = $connection->prepare($requet);
            $repose->execute(array(
                "N"=>$nom,
                "P"=>$pwds,
                "PC"=>$pwdc,
                "E"=>$email
            ));
            $_SESSION["id_user"] = $connection->lastInsertId();
            $_SESSION["nom"]=$nom;
            
            //$res= $repose->fetch();
            //foreach($res as $row){
               // if(password_verify($_POST["password_user"],$row["pwd_user"])){
                  
            $rep = "INSERT INTO `stature` (`id_stature`, `id_user`, `deniere_activiter`) VALUES (NULL, '".$_SESSION["id_user"]."', current_timestamp());";
            $state = $connection->prepare($rep);
            $state->execute();
            $_SESSION["id_stature"] = $connection->lastInsertId();
            header("location:index.php");
            exit();
   
           // }

            // $_SESSION["nom"] = $nom;
            //$_SESSION["id_user"] = 
            //header("location:login.php");
            //$message= " Nom ou mot de passe incorrect  ! ";
       
          }
        }
    }else
      
       $message= " Veillez entrer votre nom et votre mot de passe !";
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
                <div class="panel-heading" style="color:black;text-align:center;">INSCRIPTION</div>
                <div class="panel-body">
                    <form method="POST" action="#">
                        <div class="form-group">
                            <label for="name_user">NOM DE L'UTILISATEUR:</label>
                            <input type="text" name="name_user" id ="name_user" placeholder="Entrez votre nom" class="form-control" required style="outlink:none;" autocomplete="off" >
                        </div>
                        <div class="form-group">
                            <label for="email_user">EMAIL:</label>
                            <input type="email" name="email_user" id ="email_user" placeholder="Entrez votre email" class="form-control" required style="outlink:none;" autocomplete="off" >
                        </div>
                        <div class="form-group ">
                            <label for="password_user">MOT DE PASSE:</label>
                           <div class="input-group"> <input type="password" name="password_user" id ="password_user" placeholder="Entrez votre mot de passe" class="form-control input1" required   ><span class="input-group-addon marsque1" style="cursor:pointer;">voir</span></div>     
                        </div>
                        <div class="form-group ">
                            <label for="confirm_password_user">CONFIRMER MOT DE PASSE:</label>
                           <div class="input-group"> <input type="password" name="confirm_password_user" id ="confirm_password_user" placeholder="confirmer le mot de passe" class="form-control input2" required   ><span class="input-group-addon marsque2" style="cursor:pointer;">voir</span></div>     
                        </div>
                        <div class="form-group">
                            <input type="submit" value ="envoyer" class="btn btn-default"> 
                            <!--  <span style="margin-rigth:70px;"><i> <a href="login.php" style="text-decoration:none">connecter vous </a></i></span>  -->
                        </div>
                        
                    </form>

                    
                    <div class="alert alert-warning">
                        <p style="text-align:center;"><?php echo $message; ?></p>

                    </div>

                    
                </div>
            </div>
        </div>
        <script>
            var mq= document.querySelector(".marsque1");
            var ip= document.querySelector(".input1")
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

            var mq2= document.querySelector(".marsque2");
            var ip2= document.querySelector(".input2")
            var a2=-1;
            mq2.addEventListener("click", function(){
            
            if(a2==-1){
                mq2.textContent="cachez";
                ip2.type="text";
                a=1;
            }else{
                mq2.textContent="voir";
                ip2.type="password";
                a2=-1
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