<?php

session_start();
require('param.ini.php');
require('security.php');

try{
      $connection= new PDO($connect_param,$login,$pass);
      
    } 
  catch(Exception $e){
      die('Erreur:' .$e->getMessage());
    }
 $reponse = $connection->query('SELECT etat_vote FROM admin ');
// print_r($reponse->fetch()['etat_vote']) ;
 $donnee = $reponse->fetch()['etat_vote'];
 $reponse->closeCursor();
 if($donnee%2 == 0){
 	$activation = "Turn On the vote";
 	$etat = "The vote is off";
 }
 else{
 	$activation = "Turn Off the vote";
 	$etat = "The vote is on";
 }

 if($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['pass'])){

	//ChangeVoteState($_POST['pass']);
	$reponse = $connection->query('SELECT * FROM admin ');
	$don =  $reponse->fetch();
	if($_POST['pass'] == $don['Password']){
		setLog(-1, -1, getIp());
		$rqt = $connection->prepare('UPDATE admin SET etat_vote = :etat_vote ' );
      $rqt->execute(array('etat_vote'=> $don['etat_vote'] + 1));
      toogleActivation($activation);
	}

}

// function ChangeVoteState($pass){

// }
function toogleActivation($activation){
	if($activation == "Turn On the vote"){
		$activation = "Turn Off the vote";
	 	$etat = "The vote is on";
	}
	else{
		$activation = "Turn On the vote";
	 	$etat = "The vote is off";
	}
	echo "<script type='text/javascript'>document.location.replace('openVote.php');</script>";
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>OpenVote</title>
</head>
<body>
	<form method="post" action="openVote.php">
		<input type="password" name="pass">
		<input type="submit" name="" value ="<?php echo $activation ?>" >
		<p><?php echo $etat;  ?></p>
		
	</form>

</body>
</html>