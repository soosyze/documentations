# Validation de données

Une fois vos formulaires de création et d’édition réalisés, vous devez valider si les données correspondent à vos attentes.

* Si la validation échoue, vous renvoyez l’utilisateur au formulaire avec un message d’erreur,
* Si la validation réussit, vous enregistrez les données et vous renvoyez l’utilisateur à la page de gestion de la "to do list".

Dans la majorité des cas, pour valider les données d’un formulaire nous faisons passer plusieurs tests sur les données.

Par exemple, pour que les champs **Item** de notre formulaire soient valides, il faut :

* Que l’item existe, 
* Que la valeur de son titre soit une chaîne de caractères,
* Et que la chaîne ne dépasse pas 255 caractères.

Il y a de fortes chances que vous aboutissiez à un schéma de validation semblable à cela :

```php
<?php
$error = [];
$title = filter_input(INPUT_POST, 'title');

if (empty($title)) {
    $errors[] = 'Le champ title n’existe pas';
} if else (!is_string($title)) {
    $errors[] = 'Le champ title n’est pas une chaîne de caractère';
} if else (strlen($title) > 255) {
    $error[]  = 'Le champ title dépasse les 255 caractères';
}

if (empty($error)) {
    /* Aucune erreur, les données sont persistées et nous retournons un message de succès. */
} else {
    /* Une ou plusieurs erreurs. Vous renvoyez le tableau de message. */
}
```

Dans cet exemple, j’ai seulement pris en compte le champ **Item**, car la validation est généralement gourmande en écriture.

## Règles, valeur et validation

Pour nous simplifier la vie, nous utiliserons le composant `Validator` qui permet de chaîner les règles de validation et de simplifier les retours.

* [Doc de Validator](https://api.soosyze.com/Soosyze/Components/Validator.html).

Dans le chapitre dédié aux routes, nous avions créé deux fonctions concernant la validation des données de création et d’édition des items. Nous commencerons par la validation de l’ajout d’item.

Rendez-vous dans le contrôleur `TodoController` et ajoutez-y le composant `Soosyze\Components\Validator\Validator`, et dans la fonction `store()` ajoutez les lignes suivantes :

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

use Soosyze\Components\Form\FormBuilder;
use Soosyze\Components\Http\Redirect;
use Soosyze\Components\Template\Template;
/* Déclaration du composant de validation. */
use Soosyze\Components\Validator\Validator;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Config' . DS);
define("VIEWS_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Views' . DS);

class TodoController extends \Soosyze\Controller
{
    /* […] */

    public function store( $req )
    {
        /* La fonction getParsedBody de l’objet Request permet de récupérer les données dans la variable $_POST. */
        $post = $req->getParsedBody();

        /* Déclaration de la classe de validation. */
        $validator = new Validator();

        /* Nous créons une nouvelle règle. */
        $validator->addRule('title', 'required|string|max:255');

        /* Puis nous ajoutons notre champ récupéré dans POST. */
        $validator->addInput('title', $post['title']);

        /* Nous demandons au validator si la valeur fournie correspond aux règles. */
        if ($validator->isValid()) {
            echo 'Les données sont valides';
        } else {
            echo 'Les données ne sont pas valides';
        }
    }
}
```

La fonction `addRule( $key, $rule )` récupère en premier paramètre le nom du champ et en second paramètre les règles de validation séparées par un pipe (`|`). Ici, trois règles :

* `required` pour l’existence du champ, 
* `string` pour son type de données, 
* `max:255` pour le nombre de caractères maximum tolérés.

La fonction `addInput($key, $value)` prend en premier paramètre le nom du champ et en second sa valeur qui sera testée par la règle écrite dans `addRule`.

Je vous propose d’apporter une modification à notre fonction `store()`.
La variable `$post` correspond au tableau associatif `$_POST` utilisé dans l’objet `Request`. Par conséquent, au lieu de tester toutes les valeurs une par une, nous utiliserons la méthode `setInputs( array $values )` qui crée un tableau associant les valeurs et qui simplifie l’écriture des règles avec la méthode `setRules( array $rules )`.

```php
/* Les règles pour nos trois champs. */
$validator->setRules([
    /**
     * L’item doit être une chaîne de caractères obligatoirement 
     * ne dépassant pas les 255 caractères. 
     */
    'title'   => 'required|string|max:255',
    /* Le poids doit être un nombre entier obligatoirement, avec zéro pour valeur minimum. */
    'height'  => 'required|int|min:1',
    /* Notre checkbox de validation est un boolean. */
    'achieve' => 'bool',
    /* Une règle existe pour valider le token. */
    'token'   => 'required|token'
]);

/* Nous lui fournissons tous les champs. */
$validator->setInputs( $post );
```

Vérifions que notre fonction valide bien les données.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item](http://127.0.0.1/soosyze/?todo/item), remplissez le formulaire et cliquer sur **_Enregistrer_**.

## Gestion des succès et erreurs

Maintenant que nos règles et champs sont spécifiés dans le validateur, nous allons voir comme gérer correctement le retour.

Si vous voulez conserver un confort dans l’usage de votre formulaire, je vous propose de suivre les bonnes pratiques suivantes :

* En cas de succès :
  * Rediriger l’utilisateur sur la page d’administration de la "to do list",
  * Afficher un message de confirmation.
* En cas d’echec :
  * Rediriger l’utilisateur sur la page d’ajout d’items, 
  * Afficher un message pour chaque erreur, 
  * Surligner les champs en défaut, 
  * Conserver la valeur des champs déjà remplis.

Le composant `Validator` nous propose les fonctions suivantes :

```php
/* Retourne les messages erreurs. */
$validator->getErrors();

/* Retourne la valeur des champs. */
$validator->getInputs();

/* Retourne la liste des clés des champs qui sont erronés. */
$validator->getKeyInputErrors();
```
Modifiez la fonction `store()` pour que les messages et la valeur des champs soient conservés dans des variables `$_SESSION`.

Pour rappel, les variables de session peuvent conserver des données d’une page à l’autre si une session existe (*le framework permet de déclarer une session, donc vous pouvez les utiliser sans problème*).

```php
/* Nous demandons au validator si la valeur fournie correspond aux règles. */
if ($validator->isValid()) {
    /* Enregistrement d’un message de succès. */
    $_SESSION[ 'success' ] = [ 'Votre configuration a été enregistrée.' ];
} else {
    /* Enregistrement des messages d’erreurs et de la valeur des champs. */
    $_SESSION[ 'inputs' ]      = $validator->getInputs();
    $_SESSION[ 'errors' ]      = $validator->getErrors();
    /* Connaître les clés des champs erronés nous permet de savoir quel champ 
    est à modifier dans le formulaire. */
    $_SESSION[ 'errors_keys' ] = $validator->getKeyInputErrors();
}
```

Enfin, il faut renvoyer l’utilisateur sur la page d’ajout en cas d’erreur, ou bien le conduire sur la page index si les données sont valides.

```php
public function store( $req )
{
    $post      = $req->getParsedBody();
    $validator = new Validator();
    
    $validator->setRules([
            'title'    => 'required|string|max:255',
            'height'   => 'required|int|min:1',
            'achieve'  => 'bool'
            'token'    => 'required|token'
        ])
        ->setInputs( $post );

    if ($validator->isValid()) {
        $_SESSION[ 'success' ] = [ 'Votre configuration a été enregistrée.' ];
        $route                 = '?admin/todo';
    } else {
        $_SESSION[ 'inputs' ]      = $validator->getInputs();
        $_SESSION[ 'errors' ]      = $validator->getErrors();
        $_SESSION[ 'errors_keys' ] = $validator->getKeyInputErrors();
        $route                     = '?todo/item';
    }

    return new Redirect($route);
}
```

Il ne reste plus qu’à modifier la fonction d’affichage du formulaire d’ajout d’item et son template. Dans un premier temps, nous allons gérer la conservation des données du formulaire en cas d’erreur :

```php
/* Délcaration des données d’un item vide. */
$data = ['title'=>'', 'height' => 1, 'achieve' => false ];
    
/* Si les inputs nous reviennent par une variable de session c’est qu’ils ont échoués à la validation. */
if (isset($_SESSION[ 'inputs' ])) {
    /* On fusionne les données de base d’un item avec les données retournées. */
    $data = array_merge($data, $_SESSION[ 'inputs' ]);
    /* On supprime les données retournées. */
    unset($_SESSION[ 'inputs' ]);
}
```

Pour le surlignage des champs et l’affichage des messages en cas d’erreur, le composant `FormBuilder` nous propose les fonctions suivantes :

```php
/* Fournit au formulaire une variable ou un tableau pour les messages de succès. */
$form->setSuccess( $msg );

/* En fournissant un tableau des clés de champ en premier paramètre. */
/* Les attributs en second paramètre seront injectés dans les champs. */
$form->addAttrs(array $keys, array $attributs);
```

Nous allons modifier le formulaire une fois généré pour :

* Surligner la bordure des champs en rouge en y insérant l’attribut `[ 'style' => 'border-color:#a94442;' ]`,
* Ajouter nos messages d’erreur ou de succès.

```php
/* Si le formulaire n’est pas valide. */
if (isset($_SESSION[ 'errors' ])) {
    /* Ajout des messages. */
    $form->addErrors($_SESSION[ 'errors' ]);
    $form->addAttrs($_SESSION[ 'errors_keys' ], [ 'style' => 'border-color:#a94442;' ]);
    unset($_SESSION[ 'errors' ], $_SESSION[ 'errors_keys' ]);
}
/* Si le formulaire est valide. */
else if (isset($_SESSION[ 'success' ])) {
    /* Ajout du message. */
    $form->setSuccess($_SESSION[ 'success' ]);
    /* Supression de la variable de session. */
    unset($_SESSION[ 'success' ], $_SESSION[ 'errors' ]);
}
```

Rendez-vous dans le contrôleur `TodoController`, et dans la fonction `create()` ajoutez les lignes suvantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function create( $req )
{
    $form = new FormBuilder(['method' => 'post', 'action' => '?todo/item']);

    /* Délcaration des données d’un item vide. */
    $data = ['title'=>'', 'height' => 1, 'achieve' => false ];
    
    /**
     * Si les inputs nous reviennent par une variable de session c’est qu’ils ont échoués au test. 
     */
    if (isset($_SESSION[ 'inputs' ])) {
        /* On fusionne les données retournées et le tableau de données d’un item vide. */
        $data = array_merge($data, $_SESSION[ 'inputs' ]);
        /* On supprime les données retournées. */
        unset($_SESSION[ 'inputs' ]);
    }

    /* On remplit le formulaire des données. */
    $form->group('todo-group-item-title', 'div', function ($form) use ($data){
            $form->label('todo-item-title-label', 'Item', ['for'=>'todo-item-title'])
                 ->text('title', 'todo-item-title', [
                    'class'       => 'form-control',
                    'placeholder' => 'Tâche à réaliser', 
                    'required'    => true,
                    'value'       => $data['title']
                  ]);
        }, ['class' => 'form-group'])
        ->group('todo-group-item-height', 'div', function ($form) use ($data){
            $form->label('todo-item-height-label', 'Position', ['for'=>'todo-item-height'])
                 ->number('height', 'todo-item-height', [
                    'class'    => 'form-control',
                    'min'      => 1,
                    'required' => true,
                    'value'    => $data['height']
                ]);
        }, ['class' => 'form-group'])
        ->group('todo-group-item-achieve', 'div', function ($form) use ($data){
            $form->checkbox('achieve', 'todo-item-achieve', ['checked' => $data['achieve']])
                 ->label('todo-item-achieve-label', 'Réalisé', ['for'=>'todo-item-achieve']);
        }, ['class' => 'form-group'])
        ->token()
        ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);
        
    /* Si le formulaire n’est pas valide. */
    if (isset($_SESSION[ 'errors' ]))
    {
        /* Ajout des messages. */
        $form->addErrors($_SESSION[ 'errors' ])
             ->addAttrs($_SESSION[ 'errors_keys' ], [ 'style' => 'border-color:#a94442;' ]);
        unset($_SESSION[ 'errors' ], $_SESSION[ 'errors_keys' ]);
    }
    /* Si le formulaire est valide. */
    else if (isset($_SESSION[ 'success' ]))
    {
        /* Ajout du message. */
        $form->setSuccess($_SESSION[ 'success' ]);
        /* Supression de la variable de session. */
        unset($_SESSION[ 'success' ]);
    }

    $tpl   = new Template('html.php', VIEWS_TODO);
    $block = new Template('form-todo-item-add.php', VIEWS_TODO);

    $block->addVar('form', $form);

    return $tpl->addVar('main_title', 'Ajout d’un élément à la liste')
               ->addBlock('content', $block)
               ->render();
}
```

Pour finir, nous allons modifier le template `form-todo-item-add.php` pour l’affichage des messages :

```html
<!-- modules/TodoModule/Views/form-todo-item-add.php -->

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!-- Si notre formulaire comprend un ou plusieurs messages d’erreur. -->
            <?php if ($form->form_errors()): ?>
                <!-- On parcourt les messages et on les affiche. -->
                <?php foreach ($form->form_errors() as $error): ?>
                    <div class="alert alert-danger">
                        <p><?php echo $error ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
             <!-- Si notre formulaire comprend un ou plusieurs messages de succès. -->
            <?php if ($form->form_success()): ?>
                <?php foreach ($form->form_success() as $success): ?>
                    <div class="alert alert-success">
                        <p><?php echo $success ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->renderForm(); ?>
        </div>
    </div>
</div>
```

Voilà comment gérer le retour des données d’un formulaire, tout en garantisant une bonne ergonomie.

## Exercice validation de l’édition

Maintenant, je vous propose cet exercice : gérer la validation des données du formulaire pour la page d’édition d’un item de la "to do list".

L’exercice est assez simple car le formulaire d’édition est pratiquement identique à un formulaire de création. Les seuls points divergeants sont :

* Il faut vérifier que l’item à éditer existe bien,
* La modification de la route de redirection en cas d’erreur,
* La fusion des données en cas d’erreur avec les données préalablement récupérées pour l’affichage du formulaire.

## Correction validation de l’édition

La correction de la fonction `udpate()` :

```php
# modules/TodoModule/Controller/TodoController.php

public function udpate( $id, $req )
{
    if (!$this->getItem( $id )) {
        return $this->get404($req);
    }

    $post      = $req->getParsedBody();
    $validator = new Validator();
        
    $validator->setRules([
            'title'   => 'required|string|max:255',
            'height'  => 'required|int|min:1',
            'achieve' => 'bool',
            'token'   => 'required|token'
        ])
        ->setInputs( $post );

    if ($validator->isValid()) {
        $_SESSION[ 'success' ] = [ 'Votre configuration a été enregistrée.' ];
        $route                 = '?admin/todo';
    } else {
        $_SESSION[ 'inputs' ]      = $validator->getInputs();
        $_SESSION[ 'errors' ]      = $validator->getErrors();
        $_SESSION[ 'errors_keys' ] = $validator->getKeyInputErrors();
        $route                     = '?todo/item/' . $id . '/edit';
    }

    return new Redirect($route);
}
```

La correction de la fonction `edit()` :

```php
# modules/TodoModule/Controller/TodoController.php

public function edit( $id, $req )
{
    if (!($data = $this->getItem( $id ))) {
        return $this->get404($req);
    }
        
    /**
     * Si les inputs nous reviennent par une variable de session, c’est qu’ils ont échoué au test. 
     */
    if (isset($_SESSION[ 'inputs' ])) {
        /* On fusionne les données retournées et le tableau de données d’un item vide. */
        $data = array_merge($data, $_SESSION[ 'inputs' ]);
        /* On supprime les données retournées. */
        unset($_SESSION[ 'inputs' ]);
    }
        
    $form = new FormBuilder(['method' => 'post', 'action' => '?todo/item/' . $id . '/edit']);
    $form->group('todo-group-item-title', 'div', function ($form) use ($data){
            $form->label('todo-item-title-label', 'Item', ['for'=>'todo-item-title'])
                 ->text('title', 'todo-item-title', [
                    'class'       => 'form-control',
                    'maxlength'   => 255,
                    'placeholder' => 'Tâche à réaliser', 
                    'required'    => true,
                    'value'       => $data['title']
                  ]);
        }, ['class' => 'form-group'])
        ->group('todo-group-item-height', 'div', function ($form) use ($data){
            $form->label('todo-item-height-label', 'Position', ['for'=>'todo-item-height'])
                 ->text('height', 'todo-item-height', [
                    'class'    => 'form-control',
                    'min'      => 1,
                    'required' => true,
                    'value'    => $data['height']
                ]);
        }, ['class' => 'form-group'])
        ->group('todo-group-item-achieve', 'div', function ($form) use ($data){
            $form->checkbox('achieve', 'todo-item-achieve', ['checked' => $data['achieve']])
                 ->label('todo-item-achieve-label', 'Réalisé', ['for'=>'todo-item-achieve']);
        }, ['class' => 'form-group'])
        ->token()
        ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);
            
    /* Si le formulaire n’est pas valide. */
    if (isset($_SESSION[ 'errors' ]))
    {
        /* Ajout des messages. */
        $form->addErrors($_SESSION[ 'errors' ])
             ->addAttrs($_SESSION[ 'errors_keys' ], [ 'style' => 'border-color:#a94442;' ]);
        unset($_SESSION[ 'errors' ], $_SESSION[ 'errors_keys' ]);
    }
    /* Si le formulaire est valide. */
    else if (isset($_SESSION[ 'success' ]))
    {
        /* Ajout du message. */
        $form->setSuccess($_SESSION[ 'success' ]);
        /* Supression de la variable de session. */
        unset($_SESSION[ 'success' ]);
    }

    $tpl   = new Template('html.php', VIEWS_TODO);
    $block = new Template('form-todo-item-edit.php', VIEWS_TODO);

    $block->addVar('form', $form);

    return $tpl->addVar('main_title', 'Modification d’un élément à la liste')
               ->addBlock('content', $block)
               ->render();
}
```

La correction du template `form-todo-item-edit.php` :

```html
<!-- modules/TodoModule/Views/form-todo-item-edit.php -->

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <!-- Si notre formulaire comprend un ou plusieurs messages d’erreur. -->
            <?php if ($form->form_errors()): ?>
                <!-- On parcourt les messages et on les affiche. -->
                <?php foreach ($form->form_errors() as $error): ?>
                    <div class="alert alert-danger">
                        <p><?php echo $error ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
             <!-- Si notre formulaire comprend un ou plusieurs messages de succès. -->
            <?php if ($form->form_success()): ?>
                <?php foreach ($form->form_success() as $success): ?>
                    <div class="alert alert-success">
                        <p><?php echo $success ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->renderForm(); ?>
        </div>
    </div>
</div>
```

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/11_validation).