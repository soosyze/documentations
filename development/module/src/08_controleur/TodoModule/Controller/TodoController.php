<?php

// modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

use Soosyze\Components\Http\Redirect;
use Soosyze\Components\Http\Response;
use Soosyze\Components\Http\Stream;

define('CONFIG_TODO', MODULES_CONTRIBUED . 'TodoModule' . DS . 'config' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = CONFIG_TODO . 'routing.json';
    }

    public function index($req)
    {
        return new Response(200, new Stream('Affichage de la liste.'));
    }

    public function admin($req)
    {
        return 'Affichage de la liste pour l’admin';
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
}
