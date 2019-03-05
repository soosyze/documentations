# Formulaire

Pour pouvoir gérer une "to do list", nous allons avoir besoin d’un formulaire pour l’ajout et l’édition des éléments de la liste.
Nous avons besoin d’un champ texte pour l’intitulé, d’un champ numérique pour la position, d’une checkbox pour savoir si la tâche est réalisée et d’un bouton de validation.

## Formulaire simple

Rendez-vous dans le répertoire `TodoModule\Views` et créez un fichier `form-item-add.php`, éditez-le et ajoutez les lignes suivantes pour créer le formulaire :

```html
<!-- modules/TodoModule/Views/form-todo-item-add.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="?todo/item" method="POST">
                <div class="form-group">
                    <label for="todo-item-title">Item<span class="form-required">*</span></label>
                    <input name="title" type="text" id="todo-item-title" class="form-control" maxlength="255" placeholder="Tâche à réaliser" required>
                </div>
                <div class="form-group">
                    <label for="todo-item-height">Position<span class="form-required">*</span></label>
                    <input name="height" type="number" id="todo-item-height" class="form-control" min="1" required value="1">
                </div>
                <div class="form-group">
                    <input name="submit" type="checkbox" id="item-todo-submit">
                    <label for="item-todo-submit">Réalisé</label>
                </div>
                <input name="submit" type="submit" class="btn btn-success" value="Enregistrer">
            </form>
        </div>
    </div>
</div>
```

* Notre formulaire enverra ses données en `POST` à la fonction `store()` via la route `?todo/item`,
* Le premier champ de type texte sera utilisé pour créer l’intitulé des tâches de la liste,
* Le second champ de type numérique permet d’ordonner les tâches dans la liste,
* Le troisième champ est une checkbox pour spécifier si la tâche est réalisée,
* Et le dernier champ est le bouton de validation.

Une fois ce formulaire créé, rendez-vous dans le contrôleur `TodoController` et ajoutez à la fonction `create( $req )` les lignes suivantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function create( $req )
{
    $tpl   = new Template('html.php', VIEWS_TODO);
    $block = new Template('form-todo-item-add.php', VIEWS_TODO);

    /* Je retourne mon formulaire dans une sous template dans ma page principale. */
    return $tpl->addVar('main_title', 'Ajout d’un élément à la liste')
               ->addBlock('content', $block)
               ->render();
}
```

Vérifions que notre fonction renvoie bien notre formulaire d’ajout d’items.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item](http://127.0.0.1/soosyze/?todo/item).

![Illustration 10_formulaire-formulaire_simple](/assets/development/10_formulaire-formulaire_simple.png)

Dans les cas simples (*petite application, page simple…*), je vous recommande de créer votre formulaire en brut dans un template et de l’appeler directement, comme nous l’avons fait.

## Formulaire simple & dynamique

Dans le cas d’un CMS, les modules doivent pouvoir communiquer entre eux et notamment modifier dynamiquement un formulaire. C’est l’une des raisons pour lesquelles il existe le composant `FormBuilder`. Celui-ci permet d’écrire un formulaire dynamique en PHP et de le générer en HTML.

- [Doc de FormBuilder](https://api.soosyze.com/Soosyze/Components/Form/FormBuilder.html).

Rendez-vous dans le contrôleur `TodoController`, ajoutez le composant `Soosyze\Components\Form\FormBuilder`, et dans la fonction `itemAdd()` ajoutez les lignes suivantes :

```php
<?php
# modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

/* Déclaration du composant de génération de formulaire. */
use Soosyze\Components\Form\FormBuilder;
use Soosyze\Components\Http\Redirect;
use Soosyze\Components\Template\Template;

define("CONFIG_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Config' . DS);

define("VIEWS_TODO", MODULES_CONTRIBUED . 'TodoModule' . DS . 'Views' . DS);

class TodoController extends \Soosyze\Controller
{
    public function create( $req )
    {
        /* Déclaration du formulaire. */
        $form = new FormBuilder([]);

        /**
         * Je crée mon champ texte avec le FormBuilder,
         * Le premier paramètre est sa clé unique (le paramètre name) et le second son id.
         */
        $form->text('title', 'todo-item-title');

        $tpl   = new Template('html.php', VIEWS_TODO);
        $block = new Template('form-todo-item-add.php', VIEWS_TODO);

        /* Nous ajoutons le formulaire à notre sous template form.php */
        $block->addVar('form', $form);

        return $tpl->addVar('main_title', 'Ajout d’un élément à la liste')
                   ->addBlock('content', $block)
                   ->render();
    }
}
```

Puis, modifiez la vue `form-todo-item-add.php` pour utiliser `FormBuilder` :

```html
<!-- modules/TodoModule/Views/form-todo-item-add.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action='?todo/item' method="POST">
                <div class="form-group">
                    <label for="todo-item-title">Item<span class="form-required">*</span></label>
                    <?php echo $form->form_input('title', [
                        'class'       => 'form-control',
                        'id'          => 'todo-item-title'
                        'maxlength'   => 255,
                        'placeholder' => 'Tâche à réaliser', 
                        'required'    => true
                    ]); ?>
                </div>
                <div class="form-group">
                    <label for="todo-item-height">Position<span class="form-required">*</span></label>
                    <input name="height" type="number" id="todo-item-height" class="form-control" min="1" required value="1">
                </div>
                <div class="form-group">
                    <input name="achieve" type="checkbox" id="todo-item-achieve">
                    <label for="todo-item-achieve">Réalisé</label>
                </div>
                <input name="submit" type="submit" class="btn btn-success" value="Enregistrer">
            </form>
        </div>
    </div>
</div>
```

Vérifions que notre fonction renvoie bien notre formulaire d’ajout d’item.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item](http://127.0.0.1/soosyze/?todo/item).

Comme vous pouvez le constater, nous utilisons la méthode `form_input()` pour appeler le champ préalablement créé dans notre contrôleur. Le premier paramètre est la clé unique du champ, et le second paramètre est un tableau d’attributs acceptés dans une balise `<input>`. Nous y avons mis les attributs `class`, `id`, `placeholder` et `required`.

Maintenant que vous savez comment créer un champ dans le contrôleur et l’appeler dans la vue, nous allons tranposer tous les autres éléments du formulaire, côté contrôleur, et les appeler dynamiquement dans la vue.

Rendez-vous dans le contrôleur `TodoController`, et dans la fonction `create()` ajoutez les lignes suivantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function create( $req )
{
    $form = new FormBuilder([]);

    /* Tous nos champs et labels sont créés dans le contrôleur. */
    $form->label('todo-item-title-label', 'Item')
         ->text('title', 'todo-item-title')
         ->label('todo-item-height-label', 'Position')
         ->number('height', 'todo-item-height')
         ->checkbox('achieve', 'item-todo-achieve')
         ->label('todo-item-achieve-label', 'Réalisé')
         ->submit('submit', 'Enregistrer');

    $tpl   = new Template('html.php', VIEWS_TODO);
    $block = new Template('form-todo-item-add.php', VIEWS_TODO);

    $block->addVar('form', $form);

    return $tpl->addVar('main_title', 'Ajout d’un élément à la liste')
               ->addBlock('content', $block)
               ->render();
}
```

Puis modifier la vue `form-todo-item-add.php` pour appeler dynamiquement tous les champs :

```html
<!-- modules/TodoModule/Views/form-todo-item-add.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $form->form_open(['method' => 'post', 'action' => '?todo/item']); ?>
                <div class="form-group">
                    <?php echo $form->form_label('todo-item-title-label', ['for'=>'todo-item-title']); ?>
                    <?php echo $form->form_input('title', [
                        'class'       => 'form-control',
                        'id'          => 'todo-item-title'
                        'maxlength'   => 255,
                        'placeholder' => 'Tâche à réaliser', 
                        'required'    => true
                    ]); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->form_label('todo-item-height-label', ['for'=>'todo-item-height']); ?>
                    <?php echo $form->form_input('height', [
                            'class'    => 'form-control',
                            'min'      => 1,
                            'required' => true,
                            'value'    => 1
                    ]); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->form_input('achieve'); ?>
                    <?php echo $form->form_label('todo-item-achieve-label', ['for'=>'todo-item-achieve']); ?>
                </div>
                <?php echo $form->form_input('submit', [
                    'class' => 'btn btn-success'
                ]); ?>
            <?php echo $form->form_close(); ?>
        </div>
    </div>
</div>
```

Vérifions que notre fonction renvoie bien notre formulaire d’ajout d’item.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item](http://127.0.0.1/soosyze/?todo/item).

Cette façon de faire permet de générer un formulaire et de récupérer les champs avec plusieurs avantages :

* Simplicité de génération côté contrôleur,
* Personnalisation des champs dans le template.

## Formulaire dynamique

L’utilisation des formulaires dynamiques apporte une très grande souplesse dans votre application. Rendre dynamique un formulaire signifie pouvoir changer le comportement des champs avant son affichage. Par exemple :

* Injecter des données dans les champs à partir d’une base de données,
* Générer tout un formulaire à partir de données stockées en base, compléter les fonctionnalités sans disperser les interfaces,
* Ajouter des champs à un formulaire d’un module-A depuis un module-B.

Pour rendre votre formulaire totalement dynamique, il doit être généré entièrement côté contrôleur, c’est-à-dire :

* Les attributs des champs (*placeholder, required, value…*) sont écrits dans le contrôleur et non dans le template,
* Le reste d’HTML, comme les `<div></div>` qui permettent de grouper les champs, sont également écrits dans le contrôleur,
* Nous ne générerons plus les champs un par un mais avec une fonction générique pour tout le formulaire.

Rendez-vous dans le contrôleur `TodoController`, et dans la fonction `create()` ajoutez les lignes suivantes :

```php
# modules/TodoModule/Controller/TodoController.php

public function create( $req )
{
    /* Déclaration du formulaire et de ses attributs. */
    $form = new FormBuilder(['method' => 'post', 'action' => '?todo/item']);

    /* Création d’un groupe de champ. */
    $form->group('todo-item-title-group', 'div', function ($form) {
            $form->label('todo-item-title-label', 'Item', ['for'=>'todo-item-title'])
                 ->text('title', 'todo-item-title', [
                    'class'       => 'form-control',
                    'maxlength'   => 255,
                    'placeholder' => 'Tâche à réaliser', 
                    'required'    => true
                  ]);
        }, ['class' => 'form-group']);

    /* Vous pouvez également chaîner l’ensemble des méthodes. */
    $form->group('todo-item-height-group', 'div', function ($form) {
            $form->label('todo-item-height-label', 'Position', ['for'=>'todo-item-height'])
                 ->number('height', 'todo-item-height', [
                    'class'    => 'form-control',
                    'min'      => 1,
                    'required' => true,
                    'value'    => 1
                 ]);
        }, ['class' => 'form-group'])
        ->group('todo-item-achieve-group', 'div', function ($form) {
            $form->checkbox('achieve', 'todo-item-achieve')
                 ->label('todo-item-achieve-label', 'Réalisé', ['for'=>'todo-item-achieve']);
        }, ['class' => 'form-group'])
        ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);

    $tpl   = new Template('html.php', VIEWS_TODO);
    $block = new Template('form-todo-item-add.php', VIEWS_TODO);

    $block->addVar('form', $form);

    return $tpl->addVar('main_title', 'Ajout d’un élément à la liste')
               ->addBlock('content', $block)
               ->render();
}
```

Vous pouvez appeler les groupes de champs directement :

```html
<!-- modules/TodoModule/Views/form-todo-item-add.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $form->form_open(); ?>
                <?php echo $form->form_group('todo-item-title-group'); ?>
                <?php echo $form->form_group('todo-item-height-group'); ?>
                <?php echo $form->form_group('todo-item-achieve-group'); ?>
                <?php echo $form->form_input('submit'); ?>
            <?php echo $form->form_close(); ?>
        </div>
    </div>
</div>
```

Mais le but étant de générer entièrement le formulaire (*si celui-ci est créé dans le contrôleur*),  le code suivant suffit :

```html
<!-- modules/TodoModule/Views/form-todo-item-add.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $form->renderForm(); ?>
        </div>
    </div>
</div>
```

Vérifions que notre fonction renvoie bien notre formulaire d’ajout d’item.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item](http://127.0.0.1/soosyze/?todo/item).
Vous pouvez également remplir le formulaire et cliquer sur **Enregistrer** pour vérifier si le formulaire est bien envoyé dans la fonction de validation d’ajout d’item.

Pour tous les autres champs et le reste des fonctionnalités de FormBuilder, je vous invite à lire la PhpDoc du composant.

## Protection CSRF

La faille CSRF (Cross-Site Request Forgery) est un type de vulnérabilité informatique qui vise à faciliter une requête HTTP.

Pour illustrer cela, imaginez que vous créiez un formulaire en local qui pointe sur l’URL de validation des données : vous pourriez alors envoyer des données sans passer par le formulaire du site.

Pour corriger cette faille, vous devez vous assurer que les données proviennent bien de votre formulaire et pas d’un autre. Un moyen très simple pour s’en assurer est de créer un token aléatoire de validité dans votre formulaire. À sa soumission, vérifiez si le token a bien été généré quelques minutes auparavant.

Le composant `FormBuilder` propose une fonction `token()` générant un champ caché avec une valeur aléatoire. Cette valeur sera stockée dans une variable de session `$_SESSION['token']`, et la date de génération milliseconde sera stocké dans la variable de session `$_SESSION['token_time']`. 

Il suffit de contrôler si la valeur du token et la durée qui y est attribuée correspondent aux valeurs stockées en session dans les fonctions de validation de données.

Rendez-vous dans le contrôleur `TodoController`, et dans la fonction `create()` ajoutez la méthode `token()` à notre génération de formulaire :

```php
# modules/TodoModule/Controller/TodoController.php

public function create( $req )
{
    $form = new FormBuilder(['method' => 'post', 'action' => '?todo/item']);

    $form->/* […] */
        /* Ajouter la fonction token en fin de formulaire pour une meilleure visibilité. */
        ->token()
        ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);
        
        /* […] */
}
```

Cette méthode générera un code HTML semblable à celui-ci :
```html
<input name="token" type="hidden" value="261525b507996dcd958.39126826">
```

## Exrecice formulaire d’édition

Maintenant, je vous propose cet exercice : créer le formulaire pour la page d’édition d’un item de la "to do list".

L’exercice est assez simple, car un formulaire d’édition est pratiquement identique à un formulaire de création.
Les seuls points divergeants sont :

* La récupération de données et la gestion du manque de données,
* L’injection de données dans le formulaire,
* Le changement de template : bien qu’identiques, séparer les templates permet une découpe plus aisée en cas de surcharge de l’interface.

Comme vous n’utilisez pas de base de données pour le moment, je vous fournis une fonction à ajouter dans votre contrôleur pour simuler la récupération d’un élément de la liste via son identifiant :

```php
# modules/TodoModule/Controller/TodoController.php

private function getItem( $id )
{
    $data = $this->getList();
    
    /* Retourne un item de la liste ou un tableau vide s’il n’existe pas. */
    return isset($data[$id])
        ? $data[$id]
        : [];
}
```

## Correction formulaire d’édition

Voici la correction de notre fonction `edit()` du contrôleur :

```php
# modules/TodoModule/Controller/TodoController.php

public function edit( $id, $req )
{
    if (!($data = $this->getItem( $id ))) {
        /** 
         * Si vous avez regardé la PhpDoc de l’objet Controller, 
         * celui-ci fournit la méthode get404() qui retourne 
         * un objet Response avec le statut 404. 
         */
        return $this->get404($req);
        /**
         * La seconde solution peut-être l’utilisation directe d’un objet Response.
         * return new Response(404, new Stream( 'Aucun item ne correspond à l’identifiant ' . $id ) );
         */
    }
    
    /* La déclaration du FormBuilder vient après la condition d’existence de l’item. */
    /* Ça ne sert à rien d’exécuter du code s’il n’ai pas utilisé en cas d’erreur. */
    $form = new FormBuilder(['method' => 'post', 'action' => '?todo/item/' . $id . '/edit']);

    /**
     * On injecte les données dans le formulaire 
     * avec l’utilisation de 'use' pour les fonctions anonymes.
     */
    $form->group('todo-item-title-group', 'div', function ($form) use ($data){
            $form->label('todo-item-title-label', 'Item', ['for'=>'todo-item-title'])
                 ->text('title', 'todo-item-title', [
                    'class'       => 'form-control',
                    'maxlength'   => 255,
                    'placeholder' => 'Tâche à réaliser', 
                    'required'    => true,
                    'value'       => $data['title']
                 ]);
        }, ['class' => 'form-group'])
        ->group('todo-item-height-group', 'div', function ($form) use ($data){
            $form->label('todo-item-height-label', 'Position', ['for'=>'todo-item-height'])
                 ->number('height', 'todo-item-height', [
                    'class'    => 'form-control'
                    'min'      => 1,
                    'required' => true,
                    'value'    => $data['height']
                 ]);
        }, ['class' => 'form-group'])
        ->group('todo-item-achieve-group', 'div', function ($form) use ($data){
            $form->checkbox('achieve', 'todo-item-achieve', ['checked' => $data['achieve']])
                 ->label('todo-item-achieve-label', 'Réalisé', ['for'=>'todo-item-achieve']);
        }, ['class' => 'form-group'])
        ->token()
        ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);

    $tpl   = new Template('html.php', VIEWS_TODO);
    /* On change de template. */
    $block = new Template('form-todo-item-edit.php', VIEWS_TODO);

    $block->addVar('form', $form);

    return $tpl->addVar('main_title', 'Modification d’un élément à la liste')
               ->addBlock('content', $block)
               ->render();
}
```

Et le template `form-todo-item-add.php` :

```html
<!-- modules/TodoModule/Views/form-todo-item-add.php -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $form->renderForm(); ?>
        </div>
    </div>
</div>
```

Vérifions que notre fonction renvoie bien notre formulaire d’édition d’item.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item/1/edit](http://127.0.0.1/soosyze/?todo/item/1/edit).

![Illustration 10_formulaire-correction_formulaire_d_edition](/assets/development/10_formulaire-correction_formulaire_d_edition.png)

Vous pouvez également vérifier si une erreur 404 est levée, dans le cas où l’URL pointe sur un item non existant.
Rendez-vous sur l’URL [http://127.0.0.1/soosyze/?todo/item/4/edit](http://127.0.0.1/soosyze/?todo/item/4/edit).

![Illustration 10_formulaire-404.png](/assets/development/10_formulaire-404.png)

Comme votre module fonctionne sur le CMS, il renvoie par défaut sa page 404. Si on avait utilisé un framework, le message aurait été affiché dans l’objet `Response`.

Vous pouvez retrouver les sources de ce chapitre en suivant ce [lien](/development/module/src/10_formulaire).