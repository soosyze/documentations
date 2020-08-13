# Environnement et outils de développement

Avant tout, vous devez posséder un certain nombre d’outils pour être en mesure suivre ce tutoriel.

## Environnement

Nous vous conseillons de réaliser votre développement sur un serveur local, afin de sécuriser au mieux de votre projet.

Si vous utilisez Windows comme système d’exploitation, il existe plusieurs logiciels "tout-en-un". Pour ce tutoriel, nous avons utilisé le logiciel [WampServeur 3](http://www.wampserver.com/). WAMP signifie :

* **W**indows (*votre système d’exploitation)*,
* **A**pache (*votre serveur HTTP*),
* **M**ySQL (*logiciel de base de données, qui n’est pas obligatoire pour Soosyze*),
* **P**HP (*le langage de développement utilisé pour Soosyze*).

Nous ne pouvons que vivement vous le conseiller...
Si votre choix se porte sur cet outil, nous vous invitons à lire notre [documentation d’installation](/user/00_héberger.md).

## Outils de développement

Il vous faut au minimum un éditeur de texte qui puisse mettre en forme le PHP et le JSON. Sous windows, vous trouverez entre autres :

* [Nodpadd++](https://notepad-plus-plus.org/), éditeur de texte utilisé pour le projet Soosyze,
* [SublimeText](http://www.sublimetext.com/), multi-environnement (*Windows ; UNIX, GNU/Linux ; Mac OS, Mac OS X et macOS*).

Vous pouvez également utiliser un IDE (*Environnement De Développement*), qui fournit une interface plus complète et des outils embarqués qui permettent de débugger, notamment. Le choix du logiciel importe peu  :

* [NetBeans](https://netbeans.org/), IDE utilisé pour le projet Soosyze,
* [Eclipse](https://www.eclipse.org/),
* [Atome](https://atom.io/),
* [Visula Studio Community](https://visualstudio.microsoft.com/fr/vs/community/).

Je vous invite également à vous munir des outils PHP suivants :

* [Composer](https://getcomposer.org/), qui permet d’installer les dépendances,
* [PHP Coding Standfards Fixer](http://cs.sensiolabs.org/), qui nettoie et standardise votre code.

## Outils bonus

Nous vous partageons également une partie des outils utilisés pour le développement du framework et de la bibliothèque NoSQL. Ils ne vous seront d’aucune utilité pour ce tutoriel, mais si ça vous intéresse, les voici :

* [phpDocumentor](https://www.phpdoc.org/), qui génère une documentation à partir des commentaires du code,
* [phpMetrics](https://www.phpmetrics.org/), qui génère un rapport sur la qualité du code,
* [phpUnit](https://phpunit.de/), qui exécute des tests unitaires.

## Activer le mode débug

Dernière mise en place, activer le mode débug. Il vous permet d’afficher les érreurs éventuelles dans votre code. Rendez-vous à la racine de votre projet et éditez le fichier `index.php` et décommanter la ligne suivante :

```php
<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__) . DS);

/* Décommenter la ligne pour autoriser l’affichage des erreurs. */
$config[ 'debug' ] = true;
require_once 'bootstrap/requirements.php';
require_once 'bootstrap/debug.php';
require_once 'bootstrap/autoload.php';

require_once 'app/app_core.php';
require_once 'bootstrap/start.php';
require_once 'bootstrap/facade.php';

echo $app->run();
```

Vous êtes prêt ? Alors c’est parti !