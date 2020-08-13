# Tutoriel pour développer un module

SoosyzeCMS se base sur SoosyzeFramework, chaque fonctionnalité est découpée dans un module correspondant.
Un module remplit un rôle ou une fonction (*gestion du contenu, des menus, des utilisateurs…*).
Les modules développés par les contributeurs doivent être déposés dans le répertoire `app/module`, à ne pas confondre avec le répertoire `core/module` qui contient les modules de cœur du CMS (ceux-ci sont maintenus par par la team SoosyzeCore).

Via ce tutoriel, nous allons vous apprendre à créer un module pour SoosyzeCMS de A à Z.
Dans un premier temps, nous analyserons le développement d’un module typique pour SoosyzeFramework. Puis, dans un second temps, nous verrons comment l’adapter et l’intégrer à SoosyeCMS.

Le module d’exemple permet de créer une "to do list", donnant la possibilité de gérer une liste de tâches. Il permet :

* D’accéder à un formulaire de création, d’édition et de suppression des items de la liste (*uniquement accessible par l’administrateur*),
* De hiérarchiser les tâches,
* À tous les utilisateurs de voir cette liste.

Si, à la suite de ce tutoriel, vous êtes amené à créer plusieurs modules, vous pouvez utiliser le [starterkit-module](https://github.com/soosyze/starterkit-module) qui met à votre disposition un squelette qui vous aidera à la création de modules.