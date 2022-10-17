<?php
session_start();

require('param.ini.php');
require('security.php');
$message = "";
if(isset($_SESSION['matricule'])  and isset($_SESSION['code'])){
  echo "<script type='text/javascript'>document.location.replace('etudiant.php');</script>";
}

if(isset($_POST['matricule']) and isset($_POST['code'])){
	//verification du code dans la bd

	try{
     // $connection= new PDO('mysql:host=localhost;dbname=vote_ubuntu', 'root', '' );
     $connection = new PDO ($connect_param,$login,$pass);
      
    } 
  catch(Exception $e){
      die('Erreur:' .$e->getMessage());
    }

    //verification du statut (connecte de l'agent)
    $rep = $connection->query('SELECT etat_vote FROM admin ');
    $etat_vote = $rep->fetch()['etat_vote'];
    if($etat_vote%2==0){
      $messsage = "Votes are closed";

    }
    else{
        $reponse = $connection->query('SELECT * FROM agents ');

     while ($donnees = $reponse->fetch()) {
        if($donnees['code']==$_POST['code']){
          if($donnees['Matricule']==$_POST['matricule']){
            //header('LOCATION:reine.php');
            //creation de la session
            setLog($donnees['Id_agent'], 0, getIp());
            $_SESSION['id_agent'] = $donnees['Id_agent'];
            $_SESSION['code']=$_POST['code'];
            $_SESSION['matricule']=$_POST['matricule'];
            //si correct, enregistrement des logs, puis connexion

            //puis redirection
            $reponse->closeCursor();
            echo "<script type='text/javascript'>document.location.replace('etudiant.php');</script>";
          }
        }
      }
    $reponse->closeCursor();
  
    }




}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de vote Ubuntu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="bg-img">
        <div class="content">
            <img src="logo.jpg" alt="logo" width="150" height="100" class="center">
            <header>Director comittee member,please identify yourself</header>
            <form method="post" action="index.php">
                <div class="field">
        
                    <span><?php if(isset($messsage)) echo $messsage ?></span>
                    <input type="text" placeholder="Enter your matricule" name="matricule">
                </div>

                <div class="field space">
                    <span></span>
                    <input type="password" placeholder="Enter your code" name="code">

                </div>
                <br>
                <div class="field1">
                    <input type="submit" value="submit" >
                </div>
            </form>
    </div>
    </div>
   </body>
</html>