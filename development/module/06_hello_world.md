# Hello World !

Comme précisé dans l’introduction, SoosyzeCMS est basé sur SoosyzeFramework qui est un framework MVC (*Modèle Vue Controller*) orienté objet.

Pour vulgariser le fonctionnement d’une architecture MVC, prenons l’exemple suivant :
En appelant l’URL de votre site, un utilisateur va déclencher  :

* Un **contrôleur**, qui est la logique de l’application, il exécutera un code permettant d’appeler :
* Un **model**, qui représente vos données (*en base de données, en fichier, en tableau…*). Ces données seront retournées à votre contrôleur qui appellera ensuite :
* Une **Vue**, qui met en forme vos données (*pour l’afficher en HTML, en JSON, en texte…*).

La première étape sera donc de déclencher un contrôleur. Pour commencer, nous lui ferons afficher "Hello world !".
Dans le répertoire `TodoModule/Config`, créez un fichier `routing.json` avec le code suivant :

```json
{
    "todo.index": {
        "methode" : "GET",
        "path": "todo/index",
        "uses": "TodoController@index"
    }
}
```

Le fichier `routing.json` contiendra toutes les routes du module et exécutera un contrôleur si l’URL appelée est la bonne. Dans notre cas, cela déclenchera la méthode  `index()` , à condition que l’utilisateur ait appelé l’URL suivante : `?todo/index`.

La seconde étape est de créer le contrôleur : rendez-vous dans le répertoire `TodoModule/Controller` puis créez un fichier `TodoController.php` avec le code suivant :

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Config' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes   = CONFIG_TODO . 'routing.json';
    }

    public function index()
    {
        return "Hello World !";
    }
}
```

Avant de tester votre module, vous devez l’activer pour que SoosyseFramework puisse exécuter le code.

Rendez-vous dans le répertoire `app`, éditez le fichier `app_core.php` et ajoutez la ligne `"TodoController" => new TodoModule\Controller\TodoController()` à la fonction `loadModules()`.

```php
<?php
# app/app_core.php

use Soosyze\App;

require_once 'vendor/soosyze/framework/src/App.php';

class Core extends App
{
    public function loadServices()
    {
        return [
            'schema'   => [
                'class'     => 'QueryBuilder\\Services\\Schema',
                'arguments' => [
                    '#database.host',
                    '#database.schema'
                ]
            ],
            'query'    => [
                'class'     => 'QueryBuilder\\Services\\Query',
                'arguments' => [
                    '@schema'
                ]
            ],
            'template' => [
                'class'     => 'Template\\Services\\TemplatingHtml',
                'arguments' => [
                    '@core',
                    '@config'
                ]
            ],
            'file' => [
                'class'     => 'FileSystem\\Services\\File'
            ]
        ];
    }

    public function loadModules()
    {
        $modules = [
            /* Cette ligne permettra de charger votre module sans passer par le ModuleManager. */
            "TodoController" => new TodoModule\Controller\TodoController()
        ];

        if (empty($this->get('config')->get('settings.time_installed'))) {
            $modules[ 'Install' ] = new Install\Controller\Install();

            return $modules;
        }

        $data = $this->get('query')->select('key_controller', 'controller')->from('module')->fetchAll();
        foreach ($data as $value) {
            $modules[ $value[ 'key_controller' ] ] = new $value[ 'controller' ]();
        }

        return $modules;
    }
}
```

Sans trop entrer dans les détails, le fichier `app_core.php` contient l’objet `Core` qui permet de surcharger l’objet `App` de SoosyzeFramework pour définir quels modules doivent être utilisés.

La fonction `loadModules()` permet de sélectionner manuellement les modules à utiliser (*utile dans les cas où nous développons un module*).
La fonction `loadServices()` est celle qui ajoutera les services de base.

Il est temps de tester votre premier module : ouvrez un navigateur web et entrez l’URL suivante : [http://127.0.0.1/soosyze/?todo/index](http://127.0.0.1/soosyze/?todo/index).
Le résultat est censé être : 

![Illustration 06_hello_world](/assets/development/06_hello_world.png)

Et voilà, votre premier module est fonctionnel ! Dans le prochain chapitre, nous allons analyser en détail le système des routes.

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/06_hello_world).