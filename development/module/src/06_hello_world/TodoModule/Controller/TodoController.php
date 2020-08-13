<?php

namespace SoosyzeExtension\TodoModule\Controller;

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = dirname(__DIR__) . '/Config/routes.php';
    }

    public function index()
    {
        return 'Hello World !';
    }
}
