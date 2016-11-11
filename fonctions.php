<?php
	include_once("Utilisateur.class.php");
	
	function getUtilisateur ($bdd, $ident) {
		$res = $bdd->prepare(
			"select ident, name from users
				where ident=:ident"
		);
		$res->execute(array(':ident' => $ident));
		$utilisateur = NULL;
		if($res) {
			$data = $res->fetch();
			$utilisateur = new Utilisateur($data['ident'], $data['name']);
		}
		return $utilisateur;
	}		
	
	function connexion ($bdd, $login, $password) {
		$password = sha1($password."motenpluspourcompliquerlecryptage");
		$res = $bdd->prepare(
			"select ident, name from users
				where ident=:ident and password=:password"
		);
		$res->execute(array(':ident' => $login, ':password' => $password));
		$utilisateur = NULL;
		if($res) {
			$data = $res->fetch();
			if($data['ident'] != "" && $data['name'] != "")
			$utilisateur = new Utilisateur($data['ident'], $data['name']);
		}
		return $utilisateur;
	}
			

	function inscription ($bdd, $ident, $password, $image, $nom) {
		$res = $bdd->prepare(
		  "select count (ident) as nb from users 
			  where ident = :ident"
		);
		$res->execute(array(':ident' => $ident));
		if(($num = $res->fetch()) && ($num['nb'] != 0)) {
			return false;
		}
		else {
			if($image) {
				$flux = fopen($image['tmp_name'],'r');
				$type = $image['type'];
			}
			else {
				$flux = fopen('lib/genericAvatar.png', 'r');
				$type = "image/png";
			}
			$password = sha1($password."motenpluspourcompliquerlecryptage");
			$insertion =  $bdd->prepare(
				"insert into users
					values ('$ident','$password','$nom', :picture, :mimetype)"
			);
			$insertion->bindValue(':picture', $flux, PDO::PARAM_LOB );
			$insertion->bindValue(':mimetype', $type);
			$insertion->execute();
			suivre($bdd,$ident,$ident);
			return true;
		}
	}		
		
	function poster($bdd, $message, $ident) {
		$imax= strlen($message);
		$i = 0;
		$res = "";
		$tmp = "";
		$dejaunlien = false;
		while ($i < $imax) {
			if ($message[$i] == '{' && !$dejaunlien) {
				$dejaunlien = true;
				$i++;
				while($i < $imax && $message[$i] != '}') {
					$tmp = $tmp.$message[$i];
					$i++;
				}
				if($message[$i] == '}') {
					if(substr($tmp,0,4) != "http" )
						$res = $res.'<a href="http://'.$tmp.'">'.$tmp.'</a>';
					else
						$res = $res.'<a href="'.$tmp.'">'.$tmp.'</a>';
					$i++;
				}
				else {
					$res = $res.'{'.$tmp;
				}
			}
			else {
				$res = $res.$message[$i];
			  $i++;
			}				
		}
		$req = $bdd->prepare(
				"insert into messages (content, author)
					values (:res,:ident)"
		);
		$req->execute(array(':res' => $res, ':ident' => $ident));
	}
		
		
	function messages($bdd, $abonnements, $offset = 0) {
		$posts = array();
		$abo_string = "";
		foreach($abonnements as $cle => $valeur) {
			$abo_string = $abo_string."'".$valeur->ident()."',"; 
		}
		$abo_string[strlen($abo_string) - 1] = ")";
		$res = $bdd->query(
		"select * from messages 
		    where author in ($abo_string
		    order by date desc 
		    limit 11 offset $offset"
		);
		if($res) {
			while($data = $res->fetch()) {
				$posts[] = array( 	'date' => $data['date'], 
			                    'author' => getUtilisateur($bdd, $data['author']), 
			                   'content' => $data['content']
				);
			}
	  	}
		return $posts;
	}
	
	function utilisateurs($bdd, $recherche = "", $offset = 0) {
	  if($offset == 0)
	    $extra = "";
	  else
	    $extra = "limit 11 offset $offset";
		$utilisateurs = array();
		$res = $bdd->query(
			"select ident, name from users
				where ident ILIKE '%$recherche%' or name ILIKE '%$recherche%'
				order by name
		    $extra"
		);
		if($res) {
			while ($data = $res->fetch()){
				$utilisateurs[] = new Utilisateur($data['ident'], $data['name']); 
			}
		}
		return $utilisateurs;
	}
	
	
	function abonnements($bdd, $utilisateur, $offset = 0) {
	  if($offset == 0)
	    $extra = "";
	  else
	    $extra = "limit 11 offset $offset";
	  $abonnements = array();
	  $res = $bdd->query(
	    "select author from follow
			  where follower = '$utilisateur'
			  $extra"
	  );
	  while($data = $res->fetch()) {
		  array_push($abonnements, getUtilisateur($bdd, $data['author']));
	  }
	  return $abonnements;
	}
	
	
	function abonnes($bdd, $utilisateur, $offset = 0) {
	  if($offset == 0)
	    $extra = "";
	  else
	    $extra = "limit 11 offset $offset";
	  $abonnes = array();
	  $res = $bdd->query(
	    "select follower from follow
			  where author = '$utilisateur'
		    $extra"
	  );
	  while($data = $res->fetch()){
		  array_push($abonnes, getUtilisateur($bdd, $data['follower']));
	  }
	  return $abonnes;
	}
	
	
	function suit_deja($bdd, $u1, $u2) {
		$res = $bdd->prepare(
			"select count(*) from follow
				where author=:u2 and follower=:u1"
			);
		$res->execute(array(':u2' => $u2, ':u1' => $u1));
		$ligne = $res->fetch();
		return $ligne[0] > 0;
	}		
	
	
	function suivre($bdd, $u1, $u2) {
		$res = $bdd->prepare(
		  "insert into follow (author, follower) 
			  values (:u2,:u1)"
		);
		$res->execute(array(':u2' => $u2, ':u1' => $u1));
		return ;
	}
	
		
	function ne_plus_suivre($bdd, $u1, $u2) {
		$res = $bdd->prepare(
		  "delete from follow
				where author=:u2 and follower=:u1"
		);
		$res->execute(array(':u2' => $u2, ':u1' => $u1));
		return ;
	}
	
	function modificationName($bdd, $name, $user) {
		if ($name != "") {
			$res = $bdd->prepare(
			  "update users set name=:name
			    where ident=:user
			");
			$res->execute(array(':name' => $name, ':user' => $user));
		}
	}
	  
	function modificationPicture($bdd, $picture, $user) {
		if ($picture) {
			$flux = fopen($picture['tmp_name'],'r');
			$type = $picture['type'];
			$insertion =  $bdd->prepare(
				"update users set picture=:picture, mimetype=:mimetype
					where ident='$user'"
			);
			$insertion->bindValue(':picture', $flux, PDO::PARAM_LOB );
			$insertion->bindValue(':mimetype', $type);
			$insertion->execute();
		}
	}
	
	function modificationPassword($bdd, $password, $oldpass, $user) {
		if ($password != "" && $oldpass != "") {
			$password = sha1($password."motenpluspourcompliquerlecryptage");
			$oldpass = sha1($oldpass."motenpluspourcompliquerlecryptage");
			$res = $bdd->prepare(
			  "update users set password=:password
			    where ident=:user and password=:oldpass
			");
			$res->execute(array(':password' => $password, ':user' => $user, ':oldpass' => $oldpass));
		}
	}
?>
