<?php

// modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

use Soosyze\Components\Form\FormBuilder;
use Soosyze\Components\Http\Redirect;
use Soosyze\Components\Template\Template;

define('CONFIG_TODO', MODULES_CONTRIBUED . 'TodoModule' . DS . 'config' . DS);

define('VIEWS_TODO', MODULES_CONTRIBUED . 'TodoModule' . DS . 'Views' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = CONFIG_TODO . 'routing.json';
    }

    public function index($req)
    {
        $tpl = new Template('html.php', VIEWS_TODO);

        $block = new Template('page-todo-index.php', VIEWS_TODO);

        $list = $this->getList();

        $block->addVar('todo', $list);

        return $tpl->addVar('main_title', 'Affichage de la liste')
                ->addBlock('content', $block)
                ->render();
    }

    public function admin($req)
    {
        $tpl = new Template('html.php', VIEWS_TODO);

        $block = new Template('page-todo-admin.php', VIEWS_TODO);

        $list = $this->getList();

        $block->addVar('todo', $list);

        return $tpl->addVar('main_title', 'Affichage de la liste pour l’admin')
                ->addBlock('content', $block)
                ->render();
    }

    public function create($req)
    {
        $form = new FormBuilder([ 'method' => 'post', 'action' => '?todo/item' ]);

        $form->group('todo-item-title-group', 'div', function ($form) {
            $form->label('todo-item-title-label', 'Item', [ 'for' => 'todo-item-title' ])
                ->text('title', 'todo-item-title', [
                    'class'       => 'form-control',
                    'maxlength'   => 255,
                    'placeholder' => 'Tâche à réaliser',
                    'required'    => true,
            ]);
        }, [ 'class' => 'form-group' ]);

        $form->group('todo-item-height-group', 'div', function ($form) {
            $form->label('todo-item-height-label', 'Position', [ 'for' => 'todo-item-height' ])
                ->number('height', 'todo-item-height', [
                    'class'    => 'form-control',
                    'min'      => 1,
                    'required' => true,
                    'value'    => 1,
                ]);
        }, [ 'class' => 'form-group' ])
            ->group('todo-item-achieve-group', 'div', function ($form) {
                $form->checkbox('achieve', 'todo-item-achieve')
                    ->label('todo-item-achieve-label', 'Réalisé', [ 'for' => 'todo-item-achieve' ]);
            }, [ 'class' => 'form-group' ])
            ->token()
            ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);

        $tpl   = new Template('html.php', VIEWS_TODO);
        $block = new Template('form-todo-item-add.php', VIEWS_TODO);

        $block->addVar('form', $form);

        return $tpl->addVar('main_title', 'Ajout d’un élément à la liste')
                ->addBlock('content', $block)
                ->render();
    }

    public function store($req)
    {
        return 'Validation d’ajout d’item';
    }

    public function edit($id, $req)
    {
        if (!($data = $this->getItem($id))) {
            return $this->get404($req);
        }

        $form = new FormBuilder([ 'method' => 'post', 'action' => '?todo/item/' . $id . '/edit' ]);
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
                $form->label('todo-item-achieve-label', 'Réalisé', [ 'for' => 'todo-item-achieve' ])
                ->checkbox('achieve', 'todo-item-achieve', [ 'checked' => $data[ 'achieve' ] ]);
            }, [ 'class' => 'form-group' ])
            ->token()
            ->submit('submit', 'Enregistrer', [ 'class' => 'btn btn-success' ]);

        $tpl   = new Template('html.php', VIEWS_TODO);
        $block = new Template('form-todo-item-edit.php', VIEWS_TODO);

        $block->addVar('form', $form);

        return $tpl->addVar('main_title', 'Édition d’un élément à la liste')
                ->addBlock('content', $block)
                ->render();
    }

    public function update($id, $req)
    {
        return new Redirect('?todo/index');
    }

    public function delete($id, $req)
    {
        return "Validation de la suppression de l’item N°$id";
    }

    private function getList()
    {
        return [
            1 => [
                'id'      => 1,
                'title'   => 'Item 1',
                'height'  => 1,
                'achieve' => false,
            ],
            2 => [
                'id'      => 2,
                'title'   => 'Item 2',
                'height'  => 2,
                'achieve' => false,
            ],
            3 => [
                'id'      => 3,
                'title'   => 'Item 3',
                'height'  => 3,
                'achieve' => false,
            ],
        ];
    }

    private function getItem($id)
    {
        $data = $this->getList();

        return isset($data[ $id ])
            ? $data[ $id ]
            : [];
    }
}
