# Structure du CMS

```
www/
├─ app/ Le code source de votre site.
│  ├─ config/
│  │  ├─ database.json
│  │  └─ settings.json
│  │
│  ├─ data/
│  ├─ files/
│  ├─ modules/
│  ├─ themes/
│  └─ app_core.php
│
├─ bootstrap/ Fichier de lancement du Framework.
│  ├─ autoload.php
│  ├─ debug.php
│  ├─ requirements.php
│  └─ start.php
│
├─ core/ Le code source des modules et thèmes par défauts du CMS.
│  ├─ modules/
│  │  ├─ Contact/
│  │  ├─ FileSystem/
│  │  ├─ Install/
│  │  ├─ Menu/
│  │  ├─ News/
│  │  ├─ Node/
│  │  ├─ QueryBuilder/
│  │  ├─ System/
│  │  ├─ Template/
│  │  └─ User/
│  │
│  └─ themes/
│      ├─ Admin/
│      ├─ Bootstrap 3/
│      └─ Quiet Blue/
│
└─ vendor/
    ├─ ircmaxell/password-compat/
    ├─ psr/
    │  ├─ container/
    │  └─ http-message/
    │
    └─ soosyse/
       ├─ framework/
       └─ queryflatfile/
```

Le répertoire `app` contient l’ensemble de la configuration de votre application :

* `app/config` : les fichiers de paramétrage,
* `app/data`  : les données de votre site au format JSON (*format par défaut*),
* `app/files` : les ressources multimédia téléversées depuis votre site,
* `app/modules` : les modules contributeurs (*uniquement dans SoosyzeCMS*),
* `app/themes` : les thèmes contributeurs (*uniquement dans SoosyzeCMS*),
* `app/app_core.php` : le script de votre application (*les modules utilisés par SoosyzeCMS*).

Le répértoire `core` contient l’ensemble du code source :

* `core/modules` : l’ensemble de la logique de votre site,
* `core/themes` : les thèmes de base du CMS.

Le répertoire `vendor` contient toutes les bibliothèques nécessaires au bon fonctionnement de l’application :

* `ircmaxell/password-compat` : la bibliothèque qui permet de hasher les mots de passe en version 5.4 de PHP,
* `psr/container` : l’interface pour le CID [![PSR-11](https://img.shields.io/badge/PSR-11-yellow.svg)](https://www.php-fig.org/psr/psr-11 "Container Interface"),
* `psr/http-message` : l’interface pour les objets Request, Response, Message, Uri… [![PSR-7](https://img.shields.io/badge/PSR-7-yellow.svg)](https://www.php-fig.org/psr/psr-7 "HTTP Message Interface"),
* `soosyze/queryflatfile` : la bibliothèque qui permet de manipuler des fichiers JSON comme une base de données,
* `soosyze/framework` : le framework sur lequel se base SoosyzeCMS.
