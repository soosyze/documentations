# Hello World !

Comme précisé dans l’introduction, SoosyzeCMS est basé sur SoosyzeFramework qui est un framework MVC (*Modèle Vue Contrôleur*) orienté objet.

Pour vulgariser le fonctionnement d’une architecture MVC, prenons l’exemple suivant :

En appelant l’URL de votre site, une requête est créée est va déclancher :
* Un **Contrôleur**, qui est la logique de l’application, il exécutera un code permettant d’appeler :
* Un **Modèle**, qui représente vos données (*en base de données, en fichier, en tableau…*). Ces données seront retournées à votre contrôleur qui appellera ensuite :
* Une **Vue**, qui met en forme vos données (*pour l’afficher en HTML, en JSON, en texte…*).

La première étape sera donc de déclencher un contrôleur. 
Pour commencer, nous lui ferons afficher "Hello world !".

Dans le répertoire `TodoModule/Config`, créez un fichier `routes.php` avec le code suivant :

```php
<?php
# app/modules/TodoModule/Config/routes.php

use Soosyze\Components\Router\Route as R;

R::useNamespace('SoosyzeExtension\TodoModule\Controller');

R::get('todo.index', 'todo/index', 'TodoController@index');
```

Le fichier `routes.php` contiendra toutes les routes du module et exécutera un contrôleur si l’URL appelée est la bonne. Dans notre cas, cela déclenchera la méthode  `index()` , à condition que l’utilisateur ait appelé l’URL suivante : `?q=todo/index`.

La seconde étape est de créer le contrôleur.
Rendez-vous dans le répertoire `TodoModule/Controller` puis créez un fichier `TodoController.php` avec le code suivant :

```php
<?php
# app/modules/TodoModule/Controller/TodoController.php

namespace SoosyzeExtension\TodoModule\Controller;

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = dirname(__DIR__) . '/Config/routes.php';
    }

    public function index()
    {
        return "Hello World !";
    }
}
```

Avant de tester votre module, vous devez l’activer pour que SoosyseFramework puisse exécuter le code.

Rendez-vous dans le répertoire `app`, éditez le fichier `app_core.php` et ajoutez la ligne `"TodoController" => new SoosyzeExtension\TodoModule\Controller\TodoController()` à la fonction `loadModules()`.

```php
<?php
# app/app_core.php

use Soosyze\App;

class Core extends App
{
    public function loadServices()
    {
        return [
            'schema'   => [
                'class'     => 'SoosyzeCore\\QueryBuilder\\Services\\Schema',
                'arguments' => [
                    '#database.host',
                    '#database.schema'
                ]
            ],
            'query'    => [
                'class'     => 'SoosyzeCore\\QueryBuilder\\Services\\Query',
                'arguments' => [
                    '@schema'
                ]
            ],
            'template' => [
                'class'     => 'SoosyzeCore\\Template\\Services\\Templating',
                'arguments' => [
                    '@core',
                    '@config'
                ]
            ],
            'template.hook.user' => [
                'class' => 'SoosyzeCore\\Template\\Services\\HookUser',
                'hooks' => [
                    'user.permission.module' => 'hookPermission',
                    'install.user'           => 'hookInstallUser'
                ]
            ],
            'file'     => [
                'class'     => 'SoosyzeCore\\FileSystem\\Services\\File',
                'arguments' => [
                    '@core'
                ]
            ],
            'translate'     => [
                'class'     => 'SoosyzeCore\\Translate\\Services\\Translation',
                'arguments' => [
                    '@config',
                    __DIR__ . '/lang',
                    'en'
                ]
            ]
        ];
    }

    public function loadModules()
    {
        $modules = [
            /* Cette ligne permettra de charger votre module sans passer par le ModuleManager. */
            "TodoController" => new SoosyzeExtension\TodoModule\Controller\TodoController()
        ];

        if (empty($this->get('config')->get('settings.time_installed'))) {
            $modules[] = new SoosyzeCore\System\Controller\Install();

            return $modules;
        }

        $data = $this->get('query')->from('module_controller')->fetchAll();
        foreach ($data as $value) {
            $modules[] = new $value[ 'controller' ]();
        }

        return $modules;
    }
}
```

Sans trop entrer dans les détails, le fichier `app_core.php` contient l’objet `Core` qui permet de surcharger l’objet `App` de SoosyzeFramework pour définir quels modules doivent être utilisés.

La fonction `loadModules()` permet de sélectionner manuellement les modules à utiliser (*utile dans les cas où nous développons un module*).
La fonction `loadServices()` est celle qui ajoutera les services de base.

Il est temps de tester votre premier module : ouvrez un navigateur web et entrez l’URL suivante : [http://127.0.0.1/soosyze/?q=todo/index](http://127.0.0.1/soosyze/?q=todo/index).
Le résultat est censé être : 

![Illustration 06_hello_world](/assets/development/06_hello_world.png)

Et voilà, votre premier module est fonctionnel ! Dans le prochain chapitre, nous allons analyser en détail le système des routes.

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/06_hello_world).