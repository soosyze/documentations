<?php

// modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

use Soosyze\Components\Form\FormBuilder;
use Soosyze\Components\Http\Redirect;
use Soosyze\Components\Template\Template;
use Soosyze\Components\Validator\Validator;

define('CONFIG_TODO', MODULES_CONTRIBUED . 'TodoModule' . DS . 'config' . DS);

define('VIEWS_TODO', MODULES_CONTRIBUED . 'TodoModule' . DS . 'Views' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathServices = CONFIG_TODO . 'service.json';
        $this->pathRoutes   = CONFIG_TODO . 'routing.json';
    }

    public function index($req)
    {
        $tpl = new Template('html.php', VIEWS_TODO);

        $block = new Template('page-todo-index.php', VIEWS_TODO);

        $list = self::todo()->getList();

        $block->addVar('todo', $list);

        return $tpl->addVar('main_title', 'Affichage de la liste')
                ->addBlock('content', $block)
                ->render();
    }

    public function admin($req)
    {
        $tpl = new Template('html.php', VIEWS_TODO);

        $block = new Template('page-todo-admin.php', VIEWS_TODO);

        $list = self::todo()->getList();

        $block->addVar('todo', $list);

        return $tpl->addVar('main_title', 'Affichage de la liste pour l’admin')
                ->addBlock('content', $block)
                ->render();
    }

    public function create($req)
    {
        $data = [ 'title' => '', 'height' => 1, 'achieve' => false ];

        $this->container->callHook('todo.item.create.form.data', [ &$data ]);

        if (isset($_SESSION[ 'inputs' ])) {
            $data = array_merge($data, $_SESSION[ 'inputs' ]);
            unset($_SESSION[ 'inputs' ]);
        }

        $route = self::router()->getRoute('todo.item.store');

        $form = new FormBuilder([ 'method' => 'post', 'action' => $route ]);
        $form->group('todo-item-title-group', 'div', function ($form) use ($data) {
            $form->label('todo-item-title-label', 'Item', [ 'for' => 'todo-item-title' ])
                ->text('title', 'todo-item-title', [
                    'class'       => 'form-control',
                    'maxlength'   => 255,
                    'placeholder' => 'Tâche à réaliser',
                    'required'    => true,
                    'value'       => $data[ 'title' ],
                ]);
        }, [ 'class' => 'form-group' ])
            ->group('todo-item-height-group', 'div', function ($form) use ($data) {
                $form->label('todo-item-height-label', 'Position', [ 'for' => 'todo-item-height' ])
                ->number('height', 'todo-item-height', [
                    'class'    => 'form-control',
                    'min'      => 1,
                    'required' => true,
                    'value'    => $data[ 'height' ],
                ]);
            }, [ 'class' => 'form-group' ])
            ->group('todo-item-achieve-group', 'div', function ($form) use ($data) {
                $form->checkbox('achieve', 'todo-item-achieve', [ 'checked' => $data[ 'achieve' ] ])
                    ->label('todo-item-achieve-label', 'Réalisé', [ 'for' => 'todo-item-achieve' ]);
            }, [ 'class' => 'form-group' ])
            ->token()
            ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);

        $this->container->callHook('todo.item.create.form', [ &$form, $data ]);

        if (isset($_SESSION[ 'errors' ])) {
            $form->addErrors($_SESSION[ 'errors' ])
                ->addAttrs($_SESSION[ 'errors_keys' ], [ 'style' => 'border-color:#a94442;' ]);
            unset($_SESSION[ 'errors' ], $_SESSION[ 'errors_keys' ]);
        } elseif (isset($_SESSION[ 'success' ])) {
            $form->setSuccess($_SESSION[ 'success' ]);
            unset($_SESSION[ 'success' ], $_SESSION[ 'errors' ]);
        }

        $tpl   = new Template('html.php', VIEWS_TODO);
        $block = new Template('form-todo-item-add.php', VIEWS_TODO);

        $block->addVar('form', $form);

        return $tpl->addVar('main_title', 'Ajout d’un élément à la liste')
                ->addBlock('content', $block)
                ->render();
    }

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

        $this->container->callHook('todo.item.store.validator', [ &$validator ]);

        if ($validator->isValid()) {
            $value = [
                'title'   => $validator->getInput('title'),
                'height'  => $validator->getInput('height'),
                'achieve' => (bool) $validator->getInput('achieve'),
            ];

            $this->container->callHook('todo.item.store.after', [ $validator, &$value ]);
            self::query()
                ->insertInto('todo', array_keys($value))
                ->values($value)
                ->execute();
            $this->container->callHook('todo.item.store.before', [ $validator ]);

            $_SESSION[ 'success' ] = [ 'Votre configuration a été enregistrée.' ];
            $route                 = self::router()->getRoute('todo.admin');
        } else {
            $_SESSION[ 'inputs' ]      = $validator->getInputs();
            $_SESSION[ 'errors' ]      = $validator->getErrors();
            $_SESSION[ 'errors_keys' ] = $validator->getKeyInputErrors();
            $route                     = self::router()->getRoute('todo.item.create');
        }

        return new Redirect($route);
    }

    public function edit($id, $req)
    {
        if (!($data = self::todo()->getItem($id))) {
            return $this->get404($req);
        }

        $this->container->callHook('todo.item.edit.form.data', [ &$data, $id ]);

        if (isset($_SESSION[ 'inputs' ])) {
            $data = array_merge($data, $_SESSION[ 'inputs' ]);
            unset($_SESSION[ 'inputs' ]);
        }

        $route = self::router()->getRoute('todo.item.update', [ ':id' => $id ]);

        $form = new FormBuilder([ 'method' => 'post', 'action' => $route ]);
        $form->group('todo-item-title-group', 'div', function ($form) use ($data) {
            $form->label('todo-item-title-label', 'Item', [ 'for' => 'todo-item-title' ])
                ->text('title', 'todo-item-title', [
                    'class'       => 'form-control',
                    'placeholder' => 'Tâche à réaliser',
                    'required'    => true,
                    'value'       => $data[ 'title' ],
                ]);
        }, [ 'class' => 'form-group' ])
            ->group('todo-item-height-group', 'div', function ($form) use ($data) {
                $form->label('todo-item-height-label', 'Position', [ 'for' => 'todo-item-height' ])
                ->number('height', 'todo-item-height', [
                    'class'    => 'form-control',
                    'min'      => 1,
                    'required' => true,
                    'value'    => $data[ 'height' ],
                ]);
            }, [ 'class' => 'form-group' ])
            ->group('todo-item-achieve-group', 'div', function ($form) use ($data) {
                $form->checkbox('achieve', 'todo-item-achieve', [ 'checked' => $data[ 'achieve' ] ])
                    ->label('todo-item-achieve-label', 'Réalisé', [ 'for' => 'todo-item-achieve' ]);
            }, [ 'class' => 'form-group' ])
            ->token()
            ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);

        $this->container->callHook('todo.item.edit.form', [ &$form, $data ]);

        if (isset($_SESSION[ 'errors' ])) {
            $form->addErrors($_SESSION[ 'errors' ])
                ->addAttrs($_SESSION[ 'errors_keys' ], [ 'style' => 'border-color:#a94442;' ]);
            unset($_SESSION[ 'errors' ], $_SESSION[ 'errors_keys' ]);
        } elseif (isset($_SESSION[ 'success' ])) {
            $form->setSuccess($_SESSION[ 'success' ]);
            unset($_SESSION[ 'success' ]);
        }

        $tpl   = new Template('html.php', VIEWS_TODO);
        $block = new Template('form-todo-item-edit.php', VIEWS_TODO);

        $block->addVar('form', $form);

        return $tpl->addVar('main_title', 'Édition d’un élément à la liste')
                ->addBlock('content', $block)
                ->render();
    }

    public function update($id, $req)
    {
        if (!self::todo()->getItem($id)) {
            return $this->get404($req);
        }

        $post      = $req->getParsedBody();
        $validator = new Validator();

        $validator->setRules([
                'title'   => 'required|string|max:255',
                'height'  => 'required|int|min:1',
                'achieve' => 'bool',
                'token'   => 'required|token',
            ])
            ->setInputs($post);

        $this->container->callHook('todo.item.update.validator', [ &$validator, $id ]);

        if ($validator->isValid()) {
            $value = [
                'title'   => $validator->getInput('title'),
                'height'  => $validator->getInput('height'),
                'achieve' => (bool) $validator->getInput('achieve'),
            ];

            $this->container->callHook('todo.item.update.after', [ $validator, &$value,
                $id, ]);
            self::query()
                ->update('todo', $value)
                ->where('id', '==', $id)
                ->execute();
            $this->container->callHook('todo.item.update.before', [ $validator,
                $id, ]);

            $_SESSION[ 'success' ] = [ 'Votre configuration a été enregistrée.' ];
            $route                 = self::router()->getRoute('todo.admin');
        } else {
            $_SESSION[ 'inputs' ]      = $validator->getInputs();
            $_SESSION[ 'errors' ]      = $validator->getErrors();
            $_SESSION[ 'errors_keys' ] = $validator->getKeyInputErrors();
            $route                     = self::router()->getRoute('todo.item.edit', [
                ':id' => $id, ]);
        }

        return new Redirect($route);
    }

    public function delete($id, $req)
    {
        self::query()->from('todo')
            ->delete()
            ->where('id', '==', $id)
            ->execute();

        $route = self::router()->getRoute('todo.admin');

        return new Redirect($route);
    }
}
