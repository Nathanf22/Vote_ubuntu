
<script type="text/javascript">
	var pass = prompt('confirmez la reinitialisation');
	if(pass!='pass'){
		document.location.replace('index.php');
	}
</script>


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

//reset the candidates vote
 setLog(-3, -3, getIp());
 $rqt = $connection->prepare('UPDATE candidats SET vote = :vote WHERE 1'  );
 $rqt->execute(array('vote'=>0));
 $rqt->closeCursor();
//reset the student fields
 $rqt = $connection->prepare('UPDATE etudiants SET Statut_vote = :vote WHERE 1' );
 $rqt->execute(array('vote'=>0));
 $rqt->closeCursor();
 //reset the admin table
 $rqt = $connection->prepare('UPDATE admin SET etat_vote = :vote WHERE 1'  );
 $rqt->execute(array('vote'=>0));
 $rqt->closeCursor();


?>







<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>