<?php

namespace SoosyzeExtension\TodoModule\Controller;

use Psr\Http\Message\ServerRequestInterface;

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = dirname(__DIR__) . '/Config/routes.php';
    }

    public function index(ServerRequestInterface $req)
    {
        return 'Affichage de la liste';
    }

    public function admin(ServerRequestInterface $req)
    {
        return 'Affichage de la liste pour l\’admin';
    }

    public function create(ServerRequestInterface $req)
    {
        return 'Formulaire d\’ajout d\’item';
    }

    public function store(ServerRequestInterface $req)
    {
        return 'Validation d\’ajout d\’item';
    }

    public function edit($id, ServerRequestInterface $req)
    {
        return "Formulaire de l’édition de l’item N°$id";
    }

    public function update($id, ServerRequestInterface $req)
    {
        return "Validation de l’édition de l’item N°$id";
    }

    public function delete($id, ServerRequestInterface $req)
    {
        return "Validation de la suppression de l’item N°$id";
    }
}
