# Modèle

Voilà l’une des parties les plus importantes du tutoriel. Jusque là, nous avons abordé la construction de Contrôleur et de Views. Il nous reste à mettre en œuvre la dernière partie de l’architecture MVC, à savoir le Modèle. 

Pour rappel, le modèle a pour objectif de manipuler les données (*globalement les créer, lires, modifier et supprimer*). À partir de ce chapitre, nous allons symboliser le premier démarquage entre un module pour SoosyzeFramework et SoosyzeCMS. L’objectif à long terme sera de réduire cet écart, voire de le faire disparaître pour proposer la construction de module viable pour les deux environnements.

## SGBD

SoosyzeFramewok a fait le choix de ne pas imposer un SGBD (*Système de Gestion Base de Données*). Libre à vous de voir comment vous allez interagir avec vos données. La façon la plus simple pour vous est de créer un service avec : 

* Une fonction pour la connexion à la base de données, 
* Une fonction pour la construction de requête, 
* Et une fonction pour le retour de vos données.

## QueryFlatFile

Si vous avez lu la documentation ou la présentation de SoosyzeCMS, vous ne serez pas surpris quant à l’utilisation de la bibliothèque QueryFlatFile pour nos modules. 

Pour rappel, Queryflatfile est une bibliothèque de base de données NoSQL orientée documents écrits en PHP. Elle stocke les données par défaut au format JSON (*flat file*). L’objectif est de pouvoir manipuler des données contenues dans des fichiers de la même façon dont ont manipule les données avec le langage SQL. 

La syntaxe SQL est très largement répandue dans le monde de l’informatique, ce depuis des dizaines d’années. Je ne reviendrai pas dessus, mais si vous avez envie de vous documenter à ce sujet, je vous conseille l’excellent site [http://sql.sh/](http://sql.sh/).

Si vous avez lu le précédent chapitre, vous devez vous douter que l’utilisation de QueryFlatFile se fait via l’utilisation d’un service. Vous pouvez d’ailleurs voir sa déclaration dans la fonction `loadServices()` dans le fichier `app/app_core.php` :

```php
<?php

use Soosyze\App;

require_once 'vendor/soosyze/framework/src/App.php';

class Core extends App
{
    public function loadServices()
    {
        return [
            /* Ici, la déclaration du service gérant le schéma de la base de données. */
            'schema'   => [
                'class'     => 'QueryBuilder\\Services\\Schema',
                'arguments' => [
                    '#database.host',
                    '#database.schema'
                ]
            ],
            /* Ici, le service que nous utiliserons pour manipuler les données. */
            'query'    => [
                'class'     => 'QueryBuilder\\Services\\Query',
                'arguments' => [
                    '@schema'
                ]
            ],
            /* […] */
        ];
    }
    
    /* […] */
}

```

Il doit être déclaré en premier, afin de permettre aux autres modules de SoosyzeCMS d’avoir accès à leurs données. Les données sont stockées par défauts dans le répertoire `app/data`.

Tous les fichiers de données JSON sont minifiés à l’écriture. Selon votre IDE (*Environnement de développement*) ou l’éditeur de texte enrichi que vous utilisez pour ce tutoriel, vous devrez installer un plugin ou exécuter une commande pour rendre le contenu des fichiers plus lisibles. Donc, si vous utilisez :

* **NetBeans** : utilisez le raccourci clavier `Alt + Shift + F`,
* **Notepad++** : je vous recommande le module [JSTool](http://www.sunjw.us/jstoolnpp),
* **Sublime Text** : je vous recommande le module [Pretty Json](https://github.com/dzhibas/SublimePrettyJson),
* **Atom** : je vous recommande le module [atom-beautify](https://atom.io/packages/atom-beautify) qui prend mieux en charge que le JSON.

Vous pouvez également passer par un service en ligne, tel que [JSON Viewers](https://codebeautify.org/jsonviewer).

### Ajouter une table manuellement

Avant de manipuler les données de notre "to do list" nous allons commencer par déclarer et créer notre table manuellement.
Rendez-vous dans le répertoire `app/data` et éditez le fichier `schema.json`. Celui-ci contient le schéma des tables utilisées par notre CMS et l’organisation des données.

Rajoutez les lignes suivantes à la fin du fichier `schema.json` :

```json
{
    "todo": {
        "table": "todo",
        "path": "app\/data",
        "fields": {
            "id": {
                "type": "increments"
            },
            "title": {
                "type": "string",
                "length": 255
            },
            "height": {
                "type": "integer",
                "default": 1
            },
            "achieve": {
                "type": "boolean",
                "default": false
            }
        },
        "increments": 3
    }
}
```

Une petite explication s’impose sur les champs de notre schéma : 

* `table` correspond au nom de la table, 
* `path` est le chemin du fichier de données, 
* `fields` liste des champs qui composent notre table : 
  * `id` est l’dentifiant de l’item de type incrémental, 
  * `title` correspond au titre de l’item de type chaîne de caractère de 255 caractères maximum,
  * `height` est le poids de l’item de type entier pour valeur 1 par défaut, 
  * `achieve` permet la réalisation de l’item, de type boolean pour valeur FALSE par défaut.
* `increments` est la valeur du champ incrémental.

Maintenant que le schéma de données de la table `todo` est ajouté, il faut également créer le fichier qui accueillera les données des items. Toujours dans le répertoire `app/data`, créez un fichier `todo.json` avec les lignes suivantes :

```json
[
    {
        "id": 1,
        "title": "Item 1",
        "height": 1,
        "achieve" : false
    }, {
        "id": 2,
        "title": "Item 2",
        "height": 2,
        "achieve" : false
    }, {
        "id": 3,
        "title": "Item 3",
        "height": 3,
        "achieve" : false
    }
]
```

Il s’agit des données de nos trois items sous la représentation JSON. Bien évidemment vous n’aurez pas à créer toutes vos tables manuellement, tel que nous venons de le faire. Quand viendra le temps d’installer le module, vous utiliserez des méthodes pour créer les tables, leurs champs, types…

### Récupération de données

Pour utiliser QueryflatFile, vous devez utiliser le service `query`. Nous allons constater cela par l’exemple. Rendons-nous dans le contrôleur `TodoController`, et remplaçons provisoirement l’appel au service `todo` dans la fonction `index()` par les lignes suivantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function index( $req )
{
    $tpl = new Template('html.php', VIEWS_TODO);

    $block = new Template('page-todo-index.php', VIEWS_TODO);

    /* Commenter l’appel au service todo. */
    /* $list = self::todo()->getList(); */

    /* Et remplacez-le par cette ligne. */
    $list = self::query()
        ->select()
        ->from('todo')
        ->orderBy('height')
        ->fetchAll();

    $block->addVar('todo', $list);

    return $tpl->addVar('main_title', 'Affichage de la liste')
            ->addBlock('content', $block)
            ->render();
}
```

Vérifions que notre fonction affiche bien les données.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/index](http://127.0.0.1/soosyze/?todo/index).

Cette nouvelle ligne demande à QueryFlatFile  : 

* `->select()` de sélectionner tous les champs (*vous pouvez également ne pas spécifier la sélection pour récupérer tous les champs. Vous pouvez aussi préciser les champs que vous souhaitez en paramètres de la fonction. Exemple :* `->select('title', 'height', 'achieve')`), 
* `->from('todo')` faire provenir les données de la table `todo`, 
* `->orderBy('height')` de les trier par rapport à leur poids, 
* `->fetchAll();` de nous retourner tous les résultats.

Par rapport au reste du tutoriel, cela apporte beaucoup de nouvelles fonctions pour le service `query`. La bibliothèque QueryFlatFile est bien fournie pour la gestion de vos données, et malheureusement je ne peux pas vous en expliquer tout le fonctionnement. 
Mais par chance, une documentation existe. Vous allez vite comprendre pour quelles raisons je ne peux pas l’expliquer ici, mais elle reste simple à comprendre et à lire. La voici :

* [Documentation QueryFlatFile](https://github.com/soosyze/queryflatfile/blob/master/README.md).

Cette documentation liste toutes les explications, et détaille même comment l’utiliser en dehors de SoosyzeCMS. Mais pour notre utilisation, vous n’aurez qu’à utiliser les fonctions qui commencent par `$request` en les remplaçant par `self::query()`. 

Nous allons en profiter pour modifier les autres fonctions qui ont besoin de récupérer les données, comme l’affichage du tableau d’administration et du formulaire d’édition.

Rendez-vous dans le contrôleur `TodoController`, et dans la fonction `admin()` ajoutez les lignes suivantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function admin( $req )
{
    $tpl = new Template('html.php', VIEWS_TODO);

    $block = new Template('page-todo-admin.php', VIEWS_TODO);

    /* $list = self::todo()->getList(); */
    
    /* Notre nouvelle requête pour la page d’admin. */
    $list = self::query()
        ->select()
        ->from('todo')
        ->orderBy('height')
        ->fetchAll();

    $block->addVar('todo', $list);

    return $tpl->addVar('main_title', 'Affichage de la liste pour l’admin')
              ->addBlock('content', $block)
              ->render();
}
```

Vérifions que notre fonction affiche bien les données.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?admin/todo](http://127.0.0.1/soosyze/?admin/todo).

Enfin, dernier changement par rapport au formulaire d’édition, qui réclame les données venant d’un item en base. Toujours dans notre contrôleur, modifiez la fonction `edit()` comme suit :

```php
# modules/TodoModule/Controller/TodoController.php

public function edit( $id, $req )
{
    /* Récupération des données en dehors de notre condition pour une meilleure visibilité. */
    $data = self::query()
        ->select()
        ->from('todo')
        ->where('id', '==', $id)
        ->fetch();

    if( !$data )
    {
        return $this->get404($req);
    }
    
    /* Et notre ancienne condition à commenter.
    if( !($data = self::todo()->getItem($id)) )
    {
        return $this->get404($req);
    }
    */
        
    /* […] */
}
```

Vérifions que notre fonction affiche bien les données.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item/1/edit](http://127.0.0.1/soosyze/?todo/item/1/edit).

Là aussi, quelques subtilités : nous utilisons la condition `->where('id', '==', $id)` pour récupérer uniquement l’item correspondant à l’identifiant fourni par l’URL. 
De plus, nous utilisons la fonction `->fetch()` qui, contrairement à `->fetchAll()`, ne récupère que la première ligne de données retournées.

Et voilà ! Vous pouvez afficher vos données là où c’est nécessaire. Cependant, nous pouvons améliorer le procédé : ce n’est pas par hasard que j’ai choisi de commenter les appels au service. Vous l’aurez compris, nous allons modifier notre service pour que nous puissions exécuter nos requêtes.

### Requête dans un service

Comme expliqué dans le chapitre **Service et container**, nous pouvons ajouter une dépendance à l’aide du suffixe `@` dans la déclaration. Rendez-vous dans le répertoire `TodoModuleServices`, et modifiez le fichier `service.json` comme suit :

```json
{
    "todo": {
        "class": "TodoModule\\Services\\Todo",
        "arguments" : [
            "@query"
        ]
    }
}
```

Ainsi, nous injectons notre service de requête qui sera à récupérer dans notre constructeur. 
Rendez-vous dans le répertoire `TodoModule/Service`, éditez le fichier `Todo.php` et ajoutez-y les lignes suivantes :

```php
# modules/TodoModule/Services/Todo.php

namespace TodoModule\Services;

class Todo
{
    private $query;

    public function __construct( $query )
    {
        $this->query = $query;
    }
    
    /* […] */
}
```

Le service `query` est ainsi déclaré dans un attribut de classe et peut donc être utilisé dans les fonctions de notre service `todo`. Je vous propose de modifier nos fonctions qui simulaient la récupération de données par un appel en base de données. Toujours dans le fichier `Todo.php` modifiez les fonctions `getList()` et `getItem()` par les lignes suivantes : 

```php
<?php
# modules/TodoModule/Services/Todo.php

namespace TodoModule\Services;

class Todo
{
    private $query;

    public function __construct( $query )
    {
        $this->query = $query;
    }

    public function getList()
    {
        return $this->query
                ->select('title', 'height', 'achieve')
                ->from('todo')
                ->where('achieve', '==', false)
                ->orderBy('height')
                ->fetchAll();
    }

    public function getItem( $id )
    {
        return $this->query
                ->select()
                ->from('todo')
                ->where('id', '==', $id)
                ->fetch();
    }
}
```

Maintenant, il suffit de ré-implémenter l’utilisation de ces fonctions dans le contrôleur `TodoController` en les décommettant et en retirant les requêtes réalisées précédemment.

Désormais, il est possible d’utiliser ces fonctions de récupération d’item de la "to do list" depuis un autre contrôleur. Les prochains développeurs n’auront pas besoin de connaître par cœur la base de données pour réaliser des requêtes sur votre "to do list". Il suffira de bien commenter l’utilisation des fonctions de votre service, et tout le monde pourra y avoir accès facilement.

Pourquoi  avoir utilisé les requêtes dans le contrôleur en premier lieu, plutôt que les avoir mises directement dans notre service `Todo` ? Et bien, c’est assez simple je voulais vous montrer qu’il est possible d’interagir directement avec le service `query` dans notre contrôleur. Cela vous permettra de comparer le cheminement entre un code écrit 'en brut' et la possibilité d’ajouter des fonctions réutilisables dans votre module.

### Insertion d’item

Pour insérer vos données, il suffit de modifier la partie de votre contrôleur qui valide vos données d’insertion. 
Éditez le contrôleur `TodoController`, et dans votre fonction `store()`, insérez les lignes suivantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function store( $req )
{
    $post      = $req->getParsedBody();
    $validator = new Validator();

    $validator->setRules([
        'title'   => 'required|string|max:255',
        'height'  => 'required|int|min:1',
        'achieve' => 'bool',
        'token'   => 'required|token'
    ])
    ->setInputs($post);

    if ($validator->isValid()) {
        /* Nos valeurs. */
        $value = [
            'title'   => $validator->getInput('title'),
            'height'  => $validator->getInput('height'),
            /* Si votre checkbox est active elle retourne 'on' sinon elle retourne '' */
            /* Mais la donnée attendue est un boolean, il faut donc la convertir. */
            'achieve' => (bool) $validator->getInput('achieve')
        ];
        /* Notre fonction d’insertion. */
        self::query()
            ->insertInto('todo', array_keys($value))
            ->values($value)
            ->execute();
        $_SESSION[ 'success' ] = [ 'Votre configuration a été enregistrée.' ];
        $route                 = self::router()->getRoute('todo.admin');
    } else {
        $_SESSION[ 'inputs' ]      = $validator->getInputs();
        $_SESSION[ 'errors' ]      = $validator->getErrors();
        $_SESSION[ 'errors_keys' ] = $validator->getKeyInputErrors();
        $route                     = self::router()->getRoute('todo.create');
    }

    return new Redirect($route);
}
```

Une petite explication s’impose sur les méthodes : 

* `->insterInto('todo', array_keys($value))` prend en paramètre d’entrée le nom de la table et un tableau des champs que nous allons insérer. La fonction `array_keys` retournera les clés de chaque champ renseigné dans le tableau des valeurs. De plus, nous n’insérons pas l’identifiant puisqu’il est de type `increment` et que sa valeur augmentera automatiquement de 1 à chaque insertion, 
* `->values([])` prend en paramètre d’entrée un tableau de valeurs à insérer, 
* `$validator->getInput('field')` correspond à la fonction du validateur qui retourne la valeur d’un champ testé au préalable (*pour être sûr qu’il soit valide et qu’il ne provienne pas de n’importe où)*, 
* `->execute()` exécute l’insertion des données en base (*sert aussi pour l’exécution de l’édition et suppression de données*).

Vérifions que notre fonction ajoute bien des item dans la base de données. 
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item](http://127.0.0.1/soosyze/?todo/item).
Remplissez le formulaire, validez-le et retournez sur la page d’administration pour voir si le nouvel item est bien affiché.

### Exercice d’édition d’item

Maintenant, je vous propose cet exercice : gérer la validation de l’édition d’item. Vous allez devoir chercher dans la documentation de QueryFlatFile le chapitre sur la édition de données et adapter la fonction `udpate()` du contrôleur `TodoController`, pour que les données puissent être modifié.

### Correction de l’édition d’item

La correction de notre fonction `udpate()` :

```php
# modules/TodoModule/Controller/TodoController.php

public function udpate( $id, $req )
{
    if (!self::todo()->getItem($id)) {
        return $this->get404($req);
    }

    $post      = $req->getParsedBody();
    $validator = new Validator();

    $validator->setRules([
            'title'   => 'required|string|max:255',
            'height'  => 'required|int|min:1',
            'achieve' => 'bool',
            'token'   => 'required|token'
        ])
        ->setInputs($post);

    if ($validator->isValid()) {
         /* Il y avait seulement ces données et requêtes à ajouter. */
        $value =  [
                'title'   => $validator->getInput('title'),
                'height'  => $validator->getInput('height'),
                /* Cette condition sur le champ achieve renverra un boolean */
                'achieve' => (bool) $validator->getInput('achieve')
        ];
        self::query()
            ->update('todo', $value)
            ->where('id', '==', $id);
       $_SESSION[ 'success' ]  = [ 'Votre configuration a été enregistrée.' ];
        $route                 = self::router()->getRoute('todo.admin');
    } else {
        $_SESSION[ 'inputs' ]      = $validator->getInputs();
        $_SESSION[ 'errors' ]      = $validator->getErrors();
        $_SESSION[ 'errors_keys' ] = $validator->getKeyInputErrors();
        $route                     = self::router()->getRoute('todo.item.edit', [
            ':id' => $id ]);
    }

    return new Redirect($route);
}
```

Vérifions que notre fonction d’édition des items fonctionne bien. 
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item/1/edit](http://127.0.0.1/soosyze/?todo/item/1/edit).
Modifiez le formulaire, validez-le et retournez sur la page d’administration pour voir si l’item est bien modifié.

### Exercice suppression d’item

Maintenant, je vous propose un second exercice : gérer la validation de suppression d’item. Vous allez devoir chercher dans la documentation de QueryFlatFile le chapitre sur la suppression de données et adapter la fonction `delete()` du contrôleur `TodoController`, pour que les données puissent être supprimées. 

Cette fonction étant restée vide depuis le début du tutoriel, vous allez devoir créer une redirection sur la page d’administration une fois la requête de suppression réalisée.

### Correction suppression d’item

La correction de notre fonction `delete()` :

```php
# modules/TodoModule/Controller/TodoController.php

public function delete( $id, $req )
{
    self::query()->from('todo')
        ->delete()
        ->where('id', '==', $id)
        ->execute();

    $route = self::router()->getRoute('todo.admin');

    return new Redirect($route);
}
```

Vérifions que notre fonction de suppression des items fonctionne bien.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?admin/todo](http://127.0.0.1/soosyze/?admin/todo).
Cliquez sur le bouton **_supprimer_** dans la colonne **Actions**.

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/13_model).