# Installation et Configuration

## Exigences d’installation

### Serveur Web

| Serveur Web             | Soosyze 1.x |
|-------------------------|-------------|
| Apache HTTP Server 2.2+ | ✓ Supporté  |
| Ngnix 1+                | ✓ Supporté  |
| IIS                     | ✓ Supporté  |

*Pour Ngnix, voir la [recommandation d’intallation](#ngnix).

### Version PHP

| Version PHP                 | Soosyze 1.x    |
|-----------------------------|----------------|
| <= 5.3                      | ✗ Non supporté |
| 5.4 / 5.5 / 5.6             | ✓ Supporté     |
| 7.0 / 7.1 / 7.2 / 7.3 / 7.4 | ✓ Supporté     |

En choisissant les versions PHP 7.x, vous aurez un gain de performance sur la mémoire et un gain de temps d’exécution de 30% à 45% : votre site sera plus rapide et mieux référencé.

### Extensions requises

* `date` : pour le format des dates,
* `fileinfo` : pour la validation de fichier,
* `filter` : pour valider vos données,
* `gd` : pour la maniplation d’image,
* `json` : pour l’enregistrement des données et des configurations,
* `mbstring` : pour vos emails,
* `session` : pour garder en mémoire vos données (côté serveur) d’une page à l’autre,
* `zip` pour créer des sauvegarde et le restaurer en cas d'erreur.

Ces extensions sont généralement actives par défaut. Si l’une venait à manquer, un message d’erreur vous en informerait.

### Mémoire requise

Soosyze (*hors modules contributeurs*) nécessite 16MB de mémoire.

### Navigateurs supportés

Le thème de base ainsi que celui d’administration sont réalisés avec le framework Bootstrap 3 :

* [Navigateurs supportés](https://getbootstrap.com/docs/3.3/getting-started/#desktop-browsers),
* [Navigateurs mobiles supportés](https://getbootstrap.com/docs/3.3/getting-started/#mobile-devices).

### Connexion à internet

Le thème de base ainsi que celui d’administration se déchargent d’une partie des bibliothèques d’affichage (*front-end*) en faisant appel à des CND (*Content delivery network*) :

* Bootstrap 3.3.7,
* JQuery 3.2.1,
* JQuery UI 1.12.0,
* Select2,
* Font Awesome 5.8.1.

Pour l’affichage complet des thèmes de base, il sera nécessaire de disposer d’une connexion réseau, afin d’être en mesure d’utiliser ces bibliothèques.

## Installation

### Téléchargement rapide

Pour installer la version de production de SoosyzeCMS, il faudra télécharger et décompresser l’archive de la [dernière version du CMS](https://github.com/soosyze/soosyze/releases/download/1.0.0-alpha4.1/soosyze.zip) dans le répertoire qui hébergera votre site.

### Téléchargement via Git & Composer

Pour installer la version de développement de SoosyzeCMS, sont requis :

* Un serveur HTTP (*en ligne ou en local*) comme [Apache](http://httpd.apache.org/download.cgi) ou [Ngnix](https://nginx.org/en/download.html),
* L’outil de versionning Git pour :
  * [Windows](https://gitforwindows.org/),
  * [Mac](http://sourceforge.net/projects/git-osx-installer/),
  * Debian, Ubuntu et autres dérivés `sudo apt install git`,
  * Red Hat, Fedora, CentOS et autres dérivés `sudo yum install git`,
* L’installateur ou le fichier binaire [Composer](https://getcomposer.org/download/),
* La commande `php` dans vos variables d’environnement.

Quand vous disposerez de ces prérequis, vous pourrez alors vous rendre dans le répertoire de votre serveur, ouvrir une invite de commandes, et remplacer le terme `[my-directory]` par le répertoire qui hébergera votre site.

Clonez le repo avec Git sur votre serveur :

```sh
git clone https://github.com/soosyze/soosyze.git [my-directory]
cd [my-directory]
```

Installez les dépendances avec Composer (*assurez-vous que l’exécutable php est dans votre PATH*) :

```sh
composer install --no-dev
```

Ou si vous utilisez le fichier PHAR :

```sh
php composer.phar install --no-dev
```

Pour suivre les tutoriels, je vous invite à installer le CMS à la racine de votre serveur local et à conserver le répertoire par défaut `soosyze`.

### Installation du CMS

Maintenant que les fichiers sources sont au bon endroit, ouvrez un navigateur web (*Firefox, Chrome, Opéra, Safarie, Edge…*), et dans la barre d’adresse, entrez la valeur suivante :

* En local : [127.0.0.1/soosyze](http://127.0.0.1/soosyze),
* En ligne : votre nom de domaine.

La page suivante se présentera à vous. Remplissez tous les champs et cliquez sur **Installer**.

![Screenshot de la page d’instalaltion de SoosyzeCMS](/assets/user/install-desktop.png)

Et voilà, le CMS est installé !

## Configuration

### Ngnix

En supposant que vous ayez un site PHP configuré dans Nginx, ajoutez ce qui suit au bloc de configuration de votre serveur, pour vous assurer de la sécurité de Soosyze CMS :

```
include path\soosyze\.nginx.conf;
```