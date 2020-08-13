# Structure du CMS

```
soosyze/
├─ app/ Le code source de votre site.
│  ├─ config/
│  │  ├─ database.json
│  │  └─ settings.json
│  │
│  ├─ data/
│  ├─ files/public/
│  ├─ lang/
│  ├─ modules/
│  ├─ themes/
│  └─ app_core.php
│
├─ bootstrap/ Fichier de lancement du Framework.
│  ├─ autoload.php
│  ├─ debug.php
│  ├─ facade.php
│  ├─ requirements.php
│  ├─ start.php
│  ├─ start_cli.php
│  ├─ validator_custom.php
│  └─ validator_messages_fr.php
│
├─ core/ Le code source des modules et thèmes par défauts du CMS.
│  ├─ modules/
│  │  ├─ BackupManager/
│  │  ├─ Block/
│  │  ├─ Config/
│  │  ├─ Contact/
│  │  ├─ FileManager/
│  │  ├─ FileSystem/
│  │  ├─ Menu/
│  │  ├─ News/
│  │  ├─ Node/
│  │  ├─ QueryBuilder/
│  │  ├─ System/
│  │  ├─ Template/
│  │  ├─ Translate/
│  │  ├─ Trumbowyg/
│  │  └─ User/
│  │
│  └─ themes/
│      ├─ Admin/
│      ├─ Bootstrap3/
│      └─ QuietBlue/
│
└─ vendor/ Les dépendances du projet.
    ├─ ircmaxell/password-compat/
    ├─ paragonie/random_compat/
    ├─ psr/
    │  ├─ container/
    │  └─ http-message/
    │
    └─ soosyse/
       ├─ framework/
       └─ queryflatfile/
```

Le répertoire `app` contient l’ensemble de la configuration de votre application :

* `app/config` : fichiers de paramétrage,
* `app/data`  : données de votre site au format JSON (*format par défaut*),
* `app/files` : ressources multimédia téléversées depuis votre site,
* `app/lang` : données de traduction de l'interface (*uniquement dans SoosyzeCMS*),
* `app/modules` : modules contributeurs (*uniquement dans SoosyzeCMS*),
* `app/themes` : thèmes contributeurs (*uniquement dans SoosyzeCMS*),
* `app/app_core.php` : dcript de votre application (*les modules utilisés par SoosyzeCMS*).

Le répértoire `core` contient l’ensemble du code source :

* `core/modules` : modules de base du CMS (la logique de votre site),
* `core/themes` : thèmes de base du CMS.

Le répertoire `vendor` contient toutes les bibliothèques nécessaires au bon fonctionnement de l’application :

* `ircmaxell/password-compat` : bibliothèque qui permet de hasher les mots de passe en version 5.4 de PHP,
* `ircmaxell/password-compat` : bliothèque qui permet de génère des octets pseudo-aléatoire cryptographiquement sécurisé en version 5 de PHP,
* `psr/container` : interface pour le CID [![PSR-11](https://img.shields.io/badge/PSR-11-yellow.svg)](https://www.php-fig.org/psr/psr-11 "Container Interface"),
* `psr/http-message` : interface pour les objets Request, Response, Message, Uri… [![PSR-7](https://img.shields.io/badge/PSR-7-yellow.svg)](https://www.php-fig.org/psr/psr-7 "HTTP Message Interface"),
* `soosyze/queryflatfile` : bibliothèque qui permet de manipuler des fichiers JSON comme une base de données,
* `soosyze/framework` : framework sur lequel se base SoosyzeCMS.
