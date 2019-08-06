### Déposer le code source en local dans **WampServeur 3**(Apache) pour Windows

Dans le chapitre précédent, nous avons expliqué comment installer WampServer 3 (*WAMP*) pour faire fonctionner votre site en local. Ici, nous verrons où déposer Soosyze dans WAMP pour le faire fonctionner.
Mais avant nous allons nous assurer que vous avez tous les pré requis pour le bon fonctionnement de Soosyze.

## Prés requis

Soosyze requière plusieurs extensions nécessaires à son fonctionnement :

* `date` pour le format des dates, 
* `fileinfo` pour la validation de fichier, 
* `filter` pour valider vos données, 
* `gd` pour la maniplation d'image, 
* `json` pour l'enregistrement des données et des configurations, 
* `mbstring` pour vos emails, 
* `session` pour garder en mémoire vos données (coté serveur) d'une page à l'autre.

Cependant, il se peut que certaines viennent à manquer dans les paquets de bases, vous devrez donc les identifier et les installer.

Assurer vous que WAMP soit lancé et cliquer sur son icone dans la barre de menu en base à droite :

Aller dans Apache > Modules Apache et vérifier que les extensions requises soient activées :

![Screenshot de la extension php WAMP](/assets/user/windows-wamp-extensions.png)

## Déposer le code source 

Dans un premier temps, [téléchargez l’archive de la dernière version SoosyzeCMS sur votre ordinateur](https://github.com/soosyze/soosyze/releases/latest/download/soosyze.zip).

Cette archive contient les fichiers source de l’application. Vous devez donc déposer ces fichiers en local ou en ligne. Une fois les fichiers source au bon endroit, vous allez enfin pouvoir installer le CMS.

1. Lancez WAMP (*si ce n'est déjà fait*),
2. Rendez-vous à la racine du disque sur lequel vous avez installé WAMP, généralement `C:\` (*ou `D:\`*) ,
3. Allez dans le répertoire `\wamp` (*ou `\wamp64`*),
4. Et enfin dans le dossier `\www`,
5. Copiez/Collez l’archive de SoosyzeCMS dans ce dossier,
6. Décompressez l’archive.

Le dossier `\www` est le point d’entrée de vos applications web sous WAMP, tous les fichiers sources doivent être dans ce répértoire.

Par défaut, les fichiers sources de SoosyzeCMS sont contenus dans le répértoire `\soosyze` : à vous d’organiser vos projets comme bon vous semble.

[Vous voilà prêts à installer SoosyzeCMS](/user/01_installer.md#installer-le-cms).