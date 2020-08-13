# Routeur

Quand une URL est appelée, le routeur cherche dans tous vos modules une correspondance avec leurs routes. 

Pour que votre fichier de route soit exécuté, vous devez ajouter l’attribut `$pathRoutes` à votre contrôleur `TodoController` et définir le chemin jusqu’au fichier `route.php`. 

```php
<?php
# app/modules/TodoModule/Controller/TodoController.php

namespace SoosyzeExtension\TodoModule\Controller;

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        /* Spécifie le chemin de votre fichier de route. */
        $this->pathRoutes = dirname(__DIR__) . '/Config/routes.php';
    }

    /* […] */
}
```

Si la route est trouvée, le routeur exécutera la méthode renseignée et retournera une réponse.
Si la route n’est pas trouvée, une erreur 404 (*Page not found*) sera déclenchée.

Vous pouvez définir n’importe quel répertoire pour vos routes ou même le nom de votre fichier qui les contient.

Je vous invite néanmoins à suivre les conventions de nommage suivantes :

* Les fichiers de vos routes se situent dans un répertoire nommé `Config` dans chacun de vos modules,
* Si vous n’avez qu’un fichier de route, son nom peut être nommé `routes.php`,
* Dans le cas ou votre module possède plusieurs contrôleurs et donc plusieurs fichiers de routes, il est recommandé que chaque fichier soit nommé `routes-nom_controller.php`.

## Routes statiques

Nous allons commencer par les routes suivantes :

| Description                       | Route                                        | Méthode |
|-----------------------------------|----------------------------------------------|---------|
| Page d’affichage de la liste      | http://127.0.0.1/soosyze/?q=todo/index       | `GET`   |
| Page d’administration de la liste | http://127.0.0.1/soosyze/?q=admin/todo       | `GET`   |
| Formulaire d’ajout d’un item      | http://127.0.0.1/soosyze/?q=admin/todo/item  | `GET`   |
| Validation de l’ajout d’un item   | http://127.0.0.1/soosyze/?q=admin/todo/item  | `POST`  |

Modifiez le fichier `routes.php` et ajoutez-y les lignes suivantes :

```php
<?php
# app/modules/TodoModule/Config/routes.php

use Soosyze\Components\Router\Route as R;

R::useNamespace('SoosyzeExtension\TodoModule\Controller');
/**
 * Méthode HTTP employée (get, post, option, put, path, delete)
 *
 * @param string $key    Nom unique de la route.
 * @param string $path   L’URL recherchée après votre nom de domaine,
 * @param string $uses   NomControlleur@nomMéthode,
 * @param array  $withs  Expression régulière des attributs de la route.
 */
R::get('todo.index',  'todo/index',      'TodoController@index');
R::get('todo.admin',  'admin/todo',      'TodoController@admin');
R::get('todo.create', 'admin/todo/item', 'TodoController@create');
R::post('todo.store', 'admin/todo/item', 'TodoController@store');
```

Vous pouvez nommer vos routes comme bon vous semble, mais pour plus de visibilité, il vaut mieux les référencer en minuscules avec la convention de nommage suivante : `nom_module.nom_action`.

Maintenant que les routes statiques sont définies, modifiez `TodoController` en y ajoutant les fonctions qui seront appelées :

```php
<?php
# app/modules/TodoModule/Controller/TodoController.php

namespace SoosyzeExtension\TodoModule\Controller;

use Psr\Http\Message\ServerRequestInterface;

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = dirname(__DIR__) . '/Config/routes.php';
    }

    public function index( ServerRequestInterface $req )
    {
        return "Affichage de la liste";
    }

    public function admin( ServerRequestInterface $req )
    {
        return "Affichage de la liste pour l’admin";
    }

    public function create( ServerRequestInterface $req )
    {
        return "Formulaire d’ajout d’item";
    }

    public function store( ServerRequestInterface $req )
    {
        return "Validation d’ajout d’item";
    }
}
```

Lorsque le routeur appelle une fonction, il leur fournit un paramètre d’entrée par défaut, que nous nommerons `$req`.

Ce paramètre correspond à la représentation objet d’une requête HTTP.
Pour être plus précis, il s’agit de l’implémentation de l’interface venant de la recommandation PSR-7 : [Psr\Http\Message\ServerRequestInterface](https://www.php-fig.org/psr/psr-7/#321-psrhttpmessageserverrequestinterface).

Vérifions que nos fonctions soient bien appelées.

Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?q=todo/index](http://127.0.0.1/soosyze/?q=todo/index).
Le résultat est censé être : 

![Illustration 07_routeur-routes_statiques](/assets/development/07_routeur-routes_statiques.png)

## Routes dynamiques

Certaines routes possèdent un ou plusieurs paramètres dynamiques (*un identifiant, un nom…*).

Dans notre cas, nous voulons pouvoir éditer ou supprimer des items.  
Mais pour savoir quel item doit être édité ou supprimé, nous avons besoin de le connaître.  
La route peut porter cette information par le biais d’un identifiant.

Nous allons donc rajouter les routes suivantes :

| Description                              | Route                                                | Méthode |
|------------------------------------------|------------------------------------------------------|---------|
| Formulaire d’édition de l’item 2         | http://127.0.0.1/soosyze/?q=admin/todo/item/2/edit   | `GET`   |
| Validation de l’édition de l’item 2      | http://127.0.0.1/soosyze/?q=admin/todo/item/2/edit   | `POST`  |
| Validation de la suppression de l’item 2 | http://127.0.0.1/soosyze/?q=admin/todo/item/2/delete | `POST`  |

Modifiez le fichier `routes.php` et ajoutez les lignes suivantes à la suite de nos routes créées précédemment :

```php
# app/modules/TodoModule/Config/routes.php

/**
 * R:methode(key, path, classe, with);
 */
R::get('todo.edit',    'admin/todo/item/:id/edit',   'TodoController@edit',   [':id' => '\d+']);
R::post('todo.update', 'admin/todo/item/:id/edit',   'TodoController@update', [':id' => '\d+']);
R::post('todo.delete', 'admin/todo/item/:id/delete', 'TodoController@delete', [':id' => '\d+']);
```

Les routes possèdent un token `:id`, qui sera remplacé par la valeur de l’identifiant.
Cette règle a pour clé le nom du token et pour valeur une regex (*expression régulière*). 
Quand l’utilisateur choisira une route qui ne remplira pas la règle de validation, celui-ci sera renvoyé automatiquement à une page 404.

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
# app/modules/TodoModule/Controller/TodoController.php

namespace SoosyzeExtension\TodoModule\Controller;

use Psr\Http\Message\ServerRequestInterface;

class TodoController extends \Soosyze\Controller
{
    /* […] */

    public function edit( $id, ServerRequestInterface $req )
    {
        return "Formulaire d’édition de l’item N°$id";
    }

    public function update( $id, ServerRequestInterface $req )
    {
        return "Validation de l’édition de l’item N°$id";
    }

    public function delete( $id, ServerRequestInterface $req )
    {
        return "Validation de la suppression de l’item N°$id";
    }
}
```

Le routeur appellera la fonction définie et passera en paramètre les tokens précisés dans l’URL par ordre d’appel. Le dernier paramètre correspondra à l’objet Request fourni par le routeur.

Par exemple, si vous définissez une route avec plusieurs tokens :

```php
R:get('todo.example', 'todo/:item1/:item2/:item3', 'TodoController@example', [
    ':item1' => '\d+',
    ':item2' => '\d+',
    ':item3' => '\d+'
]);
```

Votre fonction pourra avoir comme paramètres :

```php
public function example( $item1, $item2, $item3, ServerRequestInterface $req ){
    /* code */
}
```

À noter que les noms des paramètres d’entrée ne doivent pas obligatoirement porter le même nom que celui défini dans votre fichier de routes, mais il est plus facile de s’y retrouver si les noms sont identiques.

Vérifions que vos fonctions soient bien appelées et que l’item soit bien le même que celui dans l’URL.

Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?q=todo/item/2/edit](http://127.0.0.1/soosyze/?q=todo/item/2/edit).
Le résultat est censé être : 

![Illustration 07_routeur-routes_dynamiques](/assets/development/07_routeur-routes_dynamiques.png)

Au final, votre fichier des routes doit ressembler à ça :

```php
<?php
# app/modules/TodoModule/Config/routes.php

use Soosyze\Components\Router\Route as R;

R::useNamespace('SoosyzeExtension\TodoModule\Controller');

R::get('todo.index',   'todo/index',                 'TodoController@index');
R::get('todo.admin',   'admin/todo',                 'TodoController@admin');
R::get('todo.create',  'admin/todo/item',            'TodoController@create');
R::post('todo.store',  'admin/todo/item',            'TodoController@store');
R::get('todo.edit',    'admin/todo/item/:id/edit',   'TodoController@edit',   [':id' => '\d+']);
R::post('todo.update', 'admin/todo/item/:id/edit',   'TodoController@update', [':id' => '\d+']);
R::post('todo.delete', 'admin/todo/item/:id/delete', 'TodoController@delete', [':id' => '\d+']);
```

Et votre contrôleur doit contenir le code suivant :

```php
<?php
# app/modules/TodoModule/Controller/TodoController.php

namespace SoosyzeExtension\TodoModule\Controller;

use Psr\Http\Message\ServerRequestInterface;

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = dirname(__DIR__) . '/Config/routes.php';
    }

    public function index( ServerRequestInterface $req )
    {
        return "Affichage de la liste";
    }

    public function admin( ServerRequestInterface $req )
    {
        return "Affichage de la liste pour l’admin";
    }

    public function create( ServerRequestInterface $req )
    {
        return "Formulaire d’ajout d’item";
    }

    public function store( ServerRequestInterface $req )
    {
        return "Validation d’ajout d’item";
    }

    public function edit( $id, ServerRequestInterface $req )
    {
        return "Formulaire d’édition de l’item N°$id";
    }

    public function update( $id, ServerRequestInterface $req )
    {
        return "Validation de l’édition de l’item N°$id";
    }

    public function delete( $id, ServerRequestInterface $req )
    {
        return "Validation de la suppression de l’item N°$id";
    }
}
```

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/07_routeur).

Pour information lorsque votre serveur ne peut pas prendre en charge la réécriture d'URL le routeur doit pouvoir lire vos routes. Vous avez peut-être remarqué que celui-ci utilise la variable `?q=` pour pouvoir lire les routes. Utiliser un nom de variable composé d'un seul caractère est assez fréquent, les applications web utilises fréquemment la variable `?q=` comme abréviation de **Query** et `?s=` comme abréviation de **Search**.
