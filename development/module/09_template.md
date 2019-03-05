# Template

Un template est par définition un schéma d’affichage. Il emploiera des variables ou d’autres templates pour composer un affichage cohérent.

Il existe plusieurs moteurs de template web réputés comme Twig ou Smarty.
SoosyzeFramework n’impose pas de moteur de template. Pour les utiliser, il faudra les installer par vous-même.

SoosyzeCMS utilise le composant `Template` par défaut du framework pour son affichage, c’est une solution simple et efficace pour nos besoins.

De plus, `Template` hérite de `Response`, ce qui permet une plus grande souplesse dans vos retours.

* [Doc de Template](https://api.soosyze.com/Soosyze/Components/Template/Template.html),
* [Doc de Response](https://api.soosyze.com/Soosyze/Components/Http/Response.html).

## Utiliser un template

Pour le style de notre module, nous utiliserons la bibliothèque graphique Bootstrap 3. Pour notre module, je vous conseille d’utiliser le CND fourni par Bootstrap pour la déclaration du style CSS.
Rendez-vous dans le repertoire `TodoModule/Views`, créez un nouveau fichier `html.php` et ajoutez-y les lignes suivantes :

```html
<!-- modules/TodoModule/Views/html.php -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <title>SoosyzeCMS | TodoListe </title>

        /* Déclaration par CDN de Bootstrap 3 */
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Affichage de la liste</h1>
                    <ul>
                        <li>Item 1</li>
                        <li>Item 2</li>
                        <li>Item 3</li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
```
L’objectif est d’appeler ce template depuis notre contrôleur et de le retourner.

Rendez-vous dans le contrôleur `TodoController`, ajoutez la constante `VIEWS_TODO` qui sera le chemin de vos vues, remplacez les composants `Soosyze\Components\Http\Response` et `Soosyze\Components\Http\Stream` par le composant `Soosyze\Components\Template\Template`, puis dans la fonction `index()`, ajoutez les lignes suivantes :

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

use Soosyze\Components\Http\Redirect;
/* Déclaration du composant d’affichage. */
use Soosyze\Components\Template\Template;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Config' . DS);
/* Définit le chemin du répertoire de vos vues. */
define("VIEWS_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Views' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes   = CONFIG_TODO . 'routing.json';
    }

    public function index( $req ){
        /* Va chercher le fichier de template. */
        $tpl = new Template('html.php', VIEWS_TODO);

        /* Génère et retourne le template. */
        return $tpl->render();
    }
}
```

Vérifions que notre fonction renvoie bien le template.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/index](http://127.0.0.1/soosyze/?todo/index).
Le résultat est censé être : 

![Illustration 09_template-utiliser_une_template](/assets/development/09_template-utiliser_une_template.png)

## Injection de variable

Vous pouvez aussi injecter des variables dynamiques à vos templates. Modifier le template `html.php` comme suit :

```html
<!-- modules/TodoModule/Views/html.php  -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <title>Soosyze | TodoModule</title>
        
        /* Déclaration par CDN de Bootstrap 3 */
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $main_title ?></h1>
                    <!-- Si la liste possède des éléments, nous l’affichons. -->
                    <?php if( !empty($todo) ): ?>
                    <ul>
                        <?php foreach($todo as $value): ?>
                            <li><?php echo $value['title']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- Sinon un message s’affichera pour prévenir l’utilisateur de l’absence d’item. -->
                    <!-- #LesBonnesPratiques -->
                    <?php else: ?>
                        <p>Aucun élément existant.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
```

L’objectif est d’appeler depuis notre contrôleur ce template et d’injecter des données dans la variable `$main_title` et `$todo`. 

Pour le moment, nous n’utilisons pas de base de données. Je vais donc vous fournir une fonction retournant une liste d’items à afficher. Rendez-vous dans `TodoController`, puis ajoutez la fonction `getList()` à la fin du contrôleur :

```php
private function getList()
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
```

Toujours dans notre contrôleur `TodoController`, ajoutez les lignes suivantes à la fonction `index()` :

```php
# modules/TodoModule/Controller/TodoController.php

public function index( $req )
{
    /* Va chercher le fichier de template. */
    $tpl = new Template('page.php', VIEWS_TODO);

    /* Récupère la liste d’éléments représentant la to-do liste. */
    $list = $this->getList();
    
    /* Ajoute les valeurs aux variables main_title et to-do. */
    return $tpl->addVar( 'main_title', 'Affichage de la liste' )
                ->addVar( 'todo', $list )
                ->render();
}
```

Vérifions que notre fonction renvoie bien à le template avec les variables.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/index](http://127.0.0.1/soosyze/?todo/index).

## Injection de template

Vous pouvez imbriquer les templates entre eux pour découper vos affichages. Notre but sera d’injecter un sous-template à `html.php` pour rendre le réutilisable. Cela évitera de réécrire les balises `<html>`, `<head>` ou `<body>` à chaque affichage.

Pour injecter un sous-template, nous allons utiliser la variable prédéfinie `$block[]` qui cherchera à injecter un template en fonction d’une clé. De plus, chaque page possède un titre principal, également affiché dans le template. Modifier le template `html.php` comme suit :

```html
<!-- modules/TodoModule/Views/html.php -->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <title>Soosyze | TodoModule</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?php echo $main_title; ?></h1>
                </div>
            </div>
        </div>
        <?php if(isset($block['content'])): ?>
            <?php echo $block['content'] ?>
        <?php endif; ?>
    </body>
</html>
```

Notre second template injectera la variable `$todo` et celui-ci sera injecté dans le bloc `$block['content']` du premier template. Rendez-vous dans le repertoire `TodoModule/Views`, créez un nouveau fichier `page-todo-index.php` et ajoutez-y les lignes suivantes :

```html
<!-- modules/TodoModule/Views/page-todo-index.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if( !empty($todo) ): ?>
            <ul>
                <?php foreach($todo as $value): ?>
                    <!-- Si l’item est réalisé alors il apparaîtra barré. -->
                    <?php if( $value[ 'achieve' ] ): ?>
                        <li><s><?php echo $value[ 'title' ]; ?></s></li>
                    <?php else: ?>
                        <li><?php echo $value[ 'title' ]; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <p>Aucun élément existant.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
```

Rendez-vous dans le contrôleur `TodoController`, puis dans la fonction `index()`, et ajoutez-y les lignes suivantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function index( $req )
{
    /* Le template principal. */
    $tpl = new Template('html.php', VIEWS_TODO);

    /* Le sous-template. */
    $block = new Template( 'page-todo-index.php', VIEWS_TODO );
    
    /* Récupère la liste d’éléments représentant notre to-do liste. */
    $list = $this->getList();

    /* Ajoute la variable au sous-template. */
    $block->addVar( 'todo', $list );

    /**
     * Ajoute le sous-template 'page-todo-index.php' 
     * dans le bloc 'content' du template principal.
     */
    return $tpl->addVar( 'main_title', 'Affichage de la liste')
               ->addBlock( 'content', $block )
               ->render();
}
```

Vérifions que notre fonction renvoie bien au template ses variables et son sous-template.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/index](http://127.0.0.1/soosyze/?todo/index).

À noter que la variable `$block` est une variable pré-définie par le composant `Template` pour l’injection de sous-template. Il est vivement déconseillé de l’utiliser pour d’autres usages.

## Exercice page d’administration

Maintenant, je vous propose un exercice assez simple : créer une page d’administration pour la "to do list". Vous devez donc modifier la fonction `admin()` pour renvoyer une page contenant :

* Un tableau listant tous les items :
  * Une colonne pour le titre,
  * Une colonne pour les actions (*bouton éditer et supprimer*),
  * Une colonne pour voir si l’item est réalisé.
* Un bouton d’ajout d’item au-dessus du tableau,
* Un message informatif dans le tableau si aucune donnée n’est présente.

Il s’agit du premier exercice proposé dans ce tutoriel. Gardez à l’esprit que jusqu’à maintenant, vous pouviez simplement copier-coller le code affiché (*si vous aviez la flemme de le faire à la main ^^*).

Vous avez enfin l’occasion de chercher par vous-même. Si votre code remplit le cahier des charges sans provoquer d’erreur, dites-vous qu’il n’y a pas de bonne ou de mauvaise solution à l’exercice : seulement un code plus ou moins optimisé, pensez-y... ;)

## Correction page d’administration

La correction de notre fonction `admin()` dans notre contrôleur :

```php
# modules/TodoModule/Controller/TodoController.php

public function admin( $req )
{
    $tpl   = new Template('html.php', VIEWS_TODO);
    $block = new Template('page-todo-admin.php', VIEWS_TODO);
    $list  = $this->getList();

    $block->addVar('todo', $list);

    return $tpl->addVar('main_title', 'Affichage de la liste pour l’admin')
               ->addBlock('content', $block)
               ->render();
}
```

Et le template d’administration :

```html
<!-- modules/TodoModule/Views/page-todo-admin.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="?todo/item" class="btn btn-primary">Ajouter un lien</a>
        </div>

        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Action</th>
                        <th>Réalisé</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if( !empty($todo) ): ?>
                        <?php foreach( $todo as $value ): ?>
                            <tr>
                                <td><?php echo $value[ 'title' ]; ?></td>
                                <td>
                                    <!-- L’action supprimer utilise la méthode POST, un formulaire et donc nécessaire. -->
                                    <form method="post" action="?todo/item/<?php echo $value[ 'id' ]; ?>/delete" class="form-inline">
                                        <a class="btn btn-default" href="?todo/item/<?php echo $value[ 'id' ]; ?>/edit">
                                            Éditer 
                                        </a>
                                        <input type="submit" name="delete" class="btn btn-default" value="Supprimer">
                                    </form>
                                </td>
                                <td>
                                    <?php if( $value[ 'achieve' ] ): ?>
                                        <!-- Si l’item est réalisé nous affichons une icône ✔. -->
                                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    <?php else: ?>
                                        <!-- Sinon une icône ✘-->
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="info">
                            <td colspan="3">Aucun élément existant.</td>
                        </tr>
                    <?php endif; ?>
                <tbody>
            </table>
        </div>
    </div>
</div>
```

Vérifions que notre fonction renvoie bien notre page d’administration.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?admin/todo](http://127.0.0.1/soosyze/?admin/todo).

Le résultat est censé être : 

![Illustration 09_template-correction_page_d_administration](/assets/development/09_template-correction_page_d_administration.png)

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/09_template).

## Bonus lexical 

En écrivant cette documentation, je me suis rendu compte que nous pouvions facilement nous y perdre, dans le champ lexical de ce chapitre (template, vue, bloc, sous-template...). Bref, voici un petit rappel pour conclure : 

* **Un template** (*dans notre cas*) est un object content plusieurs informations pour l’affichage d’une vue. Il contient le chemin et le fichier de la vue, des variables et des blocs. (*NDLR : après plusieurs recherches, on dit bien "un" et non "une" template, car sa traduction signifie "un modèle". Cependant, libre à vous de choisir votre déternimant, mais ne vous attardez pas sur ce genre de détail...*) 
* **Une vue**, c’est le fichier que la template va appeler pour la mise en forme des données. Elle peut contenir des variables, mais aussi des blocs. 
* **Une variable**, comme son nom l’indique, est une donnée variable (CQFD). Il peut s’agir d’une chaîne de caractères, du nombre inclus dans un tableau, d’un objet... . Cet élément sert à afficher dynamiquement des données dans les vues. 
* **Un bloc** est un emplacement qui contient un ou plusieurs sous-templates. Par exemple la template html.php contient le bloc page qui accueilleura un sous-template. 
* **Un sous-template** est seulement l’appellation d’un template imbriqué dans une autre via un bloc.