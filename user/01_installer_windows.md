# Déposer le code source en local dans **WampServeur 3**(Apache) pour Windows

Dans le chapitre précédent, nous avons expliqué comment installer WampServer 3 (*WAMP*) pour faire fonctionner votre site en local. Ici, nous verrons où déposer Soosyze dans WAMP pour le faire fonctionner.
Mais avant nous allons nous assurer que vous avez tous les pré requis pour le bon fonctionnement de Soosyze.

## Vérifier les prés requis

Soosyze requière plusieurs extensions nécessaires à son fonctionnement, il se peut que certaines soient désactivées de bases, vous devrez donc les identifier et les activer.

Assurer vous que WAMP soit lancé et cliquer sur son icone dans la barre de menu en base à droite, aller dans PHP > Extensions PHP et vérifier que les extensions requises soient activées :

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