<?php
	include_once("Utilisateur.class.php");
  session_start();
  include_once("header.php");
  include_once("fonctions.php");
  $connecte = (isset($_SESSION['utilisateur']));
  
  if ($_GET['page_abo'] > 0)
    $offset_abo = $_GET['page_abo'];
  else
    $offset_abo = 0;
  if ($_GET['page_uti'] > 0)
    $offset_uti = $_GET['page_uti'];
  else
    $offset_uti = 0;
  
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
		  <?php
			  //Barre de navigation
			  include("navbar.php");
      ?>
    </header>
    		
    <?php		
		  if($connecte) {
		    
			  $abonnements = abonnements($bdd, $_SESSION['utilisateur']->ident(), $offset_abo*10);
			  
				if (count($abonnements)){
				  echo "<div>";
				  echo "<h1>Liste de vos abonnements</h1>";
				  echo "<div class='pagination'>\n";
				  if($offset_abo > 0)
		        echo '<div class="left"><a href="abonnes.php?page_abo='.($offset_abo-1).'&page_uti='.($offset_uti).'">page précédente</a></div>';
		      if (count($abonnements) > 10)
			      echo '<div class="right"><a href="abonnes.php?page_abo='.($offset_abo+1).'&page_uti='.($offset_uti).'">page suivante</a></div>';
			      echo "\n</div>\n";
				  echo "<table border='0' cellspacing='0' cellpadding='5' width='500'>";
				  foreach ($abonnements as $cle => $valeur) {
		        if($cle < 10) {
					    if($_SESSION['utilisateur']->ident() != $valeur->ident()) {
						    echo "<tr valign='top'>\n";
						    echo "<td><a href=\"action.php?action=profil&id={$valeur->ident()}\"><img src=\"affichageAvatar.php?ident={$valeur->ident()}\" width=\"100px\"/></a></td>";
						    echo "<td><a href=\"action.php?action=profil&id={$valeur->ident()}\">{$valeur->name()}</a><br/>";
				      		echo "<small><a href=\"action.php?action=profil&id={$valeur->ident()}\">({$valeur->ident()})</a></small><br/>\n";
						    echo "<small><a href=\"action.php?action=ne_plus_suivre&id={$valeur->ident()}\">Ne plus suivre</a></small></td>\n";
						    echo "</tr>\n";
					    }
					  }
				  }
				  echo "</table>";
				  echo "<div class='pagination'>\n";
				  if($offset_abo > 0)
		        echo '<div class="left"><a href="abonnes.php?page_abo='.($offset_abo-1).'&page_uti='.($offset_uti).'">page précédente</a></div>';
		      if (count($abonnements) > 10)
			      echo '<div class="right"><a href="abonnes.php?page_abo='.($offset_abo+1).'&page_uti='.($offset_uti).'">page suivante</a></div>';
			      		echo "\n</div>\n";
				  echo "</div>";
				}
				else {
				  echo "<p><b>Vous n'êtes abonné à personne</b></p>";
				}
		  }
		  echo "<div id=\"utilisateurs\">";
		  echo "<h1>Liste de tous les utilisateurs</h1>";
		  $utilisateurs = utilisateurs($bdd, "", $offset_uti*10);
			if (count($utilisateurs)){
			  echo "<div class='pagination'>\n";
				if($offset_uti > 0)
		      echo '<div class="left"><a href="abonnes.php?page_uti='.($offset_uti-1).'&page_abo='.($offset_abo).'#utilisateurs">page précédente</a></div>';
		    if (count($utilisateurs) > 10)
			    echo '<div class="right"><a href="abonnes.php?page_uti='.($offset_uti+1).'&page_abo='.($offset_abo).'#utilisateurs">page suivante</a></div>';
			    echo "\n</div>\n";
				echo "<table border='0' cellspacing='0' cellpadding='5' width='500'>";
				foreach ($utilisateurs as $cle => $valeur) {
		      if($cle < 10) {
					echo "<tr valign='top'>\n";
					echo "<td><a href=\"action.php?action=profil&id={$valeur->ident()}\"><img src=\"affichageAvatar.php?ident={$valeur->ident()}\"/></a></td>";
					echo "<td><a href=\"action.php?action=profil&id={$valeur->ident()}\">{$valeur->name()}</a><br/>";
					echo "<small><a href=\"action.php?action=profil&id={$valeur->ident()}\">({$valeur->ident()})</a></small><br/>\n";
					if($connecte)
						if($_SESSION['utilisateur']->ident() != $valeur->ident())
							if(suit_deja($bdd, $_SESSION['utilisateur']->ident(), $valeur->ident()))
								echo "<small><a href=\"action.php?action=ne_plus_suivre&id={$valeur->ident()}\">Ne plus suivre</a></small>\n";
							else
								echo "<small><a href=\"action.php?action=suivre&id={$valeur->ident()}\">Suivre</a></small>\n";
					echo "</td></tr>\n";
			    }
				}
				echo "</table>";
			echo "<div class='pagination'>\n";
				if($offset > 0)
		      echo '<div class="left"><a href="abonnes.php?page_uti='.($offset_uti-1).'&page_abo='.($offset_abo).'#utilisateurs">page précédente</a></div>';
		    if (count($utilisateurs) > 10)
			    echo '<div class="right"><a href="abonnes.php?page_uti='.($offset_uti+1).'&page_abo='.($offset_abo).'#utilisateurs">page suivante</a></div>';
			    echo "\n</div>\n";
			}
			else {
				echo "<p><b>Aucun utilisateur à afficher!</b></p>";
			}
			echo "</div>";
		?>
	</body>
</html>
