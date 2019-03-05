# Intégration à SoosyzeCMS

Je pense que vous vous en doutez, mais nous nous approchons de la fin du tutoriel. 
Dans ce chapitre, je vais vous expliquer comment : 

* Utiliser les thèmes du CMS à la place du composant Template, 
* Installer votre module dans le CMS via le moduleManager, 
* Interagir avec les autres modules pour : 
  * Ajouter des droits utilisateurs, 
  * Ajouter un lien dans le menu.

Pour réussir correctement notre intégration, il faut bien avoir compris le concept des templates et des modèles. 
NDLR : en dehors de l’utilisation des thèmes, le reste de ce chapitre est voué à être modifié dans les prochaines versions de SoosyzeCMS pour une meilleure stabilité et mise à jour des données.

## Utiliser les thèmes de SoosyzeCMS

Jusqu'à présent, vous avez utilisé le composant `Template` pour l’affichage de vos vues, alors que SoosyzeCMS utilise le service `template` pour permettre aux développeurs d’uniformiser les vues dans un thème. (*Si vous avez besoin d’un rappel sur le fonctionnement ou le lexique du composant `Template`, je vous invite à relire le chapitre correspondant*). 

Ce service fournit une architecture prête à l’emploi en utilisant le composant `Template`. Ses fonctions sont semblables, vous ne devriez pas être perdu. 

L'architecture fournie par le service `template` :

![Illustration 15_integration-theme](/assets/development/15_integration-theme.png)

Pour appréhender cette architecture, il faut comprendre qu’il existe déjà un template principal par défaut (*html.php*) contenant des variables et des blocs (*pour rappel, un bloc contient un sous-template*) contenant des variables, des blocs, etc. :

* Un premier bloc **html.php** contenant :
* Des variables :
  * $title,
  * $description,
  * ...
* Des blocs :
  * **pages.php** contenant :
  * Des variables :
    * $title,
    * $logo,
    * $title_main.
  * Des blocs :
    * **main_menu.php** (*vide*)
    * **message.php** contenant :
      * ect...
    * **content.php** (*vide*)
    * **second_menu.php** (*vide*)

Bref si vous avez ce schéma en tête, vous allez pouvoir interagir avec lui assez simplement aussi bien pour vos modules que pour vos thèmes. 
Nous allons de ce pas modifier l’affichage de la fonction `index()` de notre contrôleur `TodoController`. 
Pour rappel, le code contenu dans cette fonction est le suivant :

```php
public function index( $req )
{
    $tpl   = new Template('html.php', VIEWS_TODO);
    $block = new Template('page-todo-index.php', VIEWS_TODO);
    $list  = self::todo()->getList();

    $block->addVar('todo', $list);

    return $tpl->addVar('main_title', 'Affichage de la liste')
            ->addBlock('content', $block)
            ->render();
}
```

Avec le service `template`, notre module n’aura plus besoin de sa vue **html.php**, je vous invite à la supprimer du répertoire `Views`. 
Pour interagir avec l’architecture du service nous aurons principalement besoin de deux fonctions :

* `->view($parent, array $vars);` qui injecte des variables dans un sous-template existant :
  * `$parent` : le nom du bloc que vous souhaitez appeler (*avec ou sans parent, séparé par une virgule*),
  * `$vars` : les variables à lui transmettre (*Exemple `['image'=> 'image_test.png']`*).
* `->render($parent, $tpl, $tplPath, array $vars = null)` qui injecte un nouveau sous-template :
  * `$parent` : le nom du bloc que vous souhaitez ajouter (*avec ou sans parent, séparé par une virgule*),
  * `$tpl` : le nom de la vue,
  * `$tplPath` : le chemin de la vue,
  * `$vars` : les variables à lui transmettre.
  
Toujours dans notre fonction `index()`, ajoutez l’appel au service `template` :

```php
public function index( $req )
{
    $list = self::todo()->getList();

    /* On commence par l’appel au service template. */
    return self::template()
        /* On injecte dans la template dans le bloc 'page' la variable 'title_main'. */
        ->view('page', [
            'title_main' => 'Affichage de la liste'
        ])
        /* On ajoute un nouveau template dans le bloc 'content' du bloc 'page' avec la variable 'todo'. */
        ->render('page.content', 'page-todo-index.php', VIEWS_TODO, [
             'todo' => $list
        ]);
}
```

Voyons maintenant le résultat de notre page dans le thème du CMS. 
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/index](http://127.0.0.1/soosyze/?todo/index).
Le résultat est censé être : 

![Illustration 15_integration-theme_index](/assets/development/15_integration-theme_index.png)

Maintenant que nous avons vu de quelle manière utiliser le service template pour l’index de notre module TodoModule, nous allons également l’utiliser pour notre administration. 
Rendez-vous dans le contrôleur `TodoController`, et dans la fonction `admin()`, ajoutez les lignes suivantes :

```php
public function admin($req)
{
    $list = self::todo()->getList();

    /* On commence par l’appel au service template. */
    return self::template()
        /* Petite nouveauté, nous appelons le thème d’administration plus que celui par défaut. */
        ->getTheme('theme_admin')
        /* On injecte dans la template dans le bloc 'page' la variable 'title_main'. */
        ->view('page', [
            'title_main' => 'Affichage de la liste pour l’admin'
        ])
        /* On ajoute un nouveau template dans le bloc 'content' du bloc 'page' avec la variable 'todo'. */
        ->render('page.content', 'page-todo-admin.php', VIEWS_TODO, [
            'todo' => $list
        ]);
}
```

## Exercice d’utilisation du thème pour les formulaires

On va finir sur un exercice assez simple : modifier les fonctions `create()` et `edit()` de notre module `TodoModule` pour y utiliser le thème du CMS à la place du composant `Template`.

## Correction de l’utilisation du thème pour les formulaires

La correction de la fonction `create()` du contrôleur `TodoController` :

```php
public function create($req)
{
    /* [...] */

    return self::template()
            ->getTheme('theme_admin')
            ->view('page', [
                'title_main' => 'Ajout d’un élément à la liste'
            ])
            ->render('page.content', 'form-todo-item-add.php', VIEWS_TODO, [
                'form' => $form
    ]);
}
```

La correction de la fonction `edit()` du contrôleur `TodoController` :

```php
public function create($req)
{
    /* [...] */

    return self::template()
            ->getTheme('theme_admin')
            ->view('page', [
                'title_main' => 'Édition d’un élément à la liste'
            ])
            ->render('page.content', 'form-todo-item-edit.php', VIEWS_TODO, [
                'form' => $form
    ]);
}
```


## Installation au ModuleManager

Si vous avez suivi chaque chapitre de ce tutoriel pour en arriver ici, vous devez remettre à zéro ce qui permet à notre module d’être installé statiquement (*en dur dans le code != dynamique*). Vous devez supprimer :

* La déclaration de notre module dans le fichier `app/app_core.php` dans la fonction `loadModules()`,  
* Son fichier de données `add/data/todo.json`,
* Et sa déclaration dans le fichier `app/data/schema.json`.

Le ModuleManager est l’un des modules du cœur de SoosyzeCMS et a pour but l’installation et la désinstallation dynamique de module. Pour qu’il puisse déterminer si votre module peut être installé, vous devez créer à la racine de votre module deux fichiers :

* `config.json` : fournissant des informations sur le module,
* `Install.php` : fournissant les scripts d’installation et de désinstallation du module.

Commençons par le module `TodoModule` : rendez-vous à la racine du module, créez un fichier `config.json` et ajoutez-y les lignes suivantes  :

```json
{
    "TodoModule": {
        "name": "TodoModule",
        "controller": {
            "TodoController": "TodoModule\\Controller\\TodoController"
        },
        "version": "1.0",
        "description": "Liste des tâches à faire",
        "package": "TodoList",
        "locked": false,
        "required": []
    }
}
```

La déclaration d’un module commence par une clé unique portant le même nom que le répertoire contenant son code source.
Ensuite, les différents paramètres :

* `name` : le nom du module (*la même que la clé unique*), 
* `controller` : le tableau associatif des contrôleurs (*"NomContrôleur" : "NameSpace\NomContrôleur"*),
* `version` : la version du module,
* `description` : la description succincte des fonctionnalités (*de 255 caractères maximum*),
* `package` : l’appartenance du module (*Core, Development, Content, SEO…*),
* `locked` : qui dit si le module ne peut pas être désinstallé (*utilisé pour les modules du cœur*),
* `required` : qui liste des modules requis pour l’installation.

Quelques petites précisions sur la **version**, elle doit suivre la logique X.Y.Z-E (*version_majeure.version_mineure.révision-état*). Cependant, dans le cadre d’un module, sa version majeure doit suivre la version majeure du CMS. 

Par exemple, si le CMS est en version 2.1.2, alors la version de votre module doit commencer par 2.x.x.

Le cycle de versions autorisés :

| Description                                                                                         | Version      |
|-----------------------------------------------------------------------------------------------------|--------------|
| Version de développement                                                                            | 1.0.0-dev    |
| Version alpha (*manque de fonctionnalités, bugs éventuels*)                                         | 1.0.0-alpha1 |
| Version bêta (*presque toutes les fonctionnalités, mise en évidence les bugs par les utilisateurs*) | 1.0.0-beta1  |
| Version RC (*Release Candidate, candidate à être la version stable*)                                | 1.0.0-RC1    |
| Version Stable (*avec toutes les fonctionnalités attendues*)                                        | 1.0.0        |

Vous voilà calé dans la rédaction du fichier de configuration d’un module. Depuis le début de ce tutoriel, je vous ai demandé de modifier manuellement les données dans le répertoire `app
/data`. Je vous annonce enfin que nous allons voir comment interagir dynamiquement avec `QueryFlatFile` à l’installation du module.

Rendez-vous à la racine du module `TodoModule`, créer un fichier `Install.php` et ajoutez-y les lignes suivantes :

```php
<?php

namespace TodoModule;

/* Utilisation du TableBuilder pour la création de notre table. */
use Queryflatfile\TableBuilder;

class Install
{
    /* Fonction appelée à l’installation d’un module par le ModulManager. */
    public function install($container)
    {
        /* On ajoute une table 'todo' si elle n’existe pas. */
        $container->schema()->createTableIfNotExists('todo', function (TableBuilder $table) {
            /* La table possède 4 champs. */
            $table->increments('id')
                ->string('title')
                ->integer('height')->valueDefault(1)
                ->boolean('achieve')->valueDefault(false);
        });

        /* On insère des données par défaut. */
        $container->query()->insertInto('todo', [ 'title', 'height', 'achieve' ])
            ->values([ 'Item 1', 1, false ])
            ->values([ 'Item 2', 2, false ])
            ->values([ 'Item 3', 3, false ])
            ->execute();
    }

    /* Fonction appelée à la désinstallation d’un module par le ModulManager. */
    public function uninstall($container)
    {
        /* On supprime la table. */
        $container->schema()->dropTable('todo');
    }
}
```

Bon, quelques explications s’imposent sur ces nouvelles fonctions :

* `->createTableIfNotExists( $table, callable $callback = null );` nous permet de créer une table si elle n’existe pas. Elle prend en premier paramètre le nom de la table et en second un callback fournissant l’objet TableBuilder pour construire les champs de la table :
  * `->increments('id')` : un identifiant de type incrémental, 
  * `->string('title')` : un titre de type chaîne de caractères, 
  * `->integer('height')->valueDefault(1)` : une hauteur de type entier positif, avec pour valeur par défaut 1, 
  * `->boolean('achieve')->valueDefault(false)` : une valeur boolean pour savoir si l’item est réalisé, avec pour valeur par défaut FALSE. 
* `->insertInto( $table, array $columns = null )` définit quelles vont être les données à insérer dans une table,
* `->dropTable( $table );` supprime une table.

Cette déclaration de table et de données pour notre "to do list" a déjà été réalisée manuellement dans le chapitre sur les modèles. Ici, vous venez d’écrire le code qui permet de la créer dynamiquement. Pour plus d’informations sur la manipulation des tables, vous retrouvez ses fonctions dans la documentation de Queryflatfile.

Maintenant que tout est réuni, il faut tester l’installation et la désinstallation de notre module. Rendez-vous sur la page d’administration des modules à l’URL [http://127.0.0.1/soosyze/?admin/modules](http://127.0.0.1/soosyze/?admin/modules).

Vous pouvez voir votre module dans le package TodoList. Cocher la checkboox, puis cliquer sur le bouton **Enregistrer** en bas de page. 
Et voilà, votre module vient d’être installé, pour vous en assurer, rendez-vous à l’URL [http://127.0.0.1/soosyze/?admin/todo](http://127.0.0.1/soosyze/?admin/todo).

Vous pouvez également faire le cheminement inverse : décocher la checkboox, puis cliquer à nouveau sur le bouton **Enregistrer**. 
Et voilà, votre module vient d’être désinstallé. Pour vous en assurer, rendez-vous à l’URL [http://127.0.0.1/soosyze/?admin/todo](http://127.0.0.1/soosyze/?admin/todo). Une erreur 404 devrait apparaître.

## Exercice d’installation du module TodoDate

Pour vous assurer que vous avez bien compris comment fonctionnent l’installation et la désintallation de module, je vous propose l’exercice suivant : 

* Créer un fichier de configuration pour le module TodoDate : 
  * La package doit être le même, 
  * Et notre module todoDate doit requérir le module TodoListe. 
* Créer un fichier d’installation pour le module TodoDate : 
  * Qui, à l’installation, ajoute une colonne date si elle n’existe pas dans la table todo, 
  * Qui, à la désinstallation, supprime la colonne date si elle existe dans la table todo.

Vous n’avez pas encore appris à modifier une table dans ce tutoriel ? Voici un conseil avisé : tout bon développeur doit apprendre à chercher par soi-même avant de demander de l’aide à autrui, d’autant plus si la documentation existe.

Bon courage. ;)

## Correction de l’installation du module TodoDate

La correction du fichier `config.json` du module `TodoDate` :

```json
{
    "TodoDate": {
        "name": "TodoDate",
        "controller": {
            "TodoDateController": "TodoDate\\Controller\\TodoDateController"
        },
        "version": "1.0",
        "description": "Ajoute une date butoir à vos tâches.",
        "package": "TodoList",
        "locked": false,
        "required": ["TodoModule"]
    }
}
```

La correction du fichier `Install.php` du module `TodoDate` :

```php
<?php

namespace TodoDate;

use Queryflatfile\TableBuilder;

class Install
{
    public function install($container)
    {
        if (!$container->schema()->hasColumn('todo', 'date')) {
            $container->schema()->alterTable('todo', function (TableBuilder $table) {
                $table->date('date')->nullable();
            });
        }
    }

    public function uninstall($container)
    {
        if ($container->schema()->hasColumn('todo', 'date')) {
            $container->schema()->alterTable('todo', function (TableBuilder $table) {
                $table->dropColumn('date');
            });
        }
    }
}
```

## Ajouter des droits utilisateurs

Pour ajouter des droits utilisateurs à votre module, il faut savoir : 

* Comment sont gérés les accès avec le module `User`, 
* Quel est le schéma de base de données des permissions et des rôles utilisateur. 

Pour rappel, ce chapitre risque de ne plus être d’acctulité dans les prochaines versions de SoosyzeCMS. Je vous expliquerai donc brièvement comment fonctionnent les droits utilisateur et comment les ajouter à votre script d’installation. Le schéma de données de l’utilisateur est assez simple : 

* Un utilisateur possède un ou plusieurs rôles, 
* Un rôle possède une ou plusieurs permissions.

Il existe trois rôles par défaut :

* L’utilisateur anonyme,
* L’utilisateur connecté,
* L’administrateur.

Les droits utilisateurs sont vérifiés avant même l’appel au router. C’est-à-dire que le module User utilise un hook de l’application, pour vérifier si l’utilisateur a l’un des rôles permettant d’accéder à la route. 

Au début du tutoriel, nous avons spécifié que tous les utilisateurs pouvaient voir la liste, mais que seul l’administrateur pouvait ajouter, modifier et supprimer des items. Pour que notre module puisse avoir des droits utilisateurs corrects, nous devons donc définir une matrice de droits :

| Route            | Utilisateur anonyme | Utilisateur connecté | Administrateur |
|------------------|---------------------|----------------------|----------------|
| todo.index       | ✓                   | ✓                   | ✓              |
| todo.admin       |                     |                      | ✓              |
| todo.item.create |                     |                      | ✓              |
| todo.item.store  |                     |                      | ✓              |
| todo.item.edit   |                     |                      | ✓              |
| todo.item.update |                     |                      | ✓              |
| todo.item.delete |                     |                      | ✓              |

Nous visualisons maintenant bien quel rôle pourra emprunter quelle route.
Rendez-vous à la racine du module `TodoModule`, éditez le fichier `Install.php`, et ajoutez à la suite de la fonction `install()` les lignes suivantes :

```php
public function install($container)
{
    /* [...] */

    /* Si la table user existe. */
    if ($container->schema()->hasTable('user')) {
        
        /* Alors, je crée les droits suivants dans la table 'permission' : */
        $container->query()->insertInto('permission', [
            'permission_id', 'permission_label'
        ])
        ->values([ 'todo.index', 'Voir la liste des tâches' ])
        ->values([ 'todo.admin', 'Voir l’administration des tâches' ])
        ->values([ 'todo.item.create', 'Voir l’ajout des tâches' ])
        ->values([ 'todo.item.store', 'Ajouter des tâches' ])
        ->values([ 'todo.item.edit', 'Voir l’édition des tâches' ])
        ->values([ 'todo.item.update', 'Éditer les tâches' ])
        ->values([ 'todo.item.delete', 'Supprimer les tâches' ])
        ->execute();

        /* Et j’ajoute une relation entre les permissions et un rôle dans la table 'role_permission'. */
        $container->query()->insertInto('role_permission', [
            'role_id', 'permission_id'
        ])
        /**
         * Valeur 1 = Utilisateur anonyme
         * Valeur 2 = Utilisateur connecté
         * Valeur 3 = Administrateur
         */
        ->values([ 1, 'todo.index' ])
        ->values([ 2, 'todo.index' ])
        ->values([ 3, 'todo.index' ])
        ->values([ 3, 'todo.admin' ])
        ->values([ 3, 'todo.item.create' ])
        ->values([ 3, 'todo.item.store' ])
        ->values([ 3, 'todo.item.edit' ])
        ->values([ 3, 'todo.item.update' ])
        ->values([ 3, 'todo.item.delete' ])
        ->execute();
   }
}
```

Il ne faut pas oublier de supprimer ces droits à la désinstallation du module. 
Toujours dans le fichier `Install.php`, ajoutez à la suite de la fonction `uninstall()` les lignes suivantes :

```php
public function uninstall($container)
{
    /* Si la table user existe. */
    if ($container->schema()->hasTable('user')) {
        /* Je supprime les permissions qui commencent par la chaine 'todo'. */
        $container->query()
            ->from('permission')
            ->delete()
            ->where('permission_id', 'like', 'todo%')
            ->execute();
        /* Je supprime les relations avec les rôles qui commencent par la chaine 'todo'. */
        $container->query()
            ->from('role_permission')
            ->delete()
            ->where('permission_id', 'like', 'todo%')
            ->execute();
    }
}
```

Il suffit désormais de désinstaller le module et de le réinstaller via le module manager pour que ces nouvelles données puissent être créées. 
Pour vérifier si les droits utilisateurs sont effectifs, assurez-vous de ne pas être connecté au CMS, et rendez-vous à l’adresse suivante : [http://127.0.0.1/soosyze/?admin/todo](http://127.0.0.1/soosyze/?admin/todo). Cela est censé vous mener à la page de connexion.

## Ajouter un lien dans le menu 

Comme pour l’ajout de droits utilisateurs, l’ajout de liens dans le menu se situe dans le fichier Install.php. 
Rendez-vous à la racine du module `TodoModule`, éditez le fichier `Install.php`, et ajoutez à la suite de la fonction `install()` les lignes suivantes :

```php
public function uninstall($container)
{
    /* Si la table menu existe existe. */
    if( $container->schema()->hasTable('menu') )
    {
        $container->query()->insertInto('menu_link', [ 
                 /* La clé de la route. */
                'key', 
                /* Le titre du lien. */
                'title_link', 
                /* Le lien. */
                'link',
                /**
                 * L’identifiant du menu
                 * 'admin-menu' pour le menu administrateur,
                 * 'main-menu' pour le menu principale,
                 * 'user-menu' pour le menu utilisateur (compte, connexion, déconnexion...)
                 */
                'menu',
                /* La place du lien dans le menu. */ 
                'weight', 
                /* -1 pour la racine du menu (le multi-niveau n’est pas encore implémenté). */
                'parent' 
            ])
            /* Ajout du lien d’administration. */
           ->values([
                'todo.admin',
                'Todo',
                'admin/todo',
                'admin-menu',
                7,
                -1
            ])
            /* Ajout du lien utilisateur. */
            ->values([
                'todo.index',
                'Todo',
                'todo/index',
                'main-menu',
                5,
                -1
            ])
            ->execute();
    }
}
```

Il suffit désormais de désinstaller le module et de le réinstaller via le moduleManager pour que ces nouvelles données puissent être créées. 
Pour vérifier si les droits utilisateurs sont effectif, assurez-vous d’être connecté au CMS, et rendez-vous aux adresses suivantes : 
[http://127.0.0.1/soosyze/?admin/todo](http://127.0.0.1/soosyze/?todo/index) : le résultat le lien **Todo** dans le menu principal,
[http://127.0.0.1/soosyze/?admin/todo](http://127.0.0.1/soosyze/?admin/todo) : le résultat le lien **Todo** dans le menu d’administration.

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/15_integration).