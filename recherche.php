<?php
	include_once("Utilisateur.class.php");
  session_start();
  include_once("header.php");
  include_once("fonctions.php");
  $connecte = (isset($_SESSION['utilisateur']));
  if ($_GET['page'] > 0)
    $offset = $_GET['page'];
  else
    $offset = 0;
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
	
		<div>
		  <?php
			  $utilisateurs = utilisateurs($bdd,$_GET['user'], $offset*10);
			  if (count($utilisateurs)){
			  echo "<div class='pagination'>\n";
				  if($offset > 0)
		        echo '<div class="left"><a href="recherche.php?user='.$GET['user'].'&page='.($offset-1).'">page précédente</a></div>';
		      if (count($utilisateurs) > 10)
			      echo '<div class="right"><a href="recherche.php?user='.$GET['user'].'&page='.($offset+1).'">page suivante</a></div>';
			      echo "\n</div>\n";
				  echo "<table border='0' cellspacing='0' cellpadding='5' width='500'>";
				  foreach ($utilisateurs as $cle => $valeur) {
		        if($cle < 10) {
					    echo "<tr valign='top'>\n";
					echo "<td><a href=\"action.php?action=profil&id={$valeur->ident()}\"><img src=\"affichageAvatar.php?ident={$valeur->ident()}\"/></a></td>";
					    echo "<td><a href=\"action.php?action=profil&id={$valeur->ident()}\">{$valeur->name()}</a><br/>";
					    echo "<small><a href=\"action.php?action=profil&id={$valeur->ident()}\">{$valeur->ident()}</a></small><br/>\n";
					    if($connecte) {
						    if($_SESSION['utilisateur']->ident() != $valeur->ident()) {
							    if(suit_deja($bdd, $_SESSION['utilisateur']->ident(), $valeur->ident())) {
								    echo "<small><a href=\"action.php?action=ne_plus_suivre&id={$valeur->ident()}\">Désuivre</a>\n";
							    }
							    else {
								    echo "<small><a href=\"action.php?action=suivre&id={$valeur->ident()}\">Suivre</a></small>\n";
							    }
						    }
					    }
					    echo "</td></tr>\n";
				    }
				  }
				  echo "</table>";
			  			  echo "<div class='pagination'>\n";
				if($offset > 0)
		      echo '<div class="left"><a href="recherche.php?user='.$GET['user'].'&page='.($offset-1).'">page précédente</a></div>';
		    if (count($utilisateurs) > 10)
			    echo '<div class="right"><a href="recherche.php?user='.$GET['user'].'&page='.($offset+1).'">page suivante</a></div>';
			    echo "\n</div>\n";}
			  else {
				  echo "<p><b>Aucun utilisateur à afficher!</b></p>";
			  }
		  ?>
		</div>
	</body>
</html>
