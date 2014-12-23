<?php
	session_start();
	include("header.php");
 	header("Content-Type : $mimetype");
	$requete = $bdd->prepare("select mimetype, picture from users where ident='{$_GET['ident']}'");
	$requete->execute();
 	$requete->bindColumn('mimetype', $mimetype);
 	$requete->bindColumn('picture', $flux, PDO::PARAM_LOB);
	$requete->fetch();
	fpassthru($flux);
?>
