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

**Pour info !** Vos contenus sont gérés par le module **Node** de SoosyzeCMS, il permet **créer des types de contenus.** Les types de contenus permettent de créer et mettre en forme vos données, par exemple une **page** ou un **article**.

`GET ?q=admin/nodes`

![Screenshot de la page de gestion des contenus de SoosyzeCMS](/assets/user/soosyze-node_index.png)

### Créer du contenu

Cliquez sur le bouton **_Ajouter du contenu_** en haut à gauche de la page de gestion de vos contenus.

Vous serez redirigé à la page des types de contenus. Par défaut vous avez le choix entre créer une **Page** pour votre site ou un **Article**.

`GET ?q=admin/node/add`

![Screenshot de la page des types de contenu de SoosyzeCMS](/assets/user/soosyze-node_add.png)

Cliquez sur le titre de l’un d’entre eux pour accéder au formulaire de création.

Remplissez les champs correspondants au format texte ou HTML, puis cliquez sur **_Enregistrer_** et vous reviendrez à la page de gestion de vos contenus.

`GET ?q=admin/node/add/page`
`GET ?q=admin/node/add/article`

Attention, le type de contenu article ne fonctionne que si le module News est activé !

### Modifier du contenu

Pour modifier le contenu, rendez-vous sur la page de gestion de contenus et cliquez sur le bouton **_Editer_**  dans la colonne _Action_ du tableau des contenus.

`GET ?q=node/:id/edit`

### Supprimer du contenu

Pour supprimer le contenu, rendez-vous sur la page de gestion de contenus et cliquez sur le bouton **_Supprimer_**  dans la colonne _Action_ du tableau des contenus.

## Gérer les menus

Rendez-vous sur la page de gestion du menu en cliquant sur le lien **_Menu_** dans le menu d’administrateur. Depuis cette interface, vous pouvez :

1. Activer ou désactiver les liens,
2. Changer la position d’affichage en glissant/déposant le lien,

Une fois les modifications apportées, cliquez sur **_Enregistrer_** en bas de la page de gestion du menu.

`GET ?q=admin/menu/main-menu`

![Screenshot de la page de gestion des menu de SoosyzeCMS](/assets/user/soosyze-menu_show.png)

### Créer un lien

Cliquez sur le bouton **_Ajouter un lien_** en haut à gauche de la page de gestion de vos menus.

Vous serez redirigé vers le formulaire d’ajout de lien. Remplissez les champs correspondants et cliquez sur **_Enregistrer_**.

`GET ?q=admin/menu/main-menu/link/add`

![Screenshot de la page d’ajout de lien de menu de SoosyzeCMS](/assets/user/soosyze-menu_link_create.png)

### Modifier un lien

Depuis la page de gestion de vos menus, cliquez sur **_Editer_** dans la colonne *Actions* du lien souhaité.

Vous serez redirigé vers le formulaire d’édition du lien. Modifiez les champs souhaités et cliquez sur **_Enregistrer_**.

`GET ?q=admin/menu/main-menu/link/:id/edit`

### Supprimer un lien

Depuis la page de gestion de vos menus, cliquez sur **_Supprimer_** dans la colonne actions du lien souhaité.

## Gérer les utilisateurs

Rendez-vous sur la page de gestion des comptes utilisateurs en cliquant sur le lien **_Utilisateur_** dans le menu d’administrateur. 
Depuis cette interface, vous pouvez voir tous les utilisateurs.

`GET ?q=admin/user`

![Screenshot de la page de gestion des utilisateurs de SoosyzeCMS](/assets/user/soosyze-user_management.png)


### Créer un utilisateur

Cliquez sur lien **_Ajouter un utilisateur_** en haut à gauche de la page de gestion des comptes utilisateurs.

Vous serez redirigé vers le formulaire de création d'utilisateur. Remplissez les champs correspondants et cliquez sur **_Enregistrer_**.

`GET ?q=user`

![Screenshot de la page de création d'un utilisateur de SoosyzeCMS](/assets/user/soosyze-user_create.png)

### Modifier un utilisateur

Depuis la page de gestion des comptes utilisateurs, cliquez sur **_Editer_** dans la colonne *Actions* de l'utilisateur souhaité.

Vous serez redirigé vers le formulaire d'édition de l'utilisateur. Modifiez les champs souhaités et cliquez sur **_Enregistrer_**.

`GET ?q=user/:id/edit`

### Supprimer un utilisateur

Depuis la page de gestion des comptes utilisateurs, cliquez sur **_Supprimer_** dans la colonne actions du lien souhaité.

Vous serez redirigé vers le formulaire de supression de compte utilisateur. Cliquez sur **_Supprimer le compte_**.

`GET ?q=user/:id/delete`

## Gérer les rôles

Un utilisateur peut posséder plusieurs rôles utilisateurs.
Par défaut il possède le rôle "Utilisateur connectée" (l'équivalent de membre du site). Les rôles fonctionnent sur le principe de CRUD.
Depuis la page de gestion des comptes utilisateurs, cliquez sur **_Administrer les rôles_**. Vous aurez les interfaces de création, modification et suppression de rôles.

`GET ?q=admin/user/role`

![Screenshot de la page de création des rôles de SoosyzeCMS](/assets/user/soosyze-user_roles.png)


## Gérer les permissions

Depuis la page de gestion des comptes utilisateurs, cliquez sur **_Administrer les permissions_**.
Les permissions déterminent quel(s) rôle(s) à les droits de voir, créer, modifier, supprimer... selon les différentes fonctionnalités du site.

Par exemple, le module **Contact** propose la permission _Utiliser le formulaire de contact général_.
Cette permission autorise par défaut tous les rôles à voir le formulaire de contact et à le valider.

![Screenshot de la page de gestion des permissions de SoosyzeCMS](/assets/user/soosyze-user_permission.png)

## Gérer les blocs

Les bloc permettent de personnaliser l'affichage à travers les différentes sections qu'il fournit.
Le thème par défaut **QuietBlue** propose 7 sections :

`GET ?q=admin/section/theme`

![Screenshot de la page des blocs de SoosyzeCMS](/assets/user/soosyze-block.png)

### Créer un blocs

Pour créer un bloc, cliquez sur l'un des boutons **_Ajouter un bloc_** dans l'une des sections.
Une fenêtre modale s'ouvrira et choisissez l'un des blocs proposés en cliquant dessus.

![Screenshot de la page des blocs de SoosyzeCMS](/assets/user/soosyze-block_create.png)

Puis cliquez sur **_Ajouter_** en bas de la fenêtre modale pour valider votre choix.

### Modifier les blocs

Pour modifier l'emplacement, placer votre curseur au-dessus d'un bloc puis cliquer sur l'icône croix qui vient d'apparaître. 
Il suffit de glisser/déposer votre bloc dans la section voulue.

![Screenshot de la page des blocs de SoosyzeCMS](/assets/user/soosyze-block_edit.png)

Dans le cas ou un module d'éditeur de texte est activé (par exemple [Trumbowyg](https://soosyze.com/module/trumbowyg)) il sera utilisé pour la modification du bloc.

![Screenshot de la page des blocs de SoosyzeCMS](/assets/user/soosyze-block_editor.png)

### Supprimer les blocs

Pour supprimer vos blocs, placer votre curseur au-dessus d'un bloc puis cliquer sur l'icône poubelle qui vient d'apparaître.