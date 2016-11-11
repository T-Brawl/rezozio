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
	  
	<!-- Ecriture du message -->
	<?php
		if($connecte) {
			echo "<div>";
			echo "<table id=\"ecriture\" border='0' cellspacing='0' cellpadding='5' width='500'>";
			echo "<tr valign='top'>\n";
			echo "<td><a href=\"action.php?action=profil&id={$_SESSION['utilisateur']->ident()}\"><img src=\"affichageAvatar.php?ident={$_SESSION['utilisateur']->ident()}\"/></a></td>";
			echo "<td><a href=\"action.php?action=profil&id={$_SESSION['utilisateur']->ident()}\">". $_SESSION['utilisateur']->name() ."\n</a><br/>";
			echo "<small><a href=\"action.php?action=profil&id={$_SESSION['utilisateur']->ident()}\">(". $_SESSION['utilisateur']->ident() .")\n</a></small>";			
	?>  
			</td>
			<td>
				<fieldset>
					<form id="msg" action="action.php?action=envoi" method = "POST">
						<span>
							<textarea placeholder="Tapez le message. La touche Entrée valide automatiquement le message. Pour un lien, entrez-le entre crochets ; par exemple {monurl.fr}" id="message" name="message" cols="35" rows="4" maxlength="140"></textarea><br/>
							<span id="cpt"> <text id="value">140</text>	</span>
						</span>
						<button type="reset" id="effacer">Effacer</button>
						<button type="submit" name="valid" value="envoyer" id="envoyer">Envoyer</button>
					</form>
				</fieldset>
			</td>
		</tr>
	</table>
</div>
	<?php
		}
	?>
		
	<?php
	if ($_GET['page'] > 0) {
		$offset = $_GET['page'];
	} else {
		$offset = 0;
	}

	if($connecte) {
		$abonnements = abonnements($bdd, $_SESSION['utilisateur']->ident());
		$messages = messages($bdd, $abonnements, $offset*10);
	} else {
		$utilisateurs = utilisateurs($bdd);
		$messages = messages($bdd, $utilisateurs, $offset*10);
	}

	//Affichage des messages 
	if (count($messages)) {
		echo "<div id='messages'>\n<table border='0' cellspacing='0' cellpadding='5' width='500'>\n";
		echo "<div class='pagination'>\n";
		if($offset > 0) echo '<div class="left"><a href="./?page='.($offset-1).'">page précédente</a></div>';
		if (count($messages) > 10) echo '<div class="right"><a href="./?page='.($offset+1).'">page suivante</a></div>';
		echo "\n</div>\n";   
		setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
		foreach ($messages as $cle => $elt) {
			if($cle < 10) {
				echo "<tr valign='top'>\n";
				echo "<td><a href=\"action.php?action=profil&id={$elt['author']->ident()}\"><img src=\"affichageAvatar.php?ident={$elt['author']->ident()}\" /></a></td>";
				echo "<td><a href=\"action.php?action=profil&id={$elt['author']->ident()}\">". $elt['author']->name() ."\n</a><br/>";
				echo "<small><a href=\"action.php?action=profil&id={$elt['author']->ident()}\">(". $elt['author']->ident() .")\n</a></small><br/>";	 
				if($connecte) {
					if($_SESSION['utilisateur']->ident() != $elt['author']->ident()) {
						if(suit_deja($bdd, $_SESSION['utilisateur']->ident(), $elt['author']->ident())) 
							echo "<small><a href=\"action.php?action=ne_plus_suivre&id={$elt['author']->ident()}\">Ne plus suivre</a>\n";
						else 
							echo "<small><a href=\"action.php?action=suivre&id={$elt['author']->ident()}\">Suivre</a></small>\n";
					}
				}
				echo "</td>";
				echo "<td>".$elt['content']."<br/>\n";
				echo "<small>".strftime("%A %d %B %Y à %X",strtotime($elt['date'])) ."</small></td>\n";
				echo "</tr>\n";
			}
		}
		echo "</table>\n";
		echo "<div class='pagination'>\n";
		if($offset > 0)	echo '<div class="left"><a href="./?page='.($offset-1).'">page précédente</a></div>';
		if (count($messages) > 10) echo '<div class="right"><a href="./?page='.($offset+1).'">page suivante</a></div>';
		echo "\n</div>\n";
		echo "</div>\n";
	} else {
		echo "<p><b>Aucun message à afficher</b></p>\n";
	}
	?>
<script type="text/javascript" src="index.js"></script> 
</body>
</html>
