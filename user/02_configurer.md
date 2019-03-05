﻿# Configurer

Après l’installation de votre site, vous êtes redirigés vers la page d’accueil par défaut de votre site. Pour configurer votre site, vous devez d’abord vous connecter.

![Screenshot de la page d’accueil de SoosyzeCMS](/assets/user/soosyze-accueil-desktop.png)

## Configurer l’utilisateur

### Connexion utilisateur

Pour accéder au formulaire de connexion, cliquer sur le lien **_Connexion_** dans le menu utilisateur en bas à droite de votre site (*accessible à n’importe quelle page*).

`GET ?user/login`

![Screenshot de la page de connexion de SoosyzeCMS](/assets/user/soosyze-user_login-desktop.png)

Saisissez votre e-mail et le mot de passe que vous avez choisi lors de l’installation dans les champs correspondants, puis cliquez sur **_Valider_**. 

* Si votre connexion est acceptée, vous serez redirigé vers la page de votre compte utilisateur,
* Si votre connexion échoue, un message vous en avertira.

`GET ?user/1`

![Screenshot de la page de profil utilisateur de SoosyzeCMS](/assets/user/soosyze-user_show-desktop.png)

### Configuer votre compte utilisateur

Une fois connecté, cliquez sur l’onglet **_Utilisateur_** de votre menu d’administration, il s’agit de la page d’édition du compte utilisateur.

`GET ?user/1/edit`

![Screenshot de la page d’edition de l’utilisateur de SoosyzeCMS](/assets/user/soosyze-user_edit-desktop.png)

Vous pouvez modifier les informations y figurant. La modification de votre mot de passe doit cependant être confirmée dans les champs situés juste en dessous.

### Retrouver votre mot de passe

Si vous avez oublié votre mot de passe, cliquez sur le lien **_Mot de passe perdu ?_** en bas du formulaire de connexion. vous serez redirigé vers un formulaire.

`GET ?user/relogin`

![Screenshot de la page de demande de nouveau mot de passe de SoosyzeCMS](/assets/user/soosyze-user_relogin-desktop.png)

Vous recevrez un e-mail vous donnant la marche à suivre pour changer votre mot de passe.

## Configurer votre site

Pour vous rendre au panneau de configuration, cliquez sur le lien **_Configuration_** de votre menu d’administration.

`GET ?admin/config`

![Screenshot de la page de configuration de SoosyzeCMS](/assets/user/soosyze-configuration-desktop.png)

1. **E-mail du site** : mail utilisé pour la configuration générale, pour vos contacts (*pour la récupération de votre mot de passe...*),
2. **Mettre le site en maintenance** : empêche les utilisateurs non connectés d’accéder à votre site,
3. **Thème du site** : liste d’affichages disponibles pour votre site,
4. **Thème d’administration du site** : liste d’affichages disponibles pour l’administration votre site,
5. **Logo** : Champ de téléchargement pour votre logo,
6. **Page d’accueil par defaut** : le lien du contenu affiché en page d’accueil de votre site,
7. **Page 403** par défaut (*accès refusé*) : lien du contenu affiché si un utilisateur accède à une page qui lui est interdite,
8. **Page 404** par défaut (*page non trouvée*) : lien du contenu affiché si un utilisateur accède à une page qui n’existe pas,
9. **Titre du site** : Le titre principal de votre site apparait aussi dans le titre de la fenêtre de votre navigateur,
10. **Description** : vous aide à votre référencement et s’affiche dans les moteurs de recherche,
11. **Mots-clés** : vous aide au référencement de votre site dans les moteurs de recherche,
12. **Favicon** : Champ de téléchargement pour votre favicon (*image à gauche du titre de la fenêtre de votre navigateur*).

Chaque modification devra être validée en cliquant sur **_Enregistrer_** en bas du formulaire.

## Configurer les modules

Pour accéder à la page de vos modules, cliquez sur le lien **_Modules_** dans le menu d’administration.

`GET ?admin/modules`

![Screenshot de la page d’e gestion des modules de SoosyzeCMS](/assets/user/soosyze-modules-desktop.png)

Un module **requis** signifie que ce module est utilisé par un autre module déja actif.

Exemple : le module News utilise le module Node, donc Node **est requis** par News.

### Installer un module

1. Téléchargez parmi [les modules contributeurs](#) lequel vous souhaitez installer,
2. Connectez-vous à votre serveur est rendez-vous dans le répertoire contenant SoosyzeCMS,
3. Rendez-vous dans le repértoire **app/modules** et déposez le module téléchargé, décompressé de son archive,
4. Allez sur la page de gestion de vos modules sur votre site,
5. Cliquez sur sur le bouton à gauche du nom du module,
6. Et cliquez sur **_Enregistrer_** en bas de votre page.