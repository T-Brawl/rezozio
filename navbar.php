<?php
    include_once("Utilisateur.class.php");
    session_start();
    include_once("header.php");
    $connecte = (isset($_SESSION['utilisateur']));
?>

<?php
	if($connecte) {
?>
<nav>
  	<ul>
        <li> <a href="./">Rézozio</a> </li>
        <?php
        $nom = $_SESSION['utilisateur']->name();
        if (strlen($nom) >= 13) {$nom = substr($nom,0,10)."...";}
        echo "<li><a href=\"action.php?action=profil&id=".$_SESSION['utilisateur']->ident()."\">".$nom."</a></li>\n";
        ?>
		<li> <a href='abonnes.php'>Abonnements</a> </li>
        <li class="blanc"> 	</li>
		<li class="formulaire">
            <form id="recherche" action="action.php?action=recherche" method = "POST">
            <input type="text" placeholder="Rechercher un utilisateur" id="recherche" name="recherche" maxlength="20" pattern="[0-9a-zA-Z\-\_]+"></textarea>
            </form> 
        </li>
		<li> <a href="action.php?action=deconnexion">Déconnexion</a> </li>
    </ul>
</nav>
<?php
  }
  else {
?>
<nav>
    <ul>
		<li id="logo"><a href="./">Rézozio</a></li>
		<li id="login" class="formulaire">
			<form action="action.php?action=connexion" method = "POST">
				<input placeholder="Login" type="text" id="login" name="login" />
		      	<input placeholder="Mot de passe" type="password" id="password" name="password" />
		      	<input type="submit" value="Connexion" />
			</form>
		</li>
      	<li class="blanc"></li>
		<li> <a href="inscription.php">Inscription</a> </li>
	</ul>
</nav>
<?php
  }
?>