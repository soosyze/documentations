# Déposer le code source dans Apache pour Linux (Ubuntu/Debian)

Dans le chapitre précédent, nous avons expliqué comment installer Apache et PHP pour faire fonctionner votre site en local. Ici, nous verrons où déposer Soosyze pour le faire fonctionner.
Mais avant nous allons nous assurer que vous avez tous les pré requis pour le bon fonctionnement de Soosyze.

## Vérifier les prés requis

Soosyze requière plusieurs extensions nécessaires à son fonctionnement, cependant, il se peut que certaines viennent à manquer dans les paquets de bases, vous devrez donc les identifier et les installer.

La commande suivante listera les extensions actuellement installées, à vous d'identifier celles qui manquent :

```
php -m
```

**Pour info !** D'expérience, les bibliothèques `gd`, `mbstring` et `date`, `zip` ne sont pas fournies systématiquement avec le paquet PHP de base, pour les installer, lancer la commande suivante :

```
sudo apt-get install php-mbstring php-date php-gd php-xml php-zip
```

Vous noterez que cette commande contient également les extensions `php-xml`. Celle-ci est utilisée par **Composer** (*[cf. le point suivant](#installer-composer)*).

![Screenshot de l'ajout d'extensions php sous Ubuntu](/assets/user/ubuntu-apache-install-php_extensions.png)

Pour vérifier que les bibliothèques sont bien installées et activées lancer la commande suivante :

```
php -m
```

Vérifier également que ces bibliothèques se soient bien installées et activées au niveau d'**Apache**, lancer la commande suivante :

```
php -c /etc/php/php/7.2/apache2/php.ini -m
```

* `-c` pour charger un fichier de configuration
* `/ect/php/7.2/apache2/php.ini` fichier de configuration PHP de Apache,
* `-m` lister les extensions installées et activées.

Si une configuration venait à manquer vous pouvez manipuler les extensions PHP de la façon suivante :

Activer une extension PHP :
```
# Activer mbstring partout
sudo phpenmod mbstring

# Activer mbstring pour la version 7.2 de PHP uniquement
phpenmod -v 7.2 mbstring

# Activer mbstring pour le SAPI (API de PHP) apache uniquement (cli , fpm , apache2...)
sudo phpenmod -s apache2 mbstring
```

Désactiver une extension PHP :
```
# Désactiver mbstring partout
sudo phpdismod mbstring

# Désactiver mbstring pour la version 7.2 de PHP uniquement
sudo phpdismod -v 7.2 mbstring

# Désactiver mbstring pour le SAPI (API de PHP) apache uniquement (cli , fpm , apache2...)
sudo phpdismod -s apache2 mbstring
```

## Installer Composer

Pour installer Soosyze nous allons utiliser le gestionnaire de dépendances **Composer** qu'il faut installer sur votre machine en lançant la commande suivante :

```
sudo apt-get install composer
```

![Screenshot de la commande apt-get install composer sous Ubuntu](/assets/user/ubuntu-apache-install-composer.png)

Pour vérifier que Composer est bien installé lancer la commande suivante :

```
composer -v
```

![Screenshot de la commande composer -v sous Ubuntu](/assets/user/ubuntu-apache-composer-v.png)

## Déposer le code source

Maintenant que toutes les extensions et outils sont installés, vous allez pouvoir enfin installer Soosyze. Rendez-vous dans le répertoire qui contiendra vos site web en lançant la commande suivante :

```
cd /var/www/html
```

Et lancer le téléchargement et l'installation des dépendances de Soosyze avec la commande suivante :

```
sudo composer create-project soosyze/soosyze --stability=beta –-no-dev
```

### Attribuer les droits utilisateurs

Dernière étape avant que vous puissiez enfin utiliser Soosyze. Il faut savoir que Soosyze comme la majorité des CMS utilisent des fonctions d'écritures (*pour les fichiers de config, traitement d'image...*). Vous devez donc attribuer les bons droits afin que Soosyze puisse écrire dans des fichiers.

Commencer par lancer la commande suivante qui attribue à l'utilisateur `www:data` les droits du groupe `www:data` sur le répertoire du CMS de façon récursive (*pour appliquer les droits à tous ses sous dossiers*):

```
sudo chown -R www-data:www-data /var/www/html/soosyze 
```

Ajouter des droits d'écriture au groupe sur le répertoire pour que l'utilisateur www-data puisse écrire dedans. Lancer la commande suivante :

```
sudo chmod -R g+w /var/www/html/soosyze
```

Et voilà vous avez fini toute l'installation des sources de Soosyze, mais pour finir, lancer la commande suivante pour relancer Apache afin d'être sûre qu'il prenne en compte toutes ces dernières modifications :

```
service apache2 restart
```

[Vous voilà prêts à installer SoosyzeCMS](/user/01_installer.md#installer-le-cms).