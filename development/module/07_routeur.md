# Routeur

Quand une URL est appelée, le routeur cherche dans tous vos modules une correspondance avec leurs routes. 

Pour que votre fichier de route soit exécuté, vous devez ajouter l’attribut `$pathRoutes` à votre contrôleur `TodoController` et définir le chemin jusqu’au fichier `routing.json`. 
Vous pouvez vous aider des constantes fournies par SoosyzeCMS :

* `MODULES_CONTRIBUED`, chemin des modules contributeurs,
* `DS`, alias de la constante `DIRECTORY_SEPARATOR`, permet de ne pas dépendre du système hôte (*pour séparer le nom des répertoires, Linux ou Mac utilisent `/`, et Windows utilise `\`*).

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Config' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        /* Spécifie le chemin de votre fichier de route. */
        $this->pathRoutes = CONFIG_TODO . 'routing.json';
    }

    /* […] */
}
```

Si la route est trouvée, le routeur exécutera la méthode renseignée et retournera une réponse.
Si la route n’est pas trouvée, une erreur 404 (*Page not found*) sera déclenchée.

Vous pouvez définir n’importe quel répertoire pour vos routes ou même le nom de votre fichier qui les contient.

Je vous invite néanmoins à suivre les conventions de nommage suivantes :

* Les fichiers de vos routes se situent dans un répertoire nommé `Config` dans chacun de vos modules,
* Si vous n’avez qu’un fichier de route, son nom peut être nommé `routing.json`,
* Dans le cas ou votre module possède plusieurs contrôleurs et donc plusieurs fichiers de routes, il est recommandé que chaque fichier soit nommé `routing-nom_controller.json`.

Le format JSON est beaucoup utilisé dans SoosyzeFramework, je vous conseille alors de vous doter d’un validateur de JSON. Vous éviterez plus facilement les erreurs de JSON mal écrits. 
J’utilise par exemple [https://jsonformatter.curiousconcept.com/](https://jsonformatter.curiousconcept.com/).

## Routes statiques

Vous pouvez nommer vos routes comme bon vous semble, mais pour plus de visibilité, il vaut mieux les référencer en minuscules avec la convention de nommage suivante : `nom_module.nom_action`.

Les attributs minimum sont :

* `"methode"`, la méthode HTTP employée (`GET`, `HEAD`, `POST`, `OPTIONS`, `CONNECT`, `TRACE`, `PUT`, `PATCH`, `DELETE`),
* `"path"` L’URL recherchée après votre nom de domaine,
* `"uses"` NomControlleur@nomMéthode.

Nous allons commencer par les routes suivantes :

| Description                       | Route                                | Méthode |
|-----------------------------------|--------------------------------------|---------|
| Page d’affichage de la liste      | http://127.0.0.1/soosyze/?todo/index | `GET`   |
| Page d’administration de la liste | http://127.0.0.1/soosyze/?admin/todo | `GET`   |
| Formulaire d’ajout d’un item      | http://127.0.0.1/soosyze/?todo/item  | `GET`   |
| Validation de l’ajout d’un item   | http://127.0.0.1/soosyze/?todo/item  | `POST`  |

Modifiez le fichier `routing.json` et ajoutez-y les lignes suivantes :

```json
{
    "todo.index": {
        "methode": "GET",
        "path": "todo/index",
        "uses": "TodoController@index"
    },
    "todo.admin": {
        "methode": "GET",
        "path": "admin/todo",
        "uses": "TodoController@admin"
    },
    "todo.item.create": {
        "methode": "GET",
        "path": "todo/item",
        "uses": "TodoController@create"
    },
    "todo.item.store": {
        "methode": "POST",
        "path": "todo/item",
        "uses": "TodoController@store"
    }
}
```

Maintenant que les routes statiques sont définies, modifiez `TodoController` en y ajoutant les fonctions qui seront appelées :

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'config' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = CONFIG_TODO . 'routing.json';
    }

    public function index( $req )
    {
        return "Affichage de la liste";
    }

    public function admin( $req )
    {
        return "Affichage de la liste pour l’admin";
    }

    public function create( $req )
    {
        return "Formulaire d’ajout d’item";
    }

    public function store( $req )
    {
        return "Validation d’ajout d’item";
    }
}
```

Lorsque le routeur appelle une fonction, il leur fournit un paramètre d’entrée par défaut, que nous nommerons `$req`.

Ce paramètre correspond à la représentation objet d’une requête HTTP.
Pour être plus précis, il s’agit de l’implémentation de l’interface venant de la recommandation PSR-7 : [Psr\Http\Message\ServerRequestInterface](https://www.php-fig.org/psr/psr-7/#321-psrhttpmessageserverrequestinterface).

Vérifions que nos fonctions soient bien appelées.

Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/index](http://127.0.0.1/soosyze/?todo/index).
Le résultat est censé être : 

![Illustration 07_routeur-routes_statiques](/assets/development/07_routeur-routes_statiques.png)

## Routes dynamiques

Certaines routes possèdent un ou plusieurs paramètres dynamiques (*un identifiant, un nom…*).

Dans notre cas, nous voulons pouvoir éditer ou supprimer des items.  
Mais pour savoir quel item doit être édité ou supprimé, nous avons besoin de le connaître.  
La route peut porter cette information par le biais d’un identifiant.

Nous allons donc rajouter les routes suivantes :

| Description                              | Route                                        | Méthode |
|------------------------------------------|----------------------------------------------|---------|
| Formulaire d’édition de l’item 2         | http://127.0.0.1/soosyze/?todo/item/2/edit   | `GET`   |
| Validation de l’édition de l’item 2      | http://127.0.0.1/soosyze/?todo/item/2/edit   | `POST`  |
| Validation de la suppression de l’item 2 | http://127.0.0.1/soosyze/?todo/item/2/delete | `POST`  |

Modifiez le fichier `routing.json` et ajoutez les lignes suivantes à la suite de nos routes créées précédemment (*attention au respect du format JSON*) :

```json
{
    "todo.item.edit": {
        "methode": "GET",
        "path": "todo/item/:id/edit",
        "uses": "TodoController@edit",
        "with": {
            ":id": "\\d+"
        }
    },
    "todo.item.update": {
        "methode": "POST",
        "path": "todo/item/:id/edit",
        "uses": "TodoController@update",
        "with": {
            ":id": "\\d+"
        }
    },
    "todo.item.delete": {
        "methode": "POST",
        "path": "todo/item/:id/delete",
        "uses": "TodoController@delete",
        "with": {
            ":id": "\\d+"
        }
    }
}
```

Les routes possèdent un token dans leur `"path"`, `:id`, qui sera remplacé par la valeur de l’identifiant.

Ce token peut posséder une règle de validation dans l’attribut `"with"`. Cette règle a pour clé le nom du token et pour valeur une regex (*expression régulière*). Quand l’utilisateur choisira une route qui ne remplira pas la règle de validation, celui-ci sera renvoyé automatiquement à une page 404.

Exemples de regex :

| Valeur souhaité                                | Regex                | Valeur OK | Valeur KO |
| ---------------------------------------------- | -------------------- | --------- | --------- |
| Nombre entier positif requis                   | \d+                  | 12        | abc       |
| Chaîne de caractères en minuscule requise      | [a-z]+               | test      | 123       |
| Chaîne alpha numerique avec underscore requise | [a-zA-Z0-9_]+        | TeSt_12   | &#{@      |
| La valeur bonjour, hello ou hola               | bonjour\|hello\|hola | bonjour   | hallo     |
| Chaîne de 3 caractères indéfinis minimum       | .{3}                 | T2&       | T2        |

Je vous conseille l’outil en ligne [http://regexr.com/](http://regexr.com/) pour tester vos regex.

La seconde étape est de modifier votre contrôleur pour y ajouter toutes les méthodes des routes.
Rendez-vous dans le contrôleur `TodoController` et ajoutez-y vos nouvelles fonctions :

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'config' . DS);

class TodoController extends \Soosyze\Controller
{
    /* […] */

    public function edit( $id, $req )
    {
        return "Formulaire d’édition de l’item N°$id";
    }

    public function update( $id, $req )
    {
        return "Validation de l’édition de l’item N°$id";
    }

    public function delete( $id, $req )
    {
        return "Validation de la suppression de l’item N°$id";
    }
}
```

Le routeur appellera la fonction définie et passera en paramètre les tokens précisés dans l’URL par ordre d’appel. Le dernier paramètre correspondra à l’objet Request fourni par le routeur.

Par exemple, si vous définissez une route avec plusieurs tokens :

```json
{
    "todo.exemple": {
        "methode": "GET",
        "path": "todo/:item1/:item2/:item3",
        "uses": "TodoController@exemple"
    }
}
```

Votre fonction pourra avoir comme paramètres :

```php
public function exemple( $item1, $item2, $item3, $req ){
    /* code */
}
```

À noter que les noms des paramètres d’entrée ne doivent pas obligatoirement porter le même nom que celui défini dans votre fichier de routes, mais il est plus facile de s’y retrouver si les noms sont identiques.

Vérifions que vos fonctions soient bien appelées et que l’item soit bien le même que celui dans l’URL.

Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item/2/edit](http://127.0.0.1/soosyze/?todo/item/2/edit).
Le résultat est censé être : 

![Illustration 07_routeur-routes_dynamiques](/assets/development/07_routeur-routes_dynamiques.png)

Au final, votre fichier des routes doit ressembler à ça :

```json
{
    "todo.index": {
        "methode": "GET",
        "path": "todo/index",
        "uses": "TodoController@index"
    },
    "todo.admin": {
        "methode": "GET",
        "path": "admin/todo",
        "uses": "TodoController@admin"
    },
    "todo.item.create": {
        "methode": "GET",
        "path": "todo/item",
        "uses": "TodoController@create"
    },
    "todo.item.store": {
        "methode": "POST",
        "path": "todo/item",
        "uses": "TodoController@store"
    },
    "todo.item.edit": {
        "methode": "GET",
        "path": "todo/item/:id/edit",
        "uses": "TodoController@edit",
        "with": {
            ":id": "\\d+"
        }
    },
    "todo.item.update": {
        "methode": "POST",
        "path": "todo/item/:id/edit",
        "uses": "TodoController@update",
        "with": {
            ":id": "\\d+"
        }
    },
    "todo.item.delete": {
        "methode": "POST",
        "path": "todo/item/:id/delete",
        "uses": "TodoController@delete",
        "with": {
            ":id": "\\d+"
        }
    }
}
```

Et votre contrôleur doit contenir le code suivant :

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'config' . DS);

class TodoController extends \Soosyze\Controller
{
    public function index( $req )
    {
        return "Affichage de la liste";
    }

    public function admin( $req )
    {
        return "Affichage de la liste pour l’admin";
    }

    public function create( $req )
    {
        return "Formulaire d’ajout d’item";
    }

    public function store( $req )
    {
        return "Validation d’ajout d’item";
    }

    public function edit( $id, $req )
    {
        return "Formulaire d’édition de l’item N°$id";
    }

    public function update( $id, $req )
    {
        return "Validation de l’édition de l’item N°$id";
    }

    public function delete( $id, $req )
    {
        return "Validation de la suppression de l’item N°$id";
    }
}
```

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/07_routeur).
