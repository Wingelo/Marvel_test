<h1>Test Marvel Heroes</h1>

<h2>Enonce</h2>

 * A partir de l'API Marvel https://developer.marvel.com/ , affichez une liste de 20 personnages à partir du centième. Chaque item de la liste doit avoir le nom du personnage et son image et un clic sur son nom doit afficher le détail du personnage avec les informations suivantes : name / description / image / le nombre de comics où le personnage apparait / les titres des 3 premiers comics où le personnage apparait 
 * L'application doit être testée 
 * Veillez à la sécurité des informations de l’application 
 * Veillez aussi à tenir compte de la web-performance autant que possible et proposez une amélioration possible concernant la performance 
 * Vous fournirez une documentation permettant au relecteur de comprendre l'application et de l'éxécuter facilement sur son poste. 
 * L'application sera mise à disposition de peaks par le moyen de votre choix.
 * Prenez au minimum 1h1/2 pour réaliser cette application (vous pouvez prendre beaucoup plus de temps), indiquez nous juste le temps que vous y avez consacré afin de nous donner une indication sur le type de mission sur lesquels vous pourriez vous épanouir et progresser 
 * S'il vous reste du temps ou si vous souhaitez y consacrer plus de temps, enrichissez l'application avec les fonctionnalités suivantes :
 * mise en place d'un loader 
 * pagination pour pouvoir afficher les personnages précédent/suivant 
 * possibilité de choisir jusqu'à 5 personnages favoris (persistence côté serveur non obligatoire) 

 Pour réaliser cette application, vous pouvez choisir la technologie de votre choix : 
 * application full client : vanilla javascript, angularJS, angular 2, react, VueJs, Aurelia, ou tout autre framework 
 * application client/serveur : PHP, NodeJs avec ou sans persistence de donnée 
 

<h2>Installation</h2>

**1- Récuperer les clés private et public de l'API Marvel**

Cliquez ici pour accéder au site [Marvel](https://developer.marvel.com/)


**2-Installation du projet**

``` composer install ```

**2.1-Création de la base de données**

```php bin/console doctrine:database:create```

**2.2- Mise à jour de la base de données**

```php bin/console doctrine:schema:update --force```

**3-Insérer la clé API public et private**

Dans ```app/config/parameters.yml```

Mettre les clés private et public

```
    public_key_marvel: (votre clé public)
    private_key_marvel: (votre clé private)
```

**4-Démarrer le serveur web**

**Samedi 15 juillet**

Dans l'inviter commande

```php bin/console server:start```


<h2> Remarque </h2>

- utilisation de Symfony 3.3

- utilisation d'un php client marvel api 

- temps : 4 heures 

- j'ai appris comment récupérer des données à partir d'une api 

- optimisation : Mettre en place un système de cache pour optimiser la vitesse

**Lundi 17 juillet**

- mise à jour du readme

- j'ai ajouté la fonctionnalité de favoris jusqu'à 5 héros  

- persistence de données dans une base de donnée(favorites_heroes)

- création d'entité FavoritesHeroes

- amélioration du style de la page

- temps : 2 heures
