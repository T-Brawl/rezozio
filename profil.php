<?php
	include_once("Utilisateur.class.php");
  session_start();
  include_once("header.php");
  include_once("fonctions.php");
  $connecte = (isset($_SESSION['utilisateur']));
  $utilisateur = getUtilisateur($bdd, $_GET['id']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="index.css" />
    <link rel="stylesheet" type="text/css" href="navbar.css" />
    <?php     
      echo "<title>{$utilisateur->name()}</title>\n";
    ?>
  </head>
  <body>
  
    <header>
      <!-- Barre de navigation -->
	  	<?php
	  		include("navbar.php");
	  	?>
    </header>

    <div id="profil">
      <?php
        echo("<img src=\"affichageAvatar.php?ident={$utilisateur->ident()}\"/>");
        echo "<center>\n<h1>\n{$utilisateur->name()}</h1></center>";
	    	echo "<center>\n<h2>\n({$utilisateur->ident()})\n</h2>\n</center>";
        if($connecte) {
      		if ($_SESSION['utilisateur']->ident() != $utilisateur->ident()) {
			      if(suit_deja($bdd, $_SESSION['utilisateur']->ident(), $utilisateur->ident())) {
				      echo " <h3><a href=\"action.php?action=ne_plus_suivre&id={$utilisateur->ident()}\">Ne plus suivre</a></h3>\n";
			      }
			      else {
				      echo " <h3><a href=\"action.php?action=suivre&id={$utilisateur->ident()}\">Suivre</a></h3>\n";
			      }
		      }
		      else {
		        echo "<h3><a href=\"modification.php\">Modification</a></h3>";
		      }
        }
	    ?>
    </div>
	
		<div>
	    <?php
        //MESSAGES
      	if ($_GET['page'] > 0) {
      		$offset = $_GET['page'];
      	}
      	else {
		      $offset = 0;
		    }
	      $utilisateurs = array(getUtilisateur($bdd, $_GET['id']));
	      $messages = messages($bdd, $utilisateurs, $offset*10);
		    
	      if (count($messages)){
	       echo "<div class='pagination'>\n";
		      if($offset > 0)
		        echo '<div class="left"><a href="profil.php?id='.($utilisateur->ident()).'&page='.($offset-1).'" style="text-align:left">page précédente</a></div>';
		      if (count($messages) > 10)
			      echo '<div class="right"><a href="profil.php?id='.($utilisateur->ident()).'&page='.($offset+1).'" style="text-align:right">page suivante</a></div>';
					echo "\n</div>\n";  
	        if ($nbMsg-(($offset+1)*10) > 0)
		        echo '<a href="./?page='.($offset+1).'">page suivante</a>';
	        setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
	        echo "<div id='messages'>\n<table border='0' cellspacing='0' cellpadding='5' width='500'>";
	        foreach ($messages as $cle => $elt){
		        echo "<tr valign='top'>\n";
		        echo "<td><a href=\"action.php?action=profil&id={$elt['author']->ident()}\"><img src=\"affichageAvatar.php?ident={$elt['author']->ident()}\"/></a></td>";
		        echo "<td><a href=\"action.php?action=profil&id={$elt['author']->ident()}\">".$elt['author']->name() ."</a><br/>\n";
			      echo "<small><a href=\"action.php?action=profil&id={$elt['author']->ident()}\">". $elt['author']->ident() ."\n</a></small>";			
		        echo "</td>";
		        echo "<td>".$elt['content'] ."<br/>\n";
		        echo "<small>".strftime("%A %d %B %Y à %X",strtotime($elt['date'])) ."</small></td>\n";
		        echo "</tr>\n";
		      }
		      echo "</table>\n</div>";
		      		    echo "<div class='pagination'>\n";
		      if($offset > 0)
		        echo '<div class="left"><a href="profil.php?id='.($utilisateur->ident()).'&page='.($offset-1).'" style="text-align:left">page précédente</a></div>';
		      if (count($messages) > 10)
			      echo '<div class="right"><a href="profil.php?id='.($utilisateur->ident()).'&page='.($offset+1).'" style="text-align:right">page suivante</a></div>';
					echo "\n</div>\n";  
	      }
	      else {
		      echo "<p><b>Aucun message à afficher</b></p>";
	      }
	    ?>
    </div>
  </body>
</html>
