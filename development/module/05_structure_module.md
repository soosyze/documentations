# Structure d’un module

Pour notre exemple, rendez-vous dans le répertoire `app/modules`, créez un nouveau répertoire et nommez-le `TodoModule`.

Un module doit contenir l’arborescence suivante :

```
TodoModule/
├─ Assets/     Vos fichiers CSS, JS, images...
├─ Config/     Les fichiers de configurations et paramétrages.
├─ Controller/ Les contrôleurs.
├─ Lang/       Les fichiers de traductions.
│  └─ fr/
├─ Migrations/ Les scripts de mise à jour.
├─ Services/   Les services et hooks.
└─ Views/      Les vues (templates).
```

Vous disposez maintenant d’une arborescence complète. nous verrons dans le chapitre suivant comment créer notre première interaction avec le module.

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/05_structure_module).