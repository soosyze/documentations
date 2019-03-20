# Hooks

Un hook signifie littéralement **crochet** en anglais. Il a pour objectif de laisser des points d’entrée dans les contrôleurs afin que les autres développeurs puissent personnaliser des fonctions déjà existantes. J’en ai déjà fait allusion dans le chapitre sur les formulaires. 

Par exemple, imaginons que votre module ne remplisse pas toutes les fonctionnalités attendues par d’autres utilisateurs. Il se peut alors que vous ouvriez le développement de votre module aux contributeurs pour le faire évoluer au risque que ses fonctions de base soient totalement dénaturées (*dans le cas où vous n’êtes pas trop regardant quant à son évolution*).

Ou alors, vous ajoutez des hooks pour que d’autres modules puissent venir y ajouter de nouvelles fonctions. Votre module resterait intègre, et de nouveaux modules viendraient compléter ses fonctionnalités.

## Pricinpe du hook

Un hook n’est ni plus ni moins qu’une fonction qui attend d’être appelée. Si l’appel réussit alors la fonction viendra modifier les paramètres passés en entrée, sinon il ne fait rien.

Exemple fictif :

```php
<?php

/**
 * Fonction pour ajouter une fonction qui s’exécutera à son appel.
 * 
 * @param string   $key Clé unique pour appeler la fonction.
 * @param callable $fun Fonction à exécuter.
 */
function addHook($key, callable $fun)
{
    global $hook;
    $hook[$key] = $fun;
}

/**
 * Fonction pour appeler un hook à partir d’une clé. 
 * Si le hook existe, exécute une fonction pour modifier le second paramètre d’entrée.
 */
function callHook($key, array $param)
{
    global $hook;
    if(isset($hook[$key]))
    {
        call_user_func_array($hook[$key], $param);
    }
}

/* 1. Déclaration des Hooks. */
/**
 * Ajoute un hook retournant la concaténation d’une chaîne de caractères passée en paramètre 
 * avec la chaîne ' World !'
 */
addHook('world', function (&$str)
{
    $str .= ' World !';
});
/**
 * Ajoute un hook qui retourne 'Good Morning User !' 
 * sans tenir compte de la chaîne de caractères passée en paramètre
 */
addHook('user', function (&$str)
{
    $str = 'Good Morning User !';
});

/* 2. Situation initiale. */
$str = 'Hello';

/* 3. Appelle le hook 'world'. */
callHook('world', [&$str]);
var_dump($str); // Résultat : string("Hello World !")

/* 4. Appel le hook 'nothing'. */
callHook('nothing', [&$str]);
var_dump($str); // Résultat : string("Hello World !")

/* 5. Appelle le hook 'user'. */
callHook('user', [&$str]);
var_dump($str); // Résultat : string("Good Morning User !")
```

Vous noterez l’utilisation du préfixe `&` dans les paramètres de nos hooks. Il s’agit d’un passage par référence de notre variable. 
Pour en savoir plus, je vous invite à lire [la documentation PHP sur le passage par référence](http://php.net/manual/fr/language.references.pass.php).

Avant de commencer à appeler les hooks, nous allons définir un besoin non pourvu pas notre module et y répondre ; par exemple, si nous devions ajouter une échéance de fin pour chaque item. 

Il faudra donc que nos hooks interviennent pour : 

* Ajouter un champ à notre formulaire de création d’item, 
* Valider les données, 
* Enregistrer les données.

## Appeler les hooks

Dans le contexte objet de SoosyzeFramework les hooks s’emploient avec le Container d’injection de dépendances. Pour appeler un hook, le CID vous fournit la méthode suivante :

```php
/**
 * Demande d’exécution de fonction si elle existe. 
 * Utilise le container pour l’ajout des hooks depuis les fichiers de services.
 *
 * @param string $name Clé pour appeler la fonction.
 * @param array  $args Paramètres passés à la fonction.
 *
 * @return mixed|void Résultat des fonctions appelées ou rien.
 */
callHook( $name, array $args = [] );
```

Éditer le contrôleur `TodoController`, et dans votre fonction `create()` insérez les lignes suivantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function create($req)
{
    $data = [ 'title' => '', 'height' => 1, 'achieve' => false ];

    /*
     * Nous appelons le hook 'todo.item.create.form.data' 
     * en lui fournissant les données du formulaire par référence. 
     * Le but est de déclarer ou de modifier les données avant la création du formulaire.
     */
    $this->container->callHook('todo.item.create.form.data', [ &$data ]);

    if (isset($_SESSION[ 'inputs' ])) {
        $data = array_merge($data, $_SESSION[ 'inputs' ]);
        unset($_SESSION[ 'inputs' ]);
    }
    
    $route = self::router()->getRoute('todo.item.update', [ ':id' => $id ]);

    $form = new FormBuilder([ 'method' => 'post', 'action' => $route ]);
    /* […] */
    ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);

    /*
     * Nous appelons le hook 'todo.item.edit.form' 
     * en lui fournissant le formulaire par référence et ses données.
     * Le but est de modifier le formulaire avant qu’il ne s’affiche.
     */
    $this->container->callHook('todo.item.create.form', [ &$form, $data ]);
    /* […] */
}
```

Avec ces deux nouvelles lignes pour appeler nos hooks, vous laissez à disposition des points d’entrée pour modifier le formulaire de création d’item. 

Nous allons également modifier la fonction qui valide la création d’item pour y ajouter des points d’entrées. 
Éditez le contrôleur `TodoController`, et dans votre fonction `store()`, modifiez les lignes suivantes :

```php
public function store($req)
{
    $post      = $req->getParsedBody();
    $validator = new Validator();

    $validator->setRules([
            'title'   => 'required|string|max:255',
            'height'  => 'required|int|min:1',
            'achieve' => 'bool',
            'token'   => 'required|token',
        ])
        ->setInputs($post);

    /*
     * Nous appelons le hook 'todo.item.store.validator' 
     * en lui fournissant le validateur par référence. 
     * Le but et d’ajouter des règles de validation avant l’insertion. 
     * Les données sont toutes ajoutées avec la fonction setInputs($post).
     */
    $this->container->callHook('todo.item.store.validator', [ &$validator ]);

    if ($validator->isValid()) {
        $value = [
            'title'   => $validator->getInput('title'),
            'height'  => $validator->getInput('height'),
            'achieve' => (bool) $validator->getInput('achieve'),
        ];

        /*
         * Nous appelons le hook 'todo.item.store.after' 
         * en lui fournissant le validateur et les données à insérer par référence. 
         * Le but est de modifier l’insertion de la table.
         */
        $this->container->callHook('todo.item.store.after', [ $validator, &$value ]);
        self::query()
            ->insertInto('todo', array_keys($value))
            ->values($value)
            ->execute();
        $this->container->callHook('todo.item.store.before', [ $validator ]);

        $_SESSION[ 'success' ] = [ 'Votre configuration a été enregistrée.' ];
        $route                 = self::router()->getRoute('todo.admin');
    }
    /* […] */
}
```

Vous noterez la présence de l’appel `todo.item.store.before` juste après l’insertion. Dans notre cas, cet appel ne nous sert à rien. Mais imaginez qu’un développeur veuille créer une liaison entre cet item et une autre table : il aura besoin que l’item soit déjà inséré, c’est pourquoi il est important d’avoir les deux appels.

Maintenant que les appels sont déclarés, nous pouvons créer des hooks pour intervenir sur le formulaire et la validation des données.

## Déclarer les hooks

Imaginons à présent (*il faut être très imagniatif pour suivre ce tuto ^^*) que nous souhaitions ajouter une date butoire (*facultative*) à nos items. C’est dommage, car vous n’y avez probablement pas pensé à la création de ce module. :'(

Mais ne paniquez pas ! Vous avez suivi avec assiduité le tutoriel et avez mis en place des appels aux hooks pour que d’autres développeurs puissent y ajouter des fonctionnalités tierces.

Et pour mieux comprendre comment ça marche, vous allez devoir créer un second module (*bien moins complet, je vous rassure tout de suite*), permettant de déclarer les hooks de notre exemple.

Dans le répertoire `app/module`, créez un répertoire `TodoDate` avec l’arborescence suivante :

```
TodoDate/
├── Config/
│   └── service.json
│
├── Controller/
│   └── TodoDateController.php
│
└── Services/
    └── TodoHook.php
```

On commence par créer notre contrôleur avec le chemin du fichier contenant la déclaration des services. 
Rendez-vous dans le répertoire `Controller` du module `TodoDate`, et créez le fichier `TodoDateController.php` qui doit contenir les lignes suivantes :

```php
<?php

namespace TodoDate\Controller;

class TodoDateController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathServices = MODULES_CONTRIBUED . 'TodoDate' . DS . 'Config' . DS . 'service.json';
    }
}
```

On poursuit par la création de notre fichier de déclaration de services. 
Rendez-vous dans le répertoire `Config` du module `TodoDate`, et créez le fichier `service.json`, il doit contenir les lignes suivantes :

```json
{
    "todo.date.hook": {
        "class": "TodoDate\\Services\\TodoHook",
        "arguments": [
            "@query",
            "@schema"
        ],
        "hooks": {

        }
    }
}
```

Vous noterez que le nouveau champ `hooks` est encore vide. C’est ici que nous allons déclarer les fonctions du service qui seront utilisées comme hook. 

Puis, nous finirons la création de notre nouveau module par le service qui contiendra ces fameux hooks. 
Rendez-vous dans le répertoire `Services` du module `TodoDate`, et créez le fichier `TodoHook.php` qui doit contenir les lignes suivantes :

```php
<?php

namespace TodoDate\Services;

class TodoHook
{
    private $query;

    private $schema;

    public function __construct($query, $schema)
    {
        $this->query  = $query;
        $this->schema = $schema;
    }
}
```

Voilà, tous les répertoires et fichiers de notre module sont présents.

Maintenant on va déclarer notre champ en base de données. Pour rappel, ce champ sera ajouté dynamiquement dans le chapitre suivant, mais en attendant, nous continuerons à le faire manuellement. 
Rendez-vous dans le répertoire `app/data` de votre projet, éditez le fichier `schema.json` et ajoutez les lignes suivantes dans votre table `todo` :

```json
{
    "todo": {
        "table": "todo",
        "path": "app\/data",
        "fields": {
            "id": {
                "type": "increments"
            },
            "title": {
                "type": "string",
                "length": 255
            },
            "height": {
                "type": "integer",
                "default": 1
            },
            "achieve": {
                "type": "boolean",
                "default": false
            },
            "date": {
                "type": "date",
                "nullable": true
            }
        },
        "increments": 3
    }
}
```

Nous venons d’ajouter le champ `date` de type `date` (*il faut savoir rester simple parfois*), et activé le paramètre `nullable`. Cela signifie que lorsque l’utilisateur créera un item, il pourra choisir de ne pas saisir de date. 

Et comme nous venons de modifier le schéma, il faut aussi modifier la structure de la table. Rendez-vous dans le répertoire `app/data` de votre projet, éditez le fichier `todo.json` et remplacez son contenu par les lignes suivantes (*pour repartir sur de bonnes bases*) :

```json
[
    {
        "id": 1,
        "title": "Item 1",
        "height": "1",
        "achieve": false,
        "date": null
    }, {
        "id": 2,
        "title": "Item 2",
        "height": 2,
        "achieve": false,
        "date": null
    }, {
        "id": 3,
        "title": "Item 3",
        "height": "3",
        "achieve": false,
        "date": null
    }
]
```

Maintenant que notre environnement de travail est prêt, il nous reste plus qu’à déclarer notre nouveau module à l’application avant de nous mettre au travail.

Mais comme nous sommes à 7 chapitres d’écart de celui qui explique comment déclarer un module manuellement, je vais vous faire une fleur en vous rafraîchissant un peu la mémoire. ^^ 

Rendez-vous dans le répertoire `app`, éditez le fichier `app_core.php`, et dans la fonction `loadModules()`, ajoutez la ligne suivante :

```php
/* […] */
public function loadModules()
{
    $modules = [
        "TodoController" => new TodoModule\Controller\TodoController(),
        /* Cette ligne permettra de charger votre module sans passer par le ModuleManager. */
        "TodoDate"       => new TodoDate\Controller\TodoDateController()
    ];

    /* […] */

    return $modules;
}
```

Et voilà, tout est prêt ! Maintenant que vous vous êtes bien échauffé en créant un nouveau module en quelques minutes, ne perdons pas de temps et commençons par l’ajout de notre champ date dans le formulaire de création.

Souvenez-vous du chapitre **Déclarer nos hooks** nous avons ajouté les points d’entrée `todo.item.create.form.data` et `todo.item.create.form` à la fonction `create()` du contrôleur `TodoController`. Nous allons utiliser ces points d’entrée et les faire correspondre aux hooks de notre nouveau module. 

Rendez-vous dans le répertoire `Config` du module `TodoDate`, éditez le fichier `service.json` et ajoutez les lignes suivantes au champ `hooks` :

```json
{
    "todo.date.hook": {
        "class": "TodoDate\\Services\\TodoHook",
        "arguments": [
            "@query",
            "@schema"
        ],
        "hooks": {
            "todo.item.create.form.data": "hookCreateFormData",
            "todo.item.create.form": "hookCreateForm"
        }
    }
}
```

Cette déclaration peut se résumer ainsi : 

* Lors d’un appel au hook `todo.item.create.form.date`, la fonction `hookCreateFormData()` de notre service `TodoHook` sera exéutée, 
* Et lors d’un appel au hook `todo.item.create.form`, la fonction `hookCreateForm()` de notre service `TodoHook` sera exécutée.

Il nous reste à créer les fonctions du service. Rendez-vous dans le service `TodoHook` et ajoutez-y ces fonctions :

```php
<?php

namespace TodoDate\Services;

class TodoHook
{
    private $query;

    private $schema;
    
    private $is_todo = false;

    public function __construct($query, $schema)
    {
        $this->query   = $query;
        $this->schema  = $schema;
        /* Si la table todo (donc le module todo) existe. */
        $this->is_todo = $schema->hasTable('todo');
    }

    public function hookCreateFormData(&$data)
    {
        /* Ici le code ajoutant les données passées en paramètre du nouveau champ date. */
    }

    public function hookCreateForm(&$form, $data)
    {
        /* Ici le code modifiant le formulaire passé en paramètre pour lui ajouter le nouveau champ. */
    }
}
```

Nous allons commencer par ajouter une donnée par défaut pour le champ date. Et si vous avez été attentif à la création des autres champs du formulaire de création, il suffit juste de spécifier une clé dans le tableau `$data` :

```php
public function hookCreateFormData(&$data)
{
    if ($this->is_todo) {
        $data[ 'date' ] = '';
    }
}
```

Voilà pour la donnée de base, maintenant passons à l’ajout du champ dans le formulaire. Pour ce faire, le composant `FormBuilder` fournit deux fonctions pour ajouter un ou plusieurs champs à un formulaire déjà déclaré :

```php
/**
 * Ajoute un ou plusieurs inputs avant un élément existant.
 *
 * @param string   $key      Clé unique.
 * @param callable $callback Fonction de création du sous-formulaire.
 *
 * @return $this
 *
 * @throws \Exception l’élément n’a pas été trouvé.
 */
public function addBefore($key, callable $callback);

/**
 * Ajoute un ou plusieurs inputs après un élément existant.
 *
 * @param string   $key      Clé unique.
 * @param callable $callback Fonction de création du sous-formulaire.
 *
 * @return $this
 *
 * @throws \Exception l’élément n’a pas été trouvé.
 */
public function addAfter($key, callable $callback);
```

Rendez-vous dans la fonction `hookCreateForm()` et ajoutez-y les lignes suivantes :

```php
public function hookCreateForm(&$form, $data)
{
    /* Si la table existe. */
    if ($this->is_todo) {
    
        /* On ajoute avant notre bouton de validation des champs. */
        $form->addBefore('submit', function ($form) use ($data) {

            /* Un groupe composé d’un label et d’un champ date. */
            $form->group('todo-item-date-group', 'div', function ($form) use ($data) {
                $form->label('todo-item-date-label', 'Date butoire', [ 'for' => 'todo-item-date' ])
                    ->date('date', 'todo-item-date', [
                        'class'    => 'form-control',
                        /* Ici notre champ date préalablement dans la fonction hookCreateFormData(). */
                        'value'    => $data[ 'date' ]
                ]);
            }, [ 'class' => 'form-group' ]);
        });
    }
}
```

Vérifions que nos fonctions renvoient bien notre formulaire d’ajout d’item avec le nouveau champ. 
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item](http://127.0.0.1/soosyze/?todo/item).

![Illustration 14_hooks](/assets/development/14_hooks.png)

Et voilà, c’est aussi simple que ça. ^^

Nous allons poursuivre notre exemple avec la validation de ce nouveau champ avec les fonctions d’appel au validateur.
Rendez-vous dans le fichier `service.json` du module `TodoDate`, et ajoutez-y les lignes suivantes :

```json
{
    "todo.date.hook": {
        "class": "TodoDate\\Services\\TodoHook",
        "arguments": [
            "@query",
            "@schema"
        ],
        "hooks": {
            "todo.item.create.form.data": "hookCreateFormData",
            "todo.item.create.form": "hookCreateForm",

            "todo.item.store.validator": "hookStoreValidator",
            "todo.item.store.after": "hookStoreAfter"
        }
    }
}
```

Pour l’appel aux hooks `todo.item.store.validator` nous ajoutons la fonction `hookStoreValidator()`, et pour l’appel à `todo.item.store.after` la fonction `hookStoreAfter`.

Rendez-vous dans le service `TodoHook` du module `TodoHook`, et ajoutez-y ces fonctions :

```php
<?php

namespace TodoDate\Services;

class TodoHook
{
    /* […] */

    public function hookStoreValidator(&$validator)
    {
        /* Si notre table existe. */
        if ($this->is_todo) {
            $minDate = date('Y-m-d', time());
            /* Nous ajoutons des règles de validation : 
             * Le champ n’est pas obligatoire, 
             * Le champ doit être de type 'date', 
             * La date ne doit pas être égale ou supérieure à la date du jour. 
             * La condition date_before_or_equal calcule si la date 
             * est strictement supérieure ou égale à celle donnée. 
             */
            $validator->addRule('date', '!required|date_after_or_equal:' . $minDate);
        }
    }

    public function hookStoreAfter($validator, &$value)
    {
        /* Si notre table existe et que le champ 'date' n’est pas vide, 
         * nous l’ajoutons à l’insertion de données. 
         */
        if ($this->is_todo) {
            if (!empty($validator->getInput('date'))) {
                $value[ 'date' ] = $validator->getInput('date');
            }
        }
    }
}
```

Maintenant, à vous de tester le bon fonctionnement de ce nouveau champ. 
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item](http://127.0.0.1/soosyze/?todo/item), remplissez les champs ainsi que la date et cliquez sur **_Enregistrer_**. 

Pour vérifier si la valeur du champ date a bien été prise en compte, rendez-vous dans le répertoire `app/data` et éditez le fichier `todo.json`. Vous devriez voir une valeur au champ `date` du nouvel item enregistré, à la place de `null`.

## Exercice d’édition d’item

Maintenant, je vous propose cet exercice : utiliser les hooks déclarés pour l’édition de l’item. 

L’exercice est assez simple car le champ `data` du formulaire création est identique à celui requis dans le formulaire d’édition. Vous devez utiliser les hooks pour : 

* Ajouter la valeur en base de données pour le formulaire d’édition, 
* Ajouter le champ `date` au formulaire d’édition d’item, 
* Valider la donnée modifiée, 
* Mettre à jour les données. 

Allez, c’est parti !

## Correction de l’édition d’item

La correction du fichier `service.json` du module `TodoDate` :

```json
{
    "todo.date.hook": {
        "class": "TodoDate\\Services\\TodoHook",
        "arguments": [
            "@query",
            "@schema"
        ],
        "hooks": {
            "todo.item.create.form.data": "hookCreateFormData",
            "todo.item.create.form": "hookCreateForm",

            "todo.item.store.validator": "hookStoreValidator",
            "todo.item.store.after": "hookStoreAfter",

            "todo.item.edit.form.data": "hookEditFormData",
            "todo.item.edit.form": "hookCreateForm",

            "todo.item.update.validator": "hookStoreValidator",
            "todo.item.update.after": "hookUpdateAfter"
        }
    }
}
```

Vous pouvez remarquer que nous utilisons la même fonction (*`hookCreateForm()`*) pour la déclaration du champ `date`, et la même fonction (*`hookStoreValidator()`*) pour la validation de données. 

La correction du fichier `TodoHook.php` du module `TodoDate` :

```php
<?php

namespace TodoDate\Services;

class TodoHook
{
    private $query;

    private $schema;

    private $is_todo = false;

    public function __construct($query, $schema)
    {
        $this->query   = $query;
        $this->schema  = $schema;
        $this->is_todo = $schema->hasTable('todo');
    }

    public function hookCreateFormData(&$data)
    {
        if ($this->is_todo) {
            $data[ 'date' ] = '';
        }
    }

    public function hookEditFormData(&$data, $id)
    {
        if ($this->is_todo) {
            if (!empty($data['date'])) {
                $data[ 'date' ] = $data[ 'date' ];
            }
        }
    }

    public function hookCreateForm(&$form, $data)
    {
        if ($this->is_todo) {
            $form->addBefore('submit', function ($form) use ($data) {
                $form->group('todo-item-date-group', 'div', function ($form) use ($data) {
                    $form->label('todo-item-date-label', 'Date butoire', [ 'for' => 'todo-item-date' ])
                        ->date('date', 'todo-item-date', [
                            'class'    => 'form-control',
                            'value'    => $data[ 'date' ]
                    ]);
                }, [ 'class' => 'form-group' ]);
            });
        }
    }

    public function hookStoreValidator(&$validator)
    {
        if ($this->is_todo) {
            $minDate = date('Y-m-d', time());
            $validator->addRule('date', '!required|date_after_or_equal:' . $minDate);
        }
    }

    public function hookStoreAfter($validator, &$value)
    {
        if ($this->is_todo) {
            if (!empty($validator->getInput('date'))) {
                $value[ 'date' ] = $validator->getInput('date');
            }
        }
    }

    public function hookUpdateAfter($validator, &$value, $id)
    {
        if ($this->is_todo) {
            $value[ 'date' ] = $validator->getInput('date');
        }
    }
}
```

Maintenant, à vous de tester le bon fonctionnement de ce nouveau champ. 
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item/1/edit](http://127.0.0.1/soosyze/?todo/item/1/edit), remplissez la date et cliquez sur **_Enregistrer_**.

![Illustration 14_hooks-correction_edition_d_item](/assets/development/14_hooks-correction_edition_d_item.png)

Après avoir fini d’écrire ce chapitre sur les hooks, je vous dirais que l’utilisation des services `query` et `schema` ne sont pas vraiment utiles dans le cas du module TodoDate (*vous le constaterez dans la chapitre suivant*). 
Effectivement, nous vérifions la présence de la table todo avant chaque opération, en nous assurant de l’existence de la "to do list". Mais en réalité, je dirais même que ces deux services sont du code mort car nous ne les utilisons plus vraiment (*pas d’insertion, d’édition ou de suppression de données*).

Mais lorsque vous developperez votre propre module et que vous aurez des opération en base de données, vous comprendrez rapidement que l’utilisation de ces deux services est indispenssable.

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/14_hooks).