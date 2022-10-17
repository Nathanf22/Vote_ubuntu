<?php
session_start();

require('param.ini.php');
require('security.php');
if(!isset($_SESSION['matricule'])  or !isset($_SESSION['code'])){
	echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
if(isset($_POST['matricule_etudiant'])){
	//verification du matricule
	try{
     // $connection= new PDO('mysql:host=localhost;dbname=vote_ubuntu', 'root', '' );
     $connection = new PDO ($connect_param,$login,$pass);
      
    } 
  catch(Exception $e){
      die('Erreur:' .$e->getMessage());
    }

    $reponse = $connection->query('SELECT * FROM etudiants ');
    $rep = $connection->query('SELECT etat_vote FROM admin ');
    $etat_vote = $rep->fetch()['etat_vote'];
    if($etat_vote%2==0){
      $_SESSION['code'] = Null;

      $_SESSION['matricule'] = Null;

      $_SESSION['matricule_etudiant'] = Null;

      session_destroy();
      echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
     // $messsage = "les votes sont fermes";

    }
    else{
          while ($donnees = $reponse->fetch()) {
        if($donnees['Matricule']==$_POST['matricule_etudiant']){
          $Nom_etudiant = $donnees['Nom'];
          $_SESSION['Nom_etudiant'] = $Nom_etudiant;
          if($donnees['Statut_vote']==1){
            //rediriger vers la page de fin
            setLog($_SESSION['id_agent'], $donnees['Id_etudiant'], getIp());
            $reponse->closeCursor();
            echo "<script type='text/javascript'>document.location.replace('end.php');</script>";
          }
          else{
            $_SESSION['matricule_etudiant'] = $_POST['matricule_etudiant'];
            $reponse->closeCursor();
            echo "<script type='text/javascript'>document.location.replace('vote.php');</script>";
          }
        }
      }
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
            <header>Welcome to Ubuntu's voting Website</header>
            
            <form method="post" action="etudiant.php">
                <div class="field">
        
                    <span></span>
                    <input type="text" placeholder="Enter your matricule" name="matricule_etudiant">
                </div>
               <!--  <div class="field space">
                    <span></span>
                    <input type="password" placeholder="Enter your code" name="code_etudiant">

                </div> -->
                <br>
                <div class="field1">
                    <input type="submit" value="submit" >
                </div>
            </form>
    </div>
    </div>
   </body>
</html>