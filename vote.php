<?php
session_start();


if(!isset($_SESSION['matricule'])  or !isset($_SESSION['code'])){
  echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
  
if($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['Candidat1'])){
  vote(1);
}

if($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['Candidat2'])){
  vote(2);
}

if($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['Disconnect'])){

  Disconnect();
}

function Disconnect(){
  $_SESSION['code'] = Null;

  $_SESSION['id_agent'] = Null;

  $_SESSION['matricule'] = Null;

  $_SESSION['matricule_etudiant'] = Null;

  session_destroy();
  echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}


function vote($choice){
  echo $choice;
  require('param.ini.php');
	try{
      $connection= new PDO($connect_param,$login,$pass);
      
    } 
  catch(Exception $e){
      die('Erreur:' .$e->getMessage());
    }

    $reponse = $connection->query('SELECT * FROM candidats WHERE Id_bureau='.$choice.' ');

  while ($donnees = $reponse->fetch()) {
    if($donnees['Id_bureau']== $choice){
      //incrementer les votes du candidat
      $rqt = $connection->prepare('UPDATE candidats SET vote = :vote WHERE Id_bureau= :id' );
      $rqt->execute(array('vote'=>$donnees['vote']+1, 'id'=>$donnees['Id_bureau']));
  $reponse->closeCursor();

      //changer le champ Satut_vote de la table etudiant
      $rqt = $connection->prepare('UPDATE etudiants SET Statut_vote = :vote WHERE Matricule= :matricule' );
      $rqt->execute(array('vote'=> 1, 'matricule'=>$_SESSION['matricule_etudiant']));
      //header('LOCATION:reine.php');''
      $_SESSION['matricule_etudiant']=NULL;
      $rqt->closeCursor();
      echo "<script type='text/javascript'>document.location.replace('end.php');</script>";
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
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="bg-img">
        <div class="content1">
            <img src="logo.jpg" alt="logo" width="150" height="100" class="center">
            <header>Just a click!!! to vote for your favorite list</header>
            <h2 style="color: white">Identite: <?php if(isset($_SESSION['Nom_etudiant'])) echo $_SESSION['Nom_etudiant'] ?></h2>
            <br>
            <form method="post" action="vote.php">
            <div class="fancy">
                <span></span>
                 <input type="submit" name="Candidat1" value="V10">
            </div>
            <br>
            <div class="fancy">
                <span></span>
                 <input type="submit" name="Candidat2" value="The way up">
            </div>
            <br>
            <br>
            <br>
                <div style="background-color: red">
                    <input type="submit" name="Disconnect" value="Disconnect">
                </div>
            <!-- <div class="fancy space2">
                <input type="submit" value="submit" >
            </div> -->
            
            </form>
            <button id="back" class="">back</button>
    </div>
    </div>
    
</body>




<script type='text/javascript'>

  document.getElementById('back').onclick = function(){
    document.location.replace('etudiant.php');
  };
</script>