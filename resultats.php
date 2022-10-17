
<script type="text/javascript">
	var pass = prompt('confirmez la reinitialisation');
	if(pass!='CTOUBUNTU2K22'){
		document.location.replace('index.php');
	}
</script>




<?php

require('param.ini.php');
require('security.php');


	try{
     // $connection= new PDO('mysql:host=localhost;dbname=vote_ubuntu', 'root', '' );
     $connection = new PDO ($connect_param,$login,$pass);
      
    } 
  catch(Exception $e){
      die('Erreur:' .$e->getMessage());


    }

    $nb_vote1 = 0;
    $nb_vote2 = 0;

    $reponse = $connection->query('SELECT * FROM candidats ');
    $rep = $connection->query('SELECT etat_vote FROM admin ');
    $etat_vote = $rep->fetch()['etat_vote'];
    if($etat_vote%2==1){
    	//vote are open
       echo "<script type='text/javascript'>document.location.replace('index.php');</script>";

    }
    setLog(-2, -2, getIp());



    while ($donnees = $reponse->fetch()){
    	if($donnees['Id_bureau'] == 1){
    		$nb_vote1 = $donnees['vote'];
    	}
    	if($donnees['Id_bureau'] == 2){
    		$nb_vote2 = $donnees['vote'];
    	}
    }
if($nb_vote1!=0 and $nb_vote2!=0){
	$V10Percent =  $nb_vote1 * 100 / ($nb_vote1 + $nb_vote2);
	$V10Percent = round($V10Percent, 2);
   $WayUpPercent =  $nb_vote2 * 100 / ($nb_vote1 + $nb_vote2);
   $WayUpPercent = round($WayUpPercent,2);
}
   if($nb_vote1==0){
   	$V10Percent = 0;
   }

    if($nb_vote2==0){
   	$WayUpPercent = 0;
   }
?>







<!DOCTYPE html>
<html>
  <head>
    <title>Resultats du vote</title>
    <style type="text/css">
      html { height: 100%; font-family: sans-serif; }
      body { margin: 0; height: 100%; }
      .row{
        display: flex;
        height: 100%;
      }
      .col{
        flex: 1;

      }
      .percent{
      	font-size: 500%;
      }
      #timer {
        margin: 0;
        width: 50%;
        height: 100%;
        vertical-align: middle;
        text-align: center;
        display: block;
        font-size: 900%;
      }
      #timer2 {
        margin: 0;
        width: 50%;
        height: 100%;
        vertical-align: middle;
        text-align: center;
        display: block;
        font-size: 900%;
      }

      #timer:hover {
        cursor: pointer !important;
      }

      #timer2:hover {
        cursor: pointer !important;
      }


      #timer      { color: #eee; background-color:  #7F00FF; }
      #timer.warn { color: #f33; background-color: #000; }
      #timer.done { color: #000; background-color: #f33; }

      #timer2      { color: #eee; background-color: #0080ff; }
      #timer2.warn { color: #f33; background-color: #000; }
      #timer2.done { color: #000; background-color: #f33; }

    </style>
  </head>
  <body>
    <div class = "row" >
    <!-- <div id="timer" class="col">
    	<p>V10</p>
    	<p class="percent"><?php if(isset($V10Percent))  echo $V10Percent  ?> %</p>
    </div> 
    <div id="timer2" class="col">
    	<p>THE WAY UP</p>
    </div> -->
    <p id="timer" class = "col">V10 <br><br><?php if(isset($V10Percent))  echo $V10Percent  ?> %</p>
    <p id="timer2" class="col">THE WAY UP <br> <?php if(isset($WayUpPercent)) echo $WayUpPercent  ?> %</p>
    </div>

  </body>
</html>
