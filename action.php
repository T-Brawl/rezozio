<?php
	include_once("Utilisateur.class.php");
	session_start();
	include_once("header.php");
	include_once("fonctions.php");
	
	switch($_GET['action']) {
		case "connexion":
			$login = htmlentities($_POST['login']);
			$password = htmlentities($_POST['password']);
  		$res = connexion($bdd, $login, $password);
	  	if($res) 
	  		$_SESSION['utilisateur'] = $res;
			header("Location:./");
			break;
		case "deconnexion":
			session_destroy();
			header("Location:./");
			break;
		case "inscription":
			$ident = htmlentities($_POST['ident']);
			$password = htmlentities($_POST['password']);
			$password2 = htmlentities($_POST['password2']);
			if($password == $password2 && $password != "" && $ident != "") {
				$name = htmlentities($_POST['name']);
				if(!isset($name) || $name == "")
					$name = $ident;
				if(isset($_FILES['picture']) && $_FILES['picture']['size'] > 0 && $_FILES['picture']['size'] < 5000000)
					$image = $_FILES['picture'];
				else 
					$image = 0;
					$res = inscription($bdd, $ident, $password, $image, $name); 			  
				  if($res) {
					$_SESSION['utilisateur'] = new Utilisateur($ident, $name);
					echo "<!DOCTYPE html><html xmlns='http://www.w3.org/1999/xhtml' xml:lang='fr' lang='fr'> \n<head>";
					echo "<link rel='stylesheet' type='text/css' href='index.css' />\n<link rel='stylesheet' type='text/css' href='navbar.css' />\n</head>\n";
					echo "<body>\n<header>\n";
					include("navbar.php");
					echo "</header>\n";
					echo "Bienvenue sur Rézozio !\nVous allez être redirigés vers la page d'accueil dans 5 secondes.";
					echo "</body>\n</html>";
			    	header("refresh:5;url=./");
			 		}
	      } else { header("Location:inscription.php?erreur=inscription"); }
			break;
		case "envoi":
			if (isset($_POST['message'])) {
			  $message = htmlspecialchars($_POST['message'], ENT_QUOTES);
				$ident = $_SESSION['utilisateur']->ident();
			  poster($bdd, $message, $ident);
			}
			header("Location:./");
			break;
		case "suivre":
			$id = htmlentities($_GET['id']);
			if($_SESSION['utilisateur']->ident() != $id) {
				if(suit_deja($bdd, $_SESSION['utilisateur']->ident(), $id)) {
					$msg = "Vous suivez déjà l'utilisateur !";
				}
				else {
					suivre($bdd, $_SESSION['utilisateur']->ident(), $id);
					$msg = "Vous suivez désormais $id !";
				}
			}
			header("Location: {$_SERVER['HTTP_REFERER']}");
			break;
		case "ne_plus_suivre":
			$id = htmlentities($_GET['id']);
			if($_SESSION['utilisateur']->ident() != $id) {
				if(suit_deja($bdd, $_SESSION['utilisateur']->ident(), $id)) {
					ne_plus_suivre($bdd, $_SESSION['utilisateur']->ident(), $id);
					$msg = "You have unfollowed a user!";
				}
				else {
					$msg = "Vous ne suivez pas encore cet utilisateur";
				}
			}
			header("Location: {$_SERVER['HTTP_REFERER']}");
			break;
		case "profil":
			$id = htmlentities($_GET['id']);
			header("Location:profil.php?id=$id");
			break;
		case "recherche":
			$recherche = htmlentities($_POST['recherche']);
			header("Location:recherche.php?user=$recherche");
			break;
		case "modification":
		  $user = $_SESSION['utilisateur']->ident();
			if(isset($_POST['name']) && $_POST['name'] != "") {
				$name = htmlentities($_POST['name']);
				$_SESSION['utilisateur']->setName($name);
				modificationName($bdd, $name, $user);				
			}
			if(isset($_FILES['picture']) && ($_FILES['picture']['size'] > 0) && $_FILES['picture']['size'] < 5000000) {
				$picture = $_FILES['picture'];
	  		modificationPicture($bdd, $picture, $user);
			}
			if(isset($_POST['password']) && $_POST['password'] != "" && isset($_POST['password2']) && $_POST['password2'] != "" && isset($_POST['oldpass']) && $_POST['oldpass'] != "") {
				$password = htmlentities($_POST['password']);
				$password2 = htmlentities($_POST['password2']);
				$oldpass = htmlentities($_POST['oldpass']);
				if($password == $password2)
			  	modificationPassword($bdd, $password, $oldpass, $user);				
			}
			header("Location:modification.php");
			default:
	}
?>
