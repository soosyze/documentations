<?php

// modules/TodoModule/Controller/TodoController.php

namespace TodoModule\Controller;

define('CONFIG_TODO', MODULES_CONTRIBUED . 'TodoModule' . DS . 'Config' . DS);

class TodoController extends \Soosyze\Controller
{
    public function __construct()
    {
        $this->pathRoutes = CONFIG_TODO . 'routing.json';
    }

    public function index()
    {
        return 'Hello World !';
    }
}
