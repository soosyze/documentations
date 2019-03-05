# Services et Container

Un service, comme son nom l’indique est un objet fournissant un service au reste de l’application. Par exemple, le composant `FormBuilder` fournit un service simple pour générer un formulaire HTML à partir d’une déclaration PHP. Mais `FormBuilder` n’est pas dépendant d’autres objets, ni dans sa construction ni dans son utilisation.

Mais imaginons un instant que `FormBuilder` choisisse d’utiliser le composant `Template` pour la génération des inputs.
Il faudrait qu’à chaque déclaration d’un `FormBuilder` un objet `Template` soit fourni :

```php
$form = new FormBuilder(new Template());
```

Ici, nous illustrons une hypothèse simple pour représenter la dépendance, mais l’exemple reste élémentaire. Imaginons cette fois-ci que nous déterminions que l’objet `Template` a besoin d’un autre objet pour fonctionner, cela nous donnerait :

```php
$form = new FormBuilder(new Template(new ObjetForTemplate()));
```

Vous conviendrez que l’utilisation de notre formulaire va poser problème, puisque qu’il dépend d’un objet dépendant lui-même d’un autre objet. C’est là qu’intervient le Container.

## Container

J’utilise l’appellation Container pour simplifier sa désignation, mais en réalité il s’agit d’un **Conteneur d’injection de dépendances** ou **CID**. En algorithmie, il existe un design pattern appelé **l'injection de dépendance** qui vise à résoudre la contrainte des dépendances entre les objets.

Le Container utilise ce design pattern pour définir un registre d’objets et les injecter à ceux qui en sont dépendants. SoosyzeFramework utilise la recommandation [PSR-11: Container interface](https://www.php-fig.org/psr/psr-11/) fournissant les méthodes suivantes pour utiliser un service :

```php
/* La fonction get() retourne le service 'myService'. */
/* En cas d’absence du service, une exception est levée. */
$myService = $container->get('myService');

/* La fonction has() retourne TRUE si le service 'myService' existe, sinon FALSE. */
$container->has('myService');
```

## Utiliser un service

SoosyzeFramework fournit l’instance du Container à chaque contrôleur, vous permettant d’utiliser ses services dans chacun de vos modules. De plus, il fournit 3 services de bases : 

* Le service `core` pour utiliser les méthodes du cœur de votre application, 
* Le service `config` pour récupérer des valeurs dans les fichiers de configuration, 
* Le service `router` pour la manipulation des routes.

Pour appeler un service dans un contrôleur, plusieurs méthodes sont possibles :

```php
/* Directement avec l’attribut de classe $container. */
$this->container->get('router');
/* Ou avec la fonction get() du contrôleur. */
$this->get('router');
/* Ou de façon statique. */
self::router();
```

Personnellement je n’utilise que la méthode statique, qui est la plus simple.

Le service `router` nous fournit la fonction `getRoute()` pour appeler une route de façon dynamique à partir de son nom. Le chemin des routes peut-être modifié en cas d’évolution d’un module ou bien raccourci pour rendre l’URL plus propre, mais leur nom restera inchangé. Donc, en utilisant ce service vous assurez le dynamise de vos routes.

Rendez-vous dans le contrôleur `TodoController`, puis dans la fonction `create()` ajoutez les lignes suvantes :

```php
/* Utilisation de la méthode getRoute() du service router. */
$route = self::router()->getRoute('todo.item.store');

/* Ajout de la route à notre formulaire. */
$form = new FormBuilder(['method' => 'post', 'action' => $route]);
```

Ici, nous appelons une route simple sans paramètre, mais vous pouvez très bien en rajouter.
Rendez-vous dans le contrôleur `TodoController`, puis dans la fonction `edit()` ajoutez les lignes suivantes :

```php
/* Utilisation de la mèthode getRoute() avec parmètre du service router. */
$route = self::router()->getRoute('todo.item.update', [ ':id' => $id ]);

/* Ajout de la route à notre formulaire */
$form = new FormBuilder(['method' => 'post', 'action' => $route]);
```

Maintenant que vous voyez comment utiliser la fonction `getRoute()` du service `router` je vous laisse modifier chaque appel de route dans le contrôleur `TodoController`.

## Créer un service

La première étape sera de créer un service qui retournera les données de la "to do list" pour alimenter le contrôleur.
Rendez-vous dans le répertoire `TodoModule/Services` et créez un fichier `Todo.php` avec le code suivant :

```php
<?php
# modules/TodoModule/Services/Todo.php

namespace TodoModule\Services;

class Todo
{
    public function getList()
    {
        return [
            1 => [
                'id'      => 1,
                'title'   => 'Item 1',
                'height'  => 1,
                'achieve' => false
            ],
            2=> [
                'id'      => 2,
                'title'   => 'Item 2',
                'height'  => 2,
                'achieve' => false
            ],
            3=> [
                'id'      => 3,
                'title'   => 'Item 3',
                'height'  => 3,
                'achieve' => false
            ]
        ];
    }

    public function getItem( $id )
    {
        $data = $this->getList();
        
        return isset($data[$id])
            ? $data[$id]
            : [];
    }
}
```

La seconde étape sera de déclarer notre service. Dans le répertoire `TodoModule/Config/`, créez un fichier `service.json` avec les lignes suivantes :

```json
{
    "todo": {
        "class": "TodoModule\\Services\\Todo"
    }
}
```

Pour que votre fichier de déclaration de service soit exécuté, ajoutez l’attribut `$pathServices` à votre contrôleur `TodoController` et définissez le chemin jusqu’au fichier `service.json`. 
Vous pouvez vous aider des constantes fournies par SoosyzeCMS :

* `MODULES_CONTRIBUED` : chemin des modules contributeurs,
* `DS` : alias de la constante `DIRECTORY_SEPARATOR`, qui permet de ne pas dépendre du système hôte (*Linux ou Mac utilisent le `/` et Windows le `\` pour séparer le nom des répertoires*).

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Config' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        /* Spécifie le chemin de votre fichier de délcaration de service. */
        $this->pathServices = CONFIG_TODO . 'service.json';
        $this->pathRoutes   = CONFIG_TODO . 'routing.json';
    }

    /* […] */
}
```

Vous pouvez définir n’importe quel répertoire pour la déclaration de vos services ou même le nom de votre fichier qui les contient. Je vous invite néanmoins à suivre les conventions de nommage suivantes :

* Les fichiers de vos services se situent dans un répertoire nommé `Config` dans chacun de vos modules, 
* Si vous n’avez qu’un fichier de service, son nom peut être nommé `services.json`, 
* Dans le cas où votre module possède plusieurs contrôleurs et donc plusieurs fichiers de services, il est recommandé que chaque fichier soit nommé `service-nom_service.json`.

Le format JSON est très utilisé dans SoosyzeFramework, je vous conseille alors de vous doter d’un validateur de JSON, vous éviterez plus facilement les erreurs de JSON mal écrits. J’utilise par exemple [https://jsonformatter.curiousconcept.com/](https://jsonformatter.curiousconcept.com/).

Maintenant que le service est créé et déclaré, vous allez pouvoir l’utiliser sans plus attendre. Dans le contrôleur `TodoController` vous allez pouvoir supprimer les deux fonctions privées `getItem()` et `getList()`, et vous remplacerez leurs utilisations par l’appel au service :

```php
/* Remplacer tous ces appels aux fonctions : */
$this->getList();
$this->getItem( $id );

/* Par les appels aux services : */
self::todo()->getList();
self::todo()->getItem( $id );
```

## Injection d’arguments et de dépendances

Notre service "to do list" est plutôt simple, car il ne nécessite pas d’argument ou de service dans sa construction.

Pour pouvoir tester l’injection, nous allons partir du principe que notre service `todo` aura besoin pour se construire des paramètres suivants : 

* Un nombre entier (*exemple : `4`*), 
* D’une chaîne de caractères (*exemple : `"Lorem ipsum"`*), 
* D’un service (*exemple : le service `router`*), 
* Et d’une valeur contenue dans un fichier de configuration (*exemple : le paramètre local du fichier settings*).

Pour ajouter cette dépendance, rendez-vous dans le fichier `service.json` et ajoutez-y les lignes suivantes :

```json
{
    "todo": {
        "class": "TodoModule\\Services\\Todo",
        "arguments": [
            4,
            "Lorem ipsum",
            "@router",
            "#settings.local"
        ],
    }
}
```

Vous noterez que pour différencier une chaîne de caractère d’un service nous utilisons le préfixe `@` et pour une valeur de configuration le préfixe `#`.
Pour utiliser les préfixe `@` et `#` comme simples caractères et non comme un appel à l’injection de service ou de valeur de configuration, ajoutez une barre oblique inverse (*antislash*). Exemple :
* `\@router` est égal à la chaîne de caractères `@router`, et pas le service `router`,
* `\#settings.local` est égal à la chaîne de caractères `#settings.local`, et pas la valeur de configuration `settings.local`.

Pour conclure cet exemple, modifiez le service `Todo` en créant le constructeur suivant :

```php
<?php
# modules/TodoModule/Services/Todo.php

namespace TodoModule\Services;

class Todo
{
    /* Les attributs de classe pour stocker la valeur des attributs du constructeur. */
    private $number;
    private $str;
    private $router;
    private $local;
    
    /**
     * Notre nombre entier, la chaîne de caractère 
     * et notre service router seront injectés à la création du service todo. 
     */
    public function __construct($number, $str, $router, $local)
    {
        $this->number = $number;
        $this->str    = $str;
        $this->router = $router;
        $this->local  = $local;
    }
    
    /* […] */
}
```

L’ordre de déclaration de l’injection doit suivre l’ordre d’appel du constructeur. 

Il s’agit d’un exemple d’utilisation de l’injection d’argument et de service, vous pouvez ainsi tester la récupération de ces données pour mieux en comprendre le fonctionnement. 
Ces attributs n’ont pas d’utilité pour le reste du tutoriel, je vous invite à les supprimer à l’issue de votre test. Mais ne vous en faites pas, nous utiliserons l’injection dans un cas bien plus utile dans le chapitre suivant.

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/12_container_services).