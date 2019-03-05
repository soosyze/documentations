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

**Pour info !** Vos contenus sont gérés par le module **Node** du SoosyzeCMS, il permet **créer des type de contenus.** Les types de contenus sont par exemple une **page** ou un **article**. Ils permettent de créer du contenu avec différents champs.

`GET ?admin/content`

![Screenshot de la page de gestion des contenus de SoosyzeCMS](/assets/user/soosyze-node_index-desktop.png)

### Créer du contenu

Cliquez sur le bouton **_Ajouter du contenu_** en haut à gauche de la page de gestion de vos contenus.

Vous serez redirigé à la page des types de contenus. Par défaut vous avez le choix entre créer une **Page** pour votre site ou un **Article**.

`GET ?node/add`

![Screenshot de la page des types de contenu de SoosyzeCMS](/assets/user/soosyze-node_add-desktop.png)

Cliquez sur le titre de l’un d’entre eux pour accéder au formulaire de création.

Remplissez les champs corespondant au format texte ou HTML, puis cliquez sur **_Enregistrer_** et vous reviendrez à la page de gestion de vos contenus.

`GET ?node/add/page`
`GET ?node/add/article`

Attention, le type de contenu article ne fonctionne que si le module News est activé !

### Modifier du contenu

Pour modifier le contenu, rendez-vous sur la page de gestion de contenus et cliquez sur le bouton **_Editer_**  dans la colonne _Action_ du tableau des contenus.

`GET ?node/:id/edit`

### Supprimer du contenu

Pour supprimer le contenu, rendez-vous sur la page de gestion de contenus et cliquez sur le bouton **_Supprimer_**  dans la colonne _Action_ du tableau des contenus.

## Gérer les menus

Rendez-vous sur la page de gestion du menu en cliquant sur le lien **_Menu_** dans le menu d’administrateur. Depuis cette interface, vous pouvez :

1.  Activer ou désactiver les liens,
2.  Changer la position d’affichage du lien dans le menu, à partir de la liste de selection dans la colonne _Poids_,
3.  Faire glisser les liens avec votre souris.

Une fois les modifications apportées, cliquez sur **_Enregistrer_** en bas de la page de gestion du menu.

`GET ?menu/main-menu`

![Screenshot de la page de gestion des menu de SoosyzeCMS](/assets/user/soosyze-menu_show-desktop.png)

### Créer un lien

Cliquez sur le bouton **_Ajouter un lien_** en haut à gauche de la page de gestion de vos menus.

Vous serez redirigé vers le formulaire d’ajout de lien. Remplissez les champs correspondants et cliquez sur **_Enregistrer_**.

`GET ?menu/main-menu/link/add`

![Screenshot de la page d’ajout de lien de menu de SoosyzeCMS](/assets/user/soosyze-menu_link_create-desktop.png)

### Modifier un lien

Depuis la page de gestion de vos menus, cliquez sur **_Editer_** dans la colonne actions du lien souhaité.

Vous serez redirigé vers le formulaire d’édition du lien. Modifiez les champs souhaités et cliquez sur **_Enregistrer_**.

`GET ?menu/main-menu/link/:id/edit`

### Supprimer un lien

Depuis la page de gestion de vos menus, cliquez sur **_Supprimer_** dans la colonne actions du lien souhaité.
