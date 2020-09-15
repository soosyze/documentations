# Configurer

Après l’installation de votre site, vous êtes redirigés vers la page d’accueil par défaut. Pour configurer votre site, vous devez d’abord vous connecter :

![Screenshot de la page d’accueil de SoosyzeCMS](/assets/user/soosyze-home.png)

## Configurer l’utilisateur

### Connexion utilisateur

Pour accéder au formulaire de connexion, cliquez sur le lien **_Connexion_** dans le menu utilisateur dans le pied de page de votre site (*accessible à n’importe quelle page*).

**Route** : `?q=user/login`

![Screenshot de la page de connexion de SoosyzeCMS](/assets/user/soosyze-user_login.png)

Saisissez votre e-mail et le mot de passe que vous avez choisi lors de l’installation dans les champs correspondants, puis cliquez sur **_Se connecter_**. 

* Si votre connexion est acceptée, vous serez redirigé vers la page de votre compte utilisateur,
* Si votre connexion échoue, un message vous en avertira.

**Route** : `?q=user/1`

![Screenshot de la page de profil utilisateur de SoosyzeCMS](/assets/user/soosyze-user_show.png)

### Configuer votre compte utilisateur

Une fois connecté, cliquez sur l’onglet **_Éditer_**, il s’agit de la page d’édition du compte utilisateur.

**Route** : `?q=user/1/edit`

![Screenshot de la page d’edition de l’utilisateur de SoosyzeCMS](/assets/user/soosyze-user_edit.png)

Vous pouvez modifier les informations y figurant. La modification de votre mot de passe doit cependant être confirmée dans les champs situés juste en dessous.

### Retrouver votre mot de passe

Si vous avez oublié votre mot de passe, cliquez sur le lien **_Mot de passe perdu ?_** en bas du formulaire de connexion. vous serez redirigé vers un formulaire.

**Route** : `?q=user/relogin`

![Screenshot de la page de demande de nouveau mot de passe de SoosyzeCMS](/assets/user/soosyze-user_relogin.png)

Vous recevrez un e-mail vous donnant la marche à suivre pour changer votre mot de passe.

## Configurer votre site

Pour vous rendre au panneau de configuration, cliquez sur le lien **_Configuration_** de votre menu d’administration.
Chaque onglet correspond à un type de configuration. Par défaut le CMS possède les onglets

* **_Fichier_** pour les configurations des fichiers,
* **_Blog_** pour les configurations des news,
* **_Contenu_** pour les configurations des contenus,
* **_Réseaux sociaux_** pour les liens de vos réseaux sociaux,
* **_Système_** pour les configurations global,
* **_Utilisateur_** pour les configurations utilisateur.

### Configurations des fichiers

**Route** : `?q=admin/config/filemanager`

![Screenshot de la page de configuration des fichiers de SoosyzeCMS](/assets/user/soosyze-config_filemanager.png)

1. **Comportement des transferts de fichiers** : par défaut "Remplacer le fichier par le nouveau".

À la fin de vos modifications, cliquez sur **_Enregistrer_** en base du formulaire pour les valider.

### Configurations des news

**Route** : `?q=admin/config/news`

![Screenshot de la page de configuration des news de SoosyzeCMS](/assets/user/soosyze-config_news.png)

1. **Nombre d'articles par page** : par défaut à 6 articles,
2. **Image par défaut** : Si un article de blog ne possède pas d'image, celle-ci sera remplacée par celle par défaut,
3. **Icône par défaut** : Si un article de blog ne possède pas d'image et que l'image par défaut est manquante, une icône FontAwesome sera affichée.

À la fin de vos modifications, cliquez sur **_Enregistrer_** en base du formulaire pour les valider.

### Configurations des nodes

**Route** : `?q=admin/config/node`

![Screenshot de la page de configuration des node de SoosyzeCMS](/assets/user/soosyze-config_node.png)

1. **Url par défaut** : S'applique à tous les types de contenu si les modèles par types sont vides,
2. **Page** : Url du type de contenu `Page`,
3. **Page privée** : Url du type de contenu `Page privée`,
4. **Article** : Url du type de contenu `Article`.

Ces modèles génére les Urls de vos contenus si vous ne la précisez pas manuellement à leurs créations ou éditions.
Plusieurs variables sont autorisées comme motifs de remplacements à l'enregistrement de vos contenus.

Exemple, la valeur par défaut des articles est `news/:date_created_year/:date_created_month/:date_created_day/:node_title`.
Si vous créez  un article qui a pour nom "Bienvenue" le 20 décembre 2020 l'url générée sera `news/2020/12/20/bienvenue-sur-mon-site`

5. **Activer la publication automatique des contenus CRON** : 

En activant la publication automatiques des contenus, vous pouvez choisir dans l'interface d'ajout et de modification de vos contenus le status "En attente de publication"  et une date de publication supérieur à la date courante.

Quand votre planificateur de tâche s'executera, tous les contenus en attente seront publiée et visible sur votre site.

### Configurations global

**Route** : `?q=admin/config/system`

![Screenshot de la page de configuration global de SoosyzeCMS](/assets/user/soosyze-config_system.png)

1. **Langue** : langue par défaut de l'interface d'administration,
2. **Fuseau horaire** : langue par défaut de l'interface d'administration,
3. **E-mail du site** : mail utilisé pour la configuration générale, pour vos contacts (*pour la récupération de votre mot de passe...*),
4. **Mettre le site en maintenance** : empêche les utilisateurs non connectés d’accéder à votre site,
5. **Rendre les URL propres** : simplifie les URL du site en masquant le paramètre `?q=`,
6. **Thème du site** : liste d’affichages disponibles pour votre site,
7. **Thème d’administration du site** : liste d’affichages disponibles pour l’administration votre site,
8. **Activer le mode sombre pour le thème administrateur si disponible**,
9. **Logo** : champ de téléchargement pour votre logo,
10. **Page d’accueil par defaut** : le lien du contenu affiché en page d’accueil de votre site,
11. **Page 403 par défaut (accès refusé)** : lien du contenu affiché si un utilisateur accède à une page qui lui est interdite,
12. **Page 404 par défaut (page non trouvée)** : lien du contenu affiché si un utilisateur accède à une page qui n’existe pas,
13. **Page de maintenance par défaut** : lien du contenu affiché si le site est en maintenance,
14. **Titre du site** : Le titre principal de votre site apparait aussi dans le titre de la fenêtre de votre navigateur,
15. **Description** : vous aide à votre référencement et s’affiche dans les moteurs de recherche,
16. **Mots-clés** : vous aide au référencement de votre site dans les moteurs de recherche,
17. **Favicon** : champ de téléchargement pour votre favicon (*image à gauche du titre de la fenêtre de votre navigateur*).

À la fin de vos modifications, cliquez sur **_Enregistrer_** en base du formulaire pour les valider.

### Configurations utilisateur

**Route** : `?q=admin/config/user`

![Screenshot de la page de configuration utilisateur de SoosyzeCMS](/assets/user/soosyze-config_user.png)

1. **Protection des routes de connexion** : Dans le cas ou le site est géré par une équipe restreinte, pour mieux protéger vos formulaire de connexion vous pouvez choisir un suffixe à l'URL.Exemple : `Ab1P-9eM_s8Y` = `user/login/Ab1P-9eM_s8Y`,
2. **Page de redirection après connexion** : Définit la route de redirection après la connexcion des utilisateurs,
3. **Ouvrir l'inscription** : Donne l'accès au formulaire d'inscription,
4. **Activer les CGU** : Contraint les nouveau utilisateur à accepter les _conditions générale d'utilisation_ du site,
5. **Page des CGU** : La page de vos CGU,
6. **Activer la politique de confidentialité des données** : Contraint les nouveau utilisateur à accepter la _politique de confidentialité des données_ du site,
7. **Page RGPD** : La page de la politique de confidentialité des données,
8. **Ouvrir la récupération de mot de passe** : Donne l'accès au formulaire de récupération de mot de passe (très utile pour éviter le SPAM si le site est géré par un seul utilisateur),
9. **Ajout d'un bouton pour visualiser les mots de passe** : Permet aux utilisateurs de voir leurs mots de passe,
10. **Longueur minimum** : Nombre de caractère minimum des mots de passes (minimum par défaut 8),
11. **Nombre de caractères majuscule** : Nombre de caractère majuscule de A à Z,
12. **Nombre de caractères numérique** : Nombre de caractère numérique de 0 à 9,
13. **Nombre de caractères spéciaux** Nombre de caractère spéciaux (tous les caractères non alpha numérique et underscore).

Si le nombre de caractère majuscule, numérique et spéciaux dépasse la longueur minimum alors celle-ci n'est plus valable.

À la fin de vos modifications, cliquez sur **_Enregistrer_** en base du formulaire pour les valider.

## Configurer les modules

Pour accéder à la page de vos modules, cliquez sur le lien **_Modules_** dans le menu d’administration.

**Route** : `?q=admin/modules`

![Screenshot de la page de gestion des modules de SoosyzeCMS](/assets/user/soosyze-modules.png)

Un module **requis** signifie que ce module est utilisé par un autre module déja actif.

Exemple : le module News utilise le module Node, donc Node **est requis** par News.

### Installer un module

1. Téléchargez parmi [les modules contributeurs](https://soosyze.com/download/modules) celui que vous souhaitez installer,
2. Connectez-vous à votre serveur et rendez-vous dans le répertoire contenant SoosyzeCMS,
3. Rendez-vous dans le repértoire **app/modules** et déposez le module téléchargé, décompressé de son archive,
4. Allez sur la page de gestion de vos modules sur votre site,
5. Cliquez sur sur le bouton à gauche du nom du module,
6. Et cliquez sur **_Enregistrer_** en bas de votre page.

## Lexique

**Route** : Il s'agit du chemin de l'URL pour afficher les pages de Soosyze.

Par exemple, pour l'URL `https://monsite.fr?q=admin/filemanager/show` :
* Votre **nom de domaine** est `https://monsite.fr`,
* Le **paramètre** `?q=` permet de lire les routes pour les URLs non réécrites,
* Et la **route** est `admin/filemanager/show`.

[Étape 4 : Gérer](/user/03_gérer.md)