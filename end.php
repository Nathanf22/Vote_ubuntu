<?php
session_start();


if(!isset($_SESSION['matricule'])  or !isset($_SESSION['code'])){
    echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}

if($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['New_vote'])){

	New_vote();
}

if($_SERVER['REQUEST_METHOD']=="POST" and isset($_POST['Disconnect'])){

	Disconnect();
}

function New_vote(){
	$_SESSION['matricule_etudiant'] = Null;
	echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}

function Disconnect(){
	$_SESSION['code'] = Null;

	$_SESSION['matricule'] = Null;

	$_SESSION['matricule_etudiant'] = Null;

	session_destroy();
	echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de vote Ubuntu</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <div class="bg-img">
        <div class="content">
            <img src="logo.jpg" alt="logo" width="150" height="100" class="center">
            <header>Thankyou for voting</header>  
            <form method="POST" action="end.php"> 
            	<div class="field">
            		<input type="submit" name="New_vote" value="New vote"/>
            	</div>
                <br>
                <div class="field">
                    <input type="submit" name="Disconnect" value="Disconnect">
                </div>
    </div>
   
    </div>
   </body>
</html>