﻿# Installer

Si vous avez suivi le chapitre précédent, vous savez qu’il existe deux façons d’héberger votre site web. Cette distinction se fera aussi pour l’installation du CMS.

Dans un premier temps, [téléchargez l’archive de SoosyzeCMS sur votre ordinateur](https://github.com/soosyze/soosyze/releases/download/1.0.0-alpha4.1/soosyze.zip).

Cette archive contient les fichiers sources de l’application. Vous devez donc déposer ces fichiers en local ou en ligne. Une fois les fichiers sources au bon endroit, vous allez enfin pouvoir installer le CMS.

## Déposer le code source en local

Dans le chapitre précédent, nous avons expliqué comment installer WampServer 3 (*WAMP*) pour faire fonctionner votre site en local. Ici, nous verrons où déposer Soosyze dans WAMP pour le faire fonctionner.

1. Lancez WAMP,
2. Rendez-vous à la racine du disque sur lequel vous avez installé WAMP, généralement C:\ ou D:\ ,
3. Allez dans le répertoire \wamp (*ou \wamp64*),
4. Et enfin dans le dossier \www,
5. Copiez/Collez l’archive de SoosyzeCMS dans ce dossier,
6. Décompressez l’archive.

Le dossier \www est le point d’entrée de vos applications web sous WAMP, tous les fichiers sources doivent être dans ce répértoire.

Par défaut, les fichiers sources de SoosyzeCMS sont contenus dans le répértoire \Soosyze : à vous d’organiser vos projets comme bon vous semble.

[Vous voilà prêts à installer SoosyzeCMS](#installer-le-cms).

## Déposer le code source en ligne

Si vous en êtes à ce paragraphe, c’est que vous avez souscrit à une offre d’hébergement en ligne.  
Pour déposer les fichiers sources de l’application, vous devez avoir un accès entre votre ordinateur et le serveur en ligne.

Vous devez au préalable installer un client FTP.

**Pour info** un client FTP est un logiciel utilisant (*entre autres*) le protocole de communication FTP (*File Transfer Protocol*) qui permet de déposer, modifier ou supprimer des fichiers depuis une machine/ordinateur à distance. C’est grâce à ce logiciel que vous aurez accès au serveur qui hébergera votre site.

### FileZilla

Il en existe plusiseurs, mais nous nous focaliserons sur le logiciel FileZilla. C’est un logiciel très répandu et disponible pour Windows, Mac OS et GNU/Linux.

1. Rendez-vous sur le [site de FileZilla](https://dillinger.io/https://filezilla-project.org/),
2. Téléchargez FileZilla Client,
3. Installez-le et Lancez le logiciel.

#### Connexion à votre serveur

Souvenez-vous, à la fin de "étape 1 : Héberger", je vous avais préconisé de conserver les identifiants de connexion fournis par votre hébergeur :

*  **Nom d’Hôte**,
*  **Protocole** (*dans 99% des cas c’est du FTP ou SFTP, si votre hébérgeur vous le permet*),
*  Votre **identifiant**,
*  Et votre **mot de passe**.

C’est maintenant que nous allons les utiliser :

1. Lancez l’execution de FileZilla,
2. En haut à gauche de la fenêtre, cliquez sur le bouton **_Gestionnaire de Sites_** (*le titre des bouttons s’affiche au survol de la souris*),
3. Une fenêtre modale s’affiche, cliquez sur **_Nouveau Site_**,
4. Renommez l’item qui vient d’apparaître,
5. Toujours dans la fenêtre modale **Gestionnaire de sites**, dans l’onglet *Général*, remplissez les champs correspondants :
  a. **Protocole** : FTP - Protocole de Transert de Fichiers (*si votre hébergeur vous permet le SFTP, je vous conseille de l’utiliser*),
  b. **Hôte** : Le nom d’hôte fourni par votre hébérgeur (*il s’agit du nom du serveur accueillant vos applications*), 
  c. **Chiffrement** : Connexion FTP simple,
  d. **Type d’autentification** : (*À vous de voir ce qui vous convient le mieux, je recommande l’option Demander le mot de passe*).
  e. **Identifiant** : Inscrivez l’identifiant fourni par votre hébérgeur,
6. Puis cliquez sur **_Connexion_**.
7. Une nouvelle fenêtre s’ouvrira : renseignez le mot de passe puis validez.


![Screen FileZilla et gestionnaire de sites](/assets/user/filezilla.png)

Vous voilà connecté à votre serveur :
8. Décompressez l’archive de Soosyze CMS, 
9. Sélectionnez tout le code source et glissez-le dans le répertoire de votre serveur.

Le répertoire qui est censé recevoir le code source est souvent nommé par défaut **www**, mais attention : ce n’est pas systématiquement le cas. Renseignez-vous auprès de votre hébergeur.

[Et voilà, vous êtes prêt à installer SoosyzeCMS](#installer-le-cms).

## Installer le CMS

Maintenant que les fichiers sources sont au bon endroit, ouvrez un navigateur web (*Firefox, Chrome, Opéra, Safarie, Edge…*), et dans la barre d’adresse, entrez la valeur suivante :

*   en local, [127.0.0.1/Soosyze](http://127.0.0.1/Soosyze),
*   en ligne, votre nom de domaine.

La page suivante se présentera à vous. Remplissez tous les champs et cliquez sur **_Installer_**.

![Screenshot de la page d’instalaltion de SoosyzeCMS](/assets/user/install-desktop.png)

Et voilà, le CMS est installé.