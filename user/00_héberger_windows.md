# Tutoriel d'hébérgement avec **WampServeur 3**(Apache) pour Windows

Si vous utilisez Windows comme système d’exploitation, il existe plusieurs logiciels "tout-en-un". Notre tutoriel sera centré sur le logiciel **WampServeur 3**. WAMP signifie :

* **W**indows (*votre système d’exploitation)*,
* **A**pache (*votre serveur web*),
* **M**ySQL (*logiciel de base de données, qui n’est pas obligatoire pour Soosyze*),
* **P**HP (*le langage de développement utilisé pour Soosyze*).

[Site officiel](http://www.wampserver.com/).
[Télécharger WampServeur 3](https://sourceforge.net/projects/wampserver/files/latest/download?source=files).

## Pré-requis

Nous avons ici recapitulé de manière simplifié toutes les étapes de l’installation de WAMP tirées de cet excellent [topic sur le forum de wamp](http://forum.wampserver.com/read.php?1,137154) régulièrement mis à jour par la communauté. N’hésitez pas à le consulter pour vous aider dans votre progression.

**Avant d’installer WampServeur 3**, voici certaines règles :

1. Ne pas utiliser d’extension inférieure à Wampserveur 3,
2. Ne pas installer WAMP 3 par dessus une version inférieure,
3. Connaître le nombre de bits d’architecture de votre ordinateur,
4. Avoir installé les bibliothèques Visual Studio.

Si vous êtes dans le cas 1. ou 2. vous devez sauvegarder vos projets, désinstaller entièrement WAMP 2 pour passer à la version 3.

Si vous êtes dans le cas 4. nous vous conseillons d’installer/ré-installer toutes les biliothèques Visual Studio. Ce sera un réel gain de temps, au lieu d’aller vérifier quelles biliothèques existent pour ensuite cibler celles qui vous manquent.

## Version de votre architecture (*32bits ou 64bits*)

Pour simplifier, retenez juste que :

* À l’heure ou j’écris ce tutoriel, la majorité des systèmes sont sous 64bits,
* Les logiciels 64bits ne peuvent pas s’installer sur un ordinateur 32bits,
* Les logiciels 32bits peuvent s’installer (*généralement*) sur un ordinateur 64bits (*logique, qui peut le plus peut le moins*).

Pour connaître le nombre de bits qu’utilise votre architecture, suivez les instructions suivantes :

1. Allez dans votre menu démarrer,
2. Cliquez sur **_Panneau de configuration_**,
3. Puis sur **_Système et sécurité_**,
4. Et enfin sur **_Système_**,
5. Vous aurez l’indication dans **_Type du système_**.

## Bibliothèques Visual Studio

Si vous avez un ordinateur avec une **architecture 32bits**,vous devrez **installer toutes les bibliothèque Visual Studio 32bits**.

Si vous avez un ordinateur avec une **architecture 64bits** vous devrez **installer toutes les biliothèque Visual Studio 32bits puis 64bits** (*dans cet ordre, au risque de ne pas pouvoir faire fonctionner WAMP 3*).

| Visual Sudio  | Architecture x86 (32bits)                                                                                    | Architecture x64 (64bits)                                                                                     |
|---------------|--------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------|
| VC9           | [Visual C++ 2008 SP1 Redistributable Package](https://www.microsoft.com/fr-fr/download/details.aspx?id=5582) | [Visual C++ 2008 SP1 Redistributable Package](https://www.microsoft.com/fr-fr/download/details.aspx?id=2092)  |
| VC10          | [Visual C++ 2010 SP1 Redistributable Package](https://www.microsoft.com/fr-fr/download/details.aspx?id=8328) | [Visual C++ 2010 SP1 Redistributable Package](https://www.microsoft.com/fr-fr/download/details.aspx?id=13523) |
| VC11          | [Visual C++ for Visual Studio 2012 Update 4](https://www.microsoft.com/fr-fr/download/details.aspx?id=30679) |                                                                                                               |
| VC13          | [Visual C++ for Visual Studio 2012 Update 4](https://support.microsoft.com/en-us/help/4032938/)              |                                                                                                               |
| VC14 & VC15   | [Visual C++ Redistributable Packages for Visual Studio 2017](https://aka.ms/vs/15/release/VC_redist.x86.exe) | [Visual C++ Redistributable Packages for Visual Studio 2017](https://aka.ms/vs/15/release/VC_redist.x64.exe)  |

1. Les versions VC9, VC10 et VC11 sont obligatoires,  
2. Les versions VC11, VC13 et VC15 ne sont pas supportées par Windows XP,  
3. Les versions VC13,  VC14 et VC15 sont obligatoires pour PHP7,  
4. La version VC14 a été remplacée par VC15.

## Installation

WAMP 3 n’est pas si difficile à installer, si votre projet ne cible pas des versions précises de Apache ou PHP.

Lancez l’installation de WAMP en double cliquant sur l’exécutable précédemment téléchargé. Dans la fenêtre vous demandant où l’installer, vous devez impérativement choisir la racine de l’un de vos disques (*C:\wamp ou D:\wamp ...*).

Et voilà ! Normalement vous avez installé le logiciel WAMP qui vous permettra de faire fonctionner Soosyze.

Pour tout problème rencontré, n’hésitez pas à vous renseigner sur le forum de Wamp. N’hésitez pas non plus à nous contacter si ce tutoriel n’est plus à jour.
