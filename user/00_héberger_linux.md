# Tutoriel d'hébérgement avec Apache et PHP pour Ubuntu/Debian

Notre tutoriel sera centré sur l’installation du logiciel Apache (votre serveur web), du langage PHP (le langage de développement utilisé pour Soosyze) et de Composer (gestionnaire de dépendances).

Nous précisons également qu’il a été réalisé sur une instance d’Ubuntu 18 vierge et uniquement en ligne de commande.

**Pour info !** si vous n'avez jamais utilisé des lignes de commandes, ce n'est pas grave. Vous n'avez qu'à vous laisser guider par les instructions pour réaliser l'installation.

## Pré-requis

Vous allez commencer par ouvrir un terminal de commande. Clique droit sur votre bureau et "Ouvrir un terminal" :

![Screenshot de l'ouverture du terminal sous Ubuntu](/assets/user/ubuntu-apache-cmd.png)

Nous allons vérifier qu'Apache et PHP ne sont pas déjà installés sur votre système. Lancer la commande suivante sur votre terminal :

```sh
dpkg -l apache php
```

Si vous avez le même retour que celui sur la capture d'écran vous allez devoir tout installer :p

![Screenshot de la commande dpkg sous Ubuntu](/assets/user/ubuntu-apache-dpkg.png)

Avant toutes opérations d'installations sur Linux il est recommandé de mettre à jour le gestionnaire de paquet que nous allons utiliser. Dans notre cas nous utiliserons le gestionnaire [apt](https://fr.wikipedia.org/wiki/Advanced_Packaging_Tool). Lancer la commande suivante sur votre terminal :

```
sudo apt-get update
```

Cette commande va mettre à jour la liste des logiciels installables.

**Pour info !** Ne connaissant pas votre configuration de départ, vous noterez que nous utilisons la commande `sudo` avant toutes autres commandes qui nécessitent des droits Administrateurs.

Il est possible que des paquets manquent selon, votre configuration ou la version d'Ubuntu que vous utilisez.
Pour régler ce problème vous allez devoir changer le paramétrage des sources des paquets. Lancer la commande suivante sur votre terminale :

```
sudo nano /etc/apt/sources.list
```

![Screenshot de la commande nano sous Ubuntu](/assets/user/ubuntu-apache-sources-restricted.png)

La commande `nano` spécifie que nous souhaitons utiliser le logiciel de traitement de texte [GNU nano](https://fr.wikipedia.org/wiki/GNU_nano) dans le terminal. Modifier les paramètres `restrected` en `universe` aux lignes suivantes :

```
deb http://archive.ubuntu.com/ubuntu bionic main universe
deb http://archive.ubuntu.com/ubuntu bionic-security main universe
deb http://archive.ubuntu.com/ubuntu bionic-updates main universe
```

Pour enregistrer sous nano appuyer sur les touches suivantes : `Ctrl + X` puis `o` pour confirmer et `Entrée` pour valider le nom du fichier d'enregistrement. 
Pour finir, relancer la commande `sudo apt-get update` pour actualiser la liste des logiciels installables.

## Installer Apache

Pour installer **Apache** lancer la commande suivante sur votre terminal :

```
sudo apt-get install apache2
```

Votre terminal vous demandera de confirmer l’installation en tapant sur le caractère `O`.

![Screenshot de la commande apt-get install apache2 sous Ubuntu](/assets/user/ubuntu-apache-install-apache.png)

## Installer PHP

Pour installer **PHP** plusieurs solutions :

* Installer les paquets un par un,
* Installer un ensemble de paquets.

C'est pour cette dernière solution que nous allons opter. Lancer la commande suivante sur votre terminal :

```
sudo apt-get install php libapache2-mod-php
```

Cette ligne de commande va télécharger, dés-comprésser et installer **PHP** en plus de quelques paquets très utiles comme :

* `php-common` fournit des commandes de gestions de modules,
* `php-json` lecture de fichiers au format JSON
* `php-cli` exécuter PHP dans le terminal via la commande php,
* `php-opcache` améliore les performances de PHP...

Votre terminal vous demandera de confirmer l’installation en tapant sur le caractère `O`.

![Screenshot de la commande apt-get install php libapache2-mod-php sous Ubuntu](/assets/user/ubuntu-apache-install-php.png)

## Vérifier que PHP est bien installé

Lancer la commande suivante sur votre terminal :

```
php -v
```

Le résultat doit être un message affichant la version de PHP :

![Screenshot de la commande php -v sous Ubuntu](/assets/user/ubuntu-apache-php-v.png)

## Lancer Apache

Pour lancer **Apache** lancer la commande suivante :

```
service apache2 start
```

Et pour vérifier si Apache fonctionne bien, ouvrez votre navigateur favori et aller à l'URL suivante : http://127.0.0.1

![Screenshot de la commande service apache2 start sous Ubuntu](/assets/user/ubuntu-apache-start.png)

Et voilà ! Normalement vous avez installé le logiciel **Apache** et le langage **PHP**.

Pour tout problème rencontré, n’hésitez pas à vous renseigner la documentation d’Apache. N’hésitez pas non plus à nous contacter si ce tutoriel n’est plus à jour.
