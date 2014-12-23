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
    <title>Rézozio</title>
  </head>
	<body>
	  <header>
			<!-- Barre de navigation -->
		  <?php
			  include("navbar.php");
		  ?>
	  </header>
		
		<?php
			if ($connecte) {
				echo "Vous êtes déjà connecté !";
			}
			else {
				?>
		    <div id="inscription">
				<fieldset>
				<?php if (isset($_GET['erreur']) && $_GET['erreur'] == "inscription") {echo "Inscription impossible." ;} ?>
				  <form action="action.php?action=inscription" method = "POST" enctype="multipart/form-data">
					  <label for="ident">Identifiant : </label><input placeholder="Identifiant" type="text" id="ident" name="ident" maxlength="20" pattern="[0-9a-zA-Z\-\_]+"/><br/>
					  <label for="password">Mot de passe : </label><input type="password" placeholder="Mot de passe" id="mdp" name="password" pattern="[0-9a-zA-Z\-\_]+"/><br/>
					  <label for="password">Vérification du mot de passe : </label><input type="password" placeholder="Vérification du mot de passe" id="mdp2" name="password2" pattern="[0-9a-zA-Z\-\_]+" onkeyup="mememdp(); return false;"/><br/>
					  <label for="name">(facultatif) Nom du compte : </label><input placeholder="Nom du compte" type="text" id="name" name="name" pattern="[a-zA-Z0-9\-\_]+"/><br/>
					  <label for="picture">(facultatif) Image : </label><input type="file" name="picture" /><br/>
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
