# Gérer

Maintenant que votre site et installé et configuré, il ne reste plus qu’à étudier la gestion de vos contenus et leur accessibilité.

La gestion des contenus fonctionne sous le principe du **CRUD** :

* **C**reate (*ex :  Créer des pages*),
* **R**ead (*ex : Lire/consulter des pages*),
* **U**pdate (*ex : Mettre à jour des pages*),
* **D**elete (*ex : Supprimer des pages*).

Si vous comprenez ça, vous avez compris plus de 50% du fonctionnement d’un CMS, car il a pour but de gérer du contenu à partir d’une interface web. Bref ! Passons au cas pratique.

## Gérer vos contenus

Rendez-vous sur la page de gestion de vos contenus en cliquant sur le lien **_Contenu_** dans le menu administrateur. Cette page visualise tous les contenus de votre site, leurs dates de création, de modifiaction et leurs états de publication.

**Pour info !** Vos contenus sont gérés par le module **Node** de SoosyzeCMS, il permet **créer des types de contenus.** Les types de contenus permettent de créer et mettre en forme vos données, par exemple une **page**, une **page privée** ou un **article**.

**Route** : `?q=admin/node`

![Screenshot de la page de gestion des contenus de SoosyzeCMS](/assets/user/soosyze-node_admin.png)

### Créer du contenu

Cliquez sur le bouton **_Ajouter du contenu_** en haut à gauche de la page de gestion de vos contenus.

Vous serez redirigé à la page des types de contenus. Par défaut vous avez le choix entre créer une **Page** pour votre site ou un **Article**.

**Route** : `?q=admin/node/add`

![Screenshot de la page des types de contenu de SoosyzeCMS](/assets/user/soosyze-node_add.png)

Cliquez sur l'un des bouton d'ajout pour selectionner le type de contenu que vous souhaitez créer.
Prenons par exemple le type de contenu Page :

Par défaut vous vous situé dans l'onglet Contenu, il correspond au champs que vous devez remplir pour créer du contenu.

Quel que soit le type de contenu vous devez préciser le titre. Les champs en dessous correspondent aux données nécessaire au contenu. 
Dans le cas d'un article en plus du champ Corp, les champs Résumé et image sont présents.

Dans l'onglet Publication vous pouvez choisir :

* D'**Épingler le contenu** pour qu'il soit présenté en 1er dans les listes d'affichages (comme la liste des news ou dans la page d'administration de contenus)
* La **date de publication**, elle doit être inférieure ou égale à la date d'enregistrement du contenu.
* Le **statut de publication**, le contenu sera visible uniquement s'il est publié.
* Le **statut archivé**, il permet de conserver un contenu sans devoir le supprimer en l'invisibilisant sur la page d'administration

Note : Par défaut vous n'aurez que les type de contenu **Page** et **Page privée**. Les autres type de contenus peuvent être générer par des module complémentaires telque :

* FaqSimple
* Gallery.

### Modifier du contenu

Pour modifier le contenu, rendez-vous sur la page de gestion de contenus et cliquez sur le bouton **_Editer_**  dans la colonne _Action_ du tableau des contenus.

**Route** : `?q=node/:id/edit`

### Supprimer du contenu

Pour supprimer le contenu, rendez-vous sur la page de gestion de contenus et cliquez sur le bouton **_Supprimer_**  dans la colonne _Action_ du tableau des contenus.

## Gérer les menus

Rendez-vous sur la page de gestion du menu en cliquant sur le lien **_Menu_** dans le menu d’administrateur. Depuis cette interface, vous pouvez :

1. Activer ou désactiver les liens,
2. Changer la position d’affichage en glissant/déposant le lien,
3. Créer, modifier et suprimer les menus.

Les menus utilisateur, principal et d'administration sont requis par le systèmes et ne peuvent être supprimés.

Une fois les modifications apportées, cliquez sur **_Enregistrer_** en bas de la page de gestion du menu.

**Route** : `?q=admin/menu/main-menu`

![Screenshot de la page de gestion des menus de SoosyzeCMS](/assets/user/soosyze-menu_admin.png)

### Créer un lien

Cliquez sur le bouton **_Ajouter un lien_** en haut à gauche de la page de gestion de vos menus.

Vous serez redirigé vers le formulaire d’ajout de lien. Remplissez les champs correspondants et cliquez sur **_Enregistrer_**.

**Route** : `?q=admin/menu/main-menu/link/add`

![Screenshot de la page d’ajout de lien de menus de SoosyzeCMS](/assets/user/soosyze-menu_link_create.png)

Les liens doivent être une route, un alias ou une URL erterne à votre site, exemple :

* Route valide : `user/login`, `node/1`, ...
* Alias valide : `\`, ...
* Lien exertne valide : https://soosyze.com

Les routes, alias, ou liens peuvent être accompagnés de paramètres suplémentaires et/ou ancre, exemple :

* Route valide : `node/1?param=value`, `node/1#ancre`, `node/1?param=value#ancre` ...
* Alias valide : `\?param=value`, `\#ancre`, `\?param=value#ancre`, ...
* Lien exertne valide : https://soosyze.com?param=value#ancre

### Modifier un lien

Depuis la page de gestion de vos menus, cliquez sur **_Editer_** dans la colonne *Actions* du lien souhaité.

Vous serez redirigé vers le formulaire d’édition du lien. Modifiez les champs souhaités et cliquez sur **_Enregistrer_**.

**Route** : `?q=admin/menu/main-menu/link/:id/edit`

### Supprimer un lien

Depuis la page de gestion de vos menus, cliquez sur **_Supprimer_** dans la colonne actions du lien souhaité.

## Gérer les utilisateurs

Rendez-vous sur la page de gestion des comptes utilisateurs en cliquant sur le lien **_Utilisateur_** dans le menu d’administrateur. 
Depuis cette interface, vous pouvez voir tous les utilisateurs.

**Route** : `?q=admin/user`

![Screenshot de la page de gestion des utilisateurs de SoosyzeCMS](/assets/user/soosyze-user_management.png)

### Créer un utilisateur

Cliquez sur lien **_Ajouter un utilisateur_** en haut à gauche de la page de gestion des comptes utilisateurs.

Vous serez redirigé vers le formulaire de création d'utilisateur. Remplissez les champs correspondants et cliquez sur **_Enregistrer_**.

**Route** : `?q=admin/user/create`

![Screenshot de la page de création d'un utilisateur de SoosyzeCMS](/assets/user/soosyze-user_create.png)

Le nouvel utilisateur peut se connecter uniquement si son statut et activé.

Le nom d'utilisateur et de l'adresse e-mail pour créer un utilisateur doivent être uniques.
L'utilisateur créé possède par défaut le rôle `Utilisateur connecté`.

### Modifier un utilisateur

Depuis la page de gestion des comptes utilisateurs, cliquez sur **_Editer_** dans la colonne *Actions* de l'utilisateur souhaité.

Vous serez redirigé vers le formulaire d'édition de l'utilisateur. Modifiez les champs souhaités et cliquez sur **_Enregistrer_**.

**Route** : `?q=user/:id/edit`

Le changement du **nom d'utilisateur** ou de l**e-mail** doit-être accompagné du mot de passe du compte utilisateur.

### Supprimer un utilisateur

Depuis la page de gestion des comptes utilisateurs, cliquez sur **_Supprimer_** dans la colonne actions du lien souhaité.

Vous serez redirigé vers le formulaire de supression de compte utilisateur. Cliquez sur **_Supprimer le compte_**.

**Route** : `?q=user/:id/delete`

## Gérer les rôles

Un utilisateur peut posséder plusieurs rôles utilisateurs.
Par défaut il possède le rôle "Utilisateur connectée" (l'équivalent de membre du site). Les rôles fonctionnent sur le principe de CRUD.
Depuis la page de gestion des comptes utilisateurs, cliquez sur **_Rôles_**. Vous aurez les interfaces de création, modification et suppression de rôles.

**Route** : `?q=admin/user/role`

![Screenshot de la page de gestion des rôles de SoosyzeCMS](/assets/user/soosyze-user_roles.png)

## Gérer les permissions

Depuis la page de gestion des comptes utilisateurs, cliquez sur **_Permissions_**.
Les permissions déterminent quel(s) rôle(s) à les droits de voir, créer, modifier, supprimer... selon les différentes fonctionnalités du site.

Par exemple, le module **Contact** propose la permission _Utiliser le formulaire de contact général_.
Cette permission autorise par défaut tous les rôles à voir le formulaire de contact et à le valider.

Autre exemple, vous pouvez choisir quels sont les rôles utilisateurs qui peuvent utiliser le thème d'administration.

![Screenshot de la page de gestion des permissions de SoosyzeCMS](/assets/user/soosyze-user_permission.png)

## Gérer les blocs

Les bloc permettent de personnaliser l'affichage à travers les différentes sections qu'il fournit.
Le thème par défaut **QuietBlue** propose 7 sections :

**Route** : `?q=admin/section/theme`

![Screenshot de la page d'édition des blocs de SoosyzeCMS](/assets/user/soosyze-block.png)

### Créer un blocs

Pour créer un bloc, cliquez sur l'un des boutons **_Ajouter un bloc_** dans l'une des sections.
Une fenêtre modale s'ouvrira et choisissez l'un des blocs proposés en cliquant dessus.

![Screenshot de la fenêtre modale de création des blocs de SoosyzeCMS](/assets/user/soosyze-block_create.png)

Puis cliquez sur **_Ajouter_** en bas de la fenêtre modale pour valider votre choix.

### Modifier les blocs

Pour modifier l'emplacement, placer votre curseur au-dessus d'un bloc puis cliquer sur l'icône croix qui vient d'apparaître. 
Il suffit de glisser/déposer votre bloc dans la section voulue.

![Screenshot de la page d'édition des blocs de SoosyzeCMS](/assets/user/soosyze-block_edit.png)

Dans le cas ou un module d'éditeur de texte est activé (par exemple [Trumbowyg](https://soosyze.com/module/trumbowyg)) il sera utilisé pour la modification du bloc.

![Screenshot du formulaire  d'édition des blocs de SoosyzeCMS](/assets/user/soosyze-block_editor.png)

### Supprimer les blocs

Pour supprimer vos blocs, placer votre curseur au-dessus d'un bloc puis cliquer sur l'icône poubelle qui vient d'apparaître.

## Gérer les fichiers

La gestion des fichiers peut-être un risque pour la sécurité de votre site, c'est pour cette raison qu'ils utilisent une forme de permissions plus précise que celles de bases.

### Gérer les permissions de fichiers

Rendez-vous sur la page de gestion des comptes utilisateurs en cliquant sur le lien **_Utilisateur_** dans le menu d'administrateur, puis sur le lien **_Permissions de fichiers__**.

**Route** : `?q=admin/user/permission/filemanager`

![Screenshot de la page de gestion des fichiers de SoosyzeCMS](/assets/user/soosyze-filemanager_profil.png)

Vous pouvez ajouter, modifier ou supprimer des permissions de fichiers :

Un profil est défini par :

* Le chemin ou se situera les fichiers (DOIT toujours commencer par un `/`),
* L'inclusion des sous répertoires,
* Les rôles utilisateurs,
* Les droits d'ajouter, modifier et supprimer des répertoires,
* La taille limite de données par répertoire (exprimé en mega octets),
* Les droits d'ajouter, modifier, supprimer, télécharger et copier le lien des fichiers,
* La taille maximum pour l'upload des fichiers (exprimé en mega octets),
* Et les extensions de fichiers.

Vous avez également accès à la variable dynamique {{user_id}} qui sera remplacée dynamiquement par l'identifiant de l'utilisateur connecté.

Si les sous répertoires NE SONT PAS inclues, les droits d'ajout, modification et suppression ne peuvent fonctionner.
Si les sous répertoires SONT inclues, alors ils seront prises en compte dans la taille limite de données du répertoire parent.

### Exemple de conflit entre permissions de fichiers

Exemple :

| Profil 1                |                                                           |
|-------------------------|-----------------------------------------------------------|
| Répertoire              | `/test`                                                   |
| Sous répértoire inclue  | `TRUE`                                                    |
| Rôles                   | **Admin**(`poids 3`), **Utilisateur connecté**(`poids 2`) |
| Taille max des fichiers | `5Mo`                                                     |
| Poids                   | `1`                                                       |

| Profil 2                |                                     |
|-------------------------|-------------------------------------|
| Répertoire              | `/test`                             |
| Sous répértoire inclue  | `TRUE`                              |
| Rôles                   | **Utilisateur connecté**(`poids 2`) |
| Taille max des fichiers | `1Mo`                               |
| Poids                   | `2`                                 |

Ces 2 permissions entre en conflits puisqu'ils pointent sur le même répertoire.

Pour résoudre ces problèmes l'algorithme calcule :

* Quels permissions correspond aux rôles utilisateurs,
* Quels rôles utilisateurs à le plus de poids,
* Quels permissions à le plus de poids.

Donc, pour un administrateur qui possède également le rôle d'utilisateur connectée; le Profil 1 sera prioritaire puisque son rôle est plus fort. 
Et pour un utilisateur classique avec le rôle d'utilisateur connecté; le Profil 2 sera prioritaire puisque le poids du profil est plus fort.

### Parcourir et utiliser les fichiers

Rendez-vous sur la page de gestion des comptes utilisateurs en cliquant sur le lien **_Utilisateur_** dans le menu d'administration.
Puis sur le lien **_Permissions de fichiers__**.

Rendez-vous sur la page de gestion des fichiers en cliquant sur le lien **_Fichier_** dans le menu d'administration.

**Route** : `?q=admin/filemanager/show`

![Screenshot de la page de gestion des fichiers de SoosyzeCMS](/assets/user/soosyze-filemanager_show.png)

Les pages, les fichiers, la zone de téléchargement, répertoire et boutons d'actions s'affichent en fonction de vos permissions de fichiers.
Pour vous déplacer d'un répertoire à l'autre cliquez sur son l'icône.

## Lexique

**Route** : Il s'agit du chemin de l'URL pour afficher les pages de Soosyze.

Par exemple, pour l'URL `https://monsite.fr?q=admin/filemanager/show` :
* Votre **nom de domaine** est `https://monsite.fr`,
* Le **paramètre** `?q=` permet de lire les routes pour les URLs non réécrites,
* Et la **route** est `admin/filemanager/show`.