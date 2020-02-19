# OhMonCoin
### Projet de Web1 de 2ème année de DUT

L'objectf était de développer un clone du site Leboncoin avec certaines fonctionnalités imposées parmis lesquelles :
- Un système de gestion utilisateur qui permet 
    - de créer un compte 
    - de se connecter avec ses identifiants
    - d'avoir accès à un espace personnel
    - de mettre à jour ses informations personnelles
- Un système d'annonces qui permette à l'utilisateur de déposer des annonces sur la plateforme
    - Elles doivent-être visible pour tous le monde
    - Les dernières annonces doivent-être visible sur une page (ici triées par ordre anti-chonologique sur la page d'accueil)
    - Une annonce doit appartenir à un utilisateur et seul lui peut la modifier ou la supprimer
    - Une annonce doit appartenir à une catégorie particulière
- Un système de recherche
- Une API JSON de recherche qui doit
    - permettre de faire des recherches de la même manière qu'avec le système de recherche
    - permettre de récupérer le détail d'une annonce
    - respecter les principes d'une API REST
-Un système de messagerie entre les utilisateurs afin qu'ils puissent communiquer sur le thème d'une annonce
    
J'ai utilisé le Framework PHP [Laravel](https://laravel.com) dans sa version 6.2 et le Framework [Bootstrap 4](https://getbootstrap.com/).

La plateforme que j'ai développé permet en plus de :
    - Restaurer des annonces supprimées par erreur
    - De suivre des annonces
    - De gérer plusieurs types utilisateur (administrateurs, standards et suspendus)
    
<div>
    [Accueil]()
</div>
