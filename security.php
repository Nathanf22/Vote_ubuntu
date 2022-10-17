<?php

function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;}

function getMac(){
	// ob_start();
	// system(‘ipconfig /all’);
	// $mycom=ob_get_contents(); //enregistre la sortie de ‘system’
	// ob_clean();
	// $findme = « Physical »;
	// $pos = strpos($mycom, $findme);
	// $macp=substr($mycom,($pos+36),17);
	// echo « L’adresse MAC est  : ».$macp;
}


function setLog($Id_agent, $Id_etudiant, $Ip){
	require('param.ini.php');
	try{
      $connection= new PDO($connect_param,$login,$pass);
      
    } 
  catch(Exception $e){
      die('Erreur:' .$e->getMessage());
    }

    $req = $connection -> prepare('INSERT INTO `log`( `Id_agent`, `Id_Etudiant`, `Adresse_Ip`) VALUES (:Id_agent, :Id_etudiant, :Ip)');
    $req->execute(array('Id_agent'=> $Id_agent, 'Id_etudiant'=>$Id_etudiant, 'Ip'=>$Ip));

    $req->closeCursor();
}


?>