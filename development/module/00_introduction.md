# Introduction

Soosyze est un micro gestionnaire de contenus en ligne, appelé aussi CMS (*Content Manager System*).
Sans base de données, à travers un système d’administration simple et avec un passif d’apprentissage quasi nul, vous pourrez créer votre site facilement.

De nombreux CMS existent (*Wordpress, Joomla, Drupal, Ez-publich, Spip…*), souvent très complexes. Ils peuvent être difficiles à appréhender pour les non-initiés et demandent beaucoup de ressources pour mettre en place un simple site.

SoosyzeCMS utilise le qualificatif **micro**, car il implémente uniquement les fonctionnalités essentielles à la gestion d’un site. D’autres micro CMS sans base de données existent. Ils sont aussi créés par des passionnés du développement web (*un peu comme moi ^^*). Après en avoir utilisé quelques-uns, j’ai voulu proposer ma vision du CMS. 

Basé sur **Soosyze Framework** (*un micro framework MVC en PHP orienté objet*) et **Queryflatfile** (*une bibliothèque noSQL*), la combinaison des deux outils offre un socle solide au développement :

* [![PSR-2](https://img.shields.io/badge/PSR-2-yellow.svg)](https://www.php-fig.org/psr/psr-2 "Coding Style Guide") L’écriture du code est standardisée,
* [![PSR-4](https://img.shields.io/badge/PSR-4-yellow.svg)](https://www.php-fig.org/psr/psr-4 "Autoloading Standard") Autoloader, interchangeable avec l’autoloader de Composer,
* [![PSR-7](https://img.shields.io/badge/PSR-7-yellow.svg)](https://www.php-fig.org/psr/psr-7 "HTTP Message Interface") Composant Http (*Resquest, Response, Message, Stream…*),
* [![PSR-11](https://img.shields.io/badge/PSR-11-yellow.svg)](https://www.php-fig.org/psr/psr-11 "Container Interface") Container d’injection de dépendance ou CID,
* [![PSR-17](https://img.shields.io/badge/PSR-17-yellow.svg)](https://www.php-fig.org/psr/psr-17 "HTTP Factories") Fabriques Http implémentées sans les interfaces qui contraignent les implémentations à PHP7,
* Découpe des fonctionnalitées en modules,
* Contrôleur,
* Query Builder,
* Configuration et paramétrage,
* Détection d’environnement,
* Hook,
* Composant d’aide au développement :
    * Routeur (*URL*),
    * Création de formulaire dynamique,
    * Validateur de données,
    * Envoi de mail,
    * Création de Template,
    * Création de Pagination.