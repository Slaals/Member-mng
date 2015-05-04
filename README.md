Symfony Standard Edition
========================
Je vais expliquer dans ce fichiers mes choix pour concevoir cet outil, je commencerais par expliquer les bundles et le routage, ensuite je pousuivrais par une description des entités et de leurs relations, des controleurs et de leurs méthodes puis finirais par le détail des vues.

Bundle
------------------------
#### UserBundle
Bundle comportant tous les outils permettant l'authentification et l'enregistrement d'un utilisateur.

#### MemberBundle
Bundle comportant tous les outils permettant la gestion d'un membre, c'est à dire ses informations ainsi que ses contacts.

Routage
------------------------
#### app/config/routing.yml
- Préfixage par */home* sur la route de MemberBundle, laisse au parefeu la possibilité de ne laisser l'accès qu'aux personnes authentifiées très simplement, sur le chemin *^/home*
- Ajout de la ressource via *user_bundle* reconnu par FOSUserBundle, permet de localiser les routes dans la configuration de *UserBundle*.

#### UserBundle/config/routing.yml
- **fos_user** : toutes les routes standards de FOSUserBundle
- **login** : login sur la racine */*, obligation d'être authentifié pour accéder au site
- **registration** : appelle le controlleur redéfini par *UserBundle/Controller/Registration*

#### MemberBundle/config/routing.yml
- **home** : représente la page d'accueil, informations du membre connecté
- **edit** : représente la page d'édition des informations du membre connecté
- **view** : représente la page d'un membre qu'un membre connecté consulte
- **contact** : représente le carnet de contacts
- **delete** : représente la page de suppression d'un contact

Entités et relations
------------------------
#### UserBundle\Entity\User
Etend *BaseUser* de FOSUserBundle, entité qui inclut alors tous les attributs de *BaseUser*, permet à l'authentifiation d'un utilisateur.

#### MemberBundle\Entity\Member
Entité qui a une réprésentation plus concrète des informations d'un membre, un utilisateur enregistré étant un membre il existe une relation **OneToOne** sur l'attribut *user*. L'attribut name de *membre* est indépendant de l'attribut *username* de *User*, un membre peut alors choisir un nom différent de son nom d'utilisateur.

#### MemberBundle\Entity\Contact
*Member* est une relation **ManyToOne** sur *Member*, *contact* est une relation **ManyToOne** sur *Member*, lie des membres entres eux pour définir leur(s) contact(s).

Controlleurs
------------------------
#### UserBundle\Controller\Registration
Redéfinition de l'enregistrement d'utilisateur de FOSBundle, *BaseController*. Permet l'ajout d'un membre à la création d'un utilisateur (*User -> Member*)

#### UserBundle\Controller\Secutiry
Authentification de l'utilisateur.

#### MemberBundle\Controller\Profile
Toutes les actions relatives à la gestion d'un membre
- **home** : informations du membre connecté
- **contact** : liste de contact du membre connecté
- **view** : informations d'un membre consulté
- **edit** : édition des informations du membre connecté
- **deleteContact** : suppression d'un contact

Vues
------------------------
Principe du triple héritage : _::layout.html.twig_ est étendu par _[Bundle]::layout.html.twig_ est étendu par toutes les vues de [Bundle]

#### ::layout.html.twig
Comporte le header avec les inclusions css et js. Défini les bloques principaux.

#### MemberBundle::layout.html.twig
Vue principale de la gestion de membre. Incluant la barre de navigation et la liste des contacts. Défini le bloque *content* qui est le contenu.

#### MemberBundle:Profile:contact
Liste des contacts avec le formulaire d'ajout et les références pour supprimer un contact ou consulter son profil.

#### MemberBundle:Pofile:index
Home, appelle les informations d'un membre. Affiche les erreurs.

#### MemberBundle:Profile:infos
Formatage des informations d'un membre.

#### MemberBundle:Profile:editInfos et MemberBundle:Profile:memberform
Affichage du formulaire pour l'édition d'informations. Séparation du formulaire de l'édition dans l'optique de le réutiliser.

Remarques personnelles
------------------------
Créer un controlleur pour la gestion des contacts aurait été judicieux, avec les actions : add, delete, view.

Il aurait été intéressant de combiner le formulaire d'inscription générique de FOSUser et le formulaire sur les informations du membre, MemberType. Ainsi un utilisateur pourrait renseigner ses informations personnelles en même temps que l'inscription.

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.



Enjoy!

[1]:  http://symfony.com/doc/2.6/book/installation.html
[6]:  http://symfony.com/doc/2.6/bundles/SensioFrameworkExtraBundle/index.html
[7]:  http://symfony.com/doc/2.6/book/doctrine.html
[8]:  http://symfony.com/doc/2.6/book/templating.html
[9]:  http://symfony.com/doc/2.6/book/security.html
[10]: http://symfony.com/doc/2.6/cookbook/email.html
[11]: http://symfony.com/doc/2.6/cookbook/logging/monolog.html
[12]: http://symfony.com/doc/2.6/cookbook/assetic/asset_management.html
[13]: http://symfony.com/doc/2.6/bundles/SensioGeneratorBundle/index.html
