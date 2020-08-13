# Contrôleur

Lors des précédents chapitres, vous avez pu remarquer que le contrôleur héritait de `\Soosyze\Controller` :

```php
class TodoController extends \Soosyze\Controller { 
    /* […] */
}
```

L’héritage de `\Soosyze\Controller` est obligatoire pour que votre contrôleur puisse être utilisé par SoosyzeFramework et SoosyzeCMS. Cette classe fournit à votre contrôleur un certain nombre de fonctionnalités.

## Namespace

SoosyzeFramework se base sur plusieurs recommandations.
[La recommandation PSR-04 (Autoloader)](https://www.php-fig.org/psr/psr-4/) donne une convention de nommage pour vos namespaces, objets et fichiers.

Pour faire simple, l’autoloader permet de charger automatiquement vos objets. Cela évite l’utilisation hasardeuse des fonctions `require` et `require_once`.

Vous devez donc nommer vos namespaces en fonction de votre arborescence et nommer votre objet de la même manière que votre fichier.

Dans notre cas, l’objet `TodoController` se situe dans un fichier `TodoController.php` et notre namespace `SoosyzeExtension\TodoModule\Controller` représente l’emplacement de `TodoController.php`.
- `SoosyzeExtension` est défini par l'autoloader du CMS comme étant le répertoire `app)/module`,
- `TodoModule` le répertoire TodoModule,
- `Controller` le répertoire Controller.

Ce qui revient à dire que l'objet `TodoController` est contenu dans le fichier `TodoController.php` dans le répertoire `app/module/TodoModule/Controller`

```php
<?php
# app/modules/TodoModule/Controller/TodoController.php

/* Le namespace doit refléter votre arborescence. */
namespace SoosyzeExtension\TodoModule\Controller;

use Psr\Http\Message\ServerRequestInterface;

/* Et le nom de la classe doit refléter le nom du fichier. */
class TodoController extends \Soosyze\Controller { 
    /* […] */
}
```

## Requête et Réponse

[La recommandation PSR-07](https://www.php-fig.org/psr/psr-7/) (HTTP Message Interface) permet de représenter le protocole HTTP sous forme d’objet.

Pour rappel, le protocole HTTP (*HyperText Transfer Protocol*) est un protocole de communication client-serveur. Pour vulgariser, ce protocole définit la manière selon laquelle une requête doit être envoyée au serveur, et comment le serveur doit renvoyer une réponse.

Donc, quand une route appelle la méthode d’un contrôleur, un objet `Request` lui est transmis en paramètre d’entrée. Il contient les données de la requête envoyée au serveur, telles que :

* La version du protocole HTTP utilisée,
* La méthode utilisée (`GET`, `POST`, …),
* L’URI (contenant l’URL),
* Les informations d’en-têtes,
* Le corps du message,
* Les données contenues dans `$_SERVEUR`, `$_COOKIE`, `$_GET`, `$_POST`, `$_FILE`.

Jusqu’à présent, le retour n’était qu’une simple chaîne de caractère. L’utilisation de l’objet `Response` permet de spécifier d’autres informations, telles que :

* Le type de données retournées (*HTML, texte, JSON…*),
* Le code de retour de la réponse (*200 = OK ; 301 = Fichier déplacé de façon permanente ; 400 = Erreur dans la requête…*),
* Ses en-têtes…

Pour plus de détails, voir la documentation PhpDoc :

* [Doc de Request](https://api.soosyze.com/Soosyze/Components/Http/Request.html),
* [Doc de Response](https://api.soosyze.com/Soosyze/Components/Http/Response.html),
* [Doc de Stream](https://api.soosyze.com/Soosyze/Components/Http/Stream.html).

Nous allons modifier notre contrôleur pour qu’il retourne un objet `Response` plutôt que du texte brut.
Ajoutez les composants `Soosyze\Components\Http\Response` et `Soosyze\Components\Http\Stream` au contrôleur `TodoController`. Ensuite, dans la fonction `index()`, ajoutez les lignes suivantes :

```php
# app/modules/TodoModule/Controller/TodoController.php

/* Le namespace doit refléter votre arborescence. */
namespace SoosyzeExtension\TodoModule\Controller;

use Psr\Http\Message\ServerRequestInterface;
/* Déclaration des objets du composant HTTP. */
use Soosyze\Components\Http\Response;
use Soosyze\Components\Http\Stream;

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        /* Spécifie le chemin de votre fichier de route. */
        $this->pathRoutes = dirname(__DIR__) . '/Config/routes.php';
    }

    /**
     * La fonction index pour afficher la liste.
     *
     * @param $request est un objet ServerRequest qui rassemble toutes les données
     * de la requête HTTP.
     */
    public function index( ServerRequestInterface $req ){
        /** 
         * L’objet Response utilise l’objet Stream comme corps de la réponse.
         * L’objet Stream permet de représenter et manipuler 
         * n’importe quel type de données en flux.
         * Stream peu ainsi contenir tout type de scalaire ou de ressources comme du JSON, 
         * du XML, du texte, du HTML, des entiers, des flottants…
         */
        return new Response(200, new Stream("Affichage de la liste"));
    }
}
```

Vérifions que la fonction soit bien appelée.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?q=todo/index](http://127.0.0.1/soosyze/?q=todo/index).
Le résultat est censé être : **Affichage de la liste**

## RESTful

Prenons maintenant un exemple bien plus technique. Imaginons que vous fassiez la séparation entre le back-end (*la logique de votre application*) et le front-end (*l’affichage de votre application*). Vous chercheriez là à faire une application RESTful. 

Vous utiliserez probablement des bibliothèques du style Angular ou React (*pour ne citer que ces deux là*), et vous chercherez à ce que le retour de votre contrôleur soit dans un format différent du `plain/text`. Prenons par exemple un retour au format JSON en utilisant l’objet `Response`.

```php
public function index( ServerRequestInterface $req ){
    /* Notre contenu. Ici une chaîne, mais il aurait pu s’agir d’un tableau. */
    $content  = "Affichage de la liste";
    /* Nous ajoutons notre contenu encodé en JSON dans un flux. */
    $stream   = new \Soosyze\Components\Http\Stream(json_encode($content));
    /* Nous passons le flux à la réponse. */
    $response = new \Soosyze\Components\Http\Response(200, $stream);

    /* Nous retournons la réponse en spécifiant que le type de contenu est du JSON. */
    return $response->withHeader('content-type', 'application/json');
}
```

Vérifions que la fonction retourne bien du JSON.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?q=todo/index](http://127.0.0.1/soosyze/?q=todo/index).
Le résultat est censé être : 

![Illustration 08_controleur-restful.png](/assets/development/08_controleur-restful.png)

Vous pouvez également utiliser la méthode `json()` fournit par le contrôleur :

```php
public function index( ServerRequestInterface $req ){
    return $this->json(200, ["Affichage de la liste"]);
}
```


## Redirect

Une redirection n’est rien de plus qu’une réponse HTTP avec un code 301 (*Fichier déplacé de façon permanente*) ou 302 (*Fichier déplacé de façon temporaire*) et un header location (*URL de redirection*). Pour simplifier l’utilisation des redirections, le composant HTTP fournit l’objet `Redirect`.

* [Doc de Redirect](https://api.soosyze.com/Soosyze/Components/Http/Redirect.html).

Par exemple, lorsque nous validerons l’édition d’un item, il faudra rediriger l’utilisateur vers la page d’admin de la "to do list". Ajoutez le composant `Soosyze\Components\Http\Redirect`, puis ajoutez les lignes suivantes dans la fonction `udpate()` :

```php
# app/modules/TodoModule/Controller/TodoController.php

/* Le namespace doit refléter votre arborescence. */
namespace SoosyzeExtension\TodoModule\Controller;

use Psr\Http\Message\ServerRequestInterface;
/* Déclaration de nos objets du composant HTTP. */
use Soosyze\Components\Http\Redirect;
use Soosyze\Components\Http\Response;
use Soosyze\Components\Http\Stream;

class TodoController extends \Soosyze\Controller
{
    /* […] */

    public function udpate( $id, ServerRequestInterface $req )
    {
        /* Fournit la route à la redirection. */
        return new Redirect('?q=todo/index');
    }
}
```

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/08_controleur).
