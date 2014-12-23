1.Thème du projet

Le Rézozio est un site qui permet aux internautes de publier de courts messages. Il leur permet de consulter les messages publiés par les autres et de « s’abonner » pour suivre plus facilement les publications d’internautes de leur choix.

2.Description fonctionnelle

N'importe qui peut consulter le site Rézozio. Par contre pour y écrire un message, il faut se connecter et donc disposer d'un compte (protégé par mot de passe). Chaque utilisateur enregistré possède un identifiant, un nom et un avatar.

2.1 Consultation en mode non connecté

La page d'accueil du site présente la liste des messages publiés par tous les utilisateurs, selon le principe décrit dans la rubrique «Affichage d'une liste de messages».

Il faudra prévoir un dispositif permettant de se connecter, et un autre pour créer un compte.

2.2 Consultation en mode connecté

La page d'accueil du site présente la liste des messages publiés par l'usager connecté et par les auteurs auquel il est abonné , selon le principe décrit dans la rubrique «Affichage d'une liste de messages».

Il faudra prévoir des dispositifs permettant de :
- créer et envoyer un message
- consulter et gérer la liste de ses abonnements
- rechercher un autre usager à partir de son nom ou de son identifiant
- gérer ses infos personnelles (nom, avatar)
- se déconnecter

2.3 Affichage d'une liste de messages

Les messages sont toujours publiés par date de publication (de la plus récente à la plus ancienne) et par tranche de 10 messages maximum ; il est proposé une commande (lien, bouton...) permettant d’en afficher 10 de plus.

L’affichage de chaque message comporte le nom, l’identifiant et l’avatar de son auteur. Il comporte également la date et heure de publication du message. Le nom et l’identifiant sont cliquables : un clic entraîne la visualisation de la liste des messages publiés par cette personne.

Quand un auteur n'a pas d'avatar, l'avatar générique est utilisé.

En mode connecté, la liste des messages d'un auteur est précédée d'un bouton permettant de s'abonner ou de se désabonner.

2.4 Création de messages

La longueur maximale des messages envoyés est de 140 caractères. Un message est constitué par du texte simple, à une exception près : il peut contenir au maximum une URL que l’auteur doit faire figurer au sein d'accolades, comme par exemple {www.github.com}. Lors de l’affichage du message, cette URL sera transformée en un véritable lien cliquable, et les accolades ne sont pas affichées. Si le message comporte plusieurs zones entre accolades, seule la première est traitée comme une URL, les autres (accolades incluses) sont considérés comme du texte normal. Une zone commençant par une accolade ouvrante et qui ne comporterait pas d'accolade fermante est également à traiter comme une zone de texte normal. Une fois publié, un message ne peut être effacé ni modifié.

2.5 Recherche de personnes

En mode connecté, une zone de texte permet de rechercher des personnes. Le texte entré est recherché parmi les noms ET les identifiants des utilisateurs enregistrés. Il en résulte une liste de personnes. En cliquant sur un nom ou un identifiant on accède à la “page” de la personne (liste de ses publications).

2.6 Inscription et gestion du compte

À l’inscription, l’utilisateur doit fournir un identifiant (composé de lettres et/ou chiffres, sans espace) et un mot de passe. Par défaut le nom de l’utilisateur est identique à son identifiant. Un utilisateur déjà enregistré et connecté dispose d’une page de gestion lui permettant de modifier son nom et son avatar.
