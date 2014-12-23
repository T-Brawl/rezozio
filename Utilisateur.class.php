<?php
class Utilisateur {

  //Attributs de la classe Utilisateur
	 private $ident;
	 private $name;
	 
  //Méthodes de la classe Utilisateur

  //Constructeur de la classe Utilisateur
	 function __construct($ident, $name) {
	 	$this->ident = $ident;
		$this->name = $name;
	}
	 
  // Retourne l'identifiant
	 public function ident() {
	 	return $this->ident;
	}
  
  // Retourne le nom
	 public function name() {
	 	return $this->name;
	}
	
	// Modifie le nom de l'utilisateur
	public function setName($name) {
		$this->name = $name;
	}
}
?>
