<?php
	include_once("Utilisateur.class.php");
  session_start();
  include_once("header.php");
  include_once("fonctions.php");
  $connecte = (isset($_SESSION['utilisateur']));
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="index.css" />
    <link rel="stylesheet" type="text/css" href="navbar.css" />
    <?php     
      echo "<title>{$_GET['id']}</title>\n";
    ?>
  </head>
  <body>
    
    <header>
    	<!-- Barre de navigation -->
		  <?php
			  include("navbar.php");
		  ?>
    </header>
    
	    <?php
		    if(!$connecte) {
			    echo "Vous n'êtes pas connecté !";
		    }
		    else {
		      echo("<div id=\"profil\">");
			    echo("<img src=\"affichageAvatar.php?ident={$_SESSION['utilisateur']->ident()}\"/>");
			    echo("<center>\n<h1>\n{$_SESSION['utilisateur']->name()}\n</h1>\n</center>");
			    echo("<center>\n<h2>\n({$_SESSION['utilisateur']->ident()})\n</h2>\n</center>");
			    echo("</div>\n");
		    }
		  ?>
	  <?php
		  if($connecte) {
		?>
		  <div id="modification">
		    <center><p>Modifiez vos données en remplissant<br/>les champs qui vous intéressent :</p></center>
			  <fieldset>
				<form action="action.php?action=modification" method = "POST" enctype="multipart/form-data">
					<label for="name">Nouveau nom : </label><input placeholder="Nouveau nom" type="text" id="name" name="name" pattern="[a-zA-Z0-9\-\_]+"/><br/>
				  <label for="password">Ancien mot de passe : </label><input type="password" placeholder="Ancien mot de passe" id="oldmdp" name="oldpass" pattern="[0-9a-zA-Z\-\_]+"/><br/>
				  <label for="password">Mot de passe : </label><input type="password" placeholder="Mot de passe" id="mdp" name="password" pattern="[0-9a-zA-Z\-\_]+"/><br/>
				  <label for="password">Vérification du mot de passe : </label><input type="password" placeholder="Vérification du mot de passe" id="mdp2" name="password2" pattern="[0-9a-zA-Z\-\_]+" onkeyup="mememdp(); return false;"/><br/>
					<label for="picture">Nouvelle image : </label><input type="file" name="picture" /><br/>
					<input id="envoi" type="submit" value="Valider" />
				</form>
		    </fieldset>
		  </div>
		  <script type="text/javascript" src="validationmotdepasse.js"></script>
		<?php
		  } 
		?>
  </body>
</html>
