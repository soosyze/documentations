# Hébérger

Avant d’entamer votre fabuleuse aventure dans le monde du web avec Soosyze, vous devez commencer par préparer le terrain.

Pour faire fonctionner votre site web, il va falloir l’héberger sur un serveur. Si vous n’avez aucune connaissance dans le web, ce n’est pas grave, les explications seront vulgarisées afin que tout un chacun s’y retrouve.

Pour commencer, vous devez choisir entre :

* **Héberger votre site en local** : faire fonctionner votre site sur votre ordinateur personnel (*vous seul pourrez y accéder*),
* **Héberger votre site en ligne** : faire fonctionner votre site sur un serveur en ligne (*quiconque aura le lien pourra avoir accès au contenu*).

## Héberger votre site en local

Quel que soit le système d’exploitation (*Windows, Mac, Linux...*) que vous utilisez, vous devrez installer un **serveur HTTP** (*serveur web*) et **PHP** (*langage de développement utilisé pour Soosyze*).

Pour information, Soosyze CMS supporte **Apache 2.2+** et **Nginx 1.0+**, qui sont deux des serveurs web les plus utilisés (*[plus de 80% des infrastructures d'hébergement les utilisent](https://w3techs.com/technologies/overview/web_server/all)*).

Pour information, Apache et Nginx ce valent en terme de maintenabilité, documentation disponible, sécurité, prise en charge de Windows/Linux...
Leurs grandes différences viennent principalement de :

* La simplicité de déploiment de Ngnix pour un public non averti, 
* La rapidité de traitement des requêtes de Nginx sur des site statiques (ce qui n'est pas le cas de Soosyze et de la majorité des CMS), 
* Le nombre de connexion simultané supporté (10 000 pour Nginx et 256 pour Apache), 
* Le système de module.

Peu importe si vous utilisez Apache ou Nginx. Si vous êtes en local vous n'aurez pas besoin de grandes performances de connexion (ce qui retire l'avantage de Nginx sur Apache).

### En local sur Linux

* [Tutoriel d'hébérgement en local avec Apache et PHP pour Ubuntu/Debian](/user/00_héberger_linux.md).

### En local sur Windows

* [Tutoriel d'hébérgement en loacl avec WampServeur 3(Apache) pour Windows](/user/00_héberger_windows.md).

## Héberger votre site en ligne

Ici nous allons vous expliquer comment trouver un hébergeur gratuit pour votre site. Sachez néanmoins que vous pouvez créer votre servreur web vous même si vous le souhaitez.

Un hébergeur est une entreprise (*ou personne morale, comme on dit dans le milieu ;)*) qui vous vend des services pour vos projets web. Dans ce tutoriel nous vous expliquerons comment choisir un nom de domaine et une offre d’hébergement gratuite de votre site.

### Un nom de domaine

Première étape, trouvez-vous un **nom de domaine**, il s’agit de l’adresse de votre site web. Par exemple, l’adresse de notre site web est **[https://soosyze.com/](http://soosyze.com/)**, composée de :

* **https** (*le protocole utilisé*),
* **soosyze** (*le nom de domaine*),
* **.com** (*l’extension du nom de domaine*).

Le nom de domaine devra être disponible, et vous devrez trouver un un nom de domaine correspondant à l’activité de votre site web. Chaque hébergeur vous proposera de vérifier si le nom de domaine est disponible, mais vous pouvez aussi passer par un service tel que [https://www.nom-domaine.fr](https://www.nom-domaine.fr/).

Nous vous conseillons de bien choisir votre nom de domaine, car il représentera vos activités et pourrait être utilisé pour plein d’autres choses (*logos, cartes de visite, référencement de votre site...*). Il est donc préférable :

* Qu’il soit clair et lisible,
* Qu’il ne dépasse pas les 50 caractères ou 3 mots,
* Dans le cas ou il serait composé de plusieurs mots, de les séparer par un tiret '-' (*non obligatoire, mais recommandé*),
* Qu’il ne possède aucun accent ou caractère spécial en dehors de '-' et '_'.

Une fois un nom de domaine trouvé, vous allez devoir l’acheter : il sera ainsi réservé à votre usage personnel.

Nous vous recommandons de réserver votre nom de domaine au moment ou vous choisirez votre offre d’hébergement. Dans le cas d’un hébergement gratuit, il sera limité. Et dans le cas d’un hébergement payant, les hébergeurs ont tendance à vous l’offrir la première année (*économie <3*).

### Une offre d’hébergement

Il existe de nombreux types d’offres d’hébergement. Pour ne mentionner que celles-ci :

**Des offres d’hébergements mutualisés** (*niveau débutant*) : pour faire simple, les ressources (*l’espace, la mémoire, la puisssance de calcul...*) de la machine qui hébergera votre site en ligne seront partagées. Ces offres font parties des moins chères proposées par les hébergeurs, puisque les coûts sont répartis entre tous les utilisateurs du service. Généralement à privilégier, car elles présentent un bon rapport qualité/prix.

**Des offres d’hébergement dédié** (*niveau porte des enfers*) : de plus en plus présentes dans le cloud, elles sont beaucoup plus chères mais vous apportent une grande souplesse et puissance pour votre site. Ces offres dédiées premettent de jouir de l’exclusivité de la machine qui héberge votre site web et donc d’y apporter des configurations et modifications plus personnalisées. Cependant, il est préférable d’avoir de bonnes notions en informatique (_comme en système et/ou en infra, souvent en Linux, petite larme dédiée à tous les dev nuls en infra_), pour profiter pleinement de ce genre d’offres.

| Tarif moyen         | Type d’offre                                                                                           | Indicatif                                                                                |
|---------------------|--------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------|
| 0€                  | hébergement gratuit, mais très limité en trafic ou quantité de données, choix du nom de domaine limité | Pour les très petits sites web 1-5 utilisateurs*, 5-10 pages* et un trafic léger         |
| 1,5€ - 3,0€ HT/mois | prix attractif, mais des limites en fonctionnalités pour débuter dans le web                           | Pour les petits sites web avec 5-30 utilisateurs*, 10-20 pages* et un trafic léger       |
| 3,0€ - 7,0€ HT/mois | une offre de base, plus fournie, avec toutes les fonctionnalités                                       | Pour les sites standards avec 30-100 utilisateurs*, 20-100 pages* et un trafic classique |
| 7,0€ - 10€ HT/mois  | une offre plus professionnelle                                                                         | Pour les sites web standards/moyens                                                      |
| 10€ et plus HT/mois | une offre professionnelle, avec plus d’espace de données et un meilleur support                        | Pour les sites web moyens                                                                |

*Ces nombres sont représentatifs et peuvent varier en fonction de la quantité d’espace disponible, de données, de pages, d’utilisateurs, du CMS...

Le conseil que nous donnons généralement est de choisir votre offre d’hébérgement en rapport avec votre projet. Vous pouvez débuter avec une offre gratuite ou standard, puis en fonction du trafic que générera votre activité, monter en gamme pour assurer votre service en ligne.

### Un hébergeur

Comme nous vous l’avons précédemment indiqué, il y a de nombreux hébergeurs. Nous vous proposons ici une liste non exhaustive que vous pourrez complèter en faisant vos propres recherches sur internet (*avec les mots clés suivants : hébergement, site web, gratuit...*)

Nous vous conseillons de les comparer afin de trouver le plus adapté pour votre site :

* (*fr*) [http://www.free.fr/freebox/pages/internet/votre-web.html](http://www.free.fr/freebox/pages/internet/votre-web.html),
* (*fr*) [https://www.alwaysdata.com/fr/](https://www.alwaysdata.com/fr/),
* (*fr*) [http://www.11vm-serv.net/offres-hebergement-web-gratuit.html](http://www.11vm-serv.net/offres-hebergement-web-gratuit.html),
* (*fr*) [https://www.hostinger.fr/hebergement-gratuit](https://www.hostinger.fr/hebergement-gratuit),
* (*en*) [https://byet.host/free-hosting](https://byet.host/free-hosting),
* (*en*) [https://fr.000webhost.com/](https://fr.000webhost.com/),
* ...

Il suffit de vous inscrire sur l’un d’entre eux, souscrire à l’une des offres, et récupérer les informations suivantes :

* **Nom d’Hôte**,
* **Protocole** (*dans 99% des cas c’est du FTP ou SFTP, vous verez à l’étape 2*),
* Votre **identifiant**,
* Et votre **mot de passe**.

Retenez-les bien, vous en aurez besoin pour la suite.

[Étape 2 : Configurer](/user/01_installer.md)