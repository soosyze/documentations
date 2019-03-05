<?php

// modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

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
        return 'Formulaire d’ajout d’item';
    }

    public function store($req)
    {
        return 'Validation d’ajout d’item';
    }

    public function edit($id, $req)
    {
        return "Formulaire d’édition de l’item N°$id";
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
}
