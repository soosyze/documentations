<p align="center"><a href="https://soosyze.com/" rel="noopener" target="_blank"><img src="https://soosyze.com/assets/files/logo/soosyze-name.png"></a></p>

# Documentation Soosyze

* :globe_with_meridians: [Site](https://soosyze.com)
* :eyes: [Démo](https://demo.soosyze.com)
* :dizzy: [Extensions et thèmes](https://github.com/soosyze-extension)
* :speech_balloon: [Forum](https://community.soosyze.com)
* :mortar_board: [Docuementations](https://github.com/soosyze/documentations)
* :green_book: [PHP Doc](https://api.soosyze.com)

Vous pouvez également nous trouver sur les réseaux :

* :busts_in_silhouette: [Mastodon](https://mamot.fr/@soosyze)
* :telephone_receiver: [Discord](https://discordapp.com/invite/parFfTt)
* :newspaper: [Diaspora](https://framasphere.org/people/10978ab0dd6301362e322a0000053625)

## Guide de l’utilisateur de SoosyzeCMS

* [Héberger](user/00_héberger.md)
* [Installer](user/01_installer.md)
* [Configurer](user/02_configurer.md)
* [Gérer](user/03_gérer.md)

## Guide de développement de SoosyzeCMS

* [Introduction](development/module/00_introduction.md)
* [Installation et configuration](development/module/01_installation_et_configuration.md)
  * [Exigences d’installation](development/module/01_installation_et_configuration.md#exigences-dinstallation)
    * [Serveur Web](development/module/01_installation_et_configuration.md#serveur-web)
    * [Version PHP](development/module/01_installation_et_configuration.md#version-php)
    * [Extensions requises](development/module/01_installation_et_configuration.md#extensions-requises)
    * [Mémoire requise](development/module/01_installation_et_configuration.md#mémoire-requise)
    * [Connexion à internet](development/module/01_installation_et_configuration.md#connexion-à-internet)
  * [Installation](development/module/01_installation_et_configuration.md#installation)
    * [Téléchargement rapide](development/module/01_installation_et_configuration.md#téléchargement-rapide)
    * [Téléchargement via Git & Composer](development/module/01_installation_et_configuration.md#téléchargement-via-Git--Composer)
    * [Installation du CMS](development/module/01_installation_et_configuration.md#installation-du-cms)
  * [Configuration](development/module/01_installation_et_configuration.md#configuration)
    * [Ngnix](development/module/01_installation_et_configuration.md#ngnix)
* [Structure du CMS](development/module/02_structure_du_cms.md)
* [Tutoriel développer un module](development/module/03_tutoriel_développer_un_module.md)
* [Environnement et outils de développement](development/module/04_environnement_et_outils_de_développement.md)
  * [Environnement](development/module/04_environnement_et_outils_de_développement.md#environnement)
  * [Outils de développements](development/module/04_environnement_et_outils_de_développement.md#outils-de-développements)
* [Structure d’un module](development/module/05_structure_module.md)
* [Hello World !](development/module/06_hello_world.md)
* [Routeur](development/module/07_routeur.md)
  * [Routes statiques](development/module/07_routeur.md#routes-statiques)
  * [Routes dynamiques](development/module/07_routeur.md#routes-dynamiques)
* [Contrôleurs](development/module/08_controleur.md)
  * [Namespace](development/module/08_controleur.md#namespace)
  * [Requête et Réponse](development/module/08_controleur.md#requête-et-réponse)
  * [RESTful](development/module/08_controleur.md#restfull)
  * [Redirect](development/module/08_controleur.md#redirect)
* [Template](development/module/09_template.md)
  * [Utiliser un template](development/module/09_template.md#utiliser-un-template)
  * [Injection de variable](development/module/09_template.md#injection-de-variable)
  * [Injection de template](development/module/09_template.md#injection-de-template)
  * [Exercice page d’administration](development/module/09_template.md#exercice-page-dadministration)
  * [Correction page d’administration](development/module/09_template.md#correction-page-dadministration)
  * [Bonus lexical](development/module/09_template.md#bonus-lexical)
* [Formulaire](development/module/10_formulaire.md)
  * [Formulaire simple](development/module/10_formulaire.md#formulaire-simple)
  * [Formulaire simple & dynamique](development/module/10_formulaire.md#formulaire-simple--dynamique)
  * [Formulaire dynamique](development/module/10_formulaire.md#formulaire-dynamique)
  * [Protection CSRF](development/module/10_formulaire.md#protection-csrf)
  * [Exrecice formulaire d’édition](development/module/10_formulaire.md#exrecice-formulaire-dédition)
  * [Correction formulaire d’édition](development/module/10_formulaire.md#correction-formulaire-dédition)
* [Validation de données](development/module/11_validation.md)
  * [Règles, valeurs et validation](development/module/11_validation.md#règles--valeurs-et-validation)
  * [Retour des succès et erreurs](development/module/11_validation.md#gestion-des-succès-et-erreurs)
  * [Exercice validation de l’édition](development/module/11_validation.md#exercice-validation-de-lédition)
  * [Correction validation de l’édition](development/module/11_validation.md#correction-validation-de-lédition)
* [Container et Services](development/module/12_container_services.md)
  * [Container](development/module/12_container_services.md#container)
  * [Utiliser un service](development/module/12_container_services.md#utiliser-un-service)
  * [Créer un service](development/module/12_container_services.md#créer-un-service)
  * [Injection d’arguments et de dépendances](development/module/12_container_services.md#injection-darguments-et-de-dépendances)
* [Modèle](development/module/13_model.md)
  * [SGBD](development/module/13_model.md#sgbd)
  * [QueryFlatFile](development/module/13_model.md#queryflatfile)
    * [Ajouter une table manuellement](development/module/13_model.md#ajouter-une-table-manuellement)
    * [Récupération de données](development/module/13_model.md#récupération-de-données)
    * [Requête dans un service](development/module/13_model.md#requête-dans-un-service)
    * [Insertion d’item](development/module/13_model.md#insertion-ditem)
    * [Exercice d’édition d’item](development/module/13_model.md#exercice-dédition-ditem)
    * [Correction de l’édition d’item](development/module/13_model.md#correction-de-lédition-ditem)
    * [Exercice suppression d’item](development/module/13_model.md#exercice-suppression-ditem)
    * [Correction suppression d’item](development/module/13_model.md#correction-suppression-ditem)
* [Hook](development/module/14_hooks.md)
  * [Princinpe du hook](development/module/14_hooks.md#pricinpe-du-hook)
  * [Appeler les hooks](development/module/14_hooks.md#appeler-les-hooks)
  * [Déclarer les hooks](development/module/14_hooks.md#déclarer-les-hooks)
  * [Exercice d’édition d’item](development/module/14_hooks.md#exercice-dédition-ditem)
  * [Correction de l’édition d’item](development/module/14_hooks.md#correction-de-lédition-ditem)
* [Intégration a SoosyzeCMS](development/module/15_integration.md)
  * [Utilisez les thèmes de SoosyzeCMS](development/module/15_integration.md#utilisez-les-thèmes-de-soosyzecms)
  * [Exercice d’utilisation du thème pour les formulaires](development/module/15_integration.md#exercice-dutilisation-du-thème-pour-les-formulaires)
  * [Correction de l’utilisation du thème pour les formulaires](development/module/15_integration.md#correction-de-lutilisation-du-thème-pour-les-formulaires)
  * [Installation au ModuleManager](development/module/15_integration.md#installation-au-modulemanager)
  * [Exercice d’installation du module TodoDate](development/module/15_integration.md#exercice-dinstallation-du-module-tododate)
  * [Correction de l’installation du module TodoDate](development/module/15_integration.md#correction-de-linstallation-du-module-tododate)
  * [Ajouter des droits utilisateurs](development/module/15_integration.md#ajouter-des-droits-utilisateurs)
  * [Ajouter un lien dans le menu](development/module/15_integration.md#ajouter-un-lien-dans-le-menu)

## Prochainement

* Notions avancées
  * Envoie d’e-mail
  * Utilisation du service config
  * Upload de fichiers/images
  * Créer une node personnalisée
* Publier votre module
  * Convention de nommage
  * Convention syntaxique
  * Code de production
  * Documentation
  * Proposer votre module au téléchargement
* Tutoriel développer un theme
  * Structure d’un theme
  * Overide un template
* Publier votre theme
  * Convention de nommage
  * Convention syntaxique
  * Code de production
  * Documentation
  * Proposer votre theme au téléchargement

## Composants

* Email
* FormBuilder
* Http
* Template
* Util
* Validator

## FAQ

* Modifier le formulaire de contact
* Intégrer une carte Google map
  * En brut (template)
  * Dans vos contenus (node)
* Intégrer une carte OpenStreetMap
  * En brut (template)
  * Dans vos contenus (node)
* Intégrer une vidéo Youtube
  * En brut (template)
  * Dans vos contenu (node)
* Intégrer une vidéo Dailymotion
  * En brut (template)
  * Dans vos contenus (node)
* Créer une ancre dans votre menu