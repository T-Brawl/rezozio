<?php
$USER = "*****";
$PASS = "********";
$HOST = "*****.***.***********.**";
$DBNAME = "*****";

try {
	$bdd = new PDO("pgsql:host={$HOST};dbname={$DBNAME}", $USER, $PASS);
} catch (PDOException $e) {
	echo "ERREUR CONNEXION" . $e->getMessage();
	exit();
}	
?>
