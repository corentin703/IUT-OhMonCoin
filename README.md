# OhMonCoin
### Projet du module Web 1 de 2ème année de DUT

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


### Mise en place
Sur une machine avec Docker, et son utilitaire *docker-compose* d'installés, tapez 
```
docker-compose up -d
```

Cela démarrera trois conteneurs contenant respectivement un serveur apache avec php, une instance de MariaDB et une instance de phpMyAdmin.

Lors de la première utilisation, vous devez initialiser la base de données (attention, il se peut que quelques secondes soient nécessaire le temps que la MariaDB se mette en place).
Pour ce faire, obtenez l'identifiant du conteneur utilisant l'image *ohmoncoin_ohmoncoin_web* grâce à la commande ci-dessous.
```
docker ps
```
Ensuite, exécutez la commande ci-dessous pour effectuer la migration :
```
docker exec -i id_conteneur php artisan migrate
```
Ceci fait, OhMonCoin est prêt.

Le site est mappé sur le port 80 par défaut : tapez donc localhost dans la barre d'adresse pour utiliser le site.

Par défaut, la base de données utilise un volume situé dans le dossier *database_persist* situé à la racine du dépôt pour la persistance.


Pour mettre le déploiement hors service, tapez :
```
docker-compose down
```


### Accueil
<div>
    <img src="https://raw.githubusercontent.com/corentin703/OhMonCoin/master/ReadMe/Accueil.png" alt="Accueil" width=50%"/>
</div>
                                                                                                                         
### Page des catégories
<div>
    <img src="https://raw.githubusercontent.com/corentin703/OhMonCoin/master/ReadMe/Catégorie.png" alt="Accueil" width=50%"/>
</div>

### Détail d'une annonce et messagerie
<div>
    <img src="https://raw.githubusercontent.com/corentin703/OhMonCoin/master/ReadMe/Messagerie.png" alt="Accueil" width=50%"/>
</div>
          
### Édition d'annonce
<div>
    <img src="https://raw.githubusercontent.com/corentin703/OhMonCoin/master/ReadMe/Edition Annonce.png" alt="Accueil" width=50%"/>
</div>
                                                                                                                         
### Espace personnel
<div>
    <img src="https://raw.githubusercontent.com/corentin703/OhMonCoin/master/ReadMe/Espace Perso.png" alt="Accueil" width=50%"/>
</div>                                                                                                                    
                                                                                                                    
### Édition des roles
<div>
    <img src="https://raw.githubusercontent.com/corentin703/OhMonCoin/master/ReadMe/Roles.png" alt="Accueil" width=50%"/>
</div>
